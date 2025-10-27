@extends('layouts.app')

@section('content')
<div class="container col-md-8">
    <h3 class="fw-bold text-center mb-4">Registrar Grupo</h3>

    <form action="{{ route('grupos.store') }}" method="POST">
        @csrf
        @include('grupos.partials.form', ['modo' => 'crear'])
    </form>
</div>
@endsection
