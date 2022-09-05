<x-adminlte-input name="name" type="text" placeholder="Nome do Usuário" value="{{ $user->name ?? old('name') }}" />

<x-adminlte-input name="email" type="text" placeholder="E-mail do Usuário" value="{{ $user->email ?? old('email') }}" />

<x-adminlte-input name="password" type="password" placeholder="Senha do Usuário" value="" />
