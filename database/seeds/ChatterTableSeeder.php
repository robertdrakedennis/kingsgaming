<?php

use Illuminate\Database\Seeder;

class ChatterTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {

        // CREATE THE CATEGORIES
        \DB::table('chatter_categories')->delete();

        \DB::table('chatter_categories')->insert([
            0 => [
                'id'         => 1,
                'parent_id'  => null,
                'order'      => 1,
                'name'       => 'Introductions',
                'color'      => '#3498DB',
                'slug'       => 'introductions',
                'created_at' => null,
                'updated_at' => null,
            ],
            1 => [
                'id'         => 2,
                'parent_id'  => null,
                'order'      => 2,
                'name'       => 'General',
                'color'      => '#2ECC71',
                'slug'       => 'general',
                'created_at' => null,
                'updated_at' => null,
            ],
            2 => [
                'id'         => 3,
                'parent_id'  => null,
                'order'      => 3,
                'name'       => 'Feedback',
                'color'      => '#9B59B6',
                'slug'       => 'feedback',
                'created_at' => null,
                'updated_at' => null,
            ],
            3 => [
                'id'         => 4,
                'parent_id'  => null,
                'order'      => 4,
                'name'       => 'Random',
                'color'      => '#E67E22',
                'slug'       => 'random',
                'created_at' => null,
                'updated_at' => null,
            ],
            4 => [
                'id'         => 5,
                'parent_id'  => 1,
                'order'      => 1,
                'name'       => 'Rules',
                'color'      => '#227ab5',
                'slug'       => 'rules',
                'created_at' => null,
                'updated_at' => null,
            ],
            5 => [
                'id'         => 6,
                'parent_id'  => 5,
                'order'      => 1,
                'name'       => 'Basics',
                'color'      => '#195a86',
                'slug'       => 'basics',
                'created_at' => null,
                'updated_at' => null,
            ],
            6 => [
                'id'         => 7,
                'parent_id'  => 5,
                'order'      => 2,
                'name'       => 'Contribution',
                'color'      => '#195a86',
                'slug'       => 'contribution',
                'created_at' => null,
                'updated_at' => null,
            ],
            7 => [
                'id'         => 8,
                'parent_id'  => 1,
                'order'      => 2,
                'name'       => 'About',
                'color'      => '#227ab5',
                'slug'       => 'about',
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
