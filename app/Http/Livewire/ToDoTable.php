<?php

namespace App\Http\Livewire;

use App\Models\ToDo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use WireUi\Traits\Actions;

final class ToDoTable extends PowerGridComponent
{
    use ActionButton;
    use Actions;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

    //Show Per Page
    public array $perPageValues = [10, 25, 50, 100];

    protected $listeners = [
        'data-changed'  => 'refreshData',
    ];

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
     */
    public function setUp(): void
    {
        $this->showCheckBox()
            ->showPerPage(5)
            ->showSearchInput()
            ->showExportOption('download', ['excel', 'csv']);
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
     */
    public function datasource(): ?Builder
    {
        return ToDo::withoutTrashed()->where('user_id', Auth::user()->id)->orderByDesc('updated_at');
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
     */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
     */
    public function addColumns(): ?PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('created_at_formatted', function (ToDo $model) {
                return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
            })
            ->addColumn('updated_at_formatted', function (ToDo $model) {
                return Carbon::parse($model->updated_at)->format('d/m/Y H:i:s');
            });
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
     */

    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */

    public function columns(): array
    {
        return [
            Column::add()
                ->title('ID')
                ->field('id')
                ->makeInputRange(),

            // Column::add()
            //     ->title('CREATED AT')
            //     ->field('created_at_formatted', 'created_at')
            //     ->searchable()
            //     ->sortable()
            //     ->makeInputDatePicker('created_at'),

            Column::add()
                ->title(__('Description'))
                ->field('description')
                ->searchable()
                ->sortable()
                ->makeInputText(),

            Column::add()
                ->title(__('Terakhir di Update'))
                ->field('updated_at_formatted', 'updated_at')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('updated_at'),

        ]
        ;
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable this section only when you have defined routes for these actions.
    |
     */

    /**
     * PowerGrid ToDo action buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */

    public function actions(): array
    {
        return [
            Button::add('edit')
                ->caption(__('Edit'))
                ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
                ->emit('edit', ['id' => 'id']),

            Button::add('destroy')
                ->caption(__('Delete'))
                ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
                ->emit('delete', ['id' => 'id']),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Method
    |--------------------------------------------------------------------------
    | Enable this section to use editOnClick() or toggleable() methods.
    | Data must be validated and treated (see "Update Data" in PowerGrid doc).
    |
     */

    /**
     * PowerGrid ToDo Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
    try {
    $updated = ToDo::query()->findOrFail($data['id'])
    ->update([
    $data['field'] => $data['value'],
    ]);
    } catch (QueryException $exception) {
    $updated = false;
    }
    return $updated;
    }

    public function updateMessages(string $status = 'error', string $field = '_default_message'): string
    {
    $updateMessages = [
    'success'   => [
    '_default_message' => __('Data has been updated successfully!'),
    //'custom_field'   => __('Custom Field updated successfully!'),
    ],
    'error' => [
    '_default_message' => __('Error updating the data.'),
    //'custom_field'   => __('Error updating custom field.'),
    ]
    ];

    $message = ($updateMessages[$status][$field] ?? $updateMessages[$status]['_default_message']);

    return (is_string($message)) ? $message : 'Error!';
    }
     */

    public function refreshData($value)
    {
        switch($value['state'] ?? null){
            case 'delete':
                $title_value = __('Note Deleted');
                $description_value = __('Note Has Been Deleted!!');
                break;
            case 'save':
                $title_value = __('Note Saved');
                $description_value = __('Note Has Been Saved!!');
                break;
            case 'update':
                $title_value = __('Note Update');
                $description_value = __('Note Has Been Updated!!');
                break;
            default :
                $title_value = null;
                $description_value = null;
                break;
        }
        if($title_value != null && $description_value != null){
            $this->notification()->success(
                $title = $title_value,
                $description = $description_value
            );
        }
        $this->fillData();
    }

    // public function delete($id)
    // {

    //     // $this->emitUp('delete', ['id' => $id]);
    //     // Todo::find($id)->delete();

    //     // $this->emit('data-changed', ['state' => 'delete']);
    // }

    // public function edit($value)
    // {
    //     $this->emitUp('edit', ['id' => $value['id']]);
    // }
}
