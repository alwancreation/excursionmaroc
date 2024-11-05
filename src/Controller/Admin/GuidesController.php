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
 * Guides controller.
 *
 * @Route("/admin/guides")
 */
class GuidesController extends AbstractController
{

    /**
     *
     * @Route("/", name="guides_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->findGuides();

        return $this->render('admin/guides/index.html.twig',array(
            'users' => $users,
        ));
    }

    /**
     * Creates a new User entity.
     *
     * @Route("/create", name="guides_create")
     * @Template("admin/guides/new.html.twig")
     */
    public function createAction(Request $request)
    {
        $user = new User();
        $user->setRoles(array('ROLE_GUIDE'));
        $user->setUserType('guide');
        $form = $this->createCreateForm($user);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
//            $user->setUsername($user->getEmail());
//            $user->setPlainPassword("RANDOMPASSORD");
            $em->persist($user);
            $em->flush();
            return $this->redirect($this->generateUrl('guides_index'));
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
        $form = $this->createForm('App\Form\UserGuideType', $entity, array(
            'action' => $this->generateUrl('guides_create'),
            'method' => 'POST',
        ));


        return $form;
    }

    /**
     * Displays a form to create a new User entity.
     *
     * @Route("/new", name="guides_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new User();
        $entity->setRoles(array('ROLE_GUIDE'));
        $entity->setUserType('guide');
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     *
     * @Route("/{id}/action/enable", name="guides_enable")
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
     * @Route("/{id}/action/disable", name="guides_disable")
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
     * @Route("/{id}/edit", name="guides_edit")
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
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'guides_menu'=>true,
        );
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/driver", name="guides_driver")
     */
    public function driverInfoAction(Request $request,User $user)
    {
        $form = $this->createForm('App\Form\UserDriverType', $user, array(
            'action' => $this->generateUrl('guides_driver', array('id' => $user->getId())),
        
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
            return $this->redirectToRoute('guides_driver',['id'=>$user->getId()]);
        }
        return $this->render("admin/guides/driver.html.twig",array(
            'user'      => $user,
            'form'   => $form->createView(),
        ));
    }



    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/show/{id}/show", name="guides_show_profile")
     */
    public function showAction(User $user)
    {
        return $this->render("admin/guides/show.html.twig",array(
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
            return $this->redirect($this->generateUrl('guides_edit', array('id' => $id)));
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

        return $this->redirect($this->generateUrl('guides_edit', array('id' => $id)));


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
        return $this->createForm('App\Form\UserGuideType', $entity, array(
            'action' => $this->generateUrl('guides_update', array('id' => $entity->getId())),
        ));
    }
    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}", name="guides_update")
     * @Template("admin/guides/edit.html.twig")
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

            return $this->redirect($this->generateUrl('guides_edit', array('id' => $id)));
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
     * @Route("/delete/user/confirm/{id}", name="guides_delete")
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
            ->setAction($this->generateUrl('guides_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
