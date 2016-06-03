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
                <a href="./sales.php">VENTA</a>
              </li>
              <li>
                <a href="./rents.html">ALQUILER</a>
              </li>
              <li class="active">
                <a href="./search.php">BÚSQUEDA</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="section section-Content col-md-12">
        <h1 class="col-md-offset-1 text-muted">Búsqueda</h1>
        <br>
        <br>
        <div class="container col-md-3 searchSection">
		  <br> 
          <form role="form" action="search.php" method="POST">
            <div class="form-group">
              <label class="control-label" for="province">Provincia</label>
              <select class="selectpicker" id="province" name="provincia" data-live-search="true">
				<option value=""></option>
                <?php 
					$sql = "SELECT name FROM state";
					$result = $conn->query($sql);
					if (!$result) {
						echo 'Could not run query: ' . mysql_error();
						exit;
					}
					while($row = $result->fetch_row()){
						echo "<option value=\"". $row[0]. "\">". $row[0] . "</option>\n";
					}
				?>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label" for="canton">Cantón</label>
              <select class="selectpicker" id="canton" name="canton" data-live-search="true">
				<option value=""></option>
                <?php 
					$sql = "SELECT name FROM city";
					$result = $conn->query($sql);
					if (!$result) {
						echo 'Could not run query: ' . mysql_error();
						exit;
					}
					while($row = $result->fetch_row()){
						echo "<option value=\"". $row[0]. "\">". $row[0] . "</option>\n";
					}
				?>
              </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block" name="search">BUSCAR</button>
          </form>
        </div>
        <div class="container col-md-9">
          
		  <?php 
		  
		  if(isset($_POST["search"])){
			   
			$cityName = $_POST['canton'];
			$stateName = $_POST['provincia'];
			
			if($cityName!=""){
				  
				$sql = "SELECT idProperty FROM property p INNER JOIN 
						(SELECT c.idCity,g.idGeolocation FROM city c INNER JOIN geolocation g ON (c.idCity=g.idCity)
						WHERE (c.name='$cityName')) s1
						ON (s1.idGeolocation=p.idGeolocation);";
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
				
				  echo '<div class="row">';
					echo '<div class="col-md-4">';
					  echo '<img src="img\casaTemplate.jpg" class="img-responsive">';
					echo '</div>';
					echo '<div class="col-md-8">';
					  echo "<a href=\"http://localhost:8080/dashboard/bienesRaices/property.php?idProperty=$idProperty\"><h1>$nameProperty</h1></a>";
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
					
			}
			
			if($cityName==""){
				  
				$sql = "SELECT idProperty FROM property p INNER JOIN 
						(SELECT s.idState,c.idCity,g.idGeolocation FROM city c INNER JOIN geolocation g ON (c.idCity=g.idCity)
						INNER JOIN state s ON (s.idState=c.idState)
						WHERE (s.name='$stateName')) s1
						ON (s1.idGeolocation=p.idGeolocation);";
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
					
			}
				  
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
