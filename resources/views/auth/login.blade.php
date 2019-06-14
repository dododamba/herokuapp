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

            <h4 class="text-dark mb-5">Connexion </h4>
            {{ Form::open(array('url' => route('login'), 'class' => 'form-horizontal form-signin','files' => true)) }}    
             
            @if (Session::has('message'))
            <div class="alert alert-{{(Session::get('status')=='error')?'danger':Session::get('status')}} " alert-dismissable fade in id="sessions-hide">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>{{Session::get('status')}}!</strong> {!! Session::get('message') !!}
              </div>
               @endif

              @if ($errors->has('global'))
                  <div class="sufee-danger alert with-close alert-danger alert-dismissible fade show">
                      <span class="badge badge-pill badge-errot">Erreur</span>
                      <strong>{{ $errors->first('global') }}</strong>

                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
              @endif


              {!! csrf_field() !!}
            <div class="form-group  mb-4 {{ $errors->has('email') ? 'has-error' : ''}}">
                <div class="col-sm-12">
                    {!! Form::text('email', null, ['class' => 'form-control  input-lg','placeholder '=>'E-mail']) !!}
                    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group  mb-4 {{ $errors->has('password') ? 'has-error' : ''}}">
                <div class="col-sm-12">
                     {!! Form::password('password', ['class' => 'form-control  input-lg','placeholder '=>'Password']) !!}
                    {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                </div>
            </div>      
           
            <button class="btn btn-lg btn-primary btn-block mb-4"  name="Submit" value="Login" type="Submit">Connecxion</button>
    

        </form>
          </div>
        </div>
      </div>
    </div>
  
  </div>
</body>
@include('cdn.js')
