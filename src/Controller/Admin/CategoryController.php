<?php

namespace App\Controller\Admin;

use App\Entity\Asset;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Helper\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/categories")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="category_index", methods={"GET"})
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('admin/category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/new", name="category_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleUpload($form, $category);
            $this->ensureSlug($category);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="category_edit", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function edit(Request $request, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleUpload($form, $category);
            $this->ensureSlug($category);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="category_delete", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request, Category $category): Response
    {
        if ($this->isCsrfTokenValid('delete' . $category->getCategoryId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($category);
            try {
                $entityManager->flush();
            } catch (\Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException $e) {
                $this->addFlash('error', 'Cette catégorie est encore utilisée par des destinations ou des excursions et ne peut pas être supprimée.');
            }
        }

        return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
    }

    private function handleUpload($form, Category $category): void
    {
        if ($category->getIconFile()) {
            $file = $form->get('iconFile')->getData();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move('uploads/categories', $fileName);

            $asset = new Asset();
            $asset->setAssetBasePath($fileName);
            $this->getDoctrine()->getManager()->persist($asset);

            $category->setCategoryIcon($asset);
            $category->setIconFile(null);
        }
    }

    private function ensureSlug(Category $category): void
    {
        if (!$category->getCategorySlug()) {
            $category->setCategorySlug((new Utils())->slugify($category->getCategoryName(), ['transliterate' => true]));
        }
    }
}
