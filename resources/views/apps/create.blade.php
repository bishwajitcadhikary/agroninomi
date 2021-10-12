<form action="{{ route('apps.store') }}" method="post" id="createForm">
    @csrf

    <div class="form-group">
        <label for="client_id">Client ID</label>
        <input type="number" class="form-control" name="client_id" id="client_id" placeholder="Enter client id (App ID)" required>
    </div>

    <div class="form-group">
        <label for="client_secret">Client ID</label>
        <input type="password" class="form-control" name="client_secret" id="client_secret" placeholder="Enter client secret" required>
    </div>

    <button type="submit" class="btn btn-primary float-right">
        <i class="fas fa-save"></i> Save
    </button>
</form>

<script>
    $('#createForm').initFormSubmit();
</script>
