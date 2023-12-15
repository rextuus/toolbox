<?php

namespace App\Controller;

use App\Form\AddRecommendationType;
use App\Stock\Content\CsvReader;
use App\Stock\Content\DailyValue\StockDailyValueService;
use App\Stock\Content\Recommendation\Data\StockRecommendationData;
use App\Stock\Content\Recommendation\StockRecommendationService;
use App\Stock\FileMoveService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/stock')]
class StockController extends AbstractController
{
    #[Route('/', name: 'tool_stock_dashboard')]
    public function index(): Response
    {
        return $this->render('stock/index.html.twig', [
            'controller_name' => 'StockController',
        ]);
    }

    #[Route('/add', name: 'tool_stock_add_recommendation')]
    public function addRecommendation(
        Request $request,
        FileMoveService $moveService,
        CsvReader $csvReader,
        StockRecommendationService $recommendationService,
        StockDailyValueService $stockDailyValueService,
    ): Response
    {
        $data = new StockRecommendationData();
        $form = $this->createForm(AddRecommendationType::class, $data);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var StockRecommendationData $data */
            $data = $form->getData();

            $moveService->moveFiles(str_replace(' ', '_', $data->getCompanyName()));
            $rows = $csvReader->readFinancialDataFromCsv(str_replace(' ', '_', $data->getCompanyName()) . '.csv');

            $recommendationData = new StockRecommendationData();
            $recommendationData->setRecommendationDay($data->getRecommendationDay());
            $recommendationData->setCompanyName($data->getCompanyName());
            $recommendation = $recommendationService->createByData($recommendationData);

            $stockDailyValueService->createMultipleByData($rows, $recommendation);
        }

        return $this->render('stock/add_recommendation.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
