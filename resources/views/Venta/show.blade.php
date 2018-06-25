@extends('layouts.layout')
@section('content')
    <div class="row">
        <section class="content">
            <div class="col-md-8 col-md-offset-2">
                @if(Session::has('success'))
                    <div class="alert alert-info">
                        {{Session::get('success')}}
                    </div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Ver Venta</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-container">
                            <form method="POST" role="form">
                                {{ csrf_field() }}
                                <input name="_method" type="hidden"
                                       value="PATCH">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text"
                                                   name="nombre" id="nombre" class="form-control input-sm"
                                                   value="{{$venta['nombre']}}">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text"
                                                   name="sucursal" id="sucursal" class="form-control input-sm"
                                                   placeholder="Sucursal" value="{{$venta['sucursal']}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text"
                                                   name="cinit" id="cinit" class="form-control input-sm"
                                                   placeholder="CI/NIT"
                                                   value="{{$venta['cinit']}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="table-container">
                                            <table class="table table-bordred table-striped">
                                                <thead>
                                                <th>#</th>
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                                </thead>
                                                <tbody id="tbody">
                                                    @if(isset($detalleventa))
                                                        @foreach($detalleventa as $detalle)
                                                            <tr>
                                                                <td></td>
                                                                <td>{{$detalle['nombreproducto']}}</td>
                                                                <td>{{$detalle['cantidad']}}</td>
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
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <a href="{{ route('venta.index')}}" class="btn btn-info btn-block">Atrás</a>
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
    {{--<script>--}}
    {{--var i = 0,--}}
    {{--arr = [];--}}

    {{--function addTel() {--}}
    {{--i++;--}}
    {{--$('#tbody').append('<tr><td>' + i + '</td><td>' + $('#telefono').val() + '</td></tr>');--}}
    {{--arr.push($('#telefono').val());--}}
    {{--$('#tel').val(JSON.stringify(arr));--}}
    {{--$('#telefono').val('');--}}
    {{--}--}}

    {{--var listaTelefonos = {!! json_encode($telefonos) !!}--}}
    {{--console.log(listaTelefonos);--}}
    {{--showTelefono(listaTelefonos);--}}

    {{--function deletePhone(id) {--}}
    {{--var x = confirm("Are you sure you want to delete?");--}}
    {{--if (x) {--}}
    {{--console.log('yes ' + id);--}}
    {{--eliminar(id);--}}

    {{--} else {--}}
    {{--console.log('nop ' + id);--}}
    {{--}--}}
    {{--showTelefono();--}}
    {{--}--}}

    {{--function showTelefono() {--}}
    {{--listaTelefonos.forEach(function (value) {--}}
    {{--if (value.marcabaja == 0) {--}}
    {{--$('#tbody').append('<tr><td>' + value.id + '</td><td>' + value.descripcion + '</td><td>' + '<a class="btn btn-danger btn-xs" onclick="deletePhone(' + value.id + ');"<span class="glyphicon glyphicon-trash">Eliminar</span></a>' + '</td></tr>');--}}
    {{--}--}}
    {{--});--}}
    {{--}--}}

    {{--function eliminar(id) {--}}
    {{--listaTelefonos.forEach(function (value) {--}}
    {{--if (value.id == id) {--}}
    {{--value.marcabaja = 1;--}}
    {{--}--}}
    {{--});--}}
    {{--console.log(listaTelefonos);--}}
    {{--$('#tbody').children().remove();--}}

    {{--}--}}
    {{--</script>--}}
@endpush