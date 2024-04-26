<?php

namespace App\Console\Commands;

use App\Point;
use App\User;
use Illuminate\Console\Command;

class ExpiredPoint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:expr-point';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expired point every 6 months for all users';

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
        $points = Point::all();

        foreach ($points as $point) {
            $date = $point->date;
            $date = date('Y-m-d', strtotime($date . ' + 6 months'));
            $now = date('Y-m-d');

            if ($date < $now) {
                $user = User::find($point->user_id);
                $user->point = $user->point - $point->point;
                $user->save();
            }
        }

        $this->info('Expired point has been successfully');

        return 0;
    }
}
