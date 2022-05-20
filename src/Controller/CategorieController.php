<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
     * @Route("/categorie", name="categorie_")
     */
class CategorieController extends AbstractController
{
    /**
     * @Route("/", name="list")
     */
    public function listCategorie(CategorieRepository $categorieRepository): Response
    {

        $categories = $categorieRepository->findAll();

        return $this->render('categorie/categorie.html.twig', [
            'categories' => $categories
        ]);
    }
}
