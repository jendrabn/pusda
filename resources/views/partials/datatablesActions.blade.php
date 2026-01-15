<div class="action-buttons">
    @if (Route::has('admin.' . $crudRoutePart . '.show'))
        <a class="btn btn-sm btn-primary"
           href="{{ route('admin.' . $crudRoutePart . '.show', $row->id) }}"
           title="View">
            <i class="fas fa-eye"></i>
        </a>
    @endif

    @if (Route::has('admin.' . $crudRoutePart . '.edit'))
        <a class="btn btn-sm btn-warning"
           href="{{ route('admin.' . $crudRoutePart . '.edit', $row->id) }}"
           title="Edit">
            <i class="fas fa-pencil-alt"></i>
        </a>
    @endif

    @if (Route::has('admin.' . $crudRoutePart . '.destroy'))
        <form action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}"
              class="m-0 p-0"
              method="POST"
              onsubmit="return confirm('Are you sure?');">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger"
                    title="Delete"
                    type="submit">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    @endif
</div>
