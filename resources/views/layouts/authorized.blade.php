<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Система сбора и хранения логов - Личный кабинет</title>
        <link rel="stylesheet"
              href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
              integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ"
              crossorigin="anonymous" />
        <link rel="stylesheet"
              href="/css/authorized.css"
              type="text/css" />
    </head>
    <body>
        <header class="container">
            <h1>Система сбора и хранения логов</h1>
            <nav class="menu btn-group" role="group" aria-label="Nav menu">
                <a href="{{ route('projects.list') }}" class="btn btn-secondary">
                    Проекты
                </a>
                <a href="{{ route('statistic.list') }}" class="btn btn-secondary">
                    Статистика
                </a>
            </nav>
        </header>
        <div class="container authorized-container">
            @yield('content')
        </div>
    </body>
</html>
