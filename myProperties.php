<?php 



// Recibe los datos que utilizará todo el sitio para manejar las conexiones a la base de datos
$_SESSION['server'] = 'localhost';
$_SESSION['username'] = 'root';
$_SESSION['password'] = 'mysql123';
$_SESSION['dbname'] = 'bienesraicescr';

// Crea una nueva conexión
$conn = new mysqli($_SESSION['server'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>


<html><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
    <link href="css/estiloTemplate.css" rel="stylesheet" type="text/css">
  </head><body>
    <div class="container">
      <div class="navbar navbar-default navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" draggable="true"><img height="40" alt="Brand" src="img/BienesRaícesCRLogoNarrow.png" class="img-thumbnail"></a>
          </div>
          <div class="collapse navbar-collapse" id="navbar-ex-collapse">
            <ul class="nav navbar-left navbar-nav">
              <li>
                <a href="./index.html">INICIO</a>
              </li>
              <li>
                <a href="./sales.html">VENTA</a>
              </li>
              <li>
                <a href="./rents.html">ALQUILER</a>
              </li>
              <li>
                <a href="./search.html">BÚSQUEDA</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="section section-Content col-md-12">
        <h1 class="col-md-offset-1 text-muted">Mis Propiedades</h1>
        <br>
        <br>
        <div class="container col-md-3">
          <br>
          <button class="btn btn-block btn-info">Agregar propiedad</button>
          <button class="btn btn-block btn-warning">Modificar propiedad</button>
          <button class="btn btn-block btn-danger">Eliminar Propiedad</button>
        </div>
        <div class="container col-md-9">
          
          <?php 
		  
		  $pidUser=1;
	  
		$sql = "SELECT idProperty FROM property WHERE idUser='$pidUser'";
				$result = $conn->query($sql);
				if (!$result) {
					echo 'Could not run query: ' . mysql_error();
					exit;
				}
				while($row = $result->fetch_row()){
					$idProperty = $row[0];
						
					if (!($resultado = $conn->query("SELECT p.name, p.description, p.price, t.name as typesale
													FROM property p INNER JOIN typesale t ON (p.idType=t.idTypeSale)
													WHERE (p.idProperty='$idProperty');"))) {
						echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
					}else{
						$fila = $resultado->fetch_assoc();
						$nameProperty = $fila['name'];
						$description = $fila['description'];
						$price = $fila['price'];
						$typesale = $fila['typesale'];	
						
					}
					
					if (!($resultado = $conn->query("SELECT c.name
											FROM property p 
											INNER JOIN geolocation g ON (p.idGeolocation=g.idGeolocation) 
											INNER JOIN city c ON (c.idCity=g.idCity)
											WHERE (p.idProperty='$idProperty');"))) {
						echo "Falló CALL: (" . $conn->errno . ") " . $conn->error;
					}else{
						$fila = $resultado->fetch_assoc();
						$cityName = $fila['name'];
					}
				
				  echo '<div class="row">';
					echo '<div class="col-md-4">';
					  echo '<img src="img\casaTemplate.jpg" class="img-responsive">';
					echo '</div>';
					echo '<div class="col-md-8">';
					  echo "<a href=\"http://localhost:8080/dashboard/bienesRaicesCR/property.html?idProperty=$idProperty\"><h1>$nameProperty</h1></a>";
					  echo '<h6 class="text-danger">';
						echo"<i class=\"fa fa-fw fa-map-marker\"></i>$cityName</h6>";
					  echo "<p>$description</p>";
					  echo '<h3 class="text-danger">';
						echo '<strong>$';
						  echo '<em>';
							echo "<span>$price</span>";
						  echo '</em>';
						echo '</strong>';
					  echo '</h3>';
					  echo "<h3 class=\"text-left text-danger\">$typesale</h3>";
				   echo '</div>';
				 echo '</div>';
				  echo '<hr>';
					
				}
	  
	  ?>
		  
        </div>
      </div>
    </div>
    <footer class="section section-primary">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <h1>Bienes Raíces CR</h1>
            <p>Somos una compañía comprometida con su propiedad y su facilidad de negociación.
              Buscamos ser la plataforma principal de transacciones propietarias.</p>
          </div>
          <div class="col-sm-6">
            <p class="text-info text-right">
              <br>
              <br>
            </p>
            <div class="row">
              <div class="col-md-12 hidden-lg hidden-md hidden-sm text-left">
                <a href="#"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 hidden-xs text-right">
                <a href="#"><i class="fa fa-3x fa-fw hub text-inverse fa-pied-piper-alt"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>


</body></html>
