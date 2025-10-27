@extends('layouts.app')

@section('content')
<div class="container col-md-8">
    <h3 class="fw-bold text-center mb-4">Registrar Aula</h3>

    <form action="{{ route('aulas.store') }}" method="POST">
        @csrf
        @include('aulas.partials.form', ['modo' => 'crear'])
    </form>
</div>
@endsection
