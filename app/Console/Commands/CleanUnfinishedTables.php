<?php

namespace App\Console\Commands;

use App\Models\Table;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CleanUnfinishedTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tables:clean-unfinished';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command search for game tables that has not been completely created and abandoned longer than 10 minutes ago.';

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
        $max_idle = 10;
        $now = Carbon::now();
        $deadline = $now->subMinute($max_idle)->format('Y-m-d H:i:s');
        $uncompleted_tables = Table::where('current_player',null)->where('updated_at','<',$deadline)->get();

        foreach ($uncompleted_tables as $uncompleted_table){
            $uncompleted_table->delete();
        }
        return Command::SUCCESS;
    }
}
