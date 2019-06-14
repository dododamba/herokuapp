@extends('layout.app')
@section('title')
New user role
@stop

@section('content')
<div>
       <div class="col-md-12">

                 @if ($errors->any())
                @foreach ($errors->all() as $error)
                      <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
    <span class="badge badge-pill badge-errot">Error</span>
   {{ $error }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
</div>
                @endforeach
        @endif


                    @if(session()->has('success'))
    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
    <span class="badge badge-pill badge-success">Success</span>
    {{session()->get('success')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
         </div>
@endif
    @if(session()->has('error'))
        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
    <span class="badge badge-pill badge-errot">Error</span>
    {{session()->get('error')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
</div>
    @endif
               </div>
</div>
<div class="card card-primary">
  <div class="card-title">Nouveau Role</div>
<div class="card-body">
  {!! Form::open(['url' => 'role', 'class' => 'form-horizontal']) !!}
          <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
              {!! Form::label('name', 'Name', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-6">
                  {!! Form::text('name', null, ['class' => 'form-control']) !!}
                  {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
              </div>
          </div>
  <div class="form-group">
      <div class="row">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Créer', ['class' => 'btn btn-success form-control']) !!}
        </div>
        <div class="col-sm-offset-3 col-sm-3">
          <a href="{{route('role.index')}}" class="btn btn-default"><< Retour</a>

        </div>
      </div>
  </div>

  {!! Form::close() !!}
    </div>
    </div>





@endsection
