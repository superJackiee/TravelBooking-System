@extends('layouts.contentLayoutMaster')

@section('title','Travel Quoting System | Product')

@section('vendor-styles')
  <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/bootstrap-treeview.min.css')}}">

  <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">

  <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/editors/quill/katex.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/editors/quill/monokai-sublime.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/editors/quill/quill.snow.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/editors/quill/quill.bubble.css')}}">

  <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">

  <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/ui/prism.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/file-uploaders/dropzone.min.css')}}">

  <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')}}">

  <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/animate/animate.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/sweetalert2.min.css')}}">
@endsection

@section('custom-horizontal-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/core/menu/menu-types/horizontal-custom-menu.css')}}">
@endsection

@section('page-styles')
  <style>
    .add_product_title {
      margin: 5px 0;
      font-size: 20px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
      margin-left: 25px;
    }
  </style>

<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-file-manager.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/extensions/ext-component-treeview.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/validation/form-validation.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/file-uploaders/dropzone.css')}}">

@endsection

@section('sidebar-content')
  @if ($errors->any())
        @foreach ($errors->all() as $error)
            <input type="hidden" class="error-message" value="{{ $error }}">
        @endforeach
  @endif

  <input type="hidden" id="alert" value="{{ Session::get('alert') }}">
  <div class="app-file-sidebar sidebar-content d-flex">
    <!-- App File sidebar - Left section Starts -->
    <div class="app-file-sidebar-left">
      <!-- sidebar close icon starts -->
      <span class="app-file-sidebar-close"><i class="bx bx-x"></i></span>
      <!-- sidebar close icon ends -->

      <div class="app-file-sidebar-content">
        <!-- App File Left Sidebar - Drive Content Starts -->
        <label class="app-file-label">Category</label>
        <div class="list-group list-group-messages my-50">
          <a href="{{ route('product_add', ['flag' => 'accommodation']) }}" class="list-group-item list-group-item-action pt-0 {{ $flag == 1? 'active': ''}}">
            <div class="fonticon-wrap d-inline mr-25">
              <i class="livicon-evo" data-options="name: bank.svg; size: 24px; style: lines; {{ $flag == 1? 'strokeColor:#5A8DEE;': 'strokeColor:#475f7b;'}}  eventOn:grandparent; duration:0.85;"></i>
            </div>
            Accommodation
          </a>
          <a href="{{ route('product_add', ['flag' => 'transport']) }}" class="list-group-item list-group-item-action {{ $flag == 2? 'active': ''}}">
            <div class="fonticon-wrap d-inline mr-25">
              <i class="livicon-evo" data-options="name: car.svg; size: 24px; style: lines; {{ $flag == 2? 'strokeColor:#5A8DEE;': 'strokeColor:#475f7b;'}} eventOn:grandparent; duration:0.85;"></i>
            </div>
            Transport
          </a>
          <a href="{{ route('product_add', ['flag' => 'activities']) }}" class="list-group-item list-group-item-action {{ $flag == 3? 'active': ''}}">
            <div class="fonticon-wrap d-inline mr-25">
              <i class="livicon-evo"
                 data-options="name: fire.svg; size: 24px; style: lines; {{ $flag == 3? 'strokeColor:#5A8DEE;': 'strokeColor:#475f7b;'}} eventOn:grandparent; duration:0.85;"></i>
            </div>
            Activites and Attractions
          </a>
          <a href="{{ route('product_add', ['flag' => 'guide']) }}" class="list-group-item list-group-item-action {{ $flag == 4? 'active': ''}}">
            <div class="fonticon-wrap d-inline mr-25">
              <i class="livicon-evo"
                 data-options="name: user.svg; size: 24px; style: lines; {{ $flag == 4? 'strokeColor:#5A8DEE;': 'strokeColor:#475f7b;'}} eventOn:grandparent; duration:0.85;"></i>
            </div>
            Guides
          </a>
          <a href="{{ route('product_add', ['flag' => 'other']) }}" class="list-group-item list-group-item-action {{ $flag ==5? 'active': ''}}">
            <div class="fonticon-wrap d-inline mr-25">
              <i class="livicon-evo"
                 data-options="name: clock.svg; size: 24px; style: lines; {{ $flag == 5? 'strokeColor:#5A8DEE;': 'strokeColor:#475f7b;'}} eventOn:grandparent; duration:0.85;"></i>
            </div>
            Other
          </a>
        </div>
        <!-- App File Left Sidebar - Drive Content Ends -->
      </div>
    </div>
  </div>
@endsection

@section('content')
  <!-- File Manager app overlay -->
  <div class="app-file-overlay"></div>
  <div class="app-file-area">
    <!-- File App Content Area -->
    <div class="app-file-header">
      <!-- Header search bar starts -->
      <div class="flex-grow-1">
        <div class="sidebar-toggle d-block d-lg-none">
          <i class="bx bx-menu"></i>
        </div>
        <h4 class="add_product_title">Add Product</h4>
      </div>
      <!-- Header search bar Ends -->
      <div class="app-file-header-icons">
        <div class="fonticon-wrap d-inline mx-sm-1 align-middle">
          <a href="{{ route('product') }}">
            <i class="livicon-evo cursor-pointer" data-options="name: hand-left.svg; size: 24px; style: lines; strokeColor:#596778; duration:0.85;"></i>
          </a>
        </div>
      </div>
    </div>
    <!-- App File Content Starts -->
    <div class="app-file-content p-2">
      <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general-pan" role="tab" aria-controls="general-pan" aria-selected="true">
            <i class="bx bx-detail align-middle"></i>
            <span class="align-middle">General</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="translation-tab" data-toggle="tab" href="#translation-pan" role="tab" aria-controls="translation-pan" aria-selected="false">
            <i class="bx bx-flag align-middle"></i>
            <span class="align-middle">Translations</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="image-tab" data-toggle="tab" href="#image-pan" role="tab" aria-controls="image-pan" aria-selected="false">
            <i class="bx bx-image align-middle"></i>
            <span class="align-middle">Images</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="pricing-tab" data-toggle="tab" href="#pricing-pan" role="tab" aria-controls="pricing-pan" aria-selected="false">
            <i class="bx bx-dollar-circle align-middle"></i>
            <span class="align-middle">Pricing</span>
          </a>
        </li>
      </ul>

      <div class="tab-content pt-1">
        <div class="tab-pane active" id="general-pan" role="tabpanel" aria-labelledby="general-tab">
          <form class="form-horizontal" action="{{ route('product_save') }}" id="general-form" name="general-form" method="POST"  novalidate>
            @csrf
            <input type="hidden" id="product_id" name="product_id" value="" />
            <div class="row">
              <div class="col-md-6">
                <div class="row">

                  <div class="col-md-12">
                    <h6>Title</h6>
                    <fieldset class="form-group position-relative has-icon-left @error('title') error @enderror">
                      <input type="text" id="title" name="title" value="{{old('title')}}" class="form-control" data-validation-required-message="This field is required" placeholder="Enter Title">
                      <div class="form-control-position">
                          <i class='bx bx-info-circle'></i>
                      </div>
                    </fieldset>
                  </div>

                  <div class="col-md-12">
                    <h6>Supplier</h6>
                    <fieldset class="form-group position-relative has-icon-left @error('supplier') error @enderror">
                      <select class="select2 form-control" id="supplier" name="supplier" required data-validation-required-message="This field is required">
                          <option value="">Supplier</option>
                          @foreach($supplier as $item)
                            <option value="{{$item->id}}" {{old('supplier')==$item->id?'selected':''}}>{{ $item->first_name }} {{ $item->last_name }}</option>
                          @endforeach
                      </select>
                      <div class="form-control-position">
                        <i class='bx bx-search'></i>
                      </div>
                    </fieldset>
                  </div>

                  <div class="col-md-12">
                    <h6>Category</h6>
                    <fieldset class="form-group position-relative has-icon-left @error('category') error @enderror">
                        <select class="select2 form-control" id="category" name="category" required data-validation-required-message="This field is required">
                            <option value="">Category</option>
                            @foreach($category as $item)
                            <option value="{{$item->id}}" {{old('category')==$item->id?'selected':''}}>{{ $item->title }}</option>
                            @endforeach
                        </select>
                        <div class="form-control-position">
                          <i class='bx bx-search'></i>
                        </div>
                    </fieldset>
                  </div>

                  <div class="col-md-6">
                    <h6>Country</h6>
                    <fieldset class="form-group position-relative has-icon-left @error('country') error @enderror">
                        <select class="select2 form-control" id="country" name="country" required data-validation-required-message="This field is required">
                            <option value="">Country</option>
                            @foreach($country as $item)
                            <option value="{{$item->id}}" {{old('country')==$item->id?'selected':''}}>{{ $item->title }}</option>
                            @endforeach
                        </select>
                        <div class="form-control-position">
                          <i class='bx bx-search'></i>
                        </div>
                    </fieldset>
                  </div>

                  <div class="col-md-6">
                    <h6>City</h6>
                    <fieldset class="form-group position-relative has-icon-left @error('city') error @enderror">
                      <select class="select2 form-control" id="city" name="city" required data-validation-required-message="This field is required">
                          <option value="">City</option>
                          @foreach($city as $item)
                            <option value="{{$item->id}}" {{old('city')==$item->id?'selected':''}}>{{ $item->title }}</option>
                          @endforeach
                      </select>
                      <div class="form-control-position">
                        <i class='bx bx-search'></i>
                      </div>
                    </fieldset>
                  </div>

                  <div class="col-md-6">
                    <h6>Start Time</h6>
                    <fieldset class="form-group position-relative has-icon-left @error('start_time') error @enderror">
                        <input type="text" id="start_time" name="start_time" value="{{old('start_time')}}" required data-validation-required-message="This field is required" class="form-control pickatime-format" placeholder="Select Start Time">
                        <div class="form-control-position">
                            <i class='bx bx-history'></i>
                        </div>
                    </fieldset>
                  </div>
                  <div class="col-md-6 ">
                    <h6>End Time</h6>
                    <fieldset class="form-group position-relative has-icon-left @error('end_time') error @enderror">
                        <input type="text" id="end_time" name="end_time" value="{{old('end_time')}}" required data-validation-required-message="This field is required" class="form-control pickatime-format" placeholder="Select End Time">
                        <div class="form-control-position">
                            <i class='bx bx-history'></i>
                        </div>
                    </fieldset>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <h6>Location</h6>
                <fieldset class="form-group position-relative has-icon-left @error('location') error @enderror">
                  <input type="text" id="location" name="location" value="{{old('location')}}" class="form-control" data-validation-required-message="This field is required" placeholder="Select Location">
                  <div class="form-control-position">
                      <i class='bx bx-info-circle'></i>
                  </div>
                </fieldset>
                <div id="basic-map" style="border: 1px solid #eee; height: 300px;"></div>
              </div>
              <div class="col-md-12 d-flex justify-content-end" style="margin-top: 20px;">
                <button type="submit" id="general_submit" class="btn btn-primary mr-1 mb-1">
                  <i class="bx bx-save"></i>
                  <span class="align-middle ml-25">Save</span>
                </button>
                <a href="{{ route('product') }}" class="btn btn-light-secondary mr-1 mb-1">
                  <i class="bx bx-reset"></i>
                  <span class="align-middle ml-25">Cancel</span>
                </a>
              </div>
            </div>
          </form>
        </div>
        <div class="tab-pane" id="translation-pan" role="tabpanel" aria-labelledby="translation-tab">
          <form class="form-horizontal form" id="description_form" name="description_form" method="POST" action="{{ route('product_description') }}" novalidate>
            @csrf
            <input type="hidden" id="description_product_id" name="description_product_id" value="" />
            <div id="description_list">
              <div class="row" id="description_wrapper_en">
                <div class="col-md-12 d-flex align-items-center justify-content-between">
                  <h6 class="d-flex align-items-center">
                    <span>Description</span>
                    <div class="avatar mr-1 avatar-lg">
                      <img src="{{ asset('images/flags/en.png')}}" alt="avtar img holder" class="flag">
                    </div>
                  </h6>
                </div>
                <div class="col-md-12">
                  <input type="hidden" id="descriptionID_en" name="group['en']['descriptionID']" value="" />
                  <input type="hidden" id="language_en" name="group['en']['language']" value="en" />
                  <div class="form-group">
                    <textarea id="description_en" name="group['en']['description']"  cols="30" rows="10" class="form-control"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-3">
                <h6>Language</h6>
                <fieldset class="form-group position-relative has-icon-left">
                  <select class="select2 form-control" id="language_list" name="language_list">
                      @foreach($language as $item)
                        <option value="{{$item->title}}">{{ $item->title }}</option>
                      @endforeach
                  </select>
                    <div class="form-control-position">
                        <i class='bx bx-history'></i>
                    </div>
                </fieldset>
              </div>
              <div class="col-md-3 form-group" style="padding-top: 25px;">
                <button type="button" id="description_add" data-repeater-create class="btn btn-primary mr-1 mb-1">
                  <i class="bx bx-plus"></i>
                  <span class="align-middle ml-25">Add</span>
                </button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 d-flex justify-content-end" style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary mr-1 mb-1">
                  <i class="bx bx-save"></i>
                  <span class="align-middle ml-25">Save</span>
                </button>
                <a href="{{ route('product') }}" class="btn btn-light-secondary mr-1 mb-1">
                  <i class="bx bx-reset"></i>
                  <span class="align-middle ml-25">Cancel</span>
                </a>
              </div>
            </div>
          </form>
        </div>
        <div class="tab-pane" id="image-pan" role="tabpanel" aria-labelledby="translation-tab">
          <div class="row">
            <div class="col-md-12">
              <h6>Product Image Upload</h6>
            </div>
            <div class="col-md-12">
              <form id="dpz-remove-all-thumb" action="{{ route('upload_gallery') }}" method="POST" enctype="multipart/form-data" class="dropzone dropzone-area">
                @csrf
                <input type="hidden" id="gallery_product_id" name="gallery_product_id" value="" />
                <div class="dz-message">Drop Files Here To Upload</div>
              </form>

            </div>
          </div>
        </div>
        <div class="tab-pane" id="pricing-pan" role="tabpanel" aria-labelledby="pricing-tab">
          <div class="col-md-12">
            <form class="form-horizontal" id="pricing_form" name="pricing_form" method="POST" action="{{ route('product_pricing') }}" novalidate>
              @csrf
              <input type="hidden" id="price_product_id" name="price_product_id" value="" />
              <div class="row">
                <div class="col-md-2 form-group">
                  <button type="button" id="priceset_add" class="btn btn-danger mr-1 mb-1">
                    <i class="bx bx-plus"></i>
                    <span class="align-middle ml-25">Create</span>
                  </button>
                </div>
                <div class="col-md-10 d-flex justify-content-end form-group">
                  <button type="submit" class="btn btn-primary mr-1 mb-1">
                    <i class="bx bx-save"></i>
                    <span class="align-middle ml-25">Save</span>
                  </button>
                  <a href="{{ route('product') }}" class="btn btn-light-secondary mr-1 mb-1">
                    <i class="bx bx-reset"></i>
                    <span class="align-middle ml-25">Cancel</span>
                  </a>
                </div>
              </div>

              <div id="priceset_list">
                <div class="row mb-1" id="pricingset_1" style="border: 1px solid #ccc; padding-top: 20px;">
                  <div class="col-md-12"><h6>Season</h6></div>
                  <div class="col-md-3">
                    <fieldset class="form-group position-relative has-icon-left">
                        <input type="text" class="form-control pickadate" placeholder="Select From Date" id="fromdate_1" name="fromdate[]" value="" onchange="fromdate_trigger(this, 1)">
                      <div class="form-control-position">
                        <i class='bx bx-calendar-check'></i>
                      </div>
                    </fieldset>
                  </div>
                  <div class="col-md-3">
                    <fieldset class="form-group position-relative has-icon-left">
                      <input type="text" class="form-control pickadate" placeholder="Select To Date" id="todate_1" name="todate[]" value="" onchange="todate_trigger(this, 1)">
                      <div class="form-control-position">
                        <i class='bx bx-calendar-check'></i>
                      </div>
                    </fieldset>
                  </div>
                  <div class="col-md-3">
                    <fieldset class="form-group position-relative has-icon-left">
                      <select class="select2 form-control" id="currency_1" name="currency[]">
                        <option value="">Currency</option>
                        @foreach($currency as $item)
                          <option value="{{$item->id}}">{{ $item->title }}</option>
                        @endforeach
                      </select>
                      <div class="form-control-position">
                        <i class='bx bx-search'></i>
                      </div>
                    </fieldset>
                  </div>
                  <div class="col-md-3 form-group d-flex align-items-center justify-content-start">
                    <button type="button" id="copyset_1" class="btn btn-outline-primary mr-1 mb-1" onclick="copypriceset(1)">
                      <i class="bx bx-copy"></i>
                      <span class="align-middle ml-25">Copy</span>
                    </button>

                    <button type="button" id="deleteset_1" class="btn btn-outline-danger mr-1 mb-1" onclick="deleteset(1)">
                      <i class="bx bx-trash"></i>
                      <span class="align-middle ml-25">Delete</span>
                    </button>
                  </div>

                  <div class="col-md-12" id="blackoutdatelist_1">
                    <h6>Blackout Date</h6>
                    <div class="row" id="blackoutdaterecord_1_1">
                      <div class="col-md-3 form-group">
                        <fieldset class="form-group position-relative has-icon-left">
                          <input type="text" class="form-control daterange" placeholder="Select BlackOut Date" id="blackoutdate_1_1" name="blackoutdate[0][]" value="">
                          <div class="form-control-position">
                            <i class='bx bx-calendar-check'></i>
                          </div>
                        </fieldset>
                      </div>
                      <div class="col-md-6">
                        <fieldset class="form-group position-relative has-icon-left">
                          <input type="text" class="form-control" id="blackoutmsg_1_1" name="blackoutmsg[0][]" value="Unavailable date!">
                          <div class="form-control-position">
                            <i class='bx bx-info-circle'></i>
                          </div>
                        </fieldset>
                      </div>
                      <div class="col-md-3 form-group">
                        <button type="button" class="btn btn-icon rounded-circle btn-outline-danger mr-1 mb-1" id="deleteblackoutdate_1_1" onclick="deleteblackoutdate(1, 1)">
                          <i class="bx bx-trash"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 form-group">
                    <button type="button" id="addblackoutdate_1" class="btn btn-outline-primary mr-1 mb-1" onclick="addblackoutdate(1)">
                      <i class="bx bx-plus"></i>
                      <span class="align-middle ml-25">Add</span>
                    </button>
                  </div>


                  <div class="col-md-12" id="pricelist_1">
                    @if($flag == 1)
                      <h6>Room Type</h6>
                    @elseif($flag == 2)
                      <h6>Transport Type</h6>
                    @elseif($flag == 3)
                      <h6>Activity Type</h6>
                    @elseif($flag == 4)
                      <h6>Guide Type</h6>
                    @elseif($flag == 5)
                      <h6>Type</h6>
                    @endif
                    <div class="row" id="pricinglist_1_1">
                      <input type="hidden" id="priceID_1_1" name="priceID[0][]" value="" />
                      <div class="col-md-3">
                        <fieldset class="form-group position-relative has-icon-left">
                          <select class="select2 form-control" id="tag_1_1" name="tag[0][]">
                            @foreach($category_tag as $item)
                              <option value="{{$item->id}}">{{ $item->title }}</option>
                            @endforeach
                          </select>
                          <div class="form-control-position">
                            <i class='bx bx-search'></i>
                          </div>
                        </fieldset>
                      </div>
                      <div class="col-md-3">
                        <fieldset class="form-group position-relative has-icon-left">
                          <input type="text" class="form-control" id="description_1_1" name="description[0][]" value="" placeholder="Description">
                          <div class="form-control-position">
                            <i class='bx bx-info-circle'></i>
                          </div>
                        </fieldset>
                      </div>
                      <div class="col-md-3">
                        <fieldset class="form-group position-relative has-icon-left">
                          <input type="number" id="price_1_1" name="price[0][]" class="touchspin-icon" value="" data-bts-step="0.5" data-bts-decimals="2" data-bts-prefix="$" placeholder="Price" min="0">
                        </fieldset>
                      </div>
                      <div class="col-md-3 form-group">
                        <button type="button" class="btn btn-icon rounded-circle btn-outline-danger mr-1 mb-1" id="deleteprice_1_1" onclick="deleteprice(1, 1)">
                          <i class="bx bx-trash"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 form-group">
                    <button type="button" id="addtype_1" class="btn btn-outline-primary mr-1 mb-1" onclick="addpricetype(1)">
                      <i class="bx bx-plus"></i>
                      <span class="align-middle ml-25">Add</span>
                    </button>
                  </div>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
{{-- page styles --}}

@section('vendor-scripts')

  <script src="{{asset('vendors/js/extensions/bootstrap-treeview.min.js')}}"></script>

  <script src="{{asset('vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
  <script src="{{asset('vendors/js/forms/validation/jquery.validate.min.js')}}"></script>

  <script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>

  <script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
  <script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
  <script src="{{asset('vendors/js/pickers/pickadate/picker.time.js')}}"></script>
  <script src="{{asset('vendors/js/pickers/pickadate/legacy.js')}}"></script>
  <script src="{{asset('vendors/js/pickers/daterange/moment.min.js')}}"></script>
  <script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>

  <script src="{{asset('vendors/js/editors/quill/katex.min.js')}}"></script>
  <script src="{{asset('vendors/js/editors/quill/highlight.min.js')}}"></script>
  <script src="{{asset('vendors/js/editors/quill/quill.min.js')}}"></script>
  <script src="{{asset('vendors/js/extensions/jquery.steps.min.js')}}"></script>

  <script src="{{asset('vendors/js/extensions/dropzone.min.js')}}"></script>
  <script src="{{asset('vendors/js/ui/prism.min.js')}}"></script>

  <script src="{{asset('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')}}"></script>

  <script src="{{asset('//maps.googleapis.com/maps/api/js?key=AIzaSyBgjNW0WA93qphgZW-joXVR6VC3IiYFjfo')}}"></script>
  <script src="{{asset('vendors/js/charts/gmaps.min.js')}}"></script>

  <script src="{{asset('vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>

  <script src="{{asset('vendors/js/ckeditor/ckeditor.js')}}"></script>

  <script src="{{asset('vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
  <script src="{{asset('vendors/js/extensions/polyfill.min.js')}}"></script>

@endsection

@section('page-scripts')
  <script>
      var base_url = "{{ url('/') }}";
      var category_flag = <?php echo $flag; ?>;
      var tag = <?php echo $category_tag; ?>;
      var currency = <?php echo $currency; ?>;

      function back(){
          document.location.href=base_url + '/';
      }
  </script>
  <script src="{{asset('js/scripts/pages/product_add.js')}}"></script>
@endsection
