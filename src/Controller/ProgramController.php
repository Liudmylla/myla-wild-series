<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;

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


    public function show(Program $program): Response
    {
        
       $seasons = $this->getDoctrine()
        ->getRepository(Season::class)
        ->findBy(['program'=>$program]);

        return $this->render('Program/show.html.twig', [
            'program'=> $program,
            'seasons' => $seasons
        ]);
    }

    /**
    * @Route("/{program}/season/{season}", 
    * name="season_show",
    * requirements={"program"="\d+", "season"="\d+"},
    * methods={"GET"})
    */
    public function showSeason(Program $program, Season $season)
    {

        return $this->render('Program/season_show.html.twig', ['program' => $program, 'season' => $season]);

    }

    /**
     * @Route("/{program}/seasons/{season}/episodes/{episode}",
     * name="episode_show",
     * methods={"GET"}
     * )
     */

    public function showEpisode(Program $program, Season $season, Episode $episode)
    {
        return $this->render('Program/episode_show.html.twig', [
        'program' => $program,
        'season' => $season,
        'episode'=> $episode
         ]);

    }
}