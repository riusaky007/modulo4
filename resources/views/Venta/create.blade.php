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
                        <h3 class="panel-title">Nueva Venta</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-container">
                            <form method="POST" action="{{ route('venta.store') }}"
                                  role="form">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text"
                                                   name="nombre" id="nombre" class="form-control input-sm"
                                                   placeholder="Nombre Cliente">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text"
                                                   name="sucursal" id="sucursal" class="form-control input-sm"
                                                   placeholder="Sucursal" value="Hipermaxi 4to Anillo Paragua">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text"
                                                   name="cinit" id="cinit" class="form-control input-sm"
                                                   placeholder="CI/NIT">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <select name="cboProducto" id="cboProducto" class="form-control"
                                                    onchange="getIdProduct(this)">
                                                <option value="0" selected="selected">Seleccionar</option>
                                                @if(isset($productos))
                                                    @foreach($productos as $producto)
                                                        <option value="{{$producto['id']}}"> {{$producto['nombre']}} </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <input id="idproduct" name="idproduct" type="text" hidden>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="cantidad" id="cantidad" class="form-control input-sm"
                                                   placeholder="Cantidad">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6"></div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <a name="action" onclick="addProducto()"
                                           class="btn btn-success btn-block">Add</a>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md12">
                                        <input id="listProducts" name="listProducts" type="text" hidden>
                                        <div class="table-container">
                                            <table id="tblProducto" name="tblProducto"
                                                   class="table table-bordred table-striped">
                                                <thead>
                                                <th>#</th>
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                                <th>Acciones</th>
                                                </thead>
                                                <tbody id="tbody">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md12">
                                        <input type="submit"
                                               value="Guardar" value="save" name="action"
                                               class="btn btn-success btn-block"
                                               onclick="return confirm('Are you sure?')">
                                        <a href="{{ route('cliente.index')}}" class="btn btn-info btn-block">Atrás</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <script>
            arr = [];
        function addProducto() {
            var k = 0;
            var obj = new Object();
            obj.id = $("#cboProducto option:selected").val();
            obj.nombre = $("#cboProducto option:selected").text();
            obj.cantidad = $('#cantidad').val();
            var sw = false;
            arr.forEach(function (value) {
                if (arr[k]['id'] == $("#cboProducto option:selected").val()) {
                    arr[k]['cantidad'] = (parseInt(arr[k]['cantidad']) + parseInt($('#cantidad').val())) + '';
                    sw = true;
                }
                k++;
            });
            if(!sw){
                arr.push(obj);
            }
            refreshTable();

            $('#listProducts').val(JSON.stringify(arr));
            $('#cantidad').val('');
             console.log('ListProducto =>' + $('#listProducts').val());
        }

        function getIdProduct(sel) {
            // var id = sel.value;
            // console.log($( "#cboProducto option:selected" ).text());
            //
            // console.log(id);
        }

        function deleteProduct(id) {
            var x = confirm("Are you sure you want to delete?");
            if (x) {
                console.log('yes ' + id);
                arr.splice(parseInt(id)-1,1);
                refreshTable();
            } else {
                console.log('nop ' + id);
            }
            $('#listProducts').val(JSON.stringify(arr));
            console.log('ListProducto =>' + $('#listProducts').val());
        }
        function refreshTable(){
            $('#tbody').children().remove();
            var k = 1;
            arr.forEach(function (value) {
                $('#tbody').append('<tr><td>' + k + '</td><td>' + value.nombre + '</td><td>' + value.cantidad + '</td><td>' + '<a class="btn btn-danger btn-xs" onclick="deleteProduct(' + k + ');"<span class="glyphicon glyphicon-trash">Eliminar</span></a>' + '</td></tr>');
                k++;
            });
        }
    </script>
@endpush