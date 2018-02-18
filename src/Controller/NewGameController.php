<?php
// src/Controller/HelloWorldController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\MasterMindGame;
use App\Entity\State;

class NewGameController extends Controller
{
    /**
      * @Route("/new/", name="new")
      */
    public function start(Request $request)
    {
        $newGame = new MasterMindGame();
        $form = $this->createFormBuilder($newGame)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Actualizar nombre'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //recuperamos el nombre del formulario
            $newGame = $form->getData();

            if((null == $newGame->getName()) || trim($newGame->getName())===''){
                $newGame->setName('MasterMindGame');
            };
            $newGame->setCreationDate(new \DateTime());

            //código de colores de 6 posiciones y 10 colores posibles (0-9)
            $newGame->setColorList(
                array(
                    rand(0,9),
                    rand(0,9),
                    rand(0,9),
                    rand(0,9),
                    rand(0,9),
                    rand(0,9)
                )
            );
            $newGame->setState(State::STARTED);
    
            //obtenemos el acceso a la BD
            $em = $this->getDoctrine()->getManager();
    
            // guardar en BD
            $em->persist($newGame);
    
            // ejecutar (realmente) la query
            $em->flush();  
            
            return $this->render('games/game.html.twig', array(
                'id' => $newGame->getId(),
                'creationDate' => $newGame->getCreationDate()->format('Y-m-d H:i:s'),
                'state' => $newGame->getState(),
                'name' => $newGame->getName(),
                'moves' => null
            ));
        }else{
            return $this->render('games/newgame.html.twig', array(
                'form' => $form->createView(),
            )); 
        }

      
    }
}
