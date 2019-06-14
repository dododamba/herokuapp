
@include('cdn.css')
<body class="bg-light-gray" id="body">
    <div class="container d-flex flex-column justify-content-between vh-100">
    <div class="row justify-content-center mt-5">
      <div class="col-xl-5 col-lg-6 col-md-10">
        <div class="card">

          <div class="card-header bg-primary">

     
            <div class="app-brand">
              <a href="/index.html">
                <svg class="brand-icon" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" width="30" height="33"
                  viewBox="0 0 30 33">
                  <g fill="none" fill-rule="evenodd">
                    <path class="logo-fill-blue" fill="#7DBCFF" d="M0 4v25l8 4V0zM22 4v25l8 4V0z" />
                    <path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z" />
                  </g>
                </svg>
                <span class="brand-name">Gvoyage</span>
              </a>
            </div>
          </div>
          <div class="card-body p-5">
              @if (Session::has('message'))
              <div class="alert alert-{{(Session::get('status')=='error')?'danger':Session::get('status')}} " alert-dismissable fade in id="sessions-hide">
                 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>{{Session::get('status')}}!</strong> {!! Session::get('message') !!}
               </div>
             @endif 
             
            <h4 class="text-dark mb-5">Sign In</h4>
            {{ Form::open(array('url' => route('register'), 'class' => 'form-horizontal form-signin','files' => true)) }}    
            {!! csrf_field() !!}
                
                <div class="form-group  {{ $errors->has('first_name') ? 'has-error' : ''}}">
                  <label for="first_name" class="cols-sm-2 control-label">First Name</label>
                  <div class="cols-sm-10">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                      {!! Form::text('first_name', null, ['class' => 'form-control','placeholder '=>'Enter your firtst name']) !!}
                    </div>
                    {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
                  </div>
                </div>
                <div class="form-group  {{ $errors->has('last_name') ? 'has-error' : ''}}">
                  <label for="last_name" class="cols-sm-2 control-label">Last Name</label>
                  <div class="cols-sm-10">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                      {!! Form::text('last_name', null, ['class' => 'form-control','placeholder '=>'Enter your last name']) !!}
                    </div>
                     {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
                  </div>
                </div>
    
                <div class="form-group  {{ $errors->has('email') ? 'has-error' : ''}}">
                  <label for="email" class="cols-sm-2 control-label">Your Email</label>
                  <div class="cols-sm-10">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                      {!! Form::email('email', null, ['class' => 'form-control','placeholder '=>'E-mail']) !!}
                    </div>
                     {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                  </div>
                </div>
    
                <div class="form-group  {{ $errors->has('password') ? 'has-error' : ''}}">
                  <label for="password" class="cols-sm-2 control-label">Password</label>
                  <div class="cols-sm-10">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                       {!! Form::password('password', ['class' => 'form-control','rel'=>'gp' ,'data-size'=>'10' ,'data-character-set'=>'a-z,A-Z,0-9,#' ,'placeholder '=>'Enter your Password']) !!}
                    
                    </div>
                    {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                  </div>
                </div>
    
                <div class="form-group  {{ $errors->has('password_confirmation') ? 'has-error' : ''}}">
                  <label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
                  <div class="cols-sm-10">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                      {!! Form::password('password_confirmation', ['class' => 'form-control','rel'=>'gp' ,'data-size'=>'10' ,'data-character-set'=>'a-z,A-Z,0-9,#' ,'placeholder '=>'Confirm your Password']) !!}
                    
                    </div>
                    {!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}
                  </div>
                </div>
    
                <div class="form-group  {{ $errors->has('password') ? 'has-error' : ''}} ">
                  <button class="btn btn-primary btn-lg btn-block register-button" type="submit" >Register</button>
                  
                </div>
                <div class="login-register">
                        <a href="{{url('login')}}">Login</a>
                        @if ($errors->has('global'))
                        <span class="help-block danger">
                            <strong style="color:red" >{{ $errors->first('global') }}</strong>
                        </span>
                      @endif 
                </div>     
        {{ Form::close() }}   
          </div>
        </div>
      </div>
    </div>
  
  </div>
</body>
@include('cdn.js')

