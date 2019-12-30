<?php

//Controlando el inicio de la sesión
require'../class/sessions.php';
$objses = new Sessions();
$objses->init();
$nameU = $objses->get('loginUsers');
$idUse = $objses->get('idUser');

$user = isset($nameU) ? $nameU : null ;

if($user == ''){
	header('Location: http://localhost:8888/CodigosVideos/10-DatosUsuario3/index.php?error=2');
}

//conectamos a la base de datos
require'../class/database.php';
$objData = new Database();

//llamar los datos de Login del usuario ingresado
$sth = $objData->prepare('SELECT * FROM users WHERE idUsers = :idUser');
$sth->bindParam(':idUser', $idUse);
$sth->execute();

$result = $sth->fetchAll();

//llamar los datos personales del usuario ingresado
$sth1 = $objData->prepare('SELECT * FROM user_data WHERE idUsers = :idUser');
$sth1->bindParam(':idUser', $idUse);
$sth1->execute();

$result1 = $sth1->fetchAll();

?>
<!DOCTYPE html>
<html lang="es">
	<head>
    	<meta charset="utf-8" />
        <title>Perfil de Usuario</title>
        
    </head>
    
    <body>
        
        <?php echo "Bienvenido, " . $nameU;?>
        
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="profile.php">Perfil</a></li>
            <li><a href="log_out.php">Salir</a></li>
        </ul>
        
        <br>
        
        <form action="modify_profile.php" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Datos de Inicio de Sesión</legend>
                <img src="<?php echo $result[0]['path_imgUser'];?>" width="200" /> <br>
                <label>Nombre de Usuario:</label>
                <input type="text" name="userN" value="<?php echo $result[0]['loginUsers'];?>" /><br>
                <label>Clave de acceso:</label>
                <input type="password" name="userP" /><br>
                <label>Correo electronico:</label>
                <input type="text" name="userC" value="<?php echo $result[0]['emailUser'];?>" /><br>
                <label>Avatar:</label>
                <input type="file" name="userF" /><br>  
                <input type="hidden" name="idUser" value="<?php echo $idUse;?>" />
                <input type="submit" value="ENVIAR" />
            </fieldset>    
        </form>
        
        <form action="modify_data.php" method="POST">
            <fieldset>
                <legend>Datos Personales del Usuario</legend>
                <label>Nombres:</label>
                <?php
                if($result1){?>
                    <input type="text" name="names" value="<?php echo $result1[0]['names'];?>" /><br>
                    <?php
                }else{?>
                    <input type="text" name="names" value="" /><br>
                    <?php
                }
                ?>
                <label>Fecha de Nacimiento:</label>
                <?php
                if($result1){?>
                    <input type="date" name="date" value="<?php echo $result1[0]['bornin'];?>" /><br>
                    <?php
                }else{?>
                    <input type="date" name="date" value="" /><br>
                    <?php
                }
                ?>
                <label>Páis:</label>
                <?php
                if($result1){?>
                    <input type="text" name="country" value="<?php echo $result1[0]['country'];?>" /><br>
                    <?php
                }else{?>
                    <input type="text" name="country" value="" /><br>
                    <?php
                }
                ?>
                <label>Ciudad:</label>
                <?php
                if($result1){?>
                    <input type="text" name="city" value="<?php echo $result1[0]['city'];?>" /><br>  
                    <?php
                }else{?>
                    <input type="text" name="city" value="" /><br>  
                    <?php
                }
                ?>
                <input type="hidden" name="idUser" value="<?php echo $idUse;?>" />
                <?php
                if($result1){?>
                    <input type="hidden" name="exists" value="1" />
                    <?php
                }else{?>
                    <input type="hidden" name="exists" value="0" />
                    <?php
                }
                ?>
                <input type="submit" value="ENVIAR" />
            </fieldset>    
        </form>
    </body>
    
    
    
</html>