<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Validator\Constraints;

use Bolt\BoltForms\Services\RecaptchaService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class RecaptchaValidator extends ConstraintValidator
{
    /** @var Request */
    private $request;

    /** @var RecaptchaService */
    private $service;

    public function __construct(RecaptchaService $service, RequestStack $requestStack)
    {
        $this->service = $service;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function validate($value, Constraint $constraint): void
    {
        if (! $constraint instanceof Recaptcha) {
            throw new UnexpectedTypeException($constraint, Recaptcha::class);
        }

        if (empty($this->request->get(RecaptchaService::POST_FIELD_NAME))) {
            $this->context->buildViolation($constraint->incompleteMessage)
                ->addViolation();

            return;
        }

        $this->service->setKeys($constraint->siteKey, $constraint->secretKey);

        $result = $this->service->validateTokenFromRequest($this->request);

        if ($result !== true) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ error }}', $result)
                ->addViolation();
        }
    }
}
