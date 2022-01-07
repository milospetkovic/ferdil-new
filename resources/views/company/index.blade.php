@extends('layouts.app')

@section('content')
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                @if ($view_type == 'create')
                    Maska za unos novog komitenta
                @elseif ($view_type == 'edit')
                    Ažuriranje komitenta
                @endif
            </div>

            <div class="panel-body">

                <form
                    @if ($view_type == 'create')
                        action="{{ action('App\Http\Controllers\Company\CompanyController@store') }}"
                    @elseif ($view_type == 'edit')
                        action="{{ action('App\Http\Controllers\Company\CompanyController@update') }}"
                    @endif
                    method="post" class="form-horizontal">

                    @if ($view_type == 'edit')
                        <input type="hidden" name="company_id" value="{{ $company->id }}">
                    @endif

                    {{ csrf_field() }}

                    <div class="">
                        <label for="name">Naziv komitenta</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ old('name') ? old('name') : (isset($company)) ? $company->name : '' }}">
                    </div>

                    <div class="mrg-t-10">
                        <button type="submit" class="btn btn-primary m-r"><span class="fa fa-check"></span> Sačuvaj</button>

                        <a class="btn btn-default" href="{{ action('App\Http\Controllers\HomeController@index') }}" class="btn btn-default">Prekini</a>
                    </div>

                </form>

            </div>

        </div>
    </div>
@endsection