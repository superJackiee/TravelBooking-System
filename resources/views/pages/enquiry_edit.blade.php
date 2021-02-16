@extends('layouts.contentLayoutMaster')

{{-- title --}}
@section('title','Dashboard Analytics')
{{-- venodr style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/dragula.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
@endsection

@section('custom-horizontal-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/core/menu/menu-types/horizontal-menu.css')}}">
@endsection

{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/dashboard-analytics.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/validation/form-validation.css')}}">
@endsection

@section('content')
<!-- Dashboard Analytics Start -->
<section id="dashboard-analytics">
    <!-- @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif -->
    <form class="form-horizontal" method="post" action="{{route('save_enquiry')}}" novalidate>
        @csrf
        <input type="hidden" id="enquiry_id" name="enquiry_id" value="{{$custom_enquiry->id}}">
        <div class="card">
            <div class="card-header" style="padding-bottom: 0;">
                <h3>Edit an enquiry</h3>
            </div> 
            <hr>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Title</h6>
                            <fieldset class="form-group position-relative has-icon-left">
                                <div class="controls">
                                    <input type="text" class="form-control" id="title" name="title" value="{{$custom_enquiry->title}}" required
                                        placeholder="Enquery Title" data-validation-required-message="This title field is required">
                                </div>
                                <div class="form-control-position">
                                    <i class="bx bx-purchase-tag-alt"></i>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <div style="display: flex;">
                                <h6>Customer Name</h6>&nbsp;&nbsp;&nbsp;
                                <i class="bx bx-user"></i>
                            </div>
                            <div class="form-group">
                                <div class="controls">
                                    <select class="select2 form-control" id="accound_id" name="account_id" required data-validation-required-message="This title field is required">
                                        <option value="">--- Please select customer ---</option>
                                        @foreach($account as $each_one)
                                            @if($custom_enquiry->account_id == $each_one->id)
                                                <option value="{{$each_one->id}}" selected>{{$each_one->first_name.' '.$each_one->last_name}}, {{$each_one->main_email}}, {{$each_one->get_account_type->title}}</option>
                                            @else
                                            <option value="{{$each_one->id}}">{{$each_one->first_name.' '.$each_one->last_name}}, {{$each_one->main_email}}, {{$each_one->get_account_type->title}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>Pick up duration</h6>
                            <fieldset class="form-group position-relative has-icon-left">
                                
                                <input type="text" class="form-control showdropdowns" placeholder="Select Date" id="duration" name="duration" value="<?php
                                $substr = explode('-', $custom_enquiry->from_date);
                                $from_date = $substr[1].'/'.$substr[2].'/'.$substr[0];
                                $substr = explode('-', $custom_enquiry->to_date);
                                $to_date = $substr[1].'/'.$substr[2].'/'.$substr[0];
                                echo $from_date.' - '.$to_date;
                                ?>">
                                <div class="form-control-position">
                                    <i class='bx bx-calendar-check'></i>
                                </div>
                            </fieldset>
                            <p id="num_days"></p>
                        </div>
                        <div class="col-md-6">
                            <h6>Budget</h6>
                            <ul class="list-unstyled mb-0">
                                @if($custom_enquiry->budget_per_total == 1)
                                <li class="d-inline-block mt-1 mb-1 mr-2">
                                    <fieldset>
                                    <div class="radio radio-shadow">
                                        <input type="radio" id="radioshadow1" name="budget_per_total" value="per_person" checked>
                                        <label for="radioshadow1" style="font-size: 12px;">Per Person</label>
                                    </div>
                                    </fieldset>
                                </li>
                                <li class="d-inline-block mb-1 mt-1 mr-2">
                                    <fieldset>
                                    <div class="radio radio-shadow">
                                        <input type="radio" id="radioshadow2" value="total" name="budget_per_total">
                                        <label for="radioshadow2" style="font-size: 12px;">Total</label>
                                    </div>
                                    </fieldset>
                                </li>
                                @elseif($custom_enquiry->budget_per_total == 0)
                                <li class="d-inline-block mt-1 mb-1 mr-2">
                                    <fieldset>
                                    <div class="radio radio-shadow">
                                        <input type="radio" id="radioshadow1" name="budget_per_total" value="per_person">
                                        <label for="radioshadow1" style="font-size: 12px;">Per Person</label>
                                    </div>
                                    </fieldset>
                                </li>
                                <li class="d-inline-block mb-1 mt-1 mr-2">
                                    <fieldset>
                                    <div class="radio radio-shadow">
                                        <input type="radio" id="radioshadow2" value="total" name="budget_per_total" checked>
                                        <label for="radioshadow2" style="font-size: 12px;">Total</label>
                                    </div>
                                    </fieldset>
                                </li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h6>Adults Number:</h6>
                                <input type="number" class="touchspin" id="adults_num" name="adults_num" value="{{$custom_enquiry->adult_number}}">
                            </div>
                            <p id="traveler_total" style="padding-top: 30px;">Total travelers: 0</p>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h6>Children Number:</h6>
                                <input type="number" class="touchspin" id="children_num" name="children_num" value="{{$custom_enquiry->children_number}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <h6>Price($)</h6>
                                <input type="text" class="touchspin" data-bts-step="0.5" data-bts-decimals="2" data-bts-prefix="$" name="budget" value="{{$custom_enquiry->budget}}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <h6>Single Rooms:</h6>
                                <div class="d-inline-block mb-1 mr-1">
                                    <input type="number" class="touchspin" id="single_room" name="single_room" value="{{$custom_enquiry->single_count}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <h6>Double Rooms:</h6>
                                <div class="d-inline-block mb-1 mr-1">
                                    <input type="number" class="touchspin" id="double_room" name="double_room" value="{{$custom_enquiry->double_count}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <h6>Twin Rooms:</h6>
                                <div class="d-inline-block mb-1 mr-1">
                                    <input type="number" class="touchspin" id="twin_room" name="twin_room" value="{{$custom_enquiry->twin_count}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <h6>Triple Rooms:</h6>
                                <div class="d-inline-block mb-1 mr-1">
                                    <input type="number" class="touchspin" id="triple_room" name="triple_room" value="{{$custom_enquiry->triple_count}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <h6>Family Rooms:</h6>
                                <div class="d-inline-block mb-1 mr-1">
                                    <input type="number" class="touchspin" id="family_room" name="family_room" value="{{$custom_enquiry->family_count}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <h6 id="number_rooms"></h6>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <h6>Note </h6>
                                <textarea class="form-control" id="horizontalTextarea" rows="5" placeholder="Please type note about enquiry." name="note">{{$custom_enquiry->note}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <fieldset>
                                <div class="checkbox checkbox-primary">
                                    @if($custom_enquiry->is_assigned == 1)
                                    <input type="checkbox" id="is_assigned" name="is_assigned" checked>
                                    @else
                                    <input type="checkbox" id="is_assigned" name="is_assigned">
                                    @endif
                                    <label for="is_assigned">Assigned to(user)</label>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                @if($custom_enquiry->is_assigned == 1)
                                <select class="select2 form-control" id="assigned_user" name="assigned_user">
                                @else
                                <select class="select2 form-control" id="assigned_user" name="assigned_user" disabled>
                                @endif
                                    <option value="">--- Please select user ---</option>
                                    @foreach($account as $each_one)
                                        @if($each_one->get_account_type->title == 'Staff')
                                            @if($each_one->id == $custom_enquiry->assigned_user)
                                                <option value="{{$each_one->id}}" selected>{{$each_one->fisrt_name.' '.$each_one->last_name}}, {{$each_one->main_email}}, {{$each_one->get_account_type->title}}</option>
                                            @else
                                                <option value="{{$each_one->id}}">{{$each_one->fisrt_name.' '.$each_one->last_name}}, {{$each_one->main_email}}, {{$each_one->get_account_type->title}}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 d-flex justify-content-end mb-3">
                            <button type="submit" class="btn btn-primary mr-1 mb-1">Save</button>
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
<script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.time.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/legacy.js')}}"></script>
<script src="{{asset('vendors/js/pickers/daterange/moment.min.js')}}"></script>
<script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
<script src="{{asset('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')}}"></script>
<script src="{{asset('vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
@endsection

@section('page-scripts')
<script>
    var custom_enquiry = <?php echo json_encode($custom_enquiry)?>;
    var base_url = "{{ url('/') }}";
    function back(){
        document.location.href=base_url + '/';
    }
</script>
<script src="{{asset('js/scripts/pages/page-enquiry.js')}}"></script>
@endsection
