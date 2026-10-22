<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\LandingPage;
use App\Models\Project;
use Illuminate\Support\Facades\Cache;

class LandingController extends Controller
{
    public function show(string $slug)
    {
        $page = Cache::remember("landing-page:{$slug}", 600, fn () => LandingPage::where('slug', $slug)->first());
        abort_if(! $page, 404);   

        $projects = Project::query()
            ->where('status', 'active')
            ->where('city', $page->city)
            ->when($page->bhk, fn ($q, $bhk) => $q->where('bhk', $bhk))
            ->when($page->type, fn ($q, $type) => $q->where('type', $type))
            ->select(['id', 'developer_id', 'title', 'slug', 'city', 'type', 'bhk', 'price', 'rera_no', 'image', 'description'])
            ->with('developer:id,name,slug')            
            ->orderByDesc('id')
            ->paginate(24)                              
            ->withQueryString();

        $faqs = Cache::remember('faqs.landing', 3600, fn () => Faq::orderBy('id')->limit(10)->get(['id', 'question', 'answer']));

        return view('landing', compact('page', 'projects', 'faqs'));
    }
}
