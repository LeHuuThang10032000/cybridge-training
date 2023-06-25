<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\LazyCollection;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $csvFile = database_path('seeders/data/users.csv');
        $users = $this->parseCsv($csvFile);

        $userChunks = array_chunk($users, 500); // Chunk the users array to optimize insertion

        foreach ($userChunks as $chunk) {
            $values = [];

            foreach ($chunk as $userData) {
                $values[] = "('{$userData['name']}', '{$userData['email']}', '" . Hash::make($userData['password']) . "')";
            }

            $query = "INSERT INTO users (name, email, password) VALUES " . implode(',', $values);

            DB::statement($query);
        }
    }

    private function parseCsv($file)
    {
        $data = [];
        $header = null;

        if (($handle = fopen($file, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        return $data;
    }
}
