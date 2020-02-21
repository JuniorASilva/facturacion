@extends('body/body')
@section('content')
    <main class="main-content p-5" role="main">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-12 pb-5">
<<<<<<< HEAD
                            <h2>{{ isset($usuario) ? 'Actualización de ' : 'Registro de '}} usuario</h2>
                        </div>
                        @if(session()->get('message_signup'))
							<div class="alert alert-warning alert-dismissible fade show" role="alert">
								{{ session()->get('message_signup') }}
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						@endif
                        <form method="POST" id="registro-usuario">
                            @csrf
=======
                            <h2>{{ isset($usuario) ? 'Actualizacion de ' : 'Registro de ' }}Usuario</h2>
                        </div>
                        <form method="post" id="registro-usuario">
>>>>>>> 9ff5112d938b8b0bfc2246d6e3d822416a89b804
                            <div class="form-group row">
                                <label for="nombres" class="col-sm-2 col-form-label">Nombres</label>
                                <div class="col-sm-4">
<<<<<<< HEAD
                                    <input type="text" class="form-control" id="nombres" required name="nombres" placeholder="nombres" value="<?= !isset($usuario) ? '' : $usuario->nombres ?>">
=======
                                    <input type="text" class="form-control" id="nombres" required name="nombres" placeholder="Nombres" value="<?= !isset($usuario) ? '' : $usuario->nombres ?>">
>>>>>>> 9ff5112d938b8b0bfc2246d6e3d822416a89b804
                                </div>
                                <label for="apellidos" class="col-sm-2 col-form-label">Apellidos</label>
                                <div class="col-sm-4">
<<<<<<< HEAD
                                    <input type="text" class="form-control" id="apellidos" required name="apellidos" placeholder="apellidos" value="<?= !isset($usuario) ? '' : $usuario->apellidos ?>">
=======
                                    <input type="text" class="form-control" id="apellidos" required name="apellidos" placeholder="Apellidos" value="<?= !isset($usuario) ? '' : $usuario->apellidos ?>">
>>>>>>> 9ff5112d938b8b0bfc2246d6e3d822416a89b804
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="usuario" class="col-sm-2 col-form-label">Usuario*</label>
                                <div class="col-sm-4">
<<<<<<< HEAD
                                    <input type="text" class="form-control" id="usuario" required name="usuario" placeholder="Usuario" value="<?= !isset($usuario) ? '' : $usuario->apellidos ?>">
=======
                                    <input type="text" class="form-control" id="usuario" required name="usuario" placeholder="Usuario" value="<?= !isset($usuario) ? '' : $usuario->usuario ?>">
>>>>>>> 9ff5112d938b8b0bfc2246d6e3d822416a89b804
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pass" class="col-sm-2 col-form-label">Contraseña*</label>
                                <div class="col-sm-4">
<<<<<<< HEAD
                                    <input type="password" class="form-control" id="pass" <?= !isset($usuario) ? 'required' : '' ?> name="pass" placeholder="Contraseña">
                                </div>
                                <label for="repeat-pass" class="col-sm-2 col-form-label">Repetir Contraseña*</label>
                                <div class="col-sm-4">
                                    <input type="password" class="form-control" id="repeat-pass" <?= !isset($usuario) ? 'required' : '' ?> name="repeat-pass" placeholder="Repetir Contraseña">
=======
                                    <input type="password" class="form-control" id="pass" <?= isset($usuario) ? '' : 'required' ?> name="pass" placeholder="Contraseña">
                                </div>
                                <label for="repeat-pass" class="col-sm-2 col-form-label">Repetir Contraseña*</label>
                                <div class="col-sm-4">
                                    <input type="password" class="form-control" id="repeat-pass" <?= isset($usuario) ? '' : 'required' ?> name="repeat-pass" placeholder="Repetir Contraseña">
>>>>>>> 9ff5112d938b8b0bfc2246d6e3d822416a89b804
                                </div>
                            </div>
                            <fieldset class="form-group">
                                <div class="row">
                                    <legend class="col-form-label col-sm-2 pt-0">Roles</legend>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="roles" required name="roles">
                                            @foreach ($roles as $rol)
<<<<<<< HEAD
                                                <option value="{{ $rol->id }}" {{ (isset($usuario) && ($rol->id == $usuario->rol_id)) ? '' : 'selected' }}> {{ $rol->nombre }}</option>
=======
                                                <option value="{{ $rol->id }}" {{ isset($usuario) && $usuario->id_rol == $rol->id ? '' : 'selected' }}> {{ $rol->nombre }}</option>
>>>>>>> 9ff5112d938b8b0bfc2246d6e3d822416a89b804
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-group row">
<<<<<<< HEAD
                                <div class="col-sm-10">
                                    <button type="submit" id="registrar" class="btn btn-primary">Registrar</button>
                                    <a href=javascript:history.back(1) class="btn btn-danger"><i class="fa fa-arrow-circle-left"></i> Volver</a>
=======
                                <div class="col-sm-10 btn-group">
                                    <a href=javascript:history.back(1) class="btn btn-danger"><i class="fa fa-arrow-circle-left"></i> Volver</a>
                                    <button type="submit" id="registrar" class="btn btn-primary">{{ isset($usuario) ? 'Actualizar' :  'Registrar' }}</button>
>>>>>>> 9ff5112d938b8b0bfc2246d6e3d822416a89b804
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script type="text/javascript">
        $(function(){
<<<<<<< HEAD
            $('#registro-usuario').on('submit', function(event){
                event.preventDefault();
                //toastr.error('Error al tratar de registrar usuario');
                $.confirm({
                    content: function(){
                        let self = this;
                        return $.ajax({
                            url: "{{ isset($usuario) ? route('editar-usuario', ['id' => $usuario->id]) : route('nuevo-usuario') }}",
=======
            $('#registro-usuario').on('submit',function(event){
                event.preventDefault()
                //toastr.error('Este es un mensaje de prueba')
                $.confirm({
                    content: function(){
                        var self = this
                        return $.ajax({
                            url: "{{ isset($usuario) ? route('editar-usuario',['id'=> $usuario->id]) : route('nuevo-usuario') }}",
>>>>>>> 9ff5112d938b8b0bfc2246d6e3d822416a89b804
                            method: 'POST',
                            dataType: 'JSON',
                            data: $('#registro-usuario').serialize()
                        }).done(function(response){
<<<<<<< HEAD
                            self.close();
                            toastr.success(response.message);
                            setTimeout(function(){
                                window.location.href = '{{ route("usuarios") }}';
                            },3000);
                        }).fail(function(){
                            self.close();
                            toastr.error('Error, consulte con su administrador');
                        });
                    }
                });
               
            });
            $('#usuario').on('blur',function(){
                if($('#usuario').val() == '')
                    return false;
=======
                            self.close()
                            toastr.success(response.message)
                            setTimeout(function(){
                                window.location.href='{{ route("usuarios") }}'
                            },3000)
                        }).fail(function(){
                            self.close()
                            toastr.error('Error, consulte con su administrador')
                        })
                    }
                })
            })
            $('#usuario').on('blur', function () {
                if ($('#usuario').val() == '')
                    return false

>>>>>>> 9ff5112d938b8b0bfc2246d6e3d822416a89b804
                $.ajax({
                    url: "{{ route('consulta-usuario') }}",
                    method: 'POST',
                    dataType: 'JSON ',
                    data: {
<<<<<<< HEAD
                        usuario: $('#usuario').val(),
                        id: {{ isset($usuario) ? $usuario->id : 0 }},
                        _token: '{{ csrf_token() }}'
                    }
                }).done(function(response){
                    if(response.status == 202){
                        $('#registrar').attr('disabled','disabled');
                        $('#usuario').addClass('border-danger').removeClass('border-success');
                        toastr.error(response.message);
                    }else{
                        $('#registrar').removeAttr('disabled');
                        $('#usuario').addClass('border-success').removeClass('border-danger');
                        toastr.success(response.message);
                        setTimeout(()=>{
                            $('#usuario').removeClass('border-success');
                        }, 3000);
                    }
                }).fail(function(error){
                    console.log(error)
                });
            });
        });
=======
                        usuario: $("#usuario").val(),
                        id: {{ isset($usuario) ? $usuario->id : 0 }},
                        _token: '{{ csrf_token() }}'
                    }
                })
                    .done(function (response) {
                        if (response.status == 202) {
                            $('#registrar').attr('disabled', 'disabled')
                            $('#usuario').addClass('border-danger').removeClass('border-success')
                            toastr.error(response.message)
                        } else {
                            $('#registrar').removeAttr('disabled')
                            $('#usuario').addClass('border-success').removeClass('border-danger')
                            toastr.success(response.message)
                            setTimeout(() => {
                                $('#usuario').removeClass('border-success')
                            }, 3000)
                        }

                        console.log(response)
                    })
                    .fail(function (error) {
                        console.log(error)
                    })
            })
        })
>>>>>>> 9ff5112d938b8b0bfc2246d6e3d822416a89b804
    </script>
    <!--
        terminar el registro del usuario
        agregarle 3 segundos de espera de color verde
    -->
@endsection
