<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Image;
use App\User;
use DB;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
        {
            $this->middleware('web');
        }
    public function index()
    {
        
        return view('layouts.home.profile', ['user'=>Auth::user()]);
        
    }

    public function TotalFactura($id)
    {
        $local = DB::select("call sgt01.SP_Tarefas_Usuario(?)",[$id]);
        return view('layouts.home.profile', ['user'=>Auth::user()])->with('local',$local);
        
    }

    public function update_avatar(Request $request)
    {
      //Handle the user upload of update_avatar
      if ($request->hasFile('avatar')) {
        $avatar = $request->file('avatar');
        $filename = time() . '.' . $avatar->getClientOriginalExtension();
        Image::make($avatar)->resize(300, 300)->save( public_path('/img/profile/' . $filename));

        $user = Auth::user();
        $user->avatar = $filename;
        $user->save();
      }
      return view('layouts.home.profile', ['user'=>Auth::user()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     //TODO criar novo usuário e definir o role
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    protected $rules=[
        'name' => 'required|max:255',
        'about' => 'required',
        'endereco'=>'required',
        'bday'=>'required',
        'occupation'=>'required',
        'telefone'=>'required',
        'password'=>'required|min:6|confirmed',
        'password_confirmation'=>'sometimes|required_with:password',
      ];
    public function update(Request $request, $name)
    {


      $userid = DB::Table('users')->select('id')->where('name','=',$name)->get();
      $this->rules['email']='required|email|unique:users,email,'.$userid[0]->id;
      $validate = Validator::make($request->all(), $this->rules);
      if ($validate->passes()) {

        $user = \App\User::find($userid[0]->id);
        $user->name = $request['name'];
        $user->about = $request['about'];
        $user->endereco = $request['endereco'];
        $user->bday = $request['bday'];
        $user->occupation = $request['occupation'];
        $user->email = $request['email'];
        $user->telefone = $request['telefone'];
        $user->save();
        return redirect('/dashboard/'.$name.'/profile')->with('success','Perfíl Actualizado!');
      }else{
        return redirect('/dashboard/'.$name.'/profile')->with('error','Perfíl Não Actualizado!');
      }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
