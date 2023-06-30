<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::connection()->disableQueryLog();
        
        $csvFile = database_path('seeders/data/users.csv');
        $users = $this->parseCsv($csvFile);

        $userChunks = array_chunk($users, 1000);

        foreach ($userChunks as $chunk) {
            $values = [];

            foreach ($chunk as $userData) {
                $values[] = "('{$userData['name']}', '{$userData['email']}', '" . Hash::make($userData['password'], ['rounds' => 5]) . "')";
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
            while (($row = fgetcsv($handle, 4096, ',')) !== false) {
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
