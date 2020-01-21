<!DOCTYPE html>

<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="{{ asset('assets/img/favicon.png') }}">

	<title>Backend | Trab 1</title>

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700&amp;subset=latin-ext" rel="stylesheet">

	<!-- CSS - REQUIRED - START -->
	<!-- Batch Icons -->
	<link rel="stylesheet" href="{{ asset('assets/fonts/batch-icons/css/batch-icons.css') }}">
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap/bootstrap.min.css') }}">
	<!-- Material Design Bootstrap -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap/mdb.min.css') }}">
	<!-- Custom Scrollbar -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/custom-scrollbar/jquery.mCustomScrollbar.min.css') }}">
	<!-- Hamburger Menu -->
	<link rel="stylesheet" href="{{ asset('assets/css/hamburgers/hamburgers.css') }}">

	<!-- CSS - REQUIRED - END -->

	<!-- CSS - OPTIONAL - START -->
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ asset('assets/fonts/font-awesome/css/font-awesome.min.css') }}">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ asset('assets/fonts/font-awesome/css/font-awesome.min.css') }}">
	<!-- JVMaps -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/jvmaps/jqvmap.min.css') }}">
	<!-- CSS - OPTIONAL - END -->

	<!-- QuillPro Styles -->
	<link rel="stylesheet" href="{{ asset('assets/css/quillpro/quillpro.css') }}">

	<!-- SCRIPTS - REQUIRED START -->
	<!-- Placed at the end of the document so the pages load faster -->
	<!-- Bootstrap core JavaScript -->
	<!-- JQuery -->
	<script type="text/javascript" src="{{ asset('assets/js/jquery/jquery-3.1.1.min.js') }}"></script>
	<!-- Popper.js - Bootstrap tooltips -->
	<script type="text/javascript" src="{{ asset('assets/js/bootstrap/popper.min.js') }}"></script>
	<!-- Bootstrap core JavaScript -->
	<script type="text/javascript" src="{{ asset('assets/js/bootstrap/bootstrap.min.js') }}"></script>
	<!-- MDB core JavaScript -->
	<script type="text/javascript" src="{{ asset('assets/js/bootstrap/mdb.min.js') }}"></script>
	<!-- Velocity -->
	<script type="text/javascript" src="{{ asset('assets/plugins/velocity/velocity.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/plugins/velocity/velocity.ui.min.js') }}"></script>
	<!-- Custom Scrollbar -->
	<script type="text/javascript" src="{{ asset('assets/plugins/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
	<!-- jQuery Visible -->
	<script type="text/javascript" src="{{ asset('assets/plugins/jquery_visible/jquery.visible.min.js') }}"></script>
	<!-- jQuery Visible -->
	<script type="text/javascript" src="{{ asset('assets/plugins/jquery_visible/jquery.visible.min.js') }}"></script>
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script type="text/javascript" src="{{ asset('assets/js/misc/ie10-viewport-bug-workaround.js') }}"></script>

	<!-- SCRIPTS - REQUIRED END -->

	<!-- SCRIPTS - OPTIONAL START -->
	<!-- ChartJS -->
	<script type="text/javascript" src="{{ asset('assets/plugins/chartjs/chart.bundle.min.js') }}"></script>
	<!-- JVMaps -->
	<script type="text/javascript" src="{{ asset('assets/plugins/jvmaps/jquery.vmap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/plugins/jvmaps/maps/jquery.vmap.usa.js') }}"></script>
	<!-- Image Placeholder -->
	<script type="text/javascript" src="{{ asset('assets/js/misc/holder.min.js') }}"></script>
	<!-- SCRIPTS - OPTIONAL END -->

	<!-- QuillPro Scripts -->
	<script type="text/javascript" src="{{ asset('assets/js/scripts.js') }}"></script>
</head>

<body>

	<div class="container-fluid">
		<div class="row">
			<nav id="sidebar" class="px-0 bg-dark bg-gradient sidebar">
				<ul class="nav nav-pills flex-column">
					<li class="logo-nav-item">
						<a class="navbar-brand" href="#">
							<img src="{{ asset('assets/img/logo-dark.png') }}" width="145" height="40" alt="CodiGO">
						</a>
					</li>
					<li>
						<h6 class="nav-header">General</h6>
					</li>
					<li class="nav-item">
						<a class="nav-link {{ $option == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
							<i class="batch-icon batch-icon-terminal"></i>
							Principal <span class="sr-only">(current)</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link {{ $option == 'usuarios' ? 'active' : '' }}" href="{{ route('usuarios') }}">
							<i class="batch-icon batch-icon-book-alt-lines"></i>
							Usuario <span class="sr-only">(current)</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="calculadora.php">
							<i class="batch-icon batch-icon-marquee-plus"></i>
							Calculadora <span class="sr-only">(current)</span>
						</a>
					</li>
					
				</ul>

				
			</nav>
			<div class="right-column">
				<nav class="navbar navbar-expand-lg navbar-light bg-white">
					<a class="navbar-brand d-block d-sm-block d-md-block d-lg-none" href="#">
						<img src="{{ asset('assets/img/logo-dark.png') }}" width="145" height="32.3" alt="QuillPro">
					</a>
					<button class="hamburger hamburger--slider" type="button" data-target=".sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle Sidebar">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>
					<!-- Added Mobile-Only Menu -->
					<ul class="navbar-nav ml-auto mobile-only-control d-block d-sm-block d-md-block d-lg-none">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" id="navbar-notification-search-mobile" data-toggle="dropdown" data-flip="false" aria-haspopup="true" aria-expanded="false">
								<i class="batch-icon batch-icon-search"></i>
							</a>
							<ul class="dropdown-menu dropdown-menu-fullscreen" aria-labelledby="navbar-notification-search-mobile">
								<li>
									<form class="form-inline my-2 my-lg-0 no-waves-effect">
										<div class="input-group">
											<input type="text" class="form-control" placeholder="Search for..." aria-label="Search for..." aria-describedby="basic-addon2">
											<div class="input-group-append">
												<button class="btn btn-primary btn-gradient waves-effect waves-light" type="button">
													<i class="batch-icon batch-icon-search"></i>
												</button>
											</div>
										</div>
									</form>
								</li>
							</ul>
						</li>
					</ul>

					<!--  DEPRECATED CODE:
						<div class="navbar-collapse" id="navbarSupportedContent">
					-->
					<!-- USE THIS CODE Instead of the Commented Code Above -->
					<!-- .collapse added to the element -->
					<div class="collapse navbar-collapse" id="navbar-header-content">
						<ul class="navbar-nav navbar-language-translation mr-auto">
						   
						</ul>
						<ul class="navbar-nav navbar-notifications float-right">
							
						</ul>
						<ul class="navbar-nav ml-5 navbar-profile">
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" id="navbar-dropdown-navbar-profile" data-toggle="dropdown" data-flip="false" aria-haspopup="true" aria-expanded="false">
									<!--<?php //if(isset($_SESSION['usuario'])): ?>
                                        <div class="profile-name">
										     <b style="color: #142961">Hola!&nbsp;</b>
									    </div>
                                    <?php //endif;?>-->
									<div class="profile-picture bg-gradient bg-primary has-message float-right">
										<img src="{{ asset('assets/img/usuario.png') }}" width="44" height="44">
									</div>
								</a>
								<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-dropdown-navbar-profile">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}">
                                        <i class="batch-icon batch-icon-outgoing"></i>&nbsp;&nbsp; Cerrar Sesión</a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</nav>

				@yield('contenido')

			</div>
		</div>
	</div>
	
</body>
</html>
