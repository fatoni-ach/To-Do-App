<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('TO DO') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container mx-auto px-4 sm:px-8">
                <div>
                    <div class="flex space-x">
                        <button onclick="$openModal('modalCreate')" wire:loading.attr="disabled"
                            class="bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm">
                            {{ __('Create') }}
                        </button>
                    </div>
                    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                        {{-- <div class="inline-block min-w-full shadow rounded-lg overflow-hidden"> --}}
                        @livewire('to-do-table')

                        {{-- <button class="bg-indigo-500 cursor-pointer text-white px-1 py-2.5 m-1 rounded text-sm">edit</button>
                        <button class="bg-red-500 cursor-pointer text-white px-1 py-2 m-1 rounded text-sm">delete</button>
                        <x-icon name="trash" class="w-5 h-5" /> --}}

                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modal.card title="{{ __('Create') }}" fullscreeen blur wire:model.defer="modalCreate">
        <div class="grid grid-cols-1 sm:grid-cols-1 gap-4">
            <x-textarea wire:model.lazy='description' label="Description" placeholder="write your Note" />
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                {{-- <x-button flat negative label="Delete" wire:click="delete" /> --}}
                <div class="flex">
                    <x-button flat label="{{__('Cancel')}}" x-on:click="close" class="mr-3" />
                    <x-button primary label="{{__('Save')}}" wire:click.prevent=create() />
                </div>
            </div>
        </x-slot>
    </x-modal.card>

    <x-modal.card title="{{ __('Update') }}" fullscreeen blur wire:model.defer="modalUpdate">
        <div class="grid grid-cols-1 sm:grid-cols-1 gap-4">
            <x-textarea wire:model.lazy='description' label="Description" placeholder="write your Note" />
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                {{-- <x-button flat negative label="Delete" wire:click="delete" /> --}}
                <div class="flex">
                    <x-button flat label="{{__('Cancel')}}" x-on:click="close" class="mr-3" />
                    <x-button primary label="{{__('Save')}}" wire:click.prevent=update() />
                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
