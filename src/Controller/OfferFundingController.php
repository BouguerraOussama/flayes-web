<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\Funding;
use App\Entity\User;
use App\Form\OfferFundingType;
use App\Repository\FundingRepository;
use App\Repository\OfferRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Validator\Constraints\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/OfferFunding')]
class OfferFundingController extends AbstractController
{
    #[Route('/', name: 'app_Offerfunding_index', methods: ['GET'])]
    public function index(OfferRepository $offer , FundingRepository $funding, Request $request, UserRepository $userRepository): Response
    {

        return $this->render('OfferFunding/index.html.twig', [
          'offers' => $offer->findAll(),
            'fundings' => $funding->findAll()
        ]);
    }
    #[Route('/new', name: 'app_OfferFunding_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager , UserRepository $userRepository): Response
    {
//       Retrieving User here
        $session=$request->getSession();
        $user =$userRepository->find($session->get('UserId'));
//      End retrieving User here
        $offer = new Offer();
        $funding = new Funding();
        $form = $this->createForm(OfferFundingType::class,  $offer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $formData->setDateCreated(new \DateTime());
            $formData->setStatus(0);

            $offer->setUser($user);

            $funding=$formData->getFunding();
            $this->calculateOfferScore($funding);

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
//        $session=$request->getSession();
        $offer = $entityManager->getRepository(Offer::class)->find($id);
        $funding = $offer->getFunding();
        $this->calculateOfferScore($funding);

        if (!$offer) {
            throw $this->createNotFoundException('The offer does not exist');
        }

        $form = $this->createForm(OfferFundingType::class, $offer, [
            'funding' => $funding,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_Offerfunding_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('OfferFunding/edit.html.twig', [
            'offer' => $offer,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_offer_delete')]
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
        return $this->redirectToRoute('app_Offerfunding_index', [], Response::HTTP_SEE_OTHER);
    }

    private function calculateOfferScore(Funding $funding) {
        switch ($funding->getType()) {
            case 'dept':
                switch ($funding->getTextattribute()) {
                    case 'AAA':
                        $riskScore = 100;
                        break;
                    case 'AA+':
                        $riskScore = 90;
                        break;
                    case 'AA':
                        $riskScore = 80;
                        break;
                    case 'A+':
                        $riskScore = 70;
                        break;
                    case 'A':
                        $riskScore = 60;
                        break;
                    case 'BBB+':
                        $riskScore = 50;
                        break;
                    case 'BBB':
                        $riskScore = 40;
                        break;
                    case 'BB+':
                        $riskScore = 30;
                        break;
                    case 'BB':
                        $riskScore = 20;
                        break;
                    default:
                        $riskScore = 0; // Default score for unknown risk appetite
                }

                $score = ($funding->getAttribute1() * 0.4) +($funding->getAttribute2() * 0.3 ) + ($funding->getAttribute3() * 0.2) + ($riskScore * 0.1);

                break;
            case 'revenue':
                switch($funding->getTextattribute()){
                    case'On sails':
                        $score=($funding->getAttribute1() * 0.4)+ ($funding->getAttribute3() * 0.3);
                        break;
                    case 'On revenue':
                        $score=($funding->getAttribute1() * 0.4)+ ($funding->getAttribute2() * 0.3);
                        break;
                }
                 break;
            case 'equity':
                switch ($funding->getTextattribute()) {
                    case 'Low':
                        $riskScore = 40;
                        break;
                    case 'Medium':
                        $riskScore = 30;
                        break;
                    case 'High':
                        $riskScore = 20;
                        break;
                    default:
                        $riskScore = 0; // Default score for unknown risk appetite
                }
                $score=($funding->getAttribute1() * 0.4)  + ($funding->getAttribute2() * 0.3)   + ($funding->getAttribute3() * 0.2) + ($riskScore * 0.1);
                 break;
        }
        $funding->setScore($score);
    }




}
