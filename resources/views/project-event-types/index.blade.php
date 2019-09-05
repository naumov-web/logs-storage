@extends('layouts.authorized')

@section('content')
    <div class="projects-page-content authorized-page-content">
        <h2>Типы событий проекта "{{ $project->name }}"</h2>
        <div class="add-button-row">
            <a href="{{ route('project.event-types.add-form', ['project' => $project->id]) }}" class="btn btn-success">
                Добавить
            </a>
        </div>
    </div>
@stop
