<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Form\Type\UserForm;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\User;
// czy zawsze repozytorium wrzucamy do containera?
//QUEST POBOCZNY
//Zrob serwis zamieniajacy idka na username i pokazujacy to na stronie
//czyli po zapisaniu usera bierzemy jego idka i cyk! na usernamea go
class UserController extends Controller
{
    /**
     * @Route("/new")
     */
    public function newAction(Request $req)
    {
        $user =new User();
        $form=$this->createForm(UserForm::class,$user);
        $form->handleRequest($req);

        if($form->isSubmitted()){
            $post=$form->getData();
            $em=$this->get('app_bundle.entity.repository_user');//czyli tutaj wzywamy magiczny container
            $em->save($post);// tutaj wywolujemy jeszcze bardziej magiczna metode containera
            $id=$post->getId();

            $username=$em->idToUsernameSwitch($id);
            return $this->render('AppBundle:User:new.html.twig', array(
                'username'=>$username, 'id'=> $id
            ));
        }

        return $this->render('AppBundle:User:new.html.twig', array(
            'form'=>$form->createView()
        ));
    }

}
