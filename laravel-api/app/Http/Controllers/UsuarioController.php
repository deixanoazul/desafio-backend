<?php

namespace App\Http\Controllers;

use App\Models\Usuarios as Users;
use App\Models\Transacoes as transacoes;
use App\Http\Resources\UsuarioResource as UsuarioResource;
use Carbon\Carbon;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UsuarioController extends Controller
{
  public function index()
  {
    $users = Users::paginate(15);
    return UsuarioResource::collection($users);
  }

  public function show($id)
  {
    $users = Users::findOrFail($id);
    return new UsuarioResource($users);
  }

  public function store(Request $request)
  {
    $users = new Users;
    $users->birthdate = $request->input('birthdate');
    $aniversario = $request->input('birthdate');
    $data_atual = Carbon::now()->diffInYears($aniversario);
    $users->name = $request->input('name');
    $users->email = $request->input('email');
    $users->cpf = $request->input('cpf');
    $users->montante = $request->input('montante');

    if ($data_atual >= 21 && $users->save()) {
      return new UsuarioResource($users);
    } else {
      return response()->json([
        'resp' => 'idade minima invalida'
      ], 403);
    }
  }

  public function update(Request $request)
  {
    $users = Users::findOrFail($request->id);
    $users->name = $request->input('name');
    $users->email = $request->input('email');
    $users->birthdate = $request->input('birthdate');
    $users->cpf = $request->input('cpf');
    $users->montante = $request->input('montante');

    if ($users->save()) {
      return new UsuarioResource($users);
    }
  }

  public function destroy($id)
  {
    $users = Users::findOrFail($id);
    $conta = DB::table('usuarios')
                ->join('transacoes', function ($join) {
                    $join->on("usuarios.id", '=', 'transacoes.id_usuario')
                      ->having('transacoes.id_usuario', '>', 0);
      })
      ->count();
    if ($conta > 0 && $users->delete()) {
      return new UsuarioResource($users);
    }else{
      return response()->json([
        'resp' => 'usuario possui valores pendentes'
      ], 403); 
    }
  }
}
