<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class DBBackup extends Command
{
    
    protected $signature = 'db:backup';

    
    protected $description = 'Database backup';

    
    public function handle()
    {
        $fileName = Carbon::now()->format('Y-m-d H:i:s').".sql";
        $command = "mysqldump --user=" .env('DB_USERNAME')." --password=" .env('DB_PASSWORD')."host=" .env('DB_HOST')." > ". storage_path()."/app/backup/".$fileName;
        exec($command);
        return Command::SUCCESS;
    }
}
