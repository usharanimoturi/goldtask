<?php

namespace goldtask\Bundle\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use goldtask\Bundle\AppBundle\Entity\clockindetails;
use goldtask\Bundle\AppBundle\Entity\TrackingDetails;
use goldtask\Bundle\AppBundle\Entity\Offices;
use goldtask\Bundle\AppBundle\Entity\customers;
use goldtask\Bundle\AppBundle\Entity\useridgrams;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class ClockinController extends Controller
{
	
	public function clockinlistAction(Request $request){	
		
		$session = $request->getSession(); // Authentcation User information using Session
		$userid = $session->get('userid');	
        $user_role_id=$session->get('userroleid');
		$officesId=1;//$session->get('offices_id');
		if(!isset($userid) || $userid ==''){
			return $this->redirect($this->generateUrl('login'));
		}
		        		
	    $em = $this->getDoctrine()->getManager();
		
		$today= date('Y-m-d');
		if($user_role_id==4 || $user_role_id==5){
		$user_sql = " and u.id=$userid ";
		}else
		{
			$user_sql ='';
		}
		$clockin_query = "SELECT u.id,CONCAT(UCASE(LEFT(u.first_name, 1)),SUBSTRING(u.first_name, 2)) as first_name,CONCAT(UCASE(LEFT(u.last_name, 1)),SUBSTRING(u.last_name, 2)) as last_name,o.legal_name,date_format(c.start_date,'%Y-%m-%d') as start_date,c.is_status,c.weight from tracking_details as c left join user as u on u.id=c.user_id left join offices_users as of on of.user_id =c.user_id left join offices as o on o.id=of.offices_id where  date_format(start_date,'%Y-%m-%d')='$today'".$user_sql;		
		
		$clockin_conn = $em->getConnection()->prepare($clockin_query);
		$clockin_conn->execute();
		$clockin_info = $clockin_conn->fetchAll();
		
		if($user_role_id==1 || $user_role_id==2 || $user_role_id==3){		
		return $this->render('goldtaskAppBundle:Clockin:clockinlist.html.twig', array('data' => $clockin_info,'user_role_id'=>$user_role_id));	
		}
		if($user_role_id==4 || $user_role_id==5){		
		return $this->render('goldtaskAppBundle:Clockin:clockinlist.html.twig', array('data' => $clockin_info,'user_role_id'=>$user_role_id));	
		}
	}
	
	
	public function clockinAction(Request $request){
		
		$session = $request->getSession(); // Authentcation User information using Session
		$userid = $session->get('userid');
		$offices_id =1;// $session->get('offices_id');
		
		if(!isset($userid) || $userid ==''){
			return $this->redirect($this->generateUrl('login'));
		}
		$em = $this->getDoctrine()->getManager();
	//	$ClockinDetails = new clockindetails(); 
		$ClockinDetails = new TrackingDetails();// ClockinDetails class
		$enddate=null;
		$nowtime = time();	
							
		$Session_ids=md5($userid).md5($nowtime);					   
		$ClockinDetails->setUserId($userid);                    
		$ClockinDetails->setOfficesId($offices_id);
		$ClockinDetails->setStartDate(new \DateTime(date('Y-m-d H:i:s')));
		$ClockinDetails->setEndDate(new \DateTime(date('Y-m-d H:i:s')));                    
		$ClockinDetails->setSessionId($Session_ids);
		$ClockinDetails->setWeight(0);
		$ClockinDetails->setIsStatus(1);               
		$ClockinDetails->setCreatedBy($userid);
		$ClockinDetails->setCreatedOn(new \DateTime(date('Y-m-d H:i:s')));
		$ClockinDetails->setUpdatedBy($userid);
		$ClockinDetails->setUpdatedOn(new \DateTime(date('Y-m-d H:i:s')));
		$em->persist($ClockinDetails);
		$em->flush();
		
		return $this->redirect($this->generateUrl('customer'));	
			
	}
	
	
	public function customerAction(Request $request){	
	
		$session = $request->getSession(); // Authentcation User information using Session
		$userid = $session->get('userid');
		$offices_id =1;// $session->get('offices_id');
		
		if(!isset($userid) || $userid ==''){
			return $this->redirect($this->generateUrl('login'));
		}
		$customer = new customers();		
		
        $form = $this->createFormBuilder($customer)
           ->add('customer_name', 'text',array(
				'label' => 'Customer name*:'
			))		  
           ->add('weight_grams', 'text',array(
				'label' => 'Weight (in gms)*:'
			))			
		   ->add('submit', 'submit') 
           ->getForm();
        $form->handleRequest($request);
		if($form->isValid()){      					
			$data = $request->request->all();
			$customer_name = trim($data['form']['customer_name']);			
			$weight_grams=$data['form']['weight_grams'];
			$customer->setCustomerName("$customer_name");			
            $customer->setWeightGrams("$weight_grams");
			$customer->setUserid("$userid");			
			$customer->setCreatedBy("$userid");
			$customer->setCreatedOn(new \DateTime(date('Y-m-d H:i:s')));			
							
			$em = $this->getDoctrine()->getManager(); 
			$em->persist($customer);	
			$em->flush();
			$today = date('Y-m-d');
			$track_start_sqls = "select weight from tracking_details where date_format(`start_date`,'%Y-%m-%d')='$today' and `user_id`=$userid";
			$track_start_conn = $em->getConnection()->prepare($track_start_sqls);
			$track_start_conn->execute();
			$track_start_info = $track_start_conn->fetchAll();
			
			
				if(count($track_start_info)>0){		
				$weight =$track_start_info[0]['weight'];			//echo "<br>";
				$weight =$weight + $weight_grams; //exit;
				$sqltrack = "update `tracking_details` set `weight`='$weight' where date_format(`start_date`,'%Y-%m-%d')='$today' and `user_id`=$userid";
							$sqltrackss= $em->getConnection()->prepare($sqltrack);
				$sqltrackss->execute();			
				}
			}
		return $this->render('goldtaskAppBundle:Clockin:add_customer.html.twig', array('form' => $form->createView(),'message' => ''));		
	}

	public function clockoutlistAction(Request $request){
		
		$session = $request->getSession(); // Authentcation User information using Session
		$userid = $session->get('userid');
		$offices_id =1;// $session->get('offices_id');
		
		if(!isset($userid) || $userid ==''){
			return $this->redirect($this->generateUrl('login'));
		}
		$em = $this->getDoctrine()->getManager();
		$ClockinDetails = new TrackingDetails(); // ClockinDetails class
		$enddate=null;
		$nowtime = time();	
		$today = date('Y-m-d');
		$track_start_sqls = "select start_date from tracking_details where date_format(`start_date`,'%Y-%m-%d')='$today' and `user_id`=$userid and `offices_id`=$offices_id";
		$track_start_conn = $em->getConnection()->prepare($track_start_sqls);
		$track_start_conn->execute();
		$track_start_info = $track_start_conn->fetchAll();
				
			if(count($track_start_info)>0){		
			$from_time =strtotime($track_start_info[0]['start_date']);			
		 	$dates = strtotime(date('Y-m-d H:i:s'));  
			$difftime = $from_time-$dates;
			$minuteDiff = round(abs($difftime)/60,2);
			
			$track_enddate = date('Y-m-d H:i:s');
			$sqltrack = "update `tracking_details` set `is_status`='0',`end_date`='$track_enddate' , time_diff='$minuteDiff'  where date_format(`start_date`,'%Y-%m-%d')='$today' and `user_id`=$userid and `offices_id`=$offices_id";
                        $sqltrackss= $em->getConnection()->prepare($sqltrack);
			$sqltrackss->execute();			
			}
		return $this->redirect($this->generateUrl('clockinlist'));	
			
	}
	
	public function sample_code_get_jsonAction(Request $request){
		
		// define the SOAP client using the url for the service
	$client = new soapclient('http://globalmetals.xignite.com/xGlobalMetals.asmx?WSDL');

	// create an array of parameters 
	$param = array(
	);

	// add authentication info
	$xignite_header = new SoapHeader('http://www.xignite.com/services/',
		 "Header", array("Username" => "5E7B30B762CD4E0B9F317540D6E44427"));
	$client->__setSoapHeaders(array($xignite_header));

	// call the service, passing the parameters and the name of the operation 
	$result = $client->ListMetals($param);
	// assess the results 
	if (is_soap_fault($result)) {
	//echo '<h2>Fault</h2><pre>';
		 //print_r($result);
		// echo '</pre>';
	} else {
		// echo '<h2>Result</h2><pre>';
		 print_r($result);
		// echo '</pre>';
	}
	// print the SOAP request 
	//echo '<h2>Request</h2><pre>' . htmlspecialchars($client->__getLastRequest(), ENT_QUOTES) . '</pre>';
	// print the SOAP request Headers 
	//echo '<h2>Request Headers</h2><pre>' . htmlspecialchars($client->__getLastRequestHeaders(), ENT_QUOTES) . '</pre>';
	// print the SOAP response 
	//echo '<h2>Response</h2><pre>' . htmlspecialchars($client->__getLastResponse(), ENT_QUOTES) . '</pre>';
	return true;
	}
}