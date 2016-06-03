<?php

$_SESSION['server'] = 'localhost';
$_SESSION['username'] = 'root';
$_SESSION['password'] = 'mysql123';
$_SESSION['dbname'] = 'bienesraicescr';

// Crea una nueva conexión
$conn = new mysqli($_SESSION['server'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['login'])){
    $logUser = $_POST["logUser"];
    $logPass = $_POST["logPass"];

    $sql = "SELECT idUser, name, lastName FROM users WHERE (username='$logUser') and (password='$logPass');";
    $result = $conn->query($sql);
    if (!$result) {
    	echo 'Could not run query(log): ' . $conn->connect_error;
    	exit;
    }

    if($row = $result->fetch_row()){
        $idUser = $_SESSION["idUser"] = $row[0];
        $_SESSION["name"] = $row[1];
        $_SESSION["lastName"] = $row[2];

        header("Location: ./myProperties.php?idUser=$idUser");
        exit();
    }else{
        echo "Error en el inicio de sesion.";
    }
}

if(isset($_POST['register'])){
    $regUser = $_POST['regUser'];
    $regPass = $_POST['regPass'];
    $regDate = $_POST['regDate'];
    $regMail = $_POST['regMail'];
    $regPhone = $_POST['regPhone'];
    $regLast = $_POST['regLast'];
    $regName = $_POST['regName'];

    $sql = "INSERT INTO users (name,lastName,username,password,email,birthdate,phone)
	VALUES ('$regName', '$regLast', '$regUser', '$regPass', '$regMail', '$regDate', '$regPhone');";
    $result = $conn->query($sql);
    while(true){
        if (!$result) {
            echo 'Could not run query(reg): ' . $conn->connect_error;
            break;
        }

        if($result > 0){
            $sql = "SELECT idUser, name, lastName FROM users WHERE (username='$regUser') and (password='$regPass');";
            $result = $conn->query($sql);
            if (!$result) {
            	echo 'Could not run query(log): ' . $conn->connect_error;
            	exit;
            }

            if($row = $result->fetch_row()){
                $idUser = $_SESSION["idUser"] = $row[0];
                $_SESSION["name"] = $row[1];
                $_SESSION["lastName"] = $row[2];
            }else{break;}

            header("Location: ./myProperties.php?idUser=$idUser");
            exit();
        }else{
            echo "Error en el inicio de sesion.";
        }
        break;
    }
}


?><html><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://raw.githubusercontent.com/moment/moment/develop/src/moment.js"></script>
    <script type="text/javascript" src="https://raw.githubusercontent.com/twbs/bootstrap/master/js/collapse.js"></script>
    <script type="text/javascript" src="https://raw.githubusercontent.com/twbs/bootstrap/master/js/transition.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
                <a href="./loginRegister.php">INICIO</a>
              </li>
              <li class="active">
                <a href="./sales.php">VENTA</a>
              </li>
              <li>
                <a href="./sales.php">ALQUILER</a>
              </li>
              <li>
                <a href="./search.php">BÚSQUEDA</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="section section-Content">
        <div class="container">
          <div class="row col-md">
            <div class="col-md-5 col-md-offset-1">
              <form role="form" method="post" action="./loginRegister.php">
                <div class="form-group">
                  <label class="control-label" for="loginUser">Nombre de Usuario</label>
                  <input class="form-control" name="logUser" id="loginUser" placeholder="Ingrese nombre de usuario" type="text">
                </div>
                <div class="form-group">
                  <label class="control-label" for="loginPass">Contraseña</label>
                  <input class="form-control" name="logPass" id="loginPass" placeholder="Contraseña" type="password">
                </div>
                <button name="login" type="submit" class="btn btn-primary btn-block">INICIAR SESIÓN</button>
              </form>
            </div>
            <div class="col-md-5">
              <form role="form" method="post" action="./loginRegister.php">
                <div class="form-group col-md-10">
                  <label class="control-label" for="registerUser">Nombre de usuario</label>
                  <input class="form-control" id="registerUser" name="regUser"  placeholder="Ingrese Nombre de Usuario" type="text">
                </div>
                  <div class="form-group col-md-10">
                    <label class="control-label" for="registerName">Nombre del usuario</label>
                    <input class="form-control" id="registerName" name="regName"  placeholder="Ingrese Su Nombre" type="text">
                  </div>
                    <div class="form-group col-md-10">
                      <label class="control-label" for="registerLast">Apellido</label>
                      <input class="form-control" id="registerLast" name="regLast"  placeholder="Ingrese Su Apellido" type="text">
                    </div>
                <div class="form-group col-md-6">
                  <label class="control-label" for="registerPass">Contraseña</label>
                  <input class="form-control" id="registerPass"  name="regPass" placeholder="Contraseña" type="password">
                </div>
                <div class="form-group col-md-6">
                  <label class="control-label" for="registerPassCheck">Repita Contraseña</label>
                  <input class="form-control" name="regPass2"  id="registerPassCheck" type="password" placeholder="Repita la contraseña">
                </div>
                <div class="form-group col-md-12">
                  <label class="control-label" for="registerBirth">Fecha de Nacimiento</label>
                  <div class="input-group date" id="registerBirth">
                    <input type="text" class="form-control"  name="regDate" placeholder="yyyy-mm-dd">
                    <span class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                    </span>
                  </div>
                  <script type="text/javascript">
                    $(function () {
                            $('#registerBirth').datetimepicker({
                                viewMode: 'years',
                                format: 'YYYY-MM-DD'
                            });
                        });
					/* https://eonasdan.github.io/bootstrap-datetimepicker/ */
                  </script>
                </div>
                <div class="form-group col-md-6">
                  <label class="control-label" for="registerMail">Correo Electrónico</label>
                  <input class="form-control" name="regMail"  id="registerMail" placeholder="Correo" type="email">
                </div>
                <div class="form-group col-md-6">
                  <label class="control-label" for="registerPhone">Teléfono</label>
                  <input class="form-control" name="regPhone" id="registerPhone" type="text" placeholder="88888888">
                </div>
                <button name="register" type="submit" class="btn btn-primary btn-block">REGISTRARSE</button>
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
