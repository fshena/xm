<?php declare(strict_types=1);

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use App\Service\CompanySymbol as SymbolService;

class CompanySymbolValidator extends ConstraintValidator
{
    private $service;

    /**
     * CompanySymbolValidator constructor.
     *
     * @param SymbolService $companySymbol
     */
    public function __construct(SymbolService $companySymbol)
    {
        $this->service = $companySymbol;
    }

    public function validate($value, Constraint $constraint)
    {
        if (! $constraint instanceof CompanySymbol) {
            throw new UnexpectedTypeException($constraint, CompanySymbol::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (! is_string($value)) {
            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
            throw new UnexpectedValueException($value, 'string');
        }

        if (! $this->service->isValidSymbol($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}
