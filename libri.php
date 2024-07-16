
<?php
    define("TITLE", "Libri");
    include('header.php');
    $libriDisponibili=[];
// LA VARIABILE $libriPrestati NON VIENE USATA, QUINDI SI PUO' ELIMINARE QUANDO NON CI SARANNO PIU' CONTROLLI DA FARE  
    $libriPrestati=[];
    $libriTotali=[];
    $errors=[];
    $risultato="";
    $dateID=[];
?>

<?php

    if (!isset($_SESSION["login_user"])) {
        header("Location: login_reindirizza.php");
        //exit(); 
    }else{
        $sql = "SELECT * FROM books"; 
        $result = mysqli_query($dbr, $sql);
        while ($row = mysqli_fetch_assoc($result)){
            if($row["prestito"]==""){
                array_push ($libriDisponibili, $row);
            }
            elseif($row["prestito"]==$_SESSION["login_user"]) {
                array_push($libriPrestati, $row);
            }
            array_push($libriTotali, $row);
        }
    }
   
// E' STATA FATTA UNA DIFFERENZIAZIONE FRA I DUE TIPI DI ERRORI PERCHE' GESTITI IN DUE PAGINE DIFFERENTI
// E' OVVIAMENTE POSSIBILE UNIRE I CONTROLLI IN UN'UNICA PAGINA COSì COME FATTO PER REGISTRAZIONE E LOGIN    

    if(isset($_SESSION["errore_prestito"])){
        array_push($errors, $_SESSION["errore_prestito"]);
        unset($_SESSION["errore_prestito"]);
    }

    if(isset($_SESSION["errore_restituzione"])){
        array_push($errors, $_SESSION["errore_restituzione"]);
        unset($_SESSION["errore_restituzione"]);
    }

?>

<!-- CONTROLLO NEL CASO IN CUI NON CI SIANO LIBRI IN PRESTITO DA PARTE DELL'UTENTE --> 
<div>
    BENVENUTO NELLA SEZIONE LIBRI
    <br><br><br><br><br>
    <?php
        if(empty($libriPrestati)):
            echo "NON HAI LIBRI IN PRESTITO";
        else:
    ?>
    LIBRI IN PRESTITO
    <br><br> 
    <form method="post" action="restituzione_libri.php">
        <table id="libri">
            <tr>
                <th style="text-align:center">Autore</th>
                <th style="text-align:center">Titolo</th>
                <th style="text-align:center">Prestito</th>
            </tr>
            <?php
                for($i=0; $i<count($libriPrestati); $i++):
            ?>
            <tr>
                <td style="text-align: center"><?php echo $libriPrestati[$i]["autori"]; ?></td>
                <td style="text-align: center"><?php echo $libriPrestati[$i]["titolo"]; ?></td>   
                <?php
                    echo "<td style='text-align: center'><input type='submit' name=\"" . $libriPrestati[$i]["data"] . "," . $libriPrestati[$i]["id"] . "\" value='RESTITUISCI'></td>";
                ?>
            </tr>
            <?php
                endfor;
            ?>
        </table>
    </form>
    <?php
        endif;
    ?>
    <br><br><br><br>
    LIBRI PRESENTI NELLA BIBLIOTECA
    <br><br>   
    <form method="post" action="prestito_libri.php" >
        <table id="libri">
            <tr>
                <th style="text-align:center">Autore</th>
                <th style="text-align:center">Titolo</th>
                <th style="text-align:center">Prestito</th>
            </tr>
            <?php
                for($i=0; $i<count($libriTotali); $i++):
            ?>
                <tr>
                    <td style="text-align: center"><?php echo $libriTotali[$i]["autori"];?></td>
                    <td style="text-align: center"><?php echo $libriTotali[$i]["titolo"];?></td>
                    <?php 
                        if($libriTotali[$i]["prestito"]==""){
                            echo "<td style='text-align: center'>
                            <input type='checkbox' name='checkbox[]' value='" . $libriTotali[$i]["id"] . "'>
                            </input></td>";
                        }
                        else {
                            if($_SESSION["login_user"] == $libriTotali[$i]["prestito"] ){
                                if (time() - strtotime($libriTotali[$i]["data"]) > $libriTotali[$i]["giorni"] * 60 * 60 * 24){
                                    echo "<td style='text-align: center'>PRESTITO SCADUTO</td>";
                                }
                                else{ 
                                    echo "<td style='text-align: center'>IN PRESTITO</td>";
                                }
                            }else{  
                                echo "<td style='text-align: center'>NON DISPONIBILE</td>";
                            }
                        }
                    ?>
                </tr>
            <?php
                endfor;
            ?>
        </table>
        <div style="text-align:center; margin-top:20px">
            <input type="text" name="numgiorni" placeholder="Inserisci numero giorni prestito">
            <input type="submit" name="prestito" value="PRESTITO">
            <?php if (count($errors) > 0): ?>
                <div class="alert alert-danger" style="text-align:center; margin-bottom:40px">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach;?>
                </div>
            <?php endif;?>
        </div>  
    </form>    
</div>

<script>    

// DEFINISCO IL CONTROLLO DEL NUMERO DI LIBRI SELEZIONABILE DISABILITANDO LE CHECKBOX QUANDO IL NUMERO DI LIBRI TOTALI (POSSEDUTI E SELEZIONATI)
// VA' OLTRE IL NUMERO MASSIMO STABILITO, CIOE' 3

    var count = <?php echo $count ?>;

    document.addEventListener('DOMContentLoaded', () => {
        
        if(count ==3){
            let Checkboxes = document.querySelectorAll('input[type="checkbox"]');
            disable();    
        }
        else{
            let Checkboxes = document.querySelectorAll('input[type="checkbox"]')

            Checkboxes.forEach( checkbox => {
                checkbox.addEventListener('click', (event)=>{
                    if(checkbox.checked){
                        checkboxLimiter();
                    }
                    else{
                        getFree();
                    }
                });
            });
        }
    });


    function getFree(){
        let unmarkedBoxCount = document.querySelectorAll('input[type="checkbox"]:not(:checked)');

        unmarkedBoxCount.forEach(checkbox => {
            checkbox.disabled = false;
        })
    }

    function checkboxLimiter() {
        let markedBoxCount = document.querySelectorAll('input[type="checkbox"]:checked').length;
        
        if ((markedBoxCount+count) >= 3){
            disable();
        }
    }

    function disable() {
        let unmarkedBoxCount = document.querySelectorAll('input[type="checkbox"]:not(:checked)');

        unmarkedBoxCount.forEach(checkbox => {
            checkbox.disabled = true
        })
    }

</script>

<?php
    include('footer.php');
?>