<?php

namespace App\Console\Commands;

use App\Models\Table;
use App\Models\Table as TableAlias;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanAbandonedGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tables:clean-abandoned';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command deletes all tables that has not been completed and not played for more than 7 days.';

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
        $max_idle = 7 ; // maximum game idle in days

        $now = Carbon::now();

        $deadline = $now->subDay($max_idle)->format('Y-m-d H:i:s');

        $unfinished_games = Table::where('winner',null)->where('updated_at','<',$deadline)->get();

        foreach ($unfinished_games as $unfinished_game){
            $unfinished_game->delete();
        }

        return Command::SUCCESS;
    }
}
