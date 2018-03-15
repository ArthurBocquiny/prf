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
        if ( isset($infos[0]->cover) )
        { 
            str_replace('t_thumb', 't_cover_big', $infos[0]->cover->url);
        }
        
        return $this->render(
                'search_games/index.html.twig',
                [
                    'infos' => $infos,
                ]
        );
    }
}
