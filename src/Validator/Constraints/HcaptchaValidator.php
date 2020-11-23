<?php

namespace Bolt\BoltForms\Validator\Constraints;

use Bolt\BoltForms\Services\HcaptchaService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class HcaptchaValidator extends ConstraintValidator
{
    /** @var Request */
    private $request;

    /** @var HcaptchaService */
    private $service;

    public function __construct(HcaptchaService $service, RequestStack $requestStack)
    {
        $this->service = $service;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof Hcaptcha) {
            throw new UnexpectedTypeException($constraint, Hcaptcha::class);
        }

        if (empty($this->request->get(HcaptchaService::POST_FIELD_NAME)))
        {
            $this->context->buildViolation($constraint->incompleteMessage)
                ->atPath('my_hcaptcha')
                ->addViolation();
            return;
        }

        $this->service->setKeys($constraint->siteKey, $constraint->secretKey);

        $result = $this->service->validateTokenFromRequest($this->request);

        if ($result !== true)
        {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ error }}', $result)
                ->addViolation();
        }
    }
}