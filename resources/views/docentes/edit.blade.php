@extends('layouts.app')

@section('content')
<div class="container col-md-8">
    <h3 class="fw-bold text-center mb-4">Editar Docente</h3>

    <form action="{{ route('docentes.update', $docente->id) }}" method="POST">
        @csrf @method('PUT')
        @include('docentes.partials.form', ['modo' => 'editar'])
    </form>
</div>
@endsection
