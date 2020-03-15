<?php
namespace App\Controller\Admin;
use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController{
    /**
     * @var EntityManagerInterface
     */
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
     * @Route("/admin", name="admin.property.index")
     */
    public function index(){
        $properties=$this->repository->findAll();
        return $this->render('property/admin/index.html.twig', [
            'properties'=>$properties
        ]);
    }


    /**
     *  @Route("/admin/new" ,name="admin.property.new")
     */
    public function new( Request $request){
        $property=new Property();
        $form=$this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $this->em->persist($property);
            $this->em->flush();
            return $this->redirectToRoute('admin.property.index');
        }
        return  $this->render('property/admin/new.html.twig', [
            'property'=>$property,
            'form'=>$form->createView()
        ]);
    }


    /**
     * @Route("/admin/proprety/{id}" ,name="admin.property.edit", methods="GET|POST")
     */
    public function edit(Property $property, Request $request){

        $form=$this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $this->em->flush();
            $this->addFlash("success", 'Bien modifié avec succès');
            return $this->redirectToRoute('admin.property.index' , [
                'form'=>$form->createView()
            ]);
        }
        return  $this->render('property/admin/edit.html.twig', [
            'form'=>$form->createView()
        ]);
    }



    /**
     * @param Property $property
     * @Route("/admin/proprety/{id}" ,name="admin.property.delete", methods="DELETE")
     */
    public function delete(Property $property, Request $request){
        if($this->isCsrfTokenValid('delete'.$property->getId(), $request->get('_token'))){
            $this->em->remove($property);
            $this->em->flush();


        }
        return $this->redirectToRoute("admin.property.index");



    }
}