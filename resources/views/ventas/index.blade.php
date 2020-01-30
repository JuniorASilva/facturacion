@extends('body/body')

@section('content')
    <main class="main-content p-5" role="main">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Lista de ventas</h3>
                    </div>
                    <div class="card-body">
                        <table id="table-ventas" class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Comprobante</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="btn-group">
                            <a href="{{ route('nueva-venta') }}" class="btn btn-primary" title="Emitir Comprobante">
                                <i class="fa fa-money"></i> Emitir
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script type="text/javascript">
        $(function () {
            let t_ventas = $('#table-ventas').dataTable({
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
