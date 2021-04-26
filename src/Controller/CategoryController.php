<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Program;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;

/**
* @Route("/categories/", name="category_")
*/
class CategoryController extends AbstractController
{
    /**
    * @Route("", name="index")
    */
    public function index(): Response
    {
        $categories = $this->getDoctrine()
        ->getRepository(Category::class)
        ->findAll();
        return $this->render('Category/index.html.twig', ['categories' => $categories]);
    }

    /**
     * @Route("new",name="new")
     */

    public function new(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class,$category);
        //get data 
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
              // Deal with the submitted data
            $entityManager = $this->getDoctrine()->getManager();
            // For example : persiste & flush the entity
            $entityManager->persist($category);
            $entityManager->flush();
            // And redirect to a route that display the result
            return $this->redirectToRoute('category_index');
        }
        return $this->render('Category/new.html.twig', [
            "form"=>$form->createView(),
        ]);
    }


    /**
    * @Route("{categoryName}", name="show")
    */
    public function show(string $categoryName): Response
    {
        $category = $this->getDoctrine()
        ->getRepository(Category::class)
        ->findOneBy(['name' => $categoryName]);

        if(!$category){
            throw $this->createNotFoundException(
                'Sorry, we have not this category'
            );
        } 
        
        $programs = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findBy(['category' => $category->getId()], ['id' => 'DESC'], 3);

        return $this->render('Category/show.html.twig', [
            'programs' => $programs, 
            'category' => $categoryName]);
    }
}