<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class pushMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:msg {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Message To User';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $httpClient = new CurlHTTPClient(config('services.line.message.channel_token'));
        $bot = new LINEBot($httpClient, ['channelSecret' => config('services.line.message.channel_secret')]);
        $response = $bot->pushMessage($this->argument('id'),
            new \LINE\LINEBot\MessageBuilder\StickerMessageBuilder(1,401));
        return 0;
    }
}
