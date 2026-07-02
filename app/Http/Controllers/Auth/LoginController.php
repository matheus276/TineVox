<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    private $API_URL;

    public function __construct()
    {
        $this->API_URL = env('API_URL', '/') . '/auth/login';
    }

    public function form() // Exibe o formulário de login
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $request-> validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $response = Http::post($this->API_URL, [
            'usuario' => $request->username,
            'senha' => $request->password,
        ]);

        
        $data = $response->json();

        if ($response->successful() && !empty($data['access_token'])) {

            $ramaisResponse = Http::withToken($data['access_token'])
                ->get(
                    env('API_URL') . '/ramais/listar/' . $data['idUser']
                );

            $ramaisData = $ramaisResponse->json();

            session([
                'access_token' => $data['access_token'],
                'usuario' => $data['usuario'] ?? '',
                'tipo_usuario' => $data['tipoUsuario'] ?? '',
                'id_user' => $data['idUser'] ?? null,
                'condominio' => $ramaisData['condominio'] ?? null,
            ]);

            return redirect('/dashboard');
        }


        return back()->withErrors([
            'login' => $data['erro'] ?? 'Credenciais inválidas'
        ]);
    }

    public function logout()
    {
        session()->flush(); // limpa tudo da sessão

        return redirect('/login');
    }

}