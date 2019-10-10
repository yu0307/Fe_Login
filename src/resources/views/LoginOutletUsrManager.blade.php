
@inject('UserManager', 'UserManagement')
@IncludeOutlet($UserManager,'userManagement')
@includeIf('fe_login::LoginUsrList')
@section('usrManager')
<div id="usr_management_area" actionTarget="{{route('Fe_UserManagement_save')}}">
    <div class="panel">
        <div class="panel-content p-3">
            <div class="text-right t-right">
                <button class="btn btn-success outlet_CRUD" id="bt_usrCreate" data-toggle="modal" data-target="#usrManagementCtr" outlet-target="User_Management">Create User</button>
            </div>
            <hr class="m-t-5 m-b-5">
            @yield('feLogin_UsrList')
            {{$Slot??''}}
        </div>
    </div>
</div>
@show

@section('User_Management_CRUD')
    @include('fe_login::outletViews.userManagementCRUD')
@endsection