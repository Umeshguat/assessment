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

        $projects = Project::query()
            ->where('status', 'active')
            ->where(fn ($q) => $q->where('city', $segment)->orWhere('type', $segment))
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        abort_if($projects->total() === 0 || $projects->currentPage() > $projects->lastPage(), 404);

        $seo = $policy->decide($request, $projects);

        return view('listing', compact('projects', 'seo'));
    }
}
