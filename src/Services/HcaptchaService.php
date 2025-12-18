<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Services;

use Bolt\BoltForms\CaptchaException;
use Bolt\BoltForms\Extension;
use Bolt\Extension\ExtensionRegistry;
use Symfony\Component\HttpFoundation\Request;

class HcaptchaService
{
    public const POST_FIELD_NAME = 'h-captcha-response';

    private ?string $secretKey = null;
    private ?string $siteKey = null;

    public function __construct(
        private readonly ExtensionRegistry $registry
    ) {
    }

    public function setKeys(string $siteKey, string $secretKey): void
    {
        $this->siteKey = $siteKey;
        $this->secretKey = $secretKey;
    }

    public function validateTokenFromRequest(Request $request): bool|string
    {
        /** @var Extension $extension */
        $extension = $this->registry->getExtension(Extension::class);

        $validationData = [
            'secret' => $this->secretKey,
            'response' => $request->request->get(self::POST_FIELD_NAME),
            'remoteip' => $request->getClientIp(),
            'sitekey' => $this->siteKey,
        ];
        $extension->dump($validationData);

        $postData = http_build_query($validationData);
        $extension->dump($postData);

        $ch = curl_init('https://hcaptcha.com/siteverify');
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
            return true;
        }

        return implode(',', $jsonResponse->{'error-codes'});
    }
}
