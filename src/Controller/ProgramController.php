<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;

/**
* @Route("/programs", name="program_")
*/
class ProgramController extends AbstractController
{
    /**
    * @Route("/", name="index")
    */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findAll();

        return $this->render(
            'Program/index.html.twig',
            ['programs'=>$programs]
        );
    }




    /**
    * @Route("/show/{id}", name="show", requirements={"id"="\d+"}, methods={"GET"})
    * @return Response
    */


    public function show(int $id): Response
    {
        $program = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findOneBy(['id'=>$id]);

        if(!$program){
            throw $this->createNotFoundException(
                'Sorry, we have not this program'
            );
        }
        return $this->render('Program/show.html.twig', [
            'program'=> $program,
        ]);
    }
}