@extends('components.layouts.app')

@section('subtitle', 'Roles')

@section('content')
<div>
    <livewire:roles-component :id="$id" /></div>
@endsection