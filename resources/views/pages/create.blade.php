@extends('adminlte::page')

@section('title', 'Add New Pages')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1 class="m-0 text-dark">Add New Pages</h1>
        <a href="{{ route('pages.index') }}" class="btn btn-outline-secondary">
            <i class="fa fa-undo"></i> Cancel
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <form id="filterForm">
                        <div class="row justify-content-center">
                            <div class="col-md-3">
                                <input type="search" name="name" id="name" class="form-control" placeholder="Enter page name" required>
                            </div>
                            <div class="col-md-3">
                                <input type="search" name="location" id="location" class="form-control" placeholder="Enter location">
                            </div>

                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-block" id="search"><i class="fas fa-search"></i> Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body get-list">

                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $('#filterForm').initValidate();

        $('#filterForm').on('submit', function (e) {
            e.preventDefault();

            let name = $('#name').val();
            let location = $('#location').val();

            if (name !== ""){
                $.ajax({
                    url: '{{ route('pages.search') }}',
                    data: {
                        name: name,
                        location: location
                    },
                    success: function (res) {
                        $('.get-list').html(res)
                    },
                    error: function (res) {
                        $('.get-list').empty();
                        Toast.fire({
                            icon: 'error',
                            title: res.responseJSON.message
                        })
                    }
                })
            }
        })
    </script>

@stop
