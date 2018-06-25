<?php

namespace App\Http\Controllers;

use App\venta;
use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $firebase;

    public function __construct()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mycommute-891a4-firebase-adminsdk-qf24x-6c6b90aa3f.json');
        $this->firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://mycommute-891a4.firebaseio.com/')
            ->create();
    }

    public function index()
    {
        $database = $this->firebase->getDatabase();

        $ventas = $database->getReference('erp/venta')->getValue();

        return view('venta.index', compact('ventas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $database = $this->firebase->getDatabase();

        $productos = $database->getReference('erp/producto')->getValue();
        return view('venta.create', compact('productos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['nombre' => 'required',
            'sucursal' => 'required',
            'cinit' => 'required',
            'listProducts' => 'required'
        ]);

        $nombrecliente = $request->input('nombre');
        $sucursal = $request->input('sucursal');
        $cinit = $request->input('cinit');
        $listaProducts = $request->get('listProducts');
        $listaProducts = (json_decode($listaProducts, true));
        $cantidad_productos = count($listaProducts);

        $database = $this->firebase->getDatabase();

        $newPost = $database
            ->getReference('erp/venta')
            ->push([
                'id' => '',
                'nombre' => $nombrecliente,
                'sucursal' => $sucursal,
                'cinit' => $cinit,
                'cantidadp' => $cantidad_productos,
                'marcabaja' => 0,
                'fecharegistro' => date("d-m-Y")
            ]);
        $reference = $database->getReference('erp/venta/' . $newPost->getKey());
        $reference->update(['id' => $newPost->getKey()]);
        foreach ($listaProducts as $productos) {
            $id = $productos['id'];
            $nombreproducto = $productos['nombre'];
            $cantidad = $productos['cantidad'];
            $product = $database
                ->getReference('erp/detalleventa/' . $newPost->getKey())
                ->push([
                    'id' => '',
                    'idproducto' => $id,
                    'nombreproducto' => $nombreproducto,
                    'cantidad' => $cantidad,
                    'marcabaja' => 0,
                    'fecharegistro' => date("d-m-Y")
                ]);
            $reference = $database->getReference('erp/detalleventa/' . $newPost->getKey() . '/' . $product->getKey());
            $reference->update(['id' => $product->getKey()]);
        }
        return redirect()->route('venta.index')->with('success', 'Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $database = $this->firebase->getDatabase();

        $venta = $database->getReference('erp/venta/' . $id)->getValue();
        $detalleventa = $database->getReference('erp/detalleventa/' . $id)->getValue();
        return view('venta.show',with(['venta'=>$venta,'detalleventa'=>$detalleventa]));
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

        $venta = $database->getReference('erp/venta/' . $id)->getValue();
        $detalleventa = $database->getReference('erp/detalleventa/' . $id)->getValue();
        return view('venta.edit',with(['venta'=>$venta,'detalleventa'=>$detalleventa]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, ['nombre' => 'required',
            'resumen' => 'required',
            'npagina' => 'required',
            'edicion' => 'required',
            'autor' => 'required',
            'precio' => 'required']);

        $nombre = $request->input('nombre');
        $resumen = $request->input('resumen');
        $npagina = $request->input('npagina');
        $edicion = $request->input('edicion');
        $autor = $request->input('autor');
        $precio = $request->input('precio');

        $database = $this->firebase->getDatabase();

        $reference = $database->getReference('erp/venta/' . $id);
        $reference->update(['nombre' => $nombre,
            'resumen' => $resumen,
            'npagina' => $npagina,
            'edicion' => $edicion,
            'autor' => $autor,
            'precio' => $precio]);
        return redirect()->route('Venta.index')->with('success', 'Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { //to make controller, model and migration -> artisan make:model --migration --controller test

        $database = $this->firebase->getDatabase();

        $database->getReference('erp/venta/' . $id)->remove();
        return redirect()->route('venta.index')->with('success', 'Registro eliminado satisfactoriamente');
    }
}
