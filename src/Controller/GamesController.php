<?php

namespace App\Controller;

use App\Entity\Tournois;
use Buzz\Browser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use function dump;

/**
 * @Route("/games")
 */
class GamesController extends Controller
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $browser = new Browser();

        
        $repository = $this->getDoctrine()->getRepository(Tournois::class);
        $tournois = $repository->findAll();
        $games = $repository->tournoisJeuName();
               
        
        for($i = 0; $i < count($games); $i++)
        {
            $gamesNames[] = $games[$i]['jeu'];
        }
        for($i = 0; $i < count($gamesNames); $i++)
        {
            $j = 0;
            $response = $browser->get('https://api-endpoint.igdb.com/games/?fields=*&search='.$gamesNames[$i], ['user-key' => '8b08955bdd93969a13b998edea92d869']);

            $infos = json_decode($response->getContent());
            
            $k = 0;
            while($k < count($infos))
            {
                if ( isset($infos[$k]->cover) )
                { 
                    $infos[$k]->cover->url = str_replace('t_thumb', 't_cover_big', $infos[$k]->cover->url);
                }
                $k++;
            }
            foreach($infos as $key => $value)
            {
                if ( $infos[$j]->name == $gamesNames[$i])
                {
                    $jeux[] = $infos[$j];
                    
                }
                $j++;
            }
            $infos = '';    
        }
        
        
        $nbtournois = $repository->countTournois();
        

        return $this->render(
                'games/index.html.twig',
                [
                    'jeux' => $jeux,
                    'nbtournois' => $nbtournois,
                    'tournois' => $tournois
                ]
        );
    }
    
    /**
     * @Route("/fichejeu/{jeu}", defaults={"jeu" :null})
     */
    public function fichejeu($jeu)
    {
        $em = $this->getDoctrine()->getRepository(Tournois::class);
        $selectedtournois = $em->findBy(['jeu' => $jeu]);
        
        return $this->render(
                'games/fichejeu.html.twig',
                [
                    'selectedtournois' => $selectedtournois
                ]);
    }
}
