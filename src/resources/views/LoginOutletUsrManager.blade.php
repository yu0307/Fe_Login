@inject('UserManager', 'UserManagement')
@section('usrMeta')
    @foreach ($UserManager->getMetaFields() as $metafield)
        <div class="col-md-6 col-sm-12 usr_metainfo">
            <label>{{$metafield->meta_label??$metafield->meta_name}}</label>
            <div class="input-group">
            @switch($metafield->meta_type)
                @case('select')
                    <select class="form-control" name="{{$metafield->meta_name}}">
                        @foreach (json_decode($metafield->meta_options) as $options)
                            <option {!!($options['value']==$metafield->meta_defaults?'selected="selected"':'')!!} value="{{$options['value']}}">{{$options['label']}}</option>
                        @endforeach
                    </select>
                    @break
                @default
                    <input class="form-control form-white" type="{{$metafield->meta_type}}" name="{{$metafield->meta_name}}" value="{{$metafield->meta_defaults??''}}">
            @endswitch
            </div>
        </div>
    @endforeach
@endsection
@FE_LoginIncludeOutlet(app()->UserManagementOutlet,'UserManageOutlet')
@includeIf('fe_login::LoginUsrList')

@section('usrManager')
<div id="usr_management_area" actionTarget="{{route('Fe_UserManagement_save')}}">
    <div class="panel">
        <div class="panel-content p-3 p-t-0">
            <div class="text-right t-right">
                <button class="btn btn-success" id="btn_usrCreate" data-toggle="modal" data-target="#usrManagementCtr">Create User</button>
            </div>
            <hr class="m-t-5 m-b-5">
            @yield('feLogin_UsrList')
            {{$Slot??''}}
        </div>
    </div>
</div>
@show

@section('User_Management_CRUD')
    <div class="p-5">
        @include('fe_login::outletViews.userManagementCRUD')
    </div>
@endsection