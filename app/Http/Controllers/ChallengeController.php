<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class ChallengeController extends Controller
{

    public function answer(Request $request, $id){
        if (!is_numeric($id)) {
            return back()->withErrors(["error"=>"ID must be a number"]);
        }
        $find = Challenge::find($id);
        if (empty($find)){
            return back()->withErrors(["error"=>"Challenge does not exist"]);
        }

        $check=-1;
        $answer='';
        if (!empty($_POST['submit'])) {
            $answer = $request->get('answer');
            //if ($answer==$find->link || $answer.'.txt' == $find->link){
                // $dir_download = 'public/challenges/'. $find['link'];
                // $result = Storage::get($dir_download);
                // $dir_download = public_path('storage/challenges/'. $find['link']);
                // $result = File::get($dir_download);
                //$check=1;
            //}

            $folder = storage_path('app/public/challenges/');
            $list = scandir($folder);
            $len = count($list);
            $check=0;
            for ($i=0 ; $i < $len ; $i++ ) { 
                $arr = explode('.',$list[$i]);
                if($answer == $arr[1] && $find->title == $arr[0]){
                    $check=1;
                    break;
                }
            }      
        }
        return view('challenges.answer',['challenge' => $find,'answer' => $answer,'check'=>$check]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id){
        if (!is_numeric($id)) {
            return back()->withErrors(["error"=>"ID must be a number"]);
        }
        $find = Challenge::find($id);
        if (empty($find)){
            return back()->withErrors(["error"=>"Challenge does not exist"]);
        }
        $filePath = 'public/challenges/'. $find->link;
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
        if ($find->delete()){
            return redirect()->route('challenge.index')->with("success","Delete challenge successfully");
        }
        return back()->withErrors(["error"=>"Delete challenge failed"]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'suggest' => 'required',
            'challenge' => 'required|mimes:txt|file|max:15360',
        ],
        [
            'challenge.mimes' => 'Only .txt files are allowed to upload'
        ]);

        $challenge_name = $request->file('challenge');
        $file_name = $challenge_name->getClientOriginalName();

        
        $challenge_name->storeAs('public/challenges/', $request->get('title').'.'.$file_name, 'local');
        $data_create = [
            'user_id' => Auth::id(),
            'username' => Auth::user()->username,
            'title' => $request->get('title'),
            'suggest' => $request->get('suggest'),
            //'link' => $file_name,
            'is_active' => 1,
        ];
        if (Challenge::create($data_create)){
            return redirect()->route('challenge.index')->with("success","Add new challenge successfully");
        }
        return back()->withErrors(["error"=>"Add new challenge failed"]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(){
        return view('challenges.create');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(){
        $challenges = Challenge::all();
        return view('challenges.index',['challenges' => $challenges]);
    }
}
