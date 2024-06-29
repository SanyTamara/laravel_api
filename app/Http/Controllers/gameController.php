<?php
namespace App\Http\Controllers;
use App\Models\Game;
use Illuminate\Http\Request;
use illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class gameController extends Controller
{
    public function RegisterGame(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = auth()->user();
        
        if(!$user->is_dev){
            return $this->sendError('Unauthorized.', ['error' => 'Unauthorized.']);
        }
        $game = new Game;

        $game->name = $request->name;
        $game->creator_id = $user->id;
        $game->game_key = Str::random(64);
        $game->save();

        return $this->sendResponse($game, 'Game registered. Use the key on your game client.', 201);
    }

    public function fetchKeys(){
        $user = auth()->user();
        if(!$user->is_dev){
            return $this->sendError('Unauthorized.', ['error' => 'Unauthorized.']);
        }
        
        $games = Game::where('creator_id', $user->id)->get();
        return $this->sendResponse($games, 'Game keys fetched.');   
    }
}