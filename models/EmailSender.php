<?php

class EmailSender {
    
    public function send($toWhom, $subject, $message, $from) {
        $header = "From: " . $from;
        $header .= "\nMIME-Version: 1.0\n";
        $header .= "Content-Type: text/html; charset=\"utf-8\"\n";
        if (mb_send_mail($toWhom, $subject, $message, $header)) {
            throw new UserException('Email se nepodařilo odeslat.');
        }
    }

    public function sendWithAntispam($year, $toWhom, $subject, $message, $from) {
        if ($year != date("Y")) {
            throw new UserError('Nesprávně vyplněný antispam.');
        }
        $this->send($toWhom, $subject, $message, $from);
    }

}