<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProductType;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/adilet/djuraev", name="adilet_djuraev")
 */
class AdiletDjuraevController extends AbstractController
{
    /**
     * @Route("/home", name="adilet_djuraev_home")
     */
    public function index(): Response
    {
        return $this->render('adilet_djuraev/index.html.twig', [

        ]);
    }



    /**
     * @Route("/table", name="adilet_djuraev_table")
     */
    public function table(Request $request): Response
    {
        $product = new Product();
        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $product = $form->getData();
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirect($request->getUri());
        }
        $products = $entityManager->getRepository(Product::class)->findAll();
        return $this->render('adilet_djuraev/my_table.html.twig', [
            'products'=>$products,
            'form'=>$form->createView()
        ]);
    }


    /**
     * @Route("/delete/{id}", name="adilet_djuraev_delete")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $ob = $entityManager->getRepository(Product::class)->find($id);
        $entityManager->remove($ob);
        $entityManager->flush();

        return $this->redirect('/adilet/djuraev/table');
    }

    /**
     * @Route("/update/{id}", name="adilet_djuraev_update")
     */
    public function update(Request $request, int $id): Response
    {
        $product = new Product();
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if($form->isSubmitted()){
            $entityManager->flush();
            return $this->redirect('/adilet/djuraev/table');
        }

        return $this->render('adilet_djuraev/my_update.html.twig', [
            'form'=>$form->createView()
        ]);

    }

    /**
     * @Route("/search", name="adilet_djuraev_search")
     */
    public function search(): Response
    {
        return $this->render('adilet_djuraev/my_search.html.twig', [

        ]);
    }
}
