<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
  
    // get data from my database "Afficher la list de tous les favoris"
    public function findById($id)  
    {  
        error_log('findById');

        $favorites = Favorite::where('user_id', $id)->get();
        return response()->json($favorites);
    }


    // store data in my database "Ajouter un favori"
    public function store(Request $request, $id)
    {
        if (Favorite::where('word', $request->word)->where('user_id', $id)->exists()) {
            return response()->json(['message' => 'Data exists.']);
        }else{
            $fav = Favorite::create([
                'word' => $request->word,
                'user_id' => $id,
            ]);
        return response()->json($fav, 201, ['message' => 'Data stored successfully.']);
        }
    }
    
    // get data from the public API "Search"
    public function getItem($params)
    {
        $client = new \GuzzleHttp\Client([
            'verify' => false,
        ]);
        
        $res = $client->request('GET', "https://api.dictionaryapi.dev/api/v2/entries/en/" . urlencode($params));
        $data = json_decode($res->getBody(), true);
        error_log('getItem'. $data);

        $array = array();
        foreach ($data as $value) {
            $array[] = array(
                "word" => $value['word'] ?? null,
                "phoneticT" => $value['phonetics'][0]['text'] ?? null,
                "def" => $value['meanings'][0]['definitions'][0]['definition'] ?? null,
                "syn" => $value['meanings'][0]['definitions'][0]['synonyms'][0] ?? null,
                "ano" => $value['meanings'][0]['definitions'][0]['antonyms'][0] ?? null,
                "exp" => $value['meanings'][0]['definitions'][0]['example'] ?? null
            );
        }
        return $array;
    }


    // delete data from my database "Suprimer un favori"
    public function destroy(Request $request, $id)  
    {  
        $data = Favorite::where('user_id', $id)->where('word', $request->word)->first();
        
        if ($data) {
            $data->delete();
            return response()->json(['message' => 'Data deleted successfully.']);
        } else {
            return response()->json(['message' => 'Data not exists.']);
        }
    }


    // afficher les mot rechercher par plusieurs user
    public function getDuplicateWords()
    {
        $duplicates = Favorite::select('word')
            ->groupBy('word')
            ->havingRaw('COUNT(DISTINCT user_id) > 1')
            ->get();

        return response()->json($duplicates);
    }


    // verify a user in the database if exist or not
    public function verifyUser(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $hash = password_hash($password, PASSWORD_BCRYPT);

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }
        if (!password_verify($password, $hash)) {
            return response()->json(['message' => 'Incorrect password.'], 401);
        }

        return response()->json(['name' => $user->name], 200);
    }

}