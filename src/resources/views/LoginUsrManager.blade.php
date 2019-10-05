@push('fe_login_scripts')

@if (file_exists(public_path('js/app.js')))
<script src="{{asset('js/app.js')}}"></script>
@else
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-migrate-3.0.1.min.js" crossorigin="anonymous"></script>
@endif
<script src="{{asset('/feiron/fe_login/js/Fe_Login_bootstrap.js')}}"></script>
<link rel="stylesheet" href="{{asset('/feiron/fe_login/css/Fe_Login_usrMnager_ui.css')}}">
<script src="{{asset('/feiron/fe_login/js/Fe_Login_usrMnager_ui.js')}}"></script>
@endpush

@section('usrManager')
<div class="panel">
    <div class="panel-header bg-dark">
        <h3><strong>User</strong> Management</h3>
    </div>
    <div class="panel-content">
        {{isset($Slot)?$Slot:''}}
    </div>
</div>
@show