<?php
class Model_order extends Model{
	
	function __construct(){
		parent::__construct();
	}
	
	
	
	function confirm($data, $twig){
		require_once 'core/lib/PHPMailer/class.phpmailer.php';
		
		$sum =0;
		for($i=1;$i<=$_SESSION['count'];$i++){
			$sum+= $_SESSION['items'][$i]['count'] * $_SESSION['items'][$i]['price'];
		}
		
		
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$message = $twig->render("message.html", array("user" => $data, "total"=>$sum));

		$mail = new PHPMailer();
		$mail->isSMTP();                                 
		$mail->Host='smtp.mail.ru';														// SMTP host
		$mail->Port = '465';  																// SMTP port
		$mail->SMTPAuth = true;                              
		$mail->Username = 'email sender(example@ex.ex)';               // SMTP username
		$mail->Password = 'password sender'; 											// SMTP password
		$mail->SMTPSecure = 'ssl';                            // Encryptyon
		$mail->From = 'email sender';										// Имя отправителя должно совпадать с Username
		$mail->FromName = 'Cart';
		$mail->addAddress('email recipient');               // Адрес получателя
		$mail->Subject = 'Items to order';
		$mail->isHTML(true);
		$mail->msgHTML($message);
		
		if(!$mail->send()) {
		  echo 'Сообщение не может быть отправлено сейчас. Попробуйте позже.';
		  // Сюда вставить логирование.
		} else {
		  echo 'Отправлено';
		  unset($_SESSION['items']); unset($_SESSION['count']); unset($_SESSION['Gcount']);
		}
	
		
		
		
	}
	
}