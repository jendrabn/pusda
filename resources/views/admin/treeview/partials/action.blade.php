<div class="btn-group btn-group-xs">
    <a class="btn btn-xs btn-info btn-edit"
       href="{{ route('admin.treeview.' . $routePart . '.update', $row->id) }}">
        Edit
    </a>
    <a class="btn btn-xs btn-danger btn-delete"
       href="{{ route('admin.treeview.' . $routePart . '.destroy', $row->id) }}">Delete</a>

</div>
