<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tarifa;
use App\Models\Tipo;
use DB;

class Tarifas extends Component
{
    use WithPagination;

    public $tiempo = 'Elegir',$tipo = 'Elegir', $descripcion,$costo,$jerarquia;
    public $selected_id,$search;
    public $action = 1;
    public $pagination = 5;
    public $tipos;

    public function mount()
    {
        $this->getJerarquia();
    }

    public function getJerarquia()
    {
        $tarifa = Tarifa::count();
        if($tarifa > 0)
        {
            $tarifa = Tarifa::select('jerarquia')->orderBy('jerarquia','desc')->first();
            $this->jerarquia = $tarifa->jerarquia + 1;
        }
    }

    public function render()
    {
        $this->tipos = Tipo::all();
        if(strlen($this->search) > 0)
        {
            $info = Tarifa::leftJoin('tipos as t','t.id','tarifas.tipo_id')
                        ->where('tarifas.descripcion','LIKE',"%{$this->search}%")
                        ->orWhere('tarifas.tiempo','LIKE',"%{$this->search}%")
                        ->select('tarifas.*','t.descripcion as tipo')
                        ->orderBy('tarifas.tiempo','desc')
                        ->orderBy('t.descripcion')
                        ->paginate($this->pagination);

            return view('livewire.tarifas.component',[
                'info' => $info 
            ]);

        }else{
            $info = Tarifa::leftJoin('tipos as t','t.id','tarifas.tipo_id')
                        ->select('tarifas.*','t.descripcion as tipo')
                        ->orderBy('tarifas.tiempo','desc')
                        ->orderBy('t.descripcion')
                        ->paginate($this->pagination);

            return view('livewire.tarifas.component',[
                'info' => $info 
            ]);
        }
        return view('livewire.tarifas');
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
        $this->descripcion = '';
        $this->tiempo = '';
        $this->costo = '';
        $this->tipo = 'Elegir';
        $this->selected_id = null;
        $this->action = 1;
        $this->search = '';
    }

    public function edit($id)
    {
        $record = Tarifa::find($id);
        $this->selected_id = $record->id;
        $this->descripcion = $record->descripcion;
        $this->tiempo = $record->tiempo;
        $this->costo = $record->costo;
        $this->tipo = $record->tipo->id;
        $this->jerarquia = $record->jerarquia;
        $this->action = 2;
    }

    public function CreateOrUpdate()
    {
        $this->validate([
            'tiempo' => 'required',
            'costo' => 'required',
            'tipo' => 'required',
            'tiempo' => 'not_in:Elegir',
            'tipo' => 'not_in:Elegir'
        ]);

        if($this->selected_id > 0){
            $existe = Tarifa::where('tiempo',$this->tiempo)
                        ->where('tipo_id',$this->tipo)
                        ->where('id','<>',$this->selected_id)
                        ->select('tiempo')
                        ->count();
        }
        else 
        {
            $existe = Tarifa::where('tiempo',$this->tiempo)
                        ->where('tipo_id',$this->tipo)
                        ->select('tiempo')
                        ->count();
        }

        if($existe > 0)
        {
            $this->emit('msg-error','La tarifa ya existe');
            $this->resetInput();
            return;
        }

        if($this->selected_id <= 0)
        {
            $tarifa = Tarifa::create([
                'tiempo' => $this->tiempo,
                'descripcion' => $this->descripcion,
                'costo' => $this->costo,
                'tipo_id' => $this->tipo,
                'jerarquia' => $this->jerarquia
            ]);
        }
        else 
        {
            $tarifa = Tarifa::find($this->selected_id);
            $tarifa->update([
                'tiempo' => $this->tiempo,
                'descripcion' => $this->descripcion,
                'costo' => $this->costo,
                'tipo_id' => $this->tipo,
                'jerarquia' => $this->jerarquia
            ]);
        }

        if($this->jararquia == 1)
        {
            Tarifa::where('id','<>',$tarifa->id)->update([
                'jerarquia' => 0
            ]);
        }

        if($this->selected_id)
        {
            $this->emit('msg-ok','Tarifa Actualizada');
        }
        else 
        {
            $this->emit('msg-ok','Tarifa Creada');
        }

        $this->resetInput();
        $this->getJerarquia();
    }

    protected $listeners = [
        'deleteRow' => 'destroy',
        'createFromModal' => 'createFromModal'
    ];

    public function createFromModal($info)
    {
        $data = json_decode($info);
        $this->selected_id = $data->id;
        $this->tiempo = $data->tiempo;
        $this->tipo = $data->tipo;
        $this->costo = $data->costo;
        $this->descripcion = $data->descripcion;
        $this->jerarquia = $data->jerarquia;

        $this->CreateOrUpdate();
    }

    public function destroy($id)
    {
        if($id)
        {
            $record = Tarifa::find('id',$id);
            $record->delete();
            $this->resetInput();
        }
    }
}
