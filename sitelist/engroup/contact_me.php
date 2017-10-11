<?php
if($_POST)
{
	$to_email   	= "office.engroup@gmail.com"; //Recipient email, Replace with own email here
	
	//check if its an ajax request, exit if not
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
		
		$output = json_encode(array( //create JSON data
			'type'=>'error', 
			'text' => 'Sorry Request must be Ajax POST'
		));
		die($output); //exit script outputting json data
    } 
	
	//Sanitize input data using PHP filter_var().
	$en_mail		= "ENGroup";

	$user_name		= filter_var($_POST["user_name"], FILTER_SANITIZE_STRING);
	$user_email		= filter_var($_POST["user_email"], FILTER_SANITIZE_EMAIL);
	$country_code	= filter_var($_POST["country_code"], FILTER_SANITIZE_NUMBER_INT);
	$phone_number	= filter_var($_POST["phone_number"], FILTER_SANITIZE_NUMBER_INT);
	$subject		= filter_var($_POST["subject"], FILTER_SANITIZE_STRING);
	$message		= filter_var($_POST["msg"], FILTER_SANITIZE_STRING);
	
	//additional php validation
	if(strlen($user_name)<4){ // If length is less than 4 it will output JSON error.
		$output = json_encode(array('type'=>'error', 'text' => 'Введите Ваше ФИО!'));
		die($output);
	}
	if(!filter_var($user_email, FILTER_VALIDATE_EMAIL)){ //email validation
		$output = json_encode(array('type'=>'error', 'text' => 'Проверьте правильность вашего Email'));
		die($output);
	}
	
	if(!filter_var($phone_number, FILTER_SANITIZE_NUMBER_FLOAT)){ //check for valid numbers in phone number field
		$output = json_encode(array('type'=>'error', 'text' => 'Проверьте правильность вашего номера'));
		die($output);
	}
	if(strlen($subject)<3){ //check emtpy subject
		$output = json_encode(array('type'=>'error', 'text' => 'Выберите Курс, который Вы хотели бы пройти'));
		die($output);
	}
	if(strlen($message)>900){ //check emtpy message
		$output = json_encode(array('type'=>'error', 'text' => 'Слишком длинное сообщение'));
		die($output);
	}
	
	//email body
	$message_body = "\r\nФИО: ".$user_name."\r\nКурс: ".$subject."\r\nEmail: ".$user_email."\r\nНомер телефона : ". $phone_number. "\r\n\r\nВопрос: " .$message ;
	
	//proceed with PHP email.
	$headers = 'From: '.$en_mail.'' . "\r\n" .
	'Reply-To: '.$user_email.'' . "\r\n" .
	'X-Mailer: PHP/' . phpversion();
	
	$send_mail = mail($to_email, $subject, $message_body, $headers);
	
	if(!$send_mail)
	{
		//If mail couldn't be sent output error. Check your PHP email configuration (if it ever happens)
		$output = json_encode(array('type'=>'error', 'text' => 'Ошибка сервера. Повторите еще раз или позвоните нам по тел. 87011412227'));
		die($output);
	}else{
		$output = json_encode(array('type'=>'message', 'text' => ''.$user_name .' вы успешно оставили заявку на прохождение курса '.$subject . '. В ближайшее время мы вам позвоним. Спасибо.'));
		die($output);
	}
}
?>


<div class="col-md-8">