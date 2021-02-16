@extends('layouts.contentLayoutMaster')

{{-- title --}}
@section('title','Dashboard')
{{-- venodr style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap.min.css')}}">

@endsection
@section('custom-horizontal-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/core/menu/menu-types/horizontal-menu.css')}}">
@endsection

{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/dashboard-analytics.css')}}">

@endsection

@section('content')
<!-- Dashboard Analytics Start -->

<section id="dashboard-analytics">
  <div class="row">
    <!-- Greetings Content Starts -->
    <div class="col-xl-3 col-12 dashboard-users">
      <div class="row  ">
        <!-- Statistics Cards Starts -->
        <div class="col-12">
          <div class="row">
            <div class="col-sm-6 col-12 dashboard-users-success">
              <div class="card text-center" onclick="window.location.href='/create_enquiry'">
                <div class="card-content">
                  <div class="card-body py-1">
                    <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50" style="margin-top: 16px;">
                      <!-- <i class="bx bx-briefcase-alt font-medium-5"></i> -->
                      <i class="bx bx-help-circle font-medium-5"></i>
                    </div>
                    <div class="text-muted line-ellipsis" style="margin-bottom: 15px;"><h7>Create Enquiry</h7></div>
                    <!-- <h3 class="mb-0">{{count($enquiries)}}</h3> -->
                    <!-- <button type="button" class="btn btn-outline-success round" onclick="window.location.href='/create_enquiry'">Create</button> -->
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-12 dashboard-users-danger">
              <div class="card text-center" onclick="window.location.href='/crm'">
                <div class="card-content">
                  <div class="card-body py-1">
                    <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50" style="margin-top: 16px;">
                      <i class="bx bx-user font-medium-5"></i>
                    </div>
                    <div class="text-muted line-ellipsis" style="margin-bottom: 15px;"><h7>CRM</h7></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-12 dashboard-users-warning">
              <div class="card text-center">
                <div class="card-content">
                  <div class="card-body py-1">
                    <div class="badge-circle badge-circle-lg badge-circle-light-warning mx-auto mb-50" style="margin-top: 16px;">
                      <i class="bx bx-cog font-medium-5"></i>
                    </div>
                    <div class="text-muted line-ellipsis" style="margin-bottom: 15px;"><h7>Setting</h7></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-12 dashboard-users-info">
              <div class="card text-center" onclick="window.location.href='/product'">
                <div class="card-content">
                  <div class="card-body py-1">
                    <div class="badge-circle badge-circle-lg badge-circle-light-info mx-auto mb-50" style="margin-top: 16px;">
                      <i class="bx bxs-gift font-medium-5"></i>
                    </div>
                    <div class="text-muted line-ellipsis" style="margin-bottom: 15px;"><h7>Product</h7></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Revenue Growth Chart Starts -->
      </div>
    </div>
    <div class="col-md-5 col-sm-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="card-title">Website Analytics</h4>
          <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
        </div>
        <div class="card-content">
          <div class="card-body">
            <div id="analytics-bar-chart"></div>
          </div>
        </div>
      </div>

    </div>
    <!-- Multi Radial Chart Starts -->
    <div class="col-xl-4 col-md-6 col-12 dashboard-visit">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="card-title">Visits of 2019</h4>
          <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
        </div>
        <div class="card-content">
          <div class="card-body">
            <div id="multi-radial-chart"></div>
            <ul class="list-inline d-flex justify-content-around mb-0">
              <li> <span class="bullet bullet-xs bullet-primary mr-50"></span>Target</li>
              <li> <span class="bullet bullet-xs bullet-danger mr-50"></span>Mart</li>
              <li> <span class="bullet bullet-xs bullet-warning mr-50"></span>Ebay</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="row">
    <div class="col-12 col-xl-12">
      <div class="card">
        <div class="card-header" style="border-left: 5px solid #ffdede">
          <h5 class="card-title" style="color: #FF5B5C">Task List</h5>
          <div class="heading-elements">
            <ul class="list-inline">
              <li><span class="badge badge-pill badge-light-danger">
                <?php
                  $count_not_created = 0;
                  for($i = 0; $i < count($enquiries); $i ++)
                    if($enquiries[$i]->is_created_itinerary == 0)
                      $count_not_created ++;
                  echo $count_not_created;
                ?>
                Enquiries
              </span></li>
              <li><i class="bx bx-dots-vertical-rounded font-medium-3 align-middle"></i></li>
            </ul>
          </div>
        </div>
        <!-- datatable start -->
        <div class="card-content">
          <div class="card-body">
            <div class="invoice-list-wrapper">
              <div class="action-dropdown-btn d-none">
                <div class="dropdown invoice-filter-action"></div>
              </div>
              <div class="table-responsive">
                <table id="task_table" class="table invoice-data-table dt-responsive nowrap">
                  <thead>
                    <tr>
                      <th></th>
                      <th></th>
                      <th>Title</th>
                      <th>Ref.No</th>
                      <th>Customer Name</th>
                      <th>Created By</th>
                      <th>Updated By</th>
                      <th>Travelers</th>
                      <th>Budget</th>
                      <th>Duration</th>
                      <th>Rooms</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($enquiries as $enquiry)
                  <tr>
                    <td></td>
                    <td></td>

                    <td class="text-bold-600">{{$enquiry->title}}</td>

                    <td>{{$enquiry->reference_number}}</td>

                    <td>{{$enquiry->get_account->first_name.' '.$enquiry->get_account->last_name}}</td>
                    <td>{{$enquiry->get_created_by->first_name.' '.$enquiry->get_created_by->last_name}}</td>
                    <td>
                      @if(!empty($enquiry->get_updated_by))
                        {{ $enquiry->get_updated_by->first_name.' '.$enquiry->get_updated_by->last_name}}
                      @else
                        ---
                      @endif

                    </td>
                    <td class="text-bold-600"><span>{{$enquiry->travel_number}}</span>
                    </td>
                    <td class="text-bold-600">
                      {{$enquiry->budget}}
                      @if($enquiry->budget_per_total)
                        (per person)
                      @else
                        (total)
                      @endif
                    </td>
                    <td>{{$enquiry->from_date}} - {{$enquiry->to_date}}</td>
                    <td>{{$enquiry->single_count + $enquiry->double_count + $enquiry->twin_count + $enquiry->triple_count + $enquiry->family_count}} rooms</td>
                    <td>
                      <div class="dropdown">
                        <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                        <div class="dropdown-menu dropdown-menu-right">
                          <a class="dropdown-item" href="../edit_enquiry/{{$enquiry->id}}"><i class="bx bx-edit-alt mr-1"></i> edit</a>
                          <a class="dropdown-item" href="javascript:void(0)" onClick="enquiry_del({{$enquiry->id}})"><i class="bx bx-trash mr-1"></i> delete</a>
                          <a class="dropdown-item" href="../itinerary_add_basic/with_enquiry_id/{{$enquiry->id}}"><i class="bx bx-trash mr-1"></i>Itinerary</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- datatable ends -->
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12 col-xl-12">
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="itinerary-tab" data-toggle="tab" href="#itinerary-pan" aria-controls="itinerary-pan" role="tab"
            aria-selected="true">
            <i class="bx bx-help-circle align-middle"></i>
            <span class="align-middle">Itinerary</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="booking-tab" data-toggle="tab" href="#booking-pan" aria-controls="booking-pan" role="tab"
            aria-selected="false">
            <i class="bx bxs-data align-middle"></i>
            <span class="align-middle">Booking</span>
          </a>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="itinerary-pan" aria-labelledby="itinerary-tab" role="tabpanel">
          <div class="card">
            <div class="card-header" style="border-left: 5px solid #ccf5f8">
              <h5 class="card-title" style="color: #00CFDD">All Itinerary</h5>
            </div>
            <div class="card-content">
              <div class="card-body">
                <div class="invoice-list-wrapper">
                      <div class="action-dropdown-btn d-none"></div>
                      <div class="table-responsive">
                        @if(count($itineraries) == 0)
                          <h5>Nothing found.</h5>
                        @else
                          <table id="itinerary_table" class="table invoice-data-table dt-responsive nowrap">
                            <thead>
                              <tr>
                                <th></th>
                                <th></th>
                                <th>Title</th>
                                <th>Staff Name</th>
                                <th>REF.NO</th>
                                <th>Budget</th>
                                <th>Margin(%)</th>
                                <th>Currency</th>
                                <th>Duration</th>
                                <th>Persons</th>
                                <th>Rooms</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                            @foreach($itineraries as $itinerary)
                              <tr>
                                <td></td>
                                <td>
                                  {{$itinerary->id}}
                                </td>
                                <td class="text-bold-500">
                                  {{$itinerary->title}}
                                </td>
                                <td>
                                  {{$itinerary->get_account->first_name.' '.$itinerary->get_account->last_name}}
                                </td>
                                <td class="text-bold-500">
                                  <span>{{$itinerary->reference_number}}</span>
                                </td>
                                <td class="text-bold-500">
                                  <span>{{$itinerary->budget}}</span>
                                </td>
                                <td class="text-bold-500">
                                  @if($itinerary->margin_price == 0)
                                    ----
                                  @else
                                    {{ $itinerary->margin_price }}(%)
                                  @endif
                                </td>
                                <td class="text-bold-500">
                                  @if($itinerary->currency == '0')
                                    ---
                                  @else
                                    {{$itinerary->currency}}
                                  @endif
                                </td>
                                <td>
                                  {{$itinerary->from_date}} - {{$itinerary->to_date}}
                                </td>
                                <td>
                                  adult({{ $itinerary->adult_number}}people), children({{ $itinerary->children_number}}people)
                                </td>
                                <td>
                                  {{$itinerary->single_count + $itinerary->double_count + $itinerary->twin_count + $itinerary->triple_count + $itinerary->family_count}} rooms
                                </td>
                                <td>
                                  <div class="dropdown">
                                    <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                                    <div class="dropdown-menu dropdown-menu-right">
                                      <a class="dropdown-item" href="{{ route('edit_itinerary', ['itinerary_id' => $itinerary->id]) }}"><i class="bx bx-edit-alt mr-1"></i> Edit</a>
                                      <a class="dropdown-item" href="javascript:void(0)" onClick="itinerary_del({{$itinerary->id}})"><i class="bx bx-trash mr-1"></i> Delete</a>
                                      <a class="dropdown-item" href="{{ route('send_itinerary', ['itinerary_id' => $itinerary->id]) }}"><i class="bx bx-trash mr-1"></i>Send Itinerary</a>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            @endforeach
                            </tbody>
                          </table>
                        @endif
                      </div>
                    </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="booking-pan" aria-labelledby="booking-tab" role="tabpanel">
          <div class="card">
            <div class="card-header" style="border-left: 5px solid #ccf5f8">
              <h5 class="card-title" style="color: #00CFDD">All Booking</h5>
            </div>
            <div class="card-content">
              <div class="card-body">

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

<script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/responsive.bootstrap.min.js')}}"></script>
@endsection

@section('page-scripts')
<script>
  var base_url = "{{ url('/') }}";
  var msg = <?php if(json_encode(session()->get('msg'))) echo json_encode(session()->get('msg'));  ?>;
</script>
<script src="{{asset('js/scripts/pages/dashboard.js')}}"></script>
@endsection
