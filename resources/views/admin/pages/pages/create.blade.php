@extends('adminlte::page')

@section('title', 'Cadastrar Nova Pagina SEO')

@section('content_header')
    <h1>Cadastrar Nova Pagina SEO</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('pages-seo.store') }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf

                @include('admin.pages.pages._partials.form')
            </form>
        </div>
    </div>
@endsection
