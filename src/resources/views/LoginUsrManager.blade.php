@includeIf('fe_login::LoginUsrList')

@push('usrManageFooter')
    <link href="{{asset('/feiron/fe_login/css/Fe_Login_usrMnager_ui.css')}}" rel="stylesheet">
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
<div class="modal fade" tabindex="-1" role="dialog" id="usrManagementCtr">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create a user</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@show

