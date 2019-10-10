@section('feLogin_UsrList')
<div class="user_list">
    @forelse ($UserManager->getUsers($usrMeta??[],($withMyself??false)) as $user)
        <div class="users">
            <div class="user_img"><img class="user_prof_pics img-circle" src="{{asset('feiron\fe_login\images\avatar_notif.png')}}"></div>
            <div class="user_names">{{ $user->name }}</div>
        </div>
    @empty
        <p class="text-center t-center">There are no users...</p>
    @endforelse
</div>
@endsection