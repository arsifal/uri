<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Link;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

class AnalyticsController extends Controller
{
    /**
     * @Route("/analytics/{url}")
     */
    public function index($url)
    {
        # get initial url from database
        $link = $this->getDoctrine()->getRepository(Link::class)->findOneBy(["output_link" => $url]);
        if (!$link) {
            throw $this->createNotFoundException(
                'Looks like you have incorrect URL: '. $url
            );
        }
        
        # prepare data
        $data = $this->getDoctrine()->getRepository(User::class)->findBy(["link" => $link]);
        if (!$data) {
            $data = [];
        }
        
        # render template with necessary data
        return $this->render('analytics.html.twig', [
            "link" => $link->getInitialLink(),
            "results" => $data
        ]);
    }
    
}
