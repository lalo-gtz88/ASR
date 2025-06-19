@extends('components.layouts.app')

@section('subtitle', 'Catálogo de ')

@section('content')
@if($tipo == 'edificios')
<livewire:edificios-cat />
@endif

@if($tipo == 'departamentos')
<livewire:departamentos-cat />
@endif

@if($tipo == 'categorias')
<livewire:categorias-cat />
@endif

@if($tipo == 'segmentos')
<livewire:segmentos-cat />
@endif

@if($tipo == 'marcas')
<livewire:marcas-cat />
@endif


@endsection