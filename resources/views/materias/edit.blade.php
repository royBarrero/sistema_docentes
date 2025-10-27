@extends('layouts.app')

@section('content')
<div class="container col-md-8">
    <h3 class="fw-bold text-center mb-4">Editar Materia</h3>

    <form action="{{ route('materias.update', $materia->id) }}" method="POST">
        @csrf @method('PUT')
        @include('materias.partials.form', ['modo' => 'editar'])
    </form>
</div>
@endsection
