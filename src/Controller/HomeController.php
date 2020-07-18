<?php
    namespace App\Controller; #faire correspondre le ns et le nom du dossier

    use App\Repository\ProprieteRepository;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Twig\Environment;

    class HomeController extends AbstractController{
        /**
         * @Route("/", name="home");
         * @var Environment
         */
        private  $pageAccueil;

        /**
         * @var ProprieteRepository
         */
        private $proprieteRepository;

        /**
         * HomeController constructor.
         * @param ProprieteRepository $proprieteRepository
         * @param Environment $pageAccueil
         */
        public function __construct(ProprieteRepository $proprieteRepository, Environment $pageAccueil)
        {
            $this->pageAccueil = $pageAccueil;
            $this->proprieteRepository = $proprieteRepository;
        }

        /**
         * @return Response
         * @throws \Twig\Error\LoaderError
         * @throws \Twig\Error\RuntimeError
         * @throws \Twig\Error\SyntaxError
         */
        public function index():Response
        {
            $proprietes = $this->proprieteRepository->findNewestItems();

            return new Response(
                $this->pageAccueil->render('pages/home.html.twig', [
                    'proprietes' => $proprietes
                ])
            );
        }
    }