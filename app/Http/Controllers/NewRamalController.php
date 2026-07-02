<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NewRamalController extends Controller
{       
    private $API_URL;
    
    public function __construct()
    {
        $this->API_URL = env('API_URL', '/') . '/ramais/criar_ramal';
    }
    
    public function index() {
        if (!session()->has('access_token') || session('tipo_usuario') !== 'admin') {
            return redirect('/login');
        }    
        return view('new_ramal');
    }

    public function criar_ramal(Request $request)
    {
        $request->validate([
            'ramal' => 'required',
            'senha' => 'required',
        ]);

        $token = session('access_token');

        $response = Http::withToken($token)
            ->post($this->API_URL, [
                'ramal' => $request->ramal,
                'senha' => $request->senha,
            ]);

        $data = $response->json();

        if ($response->successful()) {
            return redirect()
                ->back()
                ->with('success', $data['mensagem'] ?? 'Ramal criado com sucesso.');
        }

        return redirect()
            ->back()
            ->with('error', $data['erro'] ?? 'Erro ao criar ramal.');
    }

}