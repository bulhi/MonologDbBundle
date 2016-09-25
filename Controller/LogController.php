<?php

namespace Bulhi\MonologDbBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LogController extends Controller
{

    /**
     * Show list of log entries
     * 
     * @param Request $request 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $entries = $this->getDoctrine()
            ->getRepository('BulhiMonologDbBundle:LogEntry')
            ->findAll();

        return $this->render('BulhiMonologDbBundle:Log:index.html.twig', [
            'entries' => $entries
        ]);
    }
}
