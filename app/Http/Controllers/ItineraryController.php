<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\Enquiry;
use App\Models\Itinerary;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\ProductDescription;
use App\Models\ProductPricing;
use App\Models\Currency;
use App\Models\CategoryTag;
use App\Models\Category;
use App\Models\Region;
use App\Models\Country;
use App\Models\City;
use App\Models\Language;
use App\Models\ItineraryDaily;
use App\Models\ItineraryTemplate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use DB;
use Mail;
use PDF;

class ItineraryController extends Controller
{
  public function add_basic($enquiry_id){
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["name" => "Itinerary Basic Create"]
      ];
      $enquiry = Enquiry::where('id',$enquiry_id)->get()->first();
      return view('pages.itinerary_add_basic',compact('enquiry','pageConfigs', 'breadcrumbs'));
  }

  public function edit_itinerary(Request $request) {
    $pageConfigs = ['pageHeader' => true];
    $breadcrumbs = [
      ["link" => "/", "name" => "Home"],["name" => "Itinerary Basic Create"]
    ];

    $itinerary_id = $request->itinerary_id;
    $itinerary = Itinerary::find($itinerary_id);
    $enquiry_id = $itinerary->enquiry_id;
    $enquiry = Enquiry::where('id',$enquiry_id)->get()->first();
    return view('pages.itinerary_edit_basic',compact('enquiry', 'itinerary', 'pageConfigs', 'breadcrumbs'));
  }

  public function delete_itinerary(Request $request) {
    $itinerary_id = $request->itinerary_id;

    if(Itinerary::find($itinerary_id)) {
      Itinerary::find($itinerary_id)->delete();
      ItineraryDaily::where('itinerary_id', $itinerary_id)->delete();
      $request->session()->flash('alert', 'Deleted Successfully');
      echo 'success';
    }
  }

  public function create_basic(Request $request){

    $itinerary_id = $request->itinerary_id;
    
    if(empty($itinerary_id)) {
      $enquiry = Enquiry::where('id', $request->enquiry_id)->get()->first();

      $itinerary = new Itinerary;
      $itinerary->title = $request->title;

      $str = "I";
      for($i = 1; $i < strlen($enquiry->reference_number); $i ++)
      {
        $str[$i] = $enquiry->reference_number[$i];
      }
      $itinerary->reference_number = $str;
      
      $itinerary->enquiry_id = $enquiry->id;
      $itinerary->from_email = "";
      $itinerary->to_email = "";
      $itinerary->attach_file = "";
      $itinerary->email_template = "";

      $itinerary->budget = "";
      $itinerary->margin_price = 0;
      $itinerary->currency = "";

      $duration = $request->duration;
      $duration = explode(' - ', $duration);
      $start_date = date_create($duration[0]);
      $end_date = date_create($duration[1]);

      $itinerary->from_date = $start_date;
      $itinerary->to_date = $end_date;

      $itinerary->adult_number = $request->adults_num;
      $itinerary->children_number = $request->children_num;
      $itinerary->single_count = $request->single_room;
      $itinerary->double_count = $request->double_room;
      $itinerary->twin_count = $request->twin_room;
      $itinerary->triple_count = $request->triple_room;
      $itinerary->family_count = $request->family_room;
      $itinerary->note = $request->note;
      $itinerary->status = 0;
      $itinerary->account_id = $enquiry->account_id;
      $itinerary->created_id = Auth::user()->id;
      
      $itinerary->save();
      $str = 'itinerary_add_daily/'.$itinerary->id;
      return redirect()->to($str);
    }
    else {
      $duration = $request->duration;
      $duration = explode(' - ', $duration);
      
      $start_date = date_create($duration[0]);
      $end_date = date_create($duration[1]);
      
      $update_data = array(
        'title' => $request->title,
        'updated_id' => Auth::user()->id,
        'from_date' => $start_date,
        'to_date' => $end_date,
        'adult_number' => $request->adults_num,
        'children_number' => $request->children_num,
        'single_count' => $request->single_room,
        'double_count' => $request->double_room,
        'twin_count' => $request->twin_room,
        'triple_count' => $request->triple_room,
        'family_count' => $request->family_room,
        'note' => $request->note
      );

      Itinerary::where('id', $itinerary_id)->update($update_data);
      $str = 'itinerary_add_daily/'.$itinerary_id;
      return redirect()->to($str);
    }
  }

  public function add_daily(Request $request){
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
      ["link" => "/", "name" => "Home"],["name" => "Itinerary Daily Create"]
      ];

      // $product = Product::paginate(7);
      $product = Product::all();
      $product_gallery = ProductGallery::all();
      $product_description = ProductDescription::all();
      $product_pricing = ProductPricing::all();
      $currency = Currency::all();
      $categoryTag = CategoryTag::all();
      $category = Category::all();
      $language = Language::all();
      $itinerary = Itinerary::where('id', $request->itinerary_id)->first();
      $from_date = strtotime($itinerary->from_date);
      $to_date = strtotime($itinerary->to_date);

      $schedule_date = DB::table('itinerary_daily')
          ->select('date')
          ->where('itinerary_id', $request->itinerary_id)
          ->groupBy('date')
          ->get();

      $latestPosts = DB::table('product_gallery')
        ->select('product_id')
        ->groupByRaw('product_id');
      
      $itinerary_daily = DB::table('product')
        ->select('product.id', 'product.title as product_title', 'itinerary_daily.product_price_id', 'itinerary_daily.itinerary_margin_price', 'itinerary_daily.date', 'itinerary_daily.start_time', 'itinerary_daily.end_time', 'itinerary_daily.adults_num', 'itinerary_daily.children_num', 'country.title as country_title', 'city.title as city_title')
        ->join('itinerary_daily', 'product.id', '=', 'itinerary_daily.product_id')
        ->join('city', 'product.city', '=', 'city.id')
        ->join('country', 'product.country', '=', 'country.id')
        ->joinSub($latestPosts, 'latest_posts', function ($join) {
          $join->on('product.id', '=', 'latest_posts.product_id');
        })
        ->where('itinerary_daily.itinerary_id', $request->itinerary_id)
        ->get();

      $itinerary_schedule_data = array();
      
      for($i = 0; $i<count($schedule_date); $i++) {
        $temp = array();
        for($j=0; $j<count($itinerary_daily); $j++) {
          if($schedule_date[$i]->date == $itinerary_daily[$j]->date) {
            $path = ProductGallery::where('product_id', $itinerary_daily[$j]->id)->orderByDesc('created_at')->first();
            $path = $path->path;
            $itinerary_daily[$j]->path = $path;

            $schedule_record = $itinerary_daily[$j];
            array_push($temp, $schedule_record);
          }
        }

        $itinerary_schedule_data[$schedule_date[$i]->date] = $temp;
      }

      $itinerary_template = DB::table('itinerary_template')
          ->select('title', 'group_id', 'created_by')
          ->where('created_by', Auth::user()->id)
          ->get()
          ->groupBy('group_id');

      
      $template_itinerary_data = array();

      foreach($itinerary_template as $key=>$val) {

        $created_by = $val[$key]->created_by;
        $path = Account::where('user_id', $created_by)->first()->avatar_path;

        $day_count = DB::table('itinerary_template')
          ->select(DB::raw('count(*) as day_count'))
          ->where('group_id', $key)
          ->groupBy('date_num')
          ->get();
        
        $temp = array(
          'title' => $val[$key]->title,
          'group_id' => $val[$key]->group_id,
          'path' => $path,
          'day_count' => count($day_count)
        );

        array_push($template_itinerary_data, $temp);
      }

      $itinerary_id = $request->itinerary_id;

      $days = $to_date - $from_date;
      $days = intval(round($days / (60 * 60 * 24)));
      $days ++;
      $from_date = date('Y-m-d', $from_date);
      $to_date = date("Y-m-d", $to_date);
      $enquiry = $itinerary->get_enquiry;
          
      return view('pages.itinerary_add_daily',compact('itinerary', 'itinerary_id', 'template_itinerary_data', 'enquiry', 'product', 'language', 'product_gallery', 'product_description', 'product_pricing' ,'pageConfigs', 'breadcrumbs', 'from_date', 'to_date', 'days', 'itinerary_schedule_data', 'currency', 'categoryTag', 'category'));
  }

  public function product_search(Request $request) {
    $search_string = $request->search_string;
    $images = array();
    $country = array();
    $city = array();
    $product = Product::where('title', 'LIKE', '%'.$search_string.'%')->get();
    for($i = 0; $i < count($product); $i ++){
      $images[] = $product[$i]->getFirstImage;
      $country[] = $product[$i]->getCountry;
      $city[] = $product[$i]->getCity;
    }
    return response()->json(['product'=>$product, 'images'=>$images, 'country'=>$country, 'city'=>$city]);
  }

  public function template_search(Request $request) {
      $search_string = $request->search_string;
      
      $template = DB::table('itinerary_template')
        ->select('title', 'group_id', 'created_by')
        ->where('title', 'LIKE', '%'.$search_string.'%')
        ->where('created_by', Auth::user()->id)
        ->get()
        ->groupBy('group_id');

      $template_itinerary = array();

      foreach($template as $key=>$val) {

        $created_by = $val[$key]->created_by;
        $path = Account::where('user_id', $created_by)->first()->avatar_path;

        $day_count = DB::table('itinerary_template')
          ->select(DB::raw('count(*) as day_count'))
          ->where('group_id', $key)
          ->groupBy('date_num')
          ->get();
        
        $temp = array(
          'title' => $val[$key]->title,
          'group_id' => $val[$key]->group_id,
          'path' => $path,
          'day_count' => count($day_count)
        );

        array_push($template_itinerary, $temp);
      }

      return response()->json(['template_itinerary'=>$template_itinerary]);
  }

  public function filter(Request $request) {
    $product = array();
    $images = array();
    $country = array();
    $city = array();

    if($request->flg_accommodation == "true"){
      $sub_category = Category::where('parent_id', '1')->get();
      for($i = 0; $i < count($sub_category); $i ++){
        $temp = Product::where('category', $sub_category[$i]->id)->get();
        for($j = 0;$j < count($temp); $j ++){
          array_push($product, $temp[$j]);
        }
      }
    }
    if($request->flg_transport == "true"){
      $sub_category = Category::where('parent_id', '2')->get();
      for($i = 0; $i < count($sub_category); $i ++){
        $temp = Product::where('category', $sub_category[$i]->id)->get();
        for($j = 0;$j < count($temp); $j ++){
          array_push($product, $temp[$j]);
        }
      }
    }
    if($request->flg_activity_attraction == "true"){
      $sub_category = Category::where('parent_id', '3')->get();
      for($i = 0; $i < count($sub_category); $i ++){
        $temp = Product::where('category', $sub_category[$i]->id)->get();
        for($j = 0;$j < count($temp); $j ++){
          array_push($product, $temp[$j]);
        }
      }
    }
    if($request->flg_guide == "true"){
      $sub_category = Category::where('parent_id', '4')->get();
      for($i = 0; $i < count($sub_category); $i ++){
        $temp = Product::where('category', $sub_category[$i]->id)->get();
        for($j = 0;$j < count($temp); $j ++){
          array_push($product, $temp[$j]);
        }
      }
    }
    if($request->flg_other == "true"){
      $sub_category = Category::where('parent_id', '5')->get();
      for($i = 0; $i < count($sub_category); $i ++){
        $temp = Product::where('category', $sub_category[$i]->id)->get();
        for($j = 0;$j < count($temp); $j ++){
          array_push($product, $temp[$j]);
        }
      }
    }

    if($request->flg_accommodation == "false" && $request->flg_transport == "false" && $request->flg_activity_attraction == "false" && $request->flg_guide == "false" && $request->flg_other == "false"){
      $product = Product::all();
    }
    for($i = 0; $i < count($product); $i ++){
      $images[] = $product[$i]->getFirstImage;
      $country[] = $product[$i]->getCountry;
      $city[] = $product[$i]->getCity;
    }
    return response()->json(['product'=>$product, 'images'=>$images, 'country'=>$country, 'city'=>$city]);
  }

  public function saveDailyItinerary(Request $request){

    $itinerary_id = $request->itinerary_id;
    if(ItineraryDaily::where('itinerary_id', $itinerary_id)->get()) {
      ItineraryDaily::where('itinerary_id', $itinerary_id)->delete();
    }

    $data = $request->daily_itinerary;
    
    $budget = array();
    if(!empty($data)) {
      for($i = 0; $i < count($data); $i ++){
        for($j = 0; $j < count($data[$i]); $j ++){
          $itinerary_daily = new ItineraryDaily;
          $itinerary_daily->itinerary_id = intval($data[$i][$j]['itinerary_id']);
          $itinerary_daily->start_time = $data[$i][$j]['start_time'];
          $itinerary_daily->end_time = $data[$i][$j]['end_time'];
          $itinerary_daily->product_id = intval($data[$i][$j]['product_id']);
          $itinerary_daily->product_price_id = $data[$i][$j]['product_price_id'];
          $itinerary_daily->itinerary_margin_price = $data[$i][$j]['itinerary_margin_price'];
          $itinerary_daily->date = $data[$i][$j]['mydate'];
          $itinerary_daily->adults_num = intval($data[$i][$j]['adults_num']);
          $itinerary_daily->children_num = intval($data[$i][$j]['children_num']);
          $itinerary_daily->save();
          
          $price_id_arr = explode(':', $data[$i][$j]['product_price_id']);
                
          for($k=0; $k<count($price_id_arr); $k++) {
            $price_data = ProductPricing::find($price_id_arr[$k]);
            $price_currency = $price_data->currency;
            $price_currency = Currency::find($price_currency)->title;
            $price_value = $price_data->price + $price_data->price * $data[$i][$j]['itinerary_margin_price'] / 100;

            $price_value = number_format($price_value, '2', '.', '');

            if(isset($budget[$price_currency]) && !empty($budget[$price_currency])) {
              $temp_price = $budget[$price_currency] + $price_value;
              $budget[$price_currency] = $temp_price;
            }
            else {
              $budget[$price_currency] = $price_value;
            }
          }
        }
      }
    }

    $insert_string = '';

    $index = 0;
    foreach($budget as $key => $value) {
      
      if($index == 0) {
        $insert_string .= $key.'-'.$value;
      }
      else {
        $insert_string .= ', ';
        $insert_string .= $key.'-'.$value;
      }
      $index++;
    }

    $update_data = array(
      'budget' => $insert_string
    );

    Itinerary::where('id', $itinerary_id)->update($update_data);
    
    return response()->json(array(
      'result'=>"success",
      'itinerary_id' => $itinerary_id
    ));
  }

  public function saveTemplateItinerary(Request $request) {

    $template_id = $request->template_id;
    $template_title = $request->template_title;
    if(ItineraryTemplate::where('group_id', $template_id)->get()) {
      ItineraryTemplate::where('group_id', $template_id)->delete();
    }

    $group_id = 0;
    if(ItineraryTemplate::get()->count() != 0) {
      $last_template_data = ItineraryTemplate::orderByDesc('group_id')->get();
      $group_id = $last_template_data[0]->group_id;
    }

    $group_id ++;

    $data = $request->template_itinerary;
    if(!empty($data)) {
      for($i = 0; $i < count($data); $i ++){
        for($j = 0; $j < count($data[$i]); $j ++){
          $itinerary_template = new ItineraryTemplate;
          $itinerary_template->group_id = $group_id;
          $itinerary_template->title = $template_title;
          $itinerary_template->product_id = intval($data[$i][$j]['product_id']);
          $itinerary_template->product_price_id = intval($data[$i][$j]['product_price_id']);
          $itinerary_template->date_num = ($i+1);
          $itinerary_template->start_time = $data[$i][$j]['start_time'];
          $itinerary_template->end_time = $data[$i][$j]['end_time'];
          $itinerary_template->adults_num = intval($data[$i][$j]['adults_num']);
          $itinerary_template->children_num = intval($data[$i][$j]['children_num']);
          $itinerary_template->created_by = Auth::user()->id;
          $itinerary_template->save();
        }
      }
    }

    return response()->json(['result'=>"success"]);
  }

  public function get_product_pricing_tag(Request $request) {
    $product_id = $request->product;
    $product_id = $product_id['id'];

    $product_category = Product::find($product_id)->category;
    $product_kind = Category::find($product_category)->parent_id;
    $product_tag = CategoryTag::where('parent_id', $product_kind)->get();
    echo json_encode($product_tag);
  }

  public function get_product_pricing_and_tag(Request $request) {
    $product_id = $request->product_id;
    $product_price_id = $request->product_price_id;

    $product_data = DB::table('product')
      ->select('product.*', 'country.title as country_title', 'city.title as city_title')
      ->join('country', 'country.id', '=', 'product.country')
      ->join('city', 'city.id', '=', 'product.city')
      ->where('product.id', $product_id)
      ->get();
    
    $product_data = $product_data[0];

    $path = ProductGallery::where('product_id', $product_id)->orderByDesc('created_at')->first();
    $product_data->path = $path->path;

    $product_category = Product::find($product_id)->category;
    $product_kind = Category::find($product_category)->parent_id;
    $product_tag = CategoryTag::where('parent_id', $product_kind)->get();

    $product_price_arr = explode(':', $product_price_id);
    $product_price_data = array();
    for($i=0; $i<count($product_price_arr); $i++) {
      $temp = DB::table('product_pricing')
        ->select('product_pricing.*', 'currency.title as currency_title')
        ->where('product_pricing.id', $product_price_arr[$i])
        ->join('currency', 'currency.id', '=', 'product_pricing.currency')
        ->get();
      $temp = $temp[0];
      array_push($product_price_data, $temp);
    }

    $result = array(
      'product_data' => $product_data,
      'product_tag' => $product_tag,
      'product_price_data' => $product_price_data
    );

    echo json_encode($result);
  }

  public function check_itinerary_product_season(Request $request) {

    $product_id = $request->product_id;
    $category_tag = $request->category_tag;
    $from_date = $request->from_date;
    $from_date = strtotime($from_date);

    $to_date = $request->to_date;
    $to_date = strtotime($to_date);

    $pick_date = $request->pick_date;
    $pick_date = strtotime($pick_date);

    $blackout_flag = 0;
    $blackout_message = '';
    $blackout_validation = ProductPricing::where('product_id', $product_id)->where('tag', $category_tag)->get();

    if(!empty($blackout_validation)) {
      for($i=0; $i<count($blackout_validation); $i++) {
        $blackout_data = $blackout_validation[$i]->blackout;
        $blackout_msg = $blackout_validation[$i]->blackout_msg;

        $blackout_data = explode(', ', $blackout_data);
        $blackout_msg = explode(', ', $blackout_msg);

        for($j=0; $j<count($blackout_data); $j++) {
          $blackout_start_date = explode(' - ', $blackout_data[$j])[0];
          $blackout_end_date = explode(' - ', $blackout_data[$j])[1];

          $blackout_start_date = strtotime($blackout_start_date);
          $blackout_end_date = strtotime($blackout_end_date);

          if($blackout_start_date <= $pick_date && $blackout_end_date >= $pick_date) {
            $blackout_flag = 1;
            $blackout_message = $blackout_msg[$j];
          }
        }
      }
    }
    else {
      $blackout_flag = 1;
      $blackout_message = "Price unset for this period and category tag. please check product again.";
    }

    if($blackout_flag == 1) {
      $result = array(
        'flag' => 'blackout',
        'blackout_msg' => $blackout_message
      );

      echo json_encode($result);
      exit(1);
    }

    $season_validation = ProductPricing::where('product_id', $product_id)->where('tag', $category_tag)->get();
    $season_flag = 0;

    for($i=0; $i<count($season_validation); $i++) {
      $duration = $season_validation[$i]->duration;
      $duration = explode(' ~ ', $duration);
      $start_date = $duration[0];
      $end_date = $duration[1];

      $start_date = strtotime($start_date);
      $end_date = strtotime($end_date);

      if($from_date >= $start_date && $end_date >= $to_date) {
        $season_flag = 1;
        $price_id = $season_validation[$i]->id;
        $price_season = $season_validation[$i]->duration;
        $price_product = $season_validation[$i]->price;
        $price_currency = $season_validation[$i]->currency;
      }
    }

    if($season_flag == 0) {
      $result = array(
        'flag' => 'season'
      );
    }
    else {
      $currency_label = Currency::find($price_currency)->title;

      $result = array(
        'flag' => 'success',
        'price_id' => $price_id,
        'price_season' => $price_season,
        'price_product' => $price_product,
        'currency_label' => $currency_label
      );
    }

    echo json_encode($result);
  }

  public function complete_itinerary(Request $request) {
    $itinerary_id = $request->itinerary_id;
    $itinerary_status = Itinerary::find($itinerary_id)->status;
    $budget_str = Itinerary::find($itinerary_id)->budget;
    $budget_arr = explode(', ', $budget_str);

    $budget = array();
    for($i=0; $i<count($budget_arr); $i++) {
      $key = explode('-', $budget_arr[$i])[0];
      $val = explode('-', $budget_arr[$i])[1];
      $budget[$key] = $val;
    }

    $currency = Currency::all();

    $pageConfigs = ['pageHeader' => true];
    $breadcrumbs = [
      ["link" => "/", "name" => "Home"],["name" => "Complete Itinerary"]
    ];
    return view('pages.itinerary_complete',compact('budget','itinerary_id', 'itinerary_status', 'currency', 'pageConfigs', 'breadcrumbs'));

  }

  public function currency_converter(Request $request) {
    $converter_currency = $request->currency;
    $budget = $request->budget;

    $total_budget = 0;
    foreach($budget as $key => $value) {
      $from_Currency = $key;
      $to_Currency = $converter_currency;

      $api_key = 'f2bc294545304ee08435239a820dc66d';
      $url = 'https://free.currencyconverterapi.com/api/v5/convert?q=' . $from_Currency . '_' . $to_Currency . '&compact=ultra&apiKey='.$api_key;
      $handle = @fopen($url, 'r');

      if ($handle) {
        $result = fgets($handle, 4096);
        fclose($handle);
        redirect()->route('index')->with('Currency ApI Error occurs. Please check it again.');
      }

      if (isset($result)) {
          $conversion = json_decode($result, true);
          if (isset($conversion[$from_Currency . '_' . $to_Currency])) {
              $total_budget += intval($conversion[$from_Currency . '_' . $to_Currency] * $value);
          }
      }
    }

    $result = array(
      'flag' => 'success',
      'total_budget' => $total_budget
    );
    echo json_encode($result);
  }

  public function itinerary_complete_with_budget(Request $request) {
    $itinerary_id = $request->itinerary_id;
    $budget = $request->total_budget;
    $margin_price = $request->margin_price;
    $currency = $request->currency;
  
    $update_data = array(
      'budget' => $budget,
      'currency' => $currency,
      'margin_price' => $margin_price,
      'status' => 1
    );
  
    Itinerary::where('id', $itinerary_id)->update($update_data);
    $msg_result = "Itinerary Created Successfully";
    return redirect()->route('index')->with('msg', $msg_result);
  }

  public function delete_template_itinerary(Request $request) {
    $group_id = $request->group_id;

    if(ItineraryTemplate::where('group_id', $group_id)->delte()) {
      echo 'success';
    }
    else {
      echo 'failure';
    }
  }

  public function preview_template_itinerary(Request $request) {
    $group_id = $request->group_id;

    $template_itinerary = DB::table('itinerary_template')
      ->select('itinerary_template.date_num', 'itinerary_template.title as template_title', 'itinerary_template.product_id', 'itinerary_template.product_price_id', 'itinerary_template.start_time', 'itinerary_template.end_time', 'itinerary_template.adults_num', 'itinerary_template.children_num', 'product.title as product_title', 'country.title as country_title', 'city.title as city_title')
      ->join('product', 'product.id', '=', 'itinerary_template.product_id')
      ->join('country', 'product.country', '=', 'country.id')
      ->join('city', 'product.city', '=', 'city.id')
      ->where('itinerary_template.group_id', $group_id)
      ->where('itinerary_template.created_by', Auth::user()->id)
      ->get()
      ->groupBy('date_num');

    foreach($template_itinerary as $key => $value) {
      for($i=0; $i<count($value); $i++) {
        $product_id = $value[$i]->product_id;
        $product_path = ProductGallery::where('product_id', $product_id)->orderByDesc('created_at')->first()->path;
        $value[$i]->product_path = $product_path;
      }
    }

    echo json_encode($template_itinerary);
  }

  public function send_itinerary(Request $request) {
    $itinerary_id = $request->itinerary_id;

    $status = Itinerary::find($itinerary_id)->status;

    if($status == 0) {
      $msg = "Not Completed Itinerary. Please complete it first!";
      return redirect()->route('index')->with('msg', $msg);
    }
    else if($status == 2) {
      $msg = "Already Sent Itinerary!";
      return redirect()->route('index')->with('msg', $msg);
    }
    else {
      
      $pageConfigs = ['pageHeader' => true];
      $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["name" => "Itinerary Send"]
      ];

      $enquiry_id = Itinerary::find($itinerary_id)->enquiry_id;
      $customer_id = Enquiry::find($enquiry_id)->account_id;

      $account_type = Account::find($customer_id)->account_type;

      $to_email = "";
      if($account_type == 1) {
        $to_email = Account::find($customer_id)->main_email;
      }
      else if($account_type == 2) {
        $to_email = Account::find($customer_id)->billing_email;
      }

      $html = '<h2>Dear {customer_name},</h2>
      <p>Thank for your giving us the opportunity for help you with your upcoming trave arrangement; it has been a pleasure for us</p>
      <p>we have been helping travels create wonderful holiday experiences for years, and we hope you will benefit in the same way. Here wishing you a beautiful vacation ahead!</p>
      <p>we have carefully reviewed your holiday preferences, and specially chosen the below package for you. Please review the information, and let us know if you would like to make any further changes to this plan.</p>
      <p><a href="https://localhost/get/travel_showcase/'. $itinerary_id .'" style="font-family: Helvetica Neue ,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; color: #bbadfc; margin: 0; padding:5px 10px;" target="_blank">Click here to view your itinerary</a></p>
      <table style="width:100%; border:0px;">
      <tr>
      <td style="width: 50%">{address}</td>
      <td style="width: 50%">Phone Number: {phone_number}</td>
      </tr>
      <tr>
      <td style="width: 50%">{postcode}</td>
      <td style="width: 50%">E-mail: {email_address}</td>
      </tr>
      <tr>
      <td style="width: 50%">{city}</td>
      <td style="width: 50%">Website: {website_url}</td>
      </tr>
      <tr>
      <td style="width: 50%">{country}</td>
      </tr>
      </table>
      <div style="float:left; margin-top:20px; width:100%">
      <p>Cheers,</p>
      <p>{sitetitle} Team</p>
      </div>';

      return view('pages.itinerary_send', compact('pageConfigs', 'breadcrumbs', 'to_email', 'html', 'itinerary_id'));
    }
  }

  public function send_email_itinerary(Request $request) {
    
    $itinerary_id = $request->itinerary_id;
    $from_email = $request->from_email;
    $to_email = $request->to_email;
    $body = $request->email_template;

    $pdf_check = $request->pdf_check;
    $created_id = Itinerary::find($itinerary_id)->created_id;
    
    $email = Account::find($created_id)->main_email;
    $website_url = Account::find($created_id)->website_url;
    $street_address = Account::find($created_id)->main_street_address;
    $city = Account::find($created_id)->main_city;
    $city = City::find($city)->title;
    $postal_code = Account::find($created_id)->main_postal_code;
    $region = Account::find($created_id)->main_region_state;
    $region = Region::find($region)->title;
    $country = Account::find($created_id)->main_country;
    $country = Country::find($country)->title;
    $phone = Account::find($created_id)->main_office_phone;

    
    $enquiry_id = Itinerary::find($itinerary_id)->enquiry_id;
    $to_account_id = Enquiry::find($enquiry_id)->account_id;
    $account_name = Account::find($to_account_id)->first_name .' '. Account::find($to_account_id)->first_name;

    $body = str_replace('{customer_name}', $account_name, $body);
    $body = str_replace('{address}', $street_address, $body);
    $body = str_replace('{phone_number}', $phone, $body);
    $body = str_replace('{postcode}', $postal_code, $body);
    $body = str_replace('{email_address}', $email, $body);
    $body = str_replace('{city}', $city, $body);
    $body = str_replace('{country}', $country, $body);
    $body = str_replace('{website_url}', $website_url, $body);
    $body = str_replace('{sitetitle}', 'Travel Quoting', $body);

    $file_name = '';

    if(!empty($pdf_check)) {

      PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
      $pdf = PDF::loadHtml($body);
      $pdf = $pdf->stream();

      $file_name = 'itinerary_'. $itinerary_id .'_file.' . 'pdf';
      Storage::disk('public')->put($file_name, $pdf);

      $file_path = Storage::disk('public')->path($file_name);

      Mail::send('pages.itinerary_mail', $data, function($message) use ($from_email, $to_email, $file_path) {
        $message->to($to_email, 'Travel Quoting')->subject('Travel Itinerary for your trips');
        $message->attach($file_path);
        $message->from($from_email,'Virat Gandhi');
      });
    }
    else {
      Mail::send('pages.itinerary_mail', $data, function($message) use ($from_email, $to_email) {
        $message->to($to_email, 'Travel Quoting')->subject('Travel Itinerary for your trips');
        $message->from($from_email,'Virat Gandhi');
      });
    }

    $update_data = array(
      'from_email' => $from_email,
      'to_email' => $to_email,
      'attach_file' => $file_name,
      'email_template' => $body
    );

    Itinerary::find($itinerary_id)->update($update_data);
    return redirect()->back();
  }

  public function show_itinerary(Request $request) {
    $itinerary_id = $request->itinerary_id;
    $created_id = Itinerary::find($itinerary_id)->created_id;

    $email = Account::find($created_id)->main_email;
    $street_address = Account::find($created_id)->main_street_address;
    $city = Account::find($created_id)->main_city;
    $city = City::find($city)->title;
    $postal_code = Account::find($created_id)->main_postal_code;
    $region = Account::find($created_id)->main_region_state;
    $region = Region::find($region)->title;
    $country = Account::find($created_id)->main_country;
    $country = Country::find($country)->title;
    $phone = Account::find($created_id)->main_office_phone;

    $account_info = array(
      'email' => $email,
      'street_address' => $street_address,
      'city' => $city,
      'postal_code' => $postal_code,
      'region' => $region,
      'country' => $country,
      'phone' => $phone
    );

    $schedule_date = DB::table('itinerary_daily')
        ->select('date')
        ->where('itinerary_id', $itinerary_id)
        ->groupBy('date')
        ->get();

    $itinerary_daily = DB::table('itinerary_daily')
      ->select('product.id as product_id', 'product.title as product_title', 'category.title as category_title', 'country.title as country_title', 'city.title as city_title', 'itinerary_daily.date', 'itinerary_daily.start_time', 'itinerary_daily.end_time', 'itinerary_daily.adults_num', 'itinerary_daily.children_num')
      ->join('product', 'product.id', '=', 'itinerary_daily.product_id')
      ->join('city', 'product.city', '=', 'city.id')
      ->join('country', 'product.country', '=', 'country.id')
      ->join('category', 'product.category', '=', 'category.id')
      ->where('itinerary_daily.itinerary_id', $itinerary_id)
      ->orderBy('itinerary_daily.start_time')
      ->get();

    $itinerary_schedule_data = array();
    
    for($i = 0; $i<count($schedule_date); $i++) {
      $temp = array();
      for($j=0; $j<count($itinerary_daily); $j++) {
        if($schedule_date[$i]->date == $itinerary_daily[$j]->date) {
          $product_id = $itinerary_daily[$j]->product_id;

          $product_gallery = ProductGallery::where('product_id', $product_id)->get();
          
          $schedule_record = $itinerary_daily[$j];
          $schedule_record->product_gallery = $product_gallery;
          
          array_push($temp, $schedule_record);
        }
      }

      $itinerary_schedule_data[$schedule_date[$i]->date] = $temp;
    }
    
    $itinerary_currency = Itinerary::find($itinerary_id)->currency;
    $itinerary_budget = Itinerary::find($itinerary_id)->budget;

    $itinerary_info = array(
      'itinerary_currency' => $itinerary_currency,
      'itinerary_budget' => $itinerary_budget
    );

    return view('pages.itinerary_showcase', array(
      'account_info' => $account_info,
      'itinerary_schedule_info' => $itinerary_schedule_data,
      'itinerary_info' => $itinerary_info
    ));
  }
}