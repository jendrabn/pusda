  @if (Route::has('admin.' . $crudRoutePart . '.show'))
    <a class="btn btn-xs btn-primary" href="{{ route('admin.' . $crudRoutePart . '.show', $row->id) }}">
      View
    </a>
  @endif
  @if (Route::has('admin.' . $crudRoutePart . '.edit'))
    <a class="btn btn-xs btn-info" href="{{ route('admin.' . $crudRoutePart . '.edit', $row->id) }}">
      Edit
    </a>
  @endif
  @if (Route::has('admin.' . $crudRoutePart . '.destroy'))
    <form style="display: inline-block;" action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}"
          method="POST" onsubmit="return confirm('Are You Sure?');">
      @method('DELETE')
      @csrf
      <input class="btn btn-xs btn-danger" type="submit" value="Delete">
    </form>
  @endif
