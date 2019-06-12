<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatomlo\ProjectManagerBundle\Entity\Job;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Gatomlo\ProjectManagerBundle\Form\JobType;

class JobController extends Controller
{
  public function allAction()
  {
    $em = $this->getDoctrine()->getManager();
    $jobs = $em->getRepository('GatomloProjectManagerBundle:Job')->findAll();
    return $this->render('@GatomloProjectManager/Job/jobs.all.html.twig',array('jobs'=>$jobs));
  }
  public function addAction(Request $request)
  {
    $jobs = new Job();
    $form = $this->get('form.factory')->create(JobType::class, $jobs);
    // Si la requête est en POST
     if ($request->isMethod('POST')) {
       $form->handleRequest($request);
       if ($form->isValid()) {
         $em = $this->getDoctrine()->getManager();
         $em->persist($jobs);
         $em->flush();
         return $this->redirectToRoute('gatomlo_project_manager_admin_all_jobs');
       }
     }
    return $this->render('@GatomloProjectManager/Job/jobs.add.html.twig', array(
        'form' => $form->createView(),
        'jobs' => $jobs
      ));
  }
  public function editAction(Request $request,$id)
  {
    $em = $this->getDoctrine()->getManager();
    $jobs = $em->getRepository('GatomloProjectManagerBundle:Job')->find($id);
    $form = $this->get('form.factory')->create(JobType::class, $jobs);
    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em->persist($jobs);
        $em->flush();
        return $this->redirectToRoute('gatomlo_project_manager_admin_all_jobs');
     }}
     return $this->render('@GatomloProjectManager/Job/jobs.add.html.twig', array(
         'form' => $form->createView(),
         'jobs' => $jobs
       ));
  }
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $job = $em->getRepository('GatomloProjectManagerBundle:Job')->find($id);
    $em->remove($job);
    $em->flush();
    return $this->redirectToRoute('gatomlo_project_manager_admin_all_jobs');
  }
}
