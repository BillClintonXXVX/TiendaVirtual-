<?php require_once "config/conexion.php"; ?>
<!DOCTYPE html>
<html lang="es">
	
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<link href="css/all.min.css" rel="stylesheet">
		<link href="css/estilos.css" rel="stylesheet">
	</head>
	
	<body>
		
		<header>
			<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

			</nav>
		</header>
		
		<main>
			<div class="container">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Producto</th>
								<th>Precio</th>
								<th>Cantidad</th>
								<th>Subtotal</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
																<tr>
										<td>Laptop 15.6" con Windows 10</td>
										<td>$14,399.10</td>
										<td><input type="number" id="cantidad_2" min="1" max="10" step="1" value="6" size="5" onchange="actualizaCantidad(this.value, 2)" /></td>
										
										<td>
											<div id="subtotal_2" name="subtotal[]">$86,394.60</div>
										</td>
										<td><a id="eliminar" class="btn btn-warning btn-sm" data-bs-id="2" data-bs-toggle="modal" data-bs-target="#eliminaModal"><i class="fas fa-trash-alt"></i></a></td>
									</tr>
																	<tr>
										<td>Smartphone Negro 32gb Dual Sim 3gb Ram</td>
										<td>$2,899.00</td>
										<td><input type="number" id="cantidad_3" min="1" max="10" step="1" value="1" size="5" onchange="actualizaCantidad(this.value, 3)" /></td>
										
										<td>
											<div id="subtotal_3" name="subtotal[]">$2,899.00</div>
										</td>
										<td><a id="eliminar" class="btn btn-warning btn-sm" data-bs-id="3" data-bs-toggle="modal" data-bs-target="#eliminaModal"><i class="fas fa-trash-alt"></i></a></td>
									</tr>
																	<tr>
										<td>Zapato De Piel De Borrego</td>
										<td>$539.10</td>
										<td><input type="number" id="cantidad_1" min="1" max="10" step="1" value="1" size="5" onchange="actualizaCantidad(this.value, 1)" /></td>
										
										<td>
											<div id="subtotal_1" name="subtotal[]">$539.10</div>
										</td>
										<td><a id="eliminar" class="btn btn-warning btn-sm" data-bs-id="1" data-bs-toggle="modal" data-bs-target="#eliminaModal"><i class="fas fa-trash-alt"></i></a></td>
									</tr>
																
								<tr>
									<td colspan="3"></td>
									<td colspan="2">
										<p class="h3" id="total">$89,832.70</p>
									</td>
								</tr>
								
														
						</tbody>
					</table>
				</div>
				
				<!--<div class="row justify-content-end">-->
									<div class="row">
						<div class="col-md-5 offset-md-7 d-grid gap-2">
							<a href="pago.php" class="btn btn-primary btn-lg">Realizar pago</a>
						</div>
					</div>
							</div>
		</main>
		
		<div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						¿Desea eliminar el producto de la lista?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
						<button id="btn-elimina" class="btn btn-danger" onclick="elimina()">Eliminar</button>
					</div>
				</div>
			</div>
		</div>
		
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
		
		
		<script>
			let eliminaModal = document.getElementById('eliminaModal')
			eliminaModal.addEventListener('show.bs.modal', function(event) {
				// Button that triggered the modal
				let button = event.relatedTarget
				// Extract info from data-bs-* attributes
				let recipient = button.getAttribute('data-bs-id')
				let botonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
				botonElimina.value = recipient
			})
			
			function actualizaCantidad(cantidad, id) {
				
				if(!isNaN(cantidad) && cantidad > 0){
					
					let url = 'clases/actualizar_carrito.php';
					let formData = new FormData();
					formData.append('action', 'agregar');
					formData.append('id', id);
					formData.append('cantidad', cantidad);
					
					fetch(url, {
						method: 'POST',
						body: formData,
						mode: 'cors',
					}).then(response => response.json())
					.then(data => {
						if (data.ok) {
							let divSubtotal = document.getElementById('subtotal_' + id)
							divSubtotal.innerHTML = data.sub
							
							let total = 0.00
							let list = document.getElementsByName('subtotal[]')
							
							for (var i = 0; i < list.length; ++i) {
								total += parseFloat(list[i].innerHTML.replace(/[$,]/g, ''))
							}
							
							total = new Intl.NumberFormat('en-US', {
								minimumFractionDigits: 2
							}).format(total)
							document.getElementById("total").innerHTML = '$' + total
						}
					})
				}
			}
			
			function elimina() {
				let botonElimina = document.getElementById('btn-elimina')
				let recipient = botonElimina.value
				
				let url = 'clases/actualizar_carrito.php';
				let formData = new FormData();
				formData.append('action', 'eliminar');
				formData.append('id', recipient);
				
				fetch(url, {
                    method: 'POST',
					body: formData,
					mode: 'cors',
				}).then(response => response.json())
				.then(data => {
					if (data.ok) {
						location.reload();
					}
				})
				$('#eliminaModal').modal('hide')
			}
		</script>
		
	</body>
	
</html>