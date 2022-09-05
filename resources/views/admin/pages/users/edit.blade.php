@extends('adminlte::page')

@section('title', "Editar o Usuários {{ $user->name }}")

@section('content_header')
    <h1>Editar o Usuários {{ $user->name }}</h1>
@stop

@section('content')
    
    <form action="{{ route('users.update', $user->id) }}" method="post" class="form">
        @method('PUT')
        @csrf
        @include('admin.pages.users.forms.default')
        <x-adminlte-button class="btn-flat" type="submit" label="Cadastrar" theme="success" icon="fas fa-lg fa-save"/>
    </form>
@stop
