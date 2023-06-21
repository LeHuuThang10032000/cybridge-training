<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('permissions')->truncate();
        DB::table('permissions')->insert(
            [
                'name' => 'create_post',
                'guard_name' => 'web'
            ],
            [
                'name' => 'create_comment',
                'guard_name' => 'web'
            ],
        );

        Schema::enableForeignKeyConstraints();
    }
}
