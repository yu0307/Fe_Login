@section('usrMeta')
<div class="form-row">
    @foreach (app()->UserManagement->getMetaFields() as $metafield)
        <div class="col-md-6 col-sm-12 usr_metainfo">
            <label>{{$metafield->meta_label??$metafield->meta_name}}</label>
            <div class="input-group">
            @switch($metafield->meta_type)
                @case('select')
                    <select class="form-control" name="{{$metafield->meta_name}}">
                        @foreach (json_decode($metafield->meta_options) as $options)
                            <option {!!($options['value']==$metafield->meta_defaults?'selected="selected"':'')!!} value="{{$options['value']}}">{{$options['label']}}</option>
                        @endforeach
                    </select>
                    @break
                @case('radio')
                    <div class="icheck-inline">
                        @foreach (($metafield->meta_options??[]) as $options)
                        <label><input {{(trim($options)==trim($metafield->meta_defaults))?'checked':''}} type="radio" name="{{$metafield->meta_name}}" class="form-control" data-radio="iradio_minimal-blue" value="{!!$options!!}">{{$options}}</label>
                        @endforeach
                    </div>
                @break
                @default
                    <input class="form-control form-white" type="{{$metafield->meta_type}}" name="{{$metafield->meta_name}}" value="{{$metafield->meta_defaults??''}}">
            @endswitch
            </div>
        </div>
    @endforeach
</div>
@show