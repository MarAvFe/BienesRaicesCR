<?php
session_start();

// Fragmento para hacer desaparecer el botón para agregar jugadores en caso de no se el admin
$hidden = "";
if(!isset($_SESSION['loggedUser'])){
    $hidden = " style='display:none'";
    /*<?php echo $hidden; ?>*/
}
$_SESSION['server'] = 'localhost';
$_SESSION['username'] = 'root';
$_SESSION['password'] = '123456';
$_SESSION['dbname'] = 'BiRaDb';

// Crea una nueva conexión
$conn = new mysqli($_SESSION['server'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fragmento para manejar y validar el registro de un nuevo jugador y la actualización de su imagen.
if(isset($_GET["idProperty"])){
  //  uploadPicture($_FILES["picture"], $dniPlayer, 1);

    $idProperty = $_GET["idProperty"];

    $sql = "SELECT p.name, p.description, p.price, t.name as typesale FROM property p INNER JOIN typesale t ON (p.idType=t.idTypeSale) WHERE (p.idProperty=$idProperty);";
    $result = $conn->query($sql);
    if (!$result) {
    	echo 'Could not run query: ' . mysql_error();
    	exit;
    }
    $row = $result->fetch_row();
    $name = $row[0];
    $price = $row[2];
    $idType = $row[3];
    $description = $row[1];

    $destacada = $isOutstanding == 1 ? "Si" : "No";



      /*$sql = "select e.nameEvent,e.dateStartEvent,e.dateEndEvent, es.nameEventStructure
    	from mydb.Event e, EventStructure es
        where e.idEvent='$idEvent' and e.idEventStructure=es.idEventStructure;";
        $result = $conn->query($sql);
        if (!$result) {
        echo 'Could not run query: ' . mysql_error();
        exit;
        }
    	$row = $result->fetch_row();
    	$nameEvent = $row[0];
    	$dateStart = normalize_date($row[1]);
    	$dateEnd = normalize_date($row[2]);
    	$nameEventStructure = $row[3];

      	$sql = "call getProperty('$dniPlayer',STR_TO_DATE('$birthdate','%d/%m/%Y'),'$fnamePlayer', '$snamePlayer','$lnamePlayer','$heightPlayer','$weightPlayer','$idCountry')";
          $result = $conn->query($sql);
          if (!$result) {
      		echo 'Could not run query: ' . mysql_error();
      		exit;
        }*/
}

?>
<html ng-app="AngularGoogleMap">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="js/lib/angular.min.js"></script>

    <script src="http://maps.google.com/maps/api/js?sensor=false"></script>

    <script src="js/lib/lodash.underscore.min.js"></script>
    <script src="js/lib/angular-google-maps.min.js"></script>

    <script src="js/map-module.js"></script>

    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css"
    rel="stylesheet" type="text/css">
    <link href="css/estiloTemplate.css" rel="stylesheet" type="text/css">

    <style>
        .angular-google-map-container {
            height: 100%;
            width: 100%;
            position: absolute;
        }
    </style>

  </head>

  <body ng-controller="MapCtrl">
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
        <div class="container col-md-12">
          <div class="row">
            <div class="col-md-6">
              <img src="img/casaTemplate.jpg" class="img-responsive" width="540">
            </div>
            <div class="col-md-6">
              <h3>Descripción</h3>
              <p><?php echo $description; ?></p>
              <h3 class="col-md-5">Precio</h3>
              <h3 class="col-md-3">Tipo</h3>
              <h3 class="col-md-4">Destacada</h3>
              <h4 class="col-md-5">$
                <span><?php echo $price; ?></span>
              </h4>
              <h4 class="col-md-3"><?php echo $idType; ?></h4>
              <h4 class="col-md-4"><?php echo $destacada; ?></h4>
              <a href="#" class="btn btn-md btn-primary col-md-12">Me Interesa</a>
            </div>
          </div>
          <br>
          <div class="btn-group">
            <a href="#" class="btn btn-info btn-lg">Características</a>
            <a href="#" class="btn btn-info btn-lg">Ubicación</a>
          </div>
          <div class="row">
            <!-- Start list -->
            <br>
            <div class="col-md-12">
              <ul class="media-list">

                <?php
                $sql = "select description from characteristic where idProperty=$idProperty";
                $result = $conn->query($sql);
                if (!$result) {
                	echo 'Could not run query: ' . $conn->error;
                	exit;
                }

                while($row = $result->fetch_row()){
                    echo '<li class="media"><div class="media-body"><p>-'.$row[0].'</p></div></li>';
                }
                ?>

                <!-- <li class="media">
                  <div class="media-body">
                    <p>-El jardin tiene zacate sintético. Mi esposa es alérgica al real.</p>
                  </div>
              </li> -->
              </ul>
            </div>
            <!-- End list -->
            <!-- Start GMaps -->
            <div class="col-md-8 col-md-offset-2" style="width:750px;height:500px">
              <google-map  center="map.center"
                      zoom="15"
                      draggable="true"
                      options="map.options"
                      control="map.control">
                  <marker coords="marker.coords" options="marker.options" idkey="marker.id" ></marker>
              </google-map>
            </div>
            <!-- End GMaps -->
          </div>
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
                <a href="#"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </body>

</html>
