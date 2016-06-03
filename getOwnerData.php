<?php
session_start();

$conn = new mysqli($_SESSION['server'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$idProp = $_GET['idProperty'];

$sql = "SELECT u.name, u.lastName, u.email, u.phone FROM users u INNER JOIN property p
    ON (u.idUser=p.idUser) WHERE (p.idProperty=$idProp);";
$result = $conn->query($sql);
if (!$result) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
while($row = $result->fetch_row()){
    $name = $row[0];
    $lastName = $row[1];
    $email = $row[2];
    $phone = $row[3];
}
?>
<html>
<head>
<script type="text/javascript">
    function createMessage(pName, pText){
        alert("Información del vendedor:\n\n" + pName + "\n" + pText);
    };
    createMessage('<?php echo $name ?> <?php echo $lastName ?>', '<?php echo $phone ?>\n<?php echo $email ?>');
</script>
</head>
<body>
</body>
</html>
