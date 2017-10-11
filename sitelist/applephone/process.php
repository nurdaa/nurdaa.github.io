<?php

$errors         = array();  	// array to hold validation errors
$data 			= array(); 		// array to pass back data

	$user_name		= filter_var($_POST["name"], FILTER_SANITIZE_STRING);
	$phone_number	= filter_var($_POST["email"]);

// validate the variables ======================================================
	// if any of these variables don't exist, add an error to our $errors array

	if (empty($_POST['name']))
		$errors['name'] = 'Введите ваше имя';

	if (empty($_POST['email']))
		$errors['email'] = 'Введите свой номер телефона';



// return a response ===========================================================

	// if there are any errors in our errors array, return a success boolean of false
	if ( ! empty($errors)) {

		// if there are items in our errors array, return those errors
		$data['success'] = false;
		$data['errors']  = $errors;
	} else {


		
$to = "nurdaakz@gmail.com";
$subject = "Новая Заявка";
$headers = "From: nurdaakz@gmail.com" . "\r\n" .
"CC: nurdaakz@gmail.com";

$message_body = "\r\nИМЯ: ".$user_name."\r\nНомер телефона : ". $phone_number. "\r\n\r\nОставил заявку на сайте \r\n\r\n www.shop.engroup.kz " ;




mail($to,$subject,$message_body,$headers);


		// Начало стиля в письме 

		


		// if there are no errors process our form, then return a message

		// DO ALL YOUR FORM PROCESSING HERE
		// THIS CAN BE WHATEVER YOU WANT TO DO (LOGIN, SAVE, UPDATE, WHATEVER)

		// show a message of success and provide a true success variable
		$data['success'] = true;
		$data['message'] = 'Спасибо, наш менеджер скоро свяжется с Вами!';
	}

	// return all our data to an AJAX call
	echo json_encode($data);