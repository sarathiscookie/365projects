<?php

use Illuminate\Database\Seeder;
use App\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $project = [
            ['title' => 'tennis',
                'description'    => NULL
            ],
        ];

        Project::insert($project);
    }
}
