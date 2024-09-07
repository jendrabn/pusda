<div class="btn-group btn-group-xs">
    <button class="btn btn-xs btn-info btn-edit"
            data-url="{{ route('admin.uraian.' . $routePart . '.update', $row->id) }}">
        Edit
    </button>
    <button class="btn btn-xs btn-danger btn-delete"
            data-url="{{ route('admin.uraian.' . $routePart . '.destroy', $row->id) }}">Delete</button>
</div>
