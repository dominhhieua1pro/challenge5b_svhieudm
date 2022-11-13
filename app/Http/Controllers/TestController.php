<?php

namespace App\Http\Controllers;

use App\Models\Submit;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function __construct()
    {
    }

    public function detail($id){
        if (!is_numeric($id)) {
            return back()->withErrors(["error"=>"ID must be a number"]);
        }
        $find = Test::find($id);
        if (empty($find)){
            return back()->withErrors(["error"=>"Assignment does not exist"]);
        }
        if (Auth::user()->role_id==1) {
            $submits = Submit::where('test_id',$id)->get();
        } else {
            $submits = Submit::where('user_id',Auth::id())->where('test_id',$id)->get();
        }
        return view('tests.detail',['test'=>$find, 'submits'=>$submits]);
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
        $find = Test::find($id);
        if (empty($find)){
            return back()->withErrors(["error"=>"Assignment does not exist"]);
        }

        $filePath = 'public/tests/'.$find->name_test."/". $find->links;
        if (Storage::exists($filePath)) {
            Storage::deleteDirectory('public/tests/'.$find->name_test);
        }

        $filePath2 = 'public/submit_tests/'.$find->name_test;
        if (Storage::exists($filePath2)) {
            Storage::deleteDirectory($filePath2);
        }
        if ($find->delete()){
            return redirect()->route('test.index')->with("success","Delete assignment successfully");
        }
        return back()->withErrors(["error"=>"Delete assignment failed"]);
    }

    public function download($id){
        if (!is_numeric($id)) {
            return back()->withErrors(["error"=>"ID must be a number"]);
        }
        $find = Test::find($id);
        if (empty($find)){
            return back()->withErrors(["error"=>"Assignment does not exist"]);
        }
        $filename = $find->links;
        $dir_download = 'public/tests/'.$find->name_test."/".$filename;
        if (Storage::exists($dir_download)) {
            return Storage::download($dir_download);
        }
        return back()->withErrors(['error' => "Assignment does not exist"]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){
        if (Auth::user()->role_id!=1){
            return back()->withErrors(["error"=>"You are not a teacher"]);
        }
        $request->validate([
            'name_test' => 'required',
            'test' => 'required|file|max:15360',
        ]);
        $test_name = $request->file('test');
        $file_name = time().'_assignment_' . $test_name->getClientOriginalName();
        $test_name->storeAs('public/tests/'.$request->get('name_test')."/", $file_name, 'local');
        $data_create = [
            'name_test' => $request->get('name_test'),
            'links' => $file_name,
            'user_id' => Auth::id(),
            'username' => Auth::user()->username,
            'is_active' => $request->get('status'),
        ];
        $create = Test::create($data_create);
        if ($create){
            return redirect()->route('test.index')->with("success","Add new assignment successfully");
        }
        return back()->withErrors(["error"=>"Add new assignment failed"]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(){
        if (Auth::user()->role_id!=1){
            return back()->withErrors(["error"=>"You are not a teacher"]);
        }
        return view('tests.create');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(){
        $tests = Test::all();
        return view('tests.index',['tests'=> $tests]);
    }
}
