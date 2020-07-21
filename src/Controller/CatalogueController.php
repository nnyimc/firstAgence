<?php
namespace App\Controller;

use App\Entity\Propriete;
use App\Entity\Recherche;
use App\Form\RechercheType;
use App\Repository\ProprieteRepository;
use Doctrine\Common\Collections\ArrayCollection;
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

    /**
     * @var ArrayCollection
     */
    private $proprietes;

    public function __construct(ProprieteRepository $proprieteRepository) {
        $this->proprieteRepository = $proprieteRepository;
    }

    /** Cette méthode retourne une liste paginée de propriétés disponibles à la vente
     * @Route("/catalogue", name="catalogue")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function display(
                             Request $request,
                             PaginatorInterface $paginator
                           ): Response
    {

        $recherche = new Recherche();
        $formRecherche = $this->createForm(RechercheType::class, $recherche);
        $formRecherche->handleRequest($request);

        $this->proprietes = $paginator->paginate(
                                            $this->proprieteRepository->findAllNotSoldQuery($recherche),
                                            $request->query->getInt('page', 1),
                                            16
                                        );

        // Renvoi de la template pour la page catalogue.html
        return $this->render('pages/catalogue.html.twig', [
            'current_nav_item' => 'catalogue',
            'proprietes' => $this->proprietes,
            'form_recherche' =>$formRecherche->createView()
        ]);

    }

    /** Cette fonction retourne les détails d'une propriété
     * @Route("/catalogue/{slug}-{id}", name = "catalogue.showPropriete", requirements={"slug": "[a-z0-9\-]*"})
     * @param Propriete $propriete
     * @param $slug
     * @return Response
     */
    public function showPropriete(Propriete $propriete, $slug): Response
    {
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