<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuuminate\Support\Facades\File;
class MakeView extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'command untuk membuat view';

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
        $name = $this->argument('name');
        $viewPath = resource_path("views/{$name}.blade.php");

        if (File::exists($viewPath)) {
            return $this->error('View already exists!');
        }

        File::put($viewPath, '');

        $this->info("View created: {$viewPath}");
    }
}
