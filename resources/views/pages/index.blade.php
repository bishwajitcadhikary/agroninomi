@extends('adminlte::page')

@section('title', 'Pages')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1 class="m-0 text-dark">Pages</h1>
        <a href="{{ route('pages.create') }}" class="btn btn-outline-secondary">
            <i class="fas fa-plus"></i> Add New Page
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    {{ $dataTable->scripts() }}
@stop
