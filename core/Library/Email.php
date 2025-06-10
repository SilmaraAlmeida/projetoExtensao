<?php

namespace Core\Library;

use Core\Library\Session;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email
{
    /**
     * enviaEmail
     *
     * @param string $emailRemetente 
     * @param string $nomeRemetente 
     * @param string $assunto 
     * @param string $corpoEmail 
     * @param string $destinatario 
     * @param array $aAnexos 
     * @return bool
     */
    static function enviaEmail($emailRemetente, $nomeRemetente, $assunto, $corpoEmail, $destinatario, $aAnexos = []) 
    {
        $mail = new PHPMailer();

        try {

            $mail->isSMTP();
            $mail->SMTPDebug    = 0;                                // Enable verbose debug output
            $mail->CharSet      = "UTF-8";
            $mail->SMTPAuth     = (bool)$_ENV['MAIL.SMTPAuth'];           // Ativa o SMTP autenticado
            $mail->SMTPSecure   = $_ENV['MAIL.SMTPSECURE'];         // Enable implicit TLS encryption
            //$mail->SMTPSecure   = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Host         = $_ENV['MAIL.HOST'];
            $mail->Port         = (int)$_ENV['MAIL.PORT'];
            $mail->Username     = $_ENV['MAIL.USER'];               // Usuário de e-mail para autenticação
            $mail->Password     = $_ENV['MAIL.PASSWORD'];           // Senha do e-mail de autenticação
            $mail->From         = $emailRemetente;                  // E-mail remetente
            $mail->FromName     = $nomeRemetente;                   // Nome do Remetente
            
            $mail->addAddress( $destinatario );                     // E-mail Destinatário 
            
            $mail->isHTML(true );                                   // Será HTML
            $mail->Subject      = $assunto;                         // Assunto do e-mail
            $mail->Body         = $corpoEmail;                      // Corpo do E-mail HTML
            
            // Anexos

            if (count($aAnexos) > 0) {
                for ($yyy = 0; $yyy < count($aAnexos['name']); $yyy++) {
                    $mail->addAttachment($aAnexos['tmp_name'][$yyy], $aAnexos['name'][$yyy]);
                }
            }

            if ($mail->send()) {
                return true;
            } else {
                Session::set('msgError', "Error ao tentar enviar o e-mail: {$mail->ErrorInfo}");
                return false;
            }

        } catch (\Exception $e) {
            Session::set('msgError', "Error ao tentar enviar o e-mail: {$mail->ErrorInfo}");
            return false;
        }
    }
}