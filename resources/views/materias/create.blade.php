@extends('layouts.app')

@section('content')
<div class="container col-md-8">
    <h3 class="fw-bold text-center mb-4">Registrar Materia</h3>

    <form action="{{ route('materias.store') }}" method="POST">
        @csrf
        @include('materias.partials.form', ['modo' => 'crear'])
    </form>
</div>
@endsection
