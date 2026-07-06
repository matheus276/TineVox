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
    <title>Condominios</title>
</head>
<body>
    <div class="layout">
        @include('sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content">
            <div class="container mt-5 gravacoes">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Condominios</h1>
                    <a href="{{ route('condominios.create') }}" class="btn btn-success">
                        <i class="bi bi-building"></i> Novo Condominio
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row g-2 align-items-center justify-content-between mb-3">
                    <div class="col-md-6">
                        <form method="GET" class="d-flex gap-2">
                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   value="{{ old('search', $search) }}"
                                   placeholder="Pesquisar condominio">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </form>
                    </div>

                    <div class="col-md-3 ms-auto">
                        <form method="GET">
                            <input type="hidden" name="search" value="{{ $search }}">
                            <select name="per_page" class="form-select" onchange="this.form.submit()">
                                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 registros</option>
                                <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20 registros</option>
                                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 registros</option>
                                <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100 registros</option>
                            </select>
                        </form>
                    </div>
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Endereço</th>
                            <th>Ativo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($condominios as $condominio)
                            <tr>
                                <td>{{ $condominio->nome }}</td>
                                <td>{{ $condominio->email ?? '-' }}</td>
                                <td>{{ $condominio->telefone ?? '-' }}</td>
                                <td>{{ $condominio->endereco ?? '-' }}</td>
                                <td>
                                    @if($condominio->ativo)
                                        <span class="badge bg-success">Ativo</span>
                                    @else
                                        <span class="badge bg-danger">Inativo</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('condominios.edit', $condominio->id_condominio) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                    <form action="{{ route('condominios.destroy', $condominio->id_condominio) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja deletar este condominio?')">
                                            <i class="bi bi-trash"></i> Deletar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Nenhum condominio encontrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-4">
                    {{ $condominios->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
