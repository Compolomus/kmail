<?php declare(strict_types=1);

namespace Compolomus\Kmail;

class KMail
{
    const VERSION = '1.0';

    const RELEASE_DATE = '2017-04-24';

    private $mb;

    private $header;

    private $subject = '(No subject)';

    private $adress = [];

    private $body;

    public function __construct(string $text)
    {
        $this->addBodyMessage($text);
        $this->mb();
    }

    private function sendMailUtf8(string $adress, string $subject, string $message, string $header): bool
    {
        return mail($adress, '=?UTF-8?B?' . base64_encode($subject) . '?=', $message,
            'MIME-Version: 1.0' . PHP_EOL . $header);
    }

    public function send(): ?\Exception
    {
        $this->getHeader();
        if (sizeof($this->adress) > 0) {
            foreach ($this->adress as $adress) {
                $this->sendMailUtf8($adress, $this->getSubject(), $this->getBody(), $this->getHeader());
            }
        } else {
            throw new Exception('Отсутствует адресат');
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
        $this->body .= '--' . $this->mb() . PHP_EOL .
            'Content-Type: text/plain; charset="UTF-8"' . PHP_EOL .
            'Content-Disposition: inline' . PHP_EOL .
            'Content-Transfer-Encoding: base64' . PHP_EOL . PHP_EOL .
            chunk_split(base64_encode($text)) . PHP_EOL;
    }

    public function addFile(string $fileName, string $fileStream): KMail
    {
        $this->body .= PHP_EOL . '--' . $this->mb() . PHP_EOL .
            'Content-Type: application/octet-stream; name="' . $fileName . '"' . PHP_EOL .
            'Content-Disposition: attachment;' . PHP_EOL .
            ' filename="' . $fileName . '"' . PHP_EOL .
            'Content-Transfer-Encoding: base64' . PHP_EOL . PHP_EOL . chunk_split(base64_encode($fileStream));

        return $this;
    }

    private function endBody(): string
    {
        return '--' . $this->mb() . '--';
    }

    private function getBody(): string
    {
        return $this->body . $this->endBody();
    }

    private function mb(): string
    {
        if (!$this->mb) {
            $this->mb = '_=_Multipart_Boundary_' . substr(md5(uniqid()), 0, 8);
        }

        return $this->mb;
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
            $this->header = 'Content-Type: multipart/mixed; boundary="' . $this->mb() . '"' . PHP_EOL . 'X-Mailer: PHP' . PHP_EOL . 'Reply-To: No reply' . PHP_EOL;
        }
        return $this->header;
    }

    public function debug(): void
    {
        echo '<pre>' . print_r($this, true) . '</pre>';
    }
}
