@extends('layouts.contentLayoutMaster')

{{-- title --}}
@section('title','Travel Quoting System | Send Itineary to Customer')
{{-- venodr style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')}}">
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
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/validation/form-validation.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/itinerary.css')}}">

<style>
  .sub-container {
    max-width: 1000px;
    margin: 0 auto;
  }
</style>
@endsection

@section('content')
<!-- Dashboard Analytics Start -->
<section>
  <div class="sub-container">
  <div class="card">
    <div class="card-header">
      <h5>Send Itinerary to Customer</h5>
    </div>
    <div class="card-content">
      <div class="card-body">@csrf
        <form class="form form-horizontal" method="post" action="{{ route('itinerary_send') }}">
          @csrf
          <input type="hidden" id="itinerary_id" name="itinerary_id" value="{{ $itinerary_id }}">
          <div class="form-body">
            <div class="row">
              <div class="col-md-2">
                <label>From Email</label>
              </div>
              <div class="col-md-4 form-group">
                <div class="position-relative has-icon-left">
                  <input type="email" id="from_email" class="form-control" name="from_email" placeholder="From Email" required  data-validation-required-message="This field is required">
                  <div class="form-control-position">
                    <i class="bx bx-mail-send"></i>
                  </div>
                </div>
              </div>
              <div class="col-md-6"></div>
              <div class="col-md-2">
                <label>To Email</label>
              </div>
              <div class="col-md-4 form-group">
                <div class="position-relative has-icon-left">
                  <input type="email" id="to_email" class="form-control" name="to_email" placeholder="To Email" value="{{ $to_email }}" required  data-validation-required-message="This field is required">
                  <div class="form-control-position">
                    <i class="bx bx-mail-send"></i>
                  </div>
                </div>
              </div>
              <div class="col-md-6"></div>
                <div class="form-group col-md-10 offset-md-2">
                  <fieldset>
                    <div class="checkbox">
                      <input type="checkbox" class="checkbox-input" id="pdf_check" name="pdf_check" value="1">
                      <label for="pdf_check">Add Itinerary as PDF</label>
                    </div>
                  </fieldset>
                </div>  
              <div class="col-12 d-flex justify-content-end ">
                <button type="submit" class="btn btn-primary mr-1 mb-1">Send</button>
                <a href="{{ route('index') }}" class="btn btn-light-secondary mr-1 mb-1">Back</a>
              </div>
              <hr />
              <div class="col-md-12">
                <div class="form-group">
                  <textarea id="email_template" name="email_template"  cols="30" rows="30" class="form-control" required  data-validation-required-message="This field is required">{{ $html }}</textarea>
                </div>
              </div>
            </div>
          </div>
        </form>
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
<script src="{{asset('vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
<script src="{{asset('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')}}"></script>
<script src="{{asset('vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('vendors/js/ckeditor/ckeditor.js')}}"></script>
@endsection

@section('page-scripts')
<script>
   var base_url = "{{ url('/') }}";
   
</script>
<script src="{{asset('js/scripts/pages/itinerary_send.js')}}"></script>  
@endsection

