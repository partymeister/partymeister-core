<?php

namespace Partymeister\Core\Console\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Motor\Backend\Models\User;
use Partymeister\Core\Models\Callback;
use Partymeister\Core\Services\StuhlService;

/**
 * Class PartymeisterCoreCheckCallbacksCommand
 *
 * @package Partymeister\Core\Console\Commands
 */
class PartymeisterCoreCheckCallbacksCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'partymeister:core:check-callbacks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and fire callbacks';

    /**
     * Execute the console command.
     *
     * @throws GuzzleException
     */
    public function handle()
    {
        Auth::login(User::first());

        $callbacks = Callback::where('is_timed', true)
                             ->where('has_fired', false)
                             ->where('embargo_until', '<', date('Y-m-d H:i:s'))
                             ->get();

        foreach ($callbacks as $callback) {
            Log::info('Firing callback '.$callback->name);

            if ($callback->action == 'notification') {
                StuhlService::send($callback->body, $callback->title, '', EVENT_LEVEL_BORING, $callback->destination);
            }

            $callback->has_fired = true;
            $callback->save();
        }
    }
}
