<?php

namespace Database\Seeders;

use App\Models\Developer;
use App\Models\Faq;
use App\Models\LandingPage;
use App\Models\Project;
use App\Models\Redirect;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $dev = Developer::factory()->create(['name' => 'Godrej Properties', 'slug' => 'godrej-properties']);

        Project::factory()->count(3)->create(['developer_id' => $dev->id, 'city' => 'goa', 'bhk' => 3]);
        Project::factory()->count(25)->create(['developer_id' => $dev->id, 'city' => 'mumbai']);

        LandingPage::create([
            'slug' => '3-bhk-flats-in-goa', 'city' => 'goa', 'bhk' => 3,
            'heading' => '3 BHK Flats in Goa', 'intro' => 'Verified 3 BHK flats in Goa.',
            'meta_title' => '3 BHK Flats for Sale in Goa | MoneyTree Realty',
            'meta_description' => 'Browse RERA-registered 3 BHK flats in Goa.',
        ]);

        Faq::create(['question' => 'Is RERA registration mandatory?', 'answer' => '<p>Yes.</p><script>alert(1)</script>']);

        Redirect::create(['old_path' => '/old-project', 'new_path' => '/real-estate-projects/goa', 'status_code' => 301]);
    }
}
