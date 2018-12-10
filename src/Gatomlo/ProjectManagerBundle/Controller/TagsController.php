<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatomlo\ProjectManagerBundle\Entity\Tags;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;




class TagsController extends Controller
{
  public function jsonTagsListAction()
  {
      $em = $this->getDoctrine()->getManager();
      $tags = $em->getRepository('GatomloProjectManagerBundle:Tags')->findAll();

      $list_tags = array();
      foreach ($tags as $tag){
          $obj['id'] = $tag->getId();
          $obj['text'] = $tag->getName();
          array_push($list_tags,$obj);
      }
      return new JsonResponse($list_tags);
  }
}
