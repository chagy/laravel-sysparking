<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Empresa;
use DB;

class EmpresaController extends Component
{
    public $nombre,$telefono,$email,$direccion,$logo;

    public function mount()
    {
        $empresa = Empresa::select('*')->first();

        $this->nombre = $empresa->nombre;
        $this->telefono = $empresa->telefono;
        $this->direccion = $empresa->direccion;
        $this->email = $empresa->email;
        $this->logo = $empresa->logo;
    }

    public function render()
    {
        return view('livewire.empresa.component');
    }

    public function Guardar()
    {
        $rules = [
            'nombre' => 'required',
            'telefono' => 'required',
            'email' => 'required',
            'direccion' => 'required'
        ];

        $customMessages = [
            'nombre.required' => 'El campo nombre es requerido',
            'telefono.required' => 'El campo telefono es requerido',
            'email.required' => 'El campo email es invalid',
            'direccion.required' => 'El campo direccion es requerido',
        ];

        $this->validate($rules,$customMessages);

        DB::table('empresas')->truncate();

        Empresa::create([
            'nombre' => $this->nombre,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'direccion' => $this->direccion,
        ]);

        $this->emit('msgok','Informacion de la empresa registrade');

        // $empresa = Empresa::count();
        // if($empresa->count() > 0){

        // }else{

        // }
    }
}
