<?php

namespace App\Controller;

use App\Entity\Pupil;
use App\Form\PupilType;
use App\Repository\PupilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pupil")
 */
class AdiletController extends AbstractController
{


    /**
     * @Route("/", name="pupil_index", methods={"GET"})
     */
    public function index(PupilRepository $pupilRepository): Response
    {
        return $this->render('Adilet/index.html.twig', [
            'pupils' => $pupilRepository->findAll(),
        ]);
    }

    /**
     * @Route("/home", name="pupil_home")
     */
    public function home(): Response
    {
        return $this->render('Adilet/home.html.twig', [
        ]);
    }

    /**
     * @Route("/new", name="pupil_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $pupil = new Pupil();
        $form = $this->createForm(PupilType::class, $pupil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pupil);
            $entityManager->flush();

            return $this->redirectToRoute('pupil_index');
        }

        return $this->render('Adilet/new.html.twig', [
            'pupil' => $pupil,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pupil_show", methods={"GET"})
     */
    public function show(Pupil $pupil): Response
    {
        return $this->render('Adilet/show.html.twig', [
            'pupil' => $pupil,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="pupil_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Pupil $pupil): Response
    {
        $form = $this->createForm(PupilType::class, $pupil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pupil_index');
        }

        return $this->render('Adilet/edit.html.twig', [
            'pupil' => $pupil,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pupil_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Pupil $pupil): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pupil->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pupil);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pupil_index');
    }

    /**
     * @Route("/my/search", name="pupil_search", methods={"GET"})
     */
    public function search():Response
    {
        $ob = null;
        $entityMeneger = $this->getDoctrine()->getManager();

        if($_GET){
            $ob = $entityMeneger->getRepository(Pupil::class)->find($_GET['id']);
            if(!$ob){
                return new Response("No result");
            }
        }

        return $this->render('Adilet/mySearch.html.twig',[
            'pupil'=>$ob
    ]);
    }
}
