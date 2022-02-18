<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class Recaptcha extends Constraint
{
    /** @var string */
    public $incompleteMessage = 'Please complete the CAPTCHA challenge.';

    /** @var string */
    public $message = 'The CAPTCHA challenge failed with "{{ error }}". Please try again or contact the site owner.';

    /** @var string */
    public $secretKey;

    /** @var string */
    public $siteKey;

    /** @var float */
    public $v3Threshold;

    /** @var string */
    public $v3ThresholdFailedMessage;

    public $recaptchaVersion;

    public function __construct($siteKey, $secretKey, $recaptchaVersion, $v3Threshold = 0.0, $v3ThresholdFailedMessage = '')
    {
        $this->siteKey = $siteKey;
        $this->secretKey = $secretKey;
        $this->recaptchaVersion = $recaptchaVersion;
        $this->v3Threshold = $v3Threshold;
        $this->v3ThresholdFailedMessage = $v3ThresholdFailedMessage;
    }
}
