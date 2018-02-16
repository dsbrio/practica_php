<?php
// src/Controller/HelloWorldController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class NewGameController extends Controller
{
    /**
      * @Route("/new", name="new")
      */
    public function start()
    {
        return $this->render('games/newgame.html.twig', array(
            'id' => "123"
        ));
    }

}