@extends('adminlte::page')

@section('title', 'Cadastrar Departamento')

@section('content_header')
    <h1>Cadastrar Departamento</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('departments.store') }}" class="form" method="POST">
                @include('admin.pages.departments._partials.form')
            </form>
        </div>
    </div>
@endsection
