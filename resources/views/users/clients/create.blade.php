<form action="{{ route('clients.store') }}" method="post" id="createForm">
    @csrf

    <div class="form-group">
        <label for="first_name">First Name</label>
        <input class="form-control" name="first_name" id="first_name" placeholder="Enter first name" required>
    </div>

    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input class="form-control" name="last_name" id="last_name" placeholder="Enter last name" required>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" id="email" placeholder="Enter email address" required>
    </div>

    <div class="form-group">
        <label for="password">Email</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required>
    </div>

    <button type="submit" class="btn btn-primary float-right">
        <i class="fas fa-save"></i> Save
    </button>
</form>

<script>
    $('#createForm').initFormSubmit();
</script>
