<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\UserType;
use AppBundle\Form\UserEditType;
use AppBundle\Entity\User;


class UserController extends Controller
{
    /**
     * @Route("/user-list", name="user_list")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        // find all users listed ascending by id
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findBy(array(), array('id' => 'ASC'));

        // pass them over to view to render
        return $this->render('user/index.html.twig', array(
            'users' => $users
        ));
    }

    /**
     * @Route("/user/create", name="user_create")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {

            $user->setName($form['name']->getData());

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'notice',
                'User Added'
            );

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/user/delete/{id}", name="user_delete")
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove( $this->getDoctrine()->getRepository('AppBundle:User')->find($id) );
        $em->flush();

        $this->addFlash(
            'notice',
            'User Removed'
        );

        return $this->redirectToRoute('user_list');
    }

    /**
     * @Route("/user/edit/{id}", name="user_edit")
     *
     * @param int $id
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id, Request $request)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('id' => $id));

        $user->setName($user->getName());

        $form = $this->createForm(UserEditType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $user = $em->getRepository('AppBundle:User')->find($id);
            $user->setName($form['name']->getData());

            $em->flush();

            $this->addFlash(
                'notice',
                'User Modified'
            );

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }
}
