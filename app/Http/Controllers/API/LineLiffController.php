<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class LineLiffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("lineliff.welcome_lineliff");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $artist = new Artist();
        $artist->name = $request->name;
        $artist->number_of_works = $request->number_of_works;
        $artist->line_work = $request->line_work;
        $artist->url = $request->url;
        $artist->save();
        $this->callPushMessage($artist);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function callPushMessage(Artist $artist){
        $httpClient = new CurlHTTPClient(config('services.line.message.channel_token'));
        $bot = new LINEBot($httpClient, ['channelSecret' => config('services.line.message.channel_secret')]);
        Artisan::call('send:msg',[ 'id' => 'U6ea883c1ca6b5b47b3ac7ef81651477b']);
        $message = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder(json_encode($artist));
        $response = $bot->pushMessage('U6ea883c1ca6b5b47b3ac7ef81651477b', $message);
    }
}
