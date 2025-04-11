<?php
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\CasaController;

Route::apiResource('pessoas', PessoaController::class);
Route::apiResource('casas', CasaController::class);
