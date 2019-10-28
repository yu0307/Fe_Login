@section('usrMeta_cntr_header')
<div class="col-md-4 col-sm-12">
    <h4>User Meta Fields Management</h4>
</div>
<div class="col-md-8 col-sm-12">
    <button class="btn btn-primary pull-right usrmeta_addNew" data-toggle="modal" data-target="#MetaInfo_CRUD">Add New</button>
</div>
@endsection

@section('usrMeta_cntr_content')
<div id="usrmeta_dt_list">
    <table id="usrMeta_dt_table" width="100%" data_target="{{route('Fe_UserMetaManagement')}}" class="table table-striped table-hover table-sm dt_table">
        <thead class="thead-dark">
            <tr>
                <th>Field Name</th>
                <th>Meta Type</th>
                <th>Display Label</th>
                <th>Defaults</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
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
            <select name="meta_type" id="meta_type" style="display:block" class="p-b-10">
                <option value="text" selected>Text</option>
                <option value="select">Select</option>
                <option value="number">Number</option>
                <option value="email">Email</option>
                <option value="textarea">Text(multi-lined)</option>
                <option value="checkbox">CheckBox</option>
                <option value="radio">Radio Box</option>
            </select>
        </div>
    </div>
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
            <label class="control-label" for="meta_defaults">Default Values</label>
            <div class="prepend-icon">
                <input type="text" name="meta_defaults" id="meta_defaults" class="form-control" placeholder="Default values ..."value="">
                <i class="fa fa-indent"></i>
            </div>
        </div>
    </div>
</div>
@endsection