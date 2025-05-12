@extends('components.layouts.app')

@section('subtitle', 'Editar Enlace')

@section('content')
<div>
    <livewire:editar-enlace :uniqueId="$uniqueId" />
</div>
@endsection

 
