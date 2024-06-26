@extends('layout')
@section('content')
@if (Session::has('success'))
    <div>{{Session::get('success')}}</div>
@endif
<form action="{{route('users.store')}}" method="post">
    @csrf
    <label for="name">Nombre</label>
    <input type="name" name="name" id="name">
    <label for="username">Nombre de usuario</label>
    <input type="username" name="username" id="username">
    <label for="password">Password</label>
    <input type="password" name="password" id="password">
    <label for="confirmPassword">Confirma password</label>
    <input type="password" name="confirmPassword" id="confirmPassword">
    <button type="submit">Guardar</button>
</form>
@endsection