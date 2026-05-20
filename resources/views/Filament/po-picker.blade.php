<div x-data="{ searchFocused: false }" class="space-y-4">
    {{-- Search Bar --}}
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="relative">
            {{-- Search Icon --}}
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>

            {{-- Search Input --}}
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search by PO number, material code, name, or specification..."
                x-on:focus="searchFocused = true"
                x-on:blur="searchFocused = false"
                class="fi-input block w-full pl-10 pr-10 py-2.5 text-sm border-gray-300 rounded-lg
                       shadow-sm placeholder:text-gray-400
                       focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                       dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300
                       dark:placeholder:text-gray-500
                       dark:focus:border-primary-500 dark:focus:ring-primary-500
                       transition duration-75">

            {{-- Clear Button --}}
            @if($search)
            <button
                wire:click="$set('search', '')"
                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400
                       hover:text-gray-600 dark:hover:text-gray-300 transition">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
            @endif
        </div>

        {{-- Search Info --}}
        @if($search)
        <div class="mt-2 flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
            </svg>
            <span>
                Showing results for "<strong class="text-gray-700 dark:text-gray-300">{{ $search }}</strong>"
            </span>
        </div>
        @endif
    </div>

    {{-- Table Container with Horizontal Scroll --}}
    <div class="w-full overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm">
        <table class="w-full min-w-full table-auto divide-y divide-gray-200 dark:divide-gray-700 text-sm">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800/50">
                    <th class="px-4 py-3 w-10 text-center">
                        <input
                            type="checkbox"
                            wire:model.live="selectAll"
                            class="fi-checkbox-input rounded border-gray-300 text-primary-600
                                   shadow-sm focus:ring-primary-500 dark:border-gray-600
                                   dark:bg-gray-700">
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">
                        PO Number
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">
                        Supplier
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">
                        Material Code
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">
                        Material Name
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">
                        Specification
                    </th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">
                        Qty
                    </th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">
                        Remaining
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-gray-900/40">
                @forelse ($data as $po)
                <tr class="group transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50 cursor-pointer">

                    {{-- Checkbox --}}
                    <td class="px-4 py-3.5 w-10 text-center" onclick="event.stopPropagation()">
                        <input
                            type="checkbox"
                            wire:model="selected"
                            value="{{ $po->id }}"
                            class="fi-checkbox-input rounded border-gray-300 text-primary-600 shadow-sm
                                   focus:ring-primary-500 focus:ring-offset-0
                                   dark:border-gray-600 dark:bg-gray-700 dark:checked:bg-primary-500
                                   transition duration-75">
                    </td>

                    {{-- PO Number --}}
                    <td class="px-4 py-3.5 whitespace-nowrap font-semibold text-gray-900 dark:text-gray-100">
                        {{ $po->detail?->code ?? '—' }}
                    </td>

                    {{-- Supplier --}}
                    <td class="px-4 py-3.5 whitespace-nowrap text-gray-700 dark:text-gray-300 max-w-xs truncate" title="{{ $po->detail?->supplier?->name }}">
                        {{ $po->detail?->supplier?->name ?? '—' }}
                    </td>

                    {{-- Material Code --}}
                    <td class="px-4 py-3.5 whitespace-nowrap text-gray-700 dark:text-gray-300 max-w-xs truncate" title="{{ $po->material?->code }}>
                        {{ $po->material?->code ?? '—' }}
                    </td>

                    {{-- Material Name --}}
                    <td class=" px-4 py-3.5 whitespace-nowrap text-gray-700 dark:text-gray-300 max-w-xs truncate" title="{{ $po->material?->name }}">
                        {{ $po->material?->name ?? '—' }}
                    </td>

                    {{-- Specification --}}
                    <td class="px-4 py-3.5 whitespace-nowrap text-gray-500 dark:text-gray-400 max-w-xs truncate" title="{{ $po->material?->specification }}">
                        {{ $po->material?->specification ?? '—' }}
                    </td>

                    {{-- Quantity --}}
                    <td class="px-4 py-3.5 text-right font-semibold text-gray-900 dark:text-gray-100 tabular-nums whitespace-nowrap">
                        {{ number_format($po->qty) }}
                    </td>

                    {{-- Remaining --}}
                    <td class="px-4 py-3.5 text-right whitespace-nowrap">
                        @php
                        $badgeColors = ($po->qty_remaining ?? 0) > 0
                        ? 'bg-success-50 dark:bg-success-400/10 text-success-600 dark:text-success-400 ring-1 ring-inset ring-success-600/20 dark:ring-success-400/30'
                        : 'bg-danger-50 dark:bg-danger-400/10 text-danger-600 dark:text-danger-400 ring-1 ring-inset ring-danger-600/20 dark:ring-danger-400/30';
                        @endphp
                        <span class="fi-badge inline-flex items-center justify-center min-w-[theme(spacing.6)]
                                     rounded-xl px-2 py-0.5 text-xs font-medium tabular-nums {{ $badgeColors }}">
                            {{ $po->qty_remaining ?? 0 }}
                        </span>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-12 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <svg class="w-12 h-12 text-gray-300 dark:text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                @if($search)
                                No results found for "<span class="font-semibold">{{ $search }}</span>"
                                @else
                                No purchase orders available
                                @endif
                            </div>
                            @if($search)
                            <button
                                wire:click="$set('search', '')"
                                class="text-sm text-primary-600 dark:text-primary-400 hover:underline">
                                Clear search
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($data->hasPages())
    <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/30 rounded-b-xl">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                Showing {{ $data->firstItem() }} - {{ $data->lastItem() }} of {{ $data->total() }} results
            </div>
            <div>
                {{ $data->links() }}
            </div>
        </div>
    </div>
    @endif

    {{-- BUTTON ACTION BAR (Sama Ukuran & Style dengan Filament Bawaan) --}}
    <div class="flex items-center justify-between gap-3 px-6 pt-4">
        <div class="text-sm text-gray-500 dark:text-gray-400">
            Selected: <span class="font-bold text-primary-600 dark:text-primary-400" x-text="$wire.selected.length">0</span> items
        </div>

        <div class="flex items-center gap-2">
            {{-- Tombol Add Selected Style Filament (Diperkecil) --}}
            <button
                type="button"
                wire:click="dispatchSelected"
                class="fi-btn inline-flex items-center justify-center font-semibold px-3 py-1.5 text-sm rounded-lg transition duration-75 bg-primary-600 text-white shadow-sm hover:bg-primary-500 dark:bg-primary-500 dark:hover:bg-primary-400">
                Ok
            </button>
            {{-- Tombol Cancel Style Filament --}}
            <button
                type="button"
                x-on:click="$dispatch('close-modal')"
                class="fi-btn inline-flex items-center justify-center font-semibold px-3 py-1.5 text-sm rounded-lg transition duration-75 bg-white text-gray-950 shadow-sm ring-1 ring-gray-950/10 hover:bg-gray-50 dark:bg-white/5 dark:text-white dark:ring-white/10 dark:hover:bg-white/10">
                Cancel
            </button>
        </div>
    </div>
</div>