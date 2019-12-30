<?php

print_r($_POST);

//conetcamos a la base de datos

require 'class/database.php';

$objData = new Database();

$sth = $objData->prepare('SELECT * FROM users WHERE loginUsers = :login');

$sth->bindParam(':login', $_POST['userN']);

$sth->execute();

$result = $sth->fetchAll();

if($result){
    //echo "El usuario digitado ya existe en la base de datos, por favor digite uno nuevo.";
}else{
    
    //Generamos un codigo de activación
    
    $string = "";
    $posible = "1234567890abcdefghijklmnopqrstuvwxyz_";
    $i = 0;
    while($i < 20){
        $char = substr($posible, mt_rand(0, strlen($posible)-1),1);
        $string .= $char;
        $i++;
    }
    
    //Insertamos los datos del usuario a dar de alta.
    
    $sth = $objData->prepare('INSERT INTO users '
            . 'VALUES (:idU, :login, :passU, :idProfile, :email, :active, :path, :exist, :status)');
    
    $id = "";
    $profile = 2;
    $exist = 0;
    $path = 'public/images/apple_logo2.jpg';
    $status = 'Disabled';
    $sth->bindParam(':idU', $id);
    $sth->bindParam(':login', $_POST['userN']);
    $sth->bindParam(':passU', $_POST['userP']);
    $sth->bindParam(':idProfile', $profile);
    $sth->bindParam(':email', $_POST['userC']);
    $sth->bindParam(':active', $string);
    $sth->bindParam(':path', $path);
    $sth->bindParam(':exist', $exist);
    $sth->bindParam(':status', $status);
    
    $sth->execute();
    
    $para = $_POST['userC'];
    
    $asunto = "Link de activación de Usuario en el Sistema";
    
    $mensaje = "<html lang ='es'>"
            . "<head>"
            . "<title>Link de Activación de Usuario</title>"
            . "<meta charset='utf-8' />"
            . "</head>"
            . "<body>"
            . "Gracias por crear sus usuario en Nuestro Sistema, para poder acceder, debe activar su "
            . "usuario haciendo link en el siguiente enlace: <br>"
            . "<a href='http://localhost:8888/CodigosVideos/10-DatosUsuario3/link_activation.php?link=$string'>"
            . "Activar</a>";
    $mensaje .= "</body>"
            . "</html>  ";
    
    // Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
    
    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    
    // Cabeceras adicionales
    $cabeceras .= 'From: Video Tutoriales dareyesm <darayesm.inc@gmail.com>' . "\r\n";
		
    //Se hace el envío
    mail($para, $asunto, $mensaje, $cabeceras);
    
}
