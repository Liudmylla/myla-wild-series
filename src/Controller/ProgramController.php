<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use App\Entity\Season;

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

       $seasons = $this->getDoctrine()
        ->getRepository(Season::class)
        ->findBy(['program'=>$id]);

        return $this->render('Program/show.html.twig', [
            'program'=> $program,
            'seasons' => $seasons
        ]);
    }

    /**
    * @Route("/{programId}/season/{seasonId}", 
    * name="season_show",
    * requirements={"programId"="\d+", "seasonId"="\d+"},
    * methods={"GET"})
    */
    public function showSeason(int $programId, int $seasonId)
    {
        $program = $this->getDoctrine()->getRepository(Program::class)->findOneBy(['id' => $programId]);
        $season =  $this->getDoctrine()->getRepository(Season::class)->findOneBy(['id' => $seasonId]);
        

        return $this->render('Program/season_show.html.twig', ['program' => $program, 'season' => $season]);

    }
}