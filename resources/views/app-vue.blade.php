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

    {{-- Scripts --}}
</head>

<body>
    <noscript>
        <div class="text-center">
            <strong>We're sorry but the application doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
        </div>
    </noscript>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div id="app">
                    <v-app app>
                    </v-app>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>


