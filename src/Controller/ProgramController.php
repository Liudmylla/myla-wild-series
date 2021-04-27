<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use App\Form\ProgramType;
use App\Service\Slugify;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;





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
     * @Route("/new",name="new")
     */

    public function new(Request $request,Slugify $slugify): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class,$program);
        //get data 
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            // Deal with the submitted data
            $entityManager = $this->getDoctrine()->getManager();
            $slug = $slugify->generate($program->getTitle());
            $program->setSlug($slug);
            // For example : persiste & flush the entity
            $entityManager->persist($program);
            $entityManager->flush();
            // And redirect to a route that display the result
            return $this->redirectToRoute('program_index');
        }
        return $this->render('Program/new.html.twig', [
            "form"=>$form->createView(),
        ]);
    }



    /**
    * @Route("/show/{program}", name="show", methods={"GET"})
    * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"program": "slug"}})
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
    * methods={"GET"})
    * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"program": "slug"}})
    * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"season": "number"}})
    * @return Response
    */
    public function showSeason(Program $program, Season $season):Response
    {

        return $this->render('Program/season_show.html.twig', ['program' => $program, 'season' => $season]);

    }

    /**
     * @Route("/{program}/seasons/{season}/episodes/{episode}",
     * name="episode_show",
     * methods={"GET"})
     * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"program": "slug"}})
     * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"season": "number"}})
     * @ParamConverter("episode",class="App\Entity\Episode",options={"mapping":{"episode": "slug"}})
     * @return Response
     */

    public function showEpisode(Program $program, Season $season, Episode $episode):Response
    {
        return $this->render('Program/episode_show.html.twig', [
        'program' => $program,
        'season' => $season,
        'episode'=> $episode
         ]);

    }
}