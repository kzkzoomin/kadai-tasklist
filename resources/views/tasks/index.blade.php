@extends('layouts.app')

@section('content')

@if (Auth::check())
    <h1>タスク一覧</h1>
        @if (count($tasks) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>タスク</th>
                        <th>ステータス</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                    <tr>
                        <td>{!! link_to_route('tasks.show', $task->id, ['id' => $task->id]) !!}</td>
                        <td>{{ $task->content }}</td>
                        <td>{{ $task->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    
        {!! link_to_route('tasks.create', '新規タスクの登録', [], ['class' => 'btn btn-primary']) !!}
    
@else
{!! link_to_route('signup.get', 'ユーザー登録', [], ['class' => 'btn btn-primary']) !!}
{!! link_to_route('login', 'ログイン', [], ['class' => 'btn btn-primary']) !!}
@endif

@endsection