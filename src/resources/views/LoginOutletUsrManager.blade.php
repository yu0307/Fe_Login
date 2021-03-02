@inject('UserManager', 'UserManagement')
@includeIf('fe_login::LoginUsrList')

@section('usrManager')
<div id="usr_management_area" actionTarget="{{route('Fe_UserManagement_save')}}">
    <div class="panel bg-white">
        <div class="panel-content p-3 p-t-0">
            <div class="text-right text-end">
                <button class="btn btn-success" id="btn_usrCreate" data-toggle="modal" data-target="#usrManagementCtr">Create User</button>
            </div>
            <hr class="my-3">
            @yield('feLogin_UsrList')
            {{$Slot??''}}
        </div>
    </div>
</div>
@show

@section('User_Management_CRUD')
    <div class="py-1">
        @include('fe_login::outletViews.userManagementCRUD')
    </div>
@endsection