@extends('adminlte::page')

@section('title', "Editar a categoria {$page->title}")

@section('content_header')
    <h1>Editar a categoria {{ $page->title }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('pages-seo.update', $page->id) }}" class="form" method="POST">
                @csrf
                @method('PUT')

                @include('admin.pages.pages._partials.form')
            </form>
        </div>
    </div>
@endsection