

<?php
    session_start();
    include('db_connect.php');
    $username= $password='';
    $errors=[];
    $usernameRegex = "/(?=.*[a-zA-Z%])(?=.*[0-9])^[a-zA-Z%]{1}[a-zA-Z0-9%]{2,5}$/";
    $password_regex = "/(?=.*[a-z])(?=.*[A-Z])(?!.*[0-9])^[a-zA-Z]{4,8}$/";
?>


<?php


// SIGN UP USER

if (isset($_POST['registrazione'])) {

// CONTROLLO SULL'INSERIMENTO DEL NOME UTENTE

    if (empty($_POST['username'])) {

        $errors['username'] = 'Nome utente non inserito';

    }else {

        if(!preg_match($usernameRegex, $_POST["username"])){
            $errors['username'] = "L'username non rispetta i criteri stabiliti";
        } 
    }

// CONTROLLO SULL'INSERIMENTO DELLE PASSWORD   
    if (empty($_POST['pass'])) {
        $errors['pass'] = 'Password required';
    }else{
        if (!preg_match($password_regex , $_POST['pass'])){
            $errors['pass'] = 'La password non rispetta i criteri richiesti';
        } else{
            if ($_POST['pass'] !== $_POST['passAgain']) {
                $errors['passAgain'] = "Non c'è corrispondenza fra le due password inserite";
            }
        }
    }



// NEL CASO NON CI SIANO PROCEDO CON LE SUCCESSIVE OPERAZIONI, ALTRIMENTO RITORNO DIRETTAMENTE NELLA SEZIONE DI REGISTRAZIONE E VISUALIZZO GLI ERRORI
    if (count($errors) == 0) {

     // escape sql chars

        $username = test_input($_POST['username']);
        //$username = mysqli_real_escape_string($dbr, $_POST['username']);

    // create sql (to retrieve an user from DB in case the user already exists)

        $sql = "SELECT * FROM users WHERE username='$username'";
    
        $result = mysqli_query($dbr, $sql);


// Controllo nel caso in cui l'utente esista già nel DB

        if (mysqli_num_rows($result) > 0 ) {

            $errors['username'] = "Utente già presente nel DB";
            $_SESSION["errori"]= $errors;

        } else {

        // escape sql chars

            $password = test_input($_POST['pass']);
            //$password = mysqli_real_escape_string($dbw, $_POST['pass']);

        // create sql (to insert an user inside the DB)
        
            $sql = "INSERT INTO users(username, pwd) VALUES('$username','$password')";    

        // save to db and check
        
            if(mysqli_query($dbw, $sql)){

            // success
                //$_SESSION["userId"] = "utente";
                $_SESSION["successoRegistrazione"]= "registrato";
                header("Location: successo_registrazione.php");
                exit();

            } else {

            // fail
                $errors["DB"] = (string)mysqli_error($dbw);
                $_SESSION["errori"]= $errors;

            }
        }
    }
    else{

        $_SESSION["errori"]= $errors;

    }

    header('Location: registrazione.php');
    exit();
} 

//END SIGN UP USER




//LOGIN USER

if (isset($_POST['login'])) {

// IL CONTROLLO SE I CAMPI SIANO VUOTI LO FACCIAMO ALL'INTERNO DELLA PAGINA "LOGIN.PHP TRAMITE SCRIPT IN JAVASCRIPT"
// INOLTRE NON VIENE EFFETTUATO NESSUN TIPO DI CONTROLLO SUL TIPO DI DATI INSERITI PERCHE' SARA' FATTO NEL FILE REGISTRAZIONE.PHP
// L'UNICA COSA CHE VERRA' FATTA SARA' QUELLA DI PULIRE IL TIPO DI USER E PASS INSERITI (PER EVITARE QUALCHE TIPO DI INJECTION) TRAMITE LA FUNZIONE "test_input()"

    //$username = filter_var($_POST["user_name"], FILTER_SANITIZE_STRING);
    //$password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
  
    $username = test_input($_POST["user_name"]);
    $password = test_input($_POST["password"]);

    $sql = "SELECT * FROM users WHERE username = '$username' and pwd = '$password'";
    $result = mysqli_query($dbr, $sql);
      
    $count = mysqli_num_rows($result);
    
// If result matched $username and $password, table row must be 1 row
    
    if($count == 1) {

        $_SESSION['login_user'] = $username;
        $cookie_name = "user";
        $cookie_value = $username;

    // Cookie settato per due giorni    
        setcookie($cookie_name, $cookie_value, time() + (86400 * 2), "/");

    //setcookie($cookie_name, $cookie_value, time() + (600), "/"); (cookie per dieci minuti)
        header("Location: libri.php");

    }else {

        $errors["Login"] = "Your Login Name or Password is invalid";
        $_SESSION["errorMessage"]= $errors;
        header("Location: login.php");

    }

}

// END LOGIN USER


?>



<!-- FUNZIONE PER PULIRE I DATI -->

<?php
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>