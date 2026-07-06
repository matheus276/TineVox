<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gravações | {{ env('APP_NAME') }}</title>
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
                <h1>Gravações</h1>
                <div class="d-flex justify-content-end mb-3">
        <form method="GET">
            <select name="per_page"
                    class="form-select"
                    onchange="this.form.submit()">

                <option value="10"
                    {{ request('per_page', 10) == 10 ? 'selected' : '' }}>
                    10 registros
                </option>

                <option value="20"
                    {{ request('per_page') == 20 ? 'selected' : '' }}>
                    20 registros
                </option>

                <option value="50"
                    {{ request('per_page') == 50 ? 'selected' : '' }}>
                    50 registros
                </option>

                <option value="100"
                    {{ request('per_page') == 100 ? 'selected' : '' }}>
                    100 registros
                </option>
            </select>
        </form>
    </div>
                <table class="table table-striped" id="historicoChamadas">
                    <thead>
                        <tr>
                            <th>Arquivo</th>
                            <th>Data</th>
                            <th>Ouvir</th>
                            <th>Download</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($arquivos as $arquivo)
                        <tr>
                            <td>{{ $arquivo->getFilename() }}</td>
                            <td>{{ date('d/m/Y H:i:s', $arquivo->getMTime()) }}</td>

                            <td>
                                <audio controls>
                                    <source src="{{ route('recording.play', $arquivo->getFilename()) }}">
                                    Seu navegador não suporta áudio.
                                </audio>
                            </td>

                            <td>
                                <a href="{{ route('recording.download', $arquivo->getFilename()) }}"
                                class="btn btn-primary">
                                    Download
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-4">
                    {{ $arquivos->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>