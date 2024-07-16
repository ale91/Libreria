
<?php
    define("TITLE", "New");
    include('header.php');
?>


<!-- CONTROLLO INSERITO PER EVITARE DI POTER ACCEDERE A QUESTA PAGINA SEMPLICEMENTE SCRIVENDONE IL NOME SULL'URL -->

<?php
    if (isset($_SESSION["successoRegistrazione"])):
?>

<div class="container-avviso-libri">
    <h1 style="color:yellow">REGISTRAZIONE AVVENUTA CON SUCCESSO</h1>
    <br>
    <button style="align:center" onclick="window.location.href = 'login.php';" class="btn-dark">LOGIN</button>
</div>

<?php
        unset($_SESSION["successoRegistrazione"]);
    else:
        header("Location: registrazione.php");
    endif;
?>

<?php
    include('footer.php');
?>
