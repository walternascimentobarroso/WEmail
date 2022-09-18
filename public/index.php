<?php

require __DIR__ . '/../vendor/autoload.php';

Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../')->load();

use App\Service\Email;

$adrress = 'walternascimentobarroso@gmail.com';
$subject = 'Teste de envio de e-mail';
$body = '<strong>Olá, mundo!</strong><br>Este é um teste de envio de e-mail.';

$test = getenv('MAIL_MAILER');
$email = new Email();

$success = $email->send($adrress, $subject, $body);

$attachment = __DIR__ . '/../.env.example';
$success = $email->send($adrress, $subject, $body, $attachment);

echo $success
    ? 'E-mail enviado com sucesso'
    : 'Falha ao enviar o e-mail: ' . $email->getError();
