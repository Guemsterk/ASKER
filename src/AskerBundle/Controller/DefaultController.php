<?php

namespace AskerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
		$userId = $this->getUser()->getId();
		$securityContext = $this->container->get('security.context');

		if($securityContext->isGranted('ROLE_WS_CREATOR'))
		{
			return $this->render('asker/manager-layout.html.twig', array('currentUserId' => $userId) );
		}
		else if($securityContext->isGranted('ROLE_USER'))
		{
			return $this->render('asker/user-layout.html.twig', array('currentUserId' => $userId) );
		}
    
	}
}
