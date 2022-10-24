<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>M</b>B</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>My</b>BDApps Portal</span>
    </a>
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- User Account: style can be found in dropdown.less -->
          @if(session()->get('user_role') == 'user')
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> -->
              <span class="hidden-xs"><i class="fa fa-bullhorn"></i> OBD Credits: {{ session()->get('user_credit') }}</span>
              <span class="hidden-xs"><i class="fa fa-bullhorn"></i> Push SMS Credits:{{ session()->get('user_sms_credit') }}</span>
            </a>

          </li>
          @endif

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> -->
              <span class="hidden-xs"><i class="fa fa-envelope"></i> {{ session()->get('user_mail') }}</span>
            </a>

          </li>

          <li class="dropdown user user-menu">
            <a class="dropdown-item" href="{{ route('logout') }}">
              <span class="hidden-xs"><i class="fa fa-sign-out"></i> Logout
            </a>


          </li>

        </ul>
      </div>
    </nav>
</header>
