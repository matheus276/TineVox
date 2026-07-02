<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    
    <title>Document</title>
</head>
<body>
    <div class="layout">
            @include('sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content">
            <div id="ramais">
                <h1>Ramais - {{ session('condominio') }}</h1>
                <div class="row" id="painel"></div>
            </div>

            <br><br>
            <div class="historico card  mb-3 ">
                <div class=""><h4>Histórico de Chamadas</h4></div>
                <div class="card-body">
                    <table class="table table-striped" id="historicoChamadas">
                        <thead>
                            <tr>
                                <th scope="col">Data/Hora</th>
                                <th scope="col">Ramal</th>
                                <th scope="col">Destino</th>
                                <th scope="col">Duração</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody id="historicoTabela">
                        <tr>
                            <td colspan="5" class="text-center">
                                Carregando...
                            </td>
                        </tr>
                    </tbody>
                    </table>
                </div>
        </main>
    </div>
</body>
</html>