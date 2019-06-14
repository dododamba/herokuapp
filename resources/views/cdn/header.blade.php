<header class="main-header " id="header">
        <nav class="navbar navbar-static-top navbar-expand-lg">
          <!-- Sidebar toggle button -->
          <button id="sidebar-toggler" class="sidebar-toggle">
            <span class="sr-only">Toggle navigation</span>
          </button>
          <!-- search form -->
          <div class="search-form d-none d-lg-inline-block">
            <div class="input-group">
              <button type="button" name="search" id="search-btn" class="btn btn-flat">
                <i class="mdi mdi-magnify"></i>
              </button>
              <input type="text" name="query" id="search-input" class="form-control" placeholder="'button', 'chart' etc."
                autofocus autocomplete="off" />
            </div>
            <div id="search-results-container">
              <ul id="search-results"></ul>
            </div>
          </div>

          <div class="navbar-right ">
            <ul class="nav navbar-nav">
              
              <li class="dropdown notifications-menu">
                <button class="dropdown-toggle" data-toggle="dropdown">
                  <i class="mdi mdi-bell-outline"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-right">
                  <li class="dropdown-header">You have 5 notifications</li>
                  <li>
                    <a href="#">
                      <i class="mdi mdi-account-plus"></i> New user registered
                      <span class=" font-size-12 d-inline-block float-right"><i class="mdi mdi-clock-outline"></i> 10 AM</span>
                    </a>
                  </li>
                </ul>
              </li>
              <!-- User Account -->
              <li class="dropdown user-menu">
                <button href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                  <img src="assets/img/user/user.png" class="user-image" alt="User Image" />
                  <span class="d-none d-lg-inline-block">
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right">
                  <!-- User image -->
                  <li class="dropdown-header">
                    <img src="assets/img/user/user.png" class="img-circle" alt="User Image" />
                    <div class="d-inline-block">
                      Abdus Salam <small class="pt-1">abdus@gmail.com</small>
                    </div>
                  </li>

                  <li>
                    <a href="profile.html">
                      <i class="mdi mdi-account"></i> My Profile
                    </a>
                  </li>
                  <li>
                    <a href="#"> <i class="mdi mdi-settings"></i> Account Setting </a>
                  </li>

                  <li class="dropdown-footer">
                      {!! Form::open(['url' => url('logout'),'class'=>'form-inline']) !!}
                      {!! csrf_field() !!}
                     <li><button class="btn btn-primary btn-lg btn-block register-button" type="submit" >Deconnection</button> </li>
                  {!! Form::close() !!}
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>

      </header>
