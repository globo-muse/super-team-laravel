@include('admin.includes.alerts')

<div class="form-group">
    <label>Titulo:</label>
    <input type="text" name="title" class="form-control" placeholder="Nome:" value="{{ $page->title ?? old('title') }}">
</div>

<div class="form-group">
    <label>Meta Titulo:</label>
    <input type="text" name="meta_title" class="form-control" placeholder="Nome:" value="{{ $page->meta_title ?? old('meta_title') }}">
</div>

<div class="form-group">
    <label>Path:</label>
    <input type="text" name="path" class="form-control" placeholder="Nome:" value="{{ $page->path ?? old('path') }}">
</div>

<x-adminlte-input-file name="image" placeholder="Imagem para SEO...">
    <x-slot name="prependSlot">
        <div class="input-group-text bg-lightblue">
            <i class="fas fa-upload"></i>
        </div>
    </x-slot>
</x-adminlte-input-file>

<div class="form-group">
    <label>Descrição:</label>
    <textarea name="description" ols="30" rows="5" class="form-control">{{ $page->description ?? old('description') }}</textarea>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-dark">Enviar</button>
</div>
