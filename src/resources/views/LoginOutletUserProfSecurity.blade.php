<div class="container-fluid h-100">
    <div id="usrSecurityArea" class="row" data-target="{{route('Fe_userUpdate')}}">
        <div id="usrPassword" class="row">
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
        <div class="row">
            <div class="col-md-12 my-2 my-sm-1 my-md-3">
                <button class="btn btn-primary pull-right saveChange ladda-button" data-style="expand-left"><span class="ladda-label">Update</span></button>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>