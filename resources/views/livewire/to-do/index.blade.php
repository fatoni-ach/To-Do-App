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
                    <x-modal :value="-1">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                {{ __('Create') }}
                            </button>
                        </x-slot>
                        <form wire:submit.prevent=create()>
                            <textarea wire:model.lazy="description" column="300" rows="10" class="mt-1 block w-full mb-1"
                                id="description"></textarea>
                            <x-error field="description" class="text-red-500" />
                            <x-jet-button>
                                {{ __('Create') }}
                            </x-jet-button>
                        </form>
                    </x-modal>
                </div>
                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                    {{-- <div class="inline-block min-w-full shadow rounded-lg overflow-hidden"> --}}
                    <livewire:table.to-do-table />
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
