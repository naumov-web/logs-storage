@extends('layouts.authorized')

@section('content')
    <div class="projects-page-content authorized-page-content">
        <h2>Проекты</h2>
        <div class="add-button-row">
            <a href="{{ route('projects.add-form') }}" class="btn btn-success">
                Добавить
            </a>
        </div>
        <div class="list-items">
            <table class="table table-bordered table-striped">
                <thead>
                    <th>
                        Id
                    </th>
                    <th>
                        Наименование
                    </th>
                    <th>
                        Сайт
                    </th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach($items as $item )
                        <tr>
                            <td>
                                {{ $item->id }}
                            </td>
                            <td>
                                {{ $item->name }}
                            </td>
                            <td>
                                {{ $item->site_url }}
                            </td>
                            <td>
                                <a href="" class="btn btn-warning">
                                    Редактировать
                                </a>
                            </td>
                            <td>
                                <a href="" class="btn btn-danger">
                                    Удалить
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @include('components.pagination', [
            'pages_count' => $pages_count,
            'limit' => $limit,
            'offset' => $offset,
            'list_route_name' => $list_route_name,
        ])
    </div>
@stop
