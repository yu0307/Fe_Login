
@inject('UserManager', 'UserManagement')
@IncludeOutlet($UserManager->OutletRenders('userCreation'))

@push('fe_login_scripts')

@if (file_exists(public_path('js/app.js')))
<script src="{{asset('js/app.js')}}"></script>
@else
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-migrate-3.0.1.min.js" crossorigin="anonymous"></script>
@endif
<script src="{{asset('/feiron/fe_login/js/Fe_Login_bootstrap.js')}}"></script>
<link rel="stylesheet" href="{{asset('/feiron/fe_login/css/Fe_Login_usrMnager_ui.css')}}">
<script src="{{asset('/feiron/fe_login/js/Fe_Login_usrMnager_ui.js')}}"></script>
@endpush

@section('usrManager')
<div id="usr_management_area">
    <div class="panel">
        <div class="panel-header bg-dark">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <h3><strong>User</strong> Management</h3>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <button class="btn btn-success">Create User</button>
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
    @yield('userCreation')
</div>

@show