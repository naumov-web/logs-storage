@extends('layouts.authorized')
<?php
/**
 * @var $projects
 * @var $items
 */
?>
@section('content')
    <script type="text/javascript" src="/js/logs-index-page.js"></script>
    <div class="logs-page-content authorized-page-content">
        <h2>Лог событий</h2>
        <div class="filters-wrapper">
            <div class="show-filters">
                <button type="button" class="btn btn-primary show-filters-button">Фильтры</button>
            </div>
            <form method="get" action="" class="filters-inner" style="display: none;">
                <div class="form-group">
                    <label for="project_id">Проект:</label>
                    <select name="project_id" class="form-control">
                        <option value=""> --- </option>
                        <?php foreach($projects as $project) { ?>
                            <option
                                value="{{ $project->id }}"
                                <?php echo request()->get('project_id') == $project->id ?
                                        'selected="selected"' : '' ?>>
                                {{ $project->name }}
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Показать</button>
                </div>
            </form>
        </div>
        <div class="list-items">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Тип события</th>
                        <th>Проект</th>
                        <th>Id пользователя проекта</th>
                        <th>Дата события</th>
                        <th>Время события</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($items as $item) { ?>
                        <?php
                            $project = $item->getRelationContent('project');
                            $project_event_type = $item->getRelationContent('project_event_type');
                        ?>
                        <tr>
                            <td>{{ $project_event_type ? $project_event_type['name'] : '' }}</td>
                            <td>{{ $project ? $project['name'] : '' }}</td>
                            <td>{{ $item['external_user_id'] }}</td>
                            <td>{{ $item['event_date'] }}</td>
                            <td>{{ date('H:i:s', strtotime($item['event_time'])) }}</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
@stop
