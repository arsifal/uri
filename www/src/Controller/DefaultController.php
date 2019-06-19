<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Link;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

class DefaultController extends Controller
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
        # get initial url from database
        $link = $this->getDoctrine()->getRepository(Link::class)->findOneBy(["output_link" => $url]);
        if (!$link) {
            throw $this->createNotFoundException(
                'Looks like you have incorrect URL: '. $url
            );
        }
        
        $request = Request::createFromGlobals();
            
        # prepare entity manager
        $entityManager = $this->getDoctrine()->getManager();

        # prepare link object
        $user = new User();
        $user->setLink($link);
        $user->setIp($request->getClientIp());
        
        # remember all required data here
        $GeoLiteDatabasePath = $this->get('kernel')->getRootDir() . '/../private/GeoLite2-City.mmdb';
        $reader = new Reader($GeoLiteDatabasePath);
        try {
            $record = $reader->city($user->getIp());
            $user->setCity($record->city->names["en"]);
            $user->setCountry($record->country->names["en"]);
        } catch (AddressNotFoundException $ex) {
            
        }
        $user->setTimestamp(new \DateTime());

        # create entry
        $entityManager->persist($user);
        $entityManager->flush();
        
        # reidrect user to initial url
        return $this->redirect($link->getInitialLink());
    }
    
}
