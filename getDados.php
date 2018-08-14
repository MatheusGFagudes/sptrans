<?php
    //Conectando ao banco de dados
$con = new mysqli("localhost", "root", "", "sptrans");
if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());
$latmin = $_POST['latmin'];
$latmax = $_POST['latmax'];
$lngmin = $_POST['lngmin'];
$lngmax = $_POST['lngmax'];

    //Consultando banco de dados
<<<<<<< HEAD
$qryLista = mysqli_query($con, "SELECT * FROM paradas where (stop_lat between $latmin and $latmax) and (stop_lon between $lngmin and $lngmax)");
while ($resultado = mysqli_fetch_assoc($qryLista)) {
    $vetor[] = array_map('utf8_encode', $resultado);
}    
    
=======
    $qryLista = mysqli_query($con, "SELECT * FROM paradas where (stop_lat between $latmin and $latmax) and (stop_lon between $lngmin and $lngmax)");    
    while($resultado = mysqli_fetch_assoc($qryLista)){
        $vetor[] = array_map('utf8_encode', $resultado); 
    }    
   
>>>>>>> 1dff11ab908f393f2adb916d6e7983419be2e547
    //Passando vetor em forma de json
header('Content-type: application/json');
echo json_encode($vetor);

?>