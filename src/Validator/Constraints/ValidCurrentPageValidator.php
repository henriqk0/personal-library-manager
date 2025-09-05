<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ValidCurrentPageValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ValidCurrentPage) {
            throw new UnexpectedTypeException($constraint, ValidCurrentPage::class);
        }

        if ($value > $this->context->getObject()->getBook()->getNumPages()) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}