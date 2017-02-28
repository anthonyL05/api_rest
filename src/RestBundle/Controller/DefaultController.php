<?php

namespace RestBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as Reponse;

class DefaultController extends FOSRestController
{

    public function getNameAction($user)
    {
        $data = "a";
        $view = $this->view($data, 200)
            ->setTemplate("MyBundle:Names:getNames.html.twig")
            ->setTemplateVar('names')
        ;
        return $this->handleView($view);
    }
    public function redirectAction()
    {
        $view = $this->redirectView($this->generateUrl('some_route'), 301);
        $view = $this->routeRedirectView('some_route', array(), 301);

        return $this->handleView($view);
    }
}
