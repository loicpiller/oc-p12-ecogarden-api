<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\TipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class TipController extends AbstractController
{
    #[Route('/conseil/', name: 'current_tip', methods: ['GET'])]
    public function getTipsForCurrentMonth(TipRepository $tipRepository): JsonResponse
    {
        $month = (int) date('n');
        return $this->json($tipRepository->findApplicableForMonth($month));
    }
}
