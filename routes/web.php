<?php
use App\Http\Controllers\LanguageController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// dashboard Routes

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'DashboardController@index')->name('index');

    //Enquriy
    Route::get('/create_enquiry', 'EnquiryController@create_enquiry');
    Route::post('/create_enquiry/create',['as' => 'create_enquiry.create', 'uses' => 'EnquiryController@create']);
    Route::get('/edit_enquiry/{enquiry_id}',['as' => 'edit_enquiry', 'uses' => 'EnquiryController@edit']);
    Route::post('/save_enquiry',['as' => 'save_enquiry', 'uses' => 'EnquiryController@save_change']);
    Route::get('/del_enquiry',['as' => 'del_enquiry', 'uses' => 'EnquiryController@del_enquiry']);

    //CRM
    Route::get('/crm', 'CrmController@index')->name('crm_index');
    Route::get('/customer_create', 'CrmController@customer_create');
    Route::post('/add_account', 'CrmController@add_account');
    Route::get('/edit_customer/{account_id}',['as' => 'edit_customer', 'uses' => 'CrmController@edit_customer']);
    Route::get('/edit_account/{account_id}',['as' => 'edit_account', 'uses' => 'CrmController@edit_account']);
    Route::post('/update_account',['as' => 'update_account', 'uses' => 'CrmController@update_account']);
    Route::get('/account_create', 'CrmController@account_create');
    Route::post('/update_password', 'CrmController@update_password');
    Route::get('/del_account',['as' => 'del_account', 'uses' => 'CrmController@del_account']);
    Route::post('/crm/avatar_upload','CrmController@saveAvatarUpload')->name('avatar_upload');

    Route::get('/user_profile', ['as' => 'user_profile', 'uses'=> 'CrmController@user_profile']);
    Route::post('/update_profile', ['as' => 'update_profile', 'uses'=> 'CrmController@update_profile']);
    Route::post('/update_user_pwd', 'CrmController@update_user_pwd');

    //Itinerary

    Route::get('/itinerary_add_basic/with_enquiry_id/{enquiry_id}', 'ItineraryController@add_basic');
    Route::post('/itinerary_create_basic/with_enquiry_id', ['as' => 'itinerary_create_basic.with_enquiry_id', 'uses' => 'ItineraryController@create_basic']); 
    Route::get('/itinerary_add_daily/{itinerary_id}', ['as' => 'itinerary_add_daily', 'uses' => 'ItineraryController@add_daily']);
    Route::get('/itinerary_add_daily_search',['as' => 'itinerary_add_daily_search', 'uses' => 'ItineraryController@product_search']);
    Route::get('/itinerary_template_search',['as' => 'itinerary_template_search', 'uses' => 'ItineraryController@template_search']);
    Route::get('/itinerary_add_daily_filter',['as' => 'itinerary_add_daily_filter', 'uses' => 'ItineraryController@filter']);
    Route::get('/itinerary_edit/{itinerary_id}',['uses' => 'ItineraryController@edit_itinerary'])->name('edit_itinerary');
    Route::post('/del_itinerary',['uses' => 'ItineraryController@delete_itinerary']);
    Route::get('/itinerary_send/{itinerary_id}',['uses' => 'ItineraryController@send_itinerary'])->name('send_itinerary');
    Route::post('/itinerary_send',['uses' => 'ItineraryController@send_email_itinerary'])->name('itinerary_send');
    Route::post('/itinerary_daily_save',['as' => 'itinerary_daily_save', 'uses' => 'ItineraryController@saveDailyItinerary']);
    Route::post('/itinerary_template_save',['as' => 'itinerary_template_save', 'uses' => 'ItineraryController@saveTemplateItinerary']);
    Route::post('/get_product_pricing_tag',['as' => 'get_product_pricing_tag', 'uses' => 'ItineraryController@get_product_pricing_tag']);
    Route::post('/get_product_pricing_and_tag',['as' => 'get_product_pricing_and_tag', 'uses' => 'ItineraryController@get_product_pricing_and_tag']);
    Route::post('/check_itinerary_product_season',['as' => 'check_itinerary_product_season', 'uses' => 'ItineraryController@check_itinerary_product_season']);
    Route::get('/complete_itinerary/{itinerary_id}',['uses' => 'ItineraryController@complete_itinerary'])->name('complete_itinerary');
    Route::post('/itinerary_complete_with_budget',['as' => 'itinerary_complete_with_budget', 'uses' => 'ItineraryController@itinerary_complete_with_budget']);
    Route::post('/delete_template_itinerary',['as' => 'delete_template_itinerary', 'uses' => 'ItineraryController@delete_template_itinerary']);
    Route::post('/preview_template_itinerary',['as' => 'preview_template_itinerary', 'uses' => 'ItineraryController@preview_template_itinerary']);
    Route::post('/currency_converter',['as' => 'currency_converter', 'uses' => 'ItineraryController@currency_converter']);
    Route::get('/get/travel_showcase/{itinerary_id}', 'ItineraryController@show_itinerary');
    
    //Product
    Route::get('/product/add/{flag?}', 'ProductController@add_product')->name('product_add');
    Route::get('/product', 'ProductController@index')->name('product');
    Route::post('/product/detail', 'ProductController@product_detail')->name('product_detail');

    Route::get('/product/add/{flag?}', 'ProductController@product_add')->name('product_add');
    Route::get('/product/edit/{product_id?}', 'ProductController@product_edit')->name('product_edit');
    Route::get('/product/delete/{product_id?}', 'ProductController@product_delete')->name('product_delete');
    Route::post('/product/city', 'ProductController@get_city')->name('product.city');
    Route::post('/product/tag', 'ProductController@get_tag')->name('product.tag');
    Route::post('/product/save', 'ProductController@product_save')->name('product_save');

    Route::post('/product/description', 'ProductController@product_description')->name('product_description');
    Route::post('/product/gallery/upload', 'ProductController@upload_gallery')->name('upload_gallery');
    Route::post('/product/gallery/delete', 'ProductController@delete_gallery')->name('delete_gallery');
    Route::post('/product/pricing', 'ProductController@product_pricing')->name('product_pricing');

    //Setting
    Route::get('/settings', 'SettingController@index')->name('setting');
    Route::get('/settings/tags/{flag?}', 'SettingController@tags')->name('tags');
    Route::get('/settings/customer/', 'SettingController@customer')->name('customer');
});