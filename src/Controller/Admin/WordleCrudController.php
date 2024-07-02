<?php

namespace App\Controller\Admin;

use App\Entity\Wordle;
use App\Repository\WordleRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WordleCrudController extends AbstractCrudController
{


    public function __construct(private WordleRepository $wordleRepository)
    {
    }

    public static function getEntityFqcn(): string
    {
        return Wordle::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['deliveryDate' => 'ASC'])
            ->setEntityLabelInPlural('Wordles')
            ->setEntityLabelInSingular('Wordle')
            ->setPageTitle(Crud::PAGE_INDEX, 'Manage your Wordles')
            ->setSearchFields(['value', 'deliveryDate'])
            ->setPaginatorPageSize(30)
            ->setEntityPermission('ROLE_ADMIN');
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IntegerField::new('id')->setDisabled()->hideWhenCreating(),
            TextField::new('value'),
        ];

        $deliveryDateField = DateField::new('deliveryDate')->addCssClass('delivery-date');

        if (Crud::PAGE_NEW === $pageName) {
            $deliveryDateField->setFormTypeOptions([
                'data' => $this->wordleRepository->findNextDateGap(),
            ]);
        }

        $fields[] = $deliveryDateField;

        return $fields;
    }
}
