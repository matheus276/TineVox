<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Ramal | {{ env('APP_NAME') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="{{ asset('js/main.js') }}"></script>
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/gravacoes.css') }}" rel="stylesheet">
</head>
<body>
    <div class="layout">
        @include('sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content">
            <div class="container mt-5 gravacoes">
                <h1>Criar Ramal</h1>

                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        {{-- Mensagem de sucesso --}}
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        {{-- Mensagem de erro --}}
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        {{-- Erros de validação --}}
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $erro)
                                        <li>{{ $erro }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('ramal.criar') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="ramal" class="form-label">Ramal</label>
                                <input type="text"
                                    class="form-control"
                                    id="ramal"
                                    name="ramal"
                                    value="{{ old('ramal') }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="senha" class="form-label">Senha</label>
                                <input type="password"
                                    class="form-control"
                                    id="senha"
                                    name="senha"
                                    required>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Criar Ramal
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>