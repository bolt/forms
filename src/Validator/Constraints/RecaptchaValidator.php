<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Validator\Constraints;

use Bolt\BoltForms\Services\RecaptchaService;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class RecaptchaValidator extends ConstraintValidator
{
    public function __construct(
        private readonly RecaptchaService $service,
        private readonly RequestStack $requestStack
    ) {
    }

    public function validate($value, Constraint $constraint): void
    {
        if (! $constraint instanceof Recaptcha) {
            throw new UnexpectedTypeException($constraint, Recaptcha::class);
        }

        $request = $this->requestStack->getCurrentRequest();
        if (empty($request->get(RecaptchaService::POST_FIELD_NAME))) {
            $this->context->buildViolation($constraint->incompleteMessage)
                ->addViolation();

            return;
        }

        $this->service->setKeys($constraint->siteKey, $constraint->secretKey);
        $this->service->setRecaptchaVersion($constraint->recaptchaVersion);
        if (isset($constraint->v3Threshold)) {
            $this->service->setV3Threshold($constraint->v3Threshold);
        }

        $result = $this->service->validateTokenFromRequest($request);

        if ($result !== true) {
            if ($result === false) {
                $this->context->buildViolation($constraint->v3ThresholdFailedMessage)
                    ->addViolation();
            } else {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ error }}', $result)
                    ->addViolation();
            }
        }
    }
}
