<?php

namespace App\Console\Commands;

use App\Models\chatGroup;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class sendAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alert:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Alert Email';

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

    }
}
