

<?php
    session_start();
    include('db_connect.php');
?>



<?php
    if (isset($_POST["prestito"])) {

        if (!empty($_POST["numgiorni"]) && is_numeric($_POST["numgiorni"])){
        
            if (!empty($_POST["checkbox"])) {
                
                foreach ($_POST["checkbox"] as $selected) {
                    
                    $sql = "UPDATE books SET prestito = '" . $_SESSION["login_user"] . "',data=NOW(),giorni='" . $_POST["numgiorni"] . "'  WHERE id=$selected;";
                    mysqli_query($dbw, $sql);
        
                }
            }else {
                $_SESSION["errore_prestito"] = "Selezionare almeno un libro";
            }
        }
        else{
            $_SESSION["errore_prestito"] = "Inserire il numero di giorni (IN FORMATO NUMERICO)";
        }
            
        header("Location:libri.php");
       
// CONTROLLO NEL CASO IN CUI QUALCUNO ACCEDA SCRIVENDO LA PAGINA NELL'URL
    }else{
        header("Location: libri.php");
    }
?>

