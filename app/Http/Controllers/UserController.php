<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File; 

class UserController extends Controller
{
    public function __construct(){
    }

    /**
     * @param Request $request
     * @param $id
     * @return void
     */
    public function storeV2(Request $request, $id){
        if (!is_numeric($id)) {
            return back()->withErrors(["error"=>"ID must be a number"]);
        }
        $find = User::find($id);
        if (empty($find)){
            return back()->withErrors(["error" => "User does not exist"]);
        }
        $request->validate([
            'url' => "required",
        ]);
        
        $image_name = time().'-url-'.basename($request->url);     
        $source = file_get_contents($request->url);
        
        $image_path = public_path('assets/images/avatars/'.$find->avatar);
        if (File::exists($image_path)) {
            File::delete($image_path);
        }

        if(!Storage::disk('public_uploads')->put($image_name, $source)) {
            return back()->withErrors(["error"=>"Change profile avatar failed"]);
        }

        $update_url = $find->update([
            "avatar" => $image_name,
            "url" => $request->url,
        ]);
        if ($update_url){
            return redirect()->route('user.index')->with("success","Change profile avatar successfully");
        }
        
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function updateV2($id){
        if (!is_numeric($id)) {
            return back()->withErrors(["error"=>"ID must be a number"]);
        }
        $find = User::find($id);
        if (empty($find)){
            return back()->withErrors(["error"=>"User does not exist"]);
        }
        return view("users.updateV2",["id"=>$id, "user"=>$find]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function store(Request $request,$id){
        if (!is_numeric($id)) {
            return back()->withErrors(["error"=>"ID must be a number"]);
        }
        $find = User::find($id);
        if (empty($find)){
            return back()->withErrors(["error"=>"User does not exist"]);
        }
        // $request->validate([
        //     'avatar' => 'mimes:png,svg,gif,jpg,jpeg|max:15360|image',
        // ]);
        if (Auth::user()->role_id==1){
            $data_update = [
                'username' => empty($request->username)? $find->username : $request->username,
                'password' => empty($request->password)? $find->password : Hash::make($request->password),
                'full_name' => empty($request->full_name)? $find->full_name : $request->full_name,
                'email' => empty($request->email)? $find->email : $request->email,
                'phone' => empty($request->phone)? $find->phone : $request->phone,
                'is_active' => $request->is_active,
            ];
            }
            else {
                 $data_update = [
                'username' =>  $find->username ,
                'password' => empty($request->password)? $find->password : Hash::make($request->password),
                'full_name' => $find->full_name ,
                'email' => empty($request->email)? $find->email : $request->email,
                'phone' => empty($request->phone)? $find->phone : $request->phone,
                'is_active' => $request->is_active,
            ];
            }
        // if ($request->hasFile('avatar')) {
            $filePath = 'public/avatars/';
            // if (Storage::exists($filePath)) {
            //     Storage::delete($filePath);
            // }
           // $avatar = $request->file('avatar');
          //  $file_name = time().'_image_' . $avatar->getClientOriginalName();

           // move($filePath,$file_name);
           // $avatar->storeAs('public/avatars', $file_name, 'local');
            $data_update['avatar'] = $find->avatar;

        //}

        $update = $find->update($data_update);
        if ($update){
            return redirect()->route('user.index')->with("success","Update user information successfully");
        }
        return back()->withErrors(["error"=>"Update user information failed"]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function update($id){
        if (!is_numeric($id)) {
            return back()->withErrors(["error"=>"ID must be a number"]);
        }
        $find = User::find($id);
        if (empty($find)){
            return back()->withErrors(["error"=>"User does not exist"]);
        }
        return view("users.update",['user' => $find]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function detail(Request $request,$id){
        if (!is_numeric($id)) {
            return back()->withErrors(["error"=>"ID must be a number"]);
        }
        $find = User::find($id);
        if (empty($find)){
            return back()->withErrors(["error"=>"User does not exist"]);
        }
        $comments = Comment::where("user_id1",$id)->get();
        $com = "";
        if (isset($_GET['comment_id'])){
            if (!is_numeric($request->comment_id)) {
                return back()->withErrors(["error"=>"Comment ID must be a number"]);
            }
            $com = Comment::findOrFail($request->comment_id);
        }
        $owner = User::find($find->owner_id);
        return view("users.detail",['user' => $find,"owner" => $owner, "comments" => $comments, "com" => $com]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id){
        if (Auth::user()->role_id!=1){
            return back()->withErrors(["error"=>"You are not a teacher"]);
        }
        if (!is_numeric($id)) {
            return back()->withErrors(["error"=>"ID must be a number"]);
        }
        $find = User::find($id);
        if (empty($find)){
            return back()->withErrors(["error"=>"User does not exist"]);
        }
        
        $image_path = public_path('assets/images/avatars/'.$find->avatar);
        if (File::exists($image_path)) {
            File::delete($image_path);
        }

        if ($find->delete()){
            return redirect()->route('user.index')->with("success","Delete user successfully");
        }
        return back()->withErrors(["error"=>"Delete user failed"]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(){
        $users = User::all();
        return view("users.index", ["users" => $users]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request){
        if (Auth::user()->role_id!=1){
            return back()->withErrors(["error"=>"You are not a teacher"]);
        }

        // $validate = $request->validate([
        //     'username' => ['required'],
        //     'password' => ['required'],
        //     'full_name' => ['required'],
        //     'email' => ['required'],
        //     'phone' => ['required'],
        //     'avatar' => 'mimes:png,svg,gif,jpg,jpeg|max:15360|image'
        // ]);

        $data_create = [
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'owner_id' => Auth::id(),
            'role_id' => 2,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_active' => $request->is_active
        ];

        // if ($request->hasFile('avatar')) {
        //     $avatar = $request->file('avatar');
        //     $file_name = time().'_image_' . $avatar->getClientOriginalName();
        //     $avatar->storeAs('public/avatars', $file_name, 'local');
        //     $data_create['avatar'] = $file_name;
        // }

        $register = User::create($data_create);
        if ($register){
            return redirect()->route('user.index')->with("success","Add new student successfully");
        }
        return back()->withErrors(["error"=>"Add new student failed"]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request){
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'error' => 'Username or Password is incorrect',
            ]);
        }
        $request->session()->regenerate();
        return redirect()->route('home');
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function me(){
        return Auth::user();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with("success","Log out successfully!");
    }
}
