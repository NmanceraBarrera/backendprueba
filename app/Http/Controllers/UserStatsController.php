<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class UserStatsController extends Controller
{
    public function estadisticas()
    {
        $totalUsuarios = Usuario::count();

        return response()->json([
            'total_usuarios' => $totalUsuarios,
        ]);
    }
}
