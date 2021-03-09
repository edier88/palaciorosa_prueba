<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {        
        if($request->ajax()){
            
            if($request->input()){
                $id = $request->input('id_user'); // Cuando el "Content-Type" está ajustado a "application/json", los datos del JSON deben ser accedidos con el método "input"
                $response = User::find($id);
            } else{
                $response = User::all();
            }

            return $response;
        }
        return view('home');
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $response = User::create([
            'nombre' => $request->input('nombre'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'edad' => $request->input('edad'),
            'sexo' => $request->input('genero'),
            'direccion' => $request->input('direccion')
        ]);
        return $response;
         
        //return json_encode($request->input('nombre'));
        //return json_encode("holaaa");
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = User::where('id', $id)
                        ->update([
                            "nombre" => $request->input('nombre'),
                            "email" => $request->input('email'),
                            "password" => Hash::make($request->input('password')),
                            "sexo" => $request->input('genero'),
                            "edad" => $request->input('edad'),
                            "direccion" => $request->input('direccion')
                        ]);
        return json_encode($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $response = $user->delete();
        return $response;
    }
}
