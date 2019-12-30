<?php

class Users{
	
	public $objDb;
	public $objSe;
	public $result;
	public $rows;
	public $useropc;
	
	public function __construct(){
		
		$this->objDb = new Database();
		$this->objSe = new Sessions();
		
	}
	
	public function login_in(){
		
            $sth = $this->objDb->prepare('SELECT * FROM users U inner join profiles P '
                    . 'on U.idprofile = P.idProfile WHERE U.loginUsers = :login AND U.passUsers = :pass');
            
            $sth->bindParam(':login', $_POST["usern"]);
            $sth->bindParam(':pass', $_POST["passwd"]);
            
            $sth->execute();
            
            $result = $sth->fetchAll();
            
            if($result){
                
                $profile = $result[0]['nameProfi'];
                
                switch($profile){
                    case 'Standard':
                        $this->objSe->init();
                        $this->objSe->set('idUser', $result[0]['idUsers']);
                        $this->objSe->set('loginUsers', $result[0]['loginUsers']);
                        $this->objSe->set('nameProfi', $result[0]['nameProfi']);
                        $this->objSe->set('idProfile', $result[0]['idProfile']);                        
                        header('Location: user/index.php');
			break;
                    case 'Admin':
                        $this->objSe->init();
                        $this->objSe->set('idUser', $result[0]['idUsers']);
                        $this->objSe->set('loginUsers', $result[0]['loginUsers']);
                        $this->objSe->set('nameProfi', $result[0]['nameProfi']);
                        $this->objSe->set('idProfile', $result[0]['idProfile']);                        
                        echo "Ha ingresado como Ususario Administrador";
                        echo '<br><a href="log_out.php">Cerrar</a>';
                        //header('Location: admin/index.php');
			break;
                }
                
            }else{
                header('Location: index.php?error=1');
            }		
	}
        
        public function modify_login($idUse = false, $path = false){
            $objdata = new Database();
            $sth = $objdata->prepare('UPDATE users SET '
                    . 'loginUsers = :loginUsers, passUsers = :passUsers, '
                    . 'emailUser = :emailUser, path_imgUser = :path_imgUser '
                    . 'WHERE idUsers = :idUsers');
                
                $sth->bindParam(':loginUsers', $_POST['userN']);
                $sth->bindParam(':passUsers', $_POST['userP']);
                $sth->bindParam(':emailUser', $_POST['userC']);
                $sth->bindParam(':path_imgUser', $path);
                $sth->bindParam(':idUsers', $idUse);
                
                $sth->execute();

                header('location: http://localhost:8888/CodigosVideos/10-DatosUsuario3/user/profile.php');
            
        }


        public function modify_data($idUse = false){
            $objdata = new Database();
            if($_POST['exists'] == 0){
                $sth = $objdata->prepare('INSERT INTO user_data VALUES '
                    . '(:id_data, :names, :bornin, :country, :city, :idUsers)');
                $idUserd = 0;
                $sth->bindParam(':id_data', $idUserd);
                $sth->bindParam(':names', $_POST['names']);
                $sth->bindParam(':bornin', $_POST['date']);
                $sth->bindParam(':country', $_POST['country']);
                $sth->bindParam(':city', $_POST['city']);
                $sth->bindParam(':idUsers', $idUse);
                
                $sth->execute();

                header('location: http://localhost:8888/CodigosVideos/10-DatosUsuario3/user/profile.php');
            }else{
                $sth = $objdata->prepare('UPDATE user_data SET '
                    . 'names = :names, bornin = :bornin, country = :country, city = :city '
                    . 'WHERE idUsers = :idUsers');
                
                $sth->bindParam(':names', $_POST['names']);
                $sth->bindParam(':bornin', $_POST['date']);
                $sth->bindParam(':country', $_POST['country']);
                $sth->bindParam(':city', $_POST['city']);
                $sth->bindParam(':idUsers', $idUse);
                
                $sth->execute();

                header('location: http://localhost:8888/CodigosVideos/10-DatosUsuario3/user/profile.php');
            }
        }
	
}