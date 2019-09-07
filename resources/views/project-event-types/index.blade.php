@extends('layouts.authorized')

@section('content')
    <div class="projects-page-content authorized-page-content">
        <h2>Типы событий проекта "{{ $project->name }}"</h2>
        <div class="add-button-row">
            <a href="{{ route('project.event-types.add-form', ['project' => $project->id]) }}" class="btn btn-success">
                Добавить
            </a>
        </div>
        <div class="list-items">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Наименование</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item )
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                <a href="{{ route('project.event-types.update-form', ['event' => $item->id]) }}" class="btn btn-warning">
                                    Редактировать
                                </a>
                            </td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
