<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Link;
use Symfony\Component\HttpFoundation\Response;

class GenerateController extends AbstractController
{
    /**
     * @Route("/generate/{url}/{expire_date}", methods={"POST"}, name="generate", defaults={"expire_date"="0000-00-00 00:00:00"})
     */
    public function expirable($url, $expire_date)
    {
        # prepare entity manager
        $entityManager = $this->getDoctrine()->getManager();
        
        # prepare link object
        $link = new Link();
        $link->setInitialLink($url);
        $link->setCreateTimestamp(new \DateTime());
        $link->setExpireTimestamp(new \DateTime($expire_date));
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
