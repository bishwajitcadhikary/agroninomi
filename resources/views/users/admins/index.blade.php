@extends('adminlte::page')

@section('title', 'Admins')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1 class="m-0 text-dark">Admins</h1>
        <button class="btn btn-outline-secondary" onclick="modal('Create New Admin', '{{ route('admins.create') }}')">
            <i class="fas fa-user-plus"></i> Create New Admin
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
