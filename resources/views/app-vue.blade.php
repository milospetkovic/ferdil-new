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
    <link href={{ asset("/css/main.css") }} rel="stylesheet">
    <link href={{ asset("/css/bootstrap-datetimepicker.css") }} rel="stylesheet">
    <link href={{ asset("/css/elitasoft.css") }} rel="stylesheet">

    <!-- Scripts -->
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    {{-- Scripts --}}
    <script>
        window.Laravel = {!! json_encode([ 'csrfToken' => csrf_token() ]); !!};
        window.auth_user = {!! json_encode($auth_user); !!};
    </script>
</head>

<body>
    <noscript>
        <div class="text-center">
            <strong>We're sorry but the application doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
        </div>
    </noscript>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2 text-center">
                <div id="app">
                    <v-app app>
                        <v-container>
                            <v-btn color="primary">
                                Primary 456
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

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('/js/moment-timezone-with-data.min.js') }}"></script>
    <script src="{{ asset('/js/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}"></script>

</body>
</html>


