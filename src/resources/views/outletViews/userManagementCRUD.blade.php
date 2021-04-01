@section('feLogin_CRUD_tab_contents')
    @php
        $menu='';
    @endphp
    @foreach (app()->UserManagementOutlet->getOutlet('UserManageOutlet') as $OutletItem)
        @php
            $ID=str_replace(' ','_',$OutletItem->MyName());
            $menu.='<li class="nav-item" role="presentation">
                        <a 
                            class="nav-link"
                            data-bs-target="#'.$ID.'" 
                            role="tab" 
                            href="#'.$ID.'" 
                            data-bs-toggle="tab">'.$OutletItem->MyName().'</a>
                    </li>';
        @endphp
        <div class="tab-pane fade py-1" id="{{$ID}}" role="tabpanel">
            @php
                $view=$OutletItem->getView();
                if ($__env->exists($view->Name(),$view->getData())){
                        echo $__env->make($view->Name(),$view->getData())->render(); 
                }
            @endphp
        </div>
    @endforeach
@endsection

@push('OutletResource')
    {!! join(app()->UserManagementOutlet->OutletResources('UserManageOutlet')) !!}
@endpush

<ul class="nav nav-pills nav-primary nav-fill f-16" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="usrBasic-tab" data-bs-toggle="tab" data-bs-target="#usrBasic" href="#usrBasic" role="tab" aria-selected="true">Basic Info</a>
    </li>
    {!!$menu!!}
</ul>
<div class="tab-content mt-3" >
    <div class="tab-pane fade active in p-2 show in" id="usrBasic" role="tabpanel">
        <input type="hidden" class="form-control" value="" id="usr_ID" name="usr_ID">
        <div class="form-row row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="control-label" for="usrName">Name</label>
                    <div class="prepend-icon input-group">
                        <input class="form-control" type="text" name="usrName" id="usrName" value="" placeholder="Name ...">
                        <i class="fa fa-indent"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="control-label" for="usrEmail">E-mail</label>
                    <div class="prepend-icon input-group">
                        <input class="form-control" type="email" name="email" id="email" value="" placeholder="Email ..." required>
                        <i class="fa fa-indent"></i>
                    </div>
                    <div class="invalid-feedback">
                        Please choose a unique and valid username.
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="control-label" for="usrPassword">Password</label>
                    <div class="prepend-icon input-group">
                        <input class="form-control" type="password" name="password" id="usrPassword" value="" placeholder="Password ..." required>
                        <i class="fa fa-indent"></i>
                    </div>
                    <div class="invalid-feedback">
                        Please provide a password.
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="control-label" for="password_confirmation">Confirm Password</label>
                    <div class="prepend-icon input-group">
                        <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" value="" placeholder="Confirm Password ..." required>
                        <i class="fa fa-indent"></i>
                    </div>
                    <div class="invalid-feedback">
                        Please provide a password.
                    </div>
                    <div class="invalid-feedback mustMatch custom">
                        Passwords do not match
                    </div>
                </div>
            </div>
            <div class="whenUpdate col-md-12">
                <h4 class="t-center text-center alert alert-info ft-14 py-2">Leave password fields empty to omit changing password. </h4>
            </div>
        </div>
    </div>
    @yield('feLogin_CRUD_tab_contents')
</div>


