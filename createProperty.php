<?php

session_start();

// Crea una nueva conexión
$conn = new mysqli($_SESSION['server'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['regProp'])){
    $regName = $_POST['regName'];
    $regDesc = $_POST['regDesc'];
    $regPrice = $_POST['regPrice'];
    $regType = $_POST['regType'];
    $regUser = $_SESSION['idUser'];
    $regCity = $_POST['regCity'];
    $regLng = 40.454018;//$_POST['regLng'];
    $regLat = 3.509205;//$_POST['regLat'];

    echo "woah";
/*`insertProperty`(pname VARCHAR(100), pdescription VARCHAR(250), pprice DECIMAL,
					pType VARCHAR(45),pUsername VARCHAR(45), pisOutstanding TINYINT, pCity VARCHAR(45),
                    pLongitude FLOAT, pLatitude FLOAT)*/

    $sql = 'insertProperty("'.$regName.'", "'.$regDesc.'", '.$regPrice.', '.$regType.', 2, 1, "'.$regCity.'", '.$regLng.', '.$regLat.')';
    $result = $conn->query($sql);
    while(true){
        if (!$result) {
            echo $sql;
            echo 'Could not run query(reg): ' . $conn->connect_error;
            break;

        }else{
            echo "Error al crear la propiedad";
        }
        break;
    }
}

?><html><head>
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
              <li class="active">
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
      <div class="section section-Content">
        <div class="container">
          <h1 class="col-md-offset-1 text-primary">Agregar propiedad</h1>
          <br>
          <div class="row col-md-12">
            <div class="col-md-12">
              <form class="form-horizontal" role="form" method="post" action="./createProperty.php">
                <div class="form-group">
                  <div class="col-sm-2">
                    <label for="" class="control-label">Nombre</label>
                  </div>
                  <div class="col-sm-10">
                    <input name="regName" type="text" class="form-control" placeholder="">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-2">
                    <label for="" class="control-label">Descripción</label>
                  </div>
                  <div class="col-sm-10">
                    <textarea class="form-control" name="regDesc"  placeholder="" rows="5" style="resize:vertical"></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-2">
                    <label for="" class="control-label">Localización</label>
                  </div>
                  <div class="col-sm-10">
                    <input type="text" name="regCity" class="form-control" placeholder="">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-2">
                    <label for="" class="control-label">Precio</label>
                  </div>
                  <div class="col-lg-10">
                    <div class="input-group">
                      <span class="selectpicker input-group-addon">$</span>
                      <input type="number" class="form-control" name="regPrice"  placeholder="" min="0">
                      <span class="selectpicker input-group-addon">.00</span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-2">
                    <label for="" class="control-label">Tipo</label>
                  </div>
                  <div class="col-sm-10">
                    <select class="selectpicker" id="tipo" data-width="100%" name="regType" >
                      <option value="0">Venta</option>
                      <option value="1">Alquiler</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-2">
                    <label for="" class="control-label">Características</label>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" placeholder="">
                  </div>
                  <div class="col-sm-2">
                    <a href="#" class="btn btn-info btn-md btn-block">Añadir</a>
                  </div>
                  <div class="col-sm-2">
                    <a href="#" class="btn btn-danger btn-md btn-block">Eliminar</a>
                  </div>
                  <div class="col-sm-offset-2 col-sm-10">
                    <select id="tipo" multiple="" size="5" style="width:100%;margin-top:10px">
                      <option>Patio amplio</option>
                      <option>Garaje para 2 carros</option>
                      <option>Jacuzzi</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button name="regProp" type="submit" class="btn btn-primary">ENVIAR</button>
                  </div>
                </div>
              </form>
            </div>
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


</body></html>
