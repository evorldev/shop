@extends('layouts.app')

@section('content')
    @auth
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            @method('DELETE')

            <button type="submit">{{ auth()->user()->name }} (Выйти)</button>
        </form>
    @endauth
    @guest
        <a href="{{ route('login') }}">Вход</a>
    @endguest
@endsection
 