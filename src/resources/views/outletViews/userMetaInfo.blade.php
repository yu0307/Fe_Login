@section('usrMeta')
<div class="container-fluid">
    <div class="form-row row">
        @foreach (app()->UserManagement->getMetaFields() as $metafield)
        @php
            $metaValue=$metaVals[$metafield->meta_name]->meta_value??$metafield->meta_defaults;
        @endphp
            <div class="col-md-6 col-sm-12 usr_metainfo">
                <label>{{$metafield->meta_label??$metafield->meta_name}}</label>
                <div class="input-group">
                @switch($metafield->meta_type)
                    @case('select')
                        <select class="form-control form-select" name="{{$metafield->meta_name}}">
                            @foreach (($metafield->meta_options??[]) as $options)
                                <option {{( ($options==$metaValue) ?'selected=selected default':'')}} value="{{trim($options)}}">{{$options}}</option>
                            @endforeach
                        </select>
                    @break
                    @case('switch')
                        <div class="form-check-inline form-switch me-2">
                            <input class="form-check-input form-control" type="checkbox" toggle {{(($metaValue==='false')?'': 'checked')}} name="{{$metafield->meta_name}}" >
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
                                    (is_array($metaValue)===false)?
                                    ((trim($options)==trim($metaValue))?'checked':'')
                                    :(in_array(trim($options),$metaValue)===false?'':'checked')
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
        @endforeach
    </div>
</div>
@show