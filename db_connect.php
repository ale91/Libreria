<?php 

// Connessione al DB
	define("DB_SERVER", "localhost");
	define("DB_USERNAME_RW", "uReadWrite");
	define("DB_USERNAME_RO", "uReadOnly");
	define("DB_PASSWORD_RW", "SuperPippo!!!");
	define("DB_PASSWORD_RO", "posso_solo_leggere");
	define("DB_DATABASE", "biblioteca");
	$dbw = mysqli_connect(DB_SERVER, DB_USERNAME_RW, DB_PASSWORD_RW, DB_DATABASE);
	$dbr = mysqli_connect(DB_SERVER, DB_USERNAME_RO, DB_PASSWORD_RO, DB_DATABASE);

	//$conn = mysqli_connect('localhost', 'root', '', 'utenti');

// Controllo connessione (azione non definita ma potrebbe essere necessario farlo)
	if(!$dbr || !$dbw){
		/**/
	}
	if(isset( $_SESSION['login_user'])){
		$utente = $_SESSION['login_user'];
		$sql = "SELECT id FROM books WHERE prestito = '$utente'";
		$result = mysqli_query($dbr, $sql);
		$count = mysqli_num_rows($result);
	}else
	{
		$count =0;
	}

?>