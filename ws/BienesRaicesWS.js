// Connect to VM
//http://serverfault.com/questions/225155/virtualbox-how-to-set-up-networking-so-both-host-and-guest-can-access-internet

var express = require('express');
var app = express();
var mysql = require('mysql');

var connData = {
	  host     : 'localhost',
	  user     : 'root',
	  password : '123456',
	  database : 'BiRaDb'
	}

/*
var connection = mysql.createConnection({
	host     : 'localhost',
	user     : 'root',
	password : '123456',
	database : 'mydb'
});

connection.connect();
*/

app.get('/getHacked', function (req, res) {
  res.send('gotHacked D:');
});

app.get('/listarDatos', function (req, res) {
	var connection = mysql.createConnection(connData);
	connection.connect();

	connection.query('SELECT * FROM users;', function(err, rows, fields) {
	  if (!err){
		console.log('The solution is: ', rows);
		resultadoVital = "La base retorna: \n";
		for(i = 0; i < rows.length; i++){
			resultadoVital += rows[i].name + " - " + rows[i].email + "\n";
		}
		res.send(resultadoVital);
	  }else
		console.log('Error while performing Query.');
	});

	connection.end();

});


app.get('/listarDatosSP', function (req, res) {


	var connection = mysql.createConnection(connData);
	connection.connect();

	connection.query('call BiRaDb.getProperties();', function(err, rows, fields) {
	  if (!err){
		console.log('The solution is: ', rows, 'lololol', fields);
		resultadoVital = "La base retorna: <br>";
		for(i = 0; i < rows[0].length; i++){
			resultadoVital += rows[0][i].name + " - " + rows[0][i].price + "<br>";
		}
		res.send(resultadoVital);
	  }else
		console.log('Error while performing Query.');
	});

	connection.end();

});


//sql.connect("mssql://<user><:password>@<hostAddr:port>/<dbName>").then(function() {
/*sql.connect("mssql://sa:unodostres@192.168.102.130:1433/whetwhetwhet").then(function() {

	console.log("Trying to retrieve data");

    // Query
    new sql.Request().query('select * from dbo.tabla').then(function(recordset) {
        //console.dir(recordset);
        res.send(recordset)
		console.log("Se retornó la vara tuanis");
    }).catch(function(err) {
        res.send('Se cayó la maire: ' + err);
    });
}).catch(function(err) {
    res.send('No se pudo conectar por: ' + err);
});*/

app.get('/androidTest', function (req, res) {
//	res.send('{"val1":"tomela","val2":"con leche"}');
	res.setHeader('Content-Type', 'application/json');
    res.send(JSON.stringify({"val1":"pedido desde el WS","val2":"tomela con leche"}, null, 3));
});

app.get('/listarConGET', function (req, res) {
	res.send("Se recibe como parámetro con GET: " + req.query.param1);
});


app.listen(5003, function () {
  console.log('Example app listening on port 5003!');
});
