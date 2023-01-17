<?php

defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    protected $_ci;

    public function __construct()
    {
        log_message('Debug', 'PHPMailer class is loaded.');
        $this->_ci = &get_instance();
        $this->_ci->load->database();
    }

    public function get_settingsValue($key)
    {
        $query = $this->_ci->db->get_where('tb_settings', ['key' => $key]);
        return $query->row()->value;
    }

    public function send($data)
    {

      if (!class_exists('PHPMailer\PHPMailer\Exception')) {
        // Include PHPMailer library files
        require_once APPPATH.'third_party/PHPMailer/Exception.php';
        require_once APPPATH.'third_party/PHPMailer/PHPMailer.php';
        require_once APPPATH.'third_party/PHPMailer/SMTP.php';
      }

      $mail = new PHPMailer(true);

      try {
          // SMTP configuration
          if($this->get_settingsValue('mailer_smtp') == 1){
            $mail->isSMTP();
          }

          $mail->SMTPOptions = array(
            'ssl' => array(
              'verify_peer' => false,
              'verify_peer_name' => false,
              'allow_self_signed' => true
            )
          );

          $mail->SMTPDebug      = 0;
          $mail->SMTPAuth       = true;
          $mail->SMTPKeepAlive  = true;
          $mail->SMTPSecure     = $this->get_settingsValue('mailer_connection');
          $mail->Port           = $this->get_settingsValue('mailer_port'); #587;
          $mail->Host           = $this->get_settingsValue('mailer_host'); #"smtp.gmail.com";
          $mail->Username       = $this->get_settingsValue('mailer_username'); #"ngodingin.indonesia@gmail.com";
          $mail->Password       = $this->get_settingsValue('mailer_password'); #"hxexyuauljnejjmq";

          $mail->setFrom($this->get_settingsValue('mailer_username'), $this->get_settingsValue('mailer_alias'));
          $mail->addReplyTo($this->get_settingsValue('mailer_username'), $this->get_settingsValue('mailer_alias'));

          // Add a recipient
          $mail->addAddress($data['to']);

          // Email subject
          $mail->Subject = "DO NOT REPLY - ".$data['subject'];

          // Set email format to HTML
          $data['web_logo'] = $this->get_settingsValue('web_logo');

          $mail->isHTML(true);
          // Email body content
          $mail->Body = $this->_ci->load->view('template/mailer/general', $data, true);

          // Send email
          if (!$mail->send()) {
              return false;
          } else {
              return true;
          }
          $mail->clearAddresses();
          $mail->clearAttachments();
      } catch (Exception $e) {
          return false;
      }
    }

    public function sendTest($data)
    {
      if (!class_exists('PHPMailer\PHPMailer\Exception')) {
        // Include PHPMailer library files
        require_once APPPATH.'third_party/PHPMailer/Exception.php';
        require_once APPPATH.'third_party/PHPMailer/PHPMailer.php';
        require_once APPPATH.'third_party/PHPMailer/SMTP.php';
      }

      $mail = new PHPMailer(true);

      try {
          // SMTP configuration
          $mail->isSMTP();

          $mail->SMTPOptions = array(
            'ssl' => array(
              'verify_peer' => false,
              'verify_peer_name' => false,
              'allow_self_signed' => true
            )
          );

          $mail->SMTPDebug      = 0;
          $mail->SMTPAuth       = true;
          $mail->SMTPKeepAlive  = true;
          $mail->SMTPSecure     = $this->get_settingsValue('mailer_connection');
          $mail->Port           = $this->get_settingsValue('mailer_port'); #587;
          $mail->Host           = $this->get_settingsValue('mailer_host'); #"smtp.gmail.com";
          $mail->Username       = $this->get_settingsValue('mailer_username'); #"ngodingin.indonesia@gmail.com";
          $mail->Password       = $this->get_settingsValue('mailer_password'); #"hxexyuauljnejjmq";

          $mail->setFrom($this->get_settingsValue('mailer_username'), $this->get_settingsValue('mailer_alias'));
          $mail->addReplyTo($this->get_settingsValue('mailer_username'), $this->get_settingsValue('mailer_alias'));

          // Add a recipient
          $mail->addAddress($data['to']);

          // Email subject
          $mail->Subject = $data['subject'];

          // Set email format to HTML
          $data['web_logo'] = $this->get_settingsValue('web_logo');

          $mail->isHTML(true);
          // Email body content
          $mail->Body = $this->_ci->load->view('template/mailer/general', $data, true);

          // Send email
          if (!$mail->send()) {
            return [
              'status' => false,
              'debug' => $mail->ErrorInfo
            ];
          } else {
            return [
              'status' => true,
              'debug' => $mail->Debugoutput
            ];
          }
          $mail->clearAddresses();
          $mail->clearAttachments();
      } catch (Exception $e) {
          return [
            'status' => false,
            'debug' => $mail->ErrorInfo
          ];
      }
    }
}
