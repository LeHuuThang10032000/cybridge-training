<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class UsersTableBackUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:users-table-back-up';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Users Table Backup Command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = "backup_users_table_" . Carbon::now()->format('Y-m-d') . ".gz";
  
        $command = "mysqldump --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . " --no-tablespaces | gzip > " . storage_path() . "/app/backup/" . $filename;
  
        $returnVar = NULL;
        $output  = NULL;
  
        exec($command, $output, $returnVar);
    }
}
