<?php



//**EXEMPLO DE FUNCIONAMENTO*** $Connection = new mysqli( 'localhost', 'usuario', 'senha', 'nome_da_db' );



$conexao = mysqli_connect("localhost", "root", "", "optodo4");



if(mysqli_connect_errno()){

	echo 'Erro na conexão:'.mysqli_connect_errno();

}



?>