<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Topic;
use App\Service\ClassifierType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClassifierController extends AbstractController
{
    #[Route('/topic/{slug}', name: 'app_topic', methods: ['GET'], options: ['expose' => true])]
    public function topicList(Topic $topic): Response
    {
        return $this->render('pages/classifier.html.twig', [
            'selector' => ClassifierType::TOPIC->value,
            'classifier' => $topic,
        ]);
    }

    #[Route('/tag/{slug}', name: 'app_tag', methods: ['GET'], options: ['expose' => true])]
    public function tagList(Tag $tag): Response
    {
        return $this->render('pages/classifier.html.twig', [
            'selector' => ClassifierType::TAG->value,
            'classifier' => $tag,
        ]);
    }
}
