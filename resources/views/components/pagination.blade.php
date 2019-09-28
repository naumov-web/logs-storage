<?php
    $request_data = isset($custom_request_data) ? $custom_request_data : [];
?>
@if($pages_count > 1)
    <ul class="pagination">
        @for($i = 0; $i < $pages_count; $i++)
            <li class="page-item {{ $offset == $i * $limit ? 'active' : '' }}">
                <a class="page-link"
                   href="{{ route($list_route_name,
                                    array_merge(
                                        ['limit' => $limit, 'offset' => $i * $limit],
                                        $request_data
                                    )
                                 ) }}">
                    {{ $i + 1 }}
                </a>
            </li>
        @endfor
    </ul>
@endif
