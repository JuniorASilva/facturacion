@extends('body/body')
@section('content')
    <main class="main-content p-5" role="main">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group row">
                                <label for="nombres" class="col-sm-2 col-form-label">Nombres*</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="nombres" required name="nombres" placeholder="Email">
                                </div>
                                <label for="apellidos" class="col-sm-2 col-form-label">Apellidos*</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="apellidos" required name="apellidos" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="usuario" class="col-sm-2 col-form-label">Usuario*</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="usuario" required name="usuario" placeholder="Usuario">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pass" class="col-sm-2 col-form-label">Contraseña*</label>
                                <div class="col-sm-4">
                                    <input type="password" class="form-control" id="pass" required name="pass" placeholder="Contraseña">
                                </div>
                                <label for="repeat-pass" class="col-sm-2 col-form-label">Repetir Contraseña*</label>
                                <div class="col-sm-4">
                                    <input type="password" class="form-control" id="repeat-pass" required name="repeat-pass" placeholder="Repetir Contraseña">
                                </div>
                            </div>
                            <fieldset class="form-group">
                                <div class="row">
                                    <legend class="col-form-label col-sm-2 pt-0">Roles</legend>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="roles" required name="roles">
                                            @foreach ($roles as $rol)
                                                <option value="{{ $rol->id }}"> {{ $rol->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" id="registrar" class="btn btn-primary">Registrar</button>
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
            $('#usuario').on('blur',function(){
                if($('#usuario').val() == '')
                    return false;
                $.ajax({
                    url: '{{ route("consulta-usuario") }}',
                    method: 'POST',
                    dataType: 'JSON ',
                    data: {
                        usuario: $('#usuario').val(),
                        _token: '{{ csrf_token() }}'
                    }
                }).done(function(response){
                    if(response.status == 202){
                        $('#registrar').attr('disabled','disabled');
                        $('#usuario').addClass('border-danger').removeClass('border-success');
                    }else{
                        $('#registrar').removeAttr('disabled');
                        $('#usuario').addClass('border-success').removeClass('border-danger');
                        setTimeout(()=>{
                            $('#usuario').removeClass('border-success');
                        }, 3000);
                    }
                }).fail(function(error){
                    console.log(error)
                });
            });
        });
    </script>
    <!--
        terminar el registro del usuario
        agregarle 3 segundos de espera de color verde
    -->
@endsection