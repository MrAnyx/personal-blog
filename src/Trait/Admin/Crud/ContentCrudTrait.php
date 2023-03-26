<?php

/*
 * This file is part of the Needlify project.
 *
 * Copyright (c) Needlify <https://needlify.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Trait\Admin\Crud;

use App\Entity\Tag;
use App\Entity\Topic;
use App\Entity\Course;
use App\Entity\Lesson;
use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Contracts\Service\Attribute\Required;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

trait ContentCrudTrait
{
    private UrlGeneratorInterface|null $urlGenerator;

    #[Required]
    public function setUrlGenerator(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function defaultContentActionConfiguration(Actions $actions, string $classifierFqcn): Actions
    {
        $actions->add(Crud::PAGE_INDEX, Action::DETAIL)->update(Crud::PAGE_INDEX, Action::DETAIL, fn (Action $action) => $action->setLabel('admin.crud.action.details'));

        $actionLabel = null;
        $actionRouteName = null;
        $url = null;

        if (Tag::class === $classifierFqcn) {
            $actionLabel = 'admin.crud.action.view_tag';
            $actionRouteName = 'app_tag';
            $url = fn (Tag $tag) => $this->urlGenerator->generate($actionRouteName, ['slug' => $tag->getSlug()]);
        } elseif (Topic::class === $classifierFqcn) {
            $actionLabel = 'admin.crud.action.view_topic';
            $actionRouteName = 'app_topic';
            $url = fn (Topic $topic) => $this->urlGenerator->generate($actionRouteName, ['slug' => $topic->getSlug()]);
        } elseif (Article::class === $classifierFqcn) {
            $actionLabel = 'admin.crud.action.view_article';
            $actionRouteName = 'app_article';
            $url = fn (Article $article) => $this->urlGenerator->generate($actionRouteName, ['slug' => $article->getSlug()]);
        } elseif (Course::class === $classifierFqcn) {
            $actionLabel = 'admin.crud.action.view_course';
            $actionRouteName = 'app_course';
            $url = fn (Course $course) => $this->urlGenerator->generate($actionRouteName, ['slug' => $course->getSlug()]);
        } elseif (Lesson::class === $classifierFqcn) {
            $actionLabel = 'admin.crud.action.view_lesson';
            $actionRouteName = 'app_lesson';
            $url = fn (Lesson $lesson) => $lesson->getCourse() ? $this->urlGenerator->generate($actionRouteName, [
                    'course_slug' => $lesson->getCourse()?->getSlug(),
                    'lesson_slug' => $lesson->getSlug(),
                ]) : '';
        }

        if ($actionLabel && $actionRouteName && $url) {
            $goToActionIndex = Action::new('goTo', $actionLabel)
                ->linkToUrl($url)
                ->displayIf(fn (Lesson $lesson) => null !== $lesson->getCourse());
            $goToActionDetail = Action::new('goTo', $actionLabel)
                ->linkToUrl($url)
                ->displayIf(fn (Lesson $lesson) => null !== $lesson->getCourse())
                ->addCssClass('btn btn-secondary');

            $actions
                ->add(Crud::PAGE_INDEX, $goToActionIndex)
                ->add(Crud::PAGE_DETAIL, $goToActionDetail);
        }

        // ->update(Crud::PAGE_DETAIL, Action::DELETE, fn (Action $action) => $action->setLabel(''))
        // ->update(Crud::PAGE_DETAIL, Action::INDEX, fn (Action $action) => $action->setLabel('')->setIcon('fas fa-list'))
        // ->update(Crud::PAGE_DETAIL, Action::EDIT, fn (Action $action) => $action->setLabel('')->setIcon('fas fa-edit'))
        // ->update(Crud::PAGE_DETAIL, 'goTo', fn (Action $action) => $action->setLabel('')->setIcon('fas fa-eye'))

        // ->reorder(Crud::PAGE_DETAIL, [Action::DELETE, 'goTo', Action::INDEX, Action::EDIT])

        return $actions;
    }
}
