@extends('layout.app')
@section('title')
    {{$role->is_group ?"Group permissions":"Role permissions"}}

@stop
@section('content')

    <div class="card card-default">
        <div class="card-heading">{{$role->is_group ?"Group ":"Role "}}{{$role->name}}</div>
        <div class="card-body">

            {{ Form::open(array('url' => route('role.save', $role->id), 'class' => 'form-horizontal')) }}
            <ul>
                <div class="row">
                    @foreach($actions as $action)
                        <div class="col-md-4">
                            <?php $first = array_values($action)[0];
                            $firstname = explode(".", $first)[0];
                            ?>

                            {{Form::label($firstname, $firstname, ['class' => 'form col-md-2 capital_letter'])}}
                            <select name="permissions[]" class="select" multiple="multiple">
                                @foreach($action as $act)
                                    @if(explode(".", $act)[0]=="api")
                                        <option value="{{$act}}" {{array_key_exists($act, $role->permissions)?"selected":""}}>
                                            {{isset(explode(".", $act)[2])?explode(".", $act)[1].".".explode(".", $act)[2]:explode(".", $act)[1]}}</option>
                                    @else
                                        <option value="{{$act}}" {{array_key_exists($act, $role->permissions)?"selected":""}}>

                                            {{explode(".", $act)[1]}}

                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-offset-3 col-sm-3">
                            {!! Form::submit('Enregistrer', ['class' => 'btn btn-success form-control']) !!}
                        </div>
                        <div class="col-sm-offset-3 col-sm-3">
                            <a href="{{$role->is_group ? route('group.index'):route('role.index')}}"
                               class="btn btn-default form-control"><< Liste</a>
                        </div>
                    </div>
                </div>

        </div>
    </div>
    </ul>
    {{ Form::close() }}

@stop
@section('js')
    <script src="{{ URL::asset('select/jquery.sumoselect.js') }}"></script>
    <link href="{{ URL::asset('select/sumoselect.css') }}" rel="stylesheet"/>

    <script type="text/javascript">
        $('.select').SumoSelect({selectAll: true, placeholder: 'Nothing selected'});
    </script>
@endsection