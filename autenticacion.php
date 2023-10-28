<?php
session_start();

function esta_autenticado()
{
    return isset($_SESSION['idSession']);
}

if (esta_autenticado()) {
    echo "El usuario está autenticado.";
} else {
    echo "El usuario no está autenticado.";
}