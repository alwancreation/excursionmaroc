<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use App\Entity\BookingGuide;
use App\Entity\BookingProduct;
use App\Entity\EntityHistory;
use App\Entity\Package;
use App\Entity\PackageGuide;
use App\Entity\PackageProduct;
use App\Entity\Product;
use App\Form\BookingGuideType;
use App\Form\BookingMonumentType;
use App\Form\BookingOtherType;
use App\Form\BookingProductType;
use App\Form\BookingTransferType;
use App\Form\BookingTransportType;
use App\Form\BookingType;
use App\Form\PackageGuideType;
use App\Form\PackageMonumentType;
use App\Form\PackageOtherType;
use App\Form\PackageProductType;
use App\Form\PackageTransferType;
use App\Form\PackageTransportType;
use App\Form\PackageType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/packages")
 */
class PackagesController extends AbstractController
{
    /**
     * @Route("/", name="package_index", methods={"GET"})
     */
    public function index(): Response
    {
        $packages = $this->getDoctrine()
            ->getRepository(Package::class)
            ->findAll();

        return $this->render('admin/packages/index.html.twig', [
            'packages' => $packages,
        ]);
    }

    /**
     * @Route("/new", name="package_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $package = new Package();
        $form = $this->createForm(PackageType::class, $package);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($package);
            $entityManager->flush();

            return $this->redirectToRoute('package_edit', ["id" => $package->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/packages/new.html.twig', [
            'package' => $package,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="package_show", methods={"GET"})
     */
    public function show(Package $package): Response
    {
        return $this->render('admin/packages/show.html.twig', [
            'package' => $package,
        ]);
    }

    /**
     * @Route("/{id}/add/product", name="package_add_product", methods={"GET","POST"})
     */
    public function package_add_product(Request $request, Package $package): Response
    {
        $packageProduct = new PackageProduct();
        $packageProduct->setPackage($package);

        $product_form = $this->createForm(PackageProductType::class, $packageProduct, [
            'action' => $this->generateUrl('package_add_product', ["id" => $package->getId()]),
        ]);

        $product_form->handleRequest($request);

        if ($product_form->isSubmitted() && $product_form->isValid()) {


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($packageProduct);
            $entityManager->flush();
        }
        return $this->redirectToRoute('package_edit', ["id" => $package->getId()], Response::HTTP_SEE_OTHER);


    }


    /**
     * @Route("/{id}/add/monument", name="package_add_monument", methods={"POST"})
     */
    public function package_add_monument(Request $request, Package $package): Response
    {
        $packageProduct = new PackageProduct();
        $packageProduct->setPackage($package);

        $product_form = $this->createForm(PackageMonumentType::class, $packageProduct, [
            'action' => $this->generateUrl('package_add_monument', ["id" => $package->getId()]),
        ]);

        $product_form->handleRequest($request);

        if ($product_form->isSubmitted() && $product_form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($packageProduct);
            $entityManager->flush();
        }
        return $this->redirectToRoute('package_edit', ["id" => $package->getId()], Response::HTTP_SEE_OTHER);


    }


    /**
     * @Route("/{id}/add/transport", name="package_add_transport", methods={"POST"})
     */
    public function package_add_transport(Request $request, Package $package): Response
    {
        $packageProduct = new PackageProduct();
        $packageProduct->setPackage($package);

        $product_form = $this->createForm(PackageTransportType::class, $packageProduct, [
            'action' => $this->generateUrl('package_add_transport', ["id" => $package->getId()]),
        ]);

        $product_form->handleRequest($request);

        if ($product_form->isSubmitted() && $product_form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($packageProduct);
            $entityManager->flush();
        }
        return $this->redirectToRoute('package_edit', ["id" => $package->getId()], Response::HTTP_SEE_OTHER);


    }

    /**
     * @Route("/{id}/add/other", name="package_add_other", methods={"POST"})
     */
    public function package_add_other(Request $request, Package $package): Response
    {
        $packageProduct = new PackageProduct();
        $packageProduct->setPackage($package);

        $product_form = $this->createForm(PackageOtherType::class, $packageProduct, [
            'action' => $this->generateUrl('package_add_other', ["id" => $package->getId()]),
        ]);

        $product_form->handleRequest($request);

        if ($product_form->isSubmitted() && $product_form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($packageProduct);
            $entityManager->flush();
        }
        return $this->redirectToRoute('package_edit', ["id" => $package->getId()], Response::HTTP_SEE_OTHER);


    }


    /**
     * @Route("/{id}/add/transfer", name="package_add_transfer", methods={"GET","POST"})
     */
    public function package_add_transfer(Request $request, Package $package): Response
    {
        $packageProduct = new PackageProduct();
        $packageProduct->setPackage($package);

        $product_form = $this->createForm(PackageTransferType::class, $packageProduct, [
            'action' => $this->generateUrl('package_add_transfer', ["id" => $package->getId()]),
        ]);

        $product_form->handleRequest($request);

        if ($product_form->isSubmitted() && $product_form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($packageProduct);
            $entityManager->flush();
        }
        return $this->redirectToRoute('package_edit', ["id" => $package->getId()], Response::HTTP_SEE_OTHER);


    }

    /**
     * @Route("/{id}/add/guide", name="package_add_guide", methods={"POST"})
     */
    public function package_add_guide(Request $request, Package $package): Response
    {
        $packageGuide = new PackageGuide();
        $packageGuide->setPackage($package);

        $guide_form = $this->createForm(PackageGuideType::class, $packageGuide, [
            'action' => $this->generateUrl('package_add_transfer', ["id" => $package->getId()]),
        ]);

        $guide_form->handleRequest($request);

        if ($guide_form->isSubmitted() && $guide_form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($packageGuide);
            $entityManager->flush();
        }
        return $this->redirectToRoute('package_edit', ["id" => $package->getId()], Response::HTTP_SEE_OTHER);


    }
    /**
     * @Route("/export/{id}", name="package_export")
     */
    public function export(Request $request, Package $package, TranslatorInterface $translator)
    {}

    /**
     * @Route("/set/state/{state}/{id}", name="packages_set_state")
     */
    public function setState(Request $request, $state, Package $package): Response
    {
        $em = $this->getDoctrine()->getManager();
        $state = $request->get('state');
        if ($state === 'pending') {
            $package->setStatus(0);
        }
        if ($state === 'confirmed') {
            $package->setStatus(1);
        }
        if ($state === 'cancelled') {
            $package->setStatus(2);
        }
        $em->persist($package);
        $em->flush();

        //**
        $entityHistory = new EntityHistory();
        $entityHistory->setUser($this->getUser());
        $entityHistory->setEntityName(Package::class);
        $entityHistory->setEntityId($package->getId());
        $entityHistory->setActionName('status');
        $entityHistory->setActionValue($package->getStatus());
        $em->persist($entityHistory);
        $em->flush();

        $referer = $request->headers->get('referer');
        if ($referer) {
            return new RedirectResponse($referer);
        }
        return $this->redirect($this->generateUrl('package_show', ["id" => $package->getId()]));
    }
    /**
     * @Route("/{id}/edit", name="package_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Package $package): Response
    {
        $form = $this->createForm(PackageType::class, $package);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // $package->setPax($package->getNumberOfAdults() + $package->getNumberOfChildren());
            $em->persist($package);
            $em->flush();
            return $this->redirectToRoute('package_edit', ["id" => $package->getId()], Response::HTTP_SEE_OTHER);
        }

        $packageProduct = new PackageProduct();
        $packageProduct->setPackage($package);

        $product_form = $this->createForm(PackageProductType::class, $packageProduct, [
            'action' => $this->generateUrl('package_add_product', ["id" => $package->getId()]),
        ]);

        $transfer_form = $this->createForm(PackageTransferType::class, $packageProduct, [
            'action' => $this->generateUrl('package_add_transfer', ["id" => $package->getId()]),
        ]);
        $monument_form = $this->createForm(PackageMonumentType::class, $packageProduct, [
            'action' => $this->generateUrl('package_add_monument', ["id" => $package->getId()]),
        ]);
        $transport_form = $this->createForm(PackageTransportType::class, $packageProduct, [
            'action' => $this->generateUrl('package_add_transport', ["id" => $package->getId()]),
        ]);
        $other_form = $this->createForm(PackageOtherType::class, $packageProduct, [
            'action' => $this->generateUrl('package_add_other', ["id" => $package->getId()]),
        ]);

        $packageGuide = new PackageGuide();
        $guide_form = $this->createForm(PackageGuideType::class, $packageGuide, [
            'action' => $this->generateUrl('package_add_guide', ["id" => $package->getId()]),
        ]);

        return $this->renderForm('admin/packages/edit.html.twig', [
            'package' => $package,
            'form' => $form,
            'product_form' => $product_form ,
            'transfer_form' => $transfer_form,
            'guide_form' => $guide_form,
            'monument_form' => $monument_form,
            'transport_form' => $transport_form,
            'other_form' => $other_form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="package_delete", methods={"POST"})
     */
    public function delete(Request $request, Package $package): Response
    {
        if ($this->isCsrfTokenValid('delete'.$package->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($package);
            $entityManager->flush();
        }

        return $this->redirectToRoute('package_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/api/get-product-prices/{id}", name="package_product_price")
     */
    public function getProductPrice(Request $request, Product $product): Response
    {
        return new JsonResponse([
            "success" => true,
            "item" => [
                'price' => $product->getPrice(),
                'pricePerChild' => $product->getPricePerChild(),
                'pricePerAdult' => $product->getPricePerAdult(),
            ]
        ]);
    }
    /**
     * @Route("/delete/product/{id}/line", name="package_delete_product")
     */
    public function deleteProduct(Request $request, PackageProduct $packageProduct): Response
    {
        $package = $packageProduct->getPackage();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($packageProduct);
        $entityManager->flush();

        return $this->redirectToRoute('package_edit', ["id" => $package->getId()], Response::HTTP_SEE_OTHER);
    }
}
