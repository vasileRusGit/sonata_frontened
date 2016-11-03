<?php

namespace Yoda\EventBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Yoda\EventBundle\Entity\Event;
use Yoda\EventBundle\Form\EventType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Event controller.
 *
 */
class EventController extends Controller
{

    /**
     * Lists all Event entities.
     * @Route("/", name="event")
     */
    public function indexAction()
    {
        $this->enforceUserSecurity();

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EventBundle:Event')->findAll();

        return $this->render('EventBundle:Event:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Lists all Event entities.
     * @Route("/event", name="event_index_user")
     */
    public function index_userAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EventBundle:Event')->findAll();

        return $this->render('EventBundle:Event:index_user.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Creates a new event entity.
     *
     */
    public function newAction(Request $request)
    {
        $this->enforceUserSecurity();

        $event = new Event();
        $form = $this->createForm('Yoda\EventBundle\Form\EventType', $event);
        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('class' => 'btn btn-primary', 'style' => 'float:right')));
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
//            $event->upload();
            
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_show', array('id' => $event->getId()));
        }

        return $this->render('EventBundle:Event:new.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }

    private function enforceUserSecurity()
    {
        $securityContext = $this->get('security.context');
        if (!$securityContext->isGranted('ROLE_USER')) {
            throw $this->createAccessDeniedException("Need ROLE_USER");
        }
    }

    /**
     * Finds and displays a Event entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EventBundle:Event')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

//        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EventBundle:Event:show.html.twig', array(
            'entity' => $entity,
//                    'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Event entity.
     *
     */
    public function editAction($id)
    {
        $this->enforceUserSecurity();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EventBundle:Event')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EventBundle:Event:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Event entity.
     *
     * @param Event $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Event $entity)
    {
        $form = $this->createForm(new EventType(), $entity, array(
            'action' => $this->generateUrl('event_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary', 'style' => 'float:right')));

        return $form;
    }

//    creates actions for easier use

    /**
     * Creates a form to delete a Event entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-danger', 'style' => 'float:right')))
            ->getForm();
    }

    /**
     * Edits an existing Event entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $this->enforceUserSecurity();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EventBundle:Event')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

//        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('event_show', array('id' => $id)));
        }

        return $this->render('EventBundle:Event:edit.html.twig', array(
            'entity' => $entity,
////            'edit_form'   => $editForm->createView(),
////            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Event entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $this->enforceUserSecurity();

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EventBundle:Event')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Event entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('event_index'));
    }

}
