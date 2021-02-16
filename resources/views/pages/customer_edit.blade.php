@extends('layouts.contentLayoutMaster')

{{-- title --}}
@section('title','Dashboard Analytics')
{{-- venodr style --}}
@section('vendor-styles')

<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/validation/form-validation.css')}}">
@endsection

@section('custom-horizontal-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/core/menu/menu-types/horizontal-menu.css')}}">
@endsection

{{-- page style --}}
@section('page-styles')
@endsection
@section('content')

<section id="dashboard-analytics">
    <form class="form-horizontal" method="post" action="../update_account" novalidate>
        @csrf
        <div class="card">
            <div class="card-header" style="padding-bottom: 0;">
                <h3>Edit Customer</h3>
            </div> 
            <hr>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>First Name</h6>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <div class="controls">
                                            <input type="hidden" id="account_id" name="account_id" value="{{$customer->id}}">
                                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{$customer->first_name}}" required
                                                placeholder="First Name" data-validation-required-message="This first name field is required">
                                        </div>
                                        <div class="form-control-position">
                                            <i class="bx bx-purchase-tag-alt"></i>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <h6>Last Name</h6>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <div class="controls">
                                            <input type="hidden" id="account_id" name="account_id" value="{{$customer->id}}">
                                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{$customer->last_name}}" required
                                                placeholder="Last Name" data-validation-required-message="This last name field is required">
                                        </div>
                                        <div class="form-control-position">
                                            <i class="bx bx-purchase-tag-alt"></i>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>Customer Type</h6>
                            <fieldset class="form-group position-relative has-icon-left">
                                <select class="form-control" id="account_type" name="account_type">
                                    @if($customer->account_type == 1)
                                    <option value="1" selected>Direct Customer</option>
                                    <option value="2">Operator</option>
                                    @elseif($customer->account_type == 2)
                                    <option value="1">Direct Customer</option>
                                    <option value="2" selected>Operator</option>
                                    @endif
                                </select>
                                <div class="form-control-position">
                                    <i class="bx bxs-group"></i>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6" style="padding-bottom: 20px; padding-top: 20px;">
                            <h6 style="font-weight: 500">Main Information</h6>
                        </div>
                        <div class="col-md-6" style="padding-bottom: 20px; padding-top: 20px;">
                            <h6 style="font-weight: 500">Company Information</h6>
                        </div>
                        
                        <div class="col-md-6">
                            <h6>State/Region</h6>
                            <fieldset class="form-group position-relative has-icon-left">
                                <select class="select2 form-control" id="main_region_state" name="main_region_state" >
                                    <option value="">- Region/State -</option>
                                    @foreach($regions as $region)
                                    @if($region->id == $customer->main_region_state)
                                    <option value="{{$region->id}}" selected>{{$region->title}}</option>
                                    @else
                                    <option value="{{$region->id}}">{{$region->title}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <div class="form-control-position">
                                    <i class="bx bxs-map"></i>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <h6>State/Region</h6>
                            <fieldset class="form-group position-relative has-icon-left">
                                <select class="select2 form-control" id="billing_region_state" name="billing_region_state" disabled>
                                    <option value="">- Region/State -</option>
                                    @foreach($regions as $region)
                                    @if($region->id == $customer->billing_state_region)
                                    <option value="{{$region->id}}" selected>{{$region->title}}</option>
                                    @else
                                    <option value="{{$region->id}}">{{$region->title}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <div class="form-control-position">
                                    <i class="bx bxs-map"></i>
                                </div>
                            </fieldset>
                        </div>

                        <div class="col-md-6">
                            <h6>Country</h6>
                            <fieldset class="form-group position-relative has-icon-left">
                                <select class="select2 form-control" id="main_country" name="main_country" >
                                    <option value="">- Country -</option>
                                    @foreach($countries as $country)
                                    @if($country->id == $customer->main_country)
                                    <option value="{{$country->id}}" selected>{{$country->title}}</option>
                                    @else
                                    <option value="{{$country->id}}">{{$country->title}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <div class="form-control-position">
                                    <i class="bx bxs-flag-alt"></i>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <h6>Country</h6>
                            <fieldset class="form-group position-relative has-icon-left">
                                <select class="select2 form-control" id="billing_country" name="billing_country" disabled>
                                    <option value="">- Country -</option>
                                    @foreach($countries as $country)
                                    @if($country->id == $customer->billing_country)
                                    <option value="{{$country->id}}" selected>{{$country->title}}</option>
                                    @else
                                    <option value="{{$country->id}}">{{$country->title}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <div class="form-control-position">
                                    <i class="bx bxs-flag-alt"></i>
                                </div>
                            </fieldset>
                        </div>
                        
                        <div class="col-md-6">
                            <h6>City</h6>
                            <fieldset class="form-group position-relative has-icon-left">
                                <select class="select2 form-control" id="main_city" name="main_city" >
                                    <option value="">- City -</option>
                                    @foreach($cities as $city)
                                    @if($city->id == $customer->main_city)
                                    <option value="{{$city->id}}" selected>{{$city->title}}</option>
                                    @else
                                    <option value="{{$city->id}}">{{$city->title}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <div class="form-control-position">
                                    <i class="bx bxs-city"></i>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <h6>City</h6>
                            <fieldset class="form-group position-relative has-icon-left">
                                <select class="select2 form-control" id="billing_city" name="billing_city" disabled>
                                    <option value="">- City -</option>
                                    @foreach($cities as $city)
                                    @if($city->id == $customer->billing_city)
                                    <option value="{{$city->id}}" selected>{{$city->title}}</option>
                                    @else
                                    <option value="{{$city->id}}">{{$city->title}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <div class="form-control-position">
                                    <i class="bx bxs-city"></i>
                                </div>
                            </fieldset>
                        </div>
                        
                        <div class="col-md-6">
                            <h6>Street Address</h6>
                            <fieldset class="form-group position-relative has-icon-left">
                                <div class="controls">
                                    <input type="text" class="form-control" id="main_street_address" name="main_street_address" value="{{$customer->main_street_address}}"
                                        placeholder="Street Address">
                                </div>
                                <div class="form-control-position">
                                    <i class="bx bx-street-view"></i>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <h6>Street Address</h6>
                            <fieldset class="form-group position-relative has-icon-left">
                                <div class="controls">
                                    <input type="text" class="form-control" id="billing_street_address" name="billing_street_address" value="{{$customer->billing_street_address}}"
                                        placeholder="Street Address" disabled>
                                </div>
                                <div class="form-control-position">
                                    <i class="bx bx-street-view"></i>
                                </div>
                            </fieldset>
                        </div>

                        <div class="col-md-6">
                            <h6>Office Phone</h6>
                            <fieldset class="form-group position-relative has-icon-left">
                                <div class="controls">
                                    <input type="text" class="form-control" id="main_office_phone" name="main_office_phone" value="{{$customer->main_office_phone}}"
                                        placeholder="Office Phone" >
                                </div>
                                <div class="form-control-position">
                                    <i class="bx bx-mobile"></i>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <h6>Office Phone</h6>
                            <fieldset class="form-group position-relative has-icon-left">
                                <div class="controls">
                                    <input type="text" class="form-control" id="billing_office_phone" name="billing_office_phone" value="{{$customer->billing_office_phone}}"
                                        placeholder="Office Phone" disabled>
                                </div>
                                <div class="form-control-position">
                                    <i class="bx bx-mobile"></i>
                                </div>
                            </fieldset>
                        </div>

                        <div class="col-md-6">
                            <h6>Main Email</h6>
                            <fieldset class="form-group position-relative has-icon-left">
                                <div class="controls">
                                    <input type="email" class="form-control" id="main_email" name="main_email" value="{{$customer->main_email}}"
                                        placeholder="Main Email" data-validation-required-message="This name field is required" required>
                                </div>
                                <div class="form-control-position">
                                    <i class="bx bx-mail-send"></i>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <h6>Billing Email</h6>
                            <fieldset class="form-group position-relative has-icon-left">
                                <div class="controls">
                                    <input type="email" class="form-control" id="billing_email" name="billing_email"  value="{{$customer->billing_email}}"
                                        placeholder="Billing Email" disabled>
                                </div>
                                <div class="form-control-position">
                                    <i class="bx bx-mail-send"></i>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-sm-10 d-flex justify-content-end mt-2 ml-2 mb-1">
                            <button type="submit" class="btn btn-primary mr-1 mb-1">Update</button>
                            <button type="reset" onClick="back()" class="btn btn-light-secondary mr-1 mb-1" >Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
  </section>
  <!-- Dashboard Analytics end -->
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
@endsection

@section('page-scripts')
<script>
    var customer = <?php echo json_encode($customer)?>;
    var base_url = "{{ url('/crm') }}";
    function back(){
        document.location.href=base_url + '/';
    }
</script>
<script src="{{asset('js/scripts/pages/crm_customer.js')}}"></script>
@endsection
