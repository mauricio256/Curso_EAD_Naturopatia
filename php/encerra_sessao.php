<?php
    session_start();
    if( isset($_SESSION['Usuario']) ):
        unset($_SESSION['Usuario']);
        header('Location:../login_aluno.php');
    endif; 