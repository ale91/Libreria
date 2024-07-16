
<?php
    define("TITLE", "Login");
    include('header.php');
?>

<?php 

    $errors=[];

    if(isset($_SESSION["errorMessage"])){
        $errors = $_SESSION["errorMessage"];
        unset($_SESSION["errorMessage"]); 
    }

?>


<div class="form-container">
    <form action="registration-action.php" method="post" id="frmLogin" onSubmit="return validate();">
        <h2>Login</h2>
            <?php if (count($errors) > 0): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach;?>
                </div>
            <?php endif;?>
        <div class="field-form">
            <div>
                <p> Username: </p> <input name="user_name" id="user_name" type="text" class="demo-input-box"
                    <?php
                        if(isset($_COOKIE["user"])):
                            echo "value='". $_COOKIE["user"]. "'";
                        endif;    
                    ?>
                    >
            </div>
            <span id="user_info" class="error"></span>
        </div>
        <br>
        <div class="field-form">
            <div>
                <p> Password: </p> <input name="password" id="password" type="password" class="demo-input-box">
            </div>
            <span id="password_info" class="error"></span>
        </div>
        <br>
        <div>
            <div>
                <input type="submit" name="login" value="Login" class="btn-dark">
                <input type="reset"  name="clear" value="Pulisci" class="btn-dark" onclick="pulisci()">
            </div>
        </div>
    </form>
</div>    


<script>

// DATO CHE SI USA IL VALORE DEL COOKIE PER LO USERNAME (NEL CASO SIA ANCORA PRESENTE) PER EFFETTUARE LA PULIZIA UTILIZZO LA FUNZIONE pulisci()
// OVVIAMENTE IN CASO DI REFRESH DELLA PAGINA (F5) IL VALORE CONTENUTO NEL COOKIE LO SI RIAVRA' A DISPOSIZIONE

    function pulisci(){
        document.getElementById("user_name").setAttribute("value","");
        document.getElementById("password").innerHTML = "";
    }


    function validate() {
        var $valid = true;
        document.getElementById("user_info").innerHTML = "";
        document.getElementById("password_info").innerHTML = "";
        
        var userName = document.getElementById("user_name").value;

        var password = document.getElementById("password").value;
        if(userName == "") 
        {
            document.getElementById("user_info").innerHTML = " username required";
        	$valid = false;
        }
        if(password == "") 
        {
        	document.getElementById("password_info").innerHTML = "password required";
            $valid = false;
        }
        return $valid;
    }
</script>


<?php

include('footer.php');

?>