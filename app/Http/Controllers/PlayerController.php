<?php

namespace App\Http\Controllers;

use App\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    //
    public function postPlayer(Request $request)
    {
        $player = Player::create([
            'name'    => $request->name,
            'team_id' => $request->team_id
        ]);

        return redirect(route('entry.ready', $player->id));
    }

}
