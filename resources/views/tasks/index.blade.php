@extends('layouts.app')

@section('content')
    
    <!-- ログイン状態 -->
    @if (Auth::check())
        {{ Auth::user()->name }}
    <!-- 未ログイン状態 -->
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>Welcome to the Tasklist</h1>
                {!! link_to_route('signup.get', 'Sign up now!', [], ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
        </div>
    @endif
@endsection