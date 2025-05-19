@extends('components.layouts.app')

@section('subtitle', "Seguimiento de ticket" )

@section('content')
<livewire:historial-ticket :id="$uniqueId" />
@endsection