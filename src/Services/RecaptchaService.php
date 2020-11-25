<?php

namespace Bolt\BoltForms\Services;

use Bolt\BoltForms\CaptchaException;
use Symfony\Component\HttpFoundation\Request;

class RecaptchaService
{
    const POST_FIELD_NAME = 'g-recaptcha-response';

    /** @var string */
    private $secretKey;

    /** @var string */
    private $siteKey;

    public function setKeys($siteKey, $secretKey)
    {
        $this->siteKey = $siteKey;
        $this->secretKey = $secretKey;
    }

    public function validateTokenFromRequest(Request $request, $debug = false)
    {
        $validationData = [
            'secret' => $this->secretKey,
            'response' => $request->get(self::POST_FIELD_NAME),
            'remoteip' => $request->getClientIp()
        ];
        $this->dump($debug, $validationData);

        $postData = http_build_query($validationData);
        $this->dump($debug, $postData);

        $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]);

        $response = curl_exec($ch);
        $this->dump($debug, $response);

        $jsonResponse = json_decode($response);

        if ($jsonResponse === false)
        {
            throw new CaptchaException(sprintf('Unexpected response: %s', $response));
        }

        if ($jsonResponse->success) {
            return true;
        } else {
            return join(',', $jsonResponse->{'error-codes'});
        }
    }

    private function dump($isDebugMode, $valueToDump)
    {
        if ($isDebugMode)
        {
            dump($valueToDump);
        }
    }
}
