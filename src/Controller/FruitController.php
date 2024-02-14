<?php

namespace App\Controller;

use App\Entity\Fruit;
use App\Form\FruitType;
use App\Repository\CommentRepository;
use App\Repository\FruitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FruitController extends AbstractController
{
    #[Route('/fruit', name: 'app_fruit')]
    public function index(FruitRepository $fruitRepository): Response
    {
        $fruits = $fruitRepository->findAll();

        return $this->render('fruit/index.html.twig', [
            'controller_name' => 'FruitController',
            'fruits'=>$fruits
        ]);
    }

    #[Route('/leFruit/{id}', name: 'leFruit')]
    public function show(Fruit $fruit, CommentRepository $commentRepository ,$id): Response
    {
        $comment = $commentRepository->find($id);
        $commentaire = $comment->getContent();

        return $this->render('fruit/show.html.twig',[
            "fruit"=>$fruit,
            "commentaire"=>$commentaire,
        ]);
    }

    #[Route('/fruit/create', name: 'create_fruit')]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $fruit = new Fruit();
        $formulaire = $this->createForm(FruitType::class,$fruit);

        $formulaire->handleRequest($request);

        if($formulaire->isSubmitted() && $formulaire->isValid()){
            $manager->persist($fruit);
            $manager->flush();
            return $this->redirectToRoute("app_fruit");
        }



        return $this->render("fruit/create.html.twig",[
            "formulaire"=>$formulaire->createView()
        ]);
    }

    #[Route('/fruit/delete/{id}', name: 'delete_fruit')]
    public function delete(Fruit $fruit,EntityManagerInterface $manager)
    {

        $manager->remove($fruit);
        $manager->flush();

        return $this->redirectToRoute("app_fruit");

    }

    #[Route('/fruit/edit/{id}', name: 'edit_fruit')]
    public function edit(Fruit $fruit, Request $request, EntityManagerInterface $manager): Response
    {

        $formulaire = $this->createForm(FruitType::class,$fruit);

        $formulaire->handleRequest($request);

        if($formulaire->isSubmitted() && $formulaire->isValid()){
            $manager->persist($fruit);
            $manager->flush();
            return $this->redirectToRoute("app_fruit");
        }



        return $this->render("fruit/create.html.twig",[
            "formulaire"=>$formulaire->createView()
        ]);
    }


}