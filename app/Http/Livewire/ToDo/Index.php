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

    protected $listeners = [
        '$refresh'
    ];

    public function render()
    {
        return view('livewire.to-do.index');
    }

    public function create()
    {
        $validated = $this->validate();
        $todo = ToDo::create($validated);
        Auth::user()->toDos()->save($todo);

        $this->emitTo('to-do-table', 'data-added');

        $this->modalCreate = false;
    }

    public function showModalCreate()
    {
        $this->modalCreate = true;
    }
}
