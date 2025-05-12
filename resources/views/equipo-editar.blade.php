@extends('components.layouts.app')

@section('subtitle', 'Editar equipo')

@section('content')
<div>
    <livewire:editar-equipo :uniqueId="$uniqueId" />
</div>
@endsection