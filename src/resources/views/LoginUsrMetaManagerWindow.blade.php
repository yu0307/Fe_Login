@extends('fe_login::LoginFrame')
@includeif('fe_login::LoginMetaCtrl')

@push('headerstyles')
<link rel="stylesheet" href="{{asset('/feiron/fe_login/css/usrMetaManager.css')}}"/>
@endpush

@push('headerscripts')
@stack('usrMetaManageHeader')
@endpush

@section('main-content')

<div class="usr-meta-manager w-100 h-75 py-5 p-3 position-absolute start-50 top-50 translate-middle">
    <div class="container-fluid">
        <div class="row" id="app">
            <div class="col-md-2 d-none d-md-block">
            </div>
            <div class="col-md-8 col-sm-12">
                <x-fe-user-meta-manager />
            </div>
            <div class="col-md-2 d-none d-md-block">
            </div>
        </div>
    </div>
</div>

@parent

<div class="modal fade" id="usrMetaManagementCtr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create a user meta field</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body User_Management">
                <div class="text-center loading">
                    <h4>Loading Contents...</h4>
                    <i class="fas fa-circle-notch fa-spin fa-2x p-0"></i>
                </div>
                <div class="User_Meta_Management_Area" id="User_Meta_Info_CRUD">
                    @yield('usrMeta_edit_ctrl')
                </div>
                <div id="usrManageWinMsg" class="hidden">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="usrMetaSave">Save changes</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@stack('usrMetaManageFooter')

@endsection