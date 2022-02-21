<?php

namespace App\Http\Livewire;

use App\Models\Tipo;
use Livewire\Component;
use Livewire\WithPagination;

class TipoController extends Component
{
    use WithPagination;

    public $descripcion;
    public $selected_id,$search;
    public $action = 1;
    private $pagination = 5;

    public function mount()
    {

    }
    
    public function render()
    {
        if(strlen($this->search) > 0){
            $info = Tipo::where('descripcion','like',"%{$this->search}%")->paginate($this->pagination);
            return view('livewire.tipos.component',[
                'info' => $info
            ]);
        } else {
            $info = Tipo::paginate($this->pagination);
            return view('livewire.tipos.component',[
                'info' => $info
            ]);
        }
    }

    public function updatingSearch(): void 
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
        $this->selected_id = null;
        $this->action = 1;
        $this->search = '';
    }

    public function edit($id)
    {
        $record = Tipo::findOrFail($id);
        $this->descripcion = $record->descripcion;
        $this->selected_id = $record->id;
        $this->action = 2;
    }

    public function StoreOrUpdate()
    {
        $this->validate([
            'descripcion' => 'required|min:4'
        ]);

        if($this->selected_id > 0){
            $existe = Tipo::where('descripcion',$this->descripcion)->where('id','<>',$this->selected_id)->select('descripcion')->get();
            if($existe->count() > 0){
                session()->flash('msg-error','Ya existe otro registro con la misma descripcion');
                $this->resetInput();
                return;
            }
        } else {
            $existe = Tipo::where('descripcion',$this->descripcion)->select('descripcion')->get();
            if($existe->count() > 0){
                session()->flash('msg-error','Ya existe otro registro con la misma descripcion');
                $this->resetInput();
                return;
            }
        }

        if($this->selected_id <= 0){
            $record = Tipo::create([
                'descripcion' => $this->descripcion
            ]);
        }else{
            $record = Tipo::find($this->selected_id);
            $record->update([
                'descripcion' => $this->descripcion
            ]);
        }

        if($this->selected_id){
            session()->flash('message','Tipo Actualizado');
        }else{
            session()->flash('message','Tipo Creado');
        }

        $this->resetInput();
    }

    public function desctroy($id)
    {
        if($id){
            $record = Tipo::find($id);
            $record->delete();
            $this->resetInput();
        }
    }

    protected $listeners = [
        'deleteRow' => 'desctroy'
    ];
}
