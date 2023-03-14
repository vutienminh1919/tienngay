<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('interest')->insert([
            'interest' => 1.5,
            'status' => 'active',
            'created_by' => "admin",
        ]);
    }
}
