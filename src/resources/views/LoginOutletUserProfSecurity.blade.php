<div class="container-fluid h-100p p-l-60 p-r-60 m-l-60 m-r-60">
    <div id="usrSecurityArea" class="row h-100p" data-target="{{route('Fe_userUpdate')}}">
        <div id="usrPassword">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="control-label">Password</label>
                    <div class="prepend-icon">
                        <input type="password" name="password" class="form-control" placeholder="password" value="">
                        <i class="fa fa-lock"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="control-label">Confirm Password</label>
                    <div class="prepend-icon">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
                        <i class="fa fa-unlock-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <button class="btn btn-primary pull-right saveChange ladda-button" data-style="expand-left"><span class="ladda-label">Update</span></button>
            <div class="clearfix"></div>
        </div>
    </div>
</div>