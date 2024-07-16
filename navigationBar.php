
<div>
    <ul class="topnav" id="navList">
        <li><a href="home.php" class="<?php if(TITLE =='Homepage'){echo 'active';}?>" >Home</a></li>
        <li><a href="libri.php" class="<?php if(TITLE =='Libri' || TITLE == 'Reindirizza'){echo 'active';}?>">Libri</a></li>
        <?php 
        //if (empty($_SESSION["login_user"])){ ?>
            <li><a href="registrazione.php" class="<?php if(TITLE =='New'){echo 'active';}?>" >Registrazione</a></li>
        <?php
        //} else {
        ?>
          <!--  <li><span>Registrazione</span></li> -->
        <?php
        //}
        ?> 
        <?php 
        if (empty($_SESSION["login_user"])){ ?>  
            <li><a href='login.php' class="<?php if(TITLE =='Login'){echo 'active';}?>">Login</a></li>
        <?php
        } else {
        ?>
        <li><span>Login</span></li>
        <?php
        }
        ?> 
            
        <?php 
        if (!empty($_SESSION["login_user"])) { ?>
            <li><a href='logout.php'>Logout</a></li>
        <?php
        } else {
        ?>
            <li><span>Logout</span></li>
        <?php
        } 
        ?>

        <?php
            if(!empty($_SESSION["login_user"])):
                echo "<li><span class='destra'> Salve ".$utente.". Hai ".$count." libro/i in prestito</span></li>"; 
            else:
                echo "<li><span class='destra'>Utente ANONIMO; Hai 0 libri in prestito</span></li>";
            endif;
        ?>
    </ul>
</div>    

    
   
        




