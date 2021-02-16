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

class SettingController extends Controller
{
    public function index(Request $request) {
        $pageConfigs = ['isContentSidebar' => true, 'bodyCustomClass' => 'email-application'];

        return view('pages.settings_general',array(
            'pageConfigs' => $pageConfigs,
        ));
    }
}
