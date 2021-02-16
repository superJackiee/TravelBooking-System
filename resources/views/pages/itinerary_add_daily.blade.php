@extends('layouts.contentLayoutMaster')

{{-- title --}}
@section('title','Travel Quoting System | Create Daily Itineary')
{{-- venodr style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/dragula.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/sweetalert2.min.css')}}">
@endsection
@section('custom-horizontal-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/core/menu/menu-types/horizontal-menu.css')}}">
@endsection

{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/dashboard-analytics.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/animate/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/wizard.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/itinerary.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/simplePagination.css')}}">
@endsection

@section('content')
<!-- Dashboard Analytics Start -->

<section>
  <!-- modal section -->
  <div class="modal fade text-left" id="product_detail_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel17"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
          <!-- product image carousel -->
          <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
          </div>
          <!-- end product image carouse -->

          <label class="app-file-label">Information</label>
          <div class="d-flex align-items-center mt-75">
              <p style="margin-right: 20px;" class="text-danger">Category:</p>
              <p class="font-weight-bold" id="category_title"></p>
          </div>
          <div class="d-flex align-items-center">
              <p style="margin-right: 20px;" class="text-danger">location:</p>
              <p class="font-weight-bold" id="location"></p>
          </div>
          <input type="hidden" id="location_info">

          <!-- google map -->
          <div id="basic-map" class="height-300"></div>
          <!-- end google map -->
        
          <div class="d-flex align-items-center mt-75">
              <p style="margin-right: 20px;" class="text-danger">Serving Time:</p>
              <p class="font-weight-bold" id="product_time"></p>
          </div>
          <div id="product_description">
             
          </div>
          <div>
              <p style="margin-right: 20px;" class="text-danger">Pricing:</p>
              <div id="pricing-data">
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
            <i class="bx bx-x d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Close</span>
          </button>
          <button type="button" class="btn btn-primary ml-1" data-dismiss="modal">
            <i class="bx bx-check d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Accept</span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade text-left" id="day-title-modal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel150" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header bg-danger white">
          <span class="modal-title" id="myModalLabel150">Day Title</span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="day-title-modal-id">
          <fieldset class="form-label-group">
              <input type="text" class="form-control" id="day-title-input" placeholder="Please Enter Day Title">
              <label for="floating-label1">Title</label>
          </fieldset>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger ml-1" data-dismiss="modal" onClick="set_day_title()">
            <i class="bx bx-check d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Change</span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade text-left" id="product-time-modal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel150" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header bg-danger white">
          <span class="modal-title" id="myModalLabel150">Product Time</span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="product-time-id">
          <div class="row">
            <div class="col-md-6">
              <h6>Start Time</h6>
              <fieldset class="form-group position-relative has-icon-left">
                <input type="text" class="form-control pickatime" id="start_time" placeholder="Select Start Time">
                <div class="form-control-position">
                    <i class='bx bx-history'></i>
                </div>
              </fieldset>
            </div>
            <div class="col-md-6 ">
              <h6>End Time</h6>
              <fieldset class="form-group position-relative has-icon-left">
                <input type="text" class="form-control pickatime" id="end_time" placeholder="Select End Time">
                <div class="form-control-position">
                    <i class='bx bx-history'></i>
                </div>
              </fieldset>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger ml-1" data-dismiss="modal" onClick="set_product_time()">
            <i class="bx bx-check d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Apply</span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade text-left" id="template-itinerary-modal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel150" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header bg-danger white">
          <span class="modal-title" id="myModalLabel150">Template Itinerary</span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="template_id" name="template_id" value="">
          <div class="row">
            <div class="col-md-12">
              <h6>Title</h6>
              <fieldset class="form-group position-relative has-icon-left">
                <input type="text" class="form-control" id="template_title" placeholder="Enter Template Itinerary Title" required>
                <div class="form-control-position">
                    <i class='bx bx-history'></i>
                </div>
              </fieldset>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger ml-1" data-dismiss="modal" onClick="save_template_itinerary()">
            <i class="bx bx-check d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Save</span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade text-left" id="product-travellers-modal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel150" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header bg-danger white">
          <span class="modal-title" id="myModalLabel150">Product Travellers</span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="product-travellers-id">
          <div class="row">
            <div class="col-md-6">
              <h6>Adult Number</h6>
              <div class="d-inline-block mb-1 mr-1">
                  <input type="number" class="touchspin" value="0" id="adults_num" name="adults_num">
              </div>
            </div>
            <div class="col-md-6">
              <h6>Child Number</h6>
              <div class="d-inline-block mb-1 mr-1">
                  <input type="number" class="touchspin" value="0" id="children_num" name="children_num">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger ml-1" data-dismiss="modal" onClick="set_product_travellers()">
            <i class="bx bx-check d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Apply</span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade text-left" id="itinerary-margin-modal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel150" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header bg-danger white">
          <span class="modal-title" id="myModalLabel150">Itinerary Price Margin</span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="itinerary-margin-id">
          <div class="row">
            <div class="col-md-12">
              <h6>Price Margin</h6>
              <div class="d-inline-block mb-1 mr-1">
                  <input type="number" class="touchspin" value="0" id="modal_itinerary_margin_price" name="modal_itinerary_margin_price">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger ml-1" data-dismiss="modal" onClick="set_price_margin()">
            <i class="bx bx-check d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Apply</span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade text-left" id="product-pricing-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel150" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <span class="modal-title" id="myModalLabel150">Product Pricing</span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-4">
              <button type="button" class="btn btn-primary" id="add_new_product_pricing" onclick="new_product_pricing()">Add New</button>
            </div>
          </div>
          <div id="product_pricing_container" class="mt-2"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger ml-1" id="set_all_product_price" onclick="set_all_product_price()">
            <i class="bx bx-check d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Apply</span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade text-left" id="template_detail_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="template_itinerary_title_caption"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
          <div id="template_preview_container">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
            <i class="bx bx-x d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Close</span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- end modal section -->

  <!-- enquiry information dropdown -->
  <div class="collapsible collapse-icon accordion-icon-rotate">
    <div class="card collapse-header">
      <div id="headingCollapse5" class="card-header" data-toggle="collapse" role="button" data-target="#collapse5"
        aria-expanded="false" aria-controls="collapse5">
        <span class="collapse-title">
          <i class='bx bx-help-circle align-middle'></i>
          <span class="align-middle">Enquiry Informaion</span>
        </span>
      </div>
      <div id="collapse5" role="tabpanel" aria-labelledby="headingCollapse5" class="collapse">
        <div class="card-content">
          <div class="card-body">
            <div class="row">
              <div class="col-md-2 col-2" style="border-left: 1px solid #DFE3E7">
                <h6>Ref.No: {{$enquiry->reference_number}}</h6>
              </div>
              <div class="col-md-2 col-2" style="border-left: 1px solid #DFE3E7">
                <h6>Title: {{$enquiry->title}}</h6>
              </div>
              <div class="col-md-2 col-2" style="border-left: 1px solid #DFE3E7">
                <h6>Total Budget: {{$enquiry->budget}}$</h6>
              </div>
              <div class="col-md-3 col-3" style="border-left: 1px solid #DFE3E7">
                <h6>From Date: &nbsp;&nbsp;&nbsp;&nbsp;{{$enquiry->from_date}}</h6>
              </div>
              <div class="col-md-3 col-3" style="border-left: 1px solid #DFE3E7">
                <h6>End Date: &nbsp;&nbsp;&nbsp;&nbsp;{{$enquiry->to_date}}</h6>
              </div>
            </div>
            <div class="row" style="padding-top: 15px;">
              <div class="col-md-6 col-6" style="border-left: 1px solid #DFE3E7">
                <h6>Travellers: &nbsp;&nbsp;{{$enquiry->adult_number}} Adult(s) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$enquiry->children_number}} Child(ren) </h6>
              </div>
            </div>
            <div class="row" style="padding-top: 15px;">
              <div class="col-md-2 col-2" style="border-left: 1px solid #DFE3E7">
                <h6>Single Room: {{$enquiry->single_count}} Room(s)</h6>
              </div>
              <div class="col-md-2 col-2" style="border-left: 1px solid #DFE3E7">
                <h6>Double Room: {{$enquiry->double_count}} Room(s)</h6>
              </div>
              <div class="col-md-2 col-2" style="border-left: 1px solid #DFE3E7">
                <h6>Twin Room: {{$enquiry->twin_count}} Room(s)</h6>
              </div>
              <div class="col-md-3 col-3" style="border-left: 1px solid #DFE3E7">
                <h6>Triple Room: {{$enquiry->triple_count}} Room(s)</h6>
              </div>
              <div class="col-md-3 col-3" style="border-left: 1px solid #DFE3E7">
                <h6>Family Room: {{$enquiry->family_count}} Room(s)</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end enquiry information dropdwon -->

  <div class="row" style="height: 100%; overflow-y: auto">
    <input type="hidden" id="itinerary_id" name="itinerary_id" value="{{ $itinerary_id }}">
    <div class="col-sm-12 col-md-4">
      <div class="card daily-schedule" style="height: 650px; overflow-y:auto;">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5>Daily Schedule</h5>
          <select class="form-control" id="day_select" onChange="day_selection_change()" style="width: 40%;">
            <option value="0">All days</option>
            <?php $date = date_create($from_date); $from_date_select = $from_date;?>
            @for($i = 0; $i < $days; $i ++)
              <?php $from_date_select = $date->format('Y-m-d');?>
              <option value='{{$i + 1}}'>Day {{$i + 1}} {{$from_date_select}}</option>
              <?php $date = date_add($date, date_interval_create_from_date_string('1 day'));?>
            @endfor
          </select>
        </div>
        <div class="card-content">
          <div class="card-body">
            <div class="row">
              <div class="col-md-8 d-flex align-items-center">
                <button type="button" id="itinerary_save" class="btn btn-primary" style="margin-bottom: 15px; margin-right: 10px;">Next</button>
                <button type="button" id="template_itinerary_save" class="btn btn-primary" style="margin-bottom: 15px;">Save As Template</button>
              </div>
              <div class="col-md-4 d-flex align-items-center justify-content-end">
                <a href="{{ route('index') }}" class="btn btn-danger" style="margin-bottom: 15px;">Back</a>
              </div>
            </div>
            <?php $date = date_create($from_date); $temp_date = $from_date?>
            @for($i = 0; $i < $days; $i ++)
            <div class="each-day" id="each_day_container_{{$i}}">
              <div class="day-header">
                <div class="day-header-left">
                  <?php $from_date = $date->format('Y-m-d');?>
                  <div class="day-date" data-pick="{{ $from_date }}">  
                     {{$from_date}}
                  </div>
                  <div class="day-title-contain">
                    <input type="hidden" id="day-title-val-{{$i}}" value="<?php $timestamp =  strtotime($from_date); echo date('l', $timestamp)?>">
                    <div id="day-title-{{$i}}"><?php $timestamp =  strtotime($from_date); echo date('l', $timestamp)?></div> &nbsp;
                    <div style="padding-top: 3px;"><i class="bx bx-pencil edit-icon" style="color:rgb(210, 77, 83);" onClick="edit_day_title({{$i}})"></i></div>
                  </div>
                </div>
                <div class="day-header-right">
                  <div class="dropdown">
                    <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item" href="../edit_enquiry/{{$enquiry->id}}"><i class="bx bx-edit-alt mr-1"></i> edit</a>
                      <a class="dropdown-item" href="javascript:void(0)" onClick="enquiry_del({{$enquiry->id}})"><i class="bx bx-trash mr-1"></i> delete</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="day-body">
                <div class="each-day-products" id=<?php echo "each-day-products-".$i?>>
                  <div class="drag-explain-contain">
                    <sapn>Drag a product here to add it to the itinerary</span>
                  </div>
                </div>
              </div>
            </div> 
            <?php $date = date_add($date, date_interval_create_from_date_string('1 day'));?>
            @endfor
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-12 col-md-4">
      <div class="card" style="height: 650px;">
        <div class="card-header" style="display: flex; align-items: center; justify-content: space-between">
          <h5>Product</h5>
          <a href="javascript:void(0)" id="filter_button">
            <i class="bx bx-filter-alt" style="font-size: 25px; color: rgb(210, 77, 83)" title="Filter Product"></i>
          </a>
        </div>
        <div class="card-content">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <fieldset class="form-group position-relative has-icon-left">
                    <input type="text" class="form-control" id="search_product" placeholder="Enter Product Title">
                    <div class="form-control-position">
                        <i class="bx bx-search"></i>
                    </div>
                </fieldset>
              </div>
            </div>
            <div class="row">
              <div class="col-3" id="filter_option" style="display: none">
                <h6 style="padding-bottom: 20px;">
                  Category
                </h6>
              
                <fieldset>
                  <div class="checkbox checkbox-danger" style="padding-bottom: 7px;" >
                    <input type="checkbox" id="check_accommodation" onChange="filter_change()">
                    <label class="colorCheckbox4" style="font-size: 0.9rem;" for="check_accommodation" >Accommodation</label>
                  </div>
                </fieldset>
                <fieldset>
                  <div class="checkbox checkbox-danger" style="padding-bottom: 7px;">
                    <input type="checkbox" id="check_transport" onChange="filter_change()" >
                    <label class="colorCheckbox4" style="font-size: 0.9rem;" for="check_transport">Transport</label>
                  </div>
                </fieldset>
                <fieldset>
                  <div class="checkbox checkbox-danger" style="padding-bottom: 7px;">
                    <input type="checkbox" id="check_activity_attraction" onChange="filter_change()">
                    <label class="colorCheckbox4" style="font-size: 0.9rem;" for="check_activity_attraction">Activies & Attraction</label>
                  </div>
                </fieldset>
                <fieldset>
                  <div class="checkbox checkbox-danger" style="padding-bottom: 7px;">
                    <input type="checkbox" id="check_guide" onChange="filter_change()">
                    <label class="colorCheckbox4" style="font-size: 0.9rem;" for="check_guide">Guide</label>
                  </div>
                </fieldset>
                <fieldset>
                  <div class="checkbox checkbox-danger" style="padding-bottom: 7px;">
                    <input type="checkbox" id="check_other" onChange="filter_change()">
                    <label class="colorCheckbox4" style="font-size: 0.9rem;" for="check_other">Other</label>
                  </div>
                </fieldset>
              </div>
              <div class="col-12" id="product_list_container">
                <ul class="product-list" id="product_list">
                  <!-- @foreach($product as $data)
                    <li class="product-list-each item">
                      <div class="product-list-class">
                        <input type="hidden" name="product_id" id="product_id" value="{{$data->id}}">
                        <div class="product-list-left" onClick="product_detail({{$data->id}})">
                          <i class="bx bx-grid-vertical" style="font-size: 25px; margin: auto 0; cursor: move"></i>
                          <img class="product-list-img" src="/{{$data->getFirstImage->path}}"/>
                          <div class="product-list-explain">
                            <div class="product-list-title" id="product-list-title">
                              {{$data->title}}
                            </div>
                            <div class="product-list-detail">
                              {{$data->getCity->title}}, {{$data->getCountry->title}}
                            </div>
                          </div>
                        </div>
                        <div class="product-list-right">
                          <div class="dropdown">
                            <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                            <div class="dropdown-menu dropdown-menu-right">
                              <a class="dropdown-item" href="../edit_enquiry/{{$enquiry->id}}"><i class="bx bx-edit-alt mr-1"></i> edit</a>
                              <a class="dropdown-item" href="javascript:void(0)" onClick="enquiry_del({{$enquiry->id}})"><i class="bx bx-trash mr-1"></i> delete</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                  @endforeach -->
                </ul>
                <ul class="pagination custom-pagination" id="product_pagination"></ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-12 col-md-4" >
      <div class="card" style="height: 650px;">
        <div class="card-header">
          <h5>Template Itinerary</h5>
        </div>
        <div class="card-content">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <fieldset class="form-group position-relative has-icon-left">
                    <input type="text" class="form-control" id="search_template_itinerary" placeholder="Enter Template Itinerary Title">
                    <div class="form-control-position">
                        <i class="bx bx-search"></i>
                    </div>
                </fieldset>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12" id="template_itinerary_list_container">
                <ul class="template-list" id="template_itinerary_list"></ul>
                <ul class="pagination" id="template_itinerary_pagination"></ul>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
  <!-- Dashboard Analytics end -->
@endsection
{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/extensions/jquery.steps.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.time.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/legacy.js')}}"></script>
<script src="{{asset('vendors/js/pickers/daterange/moment.min.js')}}"></script>
<script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
<script src="{{asset('//maps.googleapis.com/maps/api/js?key=AIzaSyBgjNW0WA93qphgZW-joXVR6VC3IiYFjfo')}}"></script>
<script src="{{asset('vendors/js/charts/gmaps.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/dragula.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
@endsection

@section('page-scripts')
<script src="{{asset('js/core/libraries/pagination.js')}}"></script>
<script>
  var base_url = "{{ url('/') }}";
  var from_date = <?php echo json_encode($temp_date)?>;
  var to_date = <?php echo json_encode($to_date)?>;
  var days = <?php echo json_encode($days)?>;
  var enquiry = <?php echo json_encode($enquiry)?>;
  var itinerary = <?php echo json_encode($itinerary)?>;
  var product = <?php echo json_encode($product)?>;
  var product_pricing = <?php echo json_encode($product_pricing)?>;
  var currency = <?php echo json_encode($currency)?>;
  var categoryTag = <?php echo json_encode($categoryTag)?>;
  var categories = <?php echo json_encode($category)?>;
  var product_gallery = <?php echo json_encode($product_gallery)?>;
  var product_description = <?php echo json_encode($product_description)?>;
  var language = <?php echo json_encode($language)?>;
  var days = <?php echo $days?>;
  var daily_schedule_data = <?php echo json_encode($itinerary_schedule_data) ?>;
  var template_itinerary_data = <?php echo json_encode($template_itinerary_data) ?>;
</script>

<script src="{{asset('js/scripts/pages/itinerary_daily.js')}}"></script>  
@endsection

