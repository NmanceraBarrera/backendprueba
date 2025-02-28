<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Activity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class usuarioController extends Controller
{
    public function index()
    {
        $usuarios_registrados = Usuario::all();
            
        if ($usuarios_registrados->isEmpty()) {
            return response()->json(['message' => 'No hay usuarios', 'status' => 200], 200);
        }
        return response()->json($usuarios_registrados, 200);
    }

    public function crear(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:usuarios',
            'phone' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación', 
                'errors' => $validator->errors(), 
                'status' => 400
            ], 400);
        }

        $usuario = Usuario::create($request->only(['name', 'email', 'phone']));

        if (!$usuario) {
            return response()->json(['message' => 'Error al crear el usuario', 'status' => 500], 500);
        }

        return response()->json(['usuario' => $usuario, 'status' => 201], 201);
    }

    public function unUsuario($id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado', 'status' => 404], 404);
        }
        return response()->json(['usuario' => $usuario, 'status' => 200], 200);
    }

    public function eliminar($id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado', 'status' => 404], 404);
        }
        $usuario->delete();
        return response()->json(['message' => 'Usuario eliminado', 'status' => 200], 200);
    }

    public function actualizar(Request $request, $id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado', 'status' => 404], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:usuarios,email,' . $id, 
            'phone' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación', 
                'errors' => $validator->errors(), 
                'status' => 400
            ], 400);
        }

        $usuario->update($request->only(['name', 'email', 'phone']));

        return response()->json(['usuario' => $usuario, 'status' => 200], 200);
    }

   
    public function usersLast30Days()
    {
        $last30Days = Carbon::now()->subDays(30);
        $usuarios = Usuario::where('created_at', '>=', $last30Days)->get();

        return response()->json([
            'total' => $usuarios->count(),
            'usuarios' => $usuarios
        ], 200);
    }

   
    public function loginCounts()
    {
        $logins = Activity::where('action', 'Inicio de sesión')
            ->select('user_id', DB::raw('count(*) as total_logins'))
            ->groupBy('user_id')
            ->orderByDesc('total_logins')
            ->get();

        return response()->json($logins, 200);
    }

  
    public function usersCreatedPerDay()
    {
        $usersByDay = Usuario::where('created_at', '>=', Carbon::now()->subDays(30))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json($usersByDay, 200);
    }
}
