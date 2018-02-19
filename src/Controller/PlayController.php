<?php
// src/Controller/HelloWorldController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\MasterMindGame;
use App\Entity\Move;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\State;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PlayController extends Controller
{

    /**
      * @Route("/games/{gameid}", name="games")
      */
      public function obtainGameDetails(Request $request, $gameid)
      {
         
            $game = $this->getDoctrine()
            ->getRepository(MasterMindGame::class)
            ->find($gameid);


            if(null!==$game && State::STARTED===$game->getState()){

                $defaultData = array('message' => 'Introduce movimiento');
                $form = $this->createFormBuilder($defaultData)
                    ->add('colorList', TextType::class, array('label' => 'Colores: '))
                    ->add('save', SubmitType::class, array('label' => 'Enviar movimiento'))
                    ->getForm();

                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    $colorsString = $form->getData()['colorList'];
                    
                    if(!preg_match('/^[0-9]{6}$/', $colorsString)){
                        return $this->render('games/play.html.twig', array(
                            'name' => $game->getName(),
                            'form' => $form->createView(),
                            'message' => "Debes escribir 6 números entre el 0 y el 9",
                        )); 
                    }else{
                        $move = new Move();
                        $move->setMasterMindGame($game);
                        $move->setDate(new \DateTime());
                        $move->setColorList(
                            str_split($colorsString)
                        );
                        $move->setEvaluation("");
    
                        //obtenemos el acceso a la BD
                        $em = $this->getDoctrine()->getManager();
                        // guardar en BD
                        $em->persist($move);
                        // ejecutar (realmente) la query
                        $em->flush();  
    
                        return new Response(
                            '<html><body>movimiento insertado</body></html>'
                        );
                    }

                }else{
                    return $this->render('games/play.html.twig', array(
                        'name' => $game->getName(),
                        'form' => $form->createView(),
                        'message' => "",
                    )); 
                }
            }else if(null!==$game && State::STARTED!==$game->getState()){

                $state = $game->getState();

                return $this->render('error/error.html.twig', array(
                    'error' => "La partida ha finalizado con resultado: $state . Seleccione otra partida o cree una nueva.",
                ));
            }else{
                return $this->render('error/error.html.twig', array(
                    'error' => 'Error en la selección de la partida, por favor, inicie una nueva.',
                ));
            }



      }
}