<?php
namespace Centauri\Extension\Frontend\Command;

use Illuminate\Console\Command;

class TableLastUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     * 
     * @var string
     */
    protected $signature = 'command:TableLastUpdateCommand';

    /**
     * The console command description.
     * 
     * @var string
     */
    protected $description = 'Dummy command description.';

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
     * @return mixed
     */
    public function handle()
    {
        echo "lmaoooo: " . now() . "\n";
    }
}
