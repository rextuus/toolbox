<?php

namespace App\Validator;

use App\Controller\Admin\WordleCrudController;
use App\Repository\WordleRepository;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class WordleDeliveryDateIsUniqueValidator extends ConstraintValidator
{


    public function __construct(private WordleRepository $wordleRepository, private AdminUrlGenerator $adminUrlGenerator)
    {
    }

    /**
     * @param DateTime $value
     */
    public function validate($value, Constraint $constraint)
    {
        /* @var WordleDeliveryDateIsUnique $constraint */
        if (null === $value || '' === $value) {
            return;
        }

        $wordles = $this->wordleRepository->findBy(['deliveryDate' => $value], ['deliveryDate' => 'ASC']);
        if (count($wordles) === 0) {
            return;
        }

        if (count($wordles) === 1 && $this->context->getObject()->getId() === $wordles[0]->getId()) {
            return;
        }

        $this->adminUrlGenerator->setController(WordleCrudController::class);
        $this->adminUrlGenerator->setAction('edit');
        $this->adminUrlGenerator->setEntityId($wordles[0]->getId());

        // TODO: implement the validation here
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value->format('Y-m-d'))
            ->setParameter('{{ existing }}', $this->adminUrlGenerator->generateUrl())
            ->setParameter('{{ wordle }}', $wordles[0]->getValue())
            ->addViolation();
    }
}
