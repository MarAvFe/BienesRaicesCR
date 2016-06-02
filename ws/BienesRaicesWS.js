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

app.get('/getRecipe', function (req, res) {
	var jsonStr = {};
	var connection = mysql.createConnection(connData);
	connection.connect();

	connection.query('call tastyv1.getRecipe("'+req.query.nombre+'");', function(err, rows, fields) {
	  if (!err){
		jsonStr.name = rows[0][0].Name;
		jsonStr.description = rows[0][0].Description;
		jsonStr.linkYT = rows[0][0].youtubeLink;
		jsonStr.shared = rows[0][0].shared;
		console.log('Returned getRecipe("'+req.query.nombre+'");');

		res.setHeader('Content-Type', 'application/json');
	    res.send(JSON.stringify(jsonStr));
	  }else
		console.log('Error while performing Query.');
	});

	connection.end();
	/*res.setHeader('Content-Type', 'application/json');
    res.send( JSON.stringify(jsonStr) );*/
});

app.get('/getIngredients', function (req, res) {
	var jsonStr = {};
	var connection = mysql.createConnection(connData);
	connection.connect();

	connection.query('call tastyv1.getIngredients("'+req.query.nombre+'");', function(err, rows, fields) {
	  if (!err){
		arreglo = [];
		for(i = 0; i < rows[0].length; i++){
			arreglo[i] = rows[0][i].description;
		}
		jsonStr.lista = arreglo;
		console.log('Returned getIngredients("'+req.query.nombre+'");');

		res.setHeader('Content-Type', 'application/json');
	    res.send(JSON.stringify(jsonStr));
	  }else
		console.log('Error while performing Query: ' + err.message);
	});
	connection.end();
	/*res.setHeader('Content-Type', 'application/json');
    res.send( JSON.stringify(jsonStr) );*/
});

app.get('/getProperties', function (req, res) {
	var jsonStr = {};
	var connection = mysql.createConnection(connData);
	connection.connect();

	connection.query('call getProperties();', function(err, rows, fields) {
	  if (!err){
		descriptions = [];
		idProps = [];
		names = [];
		prices = [];
		typeSales = [];
		for(i = 0; i < rows[0].length; i++){
			descriptions[i] = rows[0][i].description;
			idProps[i] = rows[0][i].idProperty;
			names[i] = rows[0][i].name;
			prices[i] = rows[0][i].price;
			typeSales[i] = rows[0][i].typesale;
		}
		jsonStr.description = descriptions;
		jsonStr.idProps = idProps;
		jsonStr.names = names;
		jsonStr.prices = prices;
		jsonStr.typeSales = typeSales;
		console.log('Returned getProperties();');

		res.setHeader('Content-Type', 'application/json');
	    res.send(JSON.stringify(jsonStr));
	  }else
		console.log('Error while performing Query: ' + err.message);
	});
	connection.end();
});

app.get('/login', function (req, res) {
	var jsonStr = {};
	var connection = mysql.createConnection(connData);
	connection.connect();

	connection.query('call loggin("' + req.query.pUser + '", "' + req.query.pPass + '");', function(err, rows, fields) {
	  if (!err){
		lastNames = [];
		names = [];
		idUsers = [];
		for(i = 0; i < rows[0].length; i++){
			lastNames[i] = rows[0][i].lastName;
			names[i] = rows[0][i].name;
			idUsers[i] = rows[0][i].idUser;
		}
		jsonStr.lastNames = lastNames;
		jsonStr.names = names;
		jsonStr.idUsers = idUsers;
		console.log('Returned loggin("' + req.query.pUser + '", "' + req.query.pPass + '");');

		res.setHeader('Content-Type', 'application/json');
	    res.send(JSON.stringify(jsonStr));
	  }else
		console.log('Error while performing Query: ' + err.message);
	});
	connection.end();
});

app.get('/listarConGET', function (req, res) {
	res.send("Se recibe como parámetro con GET: " + req.query.param1);
});

app.get('/getRecipes', function (req, res) {
	var jsonStr = {};
	var recipesType = req.query.param; // 0-All 1-New 2-Favorite 3-Top
	var procedureCall;
	var connection = mysql.createConnection(connData);
	connection.connect();

	switch(recipesType) {
		case "0":
		    procedureCall = 'call tastyv1.getAllRecipes();';
		    break;
		case "1":
		    procedureCall = 'call tastyv1.getAllRecipes();';//NewRecipes();';
		    break;
		case '2':
		    procedureCall = 'call tastyv1.getAllRecipes();';//FavoriteRecipes();';
		    break;
		case '3':
		    procedureCall = 'call tastyv1.getAllRecipes();';//TopRecipes();';
		    break;
		case '4':
			procedureCall = 'call tastyv1.searchWord("'+req.query.criteria+'");';
			break;
		case '5':
		    procedureCall = 'call tastyv1.searchCategory("'+req.query.criteria+'");';
		    break;
	}

console.log("proc:"+recipesType);
	connection.query(procedureCall, function(err, rows, fields) {
	  if (!err){
		nombres = [];
		descripciones = [];
		links = [];
		for(i = 0; i < rows[0].length; i++){
			nombres[i] = rows[0][i].Name;
			descripciones[i] = rows[0][i].Description;
			links[i] = rows[0][i].youtubeLink;
		}
		jsonStr.names = nombres;
		jsonStr.descriptions = descripciones;
		jsonStr.links = links;
		console.log('Returned getRecipes(); Type: ' + recipesType);

		res.setHeader('Content-Type', 'application/json');
	    res.send(JSON.stringify(jsonStr));
	  }else
		console.log('Error while performing Query: ' + err.message);
	});
	connection.end();
});


app.listen(5003, function () {
  console.log('Example app listening on port 5003!');
});
