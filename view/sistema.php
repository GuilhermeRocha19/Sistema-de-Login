<?php
session_start();

$nome = $_SESSION['nome'];

echo "Seja bem vindo, $nome!";