<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Message controller.
 *
 * @Route("messages")
 */
class MessagesController extends Controller
{
    /**
     * Lists all message entities.
     *
     * @Route("/", name="message_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository('AppBundle:Message')->findAll();
        return $this->render('AdminBundle:message:index.html.twig', array(
            'messages' => $messages,
        ));
    }



    /**
     * Finds and displays a message entity.
     *
     * @Route("/{id}", name="message_show")
     * @Method("GET")
     */
    public function showAction(Message $message)
    {
        return $this->render('AdminBundle:message:show.html.twig', array(
            'message' => $message,
        ));
    }


    /**
     * Deletes a message entity.
     *
     * @Route("/delete/{id}", name="message_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Message $message)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($message);
        $em->flush($message);
        return $this->redirectToRoute('message_index');
    }


}
