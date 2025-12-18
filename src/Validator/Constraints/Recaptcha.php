<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class Recaptcha extends Constraint
{
    public string $incompleteMessage = 'Please complete the CAPTCHA challenge.';
    public string $message = 'The CAPTCHA challenge failed with "{{ error }}". Please try again or contact the site owner.';

    public function __construct(
        public string $siteKey,
        public string $secretKey,
        public string $recaptchaVersion,
        public float $v3Threshold = 0.0,
        public string $v3ThresholdFailedMessage = ''
    ) {
        parent::__construct();
    }
}
