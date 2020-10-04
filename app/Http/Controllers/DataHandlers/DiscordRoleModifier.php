<?php

namespace App\Http\Controllers\DataHandlers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RestCord\DiscordClient;

class DiscordRoleModifier extends Controller
{
    public function assignBloqued($discord_id)
    {
        $discord = new DiscordClient(['token' => config('discordsso.bot_token')]);
        $discord->guild->addGuildMemberRole([
            'guild.id' => (int)config('discordsso.guild_id'),
            'user.id' => $discord_id,
            'role.id' => config('discordsso.bloqued_role'),
        ]);
    }

    public function removeBloqued($discord_id)
    {
        $discord = new DiscordClient(['token' => config('discordsso.bot_token')]);
        $discord->guild->removeGuildMemberRole([
            'guild.id' => (int)config('discordsso.guild_id'),
            'user.id' => $discord_id,
            'role.id' => config('discordsso.bloqued_role'),
        ]);
    }
}
