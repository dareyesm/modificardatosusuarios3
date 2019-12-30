<?php

echo $_GET['link'];

//procedemos a activar el usuario

require 'class/database.php';

$objData = new Database();

$sth = $objData->prepare('UPDATE users SET status = :status WHERE idActiveCode = :code');

$status = 'Enabled';
$code = $_GET['link'];

$sth->bindParam(':status', $status);
$sth->bindParam(':code', $code);

$sth->execute();

