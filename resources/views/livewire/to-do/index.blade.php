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
                        class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                        {{ __('Create') }}
                    </button>
                </div>
                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                    {{-- <div class="inline-block min-w-full shadow rounded-lg overflow-hidden"> --}}


                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal.card title="Edit Customer" blur wire:model.defer="modalCreate" x-on:open='...' x-on:close='...'>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <x-input label="Name" placeholder="Your full name" />
        <x-input label="Phone" placeholder="USA phone" />

        <div class="col-span-1 sm:col-span-2">
            <x-input label="Email" placeholder="example@mail.com" />
        </div>

        <div
            class="col-span-1 sm:col-span-2 cursor-pointer bg-gray-100 rounded-xl shadow-md h-72 flex items-center justify-center">
            <div class="flex flex-col items-center justify-center">
                <x-icon name="cloud-upload" class="w-16 h-16 text-blue-600" />
                <p class="text-blue-600">Click or drop files here</p>
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            {{-- <x-button flat negative label="Delete" wire:click="delete" /> --}}

            <div class="flex">
                <x-button flat label="Cancel" x-on:click="close" />
                <x-button primary label="Save" wire:click="save" />
            </div>
        </div>
    </x-slot>
</x-modal.card>
