<div class="btn-group">
    <a class="btn btn-xs btn-primary"
       href="{{ route('admin.users.edit', $id) }}">
        View
    </a>
    <button class="btn btn-xs btn-danger btn-delete"
            data-url="{{ route('admin.users.destroy', $id) }}">Delete</button>

</div>
