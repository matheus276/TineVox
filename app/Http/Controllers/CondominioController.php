<?php

namespace App\Http\Controllers;

use App\Models\Condominio;
use Illuminate\Http\Request;

class CondominioController extends Controller
{
    public function index(Request $request)
    {
        if (!session()->has('access_token')) {
            return redirect('/login');
        }

        $search = trim((string) $request->input('search', ''));
        $perPage = (int) $request->input('per_page', 10);
        $perPage = in_array($perPage, [10, 20, 50, 100], true) ? $perPage : 10;

        $condominios = Condominio::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('nome', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('endereco', 'like', "%{$search}%");
            })
            ->paginate($perPage)
            ->appends($request->query());

        return view('condominios.index', compact('condominios', 'search', 'perPage'));
    }

    public function create()
    {
        return view('condominios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'cnpj' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'pasta_gravacoes' => 'nullable|string|max:100',
            'ativo' => 'boolean',
        ]);

        Condominio::create($validated);

        return redirect('/condominios')->with('success', 'Condominio criado com sucesso!');
    }

    public function edit($id)
    {
        $condominio = Condominio::findOrFail($id);
        return view('condominios.edit', compact('condominio'));
    }

    public function update(Request $request, $id)
    {
        $condominio = Condominio::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'cnpj' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'pasta_gravacoes' => 'nullable|string|max:100',
            'ativo' => 'boolean',
        ]);

        $condominio->update($validated);

        return redirect('/condominios')->with('success', 'Condominio atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $condominio = Condominio::findOrFail($id);
        $condominio->delete();

        return redirect('/condominios')->with('success', 'Condominio deletado com sucesso!');
    }
}
