<?php

namespace App\Controller;

use App\Repository\FundingRepository;
use App\Repository\OfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/OfferFunding/admin')]
class OfferFundingAdminController extends AbstractController
{
    #[Route('/', name: 'app_offer_funding_admin')]
    public function index(OfferRepository $offer ,FundingRepository $funding): Response
    {
        return $this->render('offer_funding_admin/index.html.twig', [
            'offers' => $offer->findAll(),
            'fundings' => $funding->findAll()
        ]);
    }

    #[Route('/{id}/accept', name: 'app_offer_admin_accept')]
    public function adminAccept(Request $request, $id , EntityManagerInterface $entityManager,OfferRepository $offerRepository): Response
    {
        $offer = $offerRepository->find($id);

        if ($offer) {
            $offer->setStatus(1);
            $entityManager->persist($offer);
            $entityManager->flush();
        }
        else{
            dump($offer);
            die("Error offer not found");
        }
        return $this->redirectToRoute('app_offer_funding_admin', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/{id}/reject', name: 'app_offer_admin_reject')]
    public function adminReject(Request $request, $id , EntityManagerInterface $entityManager,OfferRepository $offerRepository): Response
    {
        $offer = $offerRepository->find($id);

        if ($offer) {
            $offer->setStatus(2);
            $entityManager->persist($offer);

            $entityManager->flush();
        }
        else{
            dump($offer);
            die("Error offer not found");
        }
        return $this->redirectToRoute('app_offer_funding_admin', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_offer_admin_delete')]
    public function delete(Request $request, $id , EntityManagerInterface $entityManager,OfferRepository $offerRepository): Response
    {
        $offer = $offerRepository->find($id);

        if ($offer) {
            $entityManager->remove($offer);
            $entityManager->remove($offer->getFunding());
            $entityManager->flush();
        }
        else{
            dump($offer);
            die("Error offer not found");
        }
        return $this->redirectToRoute('app_offer_funding_admin', [], Response::HTTP_SEE_OTHER);
    }
}
