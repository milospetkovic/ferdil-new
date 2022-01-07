@extends('layouts.app')

@section('content')

    <div class="col-xs-12">

        <div class="panel panel-default">

            <div class="panel-heading">Komitent: {{ $company->name }}</div>

            <div class="panel-body">

                <a href="{{ action('App\Http\Controllers\HomeController@index') }}" class="btn btn-sm btn-default mb-2"><i class="glyphicon glyphicon-home"></i> Početna strana</a>

                <a href="{{ url()->previous() }}" class="btn btn-sm btn-default mrg-l-5 mrg-r-5 mb-2"><i class="glyphicon glyphicon-circle-arrow-left"></i> Nazad</a>

                <a href="/company/show/{{ $company->id }}/worker/create" class="btn btn-sm btn-primary m-r mb-2">Dodaj radnika</a>

                <a href="{{ action('App\Http\Controllers\Company\CompanyController@edit', [ 'id' => $company->id]) }}" class="btn btn-sm btn-warning mrg-l-5 mb-2">Ažuriraj komitenta</a>

                <a onclick="if (!confirm('Da li zaista želite da obrišete komitenta?! Brisanjem ćete obrisati i radnike iz ove kompanije!')) return false;"  href="{{ action('App\Http\Controllers\Company\CompanyController@delete', ['id' => $company->id ]) }}" class="btn btn-sm btn-danger pull-right mb-2"><span class="fa fa-check"></span>Obriši komitenta</a>

            </div>

        </div>

    </div>

    <div class="clearfix">

        @include('partials.worker.list')

    </div>

@endsection