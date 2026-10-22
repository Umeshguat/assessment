<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectListing extends Component
{
    use WithPagination;

    public string $segment;

    #[Url(as: 'bhk', except: '')]
    public string $bhk = '';

    #[Url(as: 'q', except: '')]
    public string $search = '';

    public function updated(string $name): void
    {
        if (in_array($name, ['bhk', 'search'], true)) {
            $this->resetPage();
        }
    }

    public function resetFilters(): void
    {
        $this->reset('bhk', 'search');
        $this->resetPage();
    }

    public function render()
    {
        $projects = Project::query()
            ->with('developer')
            ->listing($this->segment)
            ->when($this->bhk !== '' && ctype_digit($this->bhk), fn ($q) => $q->where('bhk', (int) $this->bhk))
            ->when(trim($this->search) !== '', fn ($q) => $q->where('title', 'like', '%'.trim($this->search).'%'))
            ->orderByDesc('id')
            ->paginate(20);

        return view('livewire.project-listing', ['projects' => $projects]);
    }
}
