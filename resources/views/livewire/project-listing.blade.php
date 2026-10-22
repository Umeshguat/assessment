<div x-data="{ open: false }">
    {{-- Filters: Livewire = server state, Alpine = mobile toggle --}}
    <div class="mb-6 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <button type="button" @click="open = !open"
                class="flex w-full items-center justify-between text-sm font-semibold text-slate-700 md:hidden">
            Filters <span x-text="open ? '−' : '+'"></span>
        </button>

        <div :class="open ? 'block' : 'hidden'" class="mt-4 grid gap-3 md:mt-0 md:grid md:grid-cols-[1fr_160px_auto]">
            <input type="search" wire:model.live.debounce.400ms="search" placeholder="Search project name…"
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">

            <select wire:model.live="bhk"
                    class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                <option value="">Any BHK</option>
                @foreach ([1, 2, 3, 4, 5] as $n)
                    <option value="{{ $n }}">{{ $n }} BHK</option>
                @endforeach
            </select>

            <button type="button" wire:click="resetFilters"
                    class="rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50">
                Reset
            </button>
        </div>
    </div>

    <p class="mb-4 text-sm text-slate-500" wire:loading.remove>{{ $projects->total() }} projects found</p>
    <p class="mb-4 text-sm text-indigo-600" wire:loading>Updating…</p>

    <div wire:loading.class="opacity-50" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($projects as $project)
            <x-project-card :project="$project" :eager="$loop->first" wire:key="p-{{ $project->id }}" />
        @empty
            <div class="col-span-full rounded-xl border border-dashed border-slate-300 p-10 text-center text-slate-500">
                No projects match these filters.
            </div>
        @endforelse
    </div>

    <div class="mt-8">{{ $projects->links() }}</div>
</div>
