<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\GroupType;
use AppBundle\Form\GroupAddType;
use AppBundle\Entity\UserGroup;
use AppBundle\Entity\User;

class GroupController extends Controller
{
    /**
     * @Route("/group-list", name="group_list")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $groups = $this->getDoctrine()->getRepository('AppBundle:UserGroup')->findBy(array(), array('id' => 'ASC'));

        return $this->render('group/index.html.twig', array(
            'groups' => $groups
        ));
    }

    /**
     * @Route("/group/create", name="group_create")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $group = new UserGroup();

        $form = $this->createForm(GroupType::class, $group);

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {

            $group->setName($form['name']->getData());
            $group->setMembers([]);

            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();

            $this->addFlash(
                'notice',
                'Group Added'
            );

            return $this->redirectToRoute('group_list');
        }

        return $this->render('group/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/group/delete/{id}", name="group_delete")
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id)
    {
        $group = $this->getDoctrine()->getRepository('AppBundle:UserGroup')->findOneBy(array('id' => $id));
        // delete if group has no members
        if (count($group->getMembers()) == 0){
            $em = $this->getDoctrine()->getManager();
            $em->remove( $this->getDoctrine()->getRepository('AppBundle:UserGroup')->find($id) );
            $em->flush();

            $this->addFlash(
                'notice',
                'Group Removed'
            );    
        }

        $this->addFlash(
            'notice',
            'Group size is nonzero'
        );

        return $this->redirectToRoute('group_list');
    }

     /**
     * @Route("/group/details/{id}", name="group_details")
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detailsAction($id)
    {
        $group = $this->getDoctrine()->getRepository('AppBundle:UserGroup')->findOneBy(array('id' => $id));

        // get all members of this group
        $members = $group->getMembers();
        $member_names = array();

        foreach ($members as $user_id) {
            $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('id' => $user_id));
            array_push($member_names, array($user_id, $user->getName()));
        }

        return $this->render('group/details.html.twig', array(
            'group' => $group,
            'members' => $member_names
        ));
    }
    
}
