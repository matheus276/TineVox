<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="{{ asset('js/main.js') }}"></script>
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/gravacoes.css') }}" rel="stylesheet">
    <title>{{ $user ? 'Editar' : 'Criar' }} Usuário | {{ env('APP_NAME') }}</title>
</head>
<body>
    <div class="layout">
        @include('sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content">
            <div class="container mt-5 gravacoes">
                <div class="row">
                    <div class="col-md-8">
                        <h1>{{ $user ? 'Editar' : 'Criar Novo' }} Usuário</h1>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Erro ao atualizar:</strong>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ $user ? route('users.update', $user->idUser) : route('users.store') }}" method="POST">
                            @csrf
                            @if($user)
                                @method('PUT')
                            @endif

                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text"
                                       class="form-control @error('nome') is-invalid @enderror"
                                       id="nome"
                                       name="nome"
                                       value="{{ old('nome', $user?->nome) }}"
                                       required>
                                @error('nome')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', $user?->email) }}"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuário</label>
                                <input type="text"
                                       class="form-control @error('usuario') is-invalid @enderror"
                                       id="usuario"
                                       name="usuario"
                                       value="{{ old('usuario', $user?->usuario) }}"
                                       required>
                                @error('usuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="senha" class="form-label">Senha</label>
                                <input type="password"
                                       class="form-control @error('senha') is-invalid @enderror"
                                       id="senha"
                                       name="senha"
                                       placeholder="{{ $user ? 'Deixe em branco para manter a senha atual' : 'Mínimo de 6 caracteres' }}"
                                       {{ !$user ? 'required' : '' }}>
                                @error('senha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($user)
                                    <small class="form-text text-muted d-block mt-1">Mínimo de 6 caracteres. Deixe em branco para não alterar a senha.</small>
                                @else
                                    <small class="form-text text-muted d-block mt-1">Mínimo de 6 caracteres. Obrigatório para novo usuário.</small>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="tipoUsuario" class="form-label">Tipo de Usuário</label>
                                <select class="form-select @error('tipoUsuario') is-invalid @enderror"
                                        id="tipoUsuario"
                                        name="tipoUsuario"
                                        required>
                                    <option value="">Selecione um tipo</option>
                                    <option value="user" {{ old('tipoUsuario', $user?->tipoUsuario) == 'user' ? 'selected' : '' }}>Usuário</option>
                                    <option value="admin" {{ old('tipoUsuario', $user?->tipoUsuario) == 'admin' ? 'selected' : '' }}>Administrador</option>
                                </select>
                                @error('tipoUsuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Condominios</label>
                                <div class="card p-3">
                                    @forelse($condominios as $condominio)
                                        @php
                                            $isChecked = $userCondominios->contains('id_condominio', $condominio->id_condominio);
                                        @endphp
                                        <div class="form-check mb-2">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   id="cond_{{ $condominio->id_condominio }}"
                                                   name="condominios[{{ $loop->index }}][id_condominio]"
                                                   value="{{ $condominio->id_condominio }}"
                                                   {{ $isChecked ? 'checked' : '' }}>
                                            <label class="form-check-label" for="cond_{{ $condominio->id_condominio }}">
                                                {{ $condominio->nome }}
                                            </label>
                                        </div>
                                    @empty
                                        <p class="text-muted">Nenhum condominio disponível.</p>
                                    @endforelse
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> {{ $user ? 'Atualizar' : 'Salvar' }}
                                </button>
                                <a href="/users" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
