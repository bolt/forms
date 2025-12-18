<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Validator\Constraints;

use Bolt\BoltForms\Services\HcaptchaService;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class HcaptchaValidator extends ConstraintValidator
{
    public function __construct(
        private readonly HcaptchaService $service,
        private readonly RequestStack $requestStack
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (! $constraint instanceof Hcaptcha) {
            throw new UnexpectedTypeException($constraint, Hcaptcha::class);
        }

        $request = $this->requestStack->getCurrentRequest();
        if (empty($request?->request->get(HcaptchaService::POST_FIELD_NAME))) {
            $this->context->buildViolation($constraint->incompleteMessage)
                ->addViolation();

            return;
        }

        $this->service->setKeys($constraint->siteKey, $constraint->secretKey);

        $result = $this->service->validateTokenFromRequest($request);

        if ($result !== true) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ error }}', $result)
                ->addViolation();
        }
    }
}
