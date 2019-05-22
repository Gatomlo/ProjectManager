<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatomlo\ProjectManagerBundle\Entity\Event;
use Gatomlo\ProjectManagerBundle\Entity\Project;
use Gatomlo\ProjectManagerBundle\Entity\Tags;
use Gatomlo\ProjectManagerBundle\Entity\Report;
use Symfony\Component\HttpFoundation\Request;
// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Gatomlo\ProjectManagerBundle\Form\EventType;
use Gatomlo\ProjectManagerBundle\Form\ReportType;


class EventController extends Controller
{
  public function allAction()
  {
      $em = $this->getDoctrine()->getManager();
      $events = $em->getRepository('GatomloProjectManagerBundle:Event')->findAll();
      return $this->render('@GatomloProjectManager/Event/event.all.html.twig',array('events'=>$events));
  }

  public function allForAction(Project $projectId)
  {
      $em = $this->getDoctrine()->getManager();
      $events = $em->getRepository('GatomloProjectManagerBundle:Event')->findBy(array(
        'project'=>$projectId
      ));
      return $this->render('@GatomloProjectManager/Event/event.allFor.html.twig',array('events'=>$events,'project'=>$projectId));
  }
  public function viewAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $event = $em->getRepository('GatomloProjectManagerBundle:Event')->find($id);

      if (null === $event) {
        throw new NotFoundHttpException("L'événement ".$id." n'existe pas.");
      }
      return $this->render('@GatomloProjectManager/Event/event.view.html.twig',array(
        'event'=>$event));
  }
  public function addAction(Request $request, Project $projectId = null )
  {

    $event = new Event();
    if ($projectId == null){
      $fromProject = FALSE;
    }
    else{
      $fromProject = TRUE;
    }

    $form = $this->get('form.factory')->create(EventType::class, $event, array(
      'project'=>$projectId
    ));

    // Si la requête est en POST
   if ($request->isMethod('POST')) {
     // On fait le lien Requête <-> Formulaire
     // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
     $form->handleRequest($request);

     // On vérifie que les valeurs entrées sont correctes
     // (Nous verrons la validation des objets en détail dans le prochain chapitre)
     if ($form->isValid()) {
       // On enregistre notre objet $advert dans la base de données, par exemple
       $em = $this->getDoctrine()->getManager();
        $tagsArray = $form['tagsArray']->getData();
        $tags = explode(",",$tagsArray);
        foreach ($tags as $tag) {
          $existingTag = $em->getRepository('GatomloProjectManagerBundle:Tags')->findOneBy(array(
            'name'=> $tag
          ));

          if (empty($existingTag)){
            $newTag = new Tags();
            $newTag->setName($tag);
            $event->addTag($newTag);
          }

          else {
            $event->addTag($existingTag);
          }
        }
       $em->persist($event);
       $em->flush();

       $request->getSession()->getFlashBag()->add('notice', 'Evénement bien enregistré.');

       if($fromProject){
          return $this->redirectToRoute('gatomlo_project_manager_all_events_from_a_project', array('projectId' => $event->getProject()->getId()));
       }
       else{
          return $this->redirectToRoute('gatomlo_project_manager_all_events');
       }

     }
   }


    // On passe la méthode createView() du formulaire à la vue
    // afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('@GatomloProjectManager/Event/event.add.html.twig', array(
      'form' => $form->createView(),
      'event'=>$event
    ));
  }

  public function editAction(Request $request, $id)
  {

    $em = $this->getDoctrine()->getManager();
    $event = $em->getRepository('GatomloProjectManagerBundle:Event')->find($id);
    $project = $event->getProject();

    //Récupération des tags
    $existingTags = $event->getTags();
    //Création d'un tableau vide
    $existingTagsArray = [];
    // Pour chaque tag, on récupére le nom et on l'insère dans le tableau vide.
    foreach ($existingTags as $tag) {
      $currentTag = $tag->getName();
      array_push($existingTagsArray, $currentTag);
    };
    // On transforme le tableau en string pour pouvoir être inséré dans le champ texte selectize
    $existingTagsStringFormat = implode(',',$existingTagsArray);


    $form = $this->get('form.factory')->create(EventType::class, $event, array(
      'existingTags'=>$existingTagsStringFormat,
      'project'=>$project));

    // Si la requête est en POST
   if ($request->isMethod('POST')) {
     // On fait le lien Requête <-> Formulaire
     // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
     $form->handleRequest($request);

     // On vérifie que les valeurs entrées sont correctes
     // (Nous verrons la validation des objets en détail dans le prochain chapitre)
     if ($form->isValid()) {

       foreach ($existingTags as $tag) {
         $event->removeTag($tag);
       };
       // On enregistre notre objet $advert dans la base de données, par exemple
       $em = $this->getDoctrine()->getManager();
        // On enregistre notre objet $advert dans la base de données, par exemple
        $tagsArray = $form['tagsArray']->getData();
        $tags = explode(",",$tagsArray);
        foreach ($tags as $tag) {
          $existingTag = $em->getRepository('GatomloProjectManagerBundle:Tags')->findOneBy(array(
            'name'=> $tag
          ));

          if (empty($existingTag)){
            $newTag = new Tags();
            $newTag->setName($tag);
            $event->addTag($newTag);
          }

          else {
            $event->addTag($existingTag);
          }
        }
       $em->persist($event);
       $em->flush();

       $request->getSession()->getFlashBag()->add('notice', 'Evénement bien enregistré.');

       // On redirige vers la page de visualisation de l'annonce nouvellement créée
       return $this->redirectToRoute('gatomlo_project_manager_one_event', array('id' => $event->getId()));
     }
   }
    return $this->render('@GatomloProjectManager/Event/event.add.html.twig', array(
      'form' => $form->createView(),
      'event'=> $event,
    ));
  }

  public function deleteAction($id,$from)
  {
      $em = $this->getDoctrine()->getManager();
      $event = $em->getRepository('GatomloProjectManagerBundle:Event')->find($id);
      $project = $em->getRepository('GatomloProjectManagerBundle:Event')->find($event->getProject())->getId();
      $em->remove($event);
      $em->flush();

      if($from == 'events'){
        return $this->redirectToRoute('gatomlo_project_manager_all_events');
      }
      else{
        return $this->redirectToRoute('gatomlo_project_manager_all_events_from_a_project',array('projectId'=>$project));
      }

  }
  public function allReportAction()
  {
    $em = $this->getDoctrine()->getManager();
    $reports = $em->getRepository('GatomloProjectManagerBundle:Report')->findAll();
    return $this->render('@GatomloProjectManager/Report/report.all.html.twig',array('reports'=>$reports));
  }

  public function addReportAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $report = new Report();
    $form = $this->get('form.factory')->create(ReportType::class, $report,array());

    // Si la requête est en POST
   if ($request->isMethod('POST')) {
     // On fait le lien Requête <-> Formulaire
     // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
     $form->handleRequest($request);

     // On vérifie que les valeurs entrées sont correctes
     // (Nous verrons la validation des objets en détail dans le prochain chapitre)
     if ($form->isValid()) {
       // On enregistre notre objet $advert dans la base de données, par exemple
       $em = $this->getDoctrine()->getManager();
       $tagsArray = $form['tagsArray']->getData();
       $tags = explode(",",$tagsArray);
       foreach ($tags as $tag) {
         $existingTag = $em->getRepository('GatomloProjectManagerBundle:Tags')->findOneBy(array(
           'name'=> $tag
         ));
         $report->addTag($existingTag);
       }

       $em->persist($report);
       $em->flush();
     }
     return $this->redirectToRoute('gatomlo_project_manager_events_view_report',array('reportId'=>$report->getId()));

   }

    return $this->render('@GatomloProjectManager/Report/report.add.html.twig', array(
      'form' => $form->createView()));
  }

  public function reportCritersAction($reportId)
  {
    $em = $this->getDoctrine()->getManager();
    $report = $em->getRepository('GatomloProjectManagerBundle:Report')->find($reportId);
    return $this->render('@GatomloProjectManager/Report/report.criters.html.twig',array('report'=>$report));
  }

  public function viewReportAction($reportId)
  {   $params = array();
      $em = $this->getDoctrine()->getManager();
      $report = $em->getRepository('GatomloProjectManagerBundle:Report')->find($reportId);

      if($report->getType()!=NULL){
        $params['type'] = $report->getType();
      }
      if(count($report->getTags())>0){
        $params['tags'] = $report->getTags();
      }
      if($report->getProject()!=NULL){
        $params['project'] = $report->getProject();
      }
      if($report->getIntervenant()!=NULL){
        $params['user'] = $report->getIntervenant();
      }
      if($report->getStartDate()!=NULL){
        $params['startDate'] = $report->getStartDate();
      }
      else{
        $params['startDate'] = '2000-01-01';
      }
      if($report->getEndDate()!=NULL){
        $params['endDate'] = $report->getEndDate();
      }
      else{
        $params['endDate'] = date("Y-m-d");
      }

      $events = $em->getRepository('GatomloProjectManagerBundle:Event')->getReport($params);/*test with 'type'=>1,'tags'=>14, 'project'=>18 */
      return $this->render('@GatomloProjectManager/Report/report.view.html.twig',array('events'=>$events,'report'=>$report));
  }

  public function deleteReportAction($reportId)
  {
      $em = $this->getDoctrine()->getManager();
      $report = $em->getRepository('GatomloProjectManagerBundle:Report')->find($reportId);
      $em->remove($report);
      $em->flush();

      return $this->redirectToRoute('gatomlo_project_manager_events_all_reports');

  }
  public function printReportAction($reportId)
  {

     $now = (new \DateTime("now"))->format('d/m/Y H:m');
     $params = array();
        $em = $this->getDoctrine()->getManager();
        $report = $em->getRepository('GatomloProjectManagerBundle:Report')->find($reportId);

        if($report->getType()!=NULL){
          $params['type'] = $report->getType();
        }
        if(count($report->getTags())>0){
          $params['tags'] = $report->getTags();
        }
        if($report->getProject()!=NULL){
          $params['project'] = $report->getProject();
        }
        if($report->getIntervenant()!=NULL){
          $params['user'] = $report->getIntervenant();
        }
        if($report->getStartDate()!=NULL){
          $params['startDate'] = $report->getStartDate();
        }
        else{
          $params['startDate'] = '2000-01-01';
        }
        if($report->getEndDate()!=NULL){
          $params['endDate'] = $report->getEndDate();
        }
        else{
          $params['endDate'] = date("Y-m-d");
        }

        $events = $em->getRepository('GatomloProjectManagerBundle:Event')->getReport($params);
        $html = $this->renderView('@GatomloProjectManager/Report/print.report.html.twig',array('events'=>$events,'report'=>$report,'now'=>$now));

    // Configure Dompdf according to your needs
      $pdfOptions = new Options();
      $pdfOptions->set('defaultFont', 'Arial');
      $pdfOptions->set('isRemoteEnabled', TRUE);

      // Instantiate Dompdf with our options
      $dompdf = new Dompdf($pdfOptions);

      // Retrieve the HTML generated in our twig file
      $html = $html;

      // Load HTML to Dompdf
      $dompdf->loadHtml($html);

      // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
      $dompdf->setPaper('A4', 'portrait');

      // Render the HTML as PDF
      $dompdf->render();

      $font = $dompdf->getFontMetrics()->get_font("helvetica");
      $dompdf->getCanvas()->page_text(500, 785, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));
      $dompdf->stream("Rapport_".$now.".pdf", array("Attachment" => false));
  }

}
