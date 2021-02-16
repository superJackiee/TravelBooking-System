@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','CRM')

@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap.min.css')}}">
@endsection

@section('custom-horizontal-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/core/menu/menu-types/horizontal-menu.css')}}">
@endsection

@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection
@section('content')

<section id="basic-tabs-components">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="customer-tab" data-toggle="tab" href="#home" aria-controls="home" role="tab"
                aria-selected="true">
                <i class="bx bxs-contact align-middle"></i>
                <span class="align-middle">Customers</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="account-tab" data-toggle="tab" href="#profile" aria-controls="profile" role="tab"
                aria-selected="false">
                <i class="bx bx-user align-middle"></i>
                <span class="align-middle">Accounts</span>
            </a>
        </li>
    </ul>
    <div class="tab-content" style="padding-left: 0;">
        <div class="tab-pane active" id="home" aria-labelledby="customer-tab" role="tabpanel">
            <div class="invoice-list-wrapper">
                <div class="action-dropdown-btn d-none">
                    <div class="dropdown invoice-filter-action" id="invoice-filter-action-customer">
                        <button type="button" onclick="window.location.href='/customer_create'" class="btn btn-primary mr-1 glow d-flex align-items-center align-left"><span><i class="bx bxs-contact" style="margin-bottom: 5px;"></i></span>&nbsp; Add Customer</button>
                    </div>
                    <div class="dropdown invoice-options" id="invoice-options-customer">
                        <button id="export_csv_customer" class="btn btn-primary mr-1 glow d-flex align-items-center align-left"><span><i class="bx bx-table" style="margin-bottom: 5px;"></i></span>&nbsp; Export CSV</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table invoice-data-table dt-responsive nowrap" id="table-customer" style="width:100%;">
                    <thead>
                        <tr>
                            <th></th>
                            <th style="text-align: center;">No</th>
                            <th style="text-align: center;">Full Name</th>
                            <th style="text-align: center;">Email</th>
                            <th style="text-align: center;">Phone</th>
                            <th style="text-align: center;">Country</th>
                            <th style="text-align: center;">Customer Type</th>
                            <th style="text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $cnt = 0;?>
                        @foreach($accounts as $account)
                            @if($account->account_type == 1 || $account->account_type == 2)
                                <?php $cnt ++;?>
                                <tr>
                                    <td></td>
                                    <td style="text-align: center;">{{$cnt}}</td>
                                    <td style="text-align: center;">
                                        {{$account->first_name.' '.$account->last_name}}
                                    </td>
                                    <td style="text-align: center;">
                                        {{$account->main_email}}
                                    </td>
                                    <td style="text-align: center;">
                                        {{$account->main_office_phone}}
                                    </td>
                                    <td style="text-align: center;">
                                        @if(isset($account->get_country->title))
                                            {{$account->get_country->title}}
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        {{$account->get_account_type->title}}
                                    </td>
                                    <td style="text-align: center;">       
                                        <div class="invoice-action">
                                            <a title="Edit" href="../edit_customer/{{$account->id}}" id="customer_edit" class="invoice-action-edit cursor-pointer mr-1">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <a title="Delete" href="javascript:void(0)" onClick="account_del({{$account->id}})" class="invoice-action-view">
                                                <i class="bx bx-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="profile" aria-labelledby="account-tab" role="tabpanel">
            <div class="invoice-list-wrapper">
                <div class="action-dropdown-btn d-none">
                    <div class="dropdown invoice-filter-action" id="invoice-filter-action-account">
                        <button type="button" onclick="window.location.href='/account_create'" class="btn btn-primary mr-1 glow d-flex align-items-center align-left"><span><i class="bx bx-user" style="margin-bottom: 5px"></i></span>&nbsp; Add Account</button>
                    </div>
                    <div class="dropdown invoice-options" id="invoice-options-account">
                        <button id="export_csv_account" class="btn btn-primary mr-1 glow d-flex align-items-center align-left"><span><i class="bx bx-table" style="margin-bottom: 5px"></i></span>&nbsp; Export CSV</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table invoice-data-table dt-responsive nowrap" id="table-account" style="width:100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th style="text-align: center;">No</th>
                            <th style="text-align: center;">UserName</th>
                            <th style="text-align: center;">Full Name</th>
                            <th style="text-align: center;">Email</th>
                            <th style="text-align: center;">Password</th>
                            <th style="text-align: center;">Phone</th>
                            <th style="text-align: center;">Country</th>
                            <th style="text-align: center;">Customer Type</th>
                            <th style="text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $cnt = 0;?>
                        @foreach($accounts as $account)
                            @if($account->account_type == 3 || $account->account_type == 4)
                                @if($account->user_id != 1)
                                <?php $cnt ++;?>
                                    <tr>
                                        <td></td>
                                        <td style="text-align: center;">{{$cnt}}</td>
                                        <td class="text-bold-600 pr-0 sorting_1">
                                            <img class="rounded-circle mr-1" src="{{asset($account->avatar_path)}}"  style="width:40px; height:40px;" alt="card">
                                            {{$account->get_user_info->name}}
                                        </td>
                                        <td style="text-align: center;">
                                            {{$account->first_name.' '.$account->last_name}}
                                        </td>
                                        <td style="text-align: center;">
                                            {{$account->main_email}}
                                        </td>
                                        <td style="text-align: center;">
                                            <a href="javascript:void(0)" class="cursor-pointer" id="change_pwd_btn" onClick="onPasswordBtnClick({{$account->user_id}})">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                        </td>
                                        <td style="text-align: center;">
                                            {{$account->main_office_phone}}
                                        </td>
                                        <td style="text-align: center;">
                                            @if(isset($account->get_country->title))
                                                {{$account->get_country->title}}
                                            @endif
                                        </td>
                                        <td style="text-align: center;">
                                            @if(isset($account->get_account_type->title))
                                                {{$account->get_account_type->title}}
                                            @endif
                                        </td>
                                        <td style="text-align: center;">       
                                            <div class="invoice-action">
                                                <a title="Edit" href="../edit_account/{{$account->id}}" id="customer_edit" class="invoice-action-edit cursor-pointer mr-1">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <a title="Delete" href="javascript:void(0)" onClick="account_del({{$account->id}})" class="invoice-action-view">
                                                    <i class="bx bx-trash-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade text-left" id="change_password_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel150" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <form method="post" action="../update_password">
        @csrf
        <div class="modal-content">
            <div class="modal-header bg-dark white">
                <span class="modal-title" id="myModalLabel150">Change Password</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <h6>Change Password</h6>
                <input type="hidden" name="user_id_pwd" id="user_id_pwd">
                <fieldset class="form-group position-relative has-icon-left">
                    <div class="controls">
                        <input type="password" class="form-control" id="change_password" name="change_password" required
                            data-validation-required-message="The password field is required" minlength="6">
                    </div>
                    <div class="form-control-position">
                        <i class="bx bx-purchase-tag-alt"></i>
                    </div>
                </fieldset>
                <h6>Change Password Confirm</h6>
                <fieldset class="form-group position-relative has-icon-left">
                    <div class="controls">
                        <input type="password" class="form-control" id="change_password_confirm" name="change_password_confirm" required
                        required data-validation-match-match="change_password" data-validation-required-message="The Confirm password field is required" minlength="6">
                    </div>
                    <div class="form-control-position">
                        <i class="bx bx-purchase-tag-alt"></i>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-dark ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Change</span>
                </button>
            </div>
        </div>
        </form>
    </div>
</div>

@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/responsive.bootstrap.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>

@endsection

{{-- page scripts --}}
@section('page-scripts')
<script>
    var msg = <?php if(json_encode(session()->get('msg'))) echo json_encode(session()->get('msg'));  ?>;
</script>
<script src="{{asset('js/scripts/pages/crm_customer.js')}}"></script>
@endsection