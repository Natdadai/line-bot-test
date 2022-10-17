<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\LineBotService as LINEBot;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Event\MessageEvent\StickerMessage;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

class LineWebhookController extends Controller
{
    public function index(){
        return Artist::all();
    }

    public function message(Request $request) {
//        $data = $request->all();
//        $events = $data['events'];
        $artist = Artist::inRandomOrder()->get()->first();
        Log::info($request);
        $httpClient = new CurlHTTPClient(config('services.line.message.channel_token'));
        $bot = new LINEBot($httpClient, ['channelSecret' => config('services.line.message.channel_secret')]);
        $signature = $request->headers->get(HTTPHeader::LINE_SIGNATURE);
        $events = $bot->parseEventRequest($request->getContent(), $signature);

        foreach ($events as $event) {
            $replyToken = $event->getReplyToken();
            switch ($event) {
                case($event instanceof StickerMessage):
                    $packageID = $event->getPackageId();
                    $stickerID = $event->getStickerId();
                    $message = "p_ID : " . $packageID . "\n" . "s_ID : " . + $stickerID . "\n";
                    $response = $bot->replyText($replyToken, $message);
                    break;
                case($event instanceof TextMessage):
                    $message = 'give me 10 scores';
                    $user_send = $event->getText();
                    if($message == $user_send)
                        $response = $bot->replyText($replyToken, json_encode($artist));
                    else
                        $response = $bot->replyText($replyToken, "กรอกผิด");
                    break;
            }
        }
        return;
    }
}
