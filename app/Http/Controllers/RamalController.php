<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RamalController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        /*
        |--------------------------------------------------------------------------
        | AUTH
        |--------------------------------------------------------------------------
        */

        
        $token = session('access_token');
        $id_user = session('id_user');

        if (!$token || !$id_user) {
            return response()->json([
                'erro' => true,
                'mensagem' => 'Usuário não autenticado'
            ], 401);
        }

        /*
        |--------------------------------------------------------------------------
        | RAMAIS PERMITIDOS
        |--------------------------------------------------------------------------
        */

        $apiUrl = "http://localhost:5000/ramais/listar/{$id_user}";

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Authorization: Bearer '.$token
            ]
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $dadosApi = json_decode($response, true);

        if (!$dadosApi || !isset($dadosApi['ramais'])) {
            return response()->json([
                'erro' => true,
                'mensagem' => 'Erro ao buscar ramais'
            ]);
        }

        $ramaisPermitidos = array_map(
            'strval',
            $dadosApi['ramais']
        );

        /*
        |--------------------------------------------------------------------------
        | AMI
        |--------------------------------------------------------------------------
        */

        $ramais = [];

        $socket = @fsockopen("127.0.0.1", 5038);

        if ($socket) {

            fputs($socket, "Action: Login\r\n");
            fputs($socket, "Username: frontend\r\n");
            fputs($socket, "Secret: Tine@1414\r\n\r\n");

            fputs($socket, "Action: PJSIPShowEndpoints\r\n\r\n");

            $ramalAtual = '';

            while (!feof($socket)) {

                $linha = trim(fgets($socket, 4096));

                if (strpos($linha, 'ObjectName:') === 0) {

                    $ramalAtual = trim(substr($linha, 11));

                    if (!in_array($ramalAtual, $ramaisPermitidos)) {
                        $ramalAtual = '';
                        continue;
                    }

                    $ramais[$ramalAtual] = [
                        'ramal' => $ramalAtual,
                        'status' => 'offline',
                        'destino' => ''
                    ];
                }

                if (
                    strpos($linha, 'DeviceState:') === 0
                    && $ramalAtual
                ) {

                    $estado = strtolower(
                        trim(substr($linha, 12))
                    );

                    if ($estado === 'not in use') {
                        $ramais[$ramalAtual]['status'] = 'online';
                    }

                    if ($estado === 'in use') {
                        $ramais[$ramalAtual]['status'] = 'ligacao';
                    }

                    if ($estado === 'ringing') {
                        $ramais[$ramalAtual]['status'] = 'tocando';
                    }

                    if ($estado === 'unavailable') {
                        $ramais[$ramalAtual]['status'] = 'offline';
                    }
                }

                if ($linha === 'Event: EndpointListComplete') {
                    break;
                }
            }

            fclose($socket);
        }

        /*
        |--------------------------------------------------------------------------
        | HISTÓRICO
        |--------------------------------------------------------------------------
        */

        $historico = [];

        $arquivoCdr = '/var/log/asterisk/cdr-csv/Master.csv';

        if (file_exists($arquivoCdr)) {

            $linhas = array_reverse(
                file($arquivoCdr)
            );

            foreach ($linhas as $linha) {

                $dados = str_getcsv($linha);

                if (count($dados) < 15) {
                    continue;
                }

                $origem = trim($dados[1], '"');
                $destino = trim($dados[2], '"');

                if (
                    !in_array($origem, $ramaisPermitidos) &&
                    !in_array($destino, $ramaisPermitidos)
                ) {
                    continue;
                }

                $historico[] = [
                    'data' => date(
                        'd/m/Y H:i:s',
                        strtotime($dados[9])
                    ),
                    'origem' => $origem,
                    'destino' => $destino,
                    'duracao' => (int) $dados[12],
                    'tempo_conversa' => (int) $dados[13],
                    'status' => trim($dados[14], '"')
                ];

                if (count($historico) >= 5) {
                    break;
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'ramais' => array_values($ramais),
            'historico' => $historico
        ]);
    }
}