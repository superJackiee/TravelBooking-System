@extends('layouts.contentLayoutMaster')

{{-- title --}}
@section('title','Travel Quoting System | Create Itineary(Basic)')
{{-- venodr style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
@endsection
@section('custom-horizontal-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/core/menu/menu-types/horizontal-menu.css')}}">
@endsection

{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/dashboard-analytics.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/animate/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/wizard.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/validation/form-validation.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/itinerary.css')}}">
@endsection

@section('content')
<!-- Dashboard Analytics Start -->
<section>
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
 
  <div class="card">
    <div class="card-header">
      <h5>Ref.No:
        <?php
        $str = "I";
        for($i = 1; $i < strlen($enquiry->reference_number); $i ++)
        {
          $str[$i] = $enquiry->reference_number[$i];
        }
        echo $str;
          ?>
        </h5>
    </div>
    <div class="card-content">
      <div class="card-body">
        <form class="form-horizontal" method="post" action="{{route('itinerary_create_basic.with_enquiry_id')}}" novalidate>
          @csrf
          <input type="hidden" name="enquiry_id" value="{{$enquiry->id}}">
          <div class="row">
            <div class="col-md-6 col-sm-6">
              <h6>Itinerary Title</h6>
              <fieldset class="form-group position-relative has-icon-left">
                  <div class="controls">
                      <input type="text" class="form-control" id="title" name="title" placeholder="Itinerary Title" required data-validation-required-message="This Title field is required" aria-invalid="false">
                  </div>
                  <div class="form-control-position">
                      <i class="bx bx-purchase-tag-alt"></i>
                  </div>
              </fieldset>
            </div>
						
            <div class="col-md-2 col-sm-2">
              <h6>Pick up duration</h6>
              <fieldset class="form-group position-relative has-icon-left">
									<div class="controls">
										<input type="text" class="form-control showdropdowns" placeholder="Select duration" id="duration" name="duration" required data-validation-required-message="This Duration field is required" aria-invalid="false">
									</div>
                  <div class="form-control-position">
                      <i class='bx bx-calendar-check'></i>
                  </div>
              </fieldset>
            </div>
            <div class="col-md-2 col-sm-2">
                <h6>Adults Number:</h6>
                <div class="d-inline-block mb-1 mr-1">
                    <input type="number" class="touchspin" value="0" id="adults_num" name="adults_num" required data-validation-required-message="This Title field is required" aria-invalid="false">
                </div>
            </div>
            <div class="col-md-2 col-sm-2">
                <h6>Children Number:</h6>
                <div class="d-inline-block mb-1 mr-1">
                    <input type="number" class="touchspin" value="0" id="children_num" name="children_num">
                </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2 col-sm-2">
             	<h6>Single Rooms:</h6>
				<div class="d-inline-block mb-1 mr-1">
					<input type="number" class="touchspin" value="0" id="single_room" name="single_room">
				</div>
            </div>
            <div class="col-2 col-sm-2">
				<h6>Double Rooms:</h6>
				<div class="d-inline-block mb-1 mr-1">
					<input type="number" class="touchspin" value="0" id="double_room" name="double_room">
				</div>
            </div>
            <div class="col-2 col-sm-2">
				<h6>Twin Rooms:</h6>
				<div class="d-inline-block mb-1 mr-1">
					<input type="number" class="touchspin" value="0" id="twin_room" name="twin_room">
				</div>
            </div>
            <div class="col-2 col-sm-2">
				<h6>Triple Rooms:</h6>
				<div class="d-inline-block mb-1 mr-1">
					<input type="number" class="touchspin" value="0" id="triple_room" name="triple_room">
				</div>
            </div>
            <div class="col-2 col-sm-2">
				<h6>Family Rooms:</h6>
				<div class="d-inline-block mb-1 mr-1">
					<input type="number" class="touchspin" value="0" id="family_room" name="family_room">
				</div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-sm-12 col-md-12">
              <h6>Note:</h6>
              <textarea class="form-control" rows="6" placeholder="Please type note about enquiry." id="note" name="note"></textarea>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-sm-12 d-flex justify-content-end">
              <button type="submit" class="btn btn-primary mr-1 mb-1">Next</button>
              <a href="{{ route('index') }}" class="btn btn-light-secondary mr-1 mb-1">Back</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
  <!-- Dashboard Analytics end -->
@endsection
{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/extensions/jquery.steps.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
<script src="{{asset('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.time.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/legacy.js')}}"></script>
<script src="{{asset('vendors/js/pickers/daterange/moment.min.js')}}"></script>
<script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
<script src="{{asset('vendors/js/ckeditor/ckeditor.js')}}"></script>
@endsection

@section('page-scripts')
<script>
  var msg = <?php if(json_encode(session()->get('msg'))) echo json_encode(session()->get('msg'));  ?>;
</script>
<script src="{{asset('js/scripts/pages/itinerary_basic.js')}}"></script>  
@endsection

