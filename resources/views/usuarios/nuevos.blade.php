@extends('body/body')
@section('contenido')
    <main class="main-content p-5" role="main">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div><h2>{{ isset($usuario)? 'Actualizacion de ' : 'Registro de '}}Usuario</h2></div>
                        <br>
                        @if (session()->get('message_insert'))
                        <div class="alert alert-primary alert-dismissible fade show">{{ session()->get('message_insert') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button></div>
                        @endif
                        <form method="post" id="registro-usuario">
                            <div class="form-group row">
                                <label for="nombres" class="col-sm-2 col-form-label">Nombres</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" required id="nombres" name="nombres" placeholder="Nombres" value="<?= !isset($usuario)? '' : $usuario->nombres?>">
                                </div>
                                <label for="apellidos" class="col-sm-2 col-form-label">Apellidos</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" required id="apellidos" name="apellidos" placeholder="Apellidos" value="<?= !isset($usuario)? '' : $usuario->apellidos?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="usuario" class="col-sm-2 col-form-label">Usuario</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" required id="usuario" name="usuario" placeholder="Usuario" value="<?= !isset($usuario)? '' : $usuario->usuario?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pass" class="col-sm-2 col-form-label">Contraseña</label>
                                <div class="col-sm-4">
                                    <input type="password" class="form-control" id="pass" <?= isset($usuario)? '' : 'required'?> name="pass" placeholder="Contraseña">
                                </div>
                                <label for="repeat-pass" class="col-sm-2 col-form-label">Repetir Contraseña</label>
                                <div class="col-sm-4">
                                    <input type="password" class="form-control" id="repeat-pass" <?= isset($usuario)? '' : 'required'?> name="repeat-pass" placeholder="Repetir Contraseña">
                                </div>
                            </div>
                            <fieldset class="form-group">
                                <div class="row">
                                    <legend class="col-form-label col-sm-2 pt-0">Roles</legend>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="roles" name="roles" required>
                                            @foreach ($roles as $rol)
                                                <option value="{{ $rol->id }}" {{ isset($usuario) && $usuario->rol_id == $rol->id ? '' : 'selected' }}> {{ $rol->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                            
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <a href=javascript:history.back(1) class="btn btn-danger"><i class="fa fa-arrow-circle-left"></i> Volver</a>
                                    <button type="submit" id="registrar" class="btn btn-primary">{{ isset($usuario)? 'Actualizar ' : 'Guardar'}}</button>
                                </div>
                            </div>
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script type="text/javascript">
        $(function(){
            $('#registro-usuario').on('submit',function(){
                event.preventDefault()
                
                $.confirm({
                    content:function(){
                        var self = this
                        return $.ajax({
                            url: "{{ isset($usuario) ? route('editar-usuario',['id'=> $usuario->id]) : route('nuevo-usuario') }}",
                            method: 'POST',
                            dataType: 'JSON',
                            data: $('#registro-usuario').serialize()
                        }).done(function(response){

                            self.close()
                            toastr.success(response.message)
                            setTimeout(function(){
                                window.location.href='{{ route("usuarios") }}'
                            },3000)
                        }).fail(function(){
                            self.close()
                            toastr.error('Error, consulte su administrador')
                        })
                    }
                })
            })
            $('#usuario').on('blur',function(){
                if($('#usuario').val() == '')
                    return false
                $.ajax({
                    url: '{{ route("consulta-usuario") }}',
                    method: 'POST',
                    dataType: 'JSON',
                    data:{
                        usuario: $('#usuario').val(),
                        _token: '{{ @csrf_token() }}'
                    }
                }).done(function(response){
                    if(response.status == 202){
                        $('#registrar').attr('disabled','disabled')
                        $('#usuario').addClass('border-danger').removeClass('border-success')
                        toastr.error(response.message)
                    }else{
                        $('#registrar').removeAttr('disabled')
                        $('#usuario').addClass('border-success').removeClass('border-danger')
                        toastr.success(response.message)
                        setTimeout(()=>{
                            $('#usuario').removeClass('border-success')
                        },3000);
                    }
                    console.log(response)
                }).fail(function(){})
            })
        })
    </script>
@endsection