<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Component\Validator\Constraints\DateTime;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        return $this->render('front.html.twig');
    }

    /**
     * @Route("/pdfPaciente/{idP}", name="pdfCliente")
     */
    public function reporteClientePdf($idP)
    {
        $em = $this->getDoctrine()->getManager();

        $analisi = $em->getRepository('AppBundle:Analisis')->find($idP);
        $allItem = $em->getRepository('AppBundle:ResultadoAnalisis')->findBy(array('analisis' => $analisi));



        $html = $this->renderView('AppBundle:pdfReporteAnalisis:pdfCliente.html.twig', array(
            'analisi' => $analisi,
            'allitem' => $allItem,
        ));

        $head = $this->renderView('AppBundle:pdfReporteAnalisis:headpdf.html.twig',array(
                'analisi' => $analisi,
            )
        );

        $boot = $this->renderView('AppBundle:pdfReporteAnalisis:bootpdf.html.twig');

        $nombrePdf = 'A-';
         $nombrePdf .= $analisi->getId();
        $nombrePdf .= 'Pac-';
        $nombrePdf .= $analisi->getPaciente()->getNombre();
        $nombrePdf .= $analisi->getPaciente()->getApellido();
        $nombrePdf .= '.pdf';




     return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html, array(
                'orientation' => 'landscape',
                'enable-javascript' => true,
                'header-html' => $head,
                'footer-html' => $boot,
                'javascript-delay' => 1000,
                'no-stop-slow-scripts' => true,
                'no-background' => false,
                'lowquality' => false,
                'encoding' => 'utf-8',
                'images' => true,
                'cookie' => array(),
                'page-height' =>  140,
                'page-width' => 175,
                'margin-top' => 15,
                'margin-bottom' => 15,
                'dpi' => 300,
                'image-dpi' => 300,
                'enable-external-links' => true,
                'enable-internal-links' => true
            )),
            $nombrePdf
        );

    }

    /**
     * @Route("/pdfProfesional/{idP}", name="pdfProfesional")
     */
    public function reporteProfesionalpdf($idP)
    {
        $em = $this->getDoctrine()->getManager();
        $analisi = $em->getRepository('AppBundle:Analisis')->find($idP);

        $html =  $this->renderView('AppBundle:pdfReporteAnalisis:pdfProfesional.html.twig', array(
            'analisi' => $analisi
        ));

        $boot = $this->renderView('AppBundle:pdfReporteAnalisis:bootpdfP.html.twig');

        $nombrePdf = 'A-';
        $nombrePdf .= $analisi->getId();
        $nombrePdf .= 'Pac-';
        $nombrePdf .= $analisi->getPaciente()->getNombre();
        $nombrePdf .= $analisi->getPaciente()->getApellido();
        $nombrePdf .= 'Pro-';
        $nombrePdf .= $analisi->getProfesional()->getNombre();
        $nombrePdf .= $analisi->getProfesional()->getApellido();
        $nombrePdf .= '.pdf';


        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html, array(
                'orientation' => 'landscape',
                'enable-javascript' => true,
                'javascript-delay' => 1000,
                'no-stop-slow-scripts' => true,
                'header-html' => $boot,
                'no-background' => false,
                'lowquality' => false,
                'encoding' => 'utf-8',
                'page-height' =>  210,
                'page-width' => 250,
                'images' => true,
                'cookie' => array(),
                'margin-top' => 15,
                'margin-bottom' => 15,
                'dpi' => 300,
                'image-dpi' => 300,
                'enable-external-links' => true,
                'enable-internal-links' => true
            )),
            $nombrePdf
        );



    }


    /**
     * @Route("/cantidadOS/{fi}/{ff}/", name="pdfCantidadOS")
     */
    public function reporteCantidadOSpdf( $fi, $ff)
    {


        $cantidad = $this->getDoctrine()->getRepository('AppBundle:Analisis')->getCantidadOS($fi, $ff);
        $total = $this->getDoctrine()->getRepository('AppBundle:Analisis')->getTotalOS($fi, $ff);
        $total = $total[0];


        $html =  $this->renderView('AppBundle:pdfReporteAnalisis:pdfCantidadOS.html.twig', array(
            'fi' => $fi,
            'ff' => $ff,
            'total' => $total,
            'cantidad' => $cantidad
        ));

        $head = $this->renderView('AppBundle:pdfReporteAnalisis:bootpdfP.html.twig');




        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html, array(
                'orientation' => 'landscape',
                'enable-javascript' => true,
                'javascript-delay' => 1000,
                'no-stop-slow-scripts' => true,
                'header-html' => $head,
                'no-background' => false,
                'lowquality' => false,
                'encoding' => 'utf-8',
                'page-height' =>  210,
                'page-width' => 250,
                'images' => true,
                'cookie' => array(),
                'margin-top' => 15,
                'margin-bottom' => 15,
                'dpi' => 300,
                'image-dpi' => 300,
                'enable-external-links' => true,
                'enable-internal-links' => true
            )),
            'os.pdf'
        );



    }


    /**
     * @Route("/cantidadTipo/{fi}/{ff}/", name="pdfCantidiadTipo")
     */
    public function reporteCantidadTipoAction( $fi, $ff)
    {


        $cantidad = $this->getDoctrine()->getRepository('AppBundle:Analisis')->getCantidadTipo($fi, $ff);
        $total = $this->getDoctrine()->getRepository('AppBundle:Analisis')->getTotalTipo($fi, $ff);
        $total = $total[0];


        $html =  $this->renderView('AppBundle:pdfReporteAnalisis:pdfCantidadTipo.html.twig', array(
            'fi' => $fi,
            'ff' => $ff,
            'total' => $total,
            'cantidad' => $cantidad
        ));

        $head = $this->renderView('AppBundle:pdfReporteAnalisis:bootpdfP.html.twig');




        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html, array(
                'orientation' => 'landscape',
                'enable-javascript' => true,
                'javascript-delay' => 1000,
                'no-stop-slow-scripts' => true,
                'header-html' => $head,
                'no-background' => false,
                'lowquality' => false,
                'encoding' => 'utf-8',
                'page-height' =>  210,
                'page-width' => 250,
                'images' => true,
                'cookie' => array(),
                'margin-top' => 15,
                'margin-bottom' => 15,
                'dpi' => 300,
                'image-dpi' => 300,
                'enable-external-links' => true,
                'enable-internal-links' => true
            )),
            'tipoanalisis.pdf'
        );



    }


    /**
     * @Route("/adm/edit/", name="edit_administrador")
     */
    public function editAdmAction(Request $request)
    {
        $obj = $this->get('security.token_storage')->getToken()->getUser();
        $idT = $obj->getId();
        $adm = $this->getDoctrine()->getRepository('AppBundle:Administrador')->find($idT);

        $form = $this->createForm('AppBundle\Form\AdministradorType', $adm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('edit_administrador');
        }

        return $this->render('AppBundle:administrador:edit.html.twig', array(
            'form' => $form->createView(),
        ));

    }







}
