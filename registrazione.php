
<?php
    define("TITLE", "New");
    include('header.php');
?>

<?php

    $errors=[];
    
    /*if(!empty($_SESSION["userId"])) {
        unset($_SESSION["userId"]);
    }*/

    if(!empty($_SESSION["errori"])) {
        $errors = $_SESSION["errori"];
        unset($_SESSION["errori"]); 
    }

?>

    <div style="text-align:center">
        Username: <br> <li>Deve avere una lunghezza minima pari a 3 caratteri e massima pari a 6 caratteri </li>
        <li>Deve iniziare con un carattere alfabetico o con %</li>
        <li>Deve contenere almeno un carattere alfabetico ed uno numerico</li>
        <li>Puo' contenere solo caratteri numerici, alfabetici o il carattere '%'</li>
    </div>   

    <div style="text-align:center; color:black;">
        Password:<br>
        <li>Puo' contenere solo caratteri alfabetici</li>
        <li>Lunghezza compresa fra 4 ed 8 caratteri</li>
        <li>Deve contenere almeno un carattere minuscolo ed uno maiuscolo</li>
    </div>


    <div class="form-container">
        <form method="post" action="registration-action.php">
            <h2>Form Validation</h2>
            <?php if (count($errors) > 0): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?>
                        <li>
                            <?php echo $error; ?>
                        </li>
                    <?php endforeach;?>
                </div>
            <?php endif;?>
            <p><span class="error">* required field</span></p>
            <div class="field-form">  
                <p class="name">Name: </p> <input type="text" name="username" value="<?php echo ""?>">
                <span class="error">* <?php echo ""?></span>
            </div>
            <br><br>
            <div class="field-form">
                <p class="pass">Password: </p> <input type="password" name="pass" value="<?php echo ""?>">
                <span class="error">* <?php echo ""?></span>
            </div>
            <br><br>
            <div class="field-form">
                <p class="repeatPass">Repeat Password:</p><input type="password" name="passAgain" value="<?php echo ""?>">
                <span class="error">* <?php echo ""?></span>
            </div>
            <br><br>
            <input type="submit" name="registrazione" value="Submit" class="btn-dark"> 
            <input type="reset"  name="clear" value="Pulisci" class="btn-dark">
        </form>
    </div>      


<?php
    include('footer.php');
?>