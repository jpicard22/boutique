<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
     * @Route("/produit", name="produit_")
     */
class ProduitController extends AbstractController
{
    /**
     * @Route("/", name="list")
     */
    public function list(ProduitRepository $produitRepository): Response
    {
        $produits = $produitRepository->findBy([], ['dateAjout' => 'DESC']);

        return $this->render('produit/list.html.twig', [
            'produits' => $produits
        ]);
    }

    /**
     * @Route("/detail/{id}", name="detail", requirements={"id"="\d+"})
     */
    public function detail(ProduitRepository $produitRepository, int $id, CategorieRepository $categorieRepository): Response
    {
        $produit = $produitRepository->find($id);
        // dd($produit);
        // $categories = $categorieRepository->findAll();

        if (!$produit){
            throw $this->createNotFoundException('Le produit n\'existe pas');
            }
        // if (!$categories){
        //     throw $this->createNotFoundException('La catégorie n\'existe pas');
        //     }

        return $this->render('produit/detail.html.twig', [
            "produit"=>$produit
            // "categories"=>$categories
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produit();
        $produit->setDateAjout(new \DateTime());

        $produitForm = $this->createForm(ProduitType::class, $produit);

        $produitForm->handleRequest($request);
       
        if ($produitForm->isSubmitted() && $produitForm->isValid()) {
            $entityManager->persist($produit);
            $entityManager->flush();

            $this->addFlash('success', 'Article ajouté');
            return $this->redirectToRoute('produit_detail',
                [
                    'id' => $produit->getId()
                ]);
        }

        return $this->render('produit/create.html.twig', [
            'produitForm'=>$produitForm->createView()
        ]);
    }
}
