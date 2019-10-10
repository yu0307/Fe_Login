
@inject('UserManager', 'UserManagement')
@IncludeOutlet($UserManager,'userManagement')
@includeIf('fe_login::LoginUsrList')
@section('usrManager')
<div id="usr_management_area" actionTarget="{{route('Fe_UserManagement_save')}}">
    <div class="panel">
        <div class="panel-header bg-dark">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <h3><strong>User</strong> Management</h3>
                </div>
                <div class="col-md-6 col-sm-12 text-right t-right">
                    <button class="btn btn-success" id="bt_usrCreate" data-toggle="modal" data-target="#usrManagementCtr">Create User</button>
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