<div class="btn-group">
    <a class="btn btn-xs btn-primary"
       href="{{ route('admin.skpd.edit', $id) }}">
        View
    </a>
    <button class="btn btn-xs btn-danger btn-delete"
            data-url="{{ route('admin.skpd.destroy', $id) }}">Delete</button>

</div>
