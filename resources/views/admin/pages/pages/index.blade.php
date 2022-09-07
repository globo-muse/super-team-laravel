@extends('adminlte::page')

@section('title', 'Paginas SEO')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('pages-seo.index') }}" class="active">Paginas SEO</a></li>
    </ol>

    <h1>Paginas SEO <a href="{{ route('pages-seo.create') }}" class="btn btn-dark">ADD</a></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            {{-- <form action="{{ route('pages-seo.search') }}" method="POST" class="form form-inline">
                @csrf
                <input type="text" name="filter" placeholder="Filtrar:" class="form-control" value="{{ $filters['filter'] ?? '' }}">
                <button type="submit" class="btn btn-dark">Filtrar</button>
            </form> --}}
        </div>
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th width="150">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pages as $page)
                        <tr>
                            <td>{{ $page->title }}</td>
                            <td>{{ $page->slug }}</td>
                            <td style="width=10px;">
                                <a href="{{ route('pages-seo.edit', $page->id) }}" class="btn btn-info">Edit</a>
                                <a href="{{ route('pages-seo.show', $page->id) }}" class="btn btn-warning">VER</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{-- @if (isset($filters))
                {!! $pages->appends($filters)->links() !!}
            @else
                {!! $pages->links() !!}
            @endif --}}
        </div>
    </div>
@stop
