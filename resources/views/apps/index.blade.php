@extends('adminlte::page')

@section('title', 'Apps')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1 class="m-0 text-dark">Apps</h1>
        <button class="btn btn-outline-secondary" onclick="modal('Add New App', '{{ route('apps.create') }}')">
            <i class="fas fa-plus"></i> Add New App
        </button>
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
