<?php

namespace App\Validator;

use App\Repository\WordleRepository;
use App\TimesGame\Content\Word\WordService;
use App\TimesGame\WordleCheckService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class WordleIsValidWordValidator extends ConstraintValidator
{


    public function __construct(private WordleCheckService $wordleCheckService)
    {
    }

    public function validate($value, Constraint $constraint): void
    {
        /* @var WordleIsValidWord $constraint */
        if ($this->wordleCheckService->isWordValid($value)){
            return;
        }

        // TODO: implement the validation here
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
