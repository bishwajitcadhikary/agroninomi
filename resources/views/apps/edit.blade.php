<form action="{{ route('apps.update', $app->id) }}" method="post" id="updateForm">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="client_id">Client ID</label>
        <input type="number" class="form-control" name="client_id" id="client_id" value="{{ $app->client_id }}" placeholder="Enter client id (App ID)" required>
    </div>

    <div class="form-group">
        <label for="client_secret">Client ID</label>
        <input type="text" class="form-control" name="client_secret" id="client_secret" value="{{ $app->client_secret }}" placeholder="Enter client secret" required>
    </div>

    <button type="submit" class="btn btn-primary float-right">
        <i class="fas fa-save"></i> Update
    </button>
</form>

<script>
    $('#updateForm').initFormSubmit();
</script>
