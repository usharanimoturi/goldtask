<?php

namespace goldtask\Bundle\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use goldtask\Bundle\AppBundle\Entity\User;
use goldtask\Bundle\AppBundle\Entity\State;
use goldtask\Bundle\AppBundle\Entity\UserRoles;
use goldtask\Bundle\AppBundle\Entity\UserAccess;
use goldtask\Bundle\AppBundle\Entity\OfficesUsers;
use goldtask\Bundle\AppBundle\Entity\UserPasswordUpdates;
use goldtask\Bundle\AppBundle\Entity\phpmailer;
use goldtask\Bundle\AppBundle\Entity\SMTP;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class RegisterController extends Controller {

    /**
     *  User Registration
     * 	
     * */
    public function registerAction(Request $request) {

        $session = $request->getSession(); // Authentication User information using Session
        $userid = $session->get('userid');
        if (!isset($userid) || $userid == '') {
            return $this->redirect($this->generateUrl('login'));
        }
        $register = new User();
        $form = $this->createFormBuilder($register)
                ->add('username', 'text', array(
                    'label' => 'Username*:'
                ))
                ->add('password', 'password', array(
                    'label' => 'Password*:'
                ))
                ->add('userRoleId', 'choice', array(
                    'mapped' => false,
                    'label' => 'User Role*:',
                    'choices' => $this->getRoles()
                ))
                ->add('parentRoleId', 'choice', array(
                    'mapped' => false,
                    'label' => 'Manager Name*:',
                    'choices' => $this->getManagers()
                ))
                ->add('officesId', 'choice', array(
                    'mapped' => true,
                    'choices' => $this->getOffices(),
                    'multiple' => 'multiple'
                ))
                ->add('ipAddress', 'text')
                ->add('firstName', 'text')
                ->add('lastName', 'text')
                ->add('email', 'text')
                ->add('mobile', 'text')
                ->add('state', 'choice', array(
                    'mapped' => false,
                    'choices' => $this->getStates()
                ))
                ->add('city', 'text')
                ->add('address', 'textarea', array(
                    'attr' => array('rows' => 7, 'cols' => 40)
                ))
                ->add('register', 'submit')
                ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            
            $data = $request->request->all();
            $parent_role_id = $data['form']['parentRoleId'];
            $username = $data['form']['username'];
            $_password = $data['form']['password'];
            $password = md5($data['form']['password']);
            $state = trim($data['form']['state']);
            $email = trim($data['form']['email']);
            $name = trim($data['form']['firstName']) . '  ' . trim($data['form']['lastName']);
            $userRoleId = $data['form']['userRoleId'];
            $ipAddress = $data['form']['ipAddress'];
            $repository = $this->getDoctrine()->getRepository('goldtaskAppBundle:User')->findOneByUsername(array("username" => $username));

            if (count($repository) < 1) {
                //$fileName=$register->getPhotoPath()->getClientOriginalName();
                $roleresult = $this->getDoctrine()->getRepository('goldtaskAppBundle:UserRoles')->find($userRoleId);
                $roleParent = $roleresult->getIsParent();

                //$parentRoleId = $roleresult->getParentRoleId();
                //$register->upload();
                $register->setPassword("$password");
                $register->setUserRoleId("$userRoleId");
                $register->setParentRoleId("$parent_role_id");
                $register->setIsParent("$roleParent");
                $register->setState("$state");
                //$register->setPhotoPath("$fileName");
                $register->setCreatedBy("$userid");
                $register->setCreatedOn(new \DateTime(date('Y-m-d H:i:s')));
                $register->setModifiedBy(0);
                $register->setIsActive(1);
                $register->setIsBlocked(0);
                $register->setCounter(0);
                $register->setIpAddress("$ipAddress");
                                
                $em = $this->getDoctrine()->getManager();
                $em->persist($register);
                $em->flush();

                //(Ganesh) Insert into offices ids in offices_user table
                $last_account_id = $register->getId();
                $officeslist = $data['form']['officesId'];
                $offices_count = count($officeslist);
                for ($i = 0; $i < $offices_count; $i++) {
                    $OfficesUsers = new OfficesUsers();
                    $OfficesUsers->setUserId("$last_account_id");
                    $OfficesUsers->setOfficesId("$officeslist[$i]");
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($OfficesUsers);
                    $em->flush();
                }

               /* $body = $this->messegeCreateAccount($name, $username, $_password, '');
                $subject = "Account details for " . $name . " at goldtask";
                $mail = new phpmailer();
                $from = "test@optimalchain.com";
                $mail->From = "$from";
                $mail->FromName = $name;
                $mail->Host = "ssl://smtp.gmail.com";
                //$mail->SMTPSecure = "ssl";
                $mail->Mailer = "smtp";
                $mail->SMTPAuth = true;
                $mail->Username = "test@optimalchain.com";
                $mail->Password = "0pt1m4l14";
                $mail->IsHTML(true);
                //$mail->ContentType = "";
                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->AddAddress($email, "Create goldtask Account");
                if ($mail->Send()) {
                    $name = "Registration has been done successfully.";
                } else {
                    $name = "Email sending problem.Please try again!";
                }*/
                return $this->redirect($this->generateUrl('userslist'));
            } else {
                $name = "error";
                return $this->redirect($this->generateUrl('register', array('name' => $name)));
            }
        } else {
            //echo "not valid";			 
        }
        return $this->render('goldtaskAppBundle:Register:register.html.twig', array('form' => $form->createView(), 'name' => ''));
    }

    /**
     *  get the all offices list drop down done by ganesh
     * 	
     * */
    public function getOffices() {

        $em = $this->getDoctrine()->getEntityManager();
        $office_query = "SELECT id,CONCAT(UCASE(LEFT(name, 1)),SUBSTRING(name, 2)) as name FROM offices WHERE is_active=1 order by name";
        $office_query_conn = $em->getConnection()->prepare($office_query);
        $office_query_conn->execute();
        $office_list = $office_query_conn->fetchAll();
        $officelist = array();
        foreach ($office_list as $office) {
            $officelist[$office['id']] = $office['name'];
        }
        return $officelist;
    }

    /**
     *  Get All States from database in array format to display in drop down
     * 	
     * */
    public function getStates() {
        $em = $this->get('doctrine')->getManager();
        $states = $em->getRepository('goldtaskAppBundle:State')->findAll();
        $state_array[0] = "Select State";
        $state_array[1] = "On Shore";
        $state_array[2] = "Off Shore";
        //foreach ($states as $sta){
        //$state_array[$sta->getId()]=$sta->getStateName();
        //}		
        return $state_array;
    }

    /**
     *  Get All User Roles from database in array format to display in drop down
     * 	
     * */
    public function getRoles() {
        $em = $this->get('doctrine')->getManager();
        $roles = $em->getRepository('goldtaskAppBundle:UserRoles')->findBy(array(),array('roleName' => 'ASC'));
        $role_array[] = "Select Role";
        foreach ($roles as $role) {
            $role_array[$role->getId()] = $role->getRoleName();
        }
        return $role_array;
    }

    /**
     *  User Managers list done by ganesh
     * 	
     * */
    public function getManagers() {
        $em = $this->get('doctrine')->getManager();
        $users_managers_query = $em->createQuery("SELECT u.id,CONCAT(u.firstName,' ',u.lastName) as name from goldtaskAppBundle:User as u where u.userRoleId is not null order by name");
        $users_managers_list = $users_managers_query->getResult();
        $manager_role_array[] = "Select ParentRole";
        foreach ($users_managers_list as $manager_role) {
            $manager_role_array[$manager_role['id']] = $manager_role['name'];
        }
        return $manager_role_array;
    }

    /**
     *  User Login Action
     * 	
     * */
    public function loginAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession(); // Authentication User information using Session  
        $user_id = $session->get('userid');
        $user_role_id = $session->get('userroleid');
        if ($user_id != "" && $user_id != 0) {
            if ($user_role_id == 1) {
                return $this->redirect($this->generateUrl('login'));
            }
            if ($user_role_id == 2 || $user_role_id == 5 || $user_role_id == 3 || $user_role_id == 4) {
                return $this->redirect($this->generateUrl('clockinlist'));
            }
        }
        $ipaddress = $request->getClientIp();
        $register = new User();
        $register->setUsername("");
        $register->setPassword("");
        $form = $this->createFormBuilder($register)
                ->add('username', 'text')
                ->add("password", "password")
                ->add('login', 'submit')
                ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) { // submitted form values are valid  
            $data = $request->request->all();
            $username = $data['form']['username'];
            $password = md5($data['form']['password']);
            $captchatext = $_REQUEST['captchatext1'];
            $foobar2 = $session->get('captcha');
            if (strcmp(strtolower($captchatext), strtolower($foobar2)) != 0) { // Captcha Integration
                $name = "captcha incorrect";
                return $this->render('goldtaskAppBundle:Register:login.html.twig', array('form' => $form->createView(), 'name' => $name, 'success' => 1));
            }

            $repository = $this->getDoctrine()->getRepository('goldtaskAppBundle:User')->findBy(array('username' => $username, 'password' => $password));
            if (count($repository) == 1) { // User information is available in Database
                $userRoleID = $repository[0]->getUserRoleId();  // Get User Role ID				
                $userID = $repository[0]->getId();  // Get User ID
                $userIpAddress = $repository[0]->getIpAddress();  // Get User ID 
               /* if($userRoleID!=1 && $userRoleID!=0 && $userRoleID!=''){					
                    if($userIpAddress!=''){
                        $splitIp=explode(".",$userIpAddress);
                        //print_r($splitIp);exit;
                        if(count($splitIp)>=2){
                            $userOfficeIp=$splitIp[0].".".$splitIp[1];
                            $splitServerIp=explode(".",$ipaddress);
                            $_ipaddress=$splitServerIp[0].".".$splitServerIp[1];
                            if($userOfficeIp!=$_ipaddress){
                                $name = "User don't have authorization to access from this office, Please contact administrator.";
                                return $this->render('goldtaskAppBundle:Register:login.html.twig',array('form' => $form->createView(),'name' =>$name,'success'=>1));
                            }
                        }
                    }
                } */
				
				$offices_query = "SELECT offices_id from offices_users where user_id=$userID";
						
				$offices_conn = $em->getConnection()->prepare($offices_query);
				$offices_conn->execute();
				$offices_info = $offices_conn->fetchAll();
				$session->set('officesid', $offices_info[0]['offices_id']);
				
                $blocked_status = $repository[0]->getIsBlocked();
                $active_status = $repository[0]->getIsActive();
                if ($active_status == 0 || $active_status == '') { // Check User Blocked Staus
                    $name = "User account has been deactivated, Please contact administrator.";
                    return $this->render('goldtaskAppBundle:Register:login.html.twig', array('form' => $form->createView(), 'name' => $name, 'success' => 1));
                }
                $login_count = $repository[0]->getCounter();
                $blockedstatus = 0;
                $logincount = 0;
                if ($blocked_status == '' || $blocked_status == 0) {
                    $blockedstatus = 0;
                } else {
                    $blockedstatus = $repository[0]->getIsBlocked();
                }
                if ($login_count == '' || $login_count == 0) {
                    $logincount = 0;
                } else {
                    $logincount = $repository[0]->getCounter();
                }

                if ($blockedstatus == 1 && $logincount >= 3) { // Check User Blocked Staus
                    $name = "User has been blocked, Please contact administrator.";
                    return $this->render('goldtaskAppBundle:Register:login.html.twig', array('form' => $form->createView(), 'name' => $name, 'success' => 1));
                }

                $userParent = $repository[0]->getIsParent();  // Get User Role is Parent or not
                $userFirstname = $repository[0]->getFirstName();  // Get User Firstname
                $userLastname = $repository[0]->getLastName();  // Get User Lastname
                $userCreatedDate = $repository[0]->getCreatedOn();  // Get User Lastname
               // $created_date= $userCreatedDate->date;
               // $createdDate="00/00/0000";
               // if($created_date!=""){
                   // $split_date=explode("-",$created_date);
                   // $createdDate=$split_date[1]."/".$split_date[2]."/".$split_date[0];
              //  }
               
                $user_name = $userFirstname . "  " . $userLastname;
                $repository[0]->setIsBlocked(0); // Update User Status
                $repository[0]->setCounter(0);
                $em->flush();

                $timestamp = '';
                if (count($register->date)) {
                    $i = 0;
                    foreach ($register->date AS $_date) {
                        if ($i == 0) {
                            $timestamp = $_date;
                        }
                        $i++;
                    }
                }
                $userSession = md5($userID) . md5($timestamp);
                $uaccess = new UserAccess(); // Update User Login Status
                $server_ip = $_SERVER['REMOTE_ADDR'];
                $server_browser = $_SERVER['HTTP_USER_AGENT'];
                $uaccess->setUserId("$userID");
                $uaccess->setLoggedIp("$server_ip");
                $uaccess->setLoggedBrowser("$server_browser");
                $uaccess->setLoggedAt(new \DateTime(date('Y-m-d H:i:s')));
                $uaccess->setLoggedStatus("success");
                $uaccess->setSessionId("$userSession");
                $em->persist($uaccess);
                $em->flush();


                $session->set('username', $username);
                $session->set('userid', $userID);
                $session->set('userroleid', $userRoleID);
                $session->set('userParent', $userParent);
               // $session->set('userCreatedDate', $createdDate);
                //$session->set('userLastname', $userLastname);
                $session->set('user_name', $user_name);
                $session->set('userSession', $userSession);
                $foobar = $session->get('username');
                $session->get('userid');
                $user_role_id = $session->get('userroleid');
                $userRoleName = "";
                if ($user_role_id == 1) {
                    $userRoleName = "Administrator";
                }
                if ($user_role_id == 2) {
                    $userRoleName = "Call Center Manager";
                }
                if ($user_role_id == 3) {
                    $userRoleName = "Staff Manager";
                }
                if ($user_role_id == 4) {
                    $userRoleName = "Staff Member";
                }
                if ($user_role_id == 5) {
                    $userRoleName = "Call Center Member";
                }
                $session->set('userRoleName', $userRoleName);

                if ($user_role_id == 1) {
                    return $this->redirect($this->generateUrl('clockinlist'));
                }
                if ($user_role_id == 2 || $user_role_id == 5 || $user_role_id == 3 || $user_role_id == 4) {
                    return $this->redirect($this->generateUrl('clockinlist'));
                }
            } else { // User name or Password wrong
                $user_check = $this->getDoctrine()->getRepository('goldtaskAppBundle:User')->findBy(array('username' => $username));
                if (count($user_check) >= 1) { // Check User name if Correct
                    $user_check_id = $user_check[0]->getId();  // Get User ID
                    if ($user_check[0]->getCounter() == 0 || $user_check[0]->getCounter() == '') {
                        $user_check_counter = 0;
                    } else {
                        $user_check_counter = (int) $user_check[0]->getCounter();
                    }
                    if ($user_check[0]->getIsBlocked() == 0 || $user_check[0]->getIsBlocked() == '') {
                        $user_check_status = 0;
                    } else {
                        $user_check_status = (int) $user_check[0]->getIsBlocked();
                    }
                    $count = 0;
                    $timestamp = '';
                    if (count($register->date)) {
                        $i = 0;
                        foreach ($register->date AS $_date) {
                            if ($i == 0) {
                                $timestamp = $_date;
                            }
                            $i++;
                        }
                    }
                    $userSession = md5($user_check_id) . md5($timestamp);
                    $uaccess = new UserAccess(); // Update User Login Status
                    $server_ip = $_SERVER['REMOTE_ADDR'];
                    $server_browser = $_SERVER['HTTP_USER_AGENT'];
                    $uaccess->setUserId("$user_check_id");
                    $uaccess->setLoggedIp("$server_ip");
                    $uaccess->setLoggedBrowser("$server_browser");
                    $uaccess->setLoggedAt(new \DateTime(date('Y-m-d H:i:s')));
                    $uaccess->setLoggedStatus("failure");
                    $uaccess->setSessionId("$userSession");
                    $em->persist($uaccess);
                    $em->flush();

                    if ($user_check_counter < 3) {
                        $count = $user_check_counter + 1;
                        $user_check[0]->setCounter("$count");
                        if ($count == 3) {
                            $user_check[0]->setIsBlocked("1");
                        }
                        $em->flush();
                        if ($count < 3) {
                            $name = "Your Maximum Login attempts is 3";
                        }
                        if ($count == 3) {
                            $name = "User has been blocked, please contact administrator.";
                        }
                        return $this->render('goldtaskAppBundle:Register:login.html.twig', array('form' => $form->createView(), 'name' => $name, 'success' => 1));
                    }
                    if ($user_check_counter >= 3) {
                        $user_check[0]->setIsBlocked("1");
                        $em->flush();
                        $name = "User has been blocked, please contact administrator.";
                        return $this->render('goldtaskAppBundle:Register:login.html.twig', array('form' => $form->createView(), 'name' => $name, 'success' => 1));
                    }
                } else { // Check password if correct					
                    $pwd_check = $this->getDoctrine()->getRepository('goldtaskAppBundle:User')->findBy(array('password' => $password));
                    if (count($pwd_check) >= 1) {

                        $user_pwd_id = $pwd_check[0]->getId();  // Get User ID						
                        $pwdcheck_counter = $pwd_check[0]->getCounter();
                        $pwdcheck_status = $pwd_check[0]->getIsBlocked();
                        if ($pwdcheck_counter == 0 || $pwdcheck_counter == '') {
                            $pwd_check_counter = 0;
                        } else {
                            $pwd_check_counter = $pwd_check[0]->getCounter();
                        }
                        if ($pwdcheck_status == 0 || $pwdcheck_status == '') {
                            $pwd_check_status = 0;
                        } else {
                            $pwd_check_status = $pwd_check[0]->getIsBlocked();
                        }

                        $count = 0;
                        $timestamp = '';
                        if (count($register->date)) {
                            $i = 0;
                            foreach ($register->date AS $_date) {
                                if ($i == 0) {
                                    $timestamp = $_date;
                                }
                                $i++;
                            }
                        }
                        $userSession = md5($user_pwd_id) . md5($timestamp);
                        $uaccess = new UserAccess(); // Update User Login Status
                        $server_ip = $_SERVER['REMOTE_ADDR'];
                        $server_browser = $_SERVER['HTTP_USER_AGENT'];
                        $uaccess->setUserId("$user_pwd_id");
                        $uaccess->setLoggedIp("$server_ip");
                        $uaccess->setLoggedBrowser("$server_browser");
                        $uaccess->setLoggedAt(new \DateTime(date('Y-m-d H:i:s')));
                        $uaccess->setLoggedStatus("failure");
                        $uaccess->setSessionId("$userSession");
                        $em->persist($uaccess);
                        $em->flush();

                        if ($pwd_check_counter <= 2) {
                            $count = $pwd_check_counter + 1;
                            $pwd_check[0]->setCounter("$count");
                            if ($count > 2) {
                                $pwd_check[0]->setIsBlocked(1);
                            }

                            $em->flush();

                            if ($count <= 2) {
                                $name = "Your Maximum Login attempts is 3";
                            }
                            if ($count > 2) {
                                $name = "User has been blocked, please contact administrator.";
                            }
                            return $this->render('goldtaskAppBundle:Register:login.html.twig', array('form' => $form->createView(), 'name' => $name, 'success' => 1));
                        }
                        if ($pwd_check_counter > 2) {
                            $pwd_check[0]->setIsBlocked(1);
                            $em->flush();
                            $name = "User has been blocked, please contact administrator.";
                            return $this->render('goldtaskAppBundle:Register:login.html.twig', array('form' => $form->createView(), 'name' => $name, 'success' => 1));
                        }
                    } else {
                        $name = "Username or password incorrect, Please try again!";
                        return $this->render('goldtaskAppBundle:Register:login.html.twig', array('form' => $form->createView(), 'name' => $name, 'success' => 1));
                    }
                }
            }
        }
        return $this->render('goldtaskAppBundle:Register:login.html.twig', array('form' => $form->createView(), 'name' => '', 'success' => ''));
    }

    /**
     *  Display All Users List
     * 	
     * */
    public function usersListAction(Request $request) {

        $session = $request->getSession(); // Authentication User information using Session
        $userid = $session->get('userid');
        $user_role_id=$session->get('userroleid');
        if (!isset($userid) || $userid == '') {
            return $this->redirect($this->generateUrl('login'));
        }
        if($user_role_id!=1){
				return $this->redirect($this->generateUrl('wrong'));
			}
        $user = new User();
        $em = $this->getDoctrine()->getManager();
        $sql = <<<SQL
            SELECT 
                    CONCAT(
                            u.first_name,
                            '  ',
                            u.last_name
                    )AS name,
                    u.email AS email,
                    u.mobile AS mobile,
                    GROUP_CONCAT(
                            o.legal_name 
                            SEPARATOR ', '
                    ) AS office_name,
                    u.is_active AS isActive,
                    u.counter AS counter,
                    u.id AS id 
            FROM 
                    user AS u
            LEFT JOIN 
                    offices_users AS ou ON u.id=ou.user_id 
            LEFT JOIN 
                    offices AS o ON o.id=ou.offices_id 
            WHERE 
                    u.user_role_id!=1 
            GROUP BY 
                    u.id 
SQL;
        $appViewStmt = $em->getConnection()->prepare($sql);
        $appViewStmt->execute();
        $data = $appViewStmt->fetchAll();
        return $this->render('goldtaskAppBundle:Register:userlist.html.twig', array('data' => $data));
    }

    /**
     *  Update User Data
     * 	
     * */
    public function usersUpdateAction(Request $request, $id) {

        $session = $request->getSession(); // Authentcation User information using Session
        $userid = $session->get('userid');
        if (!isset($userid) || $userid == '') {
            return $this->redirect($this->generateUrl('login'));
        }

        $request = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $userData = $this->getDoctrine()->getRepository('goldtaskAppBundle:User')->find($id);
        //print_r($userData);exit;
        $officesql = <<<SQL
			SELECT 
				offices_id AS offices_id 
			FROM 
				offices_users AS ou 			
			WHERE 
				ou.user_id=$id 
			
SQL;
        $officeStmt = $em->getConnection()->prepare($officesql);
        $officeStmt->execute();
        $officeData = $officeStmt->fetchAll();
        $office = array();
        if (count($officeData) > 0) {
            foreach ($officeData AS $offices) {
                $office[] = $offices['offices_id'];
            }
        }
        $_offices = array_unique($office);
        unset($office);
        $office = implode(",", $_offices);

        $register = new User();

        $form = $this->createFormBuilder($userData)
                ->add('officesId', 'choice', array(
                    'mapped' => true,
                    'choices' => $this->getOffices(),
                    'data' => $_offices,
                    'multiple' => 'multiple'))
                ->add('ipAddress', 'text')
                ->add('firstName', 'text')
                ->add('lastName', 'text')
                ->add('mobile', 'text')
                ->add('state', 'choice', array(
                    'required' => true,
                    'mapped' => true,
                    'choices' => $this->getStates()))
                ->add('city', 'text')
                ->add('address', 'textarea')
                ->add('update', 'submit')
                ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $userDetails = $em->getRepository('goldtaskAppBundle:User')->find($id);
            if (!$userDetails) {
                throw $this->createNotFoundException('No Records were found for id ' . $id);
            }
            $data = $request->request->all();
            $fName = trim($data['form']['firstName']);
            $lName = trim($data['form']['lastName']);
            //$email = $data['form']['email'];
            $mobile = $data['form']['mobile'];
            $city = trim($data['form']['city']);
            $address = trim($data['form']['address']);
            $ipAddress = $data['form']['ipAddress'];
            $userDetails->setFirstName("$fName");
            $userDetails->setLastName("$lName");
            //$userDetails->setEmail("$email");
            $userDetails->setMobile("$mobile");
            $userDetails->setCity("$city");
            $userDetails->setAddress("$address");
            $userDetails->setIpAddress("$ipAddress");
            $em->flush();

            // Delete offices and Insert Again
            $query = 'DELETE FROM offices_users WHERE  user_id = ' . $id;
            $queryStatement = $em->getConnection()->prepare($query);
            $queryStatement->execute();
            $officeslist = $data['form']['officesId'];
            $offices_count = count($officeslist);
            if ($offices_count > 0) {
                for ($i = 0; $i < $offices_count; $i++) {
                    $OfficesUsers = new OfficesUsers();
                    $OfficesUsers->setUserId("$id");
                    $OfficesUsers->setOfficesId("$officeslist[$i]");
                    $em->persist($OfficesUsers);
                    $em->flush();
                }
            }
            //Redirect page users list 
            return $this->redirect($this->generateUrl('userslist'));
            exit;
        } else {
            return $this->render('goldtaskAppBundle:Register:userupdate.html.twig', array('form' => $form->createView(), 'id' => $id, 'office' => $office));
        }

        //return $this->render('goldtaskAppBundle:Register:userupdate.html.twig', array('data' => $data));
    }

    /**
     *  Delete User Information
     * 	
     * */
    public function usersDeleteAction(Request $request, $id) {

        $session = $request->getSession(); // Authentcation User information using Session
        $userid = $session->get('userid');
        if (!isset($userid) || $userid == '') {
            return $this->redirect($this->generateUrl('login'));
        }
        $register = new User();
        $userData = $this->getDoctrine()->getRepository('goldtaskAppBundle:User')->find($id);
        $em = $this->getDoctrine()->getManager();
        $userData->setIsActive(0);
        $em->flush();
        return $this->redirect($this->generateUrl('userslist'));
    }
    
    /**
     *  Active User Information
     * 	
     * */
    public function usersActiveAction(Request $request, $id) {

        $session = $request->getSession(); // Authentcation User information using Session
        $userid = $session->get('userid');
        if (!isset($userid) || $userid == '') {
            return $this->redirect($this->generateUrl('login'));
        }
        $register = new User();
        $userData = $this->getDoctrine()->getRepository('goldtaskAppBundle:User')->find($id);
        $em = $this->getDoctrine()->getManager();
        $userData->setIsActive(1);
        $em->flush();
        return $this->redirect($this->generateUrl('userslist'));
    }
    
    /**
     *  Inactive User Information
     * 	
     * */
    public function usersInactiveAction(Request $request, $id) {

        $session = $request->getSession(); // Authentcation User information using Session
        $userid = $session->get('userid');
        if (!isset($userid) || $userid == '') {
            return $this->redirect($this->generateUrl('login'));
        }
        $register = new User();
        $userData = $this->getDoctrine()->getRepository('goldtaskAppBundle:User')->find($id);
        $em = $this->getDoctrine()->getManager();
        $userData->setIsActive(0);
        $em->flush();
        return $this->redirect($this->generateUrl('userslist'));
    }
    
    /**
     *  Blocking User Information
     * 	
     * */
    public function usersBlockedAction(Request $request, $id) {

        $session = $request->getSession(); // Authentcation User information using Session
        $userid = $session->get('userid');
        if (!isset($userid) || $userid == '') {
            return $this->redirect($this->generateUrl('login'));
        }
        $register = new User();
        $userData = $this->getDoctrine()->getRepository('goldtaskAppBundle:User')->find($id);
        $em = $this->getDoctrine()->getManager();
        $userData->setCounter(3);
        $userData->setIsBlocked(1);
        $em->flush();
        return $this->redirect($this->generateUrl('userslist'));
    }
    
    /**
     *  Unblocking User Information
     * 	
     * */
    public function usersUnblockedAction(Request $request, $id) {

        $session = $request->getSession(); // Authentcation User information using Session
        $userid = $session->get('userid');
        if (!isset($userid) || $userid == '') {
            return $this->redirect($this->generateUrl('login'));
        }
        $register = new User();
        $userData = $this->getDoctrine()->getRepository('goldtaskAppBundle:User')->find($id);
        $em = $this->getDoctrine()->getManager();
        $userData->setCounter(0);
        $userData->setIsBlocked(0);
        $em->flush();
        return $this->redirect($this->generateUrl('userslist'));
    }

    /**
     *  View User Information
     * 	
     * */
    public function usersViewAction(Request $request, $id) {

        $session = $request->getSession(); // Authentcation User information using Session
        $userid = $session->get('userid');
        if (!isset($userid) || $userid == '') {
            return $this->redirect($this->generateUrl('login'));
        }

        $em = $this->getDoctrine()->getManager();
        $data = $this->getDoctrine()->getRepository('goldtaskAppBundle:User')->find($id);
        $officesql = <<<SQL
			SELECT 
				o.legal_name AS legal_name  
			FROM 
				offices_users AS ou 
			LEFT JOIN 
				offices AS o On o.id=ou.offices_id 
			WHERE 
				ou.user_id=$id 
			
SQL;
        $officeStmt = $em->getConnection()->prepare($officesql);
        $officeStmt->execute();
        $officeData = $officeStmt->fetchAll();
        $office = array();
        if (count($officeData) > 0) {
            foreach ($officeData AS $offices) {
                $office[] = $offices['legal_name'];
            }
        }
        $_offices = array_unique($office);
        unset($office);
        $office = implode(",", $_offices);
        //$test=$this->get('request')->getBasePath();
        return $this->render('goldtaskAppBundle:Register:userview.html.twig', array('data' => $data, 'officeData' => $office));
    }

    /**
     *  My profile action
     * 	
     * */
    public function myprofileAction(Request $request) {

        $session = $request->getSession(); // Authentication User information using Session
        $userid = $session->get('userid');
        if (!isset($userid) || $userid == '') {
            return $this->redirect($this->generateUrl('login'));
        }

        $em = $this->getDoctrine()->getManager();
        $data = $this->getDoctrine()->getRepository('goldtaskAppBundle:User')->find($userid);
        $officesql = <<<SQL
			SELECT 
				o.legal_name AS legal_name  
			FROM 
				offices_users AS ou 
			LEFT JOIN 
				offices AS o On o.id=ou.offices_id 
			WHERE 
				ou.user_id=$userid 
			
SQL;
        $officeStmt = $em->getConnection()->prepare($officesql);
        $officeStmt->execute();
        $officeData = $officeStmt->fetchAll();
        $offices = array();
        if (count($officeData) > 0) {
            foreach ($officeData AS $offices) {
                $offices[] = $offices['legal_name'];
            }
        }
        $_offices = array_unique($offices);
        $office = implode(",", $_offices);
        //$test=$this->get('request')->getBasePath();
        return $this->render('goldtaskAppBundle:Register:myprofileview.html.twig', array('data' => $data, 'officeData' => $office));
    }

    /**
     *  Change Password
     * 	
     * */
    public function changePasswordAction(Request $request) {

        $session = $request->getSession(); // Authentication User information using Session
        $userid = $session->get('userid');
		
        if (!isset($userid) || $userid == '') {
            return $this->redirect($this->generateUrl('login'));
        }
        // If the session is exist
        if (isset($_POST['changesubmit']) && $_POST['changesubmit'] == 'Change Password') {
		    $oldPwd=md5($_POST['oldpwd']);
			
			$em = $this->getDoctrine()->getManager();
			$data = $this->getDoctrine()->getRepository('goldtaskAppBundle:User');
			$usersql = <<<SQL
			SELECT 
			count(*)as users_count from user as u
						WHERE 
				u.id=$userid and u.password='$oldPwd'
			
SQL;
        $userStmt = $em->getConnection()->prepare($usersql);
        $userStmt->execute();
        $userData = $userStmt->fetchAll();
		
			if( ($userData['0']['users_count']) == 1){			
				
				$containsLetternew = preg_match('/[a-zA-Z]/', $_POST["newpwd"]); //match for letter.
				$containsDigitnew = preg_match('/\d/', $_POST["newpwd"]); //match for digit.
				$containsSpecialnew = preg_match('/[^a-zA-Z\d]/', $_POST["newpwd"]); //match for special character.

				if (!empty($_POST["newpwd"])) {
					if ($containsLetternew == 0 || $containsDigitnew == 0 || $containsSpecialnew == 0 || strlen($_POST["newpwd"]) < 8) {
						$name = "You must enter new password with at least eight characters and consists one number and one special character.";
						return $this->render('goldtaskAppBundle:Register:changepassword.html.twig', array('success' => 2, 'name' => $name));
						$check = false;
					}
				}

				$em = $this->getDoctrine()->getManager();
				$userDetails = $em->getRepository('goldtaskAppBundle:User')->find($userid);
				if (!$userDetails) {
					throw $this->createNotFoundException('No Records were found for id ' . $userid);
				}
				$newPwd = md5($_POST['newpwd']);
				$userDetails->setPassword("$newPwd");
				$em->flush();
				$name = "Password has been updated successfully!";
				return $this->render('goldtaskAppBundle:Register:changepassword.html.twig', array('success' => 1, 'name' => $name, 'Fail' => ''));
			} else{
			
				return $this->render('goldtaskAppBundle:Register:changepassword.html.twig', array('Fail' => 'Please enter correct password', 'name' => ''));
			}
		} 
		return $this->render('goldtaskAppBundle:Register:changepassword.html.twig', array('success' => '', 'name' => '', 'Fail' => ''));
		
    }

    /**
     * Forgot Password
     * 	
     * */
    public function forgotPasswordAction() {

        $request = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $register = new User();
        $form = $this->createFormBuilder($register)
                ->add('email', 'text')
                ->add('send', 'submit')
                ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $data = $request->request->all();
            $email = $data['form']['email'];
            $user_check = $this->getDoctrine()->getRepository('goldtaskAppBundle:User')->findBy(array('email' => $email));
            if (count($user_check) >= 1) {
                $password = $this->getSecureToken(8);
                $id = $user_check[0]->getId();  // Get User ID
                $name = $user_check[0]->getFirstName() . '  ' . $user_check[0]->getLastName();
                $username = $user_check[0]->getUsername();
                $hostname = $request->getSchemeAndHttpHost();
                $userActive = $user_check[0]->getIsActive();
                $userBlocked = $user_check[0]->getIsBlocked();
                if($userActive == 0){
                    $name = 3;
                    $email_addr_name = "User has been deactivated.Please contact administrator!";
                    return $this->render('goldtaskAppBundle:Register:forgotpassword.html.twig', array('form' => $form->createView(), 'email_addr_name' => $email_addr_name, 'name' => $name));
                }
                if($userBlocked == 1){
                    $name = 3;
                    $email_addr_name = "User has been blocked.Please contact administrator!";
                    return $this->render('goldtaskAppBundle:Register:forgotpassword.html.twig', array('form' => $form->createView(), 'email_addr_name' => $email_addr_name, 'name' => $name));
                }
                $timestamp = '';
                if (count($register->date)) {
                    $i = 0;
                    foreach ($register->date AS $_date) {
                        if ($i == 0) {
                            $timestamp = $_date;
                        }
                        $i++;
                    }
                }
                $random_id = md5($id) . md5($timestamp);
                $reset = $hostname . '/goldtask/web/app_dev.php/resetpassword?us=' . $random_id;
                $subject = "Account details for " . $name . " at Optimalchain.com";
                $body = $this->messegeActivatinAccount($name, $username, $password, $reset);


                $mail = new phpmailer();
                $from = "test@optimalchain.com";
                $mail->From = "$from";
                $mail->FromName = $name;
                $mail->Host = "ssl://smtp.gmail.com";
                //$mail->SMTPSecure = "ssl";
                $mail->Mailer = "smtp";
                $mail->SMTPAuth = true;
                $mail->Username = "test@optimalchain.com";
                $mail->Password = "0pt1m4l14";
                $mail->IsHTML(true);
                //$mail->ContentType = "";
                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->AddAddress($email, "goldtask User Access Account");
                $mail->Send();
                $c = 1;
                if ($c == 1) {
                    $user = $this->getDoctrine()->getRepository('goldtaskAppBundle:User')->find($id);
                    $_password = md5($password);
                    $user->setPassword("$_password");
                    $em->flush();
                    $user_password = new UserPasswordUpdates();
                    $date_list = date('Y-m-d H:i:s');
                    $insert_query = "insert into user_password_updates(USER_ID,RANDOM_CODE,CREATED_ON)values('$id','$random_id','$date_list')";
                    $stmt = $em->getConnection()->prepare($insert_query);
                    $result = $stmt->execute();
                    $name = 1;
                    $success_name = "Your account details has been sent to your email address.";
                    return $this->render('goldtaskAppBundle:Register:forgotpassword.html.twig', array('form' => $form->createView(), 'success_name' => $success_name, 'name' => $name));
                } else {
                    $name = 2;
                    $email_name = "Email sending problem.Please try again!";
                    return $this->render('goldtaskAppBundle:Register:forgotpassword.html.twig', array('form' => $form->createView(), 'email_name' => $email_name, 'name' => $name));
                }
            } else {
                $name = 3;
                $email_addr_name = "Email address not available";
                return $this->render('goldtaskAppBundle:Register:forgotpassword.html.twig', array('form' => $form->createView(), 'email_addr_name' => $email_addr_name, 'name' => $name));
            }
        }
        return $this->render('goldtaskAppBundle:Register:forgotpassword.html.twig', array('form' => $form->createView(), 'name' => ''));
    }

    /**
     *  Reset user password
     *
     * */
    public function resetpasswordAction(Request $request) {

        if (isset($_REQUEST['us']) && $_REQUEST['us'] != "") {

            $rand = $_REQUEST['us'];
            $em = $this->getDoctrine()->getManager();
            $query = "SELECT RANDOM_CODE,HOUR(TIMEDIFF(`CREATED_ON`,now())) as HRS,USER_ID FROM user_password_updates WHERE RANDOM_CODE='" . $rand . "'";
            $stmt = $em->getConnection()->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $user_id = $result[0]['RANDOM_CODE'];
            if ($result[0]['RANDOM_CODE'] == $rand && $result[0]['HRS'] <= '24' && !isset($_POST['resetsubmit'])) { // Reset link should be less than 24 hours age	
                return $this->render('goldtaskAppBundle:Register:resetpassword.html.twig', array('user' => $user_id, 'success' => ''));
            } else if ($result[0]['RANDOM_CODE'] == $rand && $result[0]['HRS'] >= '24' && !isset($_POST['resetsubmit'])) { // Expire link should be greater than 24 hours age			   
                $query = "UPDATE user_password_updates SET IS_EXPIRED = '1' WHERE RANDOM_CODE='" . $rand . "'";
                $stmt = $em->getConnection()->prepare($query);
                $result = $stmt->execute();
                $name = "Reset password link has been expired.Please try again!";
                return $this->render('goldtaskAppBundle:Register:resetpassword.html.twig', array('user' => $user_id, 'success' => '', 'name' => $name));
            } else {   // Changed new password				
                if (isset($_POST['resetsubmit']) && $_POST['resetsubmit'] == 'Reset Password') {
                    $check = true;
                    $newpassword = trim($_POST['newpwd']);
                    $user_id = $_POST['hidUser'];
                    $em = $this->getDoctrine()->getManager();

                    $query = "SELECT RANDOM_CODE,HOUR(TIMEDIFF(`CREATED_ON`,now())) as HRS,USER_ID FROM user_password_updates WHERE RANDOM_CODE='" . $user_id . "'";
                    $stmt = $em->getConnection()->prepare($query);
                    $stmt->execute();
                    $result = $stmt->fetchAll();
                    $get_user_id = $result[0]['USER_ID'];

                    if (isset($_POST['newpwd']) && $_POST['newpwd'] != '') {

                        $containsLetternew = preg_match('/[a-zA-Z]/', $_POST["newpwd"]); //match for letter.
                        $containsDigitnew = preg_match('/\d/', $_POST["newpwd"]); //match for digit.
                        $containsSpecialnew = preg_match('/[^a-zA-Z\d]/', $_POST["newpwd"]); //match for special character.

                        if (!empty($_POST["newpwd"])) {
                            if ($containsLetternew == 0 || $containsDigitnew == 0 || $containsSpecialnew == 0 || strlen($_POST["newpwd"]) < 8) {
                                $name = "You must enter new password with at least eight characters and consists one number and one special character.";
                                return $this->render('goldtaskAppBundle:Register:resetpassword.html.twig', array('success' => 2, 'user' => $user_id, 'name' => $name));
                                $check = false;
                            }
                        }
                        if ($check == true) {
                            $user = $this->getDoctrine()->getRepository('goldtaskAppBundle:User')->find($get_user_id);
                            $newPwd = md5($_POST['newpwd']);
                            $user->setPassword("$newPwd");
                            $em->flush();
                            $query = "UPDATE user_password_updates SET IS_DONE = '1' WHERE USER_ID='" . $get_user_id . "'";
                            $stmt = $em->getConnection()->prepare($query);
                            $result = $stmt->execute();
                            $name = "Password has been updated successfully!";
                            return $this->render('goldtaskAppBundle:Register:resetpassword.html.twig', array('success' => 3, 'user' => '', 'name' => $name));
                        }
                    } else {
                        $name = "Wrong user.Please try again!";
                        return $this->render('goldtaskAppBundle:Register:resetpassword.html.twig', array('success' => 4, 'name' => $name, 'user' => $user_id));
                    }
                } else {
                    $name = "Requested reset link not available. Please try again!";
                    return $this->render('goldtaskAppBundle:Register:resetpassword.html.twig', array('success' => 5, 'name' => $name, 'user' => $user_id));
                }
            }
        }
    }

    /**
     *  Set Secure Password
     *
     * */
    public function getSecureToken($length) {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[$this->crypto_rand_secure(0, strlen($codeAlphabet))];
        }
        return $token;
    }

    /**
     *  Generate Password
     *
     * */
    public function crypto_rand_secure($min, $max) {
        $range = $max - $min;
        if ($range < 0)
            return $min; // not so random...
        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    /**
     * Logout Action
     *
     * */
    public function logoutAction(Request $request) {

        $session = $request->getSession();
        $userid = $session->get('userid');
        $userSession = $session->get('userSession');
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $list = $connection->prepare("update user set counter=0 where id='$userid'");
        $list->execute();

        // Update User Login Status
        $_uaccess = $this->getDoctrine()->getRepository('goldtaskAppBundle:UserAccess')->findBy(array('sessionId' => $userSession));
        $_user_access_id = 0;
        if (count($_uaccess) > 0) {
            $_user_access_id = $_uaccess[0]->getId();
        }
        if ($_user_access_id == 0 || $_user_access_id == "") {
            $session = $request->getSession();
            $this->get('session')->clear();
            return $this->redirect($this->generateUrl('login'));
        } else {
            $_uaccess = $this->getDoctrine()->getRepository('goldtaskAppBundle:UserAccess')->find($_user_access_id);
            $_uaccess->setLogoutAt(new \DateTime(date('Y-m-d H:i:s')));
            $_uaccess->setLogoutStatus("suceess");
            $em->flush();
            $session = $request->getSession();
            $this->get('session')->clear();
            return $this->redirect($this->generateUrl('login'));
        }
    }

    /**
     *   
     *  Email content for forgot password
     * */
    public function messegeActivatinAccount($name, $username, $pass, $host) {

        $body = "Hi " . $username . ", <br> As you requested here are your account details. Please keep this details for future use as well. <br><br>
		Username:" . $username . " <br>
		Password: <b>" . $pass . "</b> <br> <br><br>
		If you want to change your password, please use this link: <a href='$host'>Reset Password</a>  (please note the link is valid for today only).<br><br><br>
		Note:This is automatically generated email, please do not reply to this email message. If you have ANY questions or concerns about the operation of this account, please contact our admin team directly. <br><br>.
        <br><br> Regards <br>goldtask Admin";

        return $body;
    }

    /**
     *   
     *  Email content for create account
     * */
    public function messegeCreateAccount($name, $username, $pass, $host = '') {

        $body = "Hi " . $name . ", <br> Congratulations!<br><br>This is to confirm that your account has been created successfully. Your account details are as mentioned below, please keep the details for future use. <br> <br> 
		Username:" . $username . " <br>
		Password: <b>" . $pass . "</b> <br> <br><br>
		Do not hesitate to contact should you have any questions or concerns about your account.<br><br>
		Note:This is automatically generated email, please do not reply to this email message. If you have ANY questions or concerns about the operation of this account, please contact our admin team directly. <br><br>
		<br><br> Regards <br>goldtask Admin";

        return $body;
    }

    /**
     *  captcha action for login
     *
     * */
    public function captchaAction(Request $request) {

        $session = $request->getSession();
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < 5; $i++) {
            $randomString .= $chars[rand(0, strlen($chars) - 1)];
        }

        $session->set('captcha', $randomString);
        $foobar = $session->get('captcha');

        return new Response($randomString);
    }

    /**
     *  Check Username available or not
     *
     * */
    public function username_findingAction(Request $request) {

        $username = $request->request->get('user');
        $user_exist_or_not = $this->getDoctrine()->getRepository('goldtaskAppBundle:User')->findOneByUsername(array("username" => $username));
        $result_user_exist_count = count($user_exist_or_not);
        return new Response(json_encode($result_user_exist_count));
    }

    /**
     *  Check Email available or not
     *
     * */
    public function username_email_findingAction(Request $request) {
        $email = $request->request->get('email');
        $user_email_exist_or_not = $this->getDoctrine()->getRepository('goldtaskAppBundle:User')->findOneByEmail(array("Email" => $email));
        $result_user_email_exist_count = count($user_email_exist_or_not);
        return new Response(json_encode($result_user_email_exist_count));
    }

    /**
     *  Show all Managers 
     *
     * */
    public function managerslistAction() {

        $em = $this->getDoctrine()->getManager();
        $mid = $_POST['managerid'];
        $users_managers_list = array();
        if ($mid == 5) {
            $users_managers_query = $em->createQuery("SELECT u.id,CONCAT(u.firstName,' ',u.lastName) as name from goldtaskAppBundle:User as u where u.userRoleId=2 order by name");
            $users_managers_list = $users_managers_query->getResult();
        } else if ($mid == 4) {
            $users_managers_query = $em->createQuery("SELECT u.id,CONCAT(u.firstName,' ',u.lastName) as name from goldtaskAppBundle:User as u where u.userRoleId=3 order by name");
            $users_managers_list = $users_managers_query->getResult();
        } else {
            if ($mid == 1 || $mid == 2 || $mid == 3) {
                $users_managers_list = array(array('id' => 1, 'name' => 'Admin'));
            }
        }
        return new Response(json_encode($users_managers_list));
    }
	public function wrongAction(){
            return $this->render('goldtaskAppBundle:Register:wrong.html.twig');
    }
}
