<?php

namespace RestBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Serializer\Encoder\JsonDecode;

class openWheatherController extends FOSRestController
{
    public function getMeteoAction($ville)
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
        $data = array($ville => array("temp" => $temp));
        $view = $this->view($data, 200)
            ->setTemplate("AppBundle:Meteo:getMeteo.html.twig")
            ->setTemplateVar('meteos')
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
