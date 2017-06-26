<?php declare(strict_types=1);

namespace Compolomus\Kmail;

class KMail
{
    const VERSION = '1.1';

    const RELEASE_DATE = '2017-06-26';

    private $bound;

    private $header;

    private $subject = '(No subject)';

    private $adress = [];

    private $body;

    public function __construct(string $text)
    {
        $this->addBodyMessage($text);
        $this->bound();
    }

    private function sendMailUtf8(string $adress, string $subject, string $message, string $header): bool
    {
        return mail($adress, '=?UTF-8?B?' . base64_encode($subject) . '?=', $message,
            'MIME-Version: 1.0' . PHP_EOL . $header);
    }

    public function send(): ?\Exception
    {
        if (sizeof($this->adress) == 0) {
            throw new \Exception('Отсутствует адресат');
        } else {
            $this->getHeader();
            foreach ($this->adress as $adress) {
                $this->sendMailUtf8($adress, $this->getSubject(), $this->getBody(), $this->getHeader());
            }
        }
        return null;
    }

    public function addAdress(string $mail): KMail
    {
        $this->adress[] = $mail;
        return $this;
    }

    private function addBodyMessage(string $text): void
    {
        $this->body .= '--' . $this->bound() . PHP_EOL .
            'Content-Type: text/plain; charset="UTF-8"' . PHP_EOL .
            'Content-Disposition: inline' . PHP_EOL .
            'Content-Transfer-Encoding: base64' . PHP_EOL . PHP_EOL .
            chunk_split(base64_encode($text)) . PHP_EOL;
    }

    public function addFile(string $fileName, string $fileStream): KMail
    {
        $this->body .= PHP_EOL . '--' . $this->bound() . PHP_EOL .
            'Content-Type: application/octet-stream; name="' . $fileName . '"' . PHP_EOL .
            'Content-Disposition: attachment;' . PHP_EOL .
            ' filename="' . $fileName . '"' . PHP_EOL .
            'Content-Transfer-Encoding: base64' . PHP_EOL . PHP_EOL . chunk_split(base64_encode($fileStream));

        return $this;
    }

    private function endBody(): string
    {
        return '--' . $this->bound() . '--';
    }

    private function getBody(): string
    {
        return $this->body . $this->endBody();
    }

    private function mb(): string
    {
        if (!$this->bound) {
            $this->bound = '_=_Multipart_Boundary_' . substr(md5(uniqid()), 0, 8);
        }

        return $this->bound;
    }

    public function setSubject(string $subject): KMail
    {
        if ($subject) {
            $this->subject = $subject;
        }

        return $this;
    }

    private function getSubject(): string
    {
        return $this->subject;
    }

    private function getHeader(): string
    {
        if (!$this->header) {
            $this->header = 'Content-Type: multipart/mixed; boundary="' . $this->bound() . '"' . PHP_EOL . 'X-Mailer: PHP' . PHP_EOL . 'Reply-To: No reply' . PHP_EOL;
        }
        return $this->header;
    }

    public function debug(): void
    {
        echo '<pre>' . print_r($this, true) . '</pre>';
    }
}
