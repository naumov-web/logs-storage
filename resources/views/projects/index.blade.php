@extends('layouts.authorized')

@section('content')
    <div class="projects-page-content authorized-page-content">
        <h2>Проекты</h2>
        <div class="add-button-row">
            <a href="{{ route('projects.add-form') }}" class="btn btn-success">
                Добавить
            </a>
        </div>
    </div>
@stop
