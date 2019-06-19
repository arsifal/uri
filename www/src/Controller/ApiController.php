<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Link;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/generate", methods={"POST"}, name="generate")
     */
    public function generate()
    {
        # get parameters
        $request = Request::createFromGlobals();
        $url = $request->request->get("initial_link");
        $expire_date = $request->request->get("expire_date", 0);
        
        # prepare entity manager
        $entityManager = $this->getDoctrine()->getManager();
        
        # prepare link object
        $link = new Link();
        $link->setInitialLink($url);
        $link->setCreateTimestamp(new \DateTime());
        if ($expire_date) {
            $link->setExpireTimestamp(new \DateTime($expire_date));
        }
        $link->setOutputLink("");
        
        # create entry
        $entityManager->persist($link);
        $entityManager->flush();
        
        # update output link
        $link->setOutputLink($link->genUniqueCode());
        
        # update entry
        $entityManager->persist($link);
        $entityManager->flush();        
        
        return new Response($link->getOutputLink());
    }
    
}
