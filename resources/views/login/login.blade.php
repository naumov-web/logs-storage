@extends('layouts.not_authorized')

@section('content')
    <link rel="stylesheet"
          href="/css/login-form.css"
          type="text/css" />
    <div class="login-page-content">
        <h1>Авторизация</h1>
        <form action="{{ route('login') }}" method="POST" class="login-form">
            @csrf
            @include('flash::message')
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" required id="email" name="email" class="form-control" />
            </div>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" required id="password" name="password" class="form-control" />
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">
                    Войти
                </button>
            </div>
        </form>
    </div>

@stop
