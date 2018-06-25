@extends('layouts.layout')
@section('content')
    <div class="row">
        <section class="content">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="pull-left"><h3>Lista Clientes</h3></div>
                        <div class="pull-right">
                            <div class="btn-group">
                                <a href="{{ route('cliente.create') }}" class="btn btn-info" id="submitUser" >Añadir Cliente</a>
                            </div>
                        </div>
                        <div class="table-container">
                            <table id="mytable" class="table table-bordred table-striped">
                                <thead>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Direccion</th>
                                <th>Acciones</th>
                                <th></th>
                                </thead>
                                <tbody>
                                @if($clientes->count())
                                    @foreach($clientes as $cliente)
                                        <tr>
                                            <td>{{$cliente->id}}</td>
                                            <td>{{$cliente->nombre}}</td>
                                            <td>{{$cliente->apellido}}</td>
                                            <td>{{$cliente->direccion}}</td>
                                            <td><a class="btn btn-primary btn-xs" href="{{action('ClienteController@edit', $cliente->id)}}" ><span class="glyphicon
glyphicon-pencil"></span></a></td>
                                            <td>
                                                <form action="{{action('ClienteController@destroy', $cliente->id)}}" method="post">
                                                    {{csrf_field()}}
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button class="btn btn-danger btn-xs" type="submit" onclick="return confirm('Are you sure?')"><span class="glyphicon glyphicon-trash"></span></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8">No hay registro !!</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $clientes->links() }}
                </div>
            </div>
        </section>
    </div>
@endsection

