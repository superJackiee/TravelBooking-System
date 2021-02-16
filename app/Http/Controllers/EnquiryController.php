<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\Enquiry;
use Illuminate\Support\Facades\Auth;

class EnquiryController extends Controller
{
    public function create_enquiry(){
        $account = Account::all();

        return view('pages.enquiry_create',compact('account'));
    }
    //ecommerce
    // public function dashboardEcommerce(){
    //     return view('pages.dashboard-ecommerce');
    // }
    // // analystic
    // public function dashboardAnalytics(){
    //     return view('pages.dashboard-analytics');
    // }
    public function create(Request $request){

        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["name" => "Dashboard"]
        ];

        $new_enquiry = new Enquiry;
        $new_enquiry->title = $request->title;
        $new_enquiry->account_id = $request->account_id;
        $new_enquiry->travel_number = $request->adults_num + $request->children_num;
        $new_enquiry->budget = $request->budget;
        $duration = $request->duration;
        $start_date = substr($duration, 0, -13);
        $time = strtotime($start_date);
        $new_enquiry->from_date = date('Y-m-d', $time);
        $end_date = substr($duration, -10);
        $time = strtotime($end_date);
        $new_enquiry->to_date = date('Y-m-d', $time);
        $new_enquiry->adult_number = $request->adults_num;
        $new_enquiry->children_number = $request->children_num;
        $new_enquiry->infant_number = 0;
        $new_enquiry->single_count = $request->single_room;
        $new_enquiry->double_count = $request->double_room;
        $new_enquiry->twin_count = $request->twin_room;
        $new_enquiry->triple_count = $request->triple_room;
        $new_enquiry->family_count = $request->family_room;
        if($request->budget_per_total == 'per_person')
            $new_enquiry->budget_per_total = 1;
        elseif($request->budget_per_total == 'total')
            $new_enquiry->budget_per_total = 0;
        if($request->is_assigned == 'on')
            $new_enquiry->is_assigned = 1;
        else
            $new_enquiry->is_assigned = 0;
        if($new_enquiry->is_assigned == 1 && $request->assigned_user != "")
            $new_enquiry->assigned_user = $request->assigned_user;
        else
            $new_enquiry->assigned_user = 0;
        $new_enquiry->is_created_itinerary = 0;
        $new_enquiry->note = $request->note;
        $new_enquiry->created_id = Auth::user()->id;
        
        $all = Enquiry::all();
        if(count($all) == 0)
        {
            $ref_no = "E-1";
        }
        else{
            $max = 0;
            for($i = 0;$i < count($all); $i ++){
                $str = explode('-',$all[$i]);
                $num = intval($str[1]);
                if($num > $max)
                    $max = $num;
            }
            $max ++;
            $ref_no = "E-".$max;
        }

        $new_enquiry->reference_number = $ref_no;
        $new_enquiry->save();

        $enquiries = Enquiry::all();
        return redirect()->route('index')->with('msg', 'enquiry created');
    }

    public function edit(Request $request)
    {
        $custom_enquiry = Enquiry::where('id', $request->enquiry_id)->first();
        $account = Account::all();
        return view('pages.enquiry_edit',compact('custom_enquiry', 'account'));
    }

    public function save_change(Request $request)
    {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["name" => "Dashboard"]
        ];

        $update_enquiry = new Enquiry;
        $update_enquiry->title = $request->title;
        $update_enquiry->account_id = $request->account_id;
        $update_enquiry->travel_number = $request->adults_num + $request->children_num;
        $update_enquiry->budget = $request->budget;
        $duration = $request->duration;
        $start_date = substr($duration, 0, -13);
        $time = strtotime($start_date);
        $update_enquiry->from_date = date('Y-m-d', $time);
        $end_date = substr($duration, -10);
        $time = strtotime($end_date);
        $update_enquiry->to_date = date('Y-m-d', $time);
        $update_enquiry->adult_number = $request->adults_num;
        $update_enquiry->children_number = $request->children_num;
        $update_enquiry->infant_number = 0;
        $update_enquiry->single_count = $request->single_room;
        $update_enquiry->double_count = $request->double_room;
        $update_enquiry->twin_count = $request->twin_room;
        $update_enquiry->triple_count = $request->triple_room;
        $update_enquiry->family_count = $request->family_room;
        if($request->budget_per_total == 'per_person')
            $update_enquiry->budget_per_total = 1;
        elseif($request->budget_per_total == 'total')
            $update_enquiry->budget_per_total = 0;
        if($request->is_assigned == 'on')
            $update_enquiry->is_assigned = 1;
        else
            $update_enquiry->is_assigned = 0;
        if($update_enquiry->is_assigned == 1 && $request->assigned_user != "")
            $update_enquiry->assigned_user = $request->assigned_user;
        else
            $update_enquiry->assigned_user = 0;
        $update_enquiry->is_created_itinerary = 0;
        $update_enquiry->note = $request->note;
        
        $custom_enquiry = Enquiry::where('id', $request->enquiry_id)->first();
        $ref_str = $custom_enquiry->reference_number;
        $ref_nums = explode('-', $ref_str);
        $ref_num = $ref_nums[1];
        
        $all_enquiry = Enquiry::all();
        $cnt = 0;
        for($i = 0; $i < count($all_enquiry);$i ++)
        {
            $ref_str = $all_enquiry[$i]->reference_number;
            $ref_nums = explode('-', $ref_str);
            if($ref_nums[1] == $ref_num)
            {
                $tmp_enquries[$cnt] = $all_enquiry[$i];
                $cnt ++;
            }
        }
        if($cnt == 1)
        {
            $ref = 'E-'.$ref_num.'-1';
            $custom_enquiry->reference_number .= '-0';
            $update_enquiry->reference_number = $ref;
            $update_enquiry->created_id = $custom_enquiry->created_id;
            $update_enquiry->updated_id = Auth::user()->id;
            $custom_enquiry->save();
            $update_enquiry->save();
        }
        else{
            $max = 0;
            for($i = 0; $i < $cnt; $i ++){
                $ref_str = $tmp_enquries[$i]->reference_number;
                $ref_nums = explode('-', $ref_str);
                $to_num = intval($ref_nums[2]);
                if($to_num > $max)
                    $max = $to_num;
            }
            $max ++;
            $update_enquiry->reference_number = 'E-'.$ref_num.'-'.$max;
            $update_enquiry->updated_id = Auth::user()->id;
            $update_enquiry->created_id = $custom_enquiry->created_id;
            $update_enquiry->save();
        }        
        return redirect()->route('index')->with('msg', 'enquiry updated');
    }

    public function del_enquiry(Request $request)
    {
        $enquiry = Enquiry::where('id', $request->enquiry_id)->first();
        $enquiry->delete();
        $success = "Success!";
        return $success;
    }
}

