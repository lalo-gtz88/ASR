@extends('components.layouts.app')

@section('subtitle', 'Detalles de equipo')

<style>
    .table-details td:first-child {
        background-color: #495057;
        color: #FFF;
    }
</style>


@section('content')
<div>
    <livewire:equipo-details :uniqueId="$uniqueId" />
</div>
@endsection