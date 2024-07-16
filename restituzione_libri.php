
<?php

    $error="";
    if ($_SERVER["REQUEST_METHOD"] == "POST") { 
        if (count($_POST) > 0) {
            $dbw = mysqli_connect("localhost", "uReadWrite", "SuperPippo!!!", "biblioteca");
           //$conn = mysqli_connect('localhost', 'root', '', 'utenti');

    // INUTILE MA MESSA UGUALMENTE   (SE VUOI TOGLILA)
            if(!$dbw){
                $error = "errore col DB";
                $_SESSION["errore_restituzione"] = $error;
                header("Location: libri.php");
                exit();
            } 
// ESTRAGGO I DUE VALORI CHE HO PASSATO NELL'ARRAY (DATA E ID DEL LIBRO SELEZIONATO PER LA RESTITUZIONE)        
            $keys = array_search('RESTITUISCI', $_POST);
            $array= explode("," , $keys);
            $data = $array[0];
            $newData= str_replace("_", " ", $data);
            //echo "il dato e': ".$newData;
            //echo is_string($data);
            //$arrayData= explode("_", $data);
            //print_r ($arrayData);
            $id = $array[1];
            $sql = "UPDATE books SET prestito = NULL, data = NULL, giorni=NULL WHERE id=" . $id . ";";
            mysqli_query($dbw, $sql);    
            mysqli_close($dbw);           
        }else{
            header("Location: libri.php");
        }
    }
 // CONTROLLO CHE QUALCUNO NON ABBIA CERCATO DI ACCEDERE ALLA PAGINA SEMPLICEMENTE SCRIVENDO IL NOME DELLA STESSA SULLA BARRA DI RICERCA         
    else{
        header("Location: libri.php");
    }

?>

<!-- LO INSERISCO SUCCESSIVAMENTE PER EVITARE IL PROBLEMA DI NON AVERE IL VALORE DEL NUMERO DI LIBRI IN PRESTITO NON AGGIORNATO IN QUESTA PAGINA
     DUNQUE MI CONNETTO INIZIALMENTE AL DB SOLO PER AGGIORNARE LA RESTITUZIONE NEL DB E SUCCESSIVAMENTE CARICO header.php -->

<?php
    define("TITLE", "Restituzione");
    include('header.php');
?>

<div>
    <div class="container-avviso-libri">
        <h1 style="color:yellow">RESTITUZIONE ESEGUITA CON SUCCESSO DOPO 
        <?php
    //NEL CASO SIA MENO DI UN GIORNO ( ANCHE PER POCHI SECONDI ) COMUNQUE SARA' ARROTONDATO AD UN GIORNO    
            //$durataprestito = ceil((time() - strtotime($newData)) / 60 / 60 / 24);
            $durataprestito = (time() - strtotime($newData));
            //$durataprestito = date_diff(time(),date_create($newData)); 
            //echo "data: ".strtotime($newData)."<br>";
            //$time = date ( 'j g:i:s', $durataprestito );
            echo secondsToWords($durataprestito);
            //echo $durataprestito;
        ?>
        </h1>
        <br>
        <button onclick="window.location.href = 'libri.php';" class="btn-dark">RITORNA</button>
    </div>
</div>

<?php
    function secondsToWords($seconds)
    {
        $ret = "";
    
        /*** get the days ***/
        $days = intval(intval($seconds) / (3600*24));
        if($days> 0)
        {
            $ret .= "$days days ";
        }
    
        /*** get the hours ***/
        $hours = (intval($seconds) / 3600) % 24;
        if($hours > 0)
        {
            $ret .= "$hours hours ";
        }
    
        /*** get the minutes ***/
        $minutes = (intval($seconds) / 60) % 60;
        if($minutes > 0)
        {
            $ret .= "$minutes minutes ";
        }
    
        /*** get the seconds ***/
        $seconds = intval($seconds) % 60;
        if ($seconds > 0) {
            $ret .= "$seconds seconds";
        }
    
        return $ret;
    }

?>

<?php
    include('footer.php');
?>