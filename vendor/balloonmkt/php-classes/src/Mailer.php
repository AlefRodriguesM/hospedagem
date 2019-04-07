<?php

namespace Balloonmkt;

use Rain\Tpl;

class Mailer{
  const USERNAME = 'aleftestesphp@gmail.com';
  const PASSWORD = '@Leftestesphp';
  const NAME_FROM = "Ballon Hosp.";

  private $mail;

  public function __construct($toAddress, $toName, $subject, $tplName, $data = array()){
    $config = array(
      'tpl_dir'    => $_SERVER["DOCUMENT_ROOT"].'/views/email/',
      'cache_dir'  => $_SERVER["DOCUMENT_ROOT"].'/views-cache/',
      'debug'      => false
    );

    Tpl::configure($config);

    $tpl = new Tpl;

    foreach($data as $key => $value){
      $tpl->assign($key, $value);
    }

    $html = $tpl->draw($tplName, true);

    $this->mail = new \PHPMailer;

    $this->mail->isSMTP();

    $this->mail->SMTPDebug = 2;

    $this->mail->Debugoutput = 'html';

    $this->mail->Host = 'smtp.gmail.com';

    $this->mail->Port = 587;

    $this->mail->SMTPOption = array(
      'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow-self-signed' => true
      )
    );

    $this->mail->SMTPSecure = 'tls';

    $this->mail->SMTPAuth = true;

    $this->mail->Username = Mailer::USERNAME;

    $this->mail->Password = Mailer::PASSWORD;

    $this->mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM);

    $this->mail->addAddress($toAddress, $toName);

    $this->mail->Subject = $subject;
    //$this->mail->Subject = utf8_decode($subject);

    $this->mail->msgHTML($html);
    //$this->mail->msgHTML(utf8_decode($html););

    $this->mail->AltBody = 'arou';
  }

  public function send(){
    return $this->mail->send();
  }
}

?>
