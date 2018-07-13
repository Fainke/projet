<?php
/**
 * Created by PhpStorm.
 * User: stagiaire
 * Date: 27/06/2018
 * Time: 14:56
 */

namespace App\Controller;


use App\Entity\Modeles;
use App\Form\ModelesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModelesController extends Controller
{
    /**
     * Affiche le détail d'un produit
     * @Route("/modeles")
     * @return Response
     */
    public function show(Request $request): Response
    {

        // On récupère le Repository
        $query = $this->getDoctrine()
            ->getRepository(Modeles::class)
            ->findAllQuery();
        // on recupere le paginateur
        $paginateur = $this->get('knp_paginator');
        //on crée la paginateur
        $pagination = $paginateur->paginate($query, $request->query->getInt('page', 1), 12);



        // Renvoi les produits à la vue
        return $this->render('User/modeles.html.twig', [
                'pagination' => $pagination
            ]
        );
    }

    /**
     * Ajoute un produit en BDD
     * @Route("/modeles/ajout")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        // Création d'une instance de notre entité
        $modeles = new Modeles();

        // Récupération du formulaire
        $form = $this->createForm(ModelesType::class, $modeles);

        /* Traitement du formulaire */
        // On "remplit" le formulaire avec les variables POST saisies
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // Formulaire ok

            // On récupère un objet de type "Product"
            $modeles = $form->getData();

            // Récupération du manager de doctrine
            $manager = $this->getDoctrine()->getManager();
            // Enregistrement du produit en BDD
            $manager->persist($modeles);
            $manager->flush();

            $this->addFlash('success', 'Votre produit a bien éte ajouter');
            return $this->redirectToRoute('app_modeles_add', [
                "id" => $modeles->getId()
            ]);
        }

        return $this->render('User/ajout.html.twig', [
            'form' => $form->createView(),
            'operation' => 'Ajout',
            'operationBtn' => 'Ajouter'
        ]);

    }
    /**
     * Affiche le détail d'un produit
     * @Route("/detail/{id}", requirements={"id":"\d+"})
     * @param int $id
     * @return Response
     */
    public function detail(int $id): Response
    {

        $repository = $this->getDoctrine()->getRepository(Modeles::class);
        $modeles = $repository->find($id);



        return $this->render(
            'User/show.html.twig',
            compact('modeles') // ["product" => $product]
        );
    }

    /**
     * Modifie un produit en BDD
     * @Route("/modeles/modification/{id}")
     * @param Modeles $modeles
     * @param Request $request
     * @return Response
     */
    public function update(Modeles $modeles, Request $request): Response
    {
        // Récupération du formulaire
        $form = $this->createForm(ModelesType::class, $modeles);

        /* Traitement du formulaire */
        // On "remplit" le formulaire avec les variables POST saisies
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // Formulaire ok

            // On récupère un objet de type "Product"
            $modeles = $form->getData();

            // Récupération du manager de doctrine
            $manager = $this->getDoctrine()->getManager();
            // Enregistrement du produit en BDD
            $manager->persist($modeles);
            $manager->flush();

            return $this->redirectToRoute('app_modeles_show', [
                "id" => $modeles->getId()
            ]);
        }

        return $this->render('User/ajout.html.twig', [
            'form' => $form->createView(),
            'operation' => ' Modification',
            'operationBtn' => 'Modifier'
        ]);


        // On redirige vers la page de détail
        // ##todo : afficher la vue du formulaire d'ajout
        return $this->redirectToRoute('app_modeles_show', [
            "id" => $modeles->getId()
        ]);
    }

    /**
     * Suppresion d'un produit en BDD
     * @Route("/modeles/suppression/{id}")
     * @param Modeles $modeles
     * @return Response
     */
    public function remove(Modeles $modeles): Response
    {

        // Suppression du produit
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($modeles);
        $manager->flush();

        // On redirige vers la liste des détail
        return $this->redirectToRoute('app_home_index');
    }

}