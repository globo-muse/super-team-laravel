<x-adminlte-input name="name" type="text" placeholder="Nome do Usuário" value="{{ $user->name ?? old('name') }}" />

<x-adminlte-input name="email" type="text" placeholder="E-mail do Usuário" value="{{ $user->email ?? old('email') }}" />

<x-adminlte-input name="role" type="text" placeholder="Cargo" value="{{ $user->role ?? old('role') }}" />

<x-adminlte-input-file name="image" placeholder="Foto de usuário...">
    <x-slot name="prependSlot">
        <div class="input-group-text bg-lightblue">
            <i class="fas fa-upload"></i>
        </div>
    </x-slot>
</x-adminlte-input-file>

<x-adminlte-input name="password" type="password" placeholder="Senha do Usuário" value="" />
