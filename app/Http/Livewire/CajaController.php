<?php

namespace App\Http\Livewire;

use App\Models\Cajas;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class CajaController extends Component
{
    use WithPagination;

    public $tipo = 'Elegir',$concepto,$monto,$comprobante;
    public $selected_id,$search;
    public $action = 1,$pagination = 5;
    
    public function render()
    {
        if(strlen($this->search) > 0){
            return view('livewire.movimientos.component',[
                'info' => Cajas::where('tipo','like',"%{$this->search}%")->orWhere('concepto','like',"%{$this->search}%")->paginate($this->pagination)
            ]);
        }else{
            $cajas = Cajas::leftJoin('users as u','u.id','cajas.user_id')
                        ->select('cajas.*','u.name')
                        ->orderBy('id','desc')
                        ->paginate($this->pagination);

            return view('livewire.movimientos.component',[
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
        $record = Cajas::find($id);

        $this->selected_id = $id;
        $this->tipo = $record->tipo;
        $this->concepto = $record->concepto;
        $this->monto = $record->monto;
        $this->comprobante = $record->comprobante;
        $this->action = 2;
    }

    public function StoreOrUpdate()
    {
        $this->validate([
            'tipo' => 'not_in:Elegir'
        ]);

        $this->validate([
            'tipo' => 'required',
            'monto' => 'required',
            'concepto' => 'required'
        ]);

        if($this->selected_id <= 0){
            $caja = Cajas::create([
                'monto' => $this->monto,
                'tipo' => $this->tipo,
                'concepto' => $this->concepto,
                'user_id' => Auth::user()->id
            ]);

            if($this->comprobante){
                $image = $this->comprobante;
                $fileName = time().'.'.explode('/',explode(':',substr($image,0,strpos($image,';')))[1])[1];
                $moved = \Image::make($image)->save('images/movs/'.$fileName);

                if($moved){
                    $caja->comprobante = $fileName;
                    $caja->save();
                }
            }
        }else{
            $record = Cajas::find($this->selected_id);
            $record->update([
                'monto' => $this->monto,
                'tipo' => $this->tipo,
                'concepto' => $this->concepto,
                'user_id' => Auth::user()->id
            ]);
            if($this->comprobante){
                $image = $this->comprobante;
                $fileName = time().'.'.explode('/',explode(':',substr($image,0,strpos($image,';')))[1])[1];
                $moved = \Image::make($image)->save('images/movs/'.$fileName);

                if($moved){
                    $record->comprobante = $fileName;
                    $record->save();
                }
            }
        }

        if($this->selected_id){
            $this->emit('msgok','Movimiento de Caja Actualizado con Exito');
        }else{
            $this->emit('msgok','Movimiento de Caja fue creado con Exito');
        }

        $this->resetInput();
    }

    protected $listeners = [
        'deleteRow' => 'destroy',
        'fileUpload' => 'handleFileUpload'
    ];

    public function handleFileUpload($imageData)
    {
        $this->comprobante = $imageData;
    }

    public function destroy($id)
    {
        if($id){
            $record = Cajas::where('id',$id);
            $record->delete();
            $this->resetInput();
        }
    }
}
