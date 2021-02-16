@extends('layouts.contentLayoutMaster')

{{-- title --}}
@section('title','Travel Quoting System | CRM - Add Account')
{{-- venodr style --}}
@section('vendor-styles')

<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/validation/form-validation.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/jquery.Jcrop.min.css')}}">

<link rel="stylesheet" type="text/css" 
    href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
<!-- Font Awesome 5 -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
@endsection

@section('custom-horizontal-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/core/menu/menu-types/horizontal-menu.css')}}">
@endsection

{{-- page style --}}
@section('page-styles')
<style type="text/css">
.nounderline, .violet{
    color: #7c4dff !important;
}
.btn-dark {
    background-color: #7c4dff !important;
    border-color: #7c4dff !important;
}
.btn-dark .file-upload {
    width: 100%;
    padding: 10px 0px;
    position: absolute;
    left: 0;
    opacity: 0;
    cursor: pointer;
}
.profile-img img{
    width: 200px;
    height: 200px;
    border-radius: 50%;
}   
</style>
@endsection

@section('content')

<section id="dashboard-analytics">
    <div class="modal" id="myModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Crop Image And Upload</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="resizer"></div>
                    <button class="btn rotate float-lef" data-deg="90" > 
                    <i class="fas fa-undo"></i></button>
                    <button class="btn rotate float-right" data-deg="-90" > 
                    <i class="fas fa-redo"></i></button>
                    <hr>
                    <button class="btn btn-block btn-dark" id="upload" > 
                        Crop And Upload
                    </button>
                </div>
            </div>
        </div>
    </div>
    <form class="form-horizontal" method="post" action="../add_account" novalidate>
        @csrf
        <div class="card">
            <div class="card-header" style="padding-bottom: 0;">
                <h3>Add Account</h3>
            </div> 
            <hr>
            <input type="hidden" name="avatar_path" id="avatar_path">
            <div class="card-content">
                <div class="card-body">
                    <div class="media mb-2">
                        <a class="mr-2" href="javascript:void(0)">
                            <img src="{{asset('assets/img/avatar.png')}}" id="profile-pic" alt="users avatar"
                                class="users-avatar-shadow rounded-circle" height="64" width="64">
                        </a>
                        <div class="btn btn-dark" style="margin-top: 15px;">
                            <input type="file" class="file-upload" id="file-upload" 
                                name="profile_picture" accept="image/*">
                                Upload New Photo
                        </div>
                    </div>
                    <form novalidate>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>Username</label>
                                        <input type="text" class="form-control" placeholder="Username"
                                            data-validation-required-message="This username field is required" 
                                            name="username" id="username" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Account Type</label>
                                    <select class="form-control" name="account_type" id="account_type">
                                        <option value="3">Supplier</option>
                                        <option value="4">Staff</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" placeholder="Frist Name" required 
                                            data-validation-required-message="This first name field is required"
                                            name="first_name" id="first_name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" placeholder="Last Name" required 
                                            data-validation-required-message="This last name field is required"
                                            name="last_name" id="last_name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Company</label>
                                    <input type="text" class="form-control" placeholder="Company name" name="comapny_name" id="company_name">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <div class="controls">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password" required
                                        data-validation-required-message="The password field is required" minlength="6">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>Confirm Password</label>
                                        <input type="password" name="con-password" class="form-control" placeholder="Confirm Password"
                                            required data-validation-match-match="password"
                                            data-validation-required-message="The Confirm password field is required" minlength="6">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <h6 style="font-weight: 500; padding-bottom: 20px; padding-top: 20px;" >Main Information</h6>
                            </div>
                            <div class="col-12 col-sm-6">
                                <h6 style="font-weight: 500; padding-bottom: 20px; padding-top: 20px;">Company Information</h6>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>State/Region</label>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <select class="select2 form-control" id="main_region_state" name="main_region_state" >
                                                <option value="">- Region/State -</option>
                                                @foreach($regions as $region)
                                                <option value="{{$region->id}}">{{$region->title}}</option>
                                                @endforeach
                                            </select>
                                            <div class="form-control-position">
                                                <i class="bx bxs-map"></i>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>State/Region</label>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <select class="select2 form-control" id="billing_region_state" name="billing_region_state">
                                            <option value="">- Region/State -</option>
                                            @foreach($regions as $region)
                                            <option value="{{$region->id}}">{{$region->title}}</option>
                                            @endforeach
                                        </select>
                                        <div class="form-control-position">
                                            <i class="bx bxs-map"></i>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>Country</label>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <select class="select2 form-control" id="main_country" name="main_country" >
                                                <option value="">- Country -</option>
                                                @foreach($countries as $country)
                                                <option value="{{$country->id}}">{{$country->title}}</option>
                                                @endforeach
                                            </select>
                                            <div class="form-control-position">
                                                <i class="bx bxs-flag-alt"></i>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Country</label>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <select class="select2 form-control" id="billing_country" name="billing_country">
                                            <option value="">- Country -</option>
                                            @foreach($countries as $country)
                                            <option value="{{$country->id}}">{{$country->title}}</option>
                                            @endforeach
                                        </select>
                                        <div class="form-control-position">
                                            <i class="bx bxs-flag-alt"></i>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>City</label>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <select class="select2 form-control" id="main_city" name="main_city" >
                                                <option value="">- City -</option>
                                                @foreach($cities as $city)
                                                <option value="{{$city->id}}">{{$city->title}}</option>
                                                @endforeach
                                            </select>
                                            <div class="form-control-position">
                                                <i class="bx bxs-city"></i>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>City</label>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <select class="select2 form-control" id="billing_city" name="billing_city">
                                            <option value="">- City -</option>
                                            @foreach($cities as $city)
                                            <option value="{{$city->id}}">{{$city->title}}</option>
                                            @endforeach
                                        </select>
                                        <div class="form-control-position">
                                            <i class="bx bxs-city"></i>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>Street Address</label>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <div class="controls">
                                                <input type="text" class="form-control" id="main_street_address" name="main_street_address"
                                                    placeholder="Street Address">
                                            </div>
                                            <div class="form-control-position">
                                                <i class="bx bx-street-view"></i>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>  
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Street Address</label>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <div class="controls">
                                            <input type="text" class="form-control" id="billing_street_address" name="billing_street_address"
                                                placeholder="Street Address">
                                        </div>
                                        <div class="form-control-position">
                                            <i class="bx bx-street-view"></i>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>Office Phone</label>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <div class="controls">
                                                <input type="text" class="form-control" id="main_office_phone" name="main_office_phone"
                                                    placeholder="Office Phone" >
                                            </div>
                                            <div class="form-control-position">
                                                <i class="bx bx-mobile"></i>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Office Phone</label>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <div class="controls">
                                            <input type="text" class="form-control" id="billing_office_phone" name="billing_office_phone"
                                                placeholder="Office Phone">
                                        </div>
                                        <div class="form-control-position">
                                            <i class="bx bx-mobile"></i>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>Main Email</label>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <div class="controls">
                                                <input type="email" class="form-control" id="main_email" name="main_email"
                                                    placeholder="Main Email" data-validation-required-message="This name field is required" required>
                                            </div>
                                            <div class="form-control-position">
                                                <i class="bx bx-mail-send"></i>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Billing Email</label>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <div class="controls">
                                            <input type="email" class="form-control" id="billing_email" name="billing_email"
                                                placeholder="Billing Email">
                                        </div>
                                        <div class="form-control-position">
                                            <i class="bx bx-mail-send"></i>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Add Account</button>
                                <button type="reset" onClick="back()" class="btn btn-light">Cancel</button>
                            </div>
                            
                        </div>
                    </form>
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
<script src="{{asset('js/scripts/jquery.Jcrop.min.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" 
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" 
    crossorigin="anonymous"></script>
<!-- Boostrap 4 -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.js"></script>
@endsection

@section('page-scripts')
<script>
    var base_url = "{{ url('/crm') }}";
    function back(){
        document.location.href=base_url + '/';
    }
</script>
<script src="{{asset('js/scripts/pages/crm_account.js')}}"></script>
@endsection
