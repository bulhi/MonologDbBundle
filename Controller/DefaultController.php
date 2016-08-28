<?php

namespace Bulhi\MonologDbBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BulhiMonologDbBundle:Default:index.html.twig');
    }
}
