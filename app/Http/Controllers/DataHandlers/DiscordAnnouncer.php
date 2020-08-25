<?php

namespace App\Http\Controllers\DataHandlers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RestCord\DiscordClient;

class DiscordAnnouncer extends Controller
{
    public function sendAnnouncement($title, $url, $imgurl, $content, $author_name, $date, $starttime, $endtime, $timestamp)
    {
        if ($url == "#") {
            $url = config('app.url');
        }
        if (is_null($imgurl)) {
            $imgurl = asset('media/img/placeholders/events_placeholder_noimg.png');
        }
        $discord = new DiscordClient(['token' => config('discordsso.bot_token')]);
        $discord->channel->createMessage([
            'channel.id' => config('discordsso.announcements_channel'),
            'content' => '@everyone',
            'embed' => [
                'author' =>[
                    'name' => 'Date: '.$date.' | '.$starttime.' - '.$endtime,
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
                    'text' => 'Auteur: '.$author_name,
                ],
                "timestamp" => $timestamp,
            ]
        ]);

        $msgs = $discord->channel->getChannelMessages([
            'channel.id' => config('discordsso.announcements_channel'),
        ]);
        $msgid = $msgs[0]->id;
        return $msgid;
    }

    public function editAnnouncement($msgid, $title, $url, $imgurl, $content, $author_name, $date, $starttime, $endtime, $timestamp)
    {
        if ($url == "#") {
            $url = config('app.url');
        }
        if (is_null($imgurl)) {
            $imgurl = asset('media/img/placeholders/events_placeholder_noimg.png');
        }
        $discord = new DiscordClient(['token' => config('discordsso.bot_token')]);
        $discord->channel->editMessage([
            'channel.id' => config('discordsso.announcements_channel'),
            'message.id' => (int)$msgid,
            'content' => '@everyone',
            'embed' => [
                'author' =>[
                    'name' => 'Date: '.$date.' | '.$starttime.' - '.$endtime,
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
                    'text' => 'Auteur: '.$author_name,
                ],
                "timestamp" => $timestamp,
            ]
        ]);
    }
}
