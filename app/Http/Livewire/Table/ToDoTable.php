<?php

namespace App\Http\Livewire\Table;

use App\Models\ToDo;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ToDoTable extends LivewireDatatable
{

    public $model = ToDo::class;
    public $description;

    // listener
    protected $listeners = [
        '$refresh',
    ];

    protected $rules = [
        'description' => ['required', 'string'],
    ];

    public function builder()
    {
        return ToDo::withoutTrashed()->where('user_id', Auth::user()->id);
    }

    public function columns()
    {
        return [
            Column::callback(['id', 'description'], function ($id, $description) {
                return view('components.table.actions', ['id' => $id, 'description' => $description]);
            })->unsortable(),
            Column::name('description')
                ->label(__('Description'))
                ->searchable()
                ->truncate(30),
            DateColumn::name('updated_at')
                ->label('Terakhir di Perbarui')
                ->defaultSort('desc'),
        ];
    }

    public function update($id)
    {
        $validated = $this->validate();

        $toDo = ToDo::find($id);

        if (!$toDo->isValid()) {
            return abort(404);
        }

        $toDo->description = $validated['description'];
        $toDo->save();

        $this->dispatchBrowserEvent('close-modal');

    }

    public function setValue($id)
    {
        $toDo = ToDo::find($id);

        if (!$toDo->isValid()) {
            return abort(404);
        }

        $this->description = $toDo->description;
    }
}
