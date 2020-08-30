<?php

namespace App\Http\Controllers\DataHandlers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RestCord\DiscordClient;

class DiscordAnnouncer extends Controller
{
    public function sendEventAnnouncement($title, $url, $imgurl, $content, $author_name, $date, $starttime, $endtime, $timestamp)
    {
        if ($url == "#") {
            $url = config('app.url');
        }
        if (is_null($imgurl)) {
            $imgurl = asset('media/img/placeholders/events_placeholder_noimg.png');
        }
        $discord = new DiscordClient(['token' => config('discordsso.bot_token')]);
        $discord->channel->createMessage([
            'channel.id' => config('discordsso.events_channel'),
            'content' => '@here',
            'embed' => [
                'author' =>[
                    'name' => 'Date: '.$date.' | '.$starttime.'z - '.$endtime.'z',
                ],
                'title' => $title,
                'url' => $url,
                'color' => 1,
                'image' => [
                    'url' => $imgurl,
                ],
                'fields' => [
                    [
                        'name' => 'Description de l\'évènement',
                        'value' => $content,
                    ],
                ],
                'footer' => [
                    'text' => 'Auteur • '.$author_name.' | Date de l\'event (UTC)',
                ],
                "timestamp" => $timestamp,
            ]
        ]);

        $msgs = $discord->channel->getChannelMessages([
            'channel.id' => config('discordsso.events_channel'),
        ]);
        $msgid = $msgs[0]->id;
        return $msgid;
    }

    public function editEventAnnouncement($msgid, $title, $url, $imgurl, $content, $author_name, $date, $starttime, $endtime, $timestamp)
    {
        if ($url == "#") {
            $url = config('app.url');
        }
        if (is_null($imgurl)) {
            $imgurl = asset('media/img/placeholders/events_placeholder_noimg.png');
        }
        $discord = new DiscordClient(['token' => config('discordsso.bot_token')]);
        $discord->channel->editMessage([
            'channel.id' => config('discordsso.events_channel'),
            'message.id' => (int)$msgid,
            'content' => '@here',
            'embed' => [
                'author' =>[
                    'name' => 'Date: '.$date.' | '.$starttime.'z - '.$endtime.'z',
                ],
                'title' => $title,
                'url' => $url,
                'color' => 1,
                'image' => [
                    'url' => $imgurl,
                ],
                'fields' => [
                    [
                        'name' => 'Description de l\'évènement',
                        'value' => $content,
                    ],
                ],
                'footer' => [
                    'text' => 'Auteur • '.$author_name.' | Date de l\'event (UTC)',
                ],
                "timestamp" => $timestamp,
            ]
        ]);
    }

    public function delEventAnnouncement($msgid)
    {
        try {
            $discord = new DiscordClient(['token' => config('discordsso.bot_token')]);
            $discord->channel->deleteMessage([
                'channel.id' => config('discordsso.events_channel'),
                'message.id' => (int)$msgid,
            ]);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function sendAnnouncement(Request $request)
    {
        # code...
    }
}
