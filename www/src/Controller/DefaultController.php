<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Link;
class DefaultController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('index.html.twig');
    }
    
    /**
     * @Route("/{url}")
     */
    public function process($url)
    {
        # remember all required data here
        
        # get initial url from database
        $link = $this->getDoctrine()->getRepository(Link::class)->findOneBy(["output_link" => $url]);
        if (!$link) {
            throw $this->createNotFoundException(
                'No product found for id '.$url
            );
        }
        
        # reidrect user to initial url
        $this->redirect($link->getInitialLink());
    }
    
}
