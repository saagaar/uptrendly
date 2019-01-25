<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// require_once(APPPATH.'/third_party/mmpdf/mpdf.php');


class Pdf extends mPDF{
 
  
  /**
   * Let's get started...
   */
  private $test='utf-8';
  public $page='A4';
  function __construct( )
  {
    $this->ci =& get_instance();
    
   $this->mpdf = new mPDF('','A4','','raleway');
 
// Write some HTML code:

 
  }
  
 
  public function sendpdf($css,$html,$outputstring)
  {
      // $this->mpdf->WriteHTML($css,1);
    $this->mpdf->WriteHTML($html);
     $content = $this->mpdf->output('abc.pdf','S');
     $attachment = chunk_split(base64_encode($content));
     $eol = PHP_EOL; 
     $filename='invoice.pdf';
     $separator = md5(time());
    $to = 'saagarchapagain@gmail.com';
    $from='sagar@emultitechsolution.com';
    $from = $from;
    $subject = $mailsubject;
    $headers = "From: " . $from . $eol;
    $headers .= "MIME-Version: 1.0" . $eol;
    $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol . $eol;

    $body = '';

    $body .= "Content-Transfer-Encoding: 7bit" . $eol;
    $body .= "This is a MIME encoded message." . $eol; //had one more .$eol


    $body .= "--" . $separator . $eol;
    $body .= "Content-Type: text/html; charset=\"iso-8859-1\"" . $eol;
    $body .= "Content-Transfer-Encoding: 8bit" . $eol . $eol;
    $body .= $message . $eol;


    $body .= "--" . $separator . $eol;
    $body .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"" . $eol;
    $body .= "Content-Transfer-Encoding: base64" . $eol;
    $body .= "Content-Disposition: attachment" . $eol . $eol;
    $body .= $attachment . $eol;
    $body .= "--" . $separator . "--";

    if (mail($to, $subject, $body, $headers)) {

      echo   $msgsuccess = 'Mail Send Successfully';
    } else {

        echo $msgerror = 'Main not send';
    }
  }
  public function downloadpdf($css,$html,$outputstring)
  {
     $this->mpdf->WriteHTML($html);
     $content = $this->mpdf->output('report.pdf','D');
  }
}