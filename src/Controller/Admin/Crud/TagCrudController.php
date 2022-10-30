<?php

/*
 * This file is part of the Needlify project.
 * Copyright (c) Needlify <https://needlify.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin\Crud;

use App\Entity\Tag;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use App\Controller\Admin\Crud\Traits\ContentCrudTrait;
use App\Controller\Admin\Crud\Traits\ClassifierCrudTrait;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TagCrudController extends AbstractCrudController
{
    use ClassifierCrudTrait;
    use ContentCrudTrait;

    public static function getEntityFqcn(): string
    {
        return Tag::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $this->defaultClassifierCrudConfiguration($crud);
    }

    public function configureFields(string $pageName): iterable
    {
        return $this->defaultClassifierFieldConfiguration($pageName, Tag::class);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $this->defaultContentActionConfiguration($actions, Tag::class);
    }
}
