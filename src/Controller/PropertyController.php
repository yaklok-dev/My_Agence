<?php
namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PropertyController extends AbstractController{

    private $em;
    /**
     * @var PropertyRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $em, PropertyRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @Route("/biens", name="property.index")
     */
    public function index(): Response
    {

     return $this->render('property/index.html.twig');
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show(Property $property, string $slug){

        if($property->getSlug() !== $slug){
            $this->redirectToRoute('property.show', [
                'id'=>$property->getID(),
                'slug'=>$property->getSlug()
            ],301);
        }

       return $this->render('property/show.html.twig',[
            'property'=>$property,
             'current_menu'=>'property'
        ]);
    }
}