<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Vue - {{ config('app.name', 'Laravel') }}{{ vcs_info()}}</title>

    {{-- Styles --}}
    <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
{{--    <link href={{ asset("/css/app.css") }} rel="stylesheet">--}}
    <link href={{ asset("/css/main.css") }} rel="stylesheet">
    <link href={{ asset("/css/bootstrap-datetimepicker.css") }} rel="stylesheet">
    <link href={{ asset("/css/elitasoft.css") }} rel="stylesheet">

    <!-- Scripts -->
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    {{-- Scripts --}}
    <script>
      window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>

<body>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container">
        <div classs="row">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="navbar-header">

                    {{-- Collapsed Hamburger Menu --}}
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    {{-- Branding Image --}}
                    <a class="navbar-brand glyphicon glyphicon-home" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    {{-- Right Side Of Navbar --}}
                    <ul class="nav navbar-nav navbar-right">
                        {{-- Authentication Links  --}}
                        @if (Auth::guest())
                            <li class="pull-right"><a href="{{ url('/login') }}">Login</a></li>
                            <li class="pull-right"><a href="{{ url('/register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menu10" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>

                                <ul class="dropdown-menu" role="menu" aria-labelledby="menu10">
                                    <li role="presentation">
                                        <a href="{{ url('/logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <div class="container">
        <div class="row">

            @include('flash::message')

            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">

                    <div id="app">
                        <v-app app>
                            <v-container>
                                <v-btn color="primary">
                                    Primary
                                </v-btn>
                                <v-btn color="secondary">
                                    Secondary
                                </v-btn>
                                <v-btn color="error">
                                    Error
                                </v-btn>
                            </v-container>
                        </v-app>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('/js/moment-timezone-with-data.min.js') }}"></script>
    <script src="{{ asset('/js/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}"></script>

    @yield('pagescript')
    @yield('scripts')

    <script>
      $('#flash-overlay-modal').modal();
      $('div.alert').not('.alert-important').delay(2000).fadeOut(350);
      $('.show-inactive').click(function() {
        $(this).closest('form').submit();
      });
      $(".dropdown-toggle").dropdown();
    </script>

</body>
</html>


