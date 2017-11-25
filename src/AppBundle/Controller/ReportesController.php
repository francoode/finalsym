<?php

namespace AppBundle\Controller;

use AppBundle\Form\ReporteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class ReportesController
 * @package AppBundle\Controller
 * @Route("reporte")
 */
class ReportesController extends Controller
{
    /**
     * @Route("/paciente", name="pacienteReporte")
     */
    public function reporteClienteAction()
    {
        $form = $this->createForm(new ReporteType(), array(
            'action' => $this->generateUrl('pacienteReporte'),
            'method' => 'POST'
        ));

        return $this->render('AppBundle:reportes:reporteCliente.html.twig', array(
            'form' => $form->createView()
        ));

    }
}
