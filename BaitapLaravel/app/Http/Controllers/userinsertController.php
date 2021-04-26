<?php
namespace App\Http\Controllers;
use App\StudInsert;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class userinsertController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
}

/*public function insert(){
        $urlData = getURLList();
        return view('stud_create');
    }
    public function create(Request $request){
        $rules = [
            'user' => 'required|string|min:3|max:255',
            'user_name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255'
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return redirect('insert')
                ->withInput()
                ->withErrors($validator);
        }
        else{
            $data = $request->input();
            try{
                $user = new userInsert;
                $user->user = $data['user'];
                $user->user_name = $data['user_name'];
                $user->address = $data['address'];
                $user->email = $data['email'];
                $user->save();
                return redirect('insert')->with('status',"Insert successfully");
            }
            catch(Exception $e){
                return redirect('insert')->with('failed',"operation failed");
            }
        }
    }
}*/
