<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use App\Entity\BookingGuide;
use App\Entity\BookingProduct;
use App\Entity\EntityHistory;
use App\Entity\PackageGuide;
use App\Entity\PackageProduct;
use App\Entity\Product;
use App\Form\BookingEditType;
use App\Form\BookingGuideType;
use App\Form\BookingMonumentType;
use App\Form\BookingOtherType;
use App\Form\BookingProductType;
use App\Form\BookingTransferType;
use App\Form\BookingTransportType;
use App\Form\BookingType;
use App\Helper\Utils;
use App\Services\ApplicationSettings;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/booking")
 */
class BookingController extends AbstractController
{

    private $settings;
    public function __construct(ApplicationSettings $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @Route("/", name="booking_index", methods={"GET"})
     */
    public function index(): Response
    {
        $bookings = $this->getDoctrine()
            ->getRepository(Booking::class)
            ->findAll();

        return $this->render('admin/bookings/index.html.twig', [
            'bookings' => $bookings,
        ]);
    }

    /**
     * @Route("/new", name="booking_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $booking = new Booking();


        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($booking->getDateStart() < $booking->getDateEnd()){
                $booking->setPax($booking->getNumberOfAdults() + $booking->getNumberOfChildren());


                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($booking);
                $entityManager->flush();


                if($booking->getPackage()){
                    /** @var PackageProduct $product */
                    foreach ($booking->getPackage()->getProducts() as $product){
                        $bookingProduct = new BookingProduct();
                        $bookingProduct->setBooking($booking);
                        $bookingProduct->setProduct($product->getProduct());
                        $bookingProduct->setPricePerAdult($product->getPricePerAdult());
                        $bookingProduct->setPricePerChild($product->getPricePerChild());
                        $bookingProduct->setNumberOfAdults($booking->getNumberOfAdults());
                        $bookingProduct->setNumberOfChildren($booking->getNumberOfChildren());
                        $bookingProduct->setDateStart($booking->getDateStart());
                        $bookingProduct->setDateEnd($booking->getDateEnd());
                        $bookingProduct->setPax($booking->getPax());
                        $bookingProduct->setTotalPrice($bookingProduct->getPricePerAdult() * $bookingProduct->getNumberOfAdults() + $bookingProduct->getPricePerChild() * $bookingProduct->getNumberOfChildren());
                        $entityManager->persist($bookingProduct);
                    }
                    /** @var PackageGuide $guide */
                    foreach ($booking->getPackage()->getGuides() as $guide){
                        $bookingGuide = new BookingGuide();
                        $bookingGuide->setBooking($booking);
                        $bookingGuide->setGuide($guide->getGuide());
                        $bookingGuide->setDateStart($booking->getDateStart());
                        $bookingGuide->setPrice($guide->getPrice());
                        $entityManager->persist($bookingGuide);
                    }
                }

                $entityManager->flush();



                return $this->redirectToRoute('booking_edit', ["id" => $booking->getId()], Response::HTTP_SEE_OTHER);
            }else{
                $form->addError(new FormError('Date start must be less than date end'));
            }
        }

        return $this->renderForm('admin/bookings/new.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="booking_show", methods={"GET"})
     */
    public function show(Booking $booking): Response
    {
        return $this->render('admin/bookings/show.html.twig', [
            'booking' => $booking,
        ]);
    }

    /**
     * @Route("/{id}/add/product", name="booking_add_product", methods={"GET","POST"})
     */
    public function booking_add_product(Request $request, Booking $booking): Response
    {
        $bookingProduct = new BookingProduct();
        $bookingProduct->setBooking($booking);

        $product_form = $this->createForm(BookingProductType::class, $bookingProduct, [
            'action' => $this->generateUrl('booking_add_product', ["id" => $booking->getId()]),
        ]);

        $product_form->handleRequest($request);

        if ($product_form->isSubmitted() && $product_form->isValid()) {

            $bookingProduct->setPax($bookingProduct->getNumberOfAdults() + $bookingProduct->getNumberOfChildren());
            $bookingProduct->setTotalPrice($bookingProduct->getPricePerAdult() * $bookingProduct->getNumberOfAdults() + $bookingProduct->getPricePerChild() * $bookingProduct->getNumberOfChildren());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bookingProduct);
            $entityManager->flush();
        }
        return $this->redirectToRoute('booking_edit', ["id" => $booking->getId()], Response::HTTP_SEE_OTHER);


    }


    /**
     * @Route("/{id}/edit/product", name="booking_edit_product", methods={"GET","POST"})
     */
    public function booking_edit_product(Request $request, BookingProduct $bookingProduct): Response
    {

        if($bookingProduct->getProduct()->getType() === 'transfer'){
            $product_form = $this->createForm(BookingTransferType::class, $bookingProduct, [
                'action' => $this->generateUrl('booking_edit_product', ["id" => $bookingProduct->getId()]),
            ]);
        }elseif($bookingProduct->getProduct()->getType() === 'monument'){
            $product_form = $this->createForm(BookingMonumentType::class, $bookingProduct, [
                'action' => $this->generateUrl('booking_edit_product', ["id" => $bookingProduct->getId()]),
            ]);
        }elseif($bookingProduct->getProduct()->getType() === 'transport'){
            $product_form = $this->createForm(BookingTransportType::class, $bookingProduct, [
                'action' => $this->generateUrl('booking_edit_product', ["id" => $bookingProduct->getId()]),
            ]);
        }elseif($bookingProduct->getProduct()->getType() === 'other'){
            $product_form = $this->createForm(BookingOtherType::class, $bookingProduct, [
                'action' => $this->generateUrl('booking_edit_product', ["id" => $bookingProduct->getId()]),
            ]);
        }else{
            $product_form = $this->createForm(BookingProductType::class, $bookingProduct, [
                'action' => $this->generateUrl('booking_edit_product', ["id" => $bookingProduct->getId()]),
            ]);
        }


        $product_form->handleRequest($request);

        if ($product_form->isSubmitted() && $product_form->isValid()) {

            $bookingProduct->setPax($bookingProduct->getNumberOfAdults() + $bookingProduct->getNumberOfChildren());
            $bookingProduct->setTotalPrice($bookingProduct->getPricePerAdult() * $bookingProduct->getNumberOfAdults() + $bookingProduct->getPricePerChild() * $bookingProduct->getNumberOfChildren());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bookingProduct);
            $entityManager->flush();
            return $this->redirectToRoute('booking_edit', ["id" => $bookingProduct->getBooking()->getId()], Response::HTTP_SEE_OTHER);
        }

        $html = $this->renderView('admin/bookings/edit_product.html.twig', [
            'bookingProduct' => $bookingProduct,
            'product_form' => $product_form->createView(),
        ]);
        return new JsonResponse(['status' => 'success', 'html' => $html]);


    }

    /**
     * @Route("/{id}/edit/guide", name="booking_edit_guide", methods={"GET","POST"})
     */
    public function booking_edit_guide(Request $request, BookingGuide $bookingProduct): Response
    {
        $product_form = $this->createForm(BookingGuideType::class, $bookingProduct, [
            'action' => $this->generateUrl('booking_edit_guide', ["id" => $bookingProduct->getId()]),
        ]);

        $product_form->handleRequest($request);
        if ($product_form->isSubmitted() && $product_form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $bookingProduct->setTotalPrice($bookingProduct->getPrice() * $bookingProduct->getDuration());
            $entityManager->persist($bookingProduct);
            $entityManager->flush();
            return $this->redirectToRoute('booking_edit', ["id" => $bookingProduct->getBooking()->getId()], Response::HTTP_SEE_OTHER);
        }

        $html = $this->renderView('admin/bookings/edit_product.html.twig', [
            "guide" => true,
            'bookingProduct' => $bookingProduct,
            'product_form' => $product_form->createView(),
        ]);
        return new JsonResponse(['status' => 'success', 'html' => $html]);


    }


    /**
     * @Route("/{id}/add/monument", name="booking_add_monument", methods={"POST"})
     */
    public function booking_add_monument(Request $request, Booking $booking): Response
    {
        $bookingProduct = new BookingProduct();
        $bookingProduct->setBooking($booking);

        $product_form = $this->createForm(BookingMonumentType::class, $bookingProduct, [
            'action' => $this->generateUrl('booking_add_monument', ["id" => $booking->getId()]),
        ]);

        $product_form->handleRequest($request);

        if ($product_form->isSubmitted() && $product_form->isValid()) {
            $bookingProduct->setPax($bookingProduct->getNumberOfAdults() + $bookingProduct->getNumberOfChildren());
            $bookingProduct->setTotalPrice($bookingProduct->getPricePerAdult() * $bookingProduct->getNumberOfAdults() + $bookingProduct->getPricePerChild() * $bookingProduct->getNumberOfChildren());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bookingProduct);
            $entityManager->flush();
        }
        return $this->redirectToRoute('booking_edit', ["id" => $booking->getId()], Response::HTTP_SEE_OTHER);


    }


    /**
     * @Route("/{id}/add/transport", name="booking_add_transport", methods={"POST"})
     */
    public function booking_add_transport(Request $request, Booking $booking): Response
    {
        $bookingProduct = new BookingProduct();
        $bookingProduct->setBooking($booking);

        $product_form = $this->createForm(BookingTransportType::class, $bookingProduct, [
            'action' => $this->generateUrl('booking_add_transport', ["id" => $booking->getId()]),
        ]);

        $product_form->handleRequest($request);

        if ($product_form->isSubmitted() && $product_form->isValid()) {
            $bookingProduct->setPax($bookingProduct->getNumberOfAdults() + $bookingProduct->getNumberOfChildren());
            $bookingProduct->setTotalPrice($bookingProduct->getPricePerAdult() * $bookingProduct->getNumberOfAdults() + $bookingProduct->getPricePerChild() * $bookingProduct->getNumberOfChildren());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bookingProduct);
            $entityManager->flush();
        }
        return $this->redirectToRoute('booking_edit', ["id" => $booking->getId()], Response::HTTP_SEE_OTHER);


    }

    /**
     * @Route("/{id}/add/other", name="booking_add_other", methods={"POST"})
     */
    public function booking_add_other(Request $request, Booking $booking): Response
    {
        $bookingProduct = new BookingProduct();
        $bookingProduct->setBooking($booking);

        $product_form = $this->createForm(BookingOtherType::class, $bookingProduct, [
            'action' => $this->generateUrl('booking_add_other', ["id" => $booking->getId()]),
        ]);

        $product_form->handleRequest($request);

        if ($product_form->isSubmitted() && $product_form->isValid()) {
            $bookingProduct->setPax($bookingProduct->getNumberOfAdults() + $bookingProduct->getNumberOfChildren());
            $bookingProduct->setTotalPrice($bookingProduct->getPricePerAdult() * $bookingProduct->getNumberOfAdults() + $bookingProduct->getPricePerChild() * $bookingProduct->getNumberOfChildren());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bookingProduct);
            $entityManager->flush();
        }
        return $this->redirectToRoute('booking_edit', ["id" => $booking->getId()], Response::HTTP_SEE_OTHER);


    }


    /**
     * @Route("/{id}/add/transfer", name="booking_add_transfer", methods={"GET","POST"})
     */
    public function booking_add_transfer(Request $request, Booking $booking): Response
    {
        $bookingProduct = new BookingProduct();
        $bookingProduct->setBooking($booking);

        $product_form = $this->createForm(BookingTransferType::class, $bookingProduct, [
            'action' => $this->generateUrl('booking_add_transfer', ["id" => $booking->getId()]),
        ]);

        $product_form->handleRequest($request);

        if ($product_form->isSubmitted() && $product_form->isValid()) {
            $bookingProduct->setPax($bookingProduct->getNumberOfAdults() + $bookingProduct->getNumberOfChildren());
            $bookingProduct->setTotalPrice($bookingProduct->getPricePerAdult() * $bookingProduct->getNumberOfAdults() + $bookingProduct->getPricePerChild() * $bookingProduct->getNumberOfChildren());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bookingProduct);
            $entityManager->flush();
        }
        return $this->redirectToRoute('booking_edit', ["id" => $booking->getId()], Response::HTTP_SEE_OTHER);


    }

    /**
     * @Route("/{id}/add/guide", name="booking_add_guide", methods={"POST"})
     */
    public function booking_add_guide(Request $request, Booking $booking): Response
    {
        $bookingGuide = new BookingGuide();
        $bookingGuide->setBooking($booking);

        $guide_form = $this->createForm(BookingGuideType::class, $bookingGuide, [
            'action' => $this->generateUrl('booking_add_transfer', ["id" => $booking->getId()]),
        ]);

        $guide_form->handleRequest($request);

        if ($guide_form->isSubmitted() && $guide_form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $bookingGuide->setTotalPrice($bookingGuide->getPrice() * $bookingGuide->getDuration());
            $entityManager->persist($bookingGuide);
            $entityManager->flush();
        }
        return $this->redirectToRoute('booking_edit', ["id" => $booking->getId()], Response::HTTP_SEE_OTHER);


    }
    /**
     * @Route("/export/{id}", name="booking_export")
     */
    public function export(Request $request, Booking $booking, TranslatorInterface $translator)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // set column width 30 for A to E

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);

        $lineNumber = 3;

        // merge cells A1 to D1
        $sheet->mergeCells('A'.$lineNumber.':D'.$lineNumber.'');
        $sheet->setCellValue('A'.$lineNumber.'', $translator->trans('Invoice Number : ') . $booking->getId());

        $sheet->mergeCells('E'.$lineNumber.':H'.$lineNumber.'');
        $sheet->setCellValue('E'.$lineNumber.'', $translator->trans('Date : ') . $booking->getDateCreate()->format('Y-m-d'));

        // set background color for cells A1 to E1
        $sheet->getStyle('A'.$lineNumber.':H'.$lineNumber.'')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFd2f1f5');

        // // set border color for cells A1 to E1
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $sheet->getStyle('A'.$lineNumber.':H'.$lineNumber.'')->applyFromArray($styleArray);

//        Date de séjour :
        $lineNumber++;
        $sheet->getStyle('A'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->mergeCells('B'.$lineNumber.':H'.$lineNumber.'');
        $sheet->getStyle('B'.$lineNumber.':H'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->setCellValue('A'.$lineNumber.'', $translator->trans('Booking dates :'));
        $sheet->setCellValue('B'.$lineNumber.'', $booking->getDateStart()->format('Y-m-d'));
//        Référence groupe:
        $lineNumber++;
        $sheet->getStyle('A'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->mergeCells('B'.$lineNumber.':H'.$lineNumber.'');
        $sheet->getStyle('B'.$lineNumber.':H'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->setCellValue('A'.$lineNumber.'', $translator->trans('Group reference:'));
        $sheet->setCellValue('B'.$lineNumber.'', '-');
//        Nbre de personne :
        $lineNumber++;
        $sheet->getStyle('A'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->mergeCells('B'.$lineNumber.':H'.$lineNumber.'');
        $sheet->getStyle('B'.$lineNumber.':H'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->setCellValue('A'.$lineNumber.'', $translator->trans('Number of pax :'));
        $sheet->setCellValue('B'.$lineNumber.'', $booking->getNumberOfAdults() + $booking->getNumberOfChildren());

        // Tarif convenu	Nbre de pax	Total à régler	Devis	Date	Total en Dhs	Date de règlement	Mode de règlement
        $lineNumber++;
        $sheet->getStyle('A'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->getStyle('A'.($lineNumber+1).'')->applyFromArray($styleArray);
        $sheet->setCellValue('A'.$lineNumber, $translator->trans("Tarif convenu"));
        $sheet->setCellValue('A'.($lineNumber+1), "-");

        $sheet->getStyle('B'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->getStyle('B'.($lineNumber+1).'')->applyFromArray($styleArray);
        $sheet->setCellValue('B'.$lineNumber, $translator->trans("Nbre de pax"));
        $sheet->setCellValue('B'.($lineNumber+1), $booking->getPax());

        $sheet->getStyle('C'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->getStyle('C'.($lineNumber+1).'')->applyFromArray($styleArray);
        $sheet->setCellValue('C'.$lineNumber, $translator->trans("Total à régler"));
        $sheet->setCellValue('C'.($lineNumber+1), $this->settings->convertedPrice($booking->getTotalPriceTtc()));

        $sheet->getStyle('D'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->getStyle('D'.($lineNumber+1).'')->applyFromArray($styleArray);
        $sheet->setCellValue('D'.$lineNumber, $translator->trans("Devis"));
        $sheet->setCellValue('D'.($lineNumber+1), $this->settings->application_currency);

        $sheet->getStyle('E'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->getStyle('E'.($lineNumber+1).'')->applyFromArray($styleArray);
        $sheet->setCellValue('E'.$lineNumber, $translator->trans("Date"));
        $sheet->setCellValue('E'.($lineNumber+1), "-");

        $sheet->getStyle('F'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->getStyle('F'.($lineNumber+1).'')->applyFromArray($styleArray);
        $sheet->setCellValue('F'.$lineNumber, $translator->trans("Total en Dhs"));
        $sheet->setCellValue('F'.($lineNumber+1), "-");

        $sheet->getStyle('G'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->getStyle('G'.($lineNumber+1).'')->applyFromArray($styleArray);
        $sheet->setCellValue('G'.$lineNumber, $translator->trans("Date de règlement"));
        $sheet->setCellValue('G'.($lineNumber+1), "-");

        $sheet->getStyle('H'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->getStyle('H'.($lineNumber+1).'')->applyFromArray($styleArray);
        $sheet->setCellValue('H'.$lineNumber, $translator->trans("Mode de règlement"));
        $sheet->setCellValue('H'.($lineNumber+1), "-");

        $lineNumber++;

        $lineNumber++;
        $sheet->getStyle('A'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->setCellValue('A'.$lineNumber.'', $translator->trans('Product'));
        $sheet->setCellValue('B'.$lineNumber.'', $translator->trans('Adults'));
        $sheet->setCellValue('C'.$lineNumber.'', $translator->trans('Price/Adult'));
        $sheet->setCellValue('D'.$lineNumber.'', $translator->trans('Children'));
        $sheet->setCellValue('E'.$lineNumber.'', $translator->trans('Price/Child'));
        $sheet->setCellValue('F'.$lineNumber.'', $translator->trans('Pax'));
        $sheet->setCellValue('H'.$lineNumber.'', $translator->trans('Total Price'));

        /** @var BookingProduct $bookingProduct */
        foreach ($booking->getProducts() as $bookingProduct) {
            $lineNumber++;
            $sheet->getStyle('A'.$lineNumber.'')->applyFromArray($styleArray);
            $sheet->setCellValue('A'.$lineNumber.'', $bookingProduct->getProduct()->getName());
            $sheet->setCellValue('B'.$lineNumber.'', $bookingProduct->getNumberOfAdults());
            $sheet->setCellValue('C'.$lineNumber.'', $this->settings->convertedPrice($bookingProduct->getPricePerAdult()));
            $sheet->setCellValue('D'.$lineNumber.'', $bookingProduct->getNumberOfChildren());
            $sheet->setCellValue('E'.$lineNumber.'', $this->settings->convertedPrice($bookingProduct->getPricePerChild()));
            $sheet->setCellValue('F'.$lineNumber.'', $bookingProduct->getPax());
            $sheet->setCellValue('H'.$lineNumber.'', $this->settings->convertedPrice($bookingProduct->getTotalPrice()));
        }

//        Total des Recettes
//        Total des Débours
//        Résultat TTC
//        Commission Hors Taxes
//        TVA

        $lineNumber++;
        $sheet->getStyle('A'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->mergeCells('B'.$lineNumber.':H'.$lineNumber.'');
        $sheet->getStyle('B'.$lineNumber.':H'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->setCellValue('A'.$lineNumber.'', $translator->trans('Total Revenue :'));
        $sheet->setCellValue('B'.$lineNumber.'', '-');
        $lineNumber++;
        $sheet->getStyle('A'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->mergeCells('B'.$lineNumber.':H'.$lineNumber.'');
        $sheet->getStyle('B'.$lineNumber.':H'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->setCellValue('A'.$lineNumber.'', $translator->trans('Total Disbursements :'));
        $sheet->setCellValue('B'.$lineNumber.'', '-');
        $lineNumber++;
        $sheet->getStyle('A'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->mergeCells('B'.$lineNumber.':H'.$lineNumber.'');
        $sheet->getStyle('B'.$lineNumber.':H'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->setCellValue('A'.$lineNumber.'', $translator->trans('Result including tax :'));
        $sheet->setCellValue('B'.$lineNumber.'', '-');
        $lineNumber++;
        $sheet->getStyle('A'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->mergeCells('B'.$lineNumber.':H'.$lineNumber.'');
        $sheet->getStyle('B'.$lineNumber.':H'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->setCellValue('A'.$lineNumber.'', $translator->trans('Commission excluding tax :'));
        $sheet->setCellValue('B'.$lineNumber.'', '-');

        $lineNumber++;
        $sheet->getStyle('A'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->mergeCells('B'.$lineNumber.':H'.$lineNumber.'');
        $sheet->getStyle('B'.$lineNumber.':H'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->setCellValue('A'.$lineNumber.'', 'Subtotal :');
        $sheet->setCellValue('B'.$lineNumber.'', $this->settings->convertedPrice($booking->getTotalPrice()));

        $lineNumber++;
        $sheet->getStyle('A'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->mergeCells('B'.$lineNumber.':H'.$lineNumber.'');
        $sheet->getStyle('B'.$lineNumber.':H'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->setCellValue('A'.$lineNumber.'', 'TVA :');
        $sheet->setCellValue('B'.$lineNumber.'', $this->settings->convertedPrice($booking->getTotalTva()));

        $lineNumber++;
        $sheet->getStyle('A'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->mergeCells('B'.$lineNumber.':H'.$lineNumber.'');
        $sheet->getStyle('B'.$lineNumber.':H'.$lineNumber.'')->applyFromArray($styleArray);
        $sheet->setCellValue('A'.$lineNumber.'', 'Total :');
        $sheet->setCellValue('B'.$lineNumber.'', $this->settings->convertedPrice($booking->getTotalPriceTtc()));


        $response = new Response();
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment;filename="invoice-'.$booking->getId().'.xlsx"');
        $response->headers->set('Cache-Control', 'max-age=0');

        $response->sendHeaders();
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
    /**
     * @Route("/set/state/{state}/{id}", name="bookings_set_state")
     */
    public function setState(Request $request, $state, Booking $booking): Response
    {
        $em = $this->getDoctrine()->getManager();
        $state = $request->get('state');
        if ($state === 'pending') {
            $booking->setStatus(0);
        }
        if ($state === 'confirmed') {
            $booking->setStatus(1);
        }
        if ($state === 'cancelled') {
            $booking->setStatus(2);
        }
        $em->persist($booking);
        $em->flush();

        //**
        $entityHistory = new EntityHistory();
        $entityHistory->setUser($this->getUser());
        $entityHistory->setEntityName(Booking::class);
        $entityHistory->setEntityId($booking->getId());
        $entityHistory->setActionName('status');
        $entityHistory->setActionValue($booking->getStatus());
        $em->persist($entityHistory);
        $em->flush();

        $referer = $request->headers->get('referer');
        if ($referer) {
            return new RedirectResponse($referer);
        }
        return $this->redirect($this->generateUrl('booking_show', ["id" => $booking->getId()]));
    }
    /**
     * @Route("/{id}/edit", name="booking_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Booking $booking): Response
    {
        $form = $this->createForm(BookingEditType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $booking->setPax($booking->getNumberOfAdults() + $booking->getNumberOfChildren());
            $em->persist($booking);
            $em->flush();
            return $this->redirectToRoute('booking_edit', ["id" => $booking->getId()], Response::HTTP_SEE_OTHER);
        }

        $bookingProduct = new BookingProduct();
        $bookingProduct->setBooking($booking);
        $bookingProduct->setDateStart($booking->getDateStart());
        $bookingProduct->setDateEnd($booking->getDateEnd());
        $bookingProduct->setNumberOfAdults($booking->getNumberOfAdults());
        $bookingProduct->setNumberOfChildren($booking->getNumberOfChildren());
        $bookingProduct->setPax($booking->getNumberOfAdults() + $booking->getNumberOfChildren());

        $product_form = $this->createForm(BookingProductType::class, $bookingProduct, [
            'action' => $this->generateUrl('booking_add_product', ["id" => $booking->getId()]),
        ]);

        $transfer_form = $this->createForm(BookingTransferType::class, $bookingProduct, [
            'action' => $this->generateUrl('booking_add_transfer', ["id" => $booking->getId()]),
        ]);
        $monument_form = $this->createForm(BookingMonumentType::class, $bookingProduct, [
            'action' => $this->generateUrl('booking_add_monument', ["id" => $booking->getId()]),
        ]);
        $transport_form = $this->createForm(BookingTransportType::class, $bookingProduct, [
            'action' => $this->generateUrl('booking_add_transport', ["id" => $booking->getId()]),
        ]);
        $other_form = $this->createForm(BookingOtherType::class, $bookingProduct, [
            'action' => $this->generateUrl('booking_add_other', ["id" => $booking->getId()]),
        ]);

        $bookingGuide = new BookingGuide();
        $guide_form = $this->createForm(BookingGuideType::class, $bookingGuide, [
            'action' => $this->generateUrl('booking_add_guide', ["id" => $booking->getId()]),
        ]);

        return $this->renderForm('admin/bookings/edit.html.twig', [
            'booking' => $booking,
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
     * @Route("/delete/{id}", name="booking_delete", methods={"POST"})
     */
    public function delete(Request $request, Booking $booking): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($booking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('booking_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/api/get-product-prices/{id}", name="booking_product_price")
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
     * @Route("/delete/product/{id}/line", name="booking_delete_product")
     */
    public function deleteProduct(Request $request, BookingProduct $bookingProduct): Response
    {
        $booking = $bookingProduct->getBooking();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($bookingProduct);
        $entityManager->flush();

        return $this->redirectToRoute('booking_edit', ["id" => $booking->getId()], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/delete/guide/{id}/line", name="booking_delete_guide")
     */
    public function booking_delete_guide(Request $request, BookingGuide $bookingProduct): Response
    {
        $booking = $bookingProduct->getBooking();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($bookingProduct);
        $entityManager->flush();

        return $this->redirectToRoute('booking_edit', ["id" => $booking->getId()], Response::HTTP_SEE_OTHER);
    }
}
