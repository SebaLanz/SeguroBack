<?php
require_once 'config/constantes.php';
require_once ("baseBiz.class.php");
use PHPMailer\PHPMailer\PHPMailer;
require_once 'vendor/autoload.php';


class Email extends BaseBiz{
	
	
	static function is_valid_email($str){
	  $matches = null;
	  return (1 === preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $str, $matches));
	}


	static function sendMail($fromName,$destino,$subject,$mensaje){
		try{
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->isHTML( TRUE );
			$mail->SMTPAuth    = TRUE;
			$mail->SMTPSecure = "tls";
			$mail->Username = SMTP_USER;   //Usuario que envía los mails. Preferible outlook. Datos entre "".               
			$mail->Password = SMTP_PASSWORD;//Clave del usuario que envía mails. Datos entre ""
			$mail->AddAddress($destino);
			$mail->FromName = $fromName;
			$mail->Subject = $subject;
			$mail->Body = $mensaje;
			$mail->Host = smtp.office365.com; 
			$mail->Port = 587;
			//$mail->SMTPDebug   = 1; // 2 to enable SMTP debug information
			$mail->SMTPOptions = array('ssl' => array(
			    'verify_peer' => false,
			    'verify_peer_name' => false,
			    'allow_self_signed' => true
			));
			$mail->SMTPAuth = true;
			$mail->From = $mail->Username;
			return $mail->Send();
		}catch (Exception $e){
            throw new Exception(" Error enviando email :".$e->getMessage());         
        }

	}





}

?>
