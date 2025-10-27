@extends('layouts.app')

@section('content')
<div class="container col-md-8">
    <h3 class="fw-bold text-center mb-4">Editar Aula</h3>

    <form action="{{ route('aulas.update', $aula->id) }}" method="POST">
        @csrf @method('PUT')
        @include('aulas.partials.form', ['modo' => 'editar'])
    </form>
</div>
@endsection

