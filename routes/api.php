<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutenticacaoController;
use App\Http\Controllers\DespesaController;
use App\Http\Controllers\UsuarioController;

Route::get('/ping', function () {
    return ['pong' => true];
});

Route::get('/401', [AutenticacaoController::class, 'naoAutorizado'])->name('login');

Route::post('/auth/login', [AutenticacaoController::class, 'login']);
Route::post('/auth/registro', [AutenticacaoController::class, 'registrar']);

Route::middleware('auth:api')->group(function () {
    Route::post('auth/validar', [AutenticacaoController::class, 'validarToken']);
    Route::post('auth/sair', [AutenticacaoController::class, 'sair']);

    Route::get('/despesas/{usuario_id}', [DespesaController::class, 'listarDespesas']);
    Route::post('/despesa/incluir', [DespesaController::class, 'incluirDespesa']);
    Route::put('/despesa/{id}', [DespesaController::class, 'atualizarDespesa']);
    Route::delete('/despesa/excluir/{id}', [DespesaController::class, 'excluirDespesa']);
});
