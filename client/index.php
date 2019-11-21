<?php
	$identificadorUsuario = isset($_COOKIE["identificadorUsuario"]) ? $_COOKIE["identificadorUsuario"] : "";
	$idUsuario = isset($_COOKIE["idUsuario"]) ? $_COOKIE["idUsuario"] : "";
	$senha = isset($_COOKIE["senha"]) ? $_COOKIE["senha"] : "";
	
	if ((strlen($identificadorUsuario) <= 0)||(strlen($idUsuario) <= 0)||(strlen($senha) <= 0)) {
		header("Location: login.html");
	}
?>
<!DOCTYPE html>
<html>

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Waiter">

		<title>Waiter</title>

		<link rel="shortcut icon" href="img/waiter-icon.png">

		<!-- Bootstrap core CSS -->
		<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

		<!-- Custom fonts for this template -->
		<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="css/home-fonts.min.css" rel="stylesheet" type="text/css">

		<!-- Plugin CSS -->
		<link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="jquery-confirm-master/css/jquery-confirm.min.css">

		<!-- MDB core JavaScript -->
		<link href="css/addons/datatables.min.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="css/home.min.css" rel="stylesheet">
	</head>

	<body id="page-top">

		<!-- Navigation -->
		<nav class="navbar navbar-expand-lg bg-secondary fixed-top text-uppercase" id="mainNav">
			<div class="container">
				<a class="navbar-brand js-scroll-trigger" href="#page-top">Waiter</a>
				<button class="navbar-toggler navbar-toggler-right text-uppercase bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
					Menu <i class="fa fa-bars"></i>
				</button>
				<div class="collapse navbar-collapse" id="navbarResponsive">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item mx-0 mx-lg-1">
							<a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#about">O Waiter</a>
						</li>
						<li class="nav-item mx-0 mx-lg-1">
							<a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#data">Meus Dados</a>
						</li>
						<li class="nav-item mx-0 mx-lg-1">
							<a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#solicitations">Solicitações</a>
						</li>
						<li class="nav-item mx-0 mx-lg-1">
							<a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#" id="botaoSair">Sair</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>

		<!-- Header -->
		<header class="masthead bg-primary text-white text-center">
			<div class="container">
				<img class="img-fluid mb-5 d-block mx-auto" src="img/waiter.png" alt="">
				<h1 class="text-uppercase mb-0">Waiter</h1>
				<hr class="star-light">
				<h2 class="font-weight-light mb-0">O Melhor Gestor de Dados Pessoais</h2>
			</div>
		</header>

		<!-- About Section -->
		<section class="mb-0" id="about">
			<div class="container">
				<h2 class="text-center text-uppercase text-secondary">O Waiter</h2>
				<hr class="star-dark mb-5">
				<div class="row">
					<div class="col-lg-4 ml-auto">
						<p class="lead">O Waiter é uma solução que visa simplificar os processos de cadastros em diversos estabelecimentos.</p>
					</div>
					<div class="col-lg-4 mr-auto">
						<p class="lead">Esperamos que com a ajuda dele você não precise mais passar por situações burocráticas e desgastantes devido a necessidade de fornecer suas informações.</p>
					</div>
				</div>
			</div>
		</section>

		<!-- My Data Section -->
		<section class="bg-primary text-white data" id="data">
			<div class="container">
				<h2 class="text-center text-uppercase text-white mb-0">Meus Dados</h2>
				<hr class="star-light mb-5">
				<div class="row">
					<div id="dataTableBlock" class="col-md-12 col-lg-12 table-wrapper-scroll-y table-editable">
						<!--a class="data-item d-block mx-auto" href="#data-modal-1">
							  <div class="data-item-caption d-flex position-absolute h-100 w-100">
								<div class="data-item-caption-content my-auto w-100 text-center text-white">
								  <i class="fa fa-search-plus fa-3x"></i>
								</div>
							  </div>
							  <img class="img-fluid" src="img/data/cabin.png" alt="">
							</a-->
						<span class="table-add float-right mb-3 mr-2"><a href="#!" class="text-success"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></a></span>
						<table id="dataTableList" class="table table-striped table-bordered table-hover table-sm text-center" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th class="th-sm">Id
										<i class="fa fa-sort float-right" aria-hidden="true"></i>
									</th>
									<th class="th-sm">Nome
										<i class="fa fa-sort float-right" aria-hidden="true"></i>
									</th>
									<th class="th-sm">Valor
										<i class="fa fa-sort float-right" aria-hidden="true"></i>
									</th>
									<th class="th-sm text-center">Excluir
										<i class="fa fa-sort float-right" aria-hidden="true"></i>
									</th>
								</tr>
							</thead>
							<tbody>
								<!--tr>
										<td contenteditable="true">Ab Nixon</td>
										<td contenteditable="true">Os Architect</td>
										<td><span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0">Excluir</button></span></td>
									</tr-->
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</section>

		<!-- Solicitations Section -->
		<section class="solicitations" id="solicitations">
			<div class="container">
				<h2 class="text-center text-uppercase text-secondary mb-0">Solicitações</h2>
				<hr class="star-dark mb-5">
				<div class="row">
					<div id="solicitationsTableBlock" class="col-md-12 col-lg-12 table-wrapper-scroll-y table-editable">
						<table id="solicitationsTableList" class="table table-striped table-bordered table-hover table-sm text-center" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th class="th-sm">Id
										<i class="fa fa-sort float-right" aria-hidden="true"></i>
									</th>
									<th class="th-sm">Campos
										<i class="fa fa-sort float-right" aria-hidden="true"></i>
									</th>
									<th class="th-sm">Solicitações
										<i class="fa fa-sort float-right" aria-hidden="true"></i>
									</th>
									<th class="th-sm text-center">Detalhar
										<i class="fa fa-sort float-right" aria-hidden="true"></i>
									</th>
									<th class="th-sm text-center">Aceitar
										<i class="fa fa-sort float-right" aria-hidden="true"></i>
									</th>
									<th class="th-sm text-center">Recusar
										<i class="fa fa-sort float-right" aria-hidden="true"></i>
									</th>
								</tr>
							</thead>
							<tbody>
								<!--tr>
										<td contenteditable="true">NuBank (4 Campos)</td>
										<td><span class="table-detail"><a class="data-item d-block mx-auto" href="#data-modal-1"><button type="button" class="btn btn-info btn-rounded btn-sm my-0">Detalhar</button></a></span></td>
										<td><span class="table-accept"><button type="button" class="btn btn-success btn-rounded btn-sm my-0">Aceitar</button></span></td>
										<td><span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0">Recusar</button></span></td>
									</tr-->
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</section>

		<!-- Footer -->
		<footer class="footer text-center">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h4 class="text-uppercase mb-12">CAROS COOPERADORES,</h4>
						<p class="lead mb-0">Esperamos ter tornado a sua vida mais fácil com o
							<a href="#page-top">Waiter</a>.
						</p>
					</div>
				</div>
			</div>
		</footer>

		<div class="copyright py-4 text-center text-white">
			<div class="container">
				<small>Copyright &copy; Rafael Perini Dev</small>
			</div>
		</div>

		<!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
		<div class="scroll-to-top d-lg-none position-fixed ">
			<a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top">
				<i class="fa fa-chevron-up"></i>
			</a>
		</div>

		<!-- Data Modals -->

		<div class="data-modal mfp-hide" id="data-modal">
			<div class="data-modal-dialog bg-white">
				<a class="close-button d-none d-md-block data-modal-dismiss" href="#"><i class="fa fa-3x fa-times"></i></a>
				<div class="container text-center">
					<div class="row">
						<div class="col-lg-8 mx-auto">
							<h2 class="text-secondary text-uppercase mb-0">Solicitação</h2>
							<hr class="star-dark mb-5">
							<div id="solicitationsTableDetailsBlock" class="col-md-12 col-lg-12 table-wrapper-scroll-y">
								<table id="solicitationsDetailsTableList" class="table table-striped table-bordered table-hover table-sm text-center" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th class="th-sm">Campos
												<i class="fa float-right" aria-hidden="true"></i>
											</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
							<a class="btn btn-primary btn-lg rounded-pill data-modal-dismiss" href="#"><i class="fa fa-close"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Bootstrap core JavaScript -->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

		<!-- Plugin JavaScript -->
		<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
		<script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="jquery-confirm-master/js/jquery-confirm.min.js"></script>

		<!-- Solicitations Form JavaScript -->
		<script src="js/jqBootstrapValidation.js"></script>
		<script src="js/contact_me.js"></script>

		<!-- MDB core JavaScript -->
		<script type="text/javascript" src="js/addons/datatables.min.js"></script>

		<!-- Custom scripts for this template -->
		<script src="js/main.min.js"></script>
		<script src="js/home.min.js"></script>
		<script src="js/tables.min.js"></script>
	</body>

</html>