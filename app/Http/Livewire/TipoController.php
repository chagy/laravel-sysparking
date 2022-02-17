<?php

namespace App\Http\Livewire;

use App\Models\Tipo;
use Livewire\Component;
use Livewire\WithPagination;

class TipoController extends Component
{
    use WithPagination;

    public $description;
    public $selected_id,$search;
    public $action = 1;
    private $pagination = 5;

    public function mount()
    {

    }
    
    public function render()
    {
        if(strlen($this->search) > 0){
            $info = Tipo::where('description','like',"%{$this->search}%")->paginate($this->pagination);
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
        $this->description = '';
        $this->selected_id = null;
        $this->action = 1;
        $this->search = '';
    }

    public function edit($id)
    {
        $record = Tipo::findOrFail($id);
        $this->description = $record->description;
        $this->selected_id = $record->id;
        $this->action = 2;
    }

    public function StoreOrUpdate()
    {
        $this->validate([
            'description' => 'required|min:4'
        ]);

        if($this->selected_id > 0){
            $existe = Tipo::where('description',$this->description)->where('id','<>',$this->selected_id)->select('description')->get();
            if($existe->count() > 0){
                session()->flash('msg-error','Ya existe otro registro con la misma description');
                $this->resetInput();
                return;
            }
        } else {
            $existe = Tipo::where('description',$this->description)->select('description')->get();
            if($existe->count() > 0){
                session()->flash('msg-error','Ya existe otro registro con la misma description');
                $this->resetInput();
                return;
            }
        }

        if($this->selected_id <= 0){
            $record = Tipo::create([
                'description' => $this->description
            ]);
        }else{
            $record = Tipo::find($this->selected_id);
            $record->update([
                'description' => $this->description
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
