<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DespesaController extends Controller
{

    public function listarDespesas()
    {
        $array = ['erro' => ''];

        $usuario_id = auth()->user()->id;

        $listaDespesas = Despesa::select('*')->where('usuario_id', $usuario_id)->get();

        return response()->json($listaDespesas);
    }

    public function incluirDespesa(Request $request)
    {
        $array = ['erro' => ''];

        $validador = Validator::make($request->all(), [
            'descricao' => 'required|max:191',
            'data_criacao' => 'required|before:today|date|date_format:Y-m-d',
            'usuario' => 'exists:usuarios,id'
        ]);

        if ($validador->fails()) {
            $array['erro'] = $validador->errors()->first();
            return $array;
        } else {
            $descricao = $request->input('descricao');
            $data = $request->input('data_criacao');
            $valor = $request->input('valor');
            $usuario = auth()->user()->id;

            $despesa = new Despesa();
            $despesa->create([
                'descricao' => $descricao,
                'data_criacao' => $data,
                'valor' => $valor,
                'usuario_id' => $usuario
            ]);
            $array['despesa'] = $despesa;
        }

        return $array;
    }

    public function atualizarDespesa(Request $request, $id)
    {
        $array = ['erro' => ''];

        $validador = Validator::make($request->all(), [
            'descricao' => 'required|max:191',
            'data_criacao' => 'required|before:today|date|date_format:Y-m-d',
            'usuario' => 'exists:usuarios,id'
        ]);

        if ($validador->fails()) {
            $array['erro'] = $validador->errors()->first();
            return $array;
        } else {

            $despesaAtualizada = Despesa::find($id);

            $despesaAtualizada->update([
                'descricao' => $request->input('descricao'),
                'data_criacao' => $request->input('data_criacao'),
                'usuario' => $request->input('valor')
            ]);

            $array['despesa'] = $despesaAtualizada;
        }

        return $array;
    }

    public function excluirDespesa($id)
    {
        $array = ['erro' => ''];

        if ($id) {
            Despesa::where('id', $id)->delete();
        } else {
            $array['erro'] = 'Id inexistente';
            return $array;
        }

        return $array;
    }
}
