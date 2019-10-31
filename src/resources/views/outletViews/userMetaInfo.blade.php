@section('usrMeta')
<div class="form-row">
    @foreach (app()->UserManagement->getMetaFields() as $metafield)
    @php
        $metaValue=$metaVals[$metafield->meta_name]->meta_value??$metafield->meta_defaults;
    @endphp
        <div class="col-md-6 col-sm-12 usr_metainfo">
            <label>{{$metafield->meta_label??$metafield->meta_name}}</label>
            <div class="input-group">
            @switch($metafield->meta_type)
                @case('select')
                    <select class="form-control" name="{{$metafield->meta_name}}">
                        @foreach (($metafield->meta_options??[]) as $options)
                            <option {{( ($options==$metaValue) ?'selected="selected"':'')}} value="{{trim($options)}}">{{$options}}</option>
                        @endforeach
                    </select>
                @break
                @case('switch')
                    <label class="switch dis-block">
                        <input type="checkbox" class="switch-input form-control" name="{{$metafield->meta_name}}"
                            {{(($metaValue==='false')?'': 'checked')}} value="on">
                        <span class="switch-label" data-on="On" data-off="Off"></span>
                        <span class="switch-handle"></span>
                    </label>
                @break
                @case('radio')
                    <div class="icheck-inline">
                        @foreach (($metafield->meta_options??[]) as $options)
                        <label><input type="radio" {{(trim($options)==$metaValue)?'checked':''}} 
                                name="{{$metafield->meta_name}}" class="form-control"
                                data-radio="iradio_minimal-blue" value="{{trim($options)}}">{{$options}}</label>
                        @endforeach
                    </div>
                @break
                @case('checkbox')
                    <div class="icheck-inline">
                        @foreach (($metafield->meta_options??[]) as $options)
                        <label><input type="checkbox" {{ (
                                                            (is_array($metaValue)===false)?
                                                            ((trim($options)==trim($metaValue))?'checked':'')
                                                            :(in_array(trim($options),$metaValue)===false?'':'checked')
                                                        )}} name="{{$metafield->meta_name}}" class="form-control"
                                data-radio="icheckbox_square-blue" value="{{trim($options)}}">{{$options}}</label>
                        @endforeach
                    </div>
                @break
                @default
                    <input class="form-control form-white" type="{{$metafield->meta_type}}" name="{{$metafield->meta_name}}" value="{{$metaValue??''}}">
            @endswitch
            </div>
        </div>
    @endforeach
</div>
@show