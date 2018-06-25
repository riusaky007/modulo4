<?php

namespace App\Http\Controllers;

use App\Libro;
use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class LibroController extends Controller
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

        $libros = $database->getReference('erp/libro')->getValue();

        return view('Libro.index',compact('libros'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Libro.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[ 'nombre'=>'required',
                                   'resumen'=>'required',
                                   'npagina'=>'required',
                                   'edicion'=>'required',
                                   'autor'=>'required',
                                   'precio'=>'required']);

        $nombre = $request->input('nombre');
        $resumen=$request->input('resumen');
        $npagina = $request->input('npagina');
        $edicion = $request->input('edicion');
        $autor = $request->input('autor');
        $precio = $request->input('precio');

        $database = $this->firebase->getDatabase();


        $newPost = $database
            ->getReference('erp/libro')
            ->push([
                'id' => '' ,
                'nombre' => $nombre ,
                'resumen' => $resumen,
                'npagina' => $npagina,
                'edicion' => $edicion,
                'autor' => $autor,
                'precio' => $precio
            ]);
        $reference = $database->getReference('erp/libro/'.$newPost->getKey());
        $reference->update(['id'=>$newPost->getKey()]);

        return redirect()->route('libro.index')->with('success','Registro creado satisfactoriamente');
    }
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/mycommute-891a4-firebase-adminsdk-qf24x-6c6b90aa3f.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://mycommute-891a4.firebaseio.com/')
            ->create();

        $database = $firebase->getDatabase();

        $libros = $database->getReference('erp/libro/'.$id)->getValue();
        return view('libro.show',compact('libros'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $database = $this->firebase->getDatabase();

        $libro = $database->getReference('erp/libro/'.$id)->getValue();
        return view('libro.edit',compact('libro'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request,[ 'nombre'=>'required',
            'resumen'=>'required',
            'npagina'=>'required',
            'edicion'=>'required',
            'autor'=>'required',
            'precio'=>'required']);

        $nombre = $request->input('nombre');
        $resumen=$request->input('resumen');
        $npagina = $request->input('npagina');
        $edicion = $request->input('edicion');
        $autor = $request->input('autor');
        $precio = $request->input('precio');

        $database = $this->firebase->getDatabase();

        $reference = $database->getReference('erp/libro/'.$id);
        $reference->update(['nombre'=>$nombre,
                            'resumen'=>$resumen,
                            'npagina'=>$npagina,
                            'edicion'=>$edicion,
                            'autor'=>$autor,
                            'precio'=>$precio]);
        return redirect()->route('libro.index')->with('success','Registro actualizado satisfactoriamente');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $database = $this->firebase->getDatabase();

        $database->getReference('erp/libro/'.$id)->remove();
        return redirect()->route('libro.index')->with('success','Registro eliminado satisfactoriamente');
    }
}