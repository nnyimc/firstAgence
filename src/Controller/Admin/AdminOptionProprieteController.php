<?php

namespace App\Controller\Admin;

use App\Entity\OptionPropriete;
use App\Form\OptionProprieteType;
use App\Repository\OptionProprieteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class AdminOptionProprieteController extends AbstractController
{
    /**
     * @var OptionProprieteRepository
     */
    private $optionRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(OptionProprieteRepository $optionRepository, EntityManagerInterface $entityManager)
    {
        $this->optionRepository = $optionRepository;
        $this->entityManager = $entityManager;
    }

    /** Cette methode retourne une liste de toutes les options
     * @Route("/admin/options", name="admin.options", methods="GET");
     * @return Response
     */
    public function home(): Response
    {
        $options = $this->listerOptions();
        return $this->render('pages/admin/options.html.twig', [
            'options' => $options
        ]);
    }

    /** Cette méthode crée une nouvelle option avant de retourner la liste de toutes les options
     * @Route("/admin/newOption", name="admin.option.new", methods="GET|POST");
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $option = new OptionPropriete();
        $formOption = $this->createForm(OptionProprieteType::class, $option);
        $formOption->handleRequest($request);

        if ($formOption->isSubmitted() && $formOption->isValid()) {

            $this->entityManager->persist($option);
            $this->entityManager->flush();

            $this->addFlash('success','Option ajoutée avec succès !');
            $options = $this->listerOptions();

            return $this->redirectToRoute(
                'admin.options',
                [
                    'options' => $options
                ],
                301
            );
        }

        return $this->render('pages/admin/option-new.html.twig', [
            'option' => $option,
            'formOption' => $formOption->createView()
            ]
        );
    }

    /** Cette methode modifie une option préexistante avant de retourner la liste d'options
     * @Route("admin/editOption/{id}", name="admin.option.edit", methods="GET|POST");
     * @param Request $request
     * @param OptionPropriete $option
     * @return Response
     */
    public function edit(Request $request, OptionPropriete $option): Response
    {
        $formOption = $this->createForm(OptionProprieteType::class, $option);
        $formOption->handleRequest($request);

        if ($formOption->isSubmitted() && $formOption->isValid()) {

            $this->entityManager->persist($option);
            $this->entityManager->flush();

            $this->addFlash('success','Option modifiée avec succès !');
            $options = $this->listerOptions();

            return $this->redirectToRoute(
                'admin.options',
                [
                    'options' => $options
                ],
                301
            );
        }

        return $this->render('pages/admin/option-edit.html.twig', [
            'option' => $option,
            'formOption' => $formOption->createView(),
        ]);
    }

    /**
     * @Route("/admin/deleteOption/{id}", name="admin.option.delete", methods="POST");
     * @param Request $request
     * @param OptionPropriete $option
     * @return Response
     */
    public function delete(Request $request, OptionPropriete $option): Response
    {
        if ($this->isCsrfTokenValid('delete'.$option->getId(), $request->request->get('_token'))) {

            $this->entityManager->remove($option);
            $this->entityManager->flush();

            $this->addFlash('success','Option supprimée avec succès !');
            $options = $this->listerOptions();

            return $this->redirectToRoute(
                'admin.options',
                [
                    'options' => $options
                ],
                301
            );
        }

    }

    /**
     * @return array
     */
    private function listerOptions(): array {
        return $this->optionRepository->findAll();
    }
}
