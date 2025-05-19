@extends('components.layouts.app')

@section('subtitle', 'Copia de ticket')

@section('content')
<div>
    <livewire:nuevo-ticket :uniqueId="$uniqueId" />
</div>
@endsection

 
