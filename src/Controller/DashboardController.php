<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ItemsRepository;
use App\Service\RedisService;
use App\Service\UploadService;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class DashboardController extends AbstractController
{
    public function __construct(
        public Environment $twig
    ) {}

    #[Route('/', name: 'dashboard')]
    public function index(
        Request $request,
        UploadService $uploadService,
        ItemsRepository $itemRepository,
        RedisService $redisService
    ): Response {

        $itemsInDb = $itemRepository->findAll();

        $form = $this->uploadForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $uploadService->uploadToRedis($itemsInDb);
        }

        $itemsInRedis = $this->mapToObjects(
            $redisService->getAll()
        );

        return new Response(
            $this->twig->render(
                'dashboard/index.html.twig',
                [
                    'itemsInDb' => $itemsInDb,
                    'itemsInRedis' => $itemsInRedis,
                    'UploadForm' => $form->createView(),
                ]
            ),
        );
    }

    private function uploadForm(): FormInterface
    {
        return $this->createFormBuilder(
                [],
                [
                    'action' => $this->generateUrl('dashboard'),
                ]
            )
            ->add('Upload', SubmitType::class)
            ->getForm();
    }

    private function mapToObjects(array $associativeArray): array
    {
        $result = [];
        foreach($associativeArray as $key => $value) {

            $obj = new stdClass();

            $obj->name = $key;
            $obj->value = $value;

            $result[] = $obj;
        }
        return $result;
    }
}
