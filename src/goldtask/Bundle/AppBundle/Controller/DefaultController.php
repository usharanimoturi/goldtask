<?php

namespace goldtask\Bundle\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $session = new Session();
		$session->start();
		$user_session=$session->get('username');
		return $this->render('goldtaskAppBundle:Default:index.html.twig');
    }
	
	public function aboutAction()
    {
		 return $this->render('goldtaskAppBundle:Default:about.html.twig');
    }
	
	public function servicesAction()
    {
		return $this->render('goldtaskAppBundle:Default:services.html.twig');
    }
	
	public function newsAction()
    {
		return $this->render('goldtaskAppBundle:Default:news.html.twig');
    }
	
	public function contactAction()
    {
		return $this->render('goldtaskAppBundle:Default:contact.html.twig');
    }
}
