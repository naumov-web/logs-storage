@extends('layouts.authorized')

@section('content')
    <div class="authorized-page-content">
        <h2>
            {{ $model ?? null ? 'Редактировать проект' : 'Добавить проект' }}
        </h2>
        <form action="{{ $model ?? null ? route('projects.update', ['project' => $model->id]) : route('projects.add') }}"
              method="POST"
              class="login-form">
            @csrf
            <div class="form-group">
                <label for="name">Наименование проекта:</label>
                <input type="text" required id="name" name="name" class="form-control" />
            </div>
            <div class="form-group">
                <label for="site_url">URL-адрес проекта:</label>
                <input type="text" id="site_url" name="site_url" class="form-control" />
            </div>
            <div class="form-group">
                <label for="api_key">API-ключ проекта:</label>
                <textarea id="api_key" name="api_key" readonly class="form-control"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">
                    Сохранить
                </button>
            </div>
        </form>
    </div>
@stop
