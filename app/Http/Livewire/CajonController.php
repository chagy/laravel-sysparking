<?php

namespace App\Http\Livewire;

use App\Models\Tipo;
use App\Models\Cajon;
use Livewire\Component;
use Livewire\WithPagination;

class CajonController extends Component
{
    use WithPagination;

    public $tipo='Elegir',$description,$estatus='DISPONIBLE',$tipos;
    public $selected_id,$search;
    public $action = 1, $pagination = 5;

    public function mount()
    {
        
    }

    public function render()
    {
        $tipos = Tipo::all();

        if(strlen($this->search) > 0){
            $info = Cajon::leftJoin("tipos as t","t.id","cajones.tipo_id")
                        ->select("cajones.*","t.descripcion as tipo")
                        ->where("cajones.descripcion","like","%{$this->search}%")   
                        ->orWhere("cajones.estatus","like","%{$this->search}%")
                        ->paginate($this->pagination);   

            return view('livewire.cajones.component',[
                'info' => $info
            ]);
        }else{
            $info = Cajon::leftJoin("tipos as t","t.id","cajones.tipo_id")
                        ->select("cajones.*","t.descripcion as tipo")
                        ->orderBy("cajones.id",'desc')
                        ->paginate($this->pagination);   

            return view('livewire.cajones.component',[
                'info' => $info
            ]);
        }
        
    }

    public function updatingSearch()
    {
        $this->gotoPage(1);
    }

    public function doAction($action)
    {
        $this->action = $action;
    }

    public function resetInput()
    {
        $this->descripcion = '';
        $this->tipo = 'Eligir';
        $this->estatus = 'DISPONIBLE';
        $this->selected_id = null;
        $this->action = 1;
        $this->search = '';
    }

    public function edit($id)
    {
        $record = Cajon::find($id);
        $this->selected_id = $id;
        $this->tipo = $record->tipo;
        $this->descripcion = $record->descripcion;
        $this->estatus = $record->estatus;
        $this->action = 2;
    }

    public function StoreOrUpdate()
    {
        $this->validate([
            'tipo' => 'not_in:Elegir'
        ]);
        $this->validate([
            'tipo' => 'required',
            'descripcion' => 'required',
            'estatus' => 'required'
        ]);

        if($this->selected_id <= 0){
            $cajon = Cajon::create([
                'descripcion' => $this->descripcion,
                'tipo_id' => $this->tipo,
                'estatus' => $this->estatus
            ]);
        }else{
            $record = Cajon::find($this->selected_id);
            $record->update([
                'descripcion' => $this->descripcion,
                'tipo_id' => $this->tipo,
                'estatus' => $this->estatus
            ]);
        }

        if($this->selected_id){
            $this->emit('msgok','Cajon Actualizado con Exito');
        }else{
            $this->emit('msgok','Cajon fue creado con Exito');
        }

        $this->resetInput();
    }

    public function destroy($id)
    {
        if($id){
            $record = Cajon::where('id',$id);
            $record->delete();
            $this->resetInput();
            $this->emit('msgok','Registro eliminado can exito');
        }
    }

    protected $listeners = [
        'deleteRow' => 'desctroy'
    ];
}
