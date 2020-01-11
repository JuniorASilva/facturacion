<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Trabajo de Backend">
	<meta name="author" content="Maria Lucia Ibañez Palacios">
	<link rel="icon" href="assets/img/favicon.png">

	<title>Backend | Facturacion</title>

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700&amp;subset=latin-ext" rel="stylesheet">

	<!-- CSS - REQUIRED - START -->
	<!-- Batch Icons -->
	<link rel="stylesheet" href="assets/fonts/batch-icons/css/batch-icons.css">
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap/bootstrap.min.css">
	<!-- Material Design Bootstrap -->
	<link rel="stylesheet" href="assets/css/bootstrap/mdb.min.css">
	<!-- Custom Scrollbar -->
	<link rel="stylesheet" href="assets/plugins/custom-scrollbar/jquery.mCustomScrollbar.min.css">
	<!-- Hamburger Menu -->
	<link rel="stylesheet" href="assets/css/hamburgers/hamburgers.css">

	<!-- CSS - REQUIRED - END -->

	<!-- CSS - OPTIONAL - START -->
	<!-- Font Awesome -->
	<link rel="stylesheet" href="assets/fonts/font-awesome/css/font-awesome.min.css">

	<!-- CSS - DEMO - START -->
	<link rel="stylesheet" href="assets/demo/css/ui-icons-batch-icons.css">
	<!-- CSS - DEMO - END -->

	<!-- CSS - OPTIONAL - END -->

	<!-- QuillPro Styles -->
	<link rel="stylesheet" href="assets/css/quillpro/quillpro.css">
</head>

<body>

	<div class="container-fluid">
		<div class="row">
			<div class="right-column sisu">
				<div class="row mx-0">
					<div class="col-md-7 order-md-2 signin-right-column px-5 bg-dark" style="background-image: url(assets/img/fondo4.jpg);">
						<a class="signin-logo d-sm-block d-md-none" href="#">
							<img src="assets/img/logo-white.png" width="145" height="40" alt="QuillPro">
						</a>
						<h1 class="display-4">Backend</h1>
						<p class="lead mb-5">
							Trabajo 1 <br>
							Profesor | Junior Silva <br>
							Autor | María Lucía Ibáñez Palacios
						</p>
					</div>
					<div class="col-md-5 order-md-1 signin-left-column bg-white px-5" style="padding-top: 100px">
						<a class="signin-logo d-sm-none d-md-block text-center" href="#">
							<img src="assets/img/logo-white.png" width="145" height="40" alt="CodiGO">
						</a>
						<div class="profile-picture profile-picture-lg bg-gradient bg-primary">
							<img src="assets/img/usuario.png" width="44" height="44">
						</div>
						<form class="pt-3" action="{{ route('login') }}" method="POST">
                            @csrf
                            @if(session()->get('message_login'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session()->get('message_login') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
							<p>Por favor ingresar su usuario y contraseña para iniciar sesión</p>
							<div class="form-group">
								<label for="nombre">Usuario</label>
								<input type="text" class="form-control" name="usuario" required>
								<label for="password">Contraseña</label>
								<input type="password" class="form-control" name="pass" required>
							</div>
							<button type="submit" class="btn btn-primary btn-gradient btn-block">
								<i class="batch-icon batch-icon-key"></i>&nbsp;&nbsp;
								Iniciar Sesión
							</button>
							<hr>
							
                            

							<p class="text-center">
								¿No tienes una cuenta? <a href="">Registrate aquí</a>
							</p>
						</form>
                                              
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- SCRIPTS - REQUIRED START -->
	<!-- Placed at the end of the document so the pages load faster -->
	<!-- Bootstrap core JavaScript -->
	<!-- JQuery -->
	<script type="text/javascript" src="assets/js/jquery/jquery-3.1.1.min.js"></script>
	<!-- Popper.js - Bootstrap tooltips -->
	<script type="text/javascript" src="assets/js/bootstrap/popper.min.js"></script>
	<!-- Bootstrap core JavaScript -->
	<script type="text/javascript" src="assets/js/bootstrap/bootstrap.min.js"></script>
	<!-- MDB core JavaScript -->
	<script type="text/javascript" src="assets/js/bootstrap/mdb.min.js"></script>
	<!-- Velocity -->
	<script type="text/javascript" src="assets/plugins/velocity/velocity.min.js"></script>
	<script type="text/javascript" src="assets/plugins/velocity/velocity.ui.min.js"></script>
	<!-- Custom Scrollbar -->
	<script type="text/javascript" src="assets/plugins/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
	<!-- jQuery Visible -->
	<script type="text/javascript" src="assets/plugins/jquery_visible/jquery.visible.min.js"></script>
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script type="text/javascript" src="assets/js/misc/ie10-viewport-bug-workaround.js"></script>

	<!-- SCRIPTS - REQUIRED END -->

	<!-- SCRIPTS - OPTIONAL START -->
	<!-- Image Placeholder -->
	<script type="text/javascript" src="assets/js/misc/holder.min.js"></script>
	<!-- SCRIPTS - OPTIONAL END -->

	<!-- QuillPro Scripts -->
	<script type="text/javascript" src="assets/js/scripts.js"></script>
</body>
</html>