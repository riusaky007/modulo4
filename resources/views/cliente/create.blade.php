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
                        <h3 class="panel-title">Nuevo Cliente</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-container">
                            <form method="POST" action="{{ route('cliente.store') }}"
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
                                    <div class="col-xs-6 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <input type="text"
                                                   name="apellido" id="apellido" class="form-control input-sm"
                                                   placeholder="Apellidos">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <textarea name="direccion" id="direccion" class="formcontrol
                                            input-sm" placeholder="Direccion"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <input type="text" id="telefono" class="form-control input-sm"
                                                   placeholder="Telefono">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-2 col-md-2">
                                        <a name="action" onclick="addTel()"
                                           class="btn btn-success btn-block">AddTel</a>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md12">
                                            <input id="tel" name="tel" type="text" hidden>
                                            <div class="table-container">
                                                <table id="tblTelefonoCliente" name="tblTelefonoCliente"
                                                       class="table table-bordred table-striped">
                                                    <thead>
                                                    <th>#</th>
                                                    <th>Telefono</th>
                                                    </thead>
                                                    <tbody id="tbody">
                                                    </tbody>
                                                </table>
                                            </div>
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
        var i = 0,
            arr = [];

        function addTel() {
            {{--$.post("{{route('addToTable')}}", {'_token': "{{csrf_token()}}",'telefono' : $('#telefono').val() }).done(function(res) {--}}
                    {{--alert( "second success" + res);--}}
                    {{--});--}}
                i++;
            $('#tbody').append('<tr><td>' + i + '</td><td>' + $('#telefono').val() + '</td></tr>');
            arr.push($('#telefono').val());
            $('#tel').val(JSON.stringify(arr));
            $('#telefono').val('');
        }

        // console.log('lol xD');
    </script>
@endpush