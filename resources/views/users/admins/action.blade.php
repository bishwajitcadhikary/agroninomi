<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
    <button class="btn btn-warning" onclick="modal('Edit Admin User', '{{ route('admins.edit', $id) }}')"><i class="fa fa-edit"></i></button>
    @if($id !== auth()->id())
    <button class="btn btn-danger" onclick="deleteModal('{{ route('admins.destroy', $id) }}')">
        <i class="fa fa-trash"></i>
    </button>
    @endif
</div>
