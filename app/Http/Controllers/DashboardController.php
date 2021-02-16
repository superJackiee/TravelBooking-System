<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\Enquiry;
use App\Models\Itinerary;

class DashboardController extends Controller
{
    public function index(){
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["name" => "Dashboard"]
        ];
        $enquiries = Enquiry::all();
        $itineraries = Itinerary::all();
        $msg = '';
        //dd(compact('enquiries', 'itineraries', 'pageConfigs', 'breadcrumbs', 'msg'));
        return view('pages.dashboard',compact('enquiries', 'itineraries', 'pageConfigs', 'breadcrumbs', 'msg'));
    }
}
