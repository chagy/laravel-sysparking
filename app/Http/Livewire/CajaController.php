<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Caja;

class CajaController extends Component
{
    use WithPagination;

    public $tipo = 'Elegir',$concepto,$monto,$comprobante;
    public $selected_id,$search;
    public $action = 1,$pagination = 5;
    
    public function render()
    {
        if(strlen($this->search) > 0){
            return view('livewire.cajas.component',[
                'info' => Caja::where('tipo','like',"%{$this->search}%")->orWhere('concepto','like',"%{$this->search}%")->paginate($this->pagination)
            ]);
        }else{
            $cajas = Caja::leftJoin('users as u','u.id','cajas.user_id')
                        ->select('cajas.*','u.nombre')
                        ->orderBy('id','desc')
                        ->paginate($this->pagination);

            return view('livewire.cajas.component',[
                'info' => $cajas
            ]);
        }
        
    }

    public function updatingSearch()
    {
        $this->gotoPage(1);
    }

    public function doAction($action)
    {
        $this->resetInput();
        $this->action = $action;
    }

    public function resetInput()
    {
        $this->concepto = '';
        $this->tipo = 'Eligir';
        $this->monto = '';
        $this->comprobante = '';
        $this->selected_id = null;
        $this->action = 1;
        $this->search = '';
    }

    public function edit($id)
    {
        $record = Caja::find($id);
        $this->selected_id = $id;
        $this->tipo = $record->tipo;
        $this->concepto = $record->concepto;
        $this->monto = $record->monto;
        $this->comprobante = $record->comprobante;
        $this->action = $record->action;
    }
}
