<form action="{{ route('pages.store') }}" method="post" id="createForm">
    @csrf

    <table class="table table-bordered table-striped" id="list">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Location</th>
            <th>Link</th>
            <th>Verified</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($pages as $data)
            <tr>
                <td>{{ $data->id }}</td>
                <td>{{ $data->name }}</td>
                <td>
                    @foreach($data->location as $key => $location)
                        <strong>{{ ucfirst($key) }} : </strong>{{ $location }} <br>
                    @endforeach
                </td>
                <td class="text-center">
                    <a href="{{ $data->link }}" class="btn btn-outline-info btn-sm" target="_blank"><i class="fa fa-external-link-alt"></i></a>
                </td>
                <td class="text-center">
                    @if($data->verification_status == "blue_verified")
                        <i class="fa fa-check-circle text-blue"></i>
                    @else
                        <i class="fa fa-times-circle"></i>
                    @endif
                </td>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input id="select-{{ $data->id }}" name="page_id[]" value="{{ $data->id }}" class="custom-control-input custom-control-input-primary custom-control-input-outline" type="checkbox">
                        <label for="select-{{ $data->id }}" class="custom-control-label"></label>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <button type="submit" class="btn btn-outline-primary">
        <i class="fas fa-save"></i>
        Save
    </button>
</form>

<script>
    $('#list').dataTable();

    $('#createForm').initFormSubmit()
</script>
