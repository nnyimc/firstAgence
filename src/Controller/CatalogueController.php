<?php
namespace App\Controller;


use App\Entity\Propriete;
use App\Repository\ProprieteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogueController extends AbstractController {

    /**
     * @var ProprieteRepository
     */
    private $proprieteRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(ProprieteRepository $proprieteRepository, EntityManagerInterface $entityManager) {
        $this->proprieteRepository = $proprieteRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/catalogue", name="catalogue")
     *
     */
    public function display(): Response{
        //Test de l'instanciation d'une propriété
        /*
        $propriete = new Propriete();
        $propriete->setNom('Villa Dora');
        $propriete->setDescription('Appartement orienté plein Sud.');
        $propriete->setNbPieces(4);
        $propriete->setNbChambres(2);
        $propriete->setSurface(75);
        $propriete->setEtage(3);
        $propriete->setPrix(200000);

        //Invocation de l'EntityManager
        $this->entityManager->persist($propriete);
        $this->entityManager->flush();

        //Test de l'entityManager
        /*
        $proprieteArray = $this->proprieteRepository->findAllNotSold();
        $proprieteArray[0]->setVendue(true);
        $this->entityManager->flush();
        */

        // Renvoi de la template pour la page catalogue.html
        return $this->render('pages/catalogue.html.twig', [
            'current_nav_item' => 'catalogue'
        ]);


    }

    /**
     * @Route("/catalogue/{slug}-{id}", name = "catalogue.showPropriete", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function showPropriete($slug, $id): Response
    {
        $propriete = $this->proprieteRepository->find($id);
        return $this->render('pages/detailPropriete.html.twig',
            [
                'propriete' => $propriete,
                'current_nav_item' => 'catalogue'
            ]
        );
    }
}