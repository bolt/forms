<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Services;

use Bolt\BoltForms\CaptchaException;
use Bolt\BoltForms\Extension;
use Bolt\Extension\ExtensionRegistry;
use Symfony\Component\HttpFoundation\Request;

class RecaptchaService
{
    public const POST_FIELD_NAME = 'g-recaptcha-response';

    /** @var ExtensionRegistry */
    private $registry;

    /** @var string */
    private $secretKey;

    /** @var float */
    private $v3Threshold;

    public function __construct(ExtensionRegistry $extensionRegistry)
    {
        $this->registry = $extensionRegistry;
    }

    public function setKeys(?string $siteKey = null, string $secretKey): void
    {
        // Note: $siteKey is not used, but here to stay in sync with HcaptchaService.php
        $this->secretKey = $secretKey;
    }

    public function setV3Thresold(float $v3Threshold): void {
        $this->v3Threshold = $v3Threshold;
    }

    public function validateTokenFromRequest(Request $request)
    {
        $extension = $this->registry->getExtension(Extension::class);

        $validationData = [
            'secret' => $this->secretKey,
            'response' => $request->get(self::POST_FIELD_NAME),
            'remoteip' => $request->getClientIp(),
        ];
        $extension->dump($validationData);

        $postData = http_build_query($validationData);
        $extension->dump($postData);

        $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
        ]);

        $response = curl_exec($ch);
        $extension->dump($response);

        $jsonResponse = json_decode($response);

        if ($jsonResponse === false) {
            throw new CaptchaException(sprintf('Unexpected response: %s', $response));
        }

        if ($jsonResponse->success) {
            if($jsonResponse->score < $this->v3Threshold){
                return false;
            }
            return true;
        }

        return implode(',', $jsonResponse->{'error-codes'});
    }
}
