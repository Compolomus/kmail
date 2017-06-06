<?php
/**
 * Compolom Tools
 * @author Mitenev Dmitrii <compolom@gmail.com>
 * @license LICENSE.md
 * @version 1.0
 */

namespace Compolom\Tools;

class KMail
{

    const VERSION = '1.0';

    const RELEASE_DATE = '2017-04-24';

    private $mb;

    private $header;

    private $subject = '(No subject)';

    private $adress = [];

    private $body;

    public function __construct($text)
    {
        $this->addBodyMessage($text);
        $this->mb();
    }

    private function sendMailUtf8($adress, $subject, $message, $header)
    {
        return mail($adress, '=?UTF-8?B?' . base64_encode($subject) . '?=', $message,
            'MIME-Version: 1.0' . PHP_EOL . $header);
    }

    public function send()
    {
        if (!$this->getHeader()) {
            $this->setHeader();
        }
        if (sizeof($this->adress) > 0) {
            foreach ($this->adress as $adress) {
                $this->sendMailUtf8($adress, $this->getSubject(), $this->getBody(), $this->getHeader());
            }
        } else {
            throw new Exception('Отсутствует адресат');
        }
    }

    public function addAdress($mail)
    {
        $this->adress[] = $mail;

        return $this;
    }

    private function addBodyMessage($text)
    {
        $this->body .= '--' . $this->mb() . PHP_EOL .
            'Content-Type: text/plain; charset="UTF-8"' . PHP_EOL .
            'Content-Disposition: inline' . PHP_EOL .
            'Content-Transfer-Encoding: base64' . PHP_EOL . PHP_EOL .
            chunk_split(base64_encode($text)) . PHP_EOL;
    }

    public function addFile($fileName, $fileStream)
    {
        $this->body .= PHP_EOL . '--' . $this->mb() . PHP_EOL .
            'Content-Type: application/octet-stream; name="' . $fileName . '"' . PHP_EOL .
            'Content-Disposition: attachment;' . PHP_EOL .
            ' filename="' . $fileName . '"' . PHP_EOL .
            'Content-Transfer-Encoding: base64' . PHP_EOL . PHP_EOL . chunk_split(base64_encode($fileStream));

        return $this;
    }

    private function endBody()
    {
        return '--' . $this->mb() . '--';
    }

    private function getBody()
    {
        return $this->body . $this->endBody();
    }

    private function mb()
    {
        if (!$this->mb) {
            $this->mb = '_=_Multipart_Boundary_' . substr(md5(uniqid(time())), 0, 8);
        }

        return $this->mb;
    }

    public function setSubject($subject)
    {
        if ($subject) {
            $this->subject = $subject;
        }

        return $this;
    }

    private function getSubject()
    {
        return $this->subject;
    }

    private function setHeader($email = 'No reply')
    {
        $this->header = 'Content-Type: multipart/mixed; boundary="' . $this->mb() . '"' . PHP_EOL . 'X-Mailer: PHP' . PHP_EOL . 'Reply-To: ' . $email . PHP_EOL;

        return $this;
    }

    private function getHeader()
    {
        return $this->header;
    }

    public function debug()
    {
        echo '<pre>' . print_r($this, 1) . '</pre>';
    }
}
