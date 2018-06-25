@extends('layouts.layout')
@section('content')
    <div class="row">
        <section class="content">
            <div class="col-md-8 col-md-offset-2">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Error!</strong> Revise los campos obligatorios.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(Session::has('success'))
                    <div class="alert alert-info">
                        {{Session::get('success')}}
                    </div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Editar Cliente</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-container">
                            <form method="POST" action="{{ route('cliente.update',$cliente->id) }}" role="form">
                                {{ csrf_field() }}
                                <input name="_method" type="hidden"
                                       value="PATCH">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text"
                                                   name="nombre" id="nombre" class="form-control input-sm"
                                                   value="{{$cliente->nombre}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text"
                                                   name="apellido" id="apellido" class="form-control input-sm"
                                                   value="{{$cliente->apellido}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="direccion" class="formcontrol input-sm" placeholder="Direccion">{{$cliente->direccion}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <input id="tel" name="tel" type="text" hidden>
                                        <div class="table-container">
                                            <table id="tblTelefonoCliente" name="tblTelefonoCliente"
                                                   class="table table-bordred table-striped">
                                                <thead>
                                                <th>#</th>
                                                <th>Telefono</th>
                                                <th>Acciones</th>
                                                </thead>
                                                <tbody id="tbody">
                                                {{--@if(isset($telefonos))--}}
                                                {{--@if($telefonos->count())--}}
                                                {{--@foreach($telefonos as $telefono)--}}
                                                {{--<tr>--}}
                                                {{--<td>{{$telefono->id}}</td>--}}
                                                {{--<td>{{$telefono->descripcion}}</td>--}}
                                                {{--<td>--}}
                                                {{--<form action="{{action('ClienteController@destroy', $telefono->id)}}"--}}
                                                {{--method="post">--}}
                                                {{--{{csrf_field()}}--}}
                                                {{--<button class="btn btn-danger btn-xs"--}}
                                                {{--type="submit"--}}
                                                {{--onclick="return confirm('Are you sure?')">--}}
                                                {{--<span class="glyphicon glyphicon-trash"></span>--}}
                                                {{--</button>--}}
                                                {{--</form>--}}
                                                {{--</td>--}}
                                                {{--</tr>--}}
                                                {{--@endforeach--}}
                                                {{--@else--}}
                                                {{--<tr>--}}
                                                {{--<td colspan="8">No hay registro !!</td>--}}
                                                {{--</tr>--}}
                                                {{--@endif--}}
                                                {{--@endif--}}

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <input type="submit"
                                               value="Actualizar" class="btn btn-success btn-block"
                                               onclick="return confirm('Are you sure?')">
                                        <a href="{{ route('cliente.index')
}}" class="btn btn-info btn-block">Atrás</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endsection
        @push('scripts')
            <script>
                var i=0,
                    arr=[];

                function addTel() {
                    i++;
                    $('#tbody').append('<tr><td>'+i+'</td><td>'+$('#telefono').val()+'</td></tr>');
                    arr.push($('#telefono').val());
                    $('#tel').val(JSON.stringify(arr));
                    $('#telefono').val('');
                }
                var listaTelefonos = {!! json_encode($telefonos) !!}
                console.log(listaTelefonos);
                showTelefono(listaTelefonos);
                function deletePhone(id) {
                    var x = confirm("Are you sure you want to delete?");
                    if (x) {
                        console.log('yes ' + id);
                        eliminar(id);

                    } else {
                        console.log('nop ' + id);
                    }
                    showTelefono();
                }
                function showTelefono(){
                    listaTelefonos.forEach(function(value){
                        if(value.marcabaja == 0){
                            $('#tbody').append('<tr><td>'+value.id+'</td><td>'+value.descripcion+'</td><td>'+'<a class="btn btn-danger btn-xs" onclick="deletePhone('+value.id+');"<span class="glyphicon glyphicon-trash">Eliminar</span></a>'+'</td></tr>');
                        }
                    });
                }
                function eliminar(id){
                    listaTelefonos.forEach(function(value){
                        if(value.id == id){
                            value.marcabaja = 1;
                        }
                    });
                    console.log(listaTelefonos);
                    $('#tbody').children().remove();

                }
            </script>
    @endpush