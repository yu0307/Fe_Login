@includeif('fe_login::LoginMetaCtrl')
<div id="usrMeta_management" actionTarget="{{route('Fe_UserMetaManagement')}}">
    <div class="panel">
        <div class="panel-content p-2 p-t-0">
            @yield('usrMeta_cntr_header')
            <hr class="m-t-5 m-b-5">
            @yield('usrMeta_cntr_content')
        </div>
    </div>
</div>

@section('User_Meta_Info_CRUD')
<div class="p-10">
    @yield('usrMeta_edit_ctrl')
</div>
@endsection