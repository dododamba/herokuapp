@extends('backLayout.app')
@section('title')
User details
@stop
@section('css')
    <link rel="stylesheet" href="{{url('select')}}/css/tail.select-modern.css">

@stop
@section('content')
<div class="card card-default">
        <div class="card-heading">User  {{$user->name}} Permissions</div>

        <div class="card-body">

{{ Form::open(array('url' => route('user.save', $user->id), 'class' => 'form-horizontal')) }}
    <ul>
    <div class="row">
    @foreach($actions as $action)
        <div class="col-md-4">
          <?php $first= array_values($action)[0];
            $firstname =explode(".", $first)[0];
          ?>

        {{Form::label($firstname, $firstname, ['class' => 'form col-md-2 capital_letter'])}}
              <select id="example" class="example" multiple>
                  @foreach($action as $act)
            @if(explode(".", $act)[0]=="api")
            <option value="{{$act}}" {{array_key_exists($act, $user->permissions)?"selected":""}}>
            {{isset(explode(".", $act)[2])?explode(".", $act)[1].".".explode(".", $act)[2]:explode(".", $act)[1]}}</option>
            @else
             <option value="{{$act}}" {{array_key_exists($act, $user->permissions)?"selected":""}}>

              {{explode(".", $act)[1]}}

             </option>
            @endif
            @endforeach
        </select>
        </div>
    @endforeach
    </div>
       <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                {!! Form::submit('Submit', ['class' => 'btn btn-success form-control']) !!}
            </div>
            <a href="{{in_array($user->roles()->first()->name, ['Client', 'Deliver'])?route('user.index', ['type='.$user->roles()->first()->name]):route('user.index')}}" class="btn btn-default">Back to list</a>
        </div>
    </ul>
    </div>
    </div>
    {{ Form::close() }}

@stop

@section('scripts')<script src="{{url('select')}}/js/tail.select.js"></script>


<script type="text/javascript">
    tail.select("select")
    tail.select("select",{

        // width/heigh of the select
        width: null,
        height: 350,

        // CSS classes of the select
        classNames: null,

        // custom placeholder
        placeholder: null,

        // allows to deselect options or not
        deselect: false,

        // sets the 'disabled' attribute of the respective tail.select instance and gets overwritten by the source select element during the initialization
        disabled: false,

        // enables animations
        animate: false,

        // determines where to place the select
        openAbove: null,

        // stays open
        stayOpen: false,

        // opens the select on init
        startOpen: false,

        // enables multiple selection
        multiple: false,

        // maximum number of options allowed to select
        multiLimit: Infinity,

        // pins selected options on the top of the dropdown list.
        multiPinSelected: false,

        // shows a counter
        multiShowCount: true,

        // shows the number of selectable options next to the counter number
        multiShowLimit: false,

        // allows you to move selected options to another element
        multiContainer:     false,

        // shows "Select All" / "Unselect All" buttons
        multiSelectAll: false,

        // shows "All" / "None" buttons on each Optgroup
        multiSelectGroup: true,

        // enables descriptions for options
        descriptions: false,

        // additonal options
        items: {},

        // set / change the localization / language
        locale: "en",

        linguisticRules: {
            "ё": "е"
        },

        // 'ASC', 'DESC', or custom function
        sortItems: false,

        // 'ASC', 'DESC', or custom function
        sortGroups: false,

        // set an event listener to the source select element
        sourceBind: false,

        // set the display: none styling, to the source select element.
        sourceHide: true,

        // enables live search
        search: false,

        // auto sets the focus
        searchFocus: true,

        // highlights matched options
        searchMarked: true,

        // allows to exclude disabled options on the search
        searchDisabled: true,

        // hide options
        hideSelect: true,

        // hides selected options
        hideSelected: false,

        // hides disabled options
        hideDisabled: false,

        // sets an event listener to the source select element
        bindSourceSelect:   false,

        // enables CSV output
        csvOutput: false,
        csvSeparator: ","

        // function(item , group , search <string|false>){}
        cbLoopItem: undefined,

        // function(label , search <string|false>){}
        cbLoopGroup: undefined,

        // gets fired every time when the .init() process of the tail.select instance has been finished / reached the end
        cbComplete: undefined,

        // gets fired every time when the Dropdown List gets rendered with no single option
        cbEmpty: undefined

    })
</script>
@endsection