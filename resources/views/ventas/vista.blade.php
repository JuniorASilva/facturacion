@extends('body/body')
@section('content')
	<main class="main-content p-5" role="main">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                	<div class="card-header">
                        <h3>Comprobante <b>{{ $comprobante->num_serie.'-'.$comprobante->num_documento }}</b></h3>
                	</div>
                    <div class="card-body">
                        <div class="form-horizontal">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <label>Cliente</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="cliente" id="cliente" placeholder="Busque por DNI o Apellidos">
                                        <input type="hidden" name="id_cliente" id="id_cliente" value="0">
                                        <div class="input-group-append">
                                            <button type="button" id="nuevo_cliente" class="btn btn-success" title="Nuevo Cliente" data-toggle="tooltip"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label>Tipo Documento</label>
                                    <select class="form-control" name="tipo_doc" id="tipo_doc">
                                        <option value="03">Boleta</option>
                                        <option value="01">Factura</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label>Fecha</label>
                                    <input type="text" name="fecha" class="form-control datepicker" value="{{ date('d/m/Y') }}">
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 ">
                                    <label>&nbsp;</label><br>
                                    <button type="button" id="agregaItem" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Item</button>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="table">
                                        <table class="table tabla-items display table-striped table-bordered table-hover center" id="tabla-items">
                                            <thead>
                                                <tr>
                                                    <th class="center">#</th>
                                                    <th class="center">Producto</th>
                                                    <th class="center">Precio</th>
                                                    <th class="center">Cantidad</th>
                                                    <th class="center">Impuesto</th>
                                                    <th class="center">Total</th>
                                                    <th class="center">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($items as $item)
                                                    <tr>
                                                        <td>{{ substr($item['id'],0,5) }}</td>
                                                        <td>{{ $item['name'] }}</td>
                                                        <td>{{ $item['price'] }}</td>
                                                        <td>{{ $item['quantity'] }}</td>
                                                        <td>{{ $item['attributes']['tipo_igv']==1? number_format($item['price']*$item['quantity']*0.18,2,'.',''):0.00 }}
                                                        </td>
                                                        <td>{{ $item['price'] *$item['quantity']}}</td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button class="btn btn-danger eliminar" type="button" data-id="{{ $item['id'] }}" title="Eliminar"><i class="fa fa-trash"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <span>Op. Gravada</span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <label>S/</label><label>0.00</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <span>Op. Inafecta</span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <label>S/</label><label>0.00</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <span>Op. Exonerada</span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <label>S/</label><label>0.00</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <span>I.G.V.</span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <label>S/</label><label>0.00</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <span>Total</span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <label>S/</label><label>0.00</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Moneda</label>
                                        <select class="form-control" name="id_moneda">
                                            <option value="1">Soles</option>
                                            <option value="2">Dolares</option>
                                            <option value="3">Euros</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection