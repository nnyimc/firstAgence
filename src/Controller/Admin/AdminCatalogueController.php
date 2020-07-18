<?php
namespace  App\Controller\Admin;

use App\Entity\Adresse;
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
        $form = $this->createForm(ProprieteType::class, $propriete);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form-> isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success','Propriété modifiée avec succès !');
            $this->proprietes = $this->listerProprietes();
            return $this->redirectToRoute('admin.catalogue', [
                'proprietes' => $this->proprietes
            ]);
        }

        return $this->render('pages/admin/edit.html.twig', [
            'propriete' => $propriete,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route ("/admin/newPropriete", name="admin.catalogue.new", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $adresse = new Adresse();
        $propriete = new Propriete();
        $propriete->setAdresse($adresse);
        $this->entityManager->persist($propriete);
        $form = $this->createForm(ProprieteType::class, $propriete);
        $form->handleRequest($request);

        return $this->render('pages/admin/new.html.twig', [
            'propriete' => $propriete,
            'form' => $form->createView()
        ]);

        if( $form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($propriete);
            $this->entityManager->flush();
            $this->addFlash('success','Propriété ajoutée avec succès !');
            $this->proprietes = $this->listerProprietes();
            return $this->redirectToRoute('admin.catalogue', [
                'proprietes' => $this->proprietes
            ]);
        }
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
            return $this->redirectToRoute('admin.catalogue', [
                'proprietes' => $this->proprietes
            ]);
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