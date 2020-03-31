@extends('body/body')
@section('content')
	<main class="main-content p-5" role="main">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                	<div class="card-header">
                		<h3>Nueva Venta</h3>
                    </div>
                    <form method="POST" action="{{ route('generaventa') }}">
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
                                            <table class="table display table-striped table-bordered table-hover center" id="tabla-items">
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
                                                            <td>{{ $item['attributes']['tipo_igv'] == 1 ? number_format($item['price']*$item['quantity']*0.18,2,'.','') : 0.0 }}</td>
                                                            <td>{{ $item['price']*$item['quantity'] }}</td>
                                                            <td>
                                                                <div class="btn-group">
													                <button class="btn btn-danger eliminar" type="button" data-id="${d.id}" title="Eliminar">
														                <i class="fa fa-trash"></i>
													                </button>
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
                                            <select class="form-control">
                                                <option value="PEN">Soles</option>
                                                <option value="DLR">Dolares</option>
                                                <option value="EUR">Euros</option>
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
                    </form>
                </div>
            </div>
        </div>
    </main>
   	<script type="text/javascript">

       $(document).on("focus",'.datepicker', function(){
		   $(this).datepicker()
	   })
   		$(function(){
            var cargaFuncionalidades = function(){
				$('.tabla-items tbody tr button.eliminar').unbind('click')
				$('.tabla-items tbody tr button.eliminar').on('click',function(){
					var row = $(this).closest("tr").get(0)
					var idItem = $(this).attr('data-id')
					$.confirm({
						title: 'Atención',
						content: 'Esta seguro de eliminar este Item?',
						buttons: {
							si: {
								text: 'Si',
								btnClass: 'btn-primary',
								action: function(){
									$.confirm({
										title: 'Resultado',
										content: function(){
											var self = this
											return $.ajax({
												url: '{{ route("quitaItem") }}',
												method: 'DELETE',
												dataType: 'json',
												data: {
													idItem: idItem,
													_token: '{{ csrf_token() }}'
												}
											}).done(function(response){
												if(response.status == 200){
													toastr.success(response.message)
													tabla_items.fnDeleteRow(tabla_items.fnGetPosition(row))
												}
												else
													toastr.error(reponse.message)
												self.close()
											}).fail(function(){
												toastr.error('Error, consulte con su administrador')
												self.close()
											})
										}
									})
								}
							},
							no: function(){}
						}
					})
				})
			}
			cargaFuncionalidades()
   			$('.datepicker').datepicker()
			$('#tipo_doc').on('click',function(){
				if($(this).val() == '03'){
					$('#cliente').attr('placeholder','Busque por DNI o Apellidos')
				}else{
					$('#cliente').attr('placeholder','Busque por RUC o Razon social')
				}
			})
   			var tabla_items = $('#tabla-items').dataTable({
    			"lengthMenu": [[-1,10,15,20,30],["All",10,15,20,30]],
                /*"columns": [
                    {"width": "10%"},
                    {"width": "40%"},
                    {"width": "15%"},
                    {"width": "15%"},
                    {"width": "20%"},
                ],*/
                "pageLength": 15,
                "language": {
                    "paginate": {
                        "first": "Primera página",
                        "last": "Ultima página",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "infoEmpty": "Observando 0 a 0 de 0 registros",
                    "info": "Observando página _PAGE_ de _PAGE_",
                    "lengthMenu": "Desplegando _MENU_ registros",
                    "sSearch": "Buscador"
                }
    		})
    		//Evento para agregar un nuevo cliente
    		$('#nuevo_cliente').on('click',function(){
				if($('#tipo_doc').val() == '03'){
					$.confirm({
						title: 'Agrega Cliente',
						columnClass: 'col-lg-8 col-md-8 col-sm-8',
						content: function(){
							var self = this
							return $.ajax({
								url: '{{ route("util-documento") }}',
								dataType: 'JSON',
								method: 'POST',
								data: {
									_token: '{{ csrf_token() }}'
								}
							}).done(function(response){
								if(response.status == 200){
									console.log(response.data)
									let stringDocumentos = ''
									for(let i in response.data){
										stringDocumentos += '<option value="'+response.data[i].id+'">'+
										response.data[i].nombre+'</option>'
									}
									/* html */
									self.setContentAppend(`<form class="formulario-persona"><div class="row" style="margin-right: 0px; margin-left: 0px;">
											<div class="col-lg-6 col-md-6">
												<label>Nombres *</label>
												<input type="text" class="form-control" placeholder="Nombres" name="nombres" required>
											</div>
											<div class="col-lg-6 col-md-6">
												<label>Apellidos *</label>
												<input type="text" class="form-control" placeholder="Apellidos" name="apellidos" required>
											</div>
										</div>
										<div class="row" style="margin-right: 0px; margin-left: 0px;">
											<div class="col-lg-6 col-md-6">
												<label>Tipo Documento *</label>
												<select class="form-control" name="tipo_doc">${stringDocumentos}</select>
											</div>
											<div class="col-lg-6 col-md-6">
												<label>Número Documento *</label>
												<input type="text" class="form-control" placeholder="12345678" name="nro_doc" required>
											</div>
										</div>
										<div class="row" style="margin-right: 0px; margin-left: 0px;">
											<div class="col-lg-6 col-md-6">
												<label>Dirección</label>
												<input type="text" class="form-control" placeholder="Av. Dirección" name="direccion">
											</div>
											<div class="col-lg-6 col-md-6">
												<label>Fecha de Nacimiento</label>
												<input type="text" class="form-control datepicker" placeholder="{{ date('Y-m-d') }}" name="fch_nac">
											</div>
										</div>
										<div class="row" style="margin-right: 0px; margin-left: 0px;">
											<div class="col-lg-6 col-md-6">
												<label>Telefono</label>
												<input type="text" class="form-control" placeholder="987654321" name="telefono">
											</div>
											<div class="col-lg-6 col-md-6">
												<label>Genero</label>
												<select class="form-control">
													<option value="1">Masculino</option>
													<option value="2">Femenino</option>
													<option value="3">Otros</option>
												</select>
											</div>
											@csrf
										</div></form>`)
								}
								else{
									self.close()
									toastr.error(response.message)
								}
							}).fail(function(){
								self.close()
								toastr.error('Error, consulte con su administrador')
							})
						},
						contentLoaded: function(){},
						onContentReady: function(){
							$('.datepicker').datepicker({
								container: "body"
							})
						},
						buttons: {
							Guardar: {
								text: 'guardar',
								keys: ['enter'],
								action: function(){
									var self = this
									if(!$('.formulario-persona').valid()){
										toastr.error('Ingrese los datos correctos')
										return false
									}
									var formularioPersona = self.$content.find('.formulario-persona').serialize()
									$.confirm({
										title: 'Registrando',
										content: function(){
											var self2 = this
											return $.ajax({
												url: '{{ route("registro-cliente") }}',
												method: 'POST',
												dataType: 'JSON',
												data: formularioPersona
											}).done(function(response){
												if(response.status == 200){
													toastr.success(response.message)
													self2.close()
													self.close()
													$('#cliente').val(response.data.nro_doc+' - '+response.data.apellidos+' '+response.data.nombres)
													$('#id_cliente').val(response.data.id_persona)
												}else{
													toastr.error(response.message)
													self2.close()
													return false
												}
											}).fail(function(){
												self2.close()
												toastr.error('Error, consulte con su administrador.')
												return false
											})
										}
									})
									/*toastr.success('Bienvenido')*/
									return false
								}
							},
							Cancelar: function(){}
						}
					})
				}
				else{
					$.confirm({
                        title: 'Busqueda en SUNAT',
                        keys: ['enter'],
						/* html */
						content: `
						<form class="formulario-sunat" id="consulta-sunat">
							<div class="row"  style="margin-right: 0px; margin-left: 0px;">
								<div class="col-lg-12 col-md-12">
									<label>RUC</label>
									<input type="text" class="form-control ruc" placeholer="Ingrese numero de RUC" name="ruc" required>
								</div>
								@csrf
							</div>
						</form>
						`,
						buttons: {
							consultar: {
								text: 'Consultar',
								btnClass: 'btn-primary',
								keys: ['enter'],
								action: function(){
									var self = this
									if(self.$content.find('.ruc').val() == ''){
										toastr.error('Ingrese un ruc valido')
										return false
									}
									$.confirm({
                                        title: 'Resultado',
                                        columnClass: 'col-lg-10 col-md-10 col-sm-10',
										content: function(){
											var self2 = this
											return $.ajax({
												url: '{{ route("consulta-ruc") }}',
												method: 'POST',
												dataType: 'JSON',
												//data: self.$content.find('.formulario-sunat').serialize(),
												data: $('#consulta-sunat').serialize()
											}).done(function(response){
												if(response.status != 200){
                                                    toastr.error(response.message)
                                                    self2.close()
                                                    return false
                                                }else{
                                                    var d = response.data
                                                    //html
                                                    self2.setContentAppend(
                                                        `
                                                        <div class="content">
                                                            <div class="row">
                                                                <div class="col-lg-4 col-md-4">
                                                                    <label>RUC</label>
                                                                </div>
                                                                <div class="col-lg-8 col-md-8">
                                                                    <label>${d.ruc}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-4 col-md-4">
                                                                    <label>Razón Social</label>
                                                                </div>
                                                                <div class="col-lg-8 col-md-8">
                                                                    <label>${d.razon_social}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-4 col-md-4">
                                                                    <label>Nombre Comercial</label>
                                                                </div>
                                                                <div class="col-lg-8 col-md-8">
                                                                    <label>${d.nombre_comercial}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-4 col-md-4">
                                                                    <label>Dirección</label>
                                                                </div>
                                                                <div class="col-lg-8 col-md-8">
                                                                    <label>${d.direccion}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        `
                                                    )
                                                }
											}).fail(function(error){
												console.log(error)
												toastr.error('Error, consulte con su administrador')
												self2.close()
											})
                                        },
                                        buttons: {
                                            ok:function(){}
                                        }
									})
									/*toastr.success('Consultando')
									return false*/
								}
							},
							cancelar: function(){}
						}
					})
				}
    		})
            var autoCompletadoCliente = function(){
                $('#cliente').autocomplete({
				serviceUrl: '{{ route("autocomplete-cliente") }}',
				minChars: 3,
				dataType: 'JSON',
				type: 'POST',
				paramName: 'cliente',
				params: {
					cliente: $('#cliente').val(),
                    cod_doc: $('#tipo_doc').val(),
					_token: '{{ csrf_token() }}'
				},
				onSelect: function(suggestion){
					$('#id_cliente').val(suggestion.data.id_cliente)
				}
			    })
            }
            autoCompletadoCliente()
            $('#tipo_doc').on('change',function(){
                $('#cliente').unbind('autocomplete')
                autoCompletadoCliente()
            })
            $('#agregaItem').on('click',function(){
                $.confirm({
                    title: 'Nuevo Item',
                    columnClass: 'col-md-10 col-lg-10 col-sm-10',
                    /*html*/
                    content:
                    `
                    <form>
                    <div class="row" style="width: 100%;">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <label>Descripción</label>
                            <textarea class="form-control" rows="10" id="descripcion" name="descripcion" required></textarea>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <label>Cantidad</label>
                                    <input class="form-control" id="cantidad" type="number" name="cantidad" value="1" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <label>Precio</label>
                                    <input class="form-control" id="precio1" type="number" name="precio" step="0.01" value="0.000" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <label>Tipo</label>
                                    <select class="form-control" id="tipoitem" name="tipoitem">
                                        <option value="1">Bien</option>
                                        <option value="0">Servicio</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <label>Descuento 0-100%</label>
                                    <input class="form-control" id="descuento2" name="descuento" placeholder="Ejm. 50%" type="number" value="0" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <label>IGV</label>
                                    <select class="form-control" id="igvs" name="igv">
                                        <option value="1">Gravado</option>
                                        <option value="2">Inafecto</option>
                                        <option value="3">Exonerado</option>
                                    </select>
                                </div>
                            </div>
                            @csrf
                            <br>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label>Subtotal: </label>
                                    <spam class="subtotal">0</spam>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label>IGV: </label>
                                    <spam class="igv">0</spam>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label>Total: </label>
                                    <spam class="total">0</spam>
                                </div>
                            </div>
                        </div>
                        </div>
                    </form>
                    `,
                    buttons: {
                        agregar: function(){
                            if(!this.$content.find('form').valid()){
                                toastr.error('Ingrese los datos correctamente')
                                return false
                            }
                            var formData = this.$content.find('form').serialize()
                            $.confirm({
                                title: 'Agregando',
                                content: function(){
                                    var self = this
                                    return $.ajax({
                                        url: '{{ route("agregaItem") }}',
                                        data: formData,
                                        method: 'POST',
                                        dataType: 'JSON'
                                    }).done(function(response){
                                        if(response.status == 200){
                                            var d = response.data
                                            tabla_items.fnAddData([
                                                d.id.substring(0,5),
                                                d.name,
                                                d.price,
                                                d.quantity,
                                                d.attributes.tipo_igv == "1" ? (parseFloat(d.price) * parseInt(d.quantity) * 0.18).toFixed(2) : 0.0,
                                                (parseFloat(d.price)*parseInt(d.quantity)),
                                                `<div class="btn-group">
                                                    <button class="btn btn-danger eliminar" type="button" data-id="${d.id}" title="Eliminar">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>`
                                            ])
                                        }
                                        console.log(response)
                                    }).fail(function(){
                                        toastr.error('Error consulte con su administrador')
                                        self.close()
                                    })
                                }
                            })
                        },
                        cancelar: function(){}
                    }
                })
            })
   		})
   	</script>
@endsection
