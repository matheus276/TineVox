<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="{{ asset('js/main.js') }}"></script>
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/gravacoes.css') }}" rel="stylesheet">
    <title>Criar Condominio</title>
</head>
<body>
    <div class="layout">
        @include('sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content">
            <div class="container mt-5 gravacoes">
                <div class="row">
                    <div class="col-md-8">
                        <h1>Criar Novo Condominio</h1>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Erro ao criar condominio:</strong>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('condominios.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('nome') is-invalid @enderror"
                                       id="nome"
                                       name="nome"
                                       value="{{ old('nome') }}"
                                       required>
                                @error('nome')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="cnpj" class="form-label">CNPJ</label>
                                <input type="text"
                                       class="form-control @error('cnpj') is-invalid @enderror"
                                       id="cnpj"
                                       name="cnpj"
                                       value="{{ old('cnpj') }}"
                                       placeholder="00.000.000/0000-00">
                                @error('cnpj')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="endereco" class="form-label">Endereço</label>
                                <input type="text"
                                       class="form-control @error('endereco') is-invalid @enderror"
                                       id="endereco"
                                       name="endereco"
                                       value="{{ old('endereco') }}">
                                @error('endereco')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="telefone" class="form-label">Telefone</label>
                                        <input type="text"
                                               class="form-control @error('telefone') is-invalid @enderror"
                                               id="telefone"
                                               name="telefone"
                                               value="{{ old('telefone') }}"
                                               placeholder="(00) 00000-0000">
                                        @error('telefone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               id="email"
                                               name="email"
                                               value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="pasta_gravacoes" class="form-label">Pasta de Gravações</label>
                                <input type="text"
                                       class="form-control @error('pasta_gravacoes') is-invalid @enderror"
                                       id="pasta_gravacoes"
                                       name="pasta_gravacoes"
                                       value="{{ old('pasta_gravacoes') }}"
                                       placeholder="Ex: brisas">
                                @error('pasta_gravacoes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox"
                                       class="form-check-input"
                                       id="ativo"
                                       name="ativo"
                                       value="1"
                                       {{ old('ativo') ? 'checked' : '' }}>
                                <label class="form-check-label" for="ativo">
                                    Ativo
                                </label>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Criar
                                </button>
                                <a href="{{ route('condominios.index') }}" class="btn btn-secondary">
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
