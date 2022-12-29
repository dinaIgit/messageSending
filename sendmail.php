<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'phpmailer/src/Exception.php';
	require 'phpmailer/src/PHPMailer.php';

	$mail = new PHPMailer(true);
	$mail->CharSet = 'UTF-8';
	$mail->setLanguage('ru', 'de', 'en', 'phpmailer/language/');
	$mail->IsHTML(true);

	//From whom is the letter
	$mail->setFrom('https://dinaigit.github.io/dinaIgit.io/index.html', 'Portfolio message');
	//Who to send
	$mail->addAddress('d.iskakova.job@gmail.com');
	//Subject line
	$mail->Subject = 'Hello! This message is from the portfolio submission form"';

	//Identity
	$identity = "private";
	if($_POST['identity'] == "company"){
		$identity = "company";
	}

	//message body
	$body = '<h1>This message is from the portfolio</h1>';
	
	if(trim(!empty($_POST['name']))){
		$body.='<p><strong>Имя:</strong> '.$_POST['name'].'</p>';
	}
	if(trim(!empty($_POST['email']))){
		$body.='<p><strong>E-mail:</strong> '.$_POST['email'].'</p>';
	}
	if(trim(!empty($_POST['identity']))){
		$body.='<p><strong>Identity:</strong> '.$identity.'</p>';
	}
/* 	if(trim(!empty($_POST['age']))){
		$body.='<p><strong>Age:</strong> '.$_POST['age'].'</p>';
	} */
	
	if(trim(!empty($_POST['message']))){
		$body.='<p><strong>Message:</strong> '.$_POST['message'].'</p>';
	}
	
	//Attach file
	if (!empty($_FILES['image']['tmp_name'])) {
		//file path
		$filePath = __DIR__ . "/files/" . $_FILES['image']['name']; 
		//uploading the file
		if (copy($_FILES['image']['tmp_name'], $filePath)){
			$fileAttach = $filePath;
			$body.='<p><strong>Attachment photo</strong>';
			$mail->addAttachment($fileAttach);
		}
	}

	$mail->Body = $body;

	//Send
	if (!$mail->send()) {
		$message = 'Error';
	} else {
		$message = 'Data has been sent!';
	}

	$response = ['message' => $message];

	header('Content-type: application/json');
	echo json_encode($response);
?>