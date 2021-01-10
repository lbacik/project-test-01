<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ItemsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class DashboardController extends AbstractController
{
    public function __construct(
        public Environment $twig
    ) {}

    #[Route('/', name: 'dashboard')]
    public function index(ItemsRepository $itemRepository): Response
    {
        return new Response(
            $this->twig->render(
                'dashboard/index.html.twig',
                [
                    'itemsInDb' => $itemRepository->findAll(),
                ]
            ),
        );
    }
}
