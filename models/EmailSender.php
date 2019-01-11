<?php

class EmailSender {
    
    public function send($whom, $subject, $message, $from) {
        $header = "From: " . $from;
        $header .= "\nMIME-Version: 1.0\n";
        $header .= "Content-Type: text/html; charset=\"utf-8\"\n";
        return mb_send_mail($whom, $subject, $message, $header);
    }
}