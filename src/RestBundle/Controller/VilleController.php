<?php

namespace RestBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as Reponse;

class VilleController extends FOSRestController
{

    /**
     * @Get("/villes/{ville}/{action}")
     */
    public function getVilleAction($ville,$action)
    {

        if($action == "meteo")
        {
            $data["meteo"] = $this->creeMeteo($ville);
        }
        elseif($action == "resto")
        {
            $data['resto'] = $this->creeResto($ville);
        }
        elseif($action == "cine")
        {
            $data['cine'] = $this->creeCine($ville);
        }
        else
        {
            $action = "all";
            /**
             * Cas all
             */
            $data["meteo"] = $this->creeMeteo($ville);
            $data['resto'] = $this->creeResto($ville);
            $data['cine'] = $this->creeCine($ville);
        }
         $data["request"] = array("ville" => $ville, "action"=> $action, "date" => new \DateTime('now'));

        $view = $this->view($data, 200)
            ->setTemplate("MyBundle:Villes:getVilles.html.twig")
            ->setTemplateVar('villes')
        ;
        return $this->handleView($view);
    }

    public function creeMeteo($ville)
    {
        $url = "api.openweathermap.org/data/2.5/weather?q=".$ville.",fr&appid=19bb68549e82c17cc5a2acff46bc2999";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $meteo = curl_exec($ch);
        curl_close($ch);
        $meteo = json_decode($meteo, true);
        foreach ($meteo as $cle => $value)
        {
            if($cle == "main")
            {
                foreach ($value as $clee => $valeur) {
                    if($clee == "temp")
                    {
                        $temp =$valeur;
                    }
                }
            }
        }

        $retour = array('temp' => $temp) ;
        return $retour;
    }
    public function creeResto($ville)
    {
        return array("nom" => "test");
    }
    public function creeCine($ville)
    {
        return array("cine" => "app");
    }
    public function redirectAction()
    {
        $view = $this->redirectView($this->generateUrl('some_route'), 301);
        $view = $this->routeRedirectView('some_route', array(), 301);

        return $this->handleView($view);
    }
}
