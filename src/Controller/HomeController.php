<?php
/**
 * Created by PhpStorm.
 * User: stagiaire
 * Date: 25/06/2018
 * Time: 12:20
 */

namespace App\Controller;


use App\Entity\IdentityUser;
use App\Form\IdentityUserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class HomeController extends Controller
{
    /**
     * @var UrlGeneratorInterface
     */
    private $router;
    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }
    /**
     * @Route("/")
     * @return string
     */
    public function index()
    {
        $maVariable = "Bienvenue sur l'accueil";
        return $this->render("home/index.html.twig", [
                'title' => $maVariable
            ]);
    }

    /**
     * @Route("/article/page/{page}", requirements={"page" = "\d+"})
     * @param int $page
     * @return string
     */
    public function list($page = 1)
    {
        return $this->render( "blog/list.html.twig", ['nbCurrentPage' => $page ]);
    }

    /**
     *
     * @Route("/about")
     * @return string
     */
    public function about()
    {
        $url = $this->generateUrl( 'app_blog_list', ["page" => 36]);
        dump( $url);
            return $this->render("home/index.html.twig", ['title' => 'something']);
    }

    /**
     * Ajoute un user
     * @Route("/ajout")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        // Création d'une instance de notre entité
        $identityUser = new IdentityUser();

        // Récupération du formulaire
        $form = $this->createForm(IdentityUserType::class, $identityUser);

        /* Traitement du formulaire */
        // On "remplit" le formulaire avec les variables POST saisies
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Formulaire ok

            // On récupère un objet de type "Product"
            $identityUser = $form->getData();
            $identityUser->setEnabled(true);
            $userManager = $this->get('fos_user.user_manager'); // Récupération du manager de doctrine
            $userManager->updateUser($identityUser);
            $manager = $this->getDoctrine()->getManager();
            // Enregistrement du produit en BDD
            $manager->persist($identityUser);
            $manager->flush();

            $this->addFlash('success', 'Votre inscription à bien été enregistrée');
            return $this->redirectToRoute('app_home_add', [
                "id" => $identityUser->getId()
            ]);
        }
        return $this->render('User/form.html.twig', [
            'form' => $form->createView(),
            'operation' => 'Ajout',
            'operationBtn' => 'Ajouter'
        ]);
    }

    /**
     * @Route("/histoire")
     * @return string
     */
    public function histoire()
    {
        $maVariable = "L'histoire du tissus";
        return $this->render("User/histoire.html.twig", [
            'title' => $maVariable
        ]);
    }

    /**
     * @Route("/propos")
     * @return string
     */
    public function propos()
    {
        $maVariable = "A propos";
        return $this->render("User/propos.html.twig", [
            'title' => $maVariable
        ]);
    }

}