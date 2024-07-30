<?php
namespace Classes;
require '../vendor/autoload.php'; // Ajusta la ruta según la ubicación de tu archivo
use PHPMailer\PHPMailer\PHPMailer;

class Email {
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token)
    {   
        
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'e6eb37ef07b7f9';
        $mail->Password = '89f93abd950acf';


        $mail->setFrom('cuentas@itstacambaro.com');
        $mail->addAddress("$this->email");
        $mail->Subject = ('Confirma tu cuenta');

        $mail->isHTML(TRUE);
        $mail->CharSet = ('UTF-8');

        $contenido = '<html>';
        
        $contenido .= "<p><strong>Hola " . $this->nombre ." </strong> Has Creado tu cuenta en TecLaboratorio
        , solo debes confirmarla en el siguiente enlace </p>";

        $contenido.= "<p>Presiona aqui: <a href='http://localhost:3000/auth/confirmar.php?token=" .
        $this->token ."'>Confirmar Cuenta</a></p>";
        $contenido .="<p>Si tu no creaste esta cuenta, puedes ignorar este mensaje</p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;
        $mail->send();

    }

    public function enviarInstrucciones(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'e6eb37ef07b7f9';
        $mail->Password = '89f93abd950acf';


        $mail->setFrom('cuentas@itstacambaro.com');
        $mail->addAddress('cuentas@itstacambaro.com','LaboratorioTec.com');
        $mail->Subject = ('Restablece tu contraseña');

        $mail->isHTML(TRUE);
        $mail->CharSet = ('UTF-8');

        $contenido = '<html>';
        
        $contenido .= "<p><strong>Hola" . $this->nombre ." </strong> Parece que has olvidado tu contraseña sigue el siguiente
        enlace para recuperarlo </p>";

        $contenido.= "<p>Presiona aqui: <a href='http://localhost:3000/auth/reestablecer.php?token=" .
        $this->token ."'>Reestablecer contraseña</a></p>";
        $contenido .="<p>Si tu no solicitaste este cambio, puedes ignorar este mensaje</p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;
        $mail->send();

    }

    public function notificarEmail(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'e6eb37ef07b7f9';
        $mail->Password = '89f93abd950acf';


        $mail->setFrom('cuentas@itstacambaro.com');
        $mail->addAddress('cuentas@itstacambaro.com','LaboratorioTec.com');
        $mail->Subject = ('Notificacion');

        $mail->isHTML(TRUE);
        $mail->CharSet = ('UTF-8');

        $contenido = '<html>';
        
        $contenido .= "<p> ".$this->nombre." genero una solicitud </p>";

        $contenido.= "<p>Presiona aqui para revisarla: <a href='http://localhost:3000/auth/login.php'>Ver</a></p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;
        $mail->send();
    }
}