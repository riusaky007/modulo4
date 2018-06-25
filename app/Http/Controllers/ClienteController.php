<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Telefono;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::orderBy('id', 'DESC')->paginate(3);
        return view('cliente.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Cliente.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nombre = $request->input('nombre');
        $apellido = $request->input('apellido');
        $direccion = $request->input('direccion');
        $telefonos = $request->input('tel');
        $telefonos = json_decode($telefonos);
        try {
            DB::beginTransaction();
            $cliente = Cliente::create(['nombre' => $nombre,
                'apellido' => $apellido,
                'direccion' => $direccion,
                'marcabaja' => false]);

            foreach ($telefonos as $telefono) {
                Telefono::create(['idcliente' => $cliente->id,
                    'idtipotelefono' => 1,
                    'descripcion' => $telefono,
                    'marcabaja'=>false]);
            }
            DB::commit();//atl+command+L to format text
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
        return redirect()->route('cliente.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente=Cliente::find($id);
        $telefonos=DB::table('telefonos')->where('idcliente', '=', $id)->get();
        return view('cliente.edit')->with(['cliente'=>$cliente,'telefonos'=>$telefonos]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public static function addToTable(Request $request)
    {
        $telefono = $request->get('telefono');
        response()->json('correcto');

    }
}
