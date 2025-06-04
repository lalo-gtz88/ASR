@extends('components.layouts.app')

@section('subtitle', 'Catálogo de ')

@section('content')
@if($tipo == 'edificios')
<livewire:edificios-cat />
@endif

@endsection