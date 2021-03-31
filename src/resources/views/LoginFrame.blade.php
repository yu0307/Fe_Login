@extends('felaraframe::blank')

@push('headerstyles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"  />
<link rel="stylesheet" href="{{asset('/feiron/fe_login/fontawesome5.15.2/css/all.css')}}"/>
<link rel="stylesheet" href="{{asset('/feiron/fe_login/css/backstretch.css')}}"/>
@endpush

@push('headerscripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{asset('/feiron/fe_login/js/backstretch.js')}}"></script>
@endpush

@section('main-content')
<div id="background">
    @for ($i = 1; $i <=6; $i++) <img class="backgroundimgs" src="{{asset('/feiron/fe_login/images/bg'.$i.'.jpg')}}">
        @endfor
</div>
@endsection