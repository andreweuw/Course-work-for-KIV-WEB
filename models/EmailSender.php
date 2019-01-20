<?php

/**
 * Třída poskytuje 2 metody pro posílání emailu
 */
class EmailSender {
    
    /**
     * Čisté poslání emailu
     */
    public function send($toWhom, $subject, $message, $from) {
        $header = "From: " . $from;
        $header .= "\nMIME-Version: 1.0\n";
        $header .= "Content-Type: text/html; charset=\"utf-8\"\n";
        if (mb_send_mail($toWhom, $subject, $message, $header)) {
            throw new UserError('Email se nepodařilo odeslat.');
        }
    }

    /**
     * Posílání emailu s kontolou spamu
     */
    public function sendWithAntispam($year, $toWhom, $subject, $message, $from) {
        if ($year != date("Y")) {
            throw new UserError('Nesprávně vyplněný antispam.');
        }
        $this->send($toWhom, $subject, $message, $from);
    }

}