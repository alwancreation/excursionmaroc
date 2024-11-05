<?php

namespace App\Controller\Admin;

use App\Entity\Asset;
use App\Entity\User;
use App\Helper\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;


/**
 * User controller.
 *
 * @Route("/admin/users")
 */
class UsersController extends AbstractController
{

    /**
     * Lists all User users.
     *
     * @Route("/", name="users")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->findUsers();

        return $this->render('admin/users/index.html.twig',array(
            'users' => $users,
        ));
    }

    /**
     * Creates a new User entity.
     *
     * @Route("/create", name="users_create")
     * @Template("admin/users/new.html.twig")
     */
    public function createAction(Request $request)
    {
        $user = new User();
        $form = $this->createCreateForm($user);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
//            $user->setUsername($user->getEmail());
//            $user->setPlainPassword("RANDOMPASSORD");
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
        $form = $this->createForm('App\Form\UserType', $entity, array(
            'action' => $this->generateUrl('users_create'),
            'method' => 'POST',
        ));


        return $form;
    }

    /**
     * Displays a form to create a new User entity.
     *
     * @Route("/new", name="users_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new User();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     *
     * @Route("/{id}/action/enable", name="users_enable")
     */
    public function enableAction(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $user->setEnabled(true);
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute("users");
    }

    /**
     *
     * @Route("/{id}/action/disable", name="users_disable")
     */
    public function disableAction(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $user->setEnabled(false);
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute("users");
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/edit", name="users_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(User::class)->find($id);
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
     * @Route("/{id}/driver", name="users_driver")
     */
    public function driverInfoAction(Request $request,User $user)
    {
        $form = $this->createForm('App\Form\UserDriverType', $user, array(
            'action' => $this->generateUrl('users_driver', array('id' => $user->getId())),
        
        ));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $utils = new Utils();
            if ($user->getAssetFile()){
                $fileName = $utils->upload($user->getAssetFile(), "uploads/users/");
                if($fileName){
                    $asset = new Asset();
                    $asset->setAssetBasePath($fileName);
                    $em->persist($asset);
                    $em->flush();
                    $user->setAsset($asset);
                }
            }
            if ($user->getAssetMedicalVisitFile()){
                $fileName = $utils->upload($user->getAssetMedicalVisitFile(), "uploads/users/");
                if($fileName){
                    $asset = new Asset();
                    $asset->setAssetBasePath($fileName);
                    $em->persist($asset);
                    $em->flush();
                    $user->setAssetMedicalVisit($asset);
                }
            }
            if ($user->getAssetDriverLicenseFile()){
                $fileName = $utils->upload($user->getAssetDriverLicenseFile(), "uploads/users/");
                if($fileName){
                    $asset = new Asset();
                    $asset->setAssetBasePath($fileName);
                    $em->persist($asset);
                    $em->flush();
                    $user->setAssetDriverLicense($asset);
                }
            }
            if ($user->getAssetIdentityFile()){
                $fileName = $utils->upload($user->getAssetIdentityFile(), "uploads/users/");
                if($fileName){
                    $asset = new Asset();
                    $asset->setAssetBasePath($fileName);
                    $em->persist($asset);
                    $em->flush();
                    $user->setAssetIdentity($asset);
                }
            }
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('users_driver',['id'=>$user->getId()]);
        }
        return $this->render("admin/users/driver.html.twig",array(
            'user'      => $user,
            'form'   => $form->createView(),
        ));
    }



    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/show/{id}/show", name="users_show_profile")
     */
    public function showAction(User $user)
    {
        return $this->render("admin/users/show.html.twig",array(
            'user'  => $user,
        ));
    }

    /**
     * Creates a form to edit a Employe entity.
     *
     * @param User|\App\Entity\User $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditFormPassword(\App\Entity\User $entity)
    {

        $form = $this->createForm('App\Form\UserPasswordType', $entity, array(
            'action' => $this->generateUrl('user_update_password', array('id' => $entity->getId())),
            
        ));

        // $form->add('submit', SubmitType::class, array('label' => 'Updates password'));

        return $form;
    }


    /**
     * Edits an existing User entity.
     *
     * @Route("/updatepassword/{id}", name="user_update_password")
     * @Template()
     */
    public function updatepasswordAction(Request $request, $id, UserPasswordHasherInterface $passwordHasher)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var User $entity */
        $entity = $em->getRepository(User::class)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        $editForm = $this->createEditFormPassword($entity);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $entity->setPassword($passwordHasher->hashPassword($entity,$entity->getPassword()));
            // $entity->setEnabled($editForm->getData()->getEnabled());
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('users_edit', array('id' => $id)));
        }
        return $this->redirect($this->generateUrl('users'));

    }

    /**
     * Edits an existing Employe entity.
     *
     * @Route("/setrole/{id}", name="user_update_role")
     * @Template()
     */
    public function setroleAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);
        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        $user->removeAllRoles();
        $post = Request::createFromGlobals();
        $roles = $post->request->get('form');
        if(isset($roles['role']) && is_array($roles['role'])){
            foreach ($roles['role'] as $roleName){
                $user->addRole1($roleName);
            }
        }
        $em->persist($user);
        $em->flush();

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
        $form = $this->createForm('App\Form\UserType', $entity, array(
            'action' => $this->generateUrl('users_update', array('id' => $entity->getId())),
        ));


        return $form;
    }
    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}", name="users_update")
     * @Template("admin/users/edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository(User::class)->find($id);

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
     * @Route("/delete/user/confirm/{id}", name="users_delete")
     */
    public function deleteAction(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
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
