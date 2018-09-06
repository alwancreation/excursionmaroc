<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Validator\Constraints\Date;


/**
 * User controller.
 *
 * @Route("/users")
 */
class UsersController extends Controller
{

    /**
     * Lists all User users.
     *
     * @Route("/", name="users")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository("AppBundle:User")->findAll();

        return $this->render('AdminBundle:Users:index.html.twig',array(
            'users' => $users,
        ));
    }


    /**
     * Creates a new User entity.
     *
     * @Route("/", name="users_create")
     * @Method("POST")
     * @Template("AdminBundle:User:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $user = new User();
        $form = $this->createCreateForm($user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $userManager = $this->container->get('fos_user.user_manager');
            //$user = $userManager->createUser();
            $user->setUsername($form->getData()->getEmail());
            $user->setEmail($form->getData()->getEmail());
            $user->setPlainPassword("RANDOMPASSORD");
            $userManager->updateUser($user,false);
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('users'));
        }

        return array(
            'entity' => $user,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(User $entity)
    {
        $form = $this->createForm('AppBundle\Form\UserType', $entity, array(
            'action' => $this->generateUrl('users_create'),
            'method' => 'POST',
        ));


        return $form;
    }

    /**
     * Displays a form to create a new User entity.
     *
     * @Route("/new", name="users_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new User();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'users_menu'=>true,
        );
    }



    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/edit", name="users_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository("AppBundle:User")->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }


        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $editFormRole = $this->createFormBuilder()
            ->add('role', ChoiceType::class, array(
                'multiple' => true,
                'attr'=>array(
                    'class'=>'multicheckbox form-control',
                    'style'=> 'height:300px'
                ),
                'choices'=>$entity->getRolesArrayKies(),
                'data'=>$entity->getRoles(),
            ))->setAction($this->generateUrl('user_update_role', array('id' => $entity->getId())))
            ->setMethod('PUT')
            ->add('save', SubmitType::class, array('label' => 'Edit roles','attr'=>array("class"=>"btn btn-primary")))
            ->getForm();


        $editFormPassword = $this->createEditFormPassword($entity);


        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'edit_form_role' => $editFormRole->createView(),
            'delete_form' => $deleteForm->createView(),
            'edit_form_password'   => $editFormPassword->createView(),
            'users_menu'=>true,
        );
    }



    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/show/{id}/profile/year/{year}", name="users_show_profile",defaults={"year" = 2017})
     * @Method("GET")
     * @Template()
     */
    public function showAction($id,$year)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository("AppBundle:User")->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        return array(
            'user'      => $entity,
        );
    }

    /**
     * Creates a form to edit a Employe entity.
     *
     * @param User|\AppBundle\Entity\User $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditFormPassword(\AppBundle\Entity\User $entity)
    {

        $form = $this->createForm('AppBundle\Form\UserPasswordType', $entity, array(
            'action' => $this->generateUrl('user_update_password', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        // $form->add('submit', SubmitType::class, array('label' => 'Updates password'));

        return $form;
    }

    /**
     * Edits an existing User entity.
     *
     * @Route("/updatepassword/{id}", name="user_update_password")
     * @Method("PUT")
     * @Template()
     */
    public function updatepasswordAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var User $entity */
        $entity = $em->getRepository("AppBundle:User")->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        $editForm = $this->createEditFormPassword($entity);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $entity->setPlainPassword($editForm->getData()->getPassword());
            $userManager = $this->container->get('fos_user.user_manager');
            //$entity->removeRole("ROLE_ADMIN");
            $entity->setEnabled($editForm->getData()->isEnabled());
            $userManager->updateUser($entity);
            return $this->redirect($this->generateUrl('users_edit', array('id' => $id)));
        }
        return $this->redirect($this->generateUrl('users'));

    }

    /**
     * Edits an existing Employe entity.
     *
     * @Route("/setrole/{id}", name="user_update_role")
     * @Method("PUT")
     * @Template()
     */
    public function setroleAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("AppBundle:User")->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $user->removeAllRoles();


        $post = Request::createFromGlobals();
        $roles = $post->request->get('form');
        if(isset($roles['role']) && is_array($roles['role'])){
            foreach ($roles['role'] as $roleName){
                $user->addRole($roleName);
            }
        }
        $userManager->updateUser($user);

        return $this->redirect($this->generateUrl('users_edit', array('id' => $id)));


    }
    /**
    * Creates a form to edit a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(User $entity)
    {
        $form = $this->createForm('AppBundle\Form\UserType', $entity, array(
            'action' => $this->generateUrl('users_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));


        return $form;
    }
    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}", name="users_update")
     * @Method("PUT")
     * @Template("AdminBundle:User:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository("AppBundle:User")->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
//            $entity->uploadImage();
//            $entity->uploadCv();

            $em->flush();

            return $this->redirect($this->generateUrl('users_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a User entity.
     *
     * @Route("/{id}", name="users_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository("AppBundle:User")->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('users'));
    }

    /**
     * Creates a form to delete a User entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('users_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
