<?php

function send_email_helper($to, $subject, $template)
{
    $email = \Config\Services::email();
    $email->setFrom(FROM_EMAIL, FROM_EMAIL_NAME);
    $email->setTo($to);
    $email->setSubject($subject);
    $email->setMessage($template);
    return $email->send();
}