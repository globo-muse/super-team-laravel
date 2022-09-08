@extends('adminlte::page')

@section('title', 'Departamento')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('departments.index') }}" class="active">Departamento</a></li>
    </ol>

    <h1>Departamento <a href="{{ route('departments.create') }}" class="btn btn-dark">+</a></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            @include('admin.includes.alerts')
        </div>
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th width="200">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>
                                {{ $item->name }}
                            </td>
                            <td style="width=10px;">
                                <form action="{{ route('departments.destroy', $item->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('departments.edit', $item->id) }}" class="btn btn-warning">editar</a>
                                    <input type="submit" value="X" class="btn btn-primary" />
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
        </div>
    </div>
@stop
