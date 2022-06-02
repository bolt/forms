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
    public const RECAPTCHA_VERSION_2 = 'recaptcha_v2';
    public const RECAPTCHA_VERSION_3 = 'recaptcha_v3';

    /** @var ExtensionRegistry */
    private $registry;

    /** @var string */
    private $secretKey;

    /** @var float */
    private $v3Threshold;

    /** @var string */
    private $recaptchaVersion;

    public function __construct(ExtensionRegistry $extensionRegistry)
    {
        $this->registry = $extensionRegistry;
    }

    public function setKeys(?string $siteKey = null, string $secretKey): void
    {
        // Note: $siteKey is not used, but here to stay in sync with HcaptchaService.php
        $this->secretKey = $secretKey;
    }

    /**
     */
    public function setRecaptchaVersion(string $recaptchaVersion): void
    {
        $this->recaptchaVersion = $recaptchaVersion;
    }

    public function setV3Threshold(float $v3Threshold): void
    {
        $v3Threshold = round($v3Threshold, 1);

        if ($v3Threshold >= 0.0 && $v3Threshold <= 1.0) {
            $this->v3Threshold = $v3Threshold;
        } else {
            throw new CaptchaException('Score must be between 0.0 and 1.0, you provided: ' . $v3Threshold);
        }
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
            if ($this->recaptchaVersion === self::RECAPTCHA_VERSION_3 && $jsonResponse->score < $this->v3Threshold) {
                return false;
            }

            return true;
        }

        return implode(',', $jsonResponse->{'error-codes'});
    }
}
