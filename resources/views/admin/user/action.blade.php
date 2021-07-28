<div class="btn-group mb-3 btn-group-sm" role="group" aria-label="Basic example">
  <a href="{{ route('admin.users.edit', $id) }}" class="btn btn-icon btn-warning"><i
      class="fas fa-pencil-alt"></i></a>
  <a href="{{ route('admin.users.show', $id) }}" class="btn btn-icon btn-info"><i class="fas fa-eye"></i></a>
  <button data-url="{{ route('admin.users.destroy', $id) }}" type="button"
    class="btn btn-icon btn-danger btn-delete"><i class="fas fa-trash-alt"></i></button>
</div>
