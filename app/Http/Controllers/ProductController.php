<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;

use App\Models\Category;
use App\Models\CategoryTag;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\Language;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\ProductDescription;
use App\Models\ProductPricing;
use App\Models\Country;
use App\Models\City;
use App\Models\Currency;
use App\Models\Customer;

use DB;

class ProductController extends Controller
{
    public function index(Request $request) {
        $pageConfigs = ['isContentSidebar' => true, 'bodyCustomClass' => 'file-manager-application'];

        if($request->ajax()) {
            $search_string = $request->search_string;
            $search_flag = $request->search_flag;
            $search_items = $request->search_items;

            $firstGallery = DB::table('product_gallery')
                    ->select(DB::raw('product_id', 'MAX(id) as max_gallery'))
                    ->groupBy(['product_gallery.product_id']);

            $product = DB::table('product')
                    ->select('product.*', 'category.title as category_title', 'country.title as country_title', 'city.title as city_title')
                    ->joinSub($firstGallery, 'first_gallery', function ($join) {
                        $join->on('product.id', '=', 'first_gallery.product_id');
                    })
                    ->join('category', 'product.category', '=', 'category.id')
                    ->join('country', 'product.country', '=', 'country.id')
                    ->join('city', 'product.city', '=', 'city.id')
                    ->orderBy('product.id');

            if($search_flag == 'my') {
                $my_category_id = Account::where('user_id', auth()->user()->id)->first()->id;
                $product->where('product.supplier', $my_category_id);
            }

            if($search_string != '') {
                $product->where('product.title', 'like', '%'.$search_string.'%' );
            }

            if(!empty($search_items) && count($search_items) != 0) {
                $product = $product->where(function($query) use ($search_items){
                    for($i=0; $i<count($search_items); $i++) {
                        $category_id = explode('-', $search_items[$i]);

                        $query = $query->orWhere(function($sub_query) use ($category_id){
                            $main_category = $category_id[0];
                            $sub_category = $category_id[1];

                            $sub_query->where('category.parent_id', $main_category);

                            if($sub_category == '0') {
                                $sub_query->where('product.category', $sub_category);
                            }
                        });
                    }
                });
            }

            $product = $product->paginate(18);

            $data = array(
                'product_gallery_model' => new ProductGallery,
                'product' => $product,
                'flag' => 'ajax'
            );

            return view('pages.product_search', $data)->render();
        }

        $product = Product::paginate(18);
        $allcount = Product::all()->count();

        $account = Account::where('user_id', auth()->user()->id)->first();
        $mycount = Product::where('supplier', $account->id)->get()->count();

        $main_category = ['Accommodation', 'Transport', 'Activites and Attraction', 'Guide', 'Other'];
        $tree_data = array();
        for($i=0; $i<count($main_category); $i++) {
            $temp_data = array(
                'text' => $main_category[$i],
                'checkID' => ($i+1).'-0',
                'href' => '#',
                'tags' => 0
            );

            $sub_category = Category::where('parent_id', ($i+1))->get();
            if(!empty($sub_category)) {
                $count = $sub_category->count();
                $temp_data['tags'] = $count;

                $node_data = array();
                for($j=0; $j<count($sub_category); $j++) {
                    $tmp = array(
                        'text' => $sub_category[$j]->title,
                        'checkID' => ($i+1).'-'.($j+1),
                        'href' => '#',
                        'tags' => 0
                    );

                    array_push($node_data, $tmp);
                }
                $temp_data['nodes'] = $node_data;
            }

            array_push($tree_data, $temp_data);
        }


        $tree_data = json_encode($tree_data);

        return view('pages.product',array(
            'pageConfigs' => $pageConfigs,
            'product' => $product,
            'allcount' => $allcount,
            'mycount' => $mycount,
            'tree_data' => $tree_data,
            'flag' => 'no'
        ));
    }

    public function product_detail(Request $request) {
        $product_id = $request->product_id;
        $product = Product::find($product_id);

        $product_gallery = ProductGallery::where('product_id', $product_id)->get();
        $product_description = ProductDescription::where('product_id', $product_id)->get();

        $pricing_group_data = DB::table('product_pricing')
          ->select(DB::raw('count(*) as group_count, duration'))
          ->where('product_id', $product_id)
          ->groupBy('duration')
          ->get();

        $pricing_data = array();

        for($i=0; $i<count($pricing_group_data); $i++) {
          $pricing_group = ProductPricing::where('duration', $pricing_group_data[$i]->duration)->get();
          $temp  = array(
            'duration' => $pricing_group_data[$i]->duration,
            'currency' => $pricing_group[0]->currency,
            'pricing_data' => array()
          );

          for($j=0; $j<count($pricing_group); $j++) {
            $tt = array(
              'id' => $pricing_group[$j]->id,
              'tag' => $pricing_group[$j]->tag,
              'price' => $pricing_group[$j]->price
            );
            array_push($temp['pricing_data'], $tt);
          }
          array_push($pricing_data, $temp);
        }

        $data = array(
            'product' => $product,
            'product_gallery' => $product_gallery,
            'product_description' => $product_description,
            'product_pricing' => $pricing_data,
            'pricing_model' => new ProductPricing
        );

        return view('pages.product_preview', $data)->render();
    }

    public function product_add(Request $request) {
        $flag = $request->flag;
        $pageConfigs = ['isContentSidebar' => true, 'bodyCustomClass' => 'file-manager-application'];

        $supplier = Account::where('account_type', 3)->get();
        $language = Language::all();
        $country = Country::all();
        $currency = Currency::all();
        $customer = Customer::all();

        $city = array();


        if($flag == 'accommodation') {
            $flag = 1;
            $category = Category::where('parent_id', 1)->get();
            $category_tag = CategoryTag::where('parent_id', 1)->get();
        }
        else if($flag == 'transport') {
            $flag = 2;
            $category = Category::where('parent_id', 2)->get();
            $category_tag = CategoryTag::where('parent_id', 2)->get();
        }
        else if($flag == 'activities') {
            $flag = 3;
            $category = Category::where('parent_id', 3)->get();
            $category_tag = CategoryTag::where('parent_id', 3)->get();
        }
        else if($flag == 'guide') {
            $flag = 4;
            $category = Category::where('parent_id', 4)->get();
            $category_tag = CategoryTag::where('parent_id', 4)->get();
        }
        else if($flag == 'other') {
            $flag = 5;
            $category = Category::where('parent_id', 5)->get();
            $category_tag = CategoryTag::where('parent_id', 5)->get();
        }

        return view('pages.product_add', array(
            'pageConfigs' => $pageConfigs,
            'category' => $category,
            'category_tag' => $category_tag,
            'supplier' => $supplier,
            'language' => $language,
            'country' => $country,
            'city' => $city,
            'flag' => $flag,
            'currency' => $currency,
            'customer' => $customer
        ));
    }

    public function product_edit(Request $request) {
        $pageConfigs = ['isContentSidebar' => true, 'bodyCustomClass' => 'file-manager-application'];

        $product_id = $request->product_id;

        $product = Product::find($product_id);
        $category_id = $product->category;
        $flag = Category::find($category_id)->parent_id;

        $category = Category::where('parent_id', $flag)->get();
        $category_tag = CategoryTag::where('parent_id', $flag)->get();

        $supplier = Account::where('account_type', 3)->get();
        $language = Language::all();
        $country = Country::all();
        $currency = Currency::all();
        $customer = Customer::all();

        $country_id = $product->country;
        $region_id = Country::find($country_id)->region_id;
        $city = City::where('region_id', $region_id)->where('country_id', $country_id)->get();

        $pricing_group_data = DB::table('product_pricing')
                  ->select(DB::raw('count(*) as group_count, duration'))
                  ->where('product_id', $product_id)
                  ->groupBy('duration')
                  ->get();

        $pricing_data = array();

        for($i=0; $i<count($pricing_group_data); $i++) {
            $pricing_group = ProductPricing::where('duration', $pricing_group_data[$i]->duration)->get();
            $temp  = array(
              'duration' => $pricing_group_data[$i]->duration,
              'currency' => $pricing_group[0]->currency,
              'blackout' => $pricing_group[0]->blackout,
              'blackout_msg' => $pricing_group[0]->blackout_msg,
              'pricing_data' => array()
            );

            for($j=0; $j<count($pricing_group); $j++) {
              $tt = array(
                'id' => $pricing_group[$j]->id,
                'tag' => $pricing_group[$j]->tag,
                'description' => $pricing_group[$j]->description,
                'price' => $pricing_group[$j]->price
              );
              array_push($temp['pricing_data'], $tt);
            }
            array_push($pricing_data, $temp);
        }

        return view('pages.product_edit', array(
            'pageConfigs' => $pageConfigs,
            'category' => $category,
            'category_tag' => $category_tag,
            'supplier' => $supplier,
            'language' => $language,
            'country' => $country,
            'city' => $city,
            'flag' => $flag,
            'product' => $product,
            'currency' => $currency,
            'customer' => $customer,
            'pricing_data' => $pricing_data
        ));
    }

    public function product_delete(Request $request) {
        $product_id = $request->product_id;

        Product::find($product_id)->delete();
        $request->session()->flash('alert', 'Deleted Successfully');
        return redirect()->route('product');
    }

    public function get_city(Request $request) {
        $country = $request->country;
        $city = City::where('country_id', $country)->get();
        echo json_encode($city);
    }

    public function get_tag(Request $request) {
        $category = $request->category;
        $city = CategoryTag::where('parent_id', $category)->get();
        echo json_encode($city);
    }

    public function product_save(Request $request) {

        $rule = [
            'title' => 'required',
            'category' => 'required',
            'supplier' => 'required',
            'country' => 'required',
            'city' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required'
        ];

        $customMessages = [
            'title.required' => 'Title filed is required',
            'category.required' => 'Category filed is required',
            'supplier.required' => 'Supplier filed is required',
            'country.required' => 'Country filed is required',
            'city.required' => 'City filed is required',
            'start_time.required' => 'Start Time filed is required',
            'end_time.required' => 'End Time filed is required',
            'location.required' => 'Location filed is required'
        ];

        $this->validate($request, $rule, $customMessages);

        try {

            $product = Product::updateOrCreate(
                ['id' => $request->product_id],
                [
                    'title' => $request->title,
                    'category' => $request->category,
                    'country' => $request->country,
                    'city' => $request->city,
                    'location' => $request->location,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'supplier' => $request->supplier
                ]
            );

            $request->session()->flash('alert', 'Saved Successfully');
            return redirect()->route('product_edit', ['product_id' => $product->id]);

        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

    public function product_description(Request $request) {
        $product_id = $request->description_product_id;

        $rule = [
            'group."*".language' => 'required',
            'group."*".description' => 'required'
        ];

        $customMessages = [
            'group."*".language.required' => 'Language field is required',
            'group."*".description.required' => 'Description field is required',
        ];

        $this->validate($request, $rule, $customMessages);

        ProductDescription::where('product_id', $product_id)->delete();

        $description_data = $request->group;

        $flag = 0;

        foreach($description_data as $description){

            ProductDescription::create(
            [
                'id' => $description["'descriptionID'"],
                'product_id' => $product_id,
                'language' => $description["'language'"],
                'description' => $description["'description'"]
            ]);
            $flag = 1;
        }

        if($flag == 1) {
            $request->session()->flash('alert', 'Saved Successfully');
            return redirect()->route('product_edit', ['product_id' => $product_id]);
        }
        else {
            return redirect()->back();
        }
    }

    public function upload_gallery(Request $request) {
        $file = $request->file('file');
        $user = auth()->user();

        if ($file) {

            $last_gallery = ProductGallery::where('product_id', $request->gallery_product_id)
                ->where('created_at', '<', date('Y-m-d hh:ii:ss'))
                ->get();

            for($i=0; $i<count($last_gallery); $i++) {
                unlink(public_path($last_gallery[$i]->path));
            }
            ProductGallery::where('product_id', $request->gallery_product_id)->where('created_at', '<', date('Y-m-d hh:ii:ss'))->delete();

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $upload_filename = time() . '.' . $extension;

            //$upload_filename = str_replace(' ', '', $upload_filename);
            $destinationPath = public_path('assets/gallery');

            $upload_success = $file->move($destinationPath, $upload_filename);

            if ($upload_success) {

                $upload = ProductGallery::create([
                    'product_id' => $request->gallery_product_id,
                    'path' => 'assets/gallery/' . $upload_filename,
                    'extension' => pathinfo($filename, PATHINFO_EXTENSION),
                ]);

                return response()->json([
                    "status" => "success",
                    "upload_id" => $upload->id,
                    'url' => asset('assets/gallery/' . $upload_filename),
                    "name" => $filename,
                ], 200);
            } else {
                return response()->json([
                    "status" => "error"
                ], 400);
            }
        } else {
            return response()->json('error: upload file not found.', 400);
        }
    }

    public function delete_gallery(Request $request) {
        $file_name = $request->file_name;

        $path = 'assets/gallery/'.$file_name;
        if (File::exists($path)) {
            unlink(public_path($path));
        }
        ProductGallery::where('path',$path)->first()->delete();
        echo 'success';
    }

    public function product_pricing(Request $request) {

        $product_id = $request->price_product_id;

        $rule = [
            'fromdate.*' => 'required',
            'todate.*' => 'required',
            'currency.*' => 'required',
            'blackoutdate.*.*' => 'required',
            'blackoutmsg.*.*' => 'required',
            'tag.*.*' => 'required',
            'price.*.*' => 'required',
        ];

        $customMessages = [
            'fromdate.*.required' => 'From Date field is required',
            'todate.*.required' => 'To Date field is required',
            'currency.*.required' => 'Currency field is required',
            'blackoutdate.*.*.required' => 'Blackout Date field is required',
            'blackoutmsg.*.*.required' => 'Blackout Note field is required',
            'tag.*.*.required' => 'Type field is required',
            'price.*.*.required' => 'Price field is required',
        ];

        $this->validate($request, $rule, $customMessages);

        ProductPricing::where('product_id', $product_id)->delete();

        $flag = 0;

        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $currency = $request->currency;

        $blackoutdate = $request->blackoutdate;
        $blackoutmsg = $request->blackoutmsg;

        $tag = $request->tag;
        $price = $request->price;
        $description = $request->description;

        $kk=0;
        $tag_temp = array();
        $price_temp = array();
        $description_temp = array();

        for($k=count($tag)-1; $k>=0; $k--) {
          $tag_temp[$kk] = $tag[$k];
          $price_temp[$kk] = $price[$k];
          $description_temp[$kk] = $description[$k];
          $kk++;
        }

        $kk=0;
        $blackoutdate_arr = array();
        $blackoutmsg_arr = array();
        for($k=count($blackoutdate)-1; $k>=0; $k--) {
          $blackoutdate_arr[$kk] = $blackoutdate[$k];
          $blackoutmsg_arr[$kk] = $blackoutmsg[$k];

          $kk++;
        }

        $blackout_d = array();
        $blackout_m = array();

        for($i=0; $i<count($fromdate); $i++) {
          $blackoutdate_temp = "";
          $blackoutmsg_temp = "";

          for($j=0; $j < count($blackoutdate_arr[$i]); $j++) {
            if($j == 0) {
              $blackoutdate_temp .= $blackoutdate_arr[$i][$j];
              $blackoutmsg_temp .= $blackoutmsg_arr[$i][$j];
            }
            else {
              $blackoutdate_temp .= ', ';
              $blackoutdate_temp .= $blackoutdate_arr[$i][$j];

              $blackoutmsg_temp .= ', ';
              $blackoutmsg_temp .= $blackoutmsg_arr[$i][$j];
            }
          }
          array_push($blackout_d, $blackoutdate_temp);
          array_push($blackout_m, $blackoutmsg_temp);
        }

      //dd($tag_temp);

        for($i=0; $i<count($fromdate); $i++) {
            for($j=0; $j<count($tag_temp[$i]); $j++) {
              $product_pricing = ProductPricing::create(
                [
                  'product_id' => $product_id,
                  'tag' => $tag_temp[$i][$j],
                  'description' => $description_temp[$i][$j],
                  'price' => $price_temp[$i][$j],
                  'currency' => $currency[$i],
                  'duration' => $fromdate[$i].' ~ '.$todate[$i],
                  'blackout' => $blackout_d[$i],
                  'blackout_msg' => $blackout_m[$i]
                ]
              );
              $flag = 1;
            }
        }

        if($flag == 1) {
            $request->session()->flash('alert', 'Saved Successfully');
            return redirect()->route('product_edit', ['product_id' => $product_id]);
        }
        else {
            return redirect()->back();
        }
    }
}
