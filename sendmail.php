<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'phpmailer/src/Exception.php';
	require 'phpmailer/src/PHPMailer.php';

	$mail = new PHPMailer(true);
	$mail->CharSet = 'UTF-8';
	$mail->setLanguage('ru', 'phpmailer/language/');
	$mail->IsHTML(true);

	//От кого письмо
	$mail->setFrom('terenyadanil@gmail.com', 'LifeShop');
	//Кому отправить
	$mail->addAddress('terenyadanil@gmail.com');
	//Тема письма
	$mail->Subject = 'Новая заявка на товар!';


	//Тело письма
	$body = '<h1>Кто-то хочет заказать через вас!</h1>';
	
	if(trim(!empty($_POST['link']))){
		$body.='<p><strong>Ссылка:</strong> '.$_POST['link'].'</p>';
	}
	
	if(trim(!empty($_POST['name']))){
		$body.='<p><strong>Имя:</strong> '.$_POST['name'].'</p>';
	}
	
	if(trim(!empty($_POST['phone']))){
		$body.='<p><strong>Телефон:</strong> '.$_POST['phone'].'</p>';
	}
	if(trim(!empty($_POST['email']))){
		$body.='<p><strong>E-mail:</strong> '.$_POST['email'].'</p>';
	}
	if(trim(!empty($_POST['add']))){
		$body.='<p><strong>Адрес:</strong> '.$_POST['add'].'</p>';
	}
	if(trim(!empty($_POST['index']))){
		$body.='<p><strong>Индекс:</strong> '.$_POST['index'].'</p>';
	}
	
	if(trim(!empty($_POST['message']))){
		$body.='<p><strong>Предпочтение:</strong> '.$_POST['message'].'</p>';
	}
	
	//Прикрепить файл
	if (!empty($_FILES['image']['tmp_name'])) {
		//путь загрузки файла
		$filePath = __DIR__ . "/files/" . $_FILES['image']['name']; 
		//грузим файл
		if (copy($_FILES['image']['tmp_name'], $filePath)){
			$fileAttach = $filePath;
			$body.='<p><strong>Фото</strong></p>';
			$mail->addAttachment($fileAttach);
		}
	}

	$mail->Body = $body;

	//Отправляем
	if (!$mail->send()) {
		$message = 'Ошибка';
	} else {
		$message = 'Данные отправлены!';
	}

	$response = ['message' => $message];

	header('Content-type: application/json');
	echo json_encode($response);
?>