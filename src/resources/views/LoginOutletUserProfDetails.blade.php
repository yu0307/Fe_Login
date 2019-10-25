@php
    $profUser=feiron\fe_login\models\fe_users::find($User->getKey())->load('metainfo')->makeVisible('metainfo');
    $User->title=$profUser->name;
    $metaVals=$profUser->metainfo->keyBy('meta_name');
    $User->subtitle='';
    $User->subtext='last activity: '.date('M-d Y',strtotime($profUser->last_login));
@endphp

<div class="container-fluid h-100p">
    <div class="row h-100p">
        <div class="col-md-12 h-80p">
            <div id="usrDetailArea" class="p-10" data-target="{{route('Fe_userUpdate')}}">
                <div id="usrDetail">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <div class="prepend-icon">
                                <input type="text" name="Name" class="form-control" placeholder="Name..." value="{{$User->name??''}}">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <div class="prepend-icon">
                                <input type="email" name="email" class="form-control" placeholder="Email..." value="{{$User->email??''}}">
                                <i class="fa fa-envelope"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="usrDetailMetas">
                    @foreach (app()->UserManagement->getMetaFields() as $metaDataField)
                    <div class="col-md-6 col-sm-12 usr_metaData">
                        <div class="form-group input-group width-100p">
                            <label>{{$metaDataField->meta_label??$metaDataField->meta_name}}</label>
                            @switch($metaDataField->meta_type)
                            @case('select')
                            <select class="form-control" name="{{$metaDataField->meta_name}}">
                                @foreach (json_decode($metaDataField->meta_options) as $options)
                                <option {!!( ($options['value']==$metaVals[$metaDataField->meta_name]->meta_value ||
                                    $options['value']==$metaDataField->meta_defaults) ?'selected="selected"':'')!!}
                                    value="{{$options['value']}}">{{$options['label']}}</option>
                                @endforeach
                            </select>
                            @break
                            @default
                            <div class="prepend-icon">
                                <input class="form-control" type="{{$metaDataField->meta_type}}" name="{{$metaDataField->meta_name}}"
                                    value="{{$metaVals[$metaDataField->meta_name]->meta_value??$metaDataField->meta_defaults??''}}">
                                <i class="fa fa-indent"></i>
                            </div>
                            @endswitch
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <button class="btn btn-primary pull-right saveChange ladda-button" data-style="expand-left"><span class="ladda-label">Update</span></button>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
@section('ExtraContents')
    <!-- Modal -->
    <div class="modal fade" id="Fe_login_ProfImage" tabindex="-1" role="dialog" aria-labelledby="Profile Image"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pull-left" id="exampleModalLabel">User Profile Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="prof_img_editArea">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="t-center text-center">
                                        <img class="usrProfImg_Preview img-circle" src="">
                                        <form class="FeLogin_ProfImgUpload m-15" enctype="multipart/form-data" action="{{route('FeLogin_ProfImgUpload')}}" id="fm_FeLogin_ProfImgUpload">
                                            <input type="file" class="inputfile" name="FeLogin_ProfImgUpload" id="FeLogin_ProfImgUpload" accept="image/x-png,image/gif,image/jpeg"/>
                                            <label for="FeLogin_ProfImgUpload"><i class="fa fa-upload"></i><span>Choose a file</span></label>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer t-center text-center">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection
