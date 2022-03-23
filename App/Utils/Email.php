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
        private static String $host = "smtp.gmail.com";
        private static String $username = "cidadeinteligente2022@gmail.com";
        private static String $password = "cidadeinteligenteSMTPAdmin";
        private static String $SMTPSecure = "tls";
        private static Int $port = 587;
        private static String $from = "cidadeinteligente2022@gmail.com";
        private static String $CharSet = "UTF-8";

        /**
         * Método responsável por inicializar o objeto PHPMailer
         * @param String $receiver E-mail do destinatário
         */
        public function __construct(String $receiver) {
            $this->mailer = new PHPMailer(true);
            $this->mailer->SMTPDebug = SMTP::DEBUG_SERVER;
            $this->mailer->isSMTP();
            $this->mailer->Host = self::$host;
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = self::$username;
            $this->mailer->Password = self::$password;
            $this->mailer->SMTPSecure = self::$SMTPSecure;
            $this->mailer->Port = self::$port;
            $this->mailer->SMTPDebug = 0;
            $this->mailer->setFrom(self::$from);
            $this->mailer->addAddress($receiver);
            $this->mailer->isHTML(true);
            $this->mailer->CharSet = self::$CharSet;
        }

        /**
         * Método responsável por enviar um e-mail
         * @param String $subject E-mail do destinatário
         * @param String $body Corpo do e-mail
         * @return void
         */
        public function SendEmail(String $subject, String $body) : void {
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;
            $this->mailer->send();
        }
    }