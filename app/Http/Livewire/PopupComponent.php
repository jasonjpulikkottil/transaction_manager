<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PopupComponent extends Component
{

    public $input;



public function showPopup()
{
    $this->input = '';
    $this->emit('showPopup');
}

public function handleInput()
{
    // Do something with the user input (e.g. save it to the database)
    // ...
    
    // Hide the popup
    $this->emit('hidePopup');
}



    public function render()
    {
        return view('livewire.popup-component');
    }
}
