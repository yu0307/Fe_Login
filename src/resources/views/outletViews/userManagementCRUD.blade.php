@section('feLogin_CRUD_tab_contents')
    @php
        $menu='';
    @endphp
    @foreach (app()->UserManagementOutlet->getOutlet('UserManageOutlet') as $OutletItem)
        @php
            $ID=str_replace(' ','_',$OutletItem->MyName());
            $menu.='
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#'.$ID.'" role="tab" >'.$OutletItem->MyName().'</a>
                    </li>';
        @endphp
        <div class="tab-pane fade p-2" id="{{$ID}}" role="tabpanel">
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

<ul class="nav nav-pills nav-fill" role="tablist">
    <li class="nav-item active">
        <a class="nav-link active" id="usrBasic-tab" data-toggle="tab" href="#usrBasic" role="tab" aria-selected="true">Basic Info</a>
    </li>
    {!!$menu!!}
</ul>
<div class="tab-content" >
    <div class="tab-pane fade active in p-2" id="usrBasic" role="tabpanel">
        <input type="hidden" class="form-control form-white" value="" id="usr_ID" name="usr_ID">
        <div class="form-row">
            <div class="col-md-6 col-sm-12">
                <label for="usrName">Name</label>
                <div class="input-group">
                    <input class="form-control form-white" type="text" name="usrName" id="usrName" value=""
                        placeholder="Name ...">
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <label for="usrEmail">E-mail</label>
                <div class="input-group mb-2">
                    <input class="form-control form-white" type="email" name="email" id="email" value="" placeholder="Email ..."
                        required>
                    <div class="invalid-feedback">
                        Please choose a unique and valid username.
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-6 col-sm-12">
                <label for="usrPassword">Password</label>
                <div class="input-group">
                    <input class="form-control form-white" type="password" name="password" id="usrPassword" value=""
                        placeholder="Password ..." required>
                    <div class="invalid-feedback">
                        Please provide a password.
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <label for="password_confirmation">Confirm Password</label>
                <div class="input-group">
                    <input class="form-control form-white" type="password" name="password_confirmation"
                        id="password_confirmation" value="" placeholder="Confirm Password ..." required>
                    <div class="invalid-feedback">
                        Please provide a password.
                    </div>
                    <div class="invalid-feedback mustMatch custom">
                        Passwords do not match
                    </div>
                </div>
            </div>
            <div class="whenUpdate col-md-12">
                <h4 class="t-center text-center">Leave password fields empty to omit changing password. </h4>
            </div>
        </div>
    </div>
    @yield('feLogin_CRUD_tab_contents')
</div>


