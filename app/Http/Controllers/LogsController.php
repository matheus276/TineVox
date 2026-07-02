<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogsController extends Controller
{
    public function index(Request $request)
    {
         
         if (!session()->has('access_token')) {
            return redirect('/login');
        }

        $query = DB::table('historico_online_offline')
            ->orderBy('id', 'desc');

        $search = trim((string) $request->input('search', ''));
        $perPage = (int) $request->input('per_page', 10);
        $perPage = in_array($perPage, [10, 20, 50, 100], true) ? $perPage : 10;

        if ($search !== '') {
            $query->where(function ($subQuery) use ($search): void {
                $subQuery->where('ramal', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('data_evento', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $logs = $query->paginate($perPage)->appends($request->query());

        return view('logs', compact('logs', 'search', 'perPage'));
    }
}