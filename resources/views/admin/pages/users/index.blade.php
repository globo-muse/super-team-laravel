@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <h1>Usuários <a href="{{ route('users.create') }}" class="btn btn-info"><i class="fas fa-plus"></i></a></h1>
@stop

@section('content')
    @include('admin.includes.alerts')
<div class="card">
    <div class="card-header">
        {{-- <form>
            <x-adminlte-input name="q" placeholder="termo" igroup-size="md" value="{{ $filters['q'] ?? '' }}">
                <x-slot name="appendSlot">
                    <x-adminlte-button theme="outline-danger" label="Ir!"/>
                </x-slot>
                <x-slot name="prependSlot">
                    <div class="input-group-text text-danger">
                        <i class="fas fa-search"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </form> --}}
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <th>Nome</th>
                <th>E-mail</th>
                <th width="200px">Ações</th>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <form action="{{ route('users.destroy', $user->id) }}" class="form form-inline" method="POST">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info mr-1" title="Editar o GF {{ $user->name }}"><i class="fas fa-pen"></i></a>
                            <button type="submit" class="btn btn-danger" title="Deletar o Candidato {{ $user->name }}"><i class="fas fa-minus-circle"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
         :D
        @if (!empty($filters))
            {{-- {!! $users->appends($filters)->links() !!} --}}
        @else
            {{-- {!! $users->links() !!} --}}
        @endif
    </div>
</div>
@stop
