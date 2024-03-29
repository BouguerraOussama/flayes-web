<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\Funding;
use App\Form\OfferFundingType;
use App\Form\OfferType;
use App\Repository\FundingRepository;
use App\Repository\OfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/OfferFunding')]
class OfferFundingController extends AbstractController
{
    #[Route('/', name: 'app_Offerfunding_index', methods: ['GET'])]
    public function index(OfferRepository $offer ,FundingRepository $funding): Response
    {
        return $this->render('OfferFunding/index.html.twig', [
          'offers' => $offer->findAll(),
            'fundings' => $funding->findAll()
        ]);
    }
    #[Route('/new', name: 'app_OfferFunding_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $offer = new Offer();
        $funding = new Funding();
        $form = $this->createForm(OfferFundingType::class,  $offer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $formData->setDateCreated(new \DateTime());
            $funding=$formData->getFunding();

            $entityManager->persist($offer);
            $entityManager->persist($funding);
            $entityManager->flush();

            return $this->redirectToRoute('app_Offerfunding_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('OfferFunding/new.html.twig', [
            'Offer' => $offer,
            'Funding' => $funding,
            'form' => $form,
        ]);
    }
    #[Route('/{id}/edit', name: 'app_OfferFunding_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, $id , EntityManagerInterface $entityManager): Response
    {
        $offer = $entityManager->getRepository(Offer::class)->find($id);
        $funding = $offer->getFunding(); // Assuming Offer has a method to retrieve associated Funding
        dump($funding);
        if (!$offer) {
            throw $this->createNotFoundException('The offer does not exist');
        }

        $form = $this->createForm(OfferFundingType::class, $offer,[
            'funding' => $funding]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_Offerfunding_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('OfferFunding/edit.html.twig', [
            'Offer' => $offer,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'app_offer_delete', methods: ['POST'])]
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
            die("Couldn't remove offer");
        }
        return $this->redirectToRoute('app_Offerfunding_index', [], Response::HTTP_SEE_OTHER);
    }

}
