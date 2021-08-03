@if ($skpd->skpdCategory)
  <div class="btn-group btn-group-sm">
    <a href="{{ route('admin.skpd.edit', $skpd->id) }}" class="btn btn-warning btn-icon"><i
        class="fas fa-pencil-alt"></i></a>
    <button data-url="{{ route('admin.skpd.destroy', $skpd->id) }}" type="button"
      class="btn btn-danger btn-icon btn-delete"><i class="fas fa-trash-alt"></i></button>
  </div>
@endif
