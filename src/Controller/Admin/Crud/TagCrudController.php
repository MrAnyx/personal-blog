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
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use App\Controller\Admin\Crud\Traits\ContentCrudTrait;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Controller\Admin\Crud\Traits\ClassifierCrudTrait;
use App\Controller\Admin\Crud\Traits\CrudTranslationTrait;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TagCrudController extends AbstractCrudController
{
    use ClassifierCrudTrait, ContentCrudTrait, CrudTranslationTrait {
        ContentCrudTrait::__construct as private __contentConstruct;
        CrudTranslationTrait::__construct as private __translationConstruct;
    }

    public function __construct(UrlGeneratorInterface $urlGenerator, TranslatorInterface $translator)
    {
        $this->__contentConstruct($urlGenerator);
        $this->__translationConstruct($translator);
    }

    public static function getEntityFqcn(): string
    {
        return Tag::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $this->defaultClassifierCrudConfiguration($crud)
                    ->setPageTitle(Crud::PAGE_INDEX, $this->translator->trans('admin.crud.tag.index.title', [], 'admin'))
                    ->setPageTitle(Crud::PAGE_NEW, $this->translator->trans('admin.crud.tag.new.title', [], 'admin'))
                    ->setPageTitle(Crud::PAGE_EDIT, $this->translator->trans('admin.crud.tag.edit.title', [], 'admin'))
                    ->setPageTitle(Crud::PAGE_DETAIL, $this->translator->trans('admin.crud.tag.details.title', [], 'admin'));
    }

    public function configureFields(string $pageName): iterable
    {
        return $this->defaultClassifierFieldConfiguration($pageName, Tag::class);
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions->update(Crud::PAGE_INDEX, Action::NEW, fn (Action $action) => $action->setLabel('admin.crud.tag.actions.create'));

        return $this->defaultContentActionConfiguration($actions, Tag::class);
    }
}
