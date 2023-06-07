<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearStorageImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:clear-public';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the contents of the public images storage folder';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Storage::deleteDirectory('public/images');
        Storage::makeDirectory('public/images');
        $this->info('Public Images storage cleared.');
    }
}
