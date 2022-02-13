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
        private static string $host = "smtp.gmail.com";
        private static string $username = "cidadeinteligente2022@gmail.com";
        private static string $password = "cidadeinteligenteSMTPAdmin";
        private static string $SMTPSecure = "tls";
        private static int $port = 587;
        private static string $from = "cidadeinteligente2022@gmail.com";
        private static string $CharSet = "UTF-8";

        /**
         * Método responsável por inicializar o objeto PHPMailer
         * @param string $receiver E-mail do destinatário
         */
        public function __construct(string $receiver) {
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