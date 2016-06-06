<?php

namespace AskerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
		$userId = 1;
        return $this->render('asker/manager-layout.html.twig', array('currentUserId' => $userId) );
    }
}
