@php
    $profUser=feiron\fe_login\models\fe_users::find($User->getKey())->load('metainfo')->makeVisible('metainfo');
    $User->title=$profUser->name;
    $metaDataFeilds = app()->UserManagement->getMetaFields();
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
    @if (count($metaDataFeilds)>0)
    <div id="usrDetailMetas" class="row">
        <h4 class="alert alert-info p-2 ft-11rem">User Meta Information</h4>
        @foreach ($metaDataFeilds as $metafield)
        @php
            $metaValue=$metaVals[$metafield->meta_name]->meta_value??$metafield->meta_defaults;
        @endphp
        <div class="col-md-6 col-sm-12 usr_metaData">
            <div class="form-group">
                <label>{{$metafield->meta_label??$metafield->meta_name}}</label>
                <div class="input-group">
                    @switch($metafield->meta_type)
                        @case('select')
                            <select class="form-control form-white form-select" name="{{$metafield->meta_name}}">
                                @foreach (($metafield->meta_options??[]) as $options)
                                    <option {{( ($options==$metaValue) ?'selected=selected default':'')}} value="{{trim($options)}}">{{$options}}</option>
                                @endforeach
                            </select>
                        @break
                        @case('switch')
                            <div class="form-check-inline form-switch me-2">
                                <input class="form-check-input form-control" type="checkbox" toggle {{(boolval($metaValue)?'checked': '')}} name="{{$metafield->meta_name}}" >
                            </div>
                        @break
                        @case('radio')
                                @foreach (($metafield->meta_options??[]) as $options)
                                    <div class="form-check-inline me-2">
                                        <input value="{{trim($options)}}" class="form-check-input form-control" {{(trim($options)==$metaValue)?'checked':''}} type="radio" name="{{$metafield->meta_name}}">
                                        <label class="form-check-label">
                                            {{$options}}
                                        </label>
                                    </div>
                                @endforeach
                        @break
                        @case('checkbox')
                            @foreach (($metafield->meta_options??[]) as $options)
                                <div class="form-check-inline me-2">
                                    <input class="form-check-input form-control" {{ (
                                        (is_array(explode(',',$metaValue))===false)?
                                        ((trim($options)==trim($metaValue))?'checked':'')
                                        :(in_array(trim($options),explode(',',$metaValue))===false?'':'checked')
                                    )}} type="checkbox" value="{{trim($options)}}" name="{{$metafield->meta_name}}">
                                    <label class="form-check-label">{{$options}}</label>
                                </div>
                            @endforeach
                        @break
                        @default
                            <input class="form-control form-white" type="{{$metafield->meta_type}}" name="{{$metafield->meta_name}}" value="{{$metaValue??''}}">
                    @endswitch
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
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
