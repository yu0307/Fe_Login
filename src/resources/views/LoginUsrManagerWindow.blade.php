@extends('fe_login::LoginFrame')

@push('headerstyles')
<link rel="stylesheet" href="{{asset('/feiron/fe_login/css/usrManager.css')}}"/>
@endpush

@push('headerscripts')
<script src="{{asset('/feiron/fe_login/js/Fe_Login_usrManager_ui.js')}}"></script>
@stack('usrManageHeader')
@endpush
@section('main-content')

<div class="usr-manager w-75 h-75 py-5 p-3 position-absolute start-50 top-50 translate-middle">
    <div class="container-fluid">
        <div class="row" id="app">
            <div class="col-md-2 d-none d-md-block">
            </div>
            <div class="col-md-8 col-sm-12">
                <x-fe-user-manager />
            </div>
            <div class="col-md-2 d-none d-md-block">
            </div>
        </div>
    </div>
</div>

@parent

<div class="modal fade" id="usrManagementCtr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create a user</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body User_Management">
                <div class="text-center loading">
                    <h4>Loading Contents...</h4>
                    <i class="fas fa-circle-notch fa-spin fa-2x p-0"></i>
                </div>
                <div class="User_Management_Area">
                    @include('fe_login::outletViews.userManagementCRUD')
                </div>
                <div id="usrManageWinMsg" class="hidden">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="usrSave">Save changes</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@stack('usrManageFooter')
@stack('OutletResource')

@endsection