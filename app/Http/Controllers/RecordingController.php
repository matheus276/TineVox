<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class RecordingController extends Controller
{
    public function index(Request $request)
    {
        if (!session()->has('access_token')) {
            return redirect('/login');
        }

        $condominio = strtolower(session('condominio'));

        $path = '/var/spool/asterisk/monitor/' . $condominio;

        $arquivos = [];

        if (File::exists($path)) {
            $arquivos = File::files($path);

            usort($arquivos, function ($a, $b) {
                return $b->getMTime() <=> $a->getMTime();
            });
        }

        // Quantidade por página (padrão 10)
        $perPage = $request->get('per_page', 10);

        // Permite apenas estes valores
        if (!in_array($perPage, [10, 20, 50, 100])) {
            $perPage = 10;
        }

        $collection = Collection::make($arquivos);

        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $currentItems = $collection
            ->slice(($currentPage - 1) * $perPage, $perPage)
            ->values();

        $arquivos = new LengthAwarePaginator(
            $currentItems,
            $collection->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query()
            ]
        );

        return view('recording', compact('arquivos'));
    }

    public function download($arquivo)
    {
        if (!session()->has('access_token')) {
            return redirect('/login');
        }

        $condominio = mb_strtolower(session('condominio'), 'UTF-8');

        $caminho = '/var/spool/asterisk/monitor/' . $condominio . '/' . $arquivo;

        if (!file_exists($caminho)) {
            abort(404);
        }

        return response()->download($caminho);
    }

    public function play($arquivo)
    {
        if (!session()->has('access_token')) {
            return redirect('/login');
        }

        $condominio = mb_strtolower(session('condominio'), 'UTF-8');

        $caminho = '/var/spool/asterisk/monitor/' . $condominio . '/' . $arquivo;

        if (!file_exists($caminho)) {
            abort(404);
        }

        return response()->file($caminho);
    }
}
