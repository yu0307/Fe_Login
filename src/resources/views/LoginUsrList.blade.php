@section('feLogin_UsrList')
<div class="user_list">
    @forelse (app()->UserManagement->getUsers($usrMeta??[],($withMyself??false)) as $user)
        <div class="users" uid="{{$user->id}}">
            <div class="usr_remove text-center t-center"><i class="animate__animated animate__fadeOutDown usr_remove far fa-times-circle c-red fa-lg p-0"></i></div>
            <div class="user_img">
                <img class="user_prof_pics img-circle rounded-circle" src="https://www.gravatar.com/avatar/{{md5(strtolower( trim($user->email ) ))}}?d={{empty($user->profile_image)?'mp':asset($user->profile_image)}}&s=65">
            </div>
            <div class="user_names t-center text-center">{{ $user->name }}</div>
        </div>
    @empty
        <p class="text-center t-center">There are no users...</p>
    @endforelse
</div>
@endsection