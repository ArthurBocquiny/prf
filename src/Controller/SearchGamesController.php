<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    /**
     * @Route("/searchgames")
     */
class SearchGamesController extends Controller
{
    /**
     * 
     * @Route("/")
     */
    public function index()
    {
        $browser = new \Buzz\Browser();
        
        $search = '';
        
        if ( !empty($_GET['games']) )
        {  
            $search = $_GET['games'];
        }
        
        $response = $browser->get('https://api-endpoint.igdb.com/games/?fields=*&search=' . $search, ['user-key' => '1da94eeed8524c769b940cd570045f1f']);
        $infos = json_decode($response->getContent());
        
        $i = 0;
        while($i < count($infos))
        {
            if ( isset($infos[$i]->cover) )
            { 
                $infos[$i]->cover->url = str_replace('t_thumb', 't_cover_big', $infos[$i]->cover->url);
            }
            $i++;
        }
        
        return $this->render(
                'search_games/index.html.twig',
                [
                    'infos' => $infos,
                ]
        );
    }
}
