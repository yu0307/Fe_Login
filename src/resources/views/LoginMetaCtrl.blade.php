@section('usrMeta_cntr_header')
<div class="row">
    <div class="col-md-4 col-sm-12">
        <h4>User Meta Fields Management</h4>
    </div>
    <div class="col-md-8 col-sm-12">
        <button class="btn btn-primary float-end usrmeta_addNew" data-toggle="modal" data-target="#MetaInfo_CRUD">Add New</button>
    </div>
</div>
@endsection

@section('usrMeta_cntr_content')
<div id="usrmeta_dt_list">
    <div id="usrMeta_dt_table" width="100%" data_target="{{route('Fe_UserMetalist')}}" class="table-striped table-hover table-sm dt_table">

    </div>

</div>
@endsection

@section('usrMeta_edit_ctrl')
<input class="form-control" name="MetaID" id="MetaID" value="" type="hidden">
<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="form-group">
            <label class="control-label" for="meta_name">Meta Name</label>
            <div class="prepend-icon">
                <input type="text" name="meta_name" id="meta_name" class="form-control" placeholder="Meta Name..." value="">
                <i class="fa fa-indent"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="form-group">
            <label class="control-label" for="meta_type">Meta Type</label>
            <select name="meta_type" id="meta_type" style="display:block" class="p-b-10 form-control">
                <option value="text" selected>Text</option>
                <option value="select">Select</option>
                <option value="number">Number</option>
                <option value="email">Email</option>
                <option value="textarea">Text(multi-lined)</option>
                <option value="checkbox">CheckBox</option>
                <option value="radio">Radio Box</option>
                <option value="switch">Toggle</option>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="form-group">
            <label class="control-label" for="meta_label">Meta Label</label>
            <div class="prepend-icon">
                <input type="text" name="meta_label" id="meta_label" class="form-control" placeholder="Label to be displayed ..." value="">
                <i class="fa fa-indent"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="form-group">
            <label class="control-label" for="meta_defaults">Default Value</label>
            <div class="prepend-icon">
                <input type="text" name="meta_defaults" id="meta_defaults" class="form-control" placeholder="Default values ..."value="">
                <i class="fa fa-indent"></i>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label" for="meta_options">Control Options</label>
            <div class="prepend-icon">
                <input type="text" name="meta_options" id="meta_options" class="form-control" placeholder="control options ..." value="">
                <i class="fa fa-indent"></i>
            </div>
        </div>
        <div class="alert alert-info my-2 py-1">
            <h6 class="fw-light ft-14">Control Options are used for Select,checkbox,radios.<br/>Seperate each options with comma(,)</h6>
        </div>
    </div>
</div>
@endsection