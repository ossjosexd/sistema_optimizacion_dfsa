<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// enlace simple
// localhost:8000
Route::get('/', function () {
    return view('welcome');
});

//enlace simple con dominio
// localhost:8000/enlace_dominio
Route::get('/enlace_dominio', function () {
	die("Prueba Enlace");
});

//enlace url con parametros
// localhost:8000/enlace_parametro/valor1
Route::get('/enlace_parametro/{var1}', function ($var1) {
	die("Prueba Enlace: " . $var1);
});

//enlace url con parametro
//localhost:8000/enlace_parametro2/valor1/valor2
Route::get('/enlace_parametro2/{var1}/{var2}', function ($var1, $var2) {
	echo "Nombre: " . $var1;
    die("<br>Nacionalidad: " . $var2);
});


//llamada desde otra vista
Route::get('/href', function () {
	die("LLamada desde vista");
});

//enlace llamando vista
// localhost:8000/enlace_vta
Route::get('/enlace_vta', function () {
	$data = ['name' => 'Victoria',
           'apellido'=>'Gil'
			];
	return view("clase",$data);
});

Route::get('/enlace_vta2', function () {
	$data = ['name' => 'Victoria',
		   'apellido'=>'Gil'
			];
	return view("clase2",$data);
})->name('vt2');


Route::get('/prueba/{var1}', function ($var1) {

	$data = ['name' => $var1,
           'apellido'=>'Gil'
			];

    echo "<h1><b>Llamada desde la vista con un enlace</b></h1>";
    echo "<br><br><b>Mostrar un arreglo</b><br>"; 
	print_r($data);

	//return view("clase",$data);
})->name('vt');





/*Route::get('/login', function () {
    return view('login');
});*/