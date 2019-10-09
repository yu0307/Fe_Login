
@inject('UserManager', 'UserManagement')
@IncludeOutlet($UserManager,'userManagement')



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
            <div class="user_list">
                @forelse ($UserManager->getUsers($usrMeta??[],($withMyself??false)) as $user)
                    <div class="users">
                        <div class="user_img"><img class="user_prof_pics img-circle" src="{{asset('feiron\fe_login\images\avatar_notif.png')}}"></div>
                        <div class="user_names">{{ $user->name }}</div>
                    </div>
                @empty
                    <p>There are no users...</p>
                @endforelse
            </div>
            {{$Slot??''}}
        </div>
    </div>
</div>

@show