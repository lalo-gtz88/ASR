@extends('components.layouts.app')

@section('subtitle', 'Ver Enlace')

@section('content')
<div>
    <livewire:ver-enlace :uniqueId="$uniqueId" />
</div>
@endsection

 
