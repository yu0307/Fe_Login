@push('usrMetaManageFooter')
<link href="{{asset('/feiron/fe_login/css/Fe_Login_usrMetaManager.css')}}" rel="stylesheet">
<script type="text/javascript" src="{{asset('/feiron/fe_login/js/Fe_login_metaManager.js')}}"></script>
@endpush

@section('usrMetaManager')
<div id="usrMeta_management" actionTarget="{{route('Fe_UserMetaManagement')}}">
    <div class="panel">
        <div class="panel-header bg-dark">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <h3><strong>User</strong> Meta Info Management</h3>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <button class="btn btn-success float-end usrmeta_addNew" data-toggle="modal" data-bs-target="#MetaInfo_CRUD">Add New Meta Info</button>
                </div>
            </div>
        </div>
        <div class="panel-content p-3">
            <div id="usrmeta_dt_list">
                <div id="usrMeta_dt_table" width="100%" data_target="{{route('Fe_UserMetalist')}}" class="table-striped table-hover table-sm dt_table">
            
                </div>
            </div>
        </div>
    </div>
</div>
@show