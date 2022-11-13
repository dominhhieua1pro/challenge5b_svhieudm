<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function  __construct(){
    }

    public function update(Request $request, $id){
        if (!is_numeric($id)) {
            return back()->withErrors(["error"=>"ID must be a number"]);
        }
        $find = Comment::find($id);
        if (empty($find)){
            return back()->withErrors(["error"=>"Comment does not exist"]);
        }
        if ($find->user_id!=Auth::id()){
            return back()->withErrors(["error"=>"Not have access to edit message"]);
        }
        $update = $find->update([
            'content' => $request->get('content')
        ]);
        if ($update){
            return redirect()->route('user.detail',['id' => $request->user_id1])->with("success","Update message successfully");
        }
        return back()->withErrors(["error"=>"Update message failed"]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, $id){
        if (!is_numeric($id)) {
            return back()->withErrors(["error"=>"ID must be a number"]);
        }
        $find = Comment::find($id);
        if (empty($find)){
            return back()->withErrors(["error"=>"Comment does not exist"]);
        }
        if ($find->user_id!=Auth::id()){
            return back()->withErrors(["error"=>"Not have access to edit message"]);
        }
        if ($find->delete()){
            return redirect()->route('user.detail',['id' => $request->user_id1])->with("success","Delete message successfully");
        }
        return back()->withErrors(["error"=>"Delete message failed"]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request){
        $request->validate([
            "content" => "required",
        ]);
        $data_create = [
            'user_id1' => $request->get('user_id1'),
            'user_id' => Auth::id(),
            'username' => Auth::user()->username,
            'content' => $request->get('content')
        ];
        $create = Comment::create($data_create);
        if ($create){
            return redirect()->route('user.detail',['id' => $request->user_id1])->with("success","Send message successfully");
        }
        return back()->withErrors(["error"=>"Send message failed"]);
    }
}
