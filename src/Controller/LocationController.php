<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\Picture;
use App\Form\LocationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LocationController extends AbstractController
{
    /**
     * @Route("/location/new", name="new_location")
     */
    public function new_location(Request $request): Response
    {
        
        $location = new location;
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { 
            $location->setDist(0);
            if($location->getLon()==null){
                $location->setLonLat();
            }
            if($location->getFrench()){
                $location->setPays("France");
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($location);
            $em->flush($location);
            return $this->redirectToRoute('dashboard_index');
        }
        return $this->render('location/new.html.twig', [
            'controller_name' => 'LocationController',
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/location/all", name="all_locations")
     */
    public function all_locations(Request $request): Response
    {
        
        $locationRep = $this->getDoctrine()->getRepository(Location::class);
        $locs=[];
        foreach($locationRep->findAll() as &$loc){
            $locactionsTab['locId']=$loc->getId();
            $locactionsTab['lon']=$loc->getLon();
            $locactionsTab['lat']=$loc->getLat();
            $locactionsTab['made']=$loc->getmade();
            array_push($locs,$locactionsTab);
        }
        $data=['data'=>$locs];
        return new JsonResponse($data);
    }

    /**
     * @Route("/location/view", name="view_loc")
     */
    public function view_loc(Request $request): Response
    {
        $locationRep = $this->getDoctrine()->getRepository(Location::class);
        $loc=$locationRep->findOneBy(array('id'=>$request->request->get('locId')));
        if(!$loc->getMade()){
          return $this->render('location/view_to_do.html.twig', [
                'controller_name' => 'LocationController',
                'location'=>$loc,
            ]);  
        }else{
            $picturesRep = $this->getDoctrine()->getRepository(Picture::class);
            $pics=[];
            foreach($picturesRep->findAll() as &$pic){
                if($loc->getId()==$pic->getLocId()){
                    array_push($pics,$pic);
                }
            }
            return $this->render('location/view_made.html.twig', [
                'controller_name' => 'LocationController',
                'location'=>$loc,
                'pictures'=>$pics
            ]); 
        }
        
    }
    /**
     * @Route("/location/accept", name="accept_loc")
     */
    public function accept_loc(Request $request): Response
    {
        $locationRep = $this->getDoctrine()->getRepository(Location::class);
        $loc=$locationRep->findOneBy(array('id'=>$request->request->get('locId')));
        $loc->setMade(!$loc->getMade());
        $em = $this->getDoctrine()->getManager();
        $em->persist($loc);
        $em->flush($loc);
        $data=['data'=>'success'];
        return new JsonResponse($data);
    }

     /**
     * @Route("/location/{locId}/upload_pic", name="upload_pic")
     */
    public function upload_pic($locId,Request $request): Response
    {
        $locationRep = $this->getDoctrine()->getRepository(Location::class);
        $loc=$locationRep->findOneBy(array('id'=>$locId));
        $files = $request->files->get('image_uploads');
        if($loc!=null){
            foreach($files as&$file){
                if ($file instanceof UploadedFile) {
                    $pic = new picture;
                    $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                    $pic->setPath("photos/".$fileName);
                    $pic->setLocId($loc->getId());
                    $file->move(
                        $this->getParameter('photo_directory'),
                        $fileName
                    );
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($pic);
                    $em->flush($pic);
                }
            }
        }
        
        return $this->redirectToRoute('dashboard_index');
    }

    
     /**
     * @Route("/location/get_picture", name="get_picture")
     */
    public function get_picture(Request $request): Response
    {
        $pictureRep = $this->getDoctrine()->getRepository(Picture::class);
        $pic=$pictureRep->findOneBy(array('id'=>$request->request->get('idPic')));
    
        return $this->render('location/picture_view.html.twig', [
            'picture'=>$pic
        ]); 
    }
}
