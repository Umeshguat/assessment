<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Support\Seo\IndexingPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ListingController extends Controller
{
    public function index(Request $request, IndexingPolicy $policy, string $segment)
    {
        $segment = Str::lower($segment);

        // Unfiltered query: drives the 404 decision and SEO policy.
        // The interactive grid itself is rendered by the ProjectListing Livewire component.
        $projects = Project::query()
            ->listing($segment)
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        abort_if($projects->total() === 0 || $projects->currentPage() > $projects->lastPage(), 404);

        $seo = $policy->decide($request, $projects);

        return view('listing', compact('projects', 'seo', 'segment'));
    }
}
