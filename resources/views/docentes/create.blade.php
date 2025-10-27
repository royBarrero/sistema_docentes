@extends('layouts.app')

@section('content')
<div class="container col-md-8">
    <h3 class="fw-bold text-center mb-4">Registrar Docente</h3>

    <form action="{{ route('docentes.store') }}" method="POST">
        @csrf
        @include('docentes.partials.form', ['modo' => 'crear'])
    </form>
</div>
@endsection
