<?php
// src/Controller/HelloWorldController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends Controller
{
    /**
      * @Route("/hello/world")
      */
    public function hello()
    {
        $number = mt_rand(0, 100);

        return $this->render('hello/hello.html.twig', array(
            'number' => $number,
            'saludo' => "PRUEBAAAA"
        ));
    }
}