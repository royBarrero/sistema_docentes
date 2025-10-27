@extends('layouts.app')

@section('content')
<div class="container col-md-8">
    <h3 class="fw-bold text-center mb-4">Editar Grupo</h3>

    <form action="{{ route('grupos.update', $grupo->id) }}" method="POST">
        @csrf @method('PUT')
        @include('grupos.partials.form', ['modo' => 'editar'])
    </form>
</div>
@endsection
