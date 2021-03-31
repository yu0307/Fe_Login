@includeIf('fe_login::LoginUsrList')

@push('usrManageFooter')
<link href="{{asset('/feiron/fe_login/css/usrManager_ui.css')}}" rel="stylesheet">
<script type="text/javascript" src="{{asset('/feiron/fe_login/js/Fe_Login_usrManager.js')}}"></script>
@endpush

@section('usrManager')
<div id="usr_management_area" actionTarget="{{route('Fe_UserManagement_save')}}">
    <div class="panel">
        <div class="panel-header bg-dark">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <h3><strong>User</strong> Management</h3>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <button class="btn btn-success float-end" id="btn_usrCreate" data-toggle="modal" data-bs-target="#usrManagementCtr">Create User</button>
                </div>
            </div>
        </div>
        <div class="panel-content p-3">
            @yield('feLogin_UsrList')
            {{$Slot??''}}
        </div>
    </div>
</div>
@show