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
         * Constutor da classe que inicializa o objeto PHPMailer.
         * @param string $receiver E-mail do destinatário
         */
        public function __construct(string $receiver) {
            $this->mailer = new PHPMailer(true);
            $this->mailer->SMTPDebug = ISDEV == true ? SMTP::DEBUG_SERVER : 0;
            $this->mailer->isSMTP();
            $this->mailer->Host = EMAIL["HOST"];
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = EMAIL["USERNAME"];
            $this->mailer->Password = EMAIL["PASSWORD"];
            $this->mailer->SMTPSecure = EMAIL["SMTPSECURE"];
            $this->mailer->Port = EMAIL["PORT"];
            $this->mailer->setFrom(EMAIL["USERNAME"]);
            $this->mailer->addAddress($receiver);
            $this->mailer->isHTML(true);
            $this->mailer->CharSet = EMAIL["CHARSET"];
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