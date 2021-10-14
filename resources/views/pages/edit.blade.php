<form action="{{ route('admins.update', $user->id) }}" method="post" id="updateForm">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="first_name">First Name</label>
        <input class="form-control" name="first_name" id="first_name" value="{{ $user->first_name }}" placeholder="Enter first name" required>
    </div>

    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input class="form-control" name="last_name" id="last_name" value="{{ $user->last_name }}"  placeholder="Enter last name" required>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}"  placeholder="Enter email address" required>
    </div>

    <button type="submit" class="btn btn-primary float-right">
        <i class="fas fa-save"></i> Update
    </button>
</form>

<script>
    $('#updateForm').initFormSubmit();
</script>
