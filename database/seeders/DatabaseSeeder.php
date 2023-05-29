<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Skill;
use App\Models\Service;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Project;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        //Experience::factory(1)->create();
        Project::factory(1)->create();

    }
}
