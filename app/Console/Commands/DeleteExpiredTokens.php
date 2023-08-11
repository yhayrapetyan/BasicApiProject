<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\PersonalAccessToken;

class DeleteExpiredTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-expired-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete the expired tokens';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('deleting expired tokens');
        PersonalAccessToken::query()
            ->orWhere('expires_at', '<', Carbon::now())
            ->orWhere('expires_at', null)->delete();
        $this->info('Expired tokens deleted successfully');
    }
}
