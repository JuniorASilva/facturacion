@extends('body.body')

@section('contenido')
    <main class="main-content p-5" role="main">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table id="table-usuarios" class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombres</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $key => $usuario)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$usuario->nombres}}</td>
                                        <td>{{$usuario->usuario}}</td>
                                        @switch($usuario->estado)
                                            @case(0)
                                                <td>Deshabilitado</td>
                                                @break
                                            @case(1)
                                                <td>Habilitado</td>
                                                @break
                                            @case(2)
                                                <td>Designado</td>
                                                @break
                                            @default
                                                <td>Por definir<td>
                                                @break
                                        @endswitch
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-outline-success" href="{{ route('editar-usuario', ['id' => $usuario->id]) }}" title="Editar"><i class="fa fa-edit"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="row">
                            <a class="btn btn-outline-primary" href="{{ route('nuevo-usuario') }}">
                                Nuevo usuario
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script type="text/javascript">
        $(function () {
            $('#table-usuarios').DataTable({
                "pageLength": 15,
                "language": {
                    "paginate": {
                        "first": "Primera página",
                        "last": "Ultima página",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "infoEmpty": "Observando 0 de 0 registros",
                    "info": "Observando pagina _PAGE_ de _PAGE_",
                    "lengthMenu": "Desplegando _MENU_ registros",
                    "sSearch": "Buscador"
                },
                "columns": [
                    {"width": "10%"},
                    {"width": "40%"},
                    {"width": "15%"},
                    {"width": "15%"},
                    {"width": "20%"}
                ],
                "lengthMenu": [
                    [-1, 10, 15, 20, 30],
                    ["All", 10, 15, 20, 30]
                ]
            })
        })
    </script>
@endsection