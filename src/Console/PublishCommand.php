<?php

namespace Upload\Console;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'An easy way for vendor:publish';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $this->call('vendor:publish', [
            '--provider' => 'Upload\UploadServiceProvider', '--force' => true,
        ]);
    }
}
