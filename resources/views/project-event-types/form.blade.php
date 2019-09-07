@extends('layouts.authorized')

@section('content')
    <div class="authorized-page-content">
        <h2>
            {{ $model ?? null ? 'Редактировать тип события проекта' : 'Добавить тип события проекта' }}
        </h2>
        <form action="{{ $model ?? null ? route('project.event-types.update', ['event' => $model->id]) : route('project.event-types.add', ['project' => $project->id]) }}"
              method="POST"
              class="login-form">
            @csrf
            <div class="form-group">
                <label for="name">Наименование типа события проекта:</label>
                <input type="text"
                       required
                       id="name"
                       name="name"
                       class="form-control"
                       value="{{ $model ?? null ? $model->name : '' }}"
                />
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">
                    Сохранить
                </button>
            </div>
        </form>
    </div>
@stop
