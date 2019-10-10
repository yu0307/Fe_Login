<input type="hidden" class="form-control form-white" value="" id="usr_ID" name="usr_ID">
    <div class="form-row">
        <div class="col-md-6 col-sm-12">
            <label for="usrName">Name</label>
            <div class="input-group">
                <input class="form-control form-white" type="text" name="usrName" id="usrName" value="" placeholder="Name ...">
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <label for="usrEmail">E-mail</label>
            <div class="input-group mb-2">
                <input class="form-control form-white" type="email" name="email" id="email" value="" placeholder="Email ..." required>
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
                <input class="form-control form-white" type="password" name="password" id="usrPassword" value="" placeholder="Password ..." required>
                <div class="invalid-feedback">
                    Please provide a password.
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <label for="password_confirmation">Confirm Password</label>
            <div class="input-group">
                <input class="form-control form-white" type="password" name="password_confirmation" id="password_confirmation" value="" placeholder="Confirm Password ..." required>
                <div class="invalid-feedback">
                    Please provide a password.
                </div>
                <div class="invalid-feedback mustMatch custom">
                    Passwords do not match
                </div>
            </div>
        </div>
    </div>
</div>
@yield('usrMeta')