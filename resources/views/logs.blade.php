<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs</title>

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
                <h1>Logs</h1>

                <div class="row g-2 align-items-center justify-content-between mb-3">
                    <div class="col-md-6">
                        <form method="GET" class="d-flex gap-2">
                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   value="{{ old('search', $search) }}"
                                   placeholder="Pesquisar dispositivo">
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

                <table class="table table-striped" id="historicoChamadas">
                    <thead>
                        <tr>
                            <th>Dispositivo</th>
                            <th>Status</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody id="historicoTabela">
                        @forelse($logs as $log)
                            <tr>
                                <td>{{ $log->ramal }}</td>
                                <td>{{ $log->status }}</td>
                                <td>{{ $log->data_evento }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Nenhum resultado encontrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-4">
                    {{ $logs->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>