@if($pages_count > 1)
    <ul class="pagination">
        @for($i = 0; $i < $pages_count; $i++)
            <li class="page-item {{ $offset == $i * $limit ? 'active' : '' }}">
                <a class="page-link"
                   href="{{ route($list_route_name, ['limit' => $limit, 'offset' => $i * $limit]) }}">
                    {{ $i + 1 }}
                </a>
            </li>
        @endfor
    </ul>
@endif
