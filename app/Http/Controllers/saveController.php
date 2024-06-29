<?php
namespace App\Http\Controllers;
use App\Models\SaveFile;
use App\Models\Game;
use Illuminate\Http\Request;

class saveController extends Controller
{
    public function index(){
        $saves = SaveFile::all();
        return response()->json($saves);
    }
    public function getAll(Request $request){
        $user = auth()->user();
        $game = Game::where('game_key', $request->header('X-Game-API-Key'))->first();

        if (!$user) {
          return response()->json(['error' => 'User not found'], 401);
        }
      
        $saveFiles = SaveFile::where('user_id', $user->id)->where('game_id', $game->id)->get();
        return response()->json($saveFiles);
        
    }
    public function newSave(Request $request) {
        $user = auth()->user();
        $request->validate([
            'gameData' => 'required|array'
        ]);
        $game = Game::where('game_key', $request->header('X-Game-API-Key'))->first();

        $save = new SaveFile;
        $save->user_id = $user->id;
        $save->gameData = json_encode($request->gameData);
        $save->game_id = $game->id;
        $save->save();
        return $this->sendResponse($save, 'Game saved.', 201);
    }
    public function load($id) {
        $user = auth()->user();
        $save = SaveFile::find($id);

        if(!empty($save)) {
            if($save->user_id != $user->id) {
                return $this->sendError('Unauthorized.', ['error' => 'Unauthorized.']);
            }

            return $this->sendResponse($save, 'Game loaded.');
        } else {
            return $this->sendError('Save file not found.', ['error' => 'Save file not found.']);
        }
    }
    public function overwrite(Request $request, $id) {
        $user = auth()->user();
        $request->validate([
            'gameData' => 'required|array',
        ]);
        
        if(SaveFile::where('id', $id)->exists()){
            $save = SaveFile::find($id);
            $game_id = (Game::where('game_key', $request->header('X-Game-API-Key'))->first())->id;
            if($save->user_id != $user->id || $save->game_id != $game_id) {
                return $this->sendError('Unauthorized.', ['error' => 'Unauthorized.']);
            } else {
                $save->gameData = json_encode($request->gameData);
                $save->updated_at = now();
                $save->save();
                return $this->sendResponse($save, 'Save file updated successfully.');
            }
        }
    }    
    public function delete($id){
        $user = auth()->user();
        if(SaveFile::where('id', $id)->exists){
            $save = SaveFile::find($id);
            if($save->user_id != $user->id) {
                return $this->sendError('Unauthorized.', ['error' => 'Unauthorized.']);
            } else {
                $save->delete();
                return $this->sendResponse($save, 'Save file deleted successfully.');
            }
        } else {
            return $this->sendError('Save file not found.', ['error' => 'Save file not found.']);
        }
    }
}