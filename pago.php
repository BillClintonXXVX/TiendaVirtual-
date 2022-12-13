<?php require_once "config/conexion.php"; ?>
<!DOCTYPE html>
<html lang="es">
	
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Tienda en linea - DEMO</title>
		
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<link href="css/all.min.css" rel="stylesheet">
		<link href="css/estilos.css" rel="stylesheet">
		
		
		<script src="https://www.paypal.com/sdk/js?client-id=ATJIdi4OsWJLVk3IdT-1uKg2XsFpNe7R89Jm3pj8NwgaxUGF5WiGQMoFB96TPkR-jMpFjPFc2inLyBqW&currency=MXN"></script>
		<script src="https://sdk.mercadopago.com/js/v2"></script>
		
	</head>
	
	<body>
		
		<header>
			<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			</nav>
		</header>

		
		<main>
			
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-md-5 col-sm-12">
						<br>
						<h1 id="texto">
                        <span id="text"></span> DETALLES DE PAGO
                        </h1>
						<br>
						<div lcass="row">
							<div class="col-10">
								<div id="paypal-button-container"></div>
							</div>
						</div>
						
						<div lcass="row">
							<div class="col-10 text-center">
								<div class="checkout-btn"></div>
							</div>
						</div>
					</div>
					
					<div class="col-lg-7 col-md-7 col-sm-12">
						<div class="table-responsive">
						</div>
					</div>
				</div>
			</div>
		</main>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
		
		<script>
			paypal.Buttons({
				
				style: {
					color: 'blue',
					shape: 'pill',
					label: 'pay'
				},
				
				createOrder: function(data, actions) {
					return actions.order.create({
						purchase_units: [{
							amount: {
								value: 89832.7							},
							description: 'Compra tienda CDP'
						}]
					});
				},
				
				onApprove: function(data, actions) {
					
					let url = 'index.php';
					actions.order.capture().then(function(details) {
						
						console.log(details);
						
						let trans = details.purchase_units[0].payments.captures[0].id;
						return fetch(url, {
							method: 'post',
							mode: 'cors',
							headers: {
								'content-type': 'application/json'
							},
							body: JSON.stringify({
								details: details
							})
							}).then(function(response) {
							window.location.href = "completado.php?key=" + trans;
						});
					});
				},
				
				onCancel: function(data) {
					console.log("Cancelo :(");
					console.log(data);
				}
			}).render('#paypal-button-container');
			
			
			const mp = new MercadoPago('TEST-f8d3d553-b99f-4684-8044-5fa273e6162b', {
				locale: 'es-MX'
			});
			
			// Inicializa el checkout Mercado Pago
			mp.checkout({
				preference: {
					id: '237609137-01b4f579-63d5-4333-a132-a2156afffcc6'
				},
				render: {
					container: '.checkout-btn', // Indica el nombre de la clase donde se mostrará el botón de pago
					type: 'wallet', // Muestra un botón de pago con la marca Mercado Pago
					label: 'Pagar con Mercado Pago', // Cambia el texto del botón de pago (opcional)
				}
			});
		</script>
		
	</body>
	
</html>
