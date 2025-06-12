@extends('components.layouts.app')

@section('subtitle', 'Nuevo equipo')

@section('content')
<div>
    <livewire:form-equipo :ip="$ip" />
</div>
@endsection