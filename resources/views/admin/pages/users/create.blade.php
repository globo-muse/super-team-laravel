@extends('adminlte::page')

@section('title', "Cadastrar um Usuário")

@section('content_header')
    <h1>Cadastrar um Usuário</h1>
@stop

@section('content')
    @include('admin.includes.alerts')
    <form action="{{ route('users.store') }}" method="post" class="form" enctype="multipart/form-data">
        @csrf
        @include('admin.pages.users.forms.default')
        <x-adminlte-button class="btn-flat" type="submit" label="Cadastrar" theme="success" icon="fas fa-lg fa-save"/>
    </form>
@stop
