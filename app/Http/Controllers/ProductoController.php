<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $firebase;

    public function __construct()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/mycommute-891a4-firebase-adminsdk-qf24x-6c6b90aa3f.json');
        $this->firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://mycommute-891a4.firebaseio.com/')
            ->create();
    }
    public function index()
    {
        $database = $this->firebase->getDatabase();

        $productos = $database->getReference('erp/producto')->getValue();

        return view('Producto.index',compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('producto.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[ 'nombre'=>'required',
                                    'precio'=>'required']);

        $nombre = $request->input('nombre');
        $precio = $request->input('precio');

        $database = $this->firebase->getDatabase();

        $newPost = $database
            ->getReference('erp/producto')
            ->push([
                'id' => '' ,
                'nombre' => $nombre ,
                'precio' => $precio,
                'fecharegistro' => date("Y-m-d H:i:s"),
                'marcabaja' => 0
                    ]);
        $reference = $database->getReference('erp/producto/'.$newPost->getKey());
        $reference->update(['id'=>$newPost->getKey()]);

        return redirect()->route('producto.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $database = $this->firebase->getDatabase();

        $producto = $database->getReference('erp/producto/'.$id)->getValue();
        return view('producto.show',compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $database = $this->firebase->getDatabase();

        $producto = $database->getReference('erp/producto/'.$id)->getValue();
        return view('producto.edit',compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[ 'nombre'=>'required',
                                    'precio'=>'required']);

        $nombre = $request->input('nombre');
        $precio = $request->input('precio');

        $database = $this->firebase->getDatabase();

        $reference = $database->getReference('erp/producto/'.$id);
        $reference->update(['nombre'=>$nombre,
                            'precio'=>$precio]);
        return redirect()->route('producto.index')->with('success','Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $database = $this->firebase->getDatabase();

        $database->getReference('erp/producto/'.$id)->remove();
        return redirect()->route('producto.index')->with('success','Registro eliminado satisfactoriamente');
    }

}
