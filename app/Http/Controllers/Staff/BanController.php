<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DataHandlers\DiscordRoleModifier;
use App\Models\Users\BannedUser;
use App\Models\Users\DiscordData;
use App\Models\Users\User;
use Illuminate\Http\Request;

class BanController extends Controller
{
    public function addBan(Request $request)
    {
        $user = User::where('vatsim_id', request('cid'))->firstOrFail();
        $discord = DiscordData::where('user_id', $user->id)->first();
        $discordId = null;
        if (!is_null($discord)) {
            $discordId = $discord->discord_id;
            app(DiscordRoleModifier::class)->assignBloqued($discordId);
        }
        $ban = BannedUser::where('vatsim_id', request('cid'))->first();
        if (!is_null($ban)) {
            return redirect()->back()->with('error-toast', 'This user is already bloqued.');
        }
        BannedUser::create([
            'user_id' => $user->id,
            'vatsim_id' => request('cid'),
            'discord_id' => $discordId,
            'reason' => '(No reason given)',
        ]);

        return redirect()->back()->with('toast-success', 'User bloqued');
    }

    public function removeBan(Request $request)
    {
        $user = User::where('vatsim_id', request('cid'))->firstOrFail();
        $discord = DiscordData::where('user_id', $user->id)->first();
        $discordId = null;
        if (!is_null($discord)) {
            $discordId = $discord->discord_id;
            app(DiscordRoleModifier::class)->removeBloqued($discordId);
        }
        $ban = BannedUser::where('vatsim_id', request('cid'))->first();
        if (is_null($ban)) {
            return redirect()->back()->with('error-toast', 'This user is not bloqued.');
        }
        $ban->delete();

        return redirect()->back()->with('toast-success', 'User unbloqued');
    }
}
