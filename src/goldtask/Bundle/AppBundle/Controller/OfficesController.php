<?php

namespace goldtask\Bundle\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use goldtask\Bundle\AppBundle\Entity\Offices;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class OfficesController extends Controller
{
		
	public function addOfficeAction(Request $request){
		
		$session = $request->getSession(); // Authentcation User information using Session
		$userid = $session->get('userid');	
		if(!isset($userid) || $userid ==''){
			return $this->redirect($this->generateUrl('login'));
		}
		
		$offices = new Offices();
		$session = $request->getSession(); // Authentcation User information using Session
		$userid = $session->get('userid');
		
        $form = $this->createFormBuilder($offices)
           ->add('name', 'text',array(
				'label' => 'Office name*:'
			))		  
           ->add('officeIpNumber', 'text',array(
				'label' => 'Office IP*:'
			))			
		   ->add('submit', 'submit') 
           ->getForm();
        $form->handleRequest($request);
		if($form->isValid()){      					
			$data = $request->request->all();
			$officeName = trim($data['form']['name']);
			$officeLegalName=$officeName;
			$officeIpNumber=$data['form']['officeIpNumber'];
			$offices->setName("$officeName");
			$offices->setLegalName("$officeLegalName");
            $offices->setOfficeIpNumber("$officeIpNumber");			
			$offices->setCreatedBy("$userid");
			$offices->setCreatedOn(new \DateTime(date('Y-m-d H:i:s')));				
			$offices->setIsActive(1);				
			$em = $this->getDoctrine()->getManager(); 
			$em->persist($offices);	
			$em->flush();		
			
			return $this->redirect($this->generateUrl('officeslist'));
		}		
		return $this->render('goldtaskAppBundle:Offices:add_office.html.twig', array('form' => $form->createView(),'message' => ''));	
	}
	
/**
 *
 *
 *
**/ 

	public function officesListAction(Request $request){	
		
		$session = $request->getSession(); // Authentcation User information using Session
		$userid = $session->get('userid');	
                $user_role_id=$session->get('userroleid');
		if(!isset($userid) || $userid ==''){
			return $this->redirect($this->generateUrl('login'));
		}
		 						
			if($user_role_id!=1){
				return $this->redirect($this->generateUrl('wrong'));
			}
        $offices = new Offices();		
	    $em = $this->getDoctrine()->getManager();					
		$data = $this->getDoctrine()->getRepository('goldtaskAppBundle:Offices')->findBy(array('isActive'=> 1));		
		return $this->render('goldtaskAppBundle:Offices:officeslist.html.twig', array('data' => $data));	
	}
	
/**
 *
 *
 *
**/
	
	public function officeViewAction(Request $request, $id){	
		
		$session = $request->getSession(); // Authentcation User information using Session
		$userid = $session->get('userid');	
		if(!isset($userid) || $userid ==''){
			return $this->redirect($this->generateUrl('login'));
		}
		
        $offices = new Offices();		
	    $em = $this->getDoctrine()->getManager();					
		$data = $this->getDoctrine()->getRepository('goldtaskAppBundle:Offices')->find($id);		
	    return $this->render('goldtaskAppBundle:Offices:officeview.html.twig', array('data' => $data));	
	}
	
/**
 *
 *
 *
**/
	
	public function officeUpdateAction(Request $request, $id){	
		
		$session = $request->getSession(); // Authentcation User information using Session
		$userid = $session->get('userid');	
		if(!isset($userid) || $userid ==''){
			return $this->redirect($this->generateUrl('login'));
		}
		
        $offices = new Offices();		
	    $em = $this->getDoctrine()->getManager();
		$request = Request::createFromGlobals();
		$offficedata = $this->getDoctrine()->getRepository('goldtaskAppBundle:Offices')->find($id);	
		$office = new Offices();
		$form = $this->createFormBuilder($offficedata) 
		 ->add('name', 'text')		
		 ->add('officeIpNumber', 'text')
		 ->add('submit', 'submit') 
		 ->getForm();
		$form->handleRequest($request);
		if ($form->isValid()) {		
			$data = $request->request->all();
			$officeName = trim($data['form']['name']);
			$officeLegalName = $officeName;
			$officeIpNumber = $data['form']['officeIpNumber'];
			
			$offficedata->setName("$officeName");
			$offficedata->setLegalName("$officeLegalName");
            $offficedata->setOfficeIpNumber("$officeIpNumber");			
			$em->flush();
			return $this->redirect($this->generateUrl('officeslist')); 
			exit; 
		}		
	    return $this->render('goldtaskAppBundle:Offices:officeupdate.html.twig',array('form' => $form->createView())); 	
	}
	
	
/**
  *
  *
  *
  *
 **/
	
	public function officeDeleteAction(Request $request, $id){	
		
		$session = $request->getSession(); // Authentcation User information using Session
		$userid = $session->get('userid');	
		if(!isset($userid) || $userid ==''){
			return $this->redirect($this->generateUrl('login'));
		}
		
        $offices = new Offices();		
	    $em = $this->getDoctrine()->getManager();
		$request = Request::createFromGlobals();
		$offficedata = $this->getDoctrine()->getRepository('goldtaskAppBundle:Offices')->find($id);	
		$office = new Offices();
		
		$offficedata->setIsActive(0);								
		$em->flush();
		$data = $this->getDoctrine()->getRepository('goldtaskAppBundle:Offices')->findBy(array('isActive'=> 1));			
		return $this->render('goldtaskAppBundle:Offices:officeslist.html.twig', array('data' => $data)); 	
	}
	
}
