<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class ValidCurrentPage extends Constraint
{
    public $message = 'The current page cannot exceed the number of pages in the book.';
}
