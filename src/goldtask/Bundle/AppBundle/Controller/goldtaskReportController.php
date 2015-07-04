<?php

namespace goldtask\Bundle\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

use goldtask\Bundle\AppBundle\Entity\clockindetails;
use goldtask\Bundle\AppBundle\Entity\goldtaskTrasaction;
use goldtask\Bundle\AppBundle\Entity\goldtaskTransactionDetails;
use goldtask\Bundle\AppBundle\Entity\PhoneStatus;


class goldtaskReportController extends Controller
{
	var $adminCondition;
        var $redirectCondition;
	public function goldtaskReportAction(Request $request){
		
		$session = $request->getSession();                 
		$user_id=$session->get('userid');
		$currentRoute = $request->attributes->get('_route');
		$m = $session->get('officesId');
                $adminRedirection="";
                $from_date = $request->request->get('fdate')=='' ? $session->get('filfdate') : $request->request->get('fdate');
		$to_date = $request->request->get('tdate')=='' ? $session->get('filtdate') : $request->request->get('tdate');
                $date_range = "";
                $date_rangeun = "";
                $date_range_other = "";
                if($from_date != '' && $to_date !='') {
                    $divides_date = explode("/", $from_date);
                    $date_from = $divides_date['2'] . "-" . $divides_date['0'] . "-" . $divides_date['1'];
                    $divides_date1 = explode("/", $to_date);
                    $date_to = $divides_date1['2'] . "-" . $divides_date1['0'] . "-" . $divides_date1['1'];
                    $date_range = " (B.last_visit_date between '".$date_from."' and '".$date_to."')"; 
                    
                }
                else if($from_date != '' && $to_date ==''){
                    $divides_date = explode("/", $from_date);
                    $date_from = $divides_date['2'] . "-" . $divides_date['0'] . "-" . $divides_date['1'];                    
                    $date_range = " (B.last_visit_date >= '".$date_from."')"; 
                    
                }
                else if($from_date == '' && $to_date !=''){
                    $divides_date1 = explode("/", $to_date);
                    $date_to = $divides_date1['2'] . "-" . $divides_date1['0'] . "-" . $divides_date1['1'];                  
                    $date_range = " (B.last_visit_date <= '".$date_to."')"; 
                    
                }
		else
		{
                    $date_range_other = " A.reschedule_date<=date_format(now(),'%Y-%m-%d')";
                    $date_rangeun = "";
		}
                
                $balance='';
               $balancefrom = $request->request->get('balancefrom')=='' ? $session->get('filbalancefrom') : $request->request->get('balancefrom');
               $balanceto = $request->request->get('balanceto')=='' ? $session->get('filbalanceto') : $request->request->get('balanceto');
                if($balancefrom != '' && $balanceto !='') {
           
                       $balance = " AND B.maxcovperson between ".$balancefrom." and ".$balanceto;                        
                }else if($balancefrom != '' && $balanceto =='') {
                               $balance = " AND B.maxcovperson >= ".$balancefrom;                        
                }else if($balancefrom == '' && $balanceto !='') {
                               $balance = " AND B.maxcovperson <= ".$balanceto;                        
                }else{
                    $balance='';
                }
                
                $calltypeqry='';
               $calltype = $request->request->get('calltype')=='' ? $session->get('filcalltype') : $request->request->get('calltype');               
                if($calltype != '' && $calltype==1) {
           
                       $calltypeqry = " AND A.missed_appointment in(1,2)";                        
                }else if($calltype != '' && $calltype==2) {
                               $calltypeqry = " AND A.outstanding_treatment in(1,2)";                        
                }else if($calltype != '' && $calltype==3) {
                               $calltypeqry = " AND A.outstanding_balance in(1,2)";                        
                }else{
                    $calltypeqry='';
                }
                
                $officetypeqry='';
               $officetype = $request->request->get('officetype')=='' ? $session->get('filofficetype') : $request->request->get('officetype');               
                if($officetype != '') {
           
                       $officetypeqry = " AND A.offices_id=$officetype";                        
                }else{
                    $officetypeqry='';
                }
                
                $insurancetypeqry='';
               $insurancetype = $request->request->get('insurancetype')=='' ? $session->get('filinsurancetype') : $request->request->get('insurancetype');               
                if($insurancetype != '') {
           
                      $insurancetypeqry = " AND B.primary_insurance_carrier_name='$insurancetype'";                        
                }else{
                    $insurancetypeqry='';
                }
               
                $session->remove('filfdate');
                $session->remove('filtdate');
                $session->remove('filbalancefrom');
                $session->remove('filbalanceto');
                $session->remove('filcalltype');
                $session->remove('filofficetype');
                $session->remove('filinsurancetype');
                
	    if(empty($m))
	    {
	    	$officesId = $session->get('officesId');
	    }
	    else
	    {
	    	$officesId = 1;
	    } 
	    $officesId = 1;
		if(!isset($user_id) || $user_id =='')
		{
			return $this->redirect($this->generateUrl('login'));
		}
		$user_role_id=$session->get('userroleid');	
		$user_parent=$session->get('userParent');
		if($user_parent==1)
		{
			$userType="parent";			
		}
		if($user_parent=='' || $user_parent==0)
		{
			$userType="user";	
			$user_parent=0;			
		}
		
		if($user_role_id!=1 && $user_parent!=0){
			$where="
				WHERE 
					a.parent_role_id=$user_id or a.id=$user_id 					
";
  
		}
		
		if($user_role_id!=1 && $user_parent==0){
			
			$where="
				WHERE 
					b.assigned_to=$user_id 					
					
";
		}
		$adminwhere = "";
                $userroleswhere="";
		if($user_role_id==1){
			$adminRedirection = $this->redirectCondition;
			//$where=" WHERE a.is_parent=1 ";
                    $where=" WHERE a.id=1 ";
			$adminwhere = " and ".$this->adminCondition;
                        $userroleswhere = " or ".str_replace("c.","a.",$this->adminCondition);                        
                        
		}		
		$em             = $this->getDoctrine()->getEntityManager();
		$connection     = $em->getConnection();
		
		  $newsql = "SELECT 
                    B.offices_id as officeid,
                    D.legal_name,
                    A.call_status,
                    B.patient_id as patient_id,
                    concat(B.last_name, ' ', B.first_name) as patname,
                    A.schedule_date as schedule_date,
                    if(A.assigned_to=0,'N/A',concat(c.first_name, ' ', c.last_name)) as assigned_to,                    
                    A.missed_appointment,
                    A.outstanding_treatment,
                    A.outstanding_balance,
                    B.first_name,
                    B.last_name,
                    date_format(B.first_visit_date, '%m/%d/%Y') as first_visit_date,
                    date_format(B.last_visit_date, '%m/%d/%Y') as last_visit_date,
                    if(B.last_missed_appointment='0000-00-00','N/A',date_format(B.last_missed_appointment, '%m/%d/%Y')) as last_missed_appointment,
                    B.primary_insurance_carrier_name,
                    B.maxcovperson,
                    B.guard_first_name,
                    B.guard_last_name,
                    concat(B.guard_last_name, ' ', B.guard_first_name) as gurname,
                    B.medicalAlert,
                    B.guar_id as patient_guid,
                    A.udate as updated_on,
                    B.medicalAlert as descript,
                    B.familycount as FamilyCNT,
                    B.familylist as groupname,
                    B.privacyalert_type as privacynote,
                    B.privacyalert_id,
                    A.id,
                    A.assigned_to,
                    B.referral_count,
                    B.referral_list,
                    B.employer

                    FROM 
                    goldtask_trasaction AS A
                    INNER JOIN patient_info AS B ON (A.offices_id=B.offices_id AND A.pat_id=B.patient_id)
                    inner join  offices D on (A.offices_id = D.id)
                    left join  user c on (c.id = A.assigned_to)

                    WHERE $date_range $date_range_other $balance AND A.freeze=0 $calltypeqry $officetypeqry  order by A.reschedule_date desc"; //$insurancetypeqry 
		//$where   = " and (b.assigned_to !=";
                	//echo $newsql;exit;					 
		$statement      = $connection->prepare($newsql." LIMIT 250");
		$statement->execute();
		$results        = $statement->fetchAll();
		$finalResult    = $results;
		$count    = count($results);
                
             /*   $assign_user_sql = "SELECT id,assigned_to,offices_id,pat_id,concat(missed_appointment,outstanding_treatment,outstanding_balance) as as_maotob FROM goldtask_trasaction where assigned_to=$user_id and freeze=0 and reschedule_date<=date_format(now(),'%Y-%m-%d') LIMIT 1";
                $assign_user_statement      = $connection->prepare($assign_user_sql);
		$assign_user_statement->execute();
		$assign_user_info        = $assign_user_statement->fetchAll();
                $assign_user = array();
                if(count($assign_user_info) > 0) {                    
                    $assign_user = $assign_user_info;
                } else {
                    $assign_user[]=array('id'=>0,'assigned_to'=>0,'pat_id'=>0,'as_maotob'=>'000','offices_id'=>0);
                }   
                
                */
				$em = $this->getDoctrine()->getManager();			
                        $office_user_query = "SELECT id,CONCAT(UCASE(LEFT(legal_name, 1)),SUBSTRING(legal_name, 2)) as name from offices order by name";			                        
                        $office_user_conn = $em->getConnection()->prepare($office_user_query);
                        $office_user_conn->execute();
                        $office_names_info = $office_user_conn->fetchAll();
                        
                        
                     /*   $insurance_query = "SELECT distinct gi.primary_insurance_carrier_name as in_name
                                            FROM goldtask_trasaction as it
                                            inner join goldtask.imp_sp_getallpatientsinsuranceinfo as gi on it.pat_id=gi.patient_id
                                            where gi.primary_insurance_carrier_name!='' AND gi.primary_insurance_carrier_name is not null AND (it.missed_appointment=1 or it.outstanding_balance=1 or it.outstanding_treatment=1) order by gi.primary_insurance_carrier_name";
                        $insurance_conn = $em->getConnection()->prepare($insurance_query);
                        $insurance_conn->execute();
                        $insurance_info = $insurance_conn->fetchAll();  */                     
                
                //print_r($assign_user);exit;
				if($user_role_id==2 || $user_role_id==3){
					//return $this->render('goldtaskAppBundle:goldtaskreport:goldtaskReport.html.twig', array('assign_user'=>$assign_user,'userType'=>$userType,'user_parent'=>$user_parent,'user_role_id'=>$user_role_id,'userid'=>$user_id, "results" => $finalResult, 'count'=> $count, 'currentRoute'=>$currentRoute,'adminRedirection'=>$adminRedirection,'fdate' => $from_date,'tdate' => $to_date,'balancefrom'=>$balancefrom ,'balanceto'=>$balanceto,'calltype'=>$calltype,'office_names_info'=>$office_names_info,'insurance_info'=>$insurance_info,'officetype'=>$officetype,'insurancetype'=>$insurancetype));
					return $this->render('goldtaskAppBundle:goldtaskreport:goldtaskReport.html.twig', array('userType'=>$userType,'user_parent'=>$user_parent,'user_role_id'=>$user_role_id,'userid'=>$user_id, "results" => $finalResult, 'count'=> $count, 'currentRoute'=>$currentRoute,'adminRedirection'=>$adminRedirection,'fdate' => $from_date,'tdate' => $to_date,'balancefrom'=>$balancefrom ,'balanceto'=>$balanceto,'calltype'=>$calltype,'insurance_info'=>'','office_names_info'=>$office_names_info,'officetype'=>$officetype,'insurancetype'=>$insurancetype));
					/*$office_names_info='';
					$insurance_info='';
					$assign_user='';
					$finalResult='';
					return $this->render('goldtaskAppBundle:goldtaskreport:goldtaskReport.html.twig', array('assign_user'=>$assign_user,'userType'=>$userType,'user_parent'=>$user_parent,'user_role_id'=>$user_role_id,'userid'=>$user_id,"results" => $finalResult 'currentRoute'=>$currentRoute,'adminRedirection'=>$adminRedirection,'fdate' => $from_date,'tdate' => $to_date,'balancefrom'=>$balancefrom ,'balanceto'=>$balanceto,'calltype'=>$calltype,'office_names_info'=>$office_names_info,'insurance_info'=>$insurance_info,'officetype'=>$officetype,'insurancetype'=>$insurancetype));*/
				}
				if($user_role_id==4 || $user_role_id==5){
					//return $this->render('goldtaskAppBundle:goldtaskreport:goldtaskUserReport.html.twig', array('assign_user'=>$assign_user,'userType'=>$userType,'user_parent'=>$user_parent,'user_role_id'=>$user_role_id,'userid'=>$user_id, "results" => $finalResult, 'count'=> $count, 'currentRoute'=>$currentRoute,'adminRedirection'=>$adminRedirection));
					
					return $this->render('goldtaskAppBundle:goldtaskreport:goldtaskUserReport.html.twig', array('userType'=>$userType,'user_parent'=>$user_parent,'user_role_id'=>$user_role_id,'userid'=>$user_id, 'currentRoute'=>$currentRoute,'adminRedirection'=>$adminRedirection));
				}
		
	}
	
/**
 *
 *
**/
	public function goldtaskAdminStaffAction(Request $request)
	{
            $session = new Session();
			$session->start();
			
			//User Roles ids						   
			$user_role_id=$session->get('userroleid'); 			
			
			if($user_role_id!=1){
				return $this->redirect($this->generateUrl('wrong'));
			}
		$this->adminCondition = '(c.user_role_id = 4 or c.user_role_id = 3) ';
                $this->redirectCondition = 'staff';
		$a =$this->goldtaskReportAction($request);
		return $a;
	}
/**
 *
 *
**/
	public function goldtaskAdminCallCenterAction(Request $request)
	{
            $session = new Session();
			$session->start();
			
			//User Roles ids						   
			$user_role_id=$session->get('userroleid'); 			
			
			if($user_role_id!=1){
				return $this->redirect($this->generateUrl('wrong'));
			}
		$this->adminCondition = '(c.user_role_id = 5 or c.user_role_id = 2) ';
                $this->redirectCondition = 'callcenter';
		$a =$this->goldtaskReportAction($request);
		return $a;
	}
	
	public function goldtaskassignUserAction(Request $request)
	{     
		$session = $request->getSession();                 
		$userid=$session->get('userid');
		$currentRoute = $request->attributes->get('_route');
		$officesId =1; //$session->get('officesId');		
		$adminRedirection   = $request->get('adminRedirection');
        $user_role_id 		= $request->get('user_role_id');
                $fillarr = array($request->get('filfdate'),$request->get('filtdate'),$request->get('filbalancefrom'),$request->get('filbalanceto'),$request->get('filofficetype'),$request->get('filinsurancetype'),$request->get('filcalltype'));
                    $this->trackingdetails($userid,$adminRedirection,$officesId,$currentRoute,$user_role_id);
                exit;
        
	}
/**
 * Tracking Details Insert
 *
**/
	public function trackingdetails($userid,$adminRedirection,$officesId,$currentRoute,$user_role_id)
	{				
		
		$em = $this->getDoctrine()->getEntityManager();
		$ClockinDetails = new ClockinDetails(); // ClockinDetails class
		$enddate=null;
		$nowtime = time();		
		//$session = $request->getSession();
		//$userid =$session->get('userid');						
		$Session_ids=md5($userid).md5($nowtime);					   
		$ClockinDetails->setUserid($userid);                    
		$ClockinDetails->setOfficesId($officesId);
		$ClockinDetails->setStartDate(new \DateTime(date('Y-m-d H:i:s')));
		$ClockinDetails->setEndDate(new \DateTime(date('Y-m-d H:i:s')));                    
		$ClockinDetails->setSessionIds($Session_ids);
		$ClockinDetails->setIsStatus(1);               
		$ClockinDetails->setCreatedBy($userid);
		$ClockinDetails->setCreatedOn(new \DateTime(date('Y-m-d H:i:s')));
		$ClockinDetails->setUpdatedBy($userid);
		$ClockinDetails->setUpdatedOn(new \DateTime(date('Y-m-d H:i:s')));
		$em->persist($ClockinDetails);
		$em->flush();
		
        /*$session = $request->getSession(); // Authentication User information using Session
        $userid = $session->get('userid');
        $user_role_id=$session->get('userroleid');
		$currentRoute = $request->attributes->get('_route');
		$adminRedirection   = $request->get('adminRedirection');*/
        if (!isset($userid) || $userid == '') {
            return $this->redirect($this->generateUrl('login'));
        }
               
        $em = $this->getDoctrine()->getManager();
		$today= date('Y-m-d');
		$clockin_query = "SELECT u.id,CONCAT(UCASE(LEFT(u.first_name, 1)),SUBSTRING(u.first_name, 2)) as first_name,CONCAT(UCASE(LEFT(u.last_name, 1)),SUBSTRING(u.last_name, 2)) as last_name,o.legal_name,c.start_date,c.is_status from clockindetails as c left join user as u on u.id=c.userid left join offices_users as of on of.user_id =c.userid left join offices as o on o.id=of.offices_id where u.id=$userid and date_format(start_date,'%Y-%m-%d')='$today'";			                        
                        $clockin_conn = $em->getConnection()->prepare($clockin_query);
                        $clockin_conn->execute();
                        $clockin_info = $clockin_conn->fetchAll();
		//print_r($clockin_info);
        return $this->render('goldtaskAppBundle:goldtaskReport:clockinReport.html.twig', array('data' => $clockin_info,'userid'=>$userid, 'currentRoute'=>'','adminRedirection'=>''));
    }
	
	
}