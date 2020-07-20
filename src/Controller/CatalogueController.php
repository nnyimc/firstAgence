<?php
namespace App\Controller;

use App\Entity\Propriete;
use App\Repository\ProprieteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CatalogueController extends AbstractController {

    /**
     * @var ProprieteRepository
     */
    private $proprieteRepository;

    public function __construct(ProprieteRepository $proprieteRepository) {
        $this->proprieteRepository = $proprieteRepository;
    }

    /**
     * @Route("/catalogue", name="catalogue")
     * @return Response
     */
    public function display(PaginatorInterface $paginator, Request $request): Response
    {
        $proprietes = $paginator->paginate($this->proprieteRepository->findAllNotSoldQuery(),
                                            $request->query->getInt( 'page', 1 ),
                                            16);

        // Renvoi de la template pour la page catalogue.html
        return $this->render('pages/catalogue.html.twig', [
            'current_nav_item' => 'catalogue',
            'proprietes' =>$proprietes
        ]);

    }

    /**
     * @Route("/catalogue/{slug}-{id}", name = "catalogue.showPropriete", requirements={"slug": "[a-z0-9\-]*"})
     * @param Propriete $propriete
     * @param $slug
     * @return Response
     */
    public function showPropriete(Propriete $propriete, $slug): Response
    {
        //Créer une entité équivalente à une recherche
        //Créer un formulaire
        //Gérer le traitement en modifiant le comportement de la fonction
        if ($propriete->getSlug() !== $slug) {
            return $this->redirectToRoute('catalogue.showPropriete',
                [
                    'id' => $propriete->getId(),
                     'slug' => $propriete->getSlug()
                ],
                301);
        }

        return $this->render('pages/detailPropriete.html.twig',
            [
                'propriete' => $propriete,
                'current_nav_item' => 'catalogue'
            ]
        );
    }
}