@extends('layouts.contentLayoutMaster')

{{-- title --}}
@section('title','Travel Quoting System | Create Itineary(Basic)')
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
@endsection

@section('content')
<!-- Dashboard Analytics Start -->
<section>
  <div class="card">
    <div class="card-header">
      <h5>Complete Itinerary</h5>
    </div>
    <div class="card-content">
      <div class="card-body">
        <form class="form-horizontal" method="post" action="{{route('itinerary_complete_with_budget')}}">
          @csrf
          <input type="hidden" name="itinerary_id" value="{{$itinerary_id}}">
          <div class="row">
            <div class="col-md-4 col-sm-6" id="budget_div">
              <h6>Budget</h6>
              
              @foreach($budget as $key => $val)
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" class="form-control" value="{{ $key }}" readonly>
                  </div>    
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" class="form-control" value="{{ $val }}" readonly>
                  </div>    
                </div>
              </div>
              @endforeach
            </div>
            <div class="col-md-2 col-sm-4">
              <h6>Currency</h6>
              <fieldset class="form-group position-relative has-icon-left">
									<div class="controls">
                    <select class="form-control" id="currency" name="currency" required data-validation-required-message="This field is required">
                        @foreach($currency as $item)
                          <option value="{{$item->title}}">{{ $item->title }}</option>
                        @endforeach
                    </select>
									</div>
                  <div class="form-control-position">
                      <i class='bx bx-calendar-check'></i>
                  </div>
              </fieldset>
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="form-group">
                  <button type="button" class="btn btn-primary" id="currency_converter" style="margin-top: 26px;">Currency Converter</button>
                </div>
            </div>
            <div class="col-md-2 col-sm-4" id="margin_price_container">
              <h6>Profit Price(%)</h6>
              <fieldset class="form-group position-relative has-icon-left">
									<div class="controls">
                    <input type="number" class="form-control" id="margin_price" name="margin_price" value="" placeholder="Please enter Profit Price." min="0" required data-validation-required-message="This field is required" aria-invalid="false">
									</div>
                  <div class="form-control-position">
                      <i class='bx bx-purchase-tag-alt'></i>
                  </div>
              </fieldset>
            </div>
            <div class="col-md-2 d-flex align-item-center">
                <div class="form-group">
                  <button type="submit" id="save_btn" class="btn btn-primary mr-1" style="margin-top: 26px;">Save</button>
                </div>
                <div class="form-group">
                  <a href="{{ route('itinerary_add_daily', [$itinerary_id]) }}" class="btn btn-danger" style="margin-top: 26px; margin-right: 20px;">Back</a>
                </div>
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
<script src="{{asset('vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
@endsection

@section('page-scripts')
<script>
   var base_url = "{{ url('/') }}";
   var budget = <?php echo json_encode($budget)?>;
</script>
<script src="{{asset('js/scripts/pages/itinerary_complete.js')}}"></script>  
@endsection

