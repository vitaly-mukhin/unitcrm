<?php

namespace App\Controller\Admin;

use App\Entity\CoreUser;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CoreUserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CoreUser::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
