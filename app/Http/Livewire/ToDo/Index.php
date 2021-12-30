<?php

namespace App\Http\Livewire\ToDo;

use App\Models\ToDo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{

    public $description, $modalCreate = false;

    protected $rules = [
        'description' => ['required', 'string']
    ];

    public function render()
    {
        return view('livewire.to-do.index');
    }
}
