<?php

namespace Tests\Feature;

use App\Models\Developer;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListingIndexingTest extends TestCase
{
    use RefreshDatabase;

    private const NOINDEX = '<meta name="robots" content="noindex';

    private function projects(int $n, string $city = 'goa'): void
    {
        $dev = Developer::factory()->create();
        Project::factory()->count($n)->create(['developer_id' => $dev->id, 'city' => $city, 'status' => 'active']);
    }

    public function test_goa_is_never_served_with_noindex(): void
    {
        $this->projects(1);   

        $this->get('/real-estate-projects/goa')
            ->assertOk()
            ->assertDontSee(self::NOINDEX, false)
            ->assertSee('<link rel="canonical" href="' . url('/real-estate-projects/goa') . '">', false);
    }

    public function test_tracking_params_do_not_cause_noindex(): void
    {
        $this->projects(3);

        $this->get('/real-estate-projects/goa?utm_source=ads&gclid=abc')
            ->assertOk()
            ->assertDontSee(self::NOINDEX, false);
    }

    public function test_filtered_sorted_and_paginated_pages_are_noindex(): void
    {
        $this->projects(25);

        foreach (['?bhk=2', '?sort=price', '?page=2'] as $qs) {
            $this->get('/real-estate-projects/goa' . $qs)->assertOk()->assertSee(self::NOINDEX, false);
        }
    }

    public function test_empty_listing_is_a_404(): void
    {
        $this->get('/real-estate-projects/thane')->assertNotFound();
    }
}
