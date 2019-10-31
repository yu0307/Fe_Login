@section('feLogin_UsrList')
<div class="user_list">
    @forelse (app()->UserManagement->getUsers($usrMeta??[],($withMyself??false)) as $user)
        <div class="users" uid="{{$user->id}}">
            <div class="usr_remove text-center t-center"><i class="animated  far fa fa-times-circle fa-times-circle-o c-red fa-2x p-0"></i></div>
            <div class="user_img">
                <img class="user_prof_pics img-circle" src="https://www.gravatar.com/avatar/{{md5(strtolower( trim($user->email ) ))}}?d={{empty($user->profile_image)?'mp':asset($user->profile_image)}}&s=65">
            </div>
            <div class="user_names t-center text-center">{{ $user->name }}</div>
        </div>
    @empty
        <p class="text-center t-center">There are no users...</p>
    @endforelse
</div>
@endsection