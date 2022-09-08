@extends('adminlte::page')

@section('title', "Editar o Departamento {$item->name}")

@section('content_header')
    <h1>Editar o Departamento {{ $item->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('departments.update', $item->id) }}" class="form" method="POST">
                @method('PUT')

                @include('admin.pages.departments._partials.form')
            </form>
        </div>
    </div>
@endsection
