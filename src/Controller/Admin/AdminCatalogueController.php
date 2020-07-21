<?php
namespace  App\Controller\Admin;

use App\Entity\Propriete;
use App\Form\ProprieteType;
use App\Repository\ProprieteRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCatalogueController extends AbstractController
{
    /**
     * @var ProprieteRepository
     */
    private $proprieteRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @ Propriete
     */
    private $proprietes;

    /**
     * AdminCatalogueController constructor.
     * @param ProprieteRepository $proprieteRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ProprieteRepository $proprieteRepository, EntityManagerInterface $entityManager)
    {
        $this->proprieteRepository = $proprieteRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route ("/admin/editPropriete/{id}", name="admin.catalogue.edit", methods="GET|POST");
     * @param Propriete $propriete
     * @param Request $request
     * @return Response
     */
    public function edit(Propriete $propriete, Request $request): Response
    {
        $formPropriete = $this->createForm(ProprieteType::class, $propriete);
        $formPropriete->handleRequest($request);

        if($formPropriete->isSubmitted() && $formPropriete-> isValid()) {
            $this->entityManager->persist($propriete);
            $this->entityManager->flush();
            $this->addFlash('success','Propriété modifiée avec succès !');
            $this->proprietes = $this->listerProprietes();
            return $this->redirectToRoute('admin.catalogue', [
                'proprietes' => $this->proprietes
            ], 301);
        }

        return $this->render('pages/admin/edit.html.twig', [
            'propriete' => $propriete,
            'formPropriete' => $formPropriete->createView()
        ]);
    }


    /**
     * @Route ("/admin/newPropriete", name="admin.catalogue.new", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $propriete = new Propriete();
        $formPropriete = $this->createForm(ProprieteType::class, $propriete);
        $formPropriete->handleRequest($request);

        if( $formPropriete->isSubmitted() && $formPropriete->isValid()) {
            $this->entityManager->persist($propriete);
            $this->entityManager->flush();
            $this->addFlash('success','Propriété ajoutée avec succès !');
            $this->proprietes = $this->listerProprietes();
            return $this->redirectToRoute(
                'admin.catalogue',
                [
                    'proprietes' => $this->proprietes
                ],
                301
            );
        }

        return $this->render('pages/admin/new.html.twig', [
            'propriete' => $propriete,
            'formPropriete' => $formPropriete->createView()
        ]);
    }

    /**
     * @Route ("/admin/deletePropriete/{id}", name="admin.catalogue.delete", methods="GET|POST|DELETE")
     * @param Propriete $propriete
     * @param Request $request
     * @return Response
     */
    public function delete(Propriete $propriete, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $propriete->getId(),
        $request->get('_token')))
        {
            $this->entityManager->remove($propriete);
            $this->entityManager->flush();
            $this->addFlash('success','Propriété supprimée avec succès !');
            $this->proprietes = $this->listerProprietes();
            return $this->redirectToRoute(
                'admin.catalogue',
                [
                    'proprietes' => $this->proprietes
                ],
                301
            );
        }

    }

    /**
     * @Route ("/admin/proprietes", name="admin.catalogue", methods="GET");
     * @return Response
     */
    public function home():Response
    {
        $this->proprietes = $this->listerProprietes();
        return $this->render('pages/admin/catalogue.html.twig', [
           'proprietes' => $this->proprietes
        ]);
    }

    /**
     * @return array
     */
    private function listerProprietes(): array {
        return $this->proprieteRepository->findAll();
    }

}