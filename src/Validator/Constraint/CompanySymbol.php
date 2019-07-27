<?php declare(strict_types=1);

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CompanySymbol extends Constraint
{
    public $message = 'The Company symbol "{{ string }}" is not valid';

}
