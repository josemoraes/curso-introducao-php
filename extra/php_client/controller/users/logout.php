<?php 
session_start();
session_unset(); //Remove todas as variáveis da sessão
session_destroy(); // Destrói a sessão

header('Location: http://appcurso.local/index.php');