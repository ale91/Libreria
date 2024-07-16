<?php

// LA SESSIONE VA' INSERITA ALTRIMENTI NON TROVA LE VARIABILI DI SESSIONE QUANDO LE CERCA
// OLTRETUTTO NON E' NEANCHE IN GRADO DI DISTRUGGERE LA SESSIONE PERCHE' NON SA QUALE SIA
    session_start();
    include("db_connect.php");

    //if (isset($_GET['logout'])) {
        session_unset();
        session_destroy();
        mysqli_close($conn);   
        header("Location: login.php");
        //exit();
    //}
?>