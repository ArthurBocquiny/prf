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
        
        $games = $repository->findAll();
        
        for($i = 0; $i < count($games); $i++)
        {    
            $gamesNames[] = $games[$i]->getJeu();
        }
        
        for($i = 0; $i < count($gamesNames); $i++)
        {
            $j = 0;
            $response = $browser->get('https://api-endpoint.igdb.com/games/?fields=*&search='.$gamesNames[$i], ['user-key' => '1da94eeed8524c769b940cd570045f1f']);
            $infos = json_decode($response->getContent());
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
        
        

        return $this->render(
                'games/index.html.twig',
                [
                    'jeux' => $jeux,
                ]
        );
    }
}
