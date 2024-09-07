@if ($category->childs->count())
    <ul>
        @foreach ($category->childs as $child)
            <li>
                {{ $child->nama_menu }}
                @include('admin.treeview.partials.menu', ['category' => $child])
            </li>
        @endforeach
    </ul>
@endif
