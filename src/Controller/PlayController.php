<?php
// src/Controller/HelloWorldController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\MasterMindGame;
use App\Entity\Move;
use App\Entity\UserMovementInput;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\State;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


use App\Util\ValidateMoveUtil;

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

                $userMovementInput = new UserMovementInput();
                $form = $this->createFormBuilder($userMovementInput)
                    ->add('inputString', TextType::class, array('label' => 'Colores: '))
                    ->add('save', SubmitType::class, array('label' => 'Enviar movimiento'))
                    ->getForm();

                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    $userMovementInput = $form->getData();
                    
                    //aunque ya se hace la validación de la regex a nivel de la entity UserMovementInput, comprobamos aquí también validación
                    if(!preg_match('/^[0-9]{6}$/', $userMovementInput->inputString)){
                        return $this->render('games/play.html.twig', array(
                            'name' => $game->getName(),
                            'form' => $form->createView(),
                            'message' => "Debes escribir 6 números entre el 0 y el 9",
                        )); 
                    }else{

                        $validationMove = new ValidateMoveUtil();
                        $responseValidationMove = $validationMove->validateMove(str_split($userMovementInput->inputString),$game);

    
                        //obtenemos el acceso a la BD
                        $em = $this->getDoctrine()->getManager();
                        // guardar en BD
                        $em->persist($responseValidationMove->getMove());
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