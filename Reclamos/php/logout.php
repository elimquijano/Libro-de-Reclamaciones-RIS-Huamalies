<?php
session_start();
$id = $_GET['id'];
$_SESSION['id_access'] = null;
session_unset();

header('Location: ../login.html');