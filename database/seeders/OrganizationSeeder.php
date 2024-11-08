<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;

class OrganizationSeeder extends Seeder
{
    public function run()
    {
        // Menambahkan data organisasi secara manual
        Organization::create([
            'name' => 'Organization A',
            'description' => 'Description for Organization A',
        ]);

        Organization::create([
            'name' => 'Organization B',
            'description' => 'Description for Organization B',
        ]);

        // Atau, jika menggunakan factory:
        \App\Models\Organization::factory(10)->create();
    }
}
