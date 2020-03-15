<?php
namespace App\Controller;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class  HomeController extends AbstractController{
    /**
     * @Route("/", name="home.index")
     */
    public function index(PropertyRepository $repository){

        $proprties=$repository->findLastest();

        return $this->render("home/index.html.twig", [
            'properties'=>$proprties
        ]);
    }
}