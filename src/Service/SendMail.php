<?php

namespace App\Service;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class SendMail {
    private $mailtbsrSender = "";
    private $mailtbsrRecever = "";

    public function smtpMailToMe(string $subject, string $message, string $replyto, string $title = "TBSR"):bool
    {
        $smtpPasse = 'ajrjnskftfmkvirv';
        $smtpServer = 'smtp.gmail.com';
        $smtpPort = '587';
        $smtpSecured = 'tls';

        $from = $this->mailtbsrSender;
        $to = $this->mailtbsrRecever;

        try{
            $transport = (new Swift_SmtpTransport($smtpServer, $smtpPort, $smtpSecured)) 
                ->setUsername($from)
                ->setPassword($smtpPasse);
            $mailer = new Swift_Mailer($transport); 
            $content = (new Swift_Message())
                ->setSubject($subject)
                ->setFrom($from, $title)
                ->setReplyTo($replyto)
                ->setTo($to)
                ->setBody($message, 'text/html');
            if ($mailer->send($content)) {
                return true;
            } else {
                return false;
            }
        }catch (\Exception $e) {
            return false;
        }
    }

    public function smtpMail(string $to, string $subject, string $message, string $title = "TBSR"):bool
    {
        $smtpPasse = 'ajrjnskftfmkvirv';
        $smtpServer = 'smtp.gmail.com';
        $smtpPort = '587';
        $smtpSecured = 'tls';

        $from = $this->mailtbsrSender;

        try{
            $transport = (new Swift_SmtpTransport($smtpServer, $smtpPort, $smtpSecured)) 
                ->setUsername($from)
                ->setPassword($smtpPasse);
            $mailer = new Swift_Mailer($transport); 
            $content = (new Swift_Message())
                ->setSubject($subject)
                ->setFrom($from, $title)
                ->setReplyTo($this->mailtbsrSender)
                ->setTo($to)
                ->setBody($message, 'text/html');
            if ($mailer->send($content)) {
                return true;
            } else {
                return false;
            }
        }catch (\Exception $e) {
            return false;
        }
    }
}