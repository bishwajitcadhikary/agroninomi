@extends('adminlte::page')

@section('title', 'Clients')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1 class="m-0 text-dark">Clients</h1>
        <button class="btn btn-outline-secondary" onclick="modal('Create New Client', '{{ route('clients.create') }}')">
            <i class="fas fa-user-plus"></i> Create New Client
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
