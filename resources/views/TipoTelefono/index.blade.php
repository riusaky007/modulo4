@extends('layouts.layout')
@section('content')
    <div class="row">
        <section class="content">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="pull-left"><h3>Lista Tipo Telefono</h3></div>
                        <div class="pull-right">
                            <div class="btn-group">
                                <a href="{{ route('producto.create') }}" class="btn btn-info" >Añadir Tipo Telefono</a>
                            </div>
                        </div>
                        <div class="table-container">
                            <table id="mytable" class="table table-bordred table-striped">
                                <thead>
                                {{--<th>#</th>--}}
                                <th>Tipo Telefono</th>
                                <th>Descripcion</th>
                                <th>Acciones</th>
                                <th></th>
                                </thead>
                                <tbody>
                                @if(!empty($productos))
                                    @foreach($productos as $producto)
                                        <tr>
                                            {{--<td>{{$producto['id']}}</td>--}}
                                            <td>{{$producto['nombre']}}</td>
                                            <td>{{$producto['precio']}}</td>
                                            <td><a class="btn btn-primary btn-xs" href="{{action('ProductoController@edit', $producto['id'])}}" ><span class="glyphicon glyphicon-pencil"></span></a></td>
                                            <td>
                                                <form action="{{action('ProductoController@destroy', $producto['id'])}}" method="post">
                                                    {{csrf_field()}}
                                                    <input name="_method" type="hidden" value="DELETE"></form>
                                                    <button class="btn btn-danger btn-xs" type="submit"><span class="glyphicon glyphicon-trash"></span></button>
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
                    {{--{{ $libros->links() }}--}}
                </div>
            </div>
        </section>
@endsection