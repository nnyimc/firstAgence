<?php
namespace App\Controller;


use App\Entity\Adresse;
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
        $faker = \Faker\Factory::create('fr_FR');

        //Création d'adresses
        for( $i = 0; $i <3; $i++) {
            $adresse = new Adresse();
            $adresse->setCodePostal(str_replace(' ', '', $faker->postcode));
            $adresse->setRue($faker->streetAddress);
            $adresse->setVille($faker->city);

            //Invocation de l'EntityManager
            $this->entityManager->persist($adresse);

            for ($j = 0; $j < 3; $j++) {
                //Test de l'instanciation d'une propriété
                $propriete = new Propriete();
                $propriete->setNom($faker->company);
                $propriete->setDescription($faker->paragraph);
                $propriete->setNbPieces($faker->numberBetween(1, 6));
                $propriete->setNbChambres($faker->numberBetween(1,4));
                $propriete->setSurface(rand(25, 220));
                $propriete->setEtage(rand(0, 12));
                $propriete->setPrix(rand(9000, 1500000));
                $propriete->setAdresse($adresse);

                //Invocation de l'EntityManager
                $this->entityManager->persist($propriete);
            }
        }


        //Invocation de l'EntityManager
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