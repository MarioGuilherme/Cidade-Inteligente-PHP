<?php

    declare(strict_types=1);

    namespace App\Utils;

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

    /**
     * Classe responsável por fazer o envio de e-mails
     *
     * @author Mário Guilherme
     */
    class Email {
        private PHPMailer $mailer;

        /**
         * Método responsável por inicializar o objeto PHPMailer
         * @param string $receiver E-mail do destinatário
         */
        public function __construct(string $receiver) {
            $this->mailer = new PHPMailer(true);
            $this->mailer->SMTPDebug = SMTP::DEBUG_SERVER;
            $this->mailer->isSMTP();
            $this->mailer->Host = "smtp.gmail.com";
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = "cidadeinteligente2022@gmail.com";
            $this->mailer->Password = "cidadeinteligenteSMTPAdmin";
            $this->mailer->SMTPSecure = "tls";
            $this->mailer->Port = 587;
            $this->mailer->SMTPDebug = 0;
            $this->mailer->setFrom("cidadeinteligente2022@gmail.com");
            $this->mailer->addAddress($receiver);
            $this->mailer->isHTML(true);
            $this->mailer->CharSet = "UTF-8";
        }

        /**
         * Método responsável por enviar um e-mail
         * @param string $subject E-mail do destinatário
         * @param string $body Corpo do e-mail
         * @return void
         */
        public function SendEmail(string $subject, string $body) : void {
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;
            $this->mailer->send();
        }
    }