<div class="btn-group btn-group-xs">
    <button class="btn btn-primary btn-xs btn-grafik"
            data-url="{{ route('admin.' . $routePart . '.chart', $child->id) }}">
        Grafik
    </button>
    <a class="btn btn-xs btn-info"
       href="{{ route('admin.' . $routePart . '.edit', $child->id) }}">
        Edit
    </a>
</div>
