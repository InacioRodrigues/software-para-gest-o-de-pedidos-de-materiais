<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Site\Pedido\AddPedido;
use App\Http\Middleware\CheckPerfil;
use App\Livewire\Admin\OrderDetails;
use App\Livewire\Admin\MaterialForm;
use App\Livewire\Admin\MaterialList;
use App\Livewire\Admin\GrupoForm;
use App\Livewire\Admin\PedidoReview;

Route::get('/home',function(){
    return view('livewire/index');
});

Route::middleware(['checkPerfil:aprovador'])->group(function () {
    Route::get('/grupos/novo', GrupoForm::class)->name('grupos.create');
    Route::get('/grupos/{grupo}/editar', GrupoForm::class)->name('grupos.edit');
});

Route::middleware(['auth'])->group(function () {
    Route::middleware(['checkPerfil:solicitante'])->group(function () {
        Route::get('/pedidos/novo', AddPedido::class)->name('pedidos.create');
    });
});


    Route::get('/pedidos/{pedido}', OrderDetails::class)->name('pedidos.show');
    Route::get('/materiais', MaterialList::class)->name('materiais.index');
    Route::get('/materiais/novo', MaterialForm::class)->name('materiais.create');
    Route::get('/materiais/{material}/editar', MaterialForm::class)->name('materiais.edit');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
]);
