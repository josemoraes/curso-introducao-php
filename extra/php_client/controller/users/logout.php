<?php 
session_start();
session_unset(); //Remove todas as variáveis da sessão
session_destroy(); // Destrói a sessão

header('Location: http://localhost/php_server/index.php');