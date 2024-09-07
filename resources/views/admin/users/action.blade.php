<div class="btn-group btn-group-xs">
    <a class="btn btn-xs btn-primary"
       href="{{ route('admin.users.show', $id) }}">
        View
    </a>
    <a class="btn btn-xs btn-info"
       href="{{ route('admin.users.edit', $id) }}">
        Edit
    </a>
    <button class="btn btn-xs btn-danger btn-delete"
            data-url="{{ route('admin.users.destroy', $id) }}">Delete</button>

</div>
