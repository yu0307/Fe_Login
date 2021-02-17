@php
    $profUser=feiron\fe_login\models\fe_users::find($User->getKey())->load('metainfo')->makeVisible('metainfo');
    $User->title=$profUser->name;
    $metaVals=$profUser->metainfo->keyBy('meta_name');
    $User->subtitle='';
    $User->subtext='last activity: '.date('M-d Y',strtotime($profUser->last_login));
@endphp

@section('usrDetail')
    <div id="usrDetail" class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label class="control-label">Display Name</label>
                <div class="prepend-icon">
                    <input type="text" name="name" class="form-control" placeholder="Name..." value="{{$User->name??''}}">
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
    <div id="usrDetailMetas" class="row">
        @foreach (app()->UserManagement->getMetaFields() as $metaDataField)
        @php
            $metaValue=$metaVals[$metaDataField->meta_name]->meta_value??$metaDataField->meta_defaults;
        @endphp
        <div class="col-md-6 col-sm-12 usr_metaData">
            <div class="form-group input-group width-100">
                <label>{{$metaDataField->meta_label??$metaDataField->meta_name}}</label>
                @switch($metaDataField->meta_type)
                    @case('select')
                    <select class="form-control" name="{{$metaDataField->meta_name}}">
                        @foreach (($metaDataField->meta_options??[]) as $options)
                        <option {{( ($options==$metaValue) ?'selected="selected"':'')}}
                            value="{{trim($options)}}">{{$options}}</option>
                        @endforeach
                    </select>
                    @break
                    @case('switch')
                    <label  class="switch dis-block">
                        <input type="checkbox" value="on" class="form-control switch-input" name="{{$metaDataField->meta_name}}" {{(($metaValue==='false')?'': 'checked')}}>
                        <span class="switch-label" data-on="On" data-off="Off" ></span>
                        <span class="switch-handle"></span>
                    </label >
                    @break
                    @case('radio')
                    <div class="icheck-inline">
                        @foreach (($metaDataField->meta_options??[]) as $options)
                            <label><input type="radio" {{
                            (trim($options)==$metaValue)?'checked':''
                            }} name="{{$metaDataField->meta_name}}" class="form-control" data-radio="iradio_minimal-blue" value="{{$options}}">{{$options}}</label>
                        @endforeach
                    </div>
                    @break
                    @case('checkbox')
                    <div class="icheck-inline">
                        @foreach (($metaDataField->meta_options??[]) as $options)
                        <label><input type="checkbox" {{
                            (
                                (is_array($metaValue)===false)?
                                ((trim($options)==trim($metaValue))?'checked':'')
                                :(in_array(trim($options),$metaValue)===false?'':'checked')
                                )
                        }}
                                name="{{$metaDataField->meta_name}}" class="form-control" data-radio="icheckbox_square-blue"
                                value="{{trim($options)}}">{{$options}}</label>
                        @endforeach
                    </div>
                    @break
                    @default
                    <div class="prepend-icon">
                        <input class="form-control" type="{{$metaDataField->meta_type}}" name="{{$metaDataField->meta_name}}"
                            value="{{$metaValue??''}}">
                        <i class="fa fa-indent"></i>
                    </div>
                @endswitch
            </div>
        </div>
        @endforeach
    </div>
@endsection

@section('profile_footer')
<button class="btn btn-primary pull-right saveChange ladda-button" data-style="expand-left"><span class="ladda-label">Update</span></button>
<div class="clearfix"></div>
@endsection

<div class="container-fluid">
    <div class="row h-100">
        <div class="col-md-12">
            <div id="usrDetailArea" class="p-10" data-target="{{route('Fe_userUpdate')}}">
                @yield('usrDetail')
            </div>
        </div>
    </div>
    <div class="row my-2 my-sm-1 my-md-3">
        <div class="col-md-12">
            @yield('profile_footer')
        </div>
    </div>
</div>

@push('lastContent')
    <!-- Modal -->
    <div class="modal fade" id="Fe_login_ProfImage" tabindex="-1" aria-labelledby="Profile_Image" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="Profile_Image">User Profile Image</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="prof_img_editArea">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="t-center text-center">
                                    <div class="edit_prof_img_area">
                                        <div class="remove_prof_img"><i class="fas fa-times fa-2x text-danger"></i></div>
                                        <img class="usrProfImg_Preview img-circle img-thumbnail" src="">
                                    </div>
                                    <form class="FeLogin_ProfImgUpload m-15" enctype="multipart/form-data" action="{{route('FeLogin_ProfImgUpload')}}" id="fm_FeLogin_ProfImgUpload">
                                        <input type="file" class="inputfile" name="FeLogin_ProfImgUpload" id="FeLogin_ProfImgUpload" accept="image/x-png,image/gif,image/jpeg"/>
                                        <label for="FeLogin_ProfImgUpload"><i class="fa fa-upload"></i><span>Choose a file</span></label>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="progress progress-striped active animate__animated animate__fadeIn" style="display:none" >
                            <div class="progress-bar  progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                aria-valuemax="100" style="width: 0px">
                                <span class="percent">0%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-save">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
@endpush
