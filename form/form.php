<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

//VARIABLES DEL FORMULARIO
$error = '';
$business = 'Soporte Apple Mac';
$nameLast = '';
$phone ='';
$email ='';
$equipo = '';
$support = '';
$request ='';
$address ='';

# TO - DESTINATARIO
$to = 'info@soporteapplemac.cl';


# SUBJECT - ASUNTO
$subject = "Formulario de Contacto - $business";

#VALIDATION AND FILTERS

//NAME AND LAST NAME
if(empty($_POST["nameLast"])){
    $error = 'Ingresa un nombre </br>';
}else{
    $nameLast = $_POST["nameLast"];
    $nameLast = filter_var($nameLast, FILTER_SANITIZE_STRING);
    $nameLast = trim($nameLast);
    if($nameLast == ''){
        $error .='Ingrese su nombre y apellido</br>';
    }
}
//PHONE
if(empty($_POST["phone"])){
    $error .= 'Ingresa un teléfono </br>';
}else{
    $phone = $_POST["phone"];
    $phone = trim($phone);
    if($phone == ''){
        $error .='Teléfono vacio</br>';
    }
}

//E-MAIL
if(empty($_POST["email"])){
    $error .= 'Ingresa un E-mail</br>';
}else{
    $email = $_POST["email"];
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $error .= 'Ingresa un E-mail verdadero</br>';
    }else{
        $email = filter_var($email,FILTER_SANITIZE_EMAIL);
    }
}

//EQUIPO
if(empty($_POST["equipo"])){
    $error .= 'Seleccione un equipo </br>';
}else{
    $equipo = $_POST["equipo"];
}

//SUPPORT
if(empty($_POST["support"])){
    $error .= 'Tipo de soporte </br>';
}else{
    $support = $_POST["support"];
}

//REQUEST
if(empty($_POST["request"])){
    $error .= 'Ingresa su requerimiento </br>';
}else{
    $request = $_POST["request"];
}

//ADDRESS
if(empty($_POST["address"])){
    $error = 'Ingresa su direccion </br>';
}else{
    $address = $_POST["address"];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $address = trim($address);
    if($address == ''){
        $error .='Ingrese una dirección</br>';
    }
}

# CONTENT FROM SEND
$content = "<h2>A continuacion los datos del cliente:</h2><br>";
$content .= "Nombre y apellido: $nameLast<br>";
$content .= "Telefono: $phone<br>";
$content .= "Email: $email<br>";
$content .= "Equipo: $equipo<br>";
$content .= "Tipo de soporte: $support<br>";
$content .= "Requerimiento: $request<br>";
$content .= "Dirección: $address<br>";


//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

# ENVIAR CORREO
if($error == ''){
    
    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'mail.soporteapplemac.cl';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'info@soporteapplemac.cl';                     //SMTP username
        $mail->Password   = 'Info2020*';                               //SMTP password
        $mail->SMTPSecure = 'ssl' ;        //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    
        //Recipients
        $mail->setFrom($email, $nameLast);
        $mail->addAddress($to);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $content;

        // Activo condificacción utf-8
        $mail->CharSet = 'UTF-8';
    
        $mail->send();
        echo 'success';
    } catch (Exception $e) {
        echo "No se pudo enviar el mensaje. Error de envío: {$mail->ErrorInfo}";
    }    
}else{
    echo $error;
}

?>