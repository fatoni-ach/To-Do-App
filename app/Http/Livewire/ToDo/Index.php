<?php

namespace App\Http\Livewire\ToDo;

use App\Models\ToDo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{

    public $description;

    protected $rules = [
        'description' => ['required', 'string']
    ];

    public function render()
    {
        return view('livewire.to-do.index');
    }

    public function create()
    {
        $validated = $this->validate();
        $this->description = null;
        
        $toDo = ToDo::create($validated);
        
        // Save method for saving one to many realationship
        Auth::user()->toDos()->save($toDo);
        
        //  For refresh Component 'Table/ToDoTable.php'
        $this->emitTo('table.to-do-table', '$refresh');

        //  For Closing modal
        $this->dispatchBrowserEvent('close-modal');
    }
}
