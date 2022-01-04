<?php

namespace App\Http\Livewire\ToDo;

use App\Models\ToDo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class Index extends Component
{
    use Actions;

    public $description, $modalCreate = false, $modalUpdate = false, $toDoId;

    protected $rules = [
        'description' => ['required', 'string'],
    ];

    protected $listeners = [
        '$refresh',
        'edit' => 'setValue',
        'delete'        => 'dialog_delete',
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

        $this->emitTo('to-do-table', 'data-changed', ['state' => 'save']);

        $this->modalCreate = false;
    }

    public function showModalCreate()
    {
        $this->modalCreate = true;
    }

    public function setValue($value)
    {
        $toDo = ToDo::find($value['id']);
        $this->description = $toDo->description;
        $this->toDoId = $toDo->id;
        $this->modalUpdate = true;
    }

    public function update()
    {
        $validated = $this->validate();
        $toDo = ToDo::find($this->toDoId ?? null);

        if(!$toDo->isValid()){
            return abort(403);
        }
        
        $toDo->description = $validated['description'];

        $toDo->save();

        $this->emitTo('to-do-table', 'data-changed', ['state' => 'update']);
        $this->modalUpdate = false;
        $this->nullValue();

    }

    public function nullValue()
    {
        $this->description = null;
        $this->id = null;
    }

    public function delete($id)
    {
        $toDo = ToDo::find($id);

        if(!$toDo->isValid()){
            return abort(403);
        }

        $toDo->delete();

        $this->emitTo('to-do-table', 'data-changed', ['state' => 'delete']);
    }

    public function dialog_delete($value)
    {

         // use a full syntax
         $this->dialog()->confirm([
            'title'       => __('Are you Sure?'),
            'description' => __('Delete the Note?'),
            'icon'        => 'question',
            'accept'      => [
                'label'  => __('Yes'),
                'method' => 'delete',
                'params' => $value['id'],
            ],
            'reject' => [
                'label'  => __('Cancel'),
            ],
        ]);

    }
}
