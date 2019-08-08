@php
$linkType=$linkType??false;
@endphp

@switch($linkType)
@case('link')
<a class="Fe_login_link" href="#" data-toggle="modal" data-target="#Fe_login_modal_window">{{$linkText??'Login'}}</a>
@break

@case('button')
<button type="button" class="Fe_login_link btn btn-primary" data-toggle="modal" data-target="#Fe_login_modal_window">{{$linkText??'Login'}}</button>
@break

@endswitch
<!-- Modal -->
<div class="modal fade" id="Fe_login_modal_window" tabindex="-1" role="dialog" aria-labelledby="Login Window" aria-hidden="true" style="display:none">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Hello, Please login.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @yield('LoginForm')
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

@push('fe_login_scripts')
<script src="{{asset('/fe_login/js/fe_login_ajax.js')}}"></script>
@endpush