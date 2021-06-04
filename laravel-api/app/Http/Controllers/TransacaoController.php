<?php

namespace App\Http\Controllers;

use App\Models\Transacoes as Transacoes;
use App\Models\Usuarios as Usuarios;
use App\Http\Resources\TransacaoResource as TransacaoResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransacaoController extends Controller
{

    public function index(){
        $transacao = Transacoes::paginate(15);
        return TransacaoResource::collection($transacao);
      }
    
      public function show($id){
        $transacao = Transacoes::findOrFail( $id );
        return new TransacaoResource( $transacao );
      }
    
      public function store(Request $request){
        $transacao = new Transacoes;
        $transacao->id_usuario = $request->input('id_usuario');
        $transacao->saldo_inicial = $request->input('saldo_inicial');
        $saldo_inicial = $request->input('saldo_inicial');
        $transacao->debito = $request->input('debito');
        $debito = $request->input('debito');
        $transacao->credito = $request->input('credito');
        $credito = $request->input('credito');
        $transacao->estorno = $request->input('estorno');
        $estorno= $request->input('estorno');
        $transacao->saldo_final = $saldo_inicial + $debito - $credito + $estorno;
        $saldo_final = $saldo_inicial + $debito - $credito + $estorno;
        $saldo_inicial = $saldo_final;
        if( $transacao->save() ){
          return new TransacaoResource( $transacao );
        }
      }
    
       public function update(Request $request){
        $transacao = Transacoes::findOrFail( $request->id );
        $transacao->id_usuario = $request->input('id_usuario');
        $transacao->saldo_inicial = $request->input('saldo_inicial');
        $saldo_inicial = $request->input('saldo_inicial');
        $transacao->debito = $request->input('debito');
        $debito = $request->input('debito');
        $transacao->credito = $request->input('credito');
        $credito = $request->input('credito');
        $transacao->estorno = $request->input('estorno');
        $estorno= $request->input('estorno');
        $transacao->saldo_final = $saldo_inicial + $debito - $credito + $estorno;
    
        if( $transacao->save() ){
          return new TransacaoResource( $transacao );
        }
      } 
    
      public function destroy($id){
        $transacao = Transacoes::findOrFail( $id );
        if( $transacao->delete() ){
          return new TransacaoResource( $transacao );
        }
    
      }
}
