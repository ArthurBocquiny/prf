<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GamesController extends Controller
{
    /**
     * @Route("/games", name="games")
     */
    public function index()
    {
        $browser = new \Buzz\Browser();

        $search = 'Halo3';
        
        $response = $browser->get('https://api-endpoint.igdb.com/games/?fields=*&search=' . $search, ['user-key' => '1da94eeed8524c769b940cd570045f1f']);
        dump($response->getContent());
        $infos = json_decode($response->getContent());
        dump(str_replace('t_thumb', 't_cover_big', $infos[0]->cover->url));
        
        

        return $this->render('games/index.html.twig', [
            'controller_name' => 'GamesController',
        ]);
    }
}
