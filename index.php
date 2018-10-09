<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>.:: Haexpress ::.</title>
	<link rel="icon" href="img/logoHeader.png">
	<link rel="stylesheet" type="text/css" href="plugs/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="plugs/jquery-ui-1.12.1/jquery-ui.min.css">
	<link rel="stylesheet" type="text/css" href="css/jquery.alerts.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
	<div class="container-fluid">
		<header style="margin: 10px;">
			<div class="row">
				<div class="col-sm-4">
					<img alt="logo" src="img/logoHeader.png">
				</div>
				<div class="col-sm-3 text-center">
					<h1>Bienvenido</h1>
				</div>
				<div class="col-sm-1">

				</div>
				<div class="col-sm-3">
					<form id="fLogin" data-toggle="validator" role="form" method="post">
						<div class="form-group row">
							<label for="txtEmail" class="col-sm-3 col-form-label">Email</label>
							<div class="col-sm-9">
								<input class="form-control" type="email" id="txtEmail" name="txtEmail" placeholder="Ingrese su email" required="required">
							</div>
						</div>
						<div class="form-group row">
							<label for="txtPassword" class="col-sm-3 col-form-label">Contraseña</label>
							<div class="col-sm-9">
								<input class="form-control" type="password" id="txtPassword" name="txtPassword" placeholder="Ingrese su contraseña" required="required">
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6 text-center">
								<a href="#" class="btn btn-outline-warning">Registrarse</a>
							</div>
							<div class="col-sm-6 text-center">
								<button type="submit" id="bLogin" class="btn btn-outline-info">Ingresar</button>
							</div>
						</div>
						<div class="form-group">
						</div>
					</form>
				</div>
				<div class="col-sm-1">
					<div class="row">
						<div class="col-sm-4">
							<img src="img/imgCanada.png" alt="English">
						</div>
						<div class="col-sm-4">
							<img src="img/imgespana.png" alt="Español">
						</div>
						<div class="col-sm-4">
							<img src="img/imgFra.png" alt="Français">
						</div>
					</div>
				</div>
			</div>
		</header>
		<div class="container">
			<div id="crHeader" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
				</ol>
				<div class="carousel-inner" role="listbox">
					<div class="carousel-item active"> 
						<img class="d-block img-fluid carouselImages" src="img/carousel/ima2.jpg" alt="First slide"> 
					</div>
					<div class="carousel-item"> 
						<img class="d-block img-fluid carouselImages" src="img/carousel/img1.jpg" alt="Second slide"> 
					</div>
					<div class="carousel-item"> 
						<img class="d-block img-fluid carouselImages" src="img/carousel/img4.jpg" alt="Four slide"> 
					</div>
				</div>
				<a class="carousel-control-prev" href="#crHeader" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#crHeader" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> 
			</div>
		</div>
	</div>
	<script type="text/javascript" src="plugs/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="plugs/bootstrap-4.0.0-alpha.6-dist/js/bootstrap.min.js"></script> 
	<script type="text/javascript" src="plugs/jquery.alerts.js"></script>
	<script type="text/javascript" src="plugs/validator.js"></script>
	<script type="text/javascript" src="script/functions.js"></script>
</body>

</html>