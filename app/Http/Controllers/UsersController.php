<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Condominio;
use App\Models\UserCondominio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        if (!session()->has('access_token')) {
            return redirect('/login');
        }

        $search = trim((string) $request->input('search', ''));
        $perPage = (int) $request->input('per_page', 10);
        $perPage = in_array($perPage, [10, 20, 50, 100], true) ? $perPage : 10;

        $users = User::query()
            ->orderBy('idUser', 'desc')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('idUser', 'like', "%{$search}%")
                      ->orWhere('nome', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate($perPage)
            ->appends($request->query());

        return view('users', compact('users', 'search', 'perPage'));
    }

    public function edit($idUser)
    {
        if (!session()->has('access_token')) {
            return redirect('/login');
        }

        $user = User::findOrFail($idUser);
        $condominios = Condominio::all();
        $userCondominios = UserCondominio::where('id_usuario', $idUser)->get();

        return view('users_edit', compact('user', 'condominios', 'userCondominios'));
    }

    public function update(Request $request, $idUser)
    {
        if (!session()->has('access_token')) {
            return redirect('/login');
        }

        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:usuarios,email,' . $idUser . ',idUser',
            'usuario' => 'required|string|max:50|unique:usuarios,usuario,' . $idUser . ',idUser',
            'tipoUsuario' => 'required|in:admin,user',
            'senha' => 'nullable|string|min:6',
            'condominios' => 'array',
            'condominios.*.id_condominio' => 'required|exists:condominios,id_condominio',
        ]);

        $user = User::findOrFail($idUser);
        
        // Preparar dados para atualizar
        $updateData = [
            'nome' => $validated['nome'],
            'email' => $validated['email'],
            'usuario' => $validated['usuario'],
            'tipoUsuario' => $validated['tipoUsuario'],
        ];

        // Se a senha foi fornecida, criptografá-la
        if (!empty($validated['senha'])) {
            $updateData['senha'] = Hash::make($validated['senha']);
        }

        // Atualizar dados do usuário
        $user->update($updateData);

        // Atualizar condominios
        UserCondominio::where('id_usuario', $idUser)->delete();
        
        if (!empty($validated['condominios'])) {
            foreach ($validated['condominios'] as $cond) {
                UserCondominio::create([
                    'id_usuario' => $idUser,
                    'id_condominio' => $cond['id_condominio'],
                ]);
            }
        }

        return redirect('/users')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function create()
    {
        if (!session()->has('access_token')) {
            return redirect('/login');
        }

        $user = null;
        $condominios = Condominio::all();
        $userCondominios = collect();

        return view('users_edit', compact('user', 'condominios', 'userCondominios'));
    }

    public function store(Request $request)
    {
        if (!session()->has('access_token')) {
            return redirect('/login');
        }

        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:usuarios,email',
            'usuario' => 'required|string|max:50|unique:usuarios,usuario',
            'tipoUsuario' => 'required|in:admin,user',
            'senha' => 'required|string|min:6',
            'condominios' => 'array',
            'condominios.*.id_condominio' => 'required|exists:condominios,id_condominio',
        ]);

        // Criar novo usuário com senha criptografada
        $user = User::create([
            'nome' => $validated['nome'],
            'email' => $validated['email'],
            'usuario' => $validated['usuario'],
            'tipoUsuario' => $validated['tipoUsuario'],
            'senha' => Hash::make($validated['senha']),
        ]);

        // Vincular condominios
        if (!empty($validated['condominios'])) {
            foreach ($validated['condominios'] as $cond) {
                UserCondominio::create([
                    'id_usuario' => $user->idUser,
                    'id_condominio' => $cond['id_condominio'],
                ]);
            }
        }

        return redirect('/users')->with('success', 'Usuário cadastrado com sucesso!');
    }

    public function destroy($idUser)
    {
        if (!session()->has('access_token')) {
            return redirect('/login');
        }

        $user = User::findOrFail($idUser);
        
        // Impedir que o usuário delete a si mesmo
        if (session('user_id') == $idUser) {
            return redirect('/users')->with('error', 'Você não pode deletar seu próprio usuário.');
        }

        // Deletar vínculos com condominios
        UserCondominio::where('id_usuario', $idUser)->delete();
        
        // Deletar usuário
        $user->delete();

        return redirect('/users')->with('success', 'Usuário deletado com sucesso!');
    }
}
