<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
    <button class="btn btn-warning" onclick="modal('Edit App', '{{ route('apps.edit', $id) }}')"><i class="fa fa-edit"></i></button>
    <button class="btn btn-danger" onclick="deleteModal('{{ route('apps.destroy', $id) }}')">
        <i class="fa fa-trash"></i>
    </button>
</div>
