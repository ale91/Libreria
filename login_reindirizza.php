<?php
    define("TITLE", "Reindirizza");
    include('header.php');
    $libriDisponibili= [];
    $libriprestati = [];
    $libriTotali = [];
    $sql = "SELECT * FROM books"; 
    $result = mysqli_query($dbr, $sql);
    while ($row = mysqli_fetch_assoc($result)){
        if($row["prestito"]==""){
            array_push ($libriDisponibili, $row);
        }
        array_push($libriTotali, $row);
    }
?>

    <div class="container-avviso-libri">
        <h1 style="color:yellow">PER ACCEDERE ALLA SESSIONE LIBRI E' NECESSARIO EFFETTUARE IL LOGIN</h1>
        <h1 style="color:yellow">IL NUMERO DI  LIBRI DISPONIBILI E': <?php  echo count($libriDisponibili) ?></h1>
        <h1 style="color:yellow">IL NUMERO DI  LIBRI TOTALI E': <?php  echo count($libriTotali) ?></h1>
        <br>
        <button style="align:center" onclick="window.location.href = 'login.php';" class="btn-dark">LOGIN</button>
    </div>

<?php
    include('footer.php');
?>
