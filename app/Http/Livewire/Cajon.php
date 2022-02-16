<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Cajon extends Component
{
    public $name = "Lex";
    public function mount()
    {

    }

    public function render()
    {
        return view('livewire.cajones');
    }
}
