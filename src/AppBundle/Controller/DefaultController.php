<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // find all users listed ascending by id
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findBy(array(), array('id' => 'ASC'));

        // pass them over to view to render
        return $this->render('user/index.html.twig', array(
            'users' => $users
        ));
    }
}
