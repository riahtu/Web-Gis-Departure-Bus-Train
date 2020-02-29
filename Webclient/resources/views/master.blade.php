<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="Web Client">
        <meta name="author" content="Reza Sariful Fikri">

        <title>Web Cilent</title>

        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="/plugin/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="/css/style.css" rel="stylesheet">


        <script src="/js/jquery-3.3.1.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/jquery.maphilight.min.js"></script>
    </head>

    <body>
        <nav class="navbar navbar-default @yield('navbarBorder')">
          <div class="@yield('container')">

              <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                    @yield('homeMenu')
              </div>

              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    @if(session()->has('WebclientSession'))
                    <li><a ><span class="fa fa-user-circle-o"></span> {{ session()->get('WebclientSession')['user'] }}</a></li>
                        @if(session()->get('WebclientSession')['level'] == 'admin')
                        <li><a href="{{ url('/place') }}"><span class="glyphicon glyphicon-map-marker"></span> Place</a></li>
                        @endif
                    <li><a href="{{ url('/logout') }}"><span class="fa fa-sign-out fa-lg"></span></a></li>
                    @else
                    <li><a id="formLogin"><span class="fa fa-sign-in fa-lg"></span> Sig In</a></li>
                    @endif
                </ul>
              </div>
          </div><!-- /.container-fluid -->
        </nav>

        <div class="conNavbarLoader">
            <div class="loaderNavbar"></div>
        </div>

        @yield('konten')
    </body>
</html>