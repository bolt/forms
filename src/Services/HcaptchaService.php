<?php

namespace Bolt\BoltForms\Services;

use Bolt\BoltForms\CaptchaException;
use Symfony\Component\HttpFoundation\Request;

class HcaptchaService
{
    const POST_FIELD_NAME = 'h-captcha-response';

    /** @var string */
    private $secretKey;

    /** @var string */
    private $siteKey;

    public function setKeys($siteKey, $secretKey)
    {
        $this->siteKey = $siteKey;
        $this->secretKey = $secretKey;
    }

    public function validateTokenFromRequest(Request $request)
    {
        $validationData = [
            'secret' => $this->secretKey,
            'response' => $request->get(self::POST_FIELD_NAME),
            'remoteip' => $request->getClientIp(),
            'sitekey' => $this->siteKey
        ];

        $ch = curl_init('https://hcaptcha.com/siteverify');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($validationData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]);
        $response = curl_exec($ch);
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
}