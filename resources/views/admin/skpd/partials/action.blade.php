<div class="btn-group btn-group-xs">
    <button class="btn btn-xs btn-info btn-edit"
            data-url="{{ route('admin.skpd.update', $id) }}">
        Edit
    </button>
    <button class="btn btn-xs btn-danger btn-delete"
            data-url="{{ route('admin.skpd.destroy', $id) }}">Delete</button>

</div>
