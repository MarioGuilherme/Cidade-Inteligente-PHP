<?php

    declare(strict_types=1);

    namespace App\Utils;

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

    /**
     * Classe responsável por fazer o controle do envio de emails.
     * @author Mário Guilherme
     */
    class Email {
        /**
         * Objeto PHPMailer.
         * @var PHPMailer
         */
        private PHPMailer $mailer;

        /**
         * Host do servidor de e-mail.
         * @var string
         */
        private static string $host = "smtp.gmail.com";

        /**
         * Email do usuário do servidor de e-mail.
         * @var string
         */
        private static string $username = "cidadeinteligente2022@gmail.com";

        /**
         * Senha do usuário do servidor de e-mail.
         * @var string
         */
        private static string $password = "cidadeinteligenteSMTPAdmin";

        /**
         * Segurança do servidor de e-mail.
         * @var string
         */
        private static string $SMTPSecure = "tls";

        /**
         * Porta do servidor de emal.
         * @var int
         */
        private static int $port = 587;

        /**
         * Email do remetente.
         * @var string
         */
        private static string $from = "cidadeinteligente2022@gmail.com";

        /**
         * Tipo de codificação.
         * @var string
         */
        private static string $charSet = "UTF-8";

        /**
         * Método responsável por inicializar o objeto PHPMailer.
         * @param string $receiver E-mail do destinatário
         * @return void
         */
        public function __construct(string $receiver) {
            $this->mailer = new PHPMailer(true);
            $this->mailer->SMTPDebug = DEV_ENV === "true" ? SMTP::DEBUG_SERVER : 0;
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
            $this->mailer->CharSet = self::$charSet;
        }

        /**
         * Método responsável por fazer o envio de um e-mail.
         * @param string $subject E-mail do destinatário
         * @param string $body Corpo do e-mail
         * @return void
         */
        public function sendEmail(string $subject, string $body) : void {
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;
            $this->mailer->send();
        }
    }