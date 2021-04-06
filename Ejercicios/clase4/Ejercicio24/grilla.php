<?php
	require_once('Usuario.php');
?>
<html>
<head>
	<title>Ejemplo de Listado de Usuarios -</title>

	<meta charset="UTF-8">
		
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="estilo.css">

</head>
<body>
	<a class="btn btn-info" href="index.html">Menu principal</a>

	<div class="container">
		<div class="page-header">
			<h1>Ejemplos de Grilla</h1>      
		</div>
		<div class="CajaInicio animated bounceInRight">
			<h1>Listado de Usuarios</h1>

<?php 

$archivoParaLeer = "usuarios.json";
$ArrayDeUsuarios = Usuario::LeerDeJson($archivoParaLeer);

echo "<table class='table'>
		<thead>
			<tr>
				<th>  NOMBRE     </th>
				<th>  FOTO       </th>
			</tr> 
		</thead>";   	

	foreach ($ArrayDeUsuarios as $user){

		echo " 	<tr>
					<td>".$user->GetNombre()."</td>
					<td><img src='".$user->GetRutaFoto()."' width='100px' height='100px'/></td>
				</tr>";
	}	
echo "</table>";		
?>
		</div>
	</div>
</body>
</html>