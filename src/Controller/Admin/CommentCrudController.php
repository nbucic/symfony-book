<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Conference comment')
            ->setEntityLabelInPlural('Conference comments')
            ->setSearchFields(['author', 'text', 'email'])
            ->setDefaultSort(['createdAt' => 'DESC']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters->add(EntityFilter::new('conference'));
    }


    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('conference', 'Conference');
        yield TextField::new('author', 'Author');
        yield EmailField::new('email', 'Email');
        yield TextareaField::new('text', 'Text')->hideOnIndex();
        yield ImageField::new('photoFilename', 'Photo filename')->setBasePath('/uploads/photos')
            ->onlyOnIndex();
        yield TextField::new('state');

        $createdAt = DateTimeField::new('createdAt', 'Created at')
            ->setFormTypeOptions([
                'years' => range(date('Y'), (int)date('Y') + 5),
                'widget' => 'single_text'
            ]);

        if (Crud::PAGE_EDIT === $pageName) {
            yield $createdAt->setFormTypeOption('disabled', true);
        } else {
            yield $createdAt;
        }
    }
}
