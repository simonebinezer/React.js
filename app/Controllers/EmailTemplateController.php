<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnswerListModel;
use App\Models\UserModel;
use App\Models\TenantModel;
use App\Models\QuestionModel;
use App\Models\SurveyModel;
use App\Models\ExternalcontactsModel;
use App\Models\CreatecontactsModel;
use App\Models\SurveyResponseModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\MailScheduleModel;


class EmailTemplateController extends BaseController
{
    public function index()
    {
        $externalList = $this->getSurveycontactdata();
        $surveyController = new SurveyController();
        $getSurvey = $surveyController->GetSurveyList()[1];
        return view('admin/emailtemplate', ["getSurvey" => $getSurvey, "externalList" => $externalList]);
    }
    public function getSurveycontactdata()
    {
        if (session()->get('tenant_id') == 1) {
            $model = new ExternalcontactsModel();
            $condition = array('status' => 1);
            return $externalList = $model->where($condition)->find();
        } else {
            $dbname = "nps_" . session()->get('tenant_name');
            //new DB creation for Tenant details
            $db = db_connect();
            $db->query('USE ' . $dbname);
            $new_db_select = "SELECT * FROM " . $dbname . ".nps_external_contacts WHERE `nps_external_contacts`.`status` = " . 1;
            $result = $db->query($new_db_select);
            $db->close();

            if (count($result->getResult()) > 0) {
                return $externalList = json_decode(json_encode($result->getResult()), true);
            }
        }
    }
    public function uploadFile()
    {
        $customerController = new CustomerController();
        $input = $this->validate([
            'formData' => 'uploaded[formData]|max_size[formData,2048]|ext_in[formData,csv]'
        ]);
        if (!$input) {
            $data['validation'] = $this->validator;
            echo json_encode(['failed' => $data, 'csrf' => csrf_hash()]);
        } else {
            if ($file = $this->request->getFile('formData')) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move('../public/csvfile', $newName);
                    $file = fopen("../public/csvfile/" . $newName, "r");
                    $i = 0;
                    $numberOfFields = 4;
                    $csvArr = array();
                    while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                        $num = count($filedata);
                        if ($i > 0 && $num == $numberOfFields) {
                            $csvArr[$i]['name'] = $filedata[0] . " " . $filedata[1];
                            $csvArr[$i]['firstname'] = $filedata[0];
                            $csvArr[$i]['lastname'] = $filedata[1];
                            $csvArr[$i]['contact'] = $filedata[2];
                            $csvArr[$i]['email'] = $filedata[3];
                        }
                        $i++;
                    }
                    fclose($file);
                    $count = 0;
                    $emaillist = array();
                    foreach ($csvArr as $exportData) {
                        $validateEmail = $customerController->Check_ContactAndEmail($exportData["email"], $exportData["contact"]);
                        if ($validateEmail) {
                            $tenant  = [
                                "tenant_id" => session()->get('tenant_id'),
                                "tenant_name" =>  session()->get('tenant_name')
                            ];
                            $data = [
                                "name" => $exportData["name"],
                                "firstname" => $exportData["firstname"],
                                "lastname" => $exportData["lastname"],
                                "contact_details" => $exportData["contact"],
                                "email_id" => $exportData["email"],
                                "created_by" => session()->get('id')
                            ];
                            if ($tenant['tenant_id'] == 1) {
                                $this->createContact($data);
                            } else {
                                $customerController->tenantCreateContact($data);
                            }
                            array_push($emaillist, $exportData["email"]);
                        }
                    }
                    $return_email = implode(",", $emaillist);
                    echo json_encode(['success' => "success", 'csrf' => csrf_hash(), "query" =>  $return_email]);
                }
            }
        }
    }

    public function createContact($exportData)
    {

        $model = new ExternalcontactsModel();
        $multiClause = array('email_id' => $exportData['email_id']);
        $contactlist = $model->where($multiClause)->first();
        if (!$contactlist) {
            $model = new ExternalcontactsModel();
            $result = $model->insertBatch([$exportData]);
        }
    }

    public function sendEmail()
    {
        $externalList = $this->getSurveycontactdata();
        $surveyController = new SurveyController();
        $getSurvey = $surveyController->GetSurveyList()[1];
        // $model = new SurveyModel();
        // $getSurvey = $model->find();
        $a = $this->request->getPost();

        if ($this->request->getMethod() == 'post' && !($this->request->getPost("email_id"))) {

            $rules = [
                'From' => 'required|min_length[6]|max_length[50]|valid_email',
                'Name' => 'required|min_length[3]|max_length[50]',
                'To' => 'ValidateRecipientList[To]'
            ];
            $errors = [

                'From' =>
                [
                    'valid_email' => 'Please check the From field. It does not appear to be valid email.',
                ],
                'Name' =>
                [
                    'min_length' => 'Please enter atleast 3 letters.',
                    'max_length' => 'Please enter less than 50 letters.'
                ],
                'To' =>
                [
                    'ValidateRecipientList' => 'Please choose a customer to send mail.'
                ]

            ];
            if (!$this->validate($rules, $errors)) {
                $a = $this->validator->getErrors();
                // $to = $this->request->getPost("to");
                // $to = ($to != null) ? $this->request->getPost("to") : null;
                return view('admin/emailtemplate', ["validation" => $this->validator, "getSurvey" => $getSurvey, "externalList" => $externalList]);
            } else {

                $userId = session()->get('id');
                $tenant  = [
                    "tenant_id" => session()->get('tenant_id'),
                    "tenant_name" =>  session()->get('tenant_name')
                ];
                $postData = $this->request->getPost();
                $toList = json_decode($postData["To"]);
                $postData["emailList"] = $toList[0];

                $customerController = new CustomerController();

                if ($tenant['tenant_id'] == 1) {
                    $segmentsMailList =   $customerController->GetEmailsFromSegments($toList[1]);
                    $mailList = array_merge($toList[0], $segmentsMailList);
                    $postData["emailList"] = $mailList;
                    $this->createMailTemplate($postData, $userId);
                } else {
                    $db_name = "";
                    $this->ConnectDB($db_name);
                    $segmentsMailList =   $customerController->GetEmailsFromSegments($toList[1]);
                    $mailList = array_merge($toList[0], $segmentsMailList);
                    $uniqueMailList=array_unique($mailList);
                    $postData["emailList"] =$uniqueMailList;
                    $this->createMailTemplatesubTenant($postData, $userId, $tenant);
                }

                $model = new SurveyModel();
                $surveyData = $model->where('campaign_id', $postData["survey"])->first();
                $postData["placeholder_name"] = $surveyData["placeholder_name"];

                //$emailstatus = $this->createTemplateForSurvey($postData, $userId, $postData['checkoutemail'], $tenant);
                $emailstatus = $this->ScheduleMail($postData, $userId, $postData["emailList"], $tenant);

                //exit();
                $db_name = "";
                $this->ConnectDB($db_name);
                $model = new SurveyModel();
                $updateValue = ['sent_status' => '0'];
                $model->update($postData["survey"], $updateValue);
                session()->setFlashdata('response', $emailstatus);
                return redirect()->to(base_url('emailtemplate'));
            }
        }
        return view('admin/emailtemplate', ["getSurvey" => $getSurvey, "externalList" => $externalList, "to" => $this->request->getPost("email_id")]);
    }

    public function createTemplateForSurvey($postdata, $userId, $emailList, $tenant)
    {
        //$whitelist = array('127.0.0.1', '::1');
        $model = new ExternalcontactsModel();
        // $multiClause = array('email_id' => $emailList, 'status' => 1);
        //$multiClause = array('email_id' => $email,'status'=>'1');
        $contactlist = $model->whereIn('email_id', $emailList)->where('status', 1)->findAll();
        $contact = [];
        $response = false;
        $tenant_id = $tenant['tenant_id'];
        $survey_id = $postdata['survey'];
        $from_id = $postdata['From'];
        $from_name = $postdata['Name'];
        $data = [];
        try {
            $mail = new PHPMailer(true);
            // $mail->SMTPKeepAlive = true;
            $subject =  $postdata['subject'] ? $postdata['subject']  : "What did you think about NPS";
            // $mail->isSMTP();
            // $mail->addCustomHeader('MIME-Version: 1.0');
            // $mail->addCustomHeader('Content-Type: text/html; charset=ISO-8859-1');
            // $mail->SMTPDebug    = 0;
            // $mail->Host         = 'smtp.gmail.com'; //smtp.google.com
            // $mail->SMTPAuth     = true;
            // $mail->Username     = 'hctoolssmtp@gmail.com';
            // $mail->Password     = 'iyelinyqlqdsmhro';
            // $mail->SMTPSecure   = 'tls';
            // $mail->Port         = 587;
            // $mail->Subject      = $subject;
            // $mail->setFrom($postdata['From'], $postdata['Name']);
            // $mail->isHTML(true);

            for ($i = 0; $i < count($contactlist); $i++) {


                $contact = $contactlist[$i];
                $template = view("template/email-template-survey", ["userId" => $userId, "postdata" => $postdata, "contactdata" => $contact, "tenantdata" => $tenant]); //, "surveyrandom" => $surveyrandom]);

                $data[$i]['tenant_id'] = $tenant_id;
                $data[$i]['survey_id'] = $survey_id;
                $data[$i]['customer_id'] = $contact['id'];
                $data[$i]['customer_mail'] = $contact['email_id'];
                $data[$i]['subject'] = $subject;
                $data[$i]['from_id'] = $from_id;
                $data[$i]['from_name'] = $from_name;
                $data[$i]['mail'] = $template;

                $mail->clearAddresses();
                // $mail->Body = $template;
                //$start = date("Y-m-d H:i:s");
                //print_r('start: ' . $start);
                //$response = $mail->send();
                //$end = date("Y-m-d H:i:s");
                //print_r('end: ' . $end);
            }
            $this->ConnectDB("nps_shared");
            $model = new MailScheduleModel();
            $model->insertBatch($data);
            // if (!$response) {

            //     return "Something went wrong. Please try again."; // . $mail->ErrorInfo;
            // } else {

            //     return "Email sent successfully.";
            // }
        } catch (Exception $e) {
            return "Something went wrong."; //. $mail->ErrorInfo;
        } finally {
            // $mail->SmtpClose();
        }
    }
    public function ScheduleMail($postdata, $userId, $emailList, $tenant)
    {
        $model = new ExternalcontactsModel();
        $contactlist = $model->whereIn('email_id', $emailList)->where('status', 1)->findAll();
        $contact = [];
        $response = false;
        $tenant_id = $tenant['tenant_id'];
        $survey_id = $postdata['survey'];
        $from_id = $postdata['From'];
        $from_name = $postdata['Name'];
        $data = [];

        $subject =  $postdata['subject'] ? $postdata['subject']  : "What did you think about NPS";


        for ($i = 0; $i < count($contactlist); $i++) {


            $contact = $contactlist[$i];
            $template = view("template/email-template-survey", ["userId" => $userId, "postdata" => $postdata, "contactdata" => $contact, "tenantdata" => $tenant]); //, "surveyrandom" => $surveyrandom]);

            $data[$i]['tenant_id'] = $tenant_id;
            $data[$i]['survey_id'] = $survey_id;
            $data[$i]['customer_id'] = $contact['id'];
            $data[$i]['customer_mail'] = $contact['email_id'];
            $data[$i]['subject'] = $subject;
            $data[$i]['from_id'] = $from_id;
            $data[$i]['from_name'] = $from_name;
            $data[$i]['mail'] = $template;
        }
        $this->ConnectDB("nps_shared");
        $model = new MailScheduleModel();
        $model->insertBatch($data);
        return "Mails are scheduled successfully, It will be send within 1 hr.";
    }
    public function createMailTemplate($postData, $userId)
    {
        $List = implode(', ', $postData["emailList"]);
        $model = new CreatecontactsModel();
        $data = [
            "subject" =>  $postData['subject'] ? $postData['subject']  : "What did you think about NPS",
            "survey_id" => $postData["survey"],
            "email_list" => $List,
            "message" => $postData["editor"],
            "user_id" => $userId
        ];
        $result = $model->insertBatch([$data]);
    }
    public function createMailTemplatesubTenant($postData, $userId, $tenant)
    {
        $dbname = "nps_" . $tenant['tenant_name'];
        //new DB creation for Tenant details
        $db = db_connect();
        $db->query('USE ' . $dbname);
        $List = implode(', ', $postData["emailList"]);
        $data = [
            "subject" =>   $postData['subject'] ? $postData['subject']  : "What did you think about NPS",
            "survey_id" => $postData["survey"],
            "email_list" => $List,
            "message" => $postData["editor"],
            "user_id" => $userId
        ];
        $key = array_keys($data);
        $values = array_values($data);
        $new_db_insert_user = "INSERT INTO " . $dbname . ".nps_email_send_list ( " . implode(',', $key) . ") VALUES('" . implode("','", $values) . "')";
        $db->query($new_db_insert_user);
    }
    public function getSurveyAnwser($email_Id, $survey_id, $userid, $tenantid) //, $randomKey)
    {

        if ($tenantid > 1) {
            $model = new TenantModel();
            $tenant = $model->where('tenant_id', $tenantid)->first();
            $dbname = "nps_" . $tenant['tenant_name'];

            $db = db_connect();
            $db->query('USE ' . $dbname);
            $multiClause = "SELECT * FROM " . $dbname . ".nps_external_contacts  WHERE `nps_external_contacts`.`id` = '" . $email_Id . "' "; //AND `nps_external_contacts`.`created_by` = '" . $userid . "'";
            $externalcount = $db->query($multiClause);
            if (count($externalcount->getRowArray()) > 0) {
                $externalList = $externalcount->getRowArray();
            }
            $isSurveyPresent = $this->CheckSurvey($survey_id);
            if ($isSurveyPresent) {
                $isResponse = $this->CheckResponse($externalList['email_id'], $survey_id);
            }
            $db->close();
        } else {
            $model = new ExternalcontactsModel();
            $multiClause = array('id' => $email_Id);
            $externalList = $model->where($multiClause)->first();
            $isSurveyPresent = $this->CheckSurvey($survey_id);
            if ($isSurveyPresent) {
                $isResponse = $this->CheckResponse($externalList['email_id'], $survey_id);
            }
        }
        if ($isSurveyPresent) {
            if (!$isResponse) {
                if ($tenantid > 1) {
                    $getSurveyData = $this->getcollectionsubtenant($email_Id, $survey_id, $userid, $tenantid); //, $randomKey);
                } else {
                    $getSurveyData = $this->getcollection($email_Id, $survey_id, $userid, $tenantid); //, $randomKey);
                }
                $data =  ["logo_user" => $getSurveyData['userData']['logo_update']];
                session()->set($data);
                return view('validateAnswer', ["getSurveyData" => $getSurveyData]); //, "randomKey" => $randomKey]);
            } else {
                $response = "Your survey feedback already added. Please check with Admin";
                session()->setFlashdata('response', $response);
                return view('thankyou');
            }
        }
        return view('Error');
    }
    public function getcollectionsubtenant($email_Id, $survey_id, $userid, $tenantid)
    {
        $model = new TenantModel();
        $tenant = $model->where('tenant_id', $tenantid)->first();
        $dbname = "nps_" . $tenant['tenant_name'];

        $model = new QuestionModel();
        $getquestion1 = $model->where('question_id', 1)->find();


        //new DB creation for Tenant details
        $db = db_connect();
        $db->query('USE ' . $dbname);
        $multiClause = "SELECT * FROM " . $dbname . ".nps_external_contacts  WHERE `nps_external_contacts`.`id` = '" . $email_Id . "'"; //AND `nps_external_contacts`.`created_by` = '" . $userid . "'";
        $externalcount = $db->query($multiClause);
        if (count($externalcount->getRowArray()) > 0) {
            $externalList = $externalcount->getRowArray();
        }
        $multiClause2 = "SELECT * FROM " . $dbname . ".nps_survey_details  WHERE `nps_survey_details`.`campaign_id` = '" . $survey_id . "'"; // AND `nps_survey_details`.`user_id` = '" . $userid . "'";
        $getSurveycount = $db->query($multiClause2);
        if (count($getSurveycount->getRowArray()) > 0) {
            $getSurvey = $getSurveycount->getRowArray();
        }
        //$multiClause3 ="SELECT * FROM ".$dbname.".nps_question_details  WHERE `nps_question_details`.`user_id` = '". $userid."' AND `nps_question_details`.`question_id` = '". $getSurvey['question_id_1']."'";
        //$multiClause3 ="SELECT * FROM ".$dbname.".nps_question_details  WHERE `nps_question_details`.`question_id` = '". $getSurvey['question_id_1']."'";

        //$getquestion1list = $db->query($multiClause3);
        // if(count($getquestion1list->getRowArray()) >0) {
        //     $getquestion1 = $getquestion1list->getRowArray();
        // }


        $multiClause5 = "SELECT * FROM " . $dbname . ".nps_users  WHERE `nps_users`.`id` = '" . $userid . "' AND `nps_users`.`tenant_id` = '" . $tenantid . "'";
        $getuserlist = $db->query($multiClause5);
        if (count($getuserlist->getRowArray()) > 0) {
            $user = $getuserlist->getRowArray();
        }
        //$db->close();
        $questioncollection = array();

        //bind the placeholder name
        $getquestion1[0]["question_name"] = str_replace("[Our Company/Product/Service Name]", $getSurvey["placeholder_name"], $getquestion1[0]["question_name"]);


        //array_merge($questioncollection, $getquestion1);

        $getSurveyData  = [
            "email_id" => $externalList['email_id'],
            "contactId" => $externalList['id'],
            "contactname" => $externalList['name'],
            "campaignId" => $getSurvey['campaign_id'],
            "campaignname" => $getSurvey['campaign_name'],
            "questionlist" => $getquestion1,
            "userData"  => $user,
            "tenantData" => $tenant
        ];
        return $getSurveyData;
    }
    public function getcollection($email_Id, $survey_id, $userid, $tenantid)
    {
        $model = new ExternalcontactsModel();
        $multiClause = array('id' => $email_Id);
        $externalList = $model->where($multiClause)->first();
        $model = new SurveyModel();
        $multiClause2 = array('campaign_id' => $survey_id);
        $getSurvey = $model->where($multiClause2)->first();
        $model = new QuestionModel();
        //$multiClause3 = array('user_id' => $userid,'question_id' => $getSurvey['question_id_1']);
        $multiClause3 = array('question_id' => $getSurvey['question_id_1']);
        $getquestion1 = $model->where($multiClause3)->first();
        $questioncollection = array();
        array_push($questioncollection, $getquestion1);
        $model = new UserModel();
        $multiClause5 = array('id' => $userid, 'tenant_id' => $tenantid);
        $user = $model->where($multiClause5)->first();
        $model = new TenantModel();
        $tenantDetails = $model->where('tenant_id',  $user['tenant_id'])->first();

        $getSurveyData  = [
            "email_id" => $externalList['email_id'],
            "contactId" => $externalList['id'],
            "contactname" => $externalList['name'],
            "campaignId" => $getSurvey['campaign_id'],
            "campaignname" => $getSurvey['campaign_name'],
            "questionlist" => $questioncollection,
            "userData"  => $user,
            "tenantData" => $tenantDetails
        ];
        return $getSurveyData;
    }
    public function randomSurvey()
    {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789"; //!@#$%&*";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
    public function createsurveyanswer()
    {
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'Answer_1' => 'required|numeric',
                'Answer_2' => 'required',
            ];
            $errors = [
                'Answer_1' => [
                    'required' => 'You must choose a first question.',
                ],
                'Answer_2' => [
                    'required' => 'You must choose an answer for second question.',
                ]
            ];

            if ($this->request->getPost('tenantid') > 1) {
                $getSurveyData = $this->getcollectionsubtenant($this->request->getPost('emailid'), $this->request->getPost('surveyid'), $this->request->getPost('userid'), $this->request->getPost('tenantid'));
            } else {
                $getSurveyData = $this->getcollection($this->request->getPost('emailid'), $this->request->getPost('surveyid'), $this->request->getPost('userid'), $this->request->getPost('tenantid'));
            }

            if (!$this->validate($rules, $errors)) {
                return view('validateAnswer', [
                    "validation" => $this->validator,
                    "getSurveyData" => $getSurveyData,
                    "randomKey" => $this->request->getPost("randomkey")
                ]);
            } else {

                $isResponse = $this->CheckResponse($getSurveyData['email_id'], $this->request->getPost("surveyid"));
                if (!$isResponse) {
                    $answer = array();
                    $answer2 = implode(",", $this->request->getPost("Answer_2"));
                    array_push($answer, $this->request->getPost("Answer_1"), $answer2);
                    $data = [
                        "campaign_id" => $this->request->getPost("surveyid"),
                        "email" => $getSurveyData['email_id'],
                        "user_id" => $this->request->getPost("userid"),
                        "question_id" => $this->request->getPost("question")[0],
                        "answer_id" => $answer[0],
                        "question_id2" => $this->request->getPost("question")[1],
                        "mail_status" => "",
                        "answer_id2" => $answer[1],
                        "ip_details" => getHostByName(getHostName()),
                        "location" => $this->GetLocation()
                    ];
                    $model = new SurveyResponseModel();
                    $result = $model->insertBatch([$data]);

                    $response = "Your survey feedback has been recorded.";
                } else {
                    $response = "Your survey feedback already added. Please check with Admin";
                }
                session()->setFlashdata('response', $response);
                return view('thankyou', ["getSurveyData" => $getSurveyData]);
            }
        }
    }

    public function GetLocation()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $ipdata = @json_decode(file_get_contents(
            "http://www.geoplugin.net/json.gp?ip=" . $ip
        ));

        $location = $ipdata->geoplugin_countryName ? $ipdata->geoplugin_countryName : "Local";
        return $location;
    }

    public function AnswerReponseforSubTenant($postdata, $data)
    {
        $model = new TenantModel();
        $tenant = $model->where('tenant_id', $postdata['tenantid'])->first();
        $dbname = "nps_" . $tenant['tenant_name'];
        $db = db_connect();
        $db->query('USE ' . $dbname);
        $key = array_keys($data);
        $values = array_values($data);
        $new_db_insert_user = "INSERT INTO " . $dbname . ".nps_survey_response ( " . implode(',', $key) . ") VALUES('" . implode("','", $values) . "')";
        $db->query($new_db_insert_user);
        $db->close();
    }
    public function getquestionnext()
    {
        $output = "Ajax request Success.";
        if ($this->request->isAJAX()) {
            $query = service('request')->getPost();
            $userId = $query['id'];
            $QandA1 = $query['QandA1'];
            $tenantId = $query['tenant'];
            $campaignId = $query['campaignId'];

            $questionId = null;
            $answer_id = "answer_id_";
            $answerList = [];
            $QandA2 = [];
            if ($QandA1 > 8) {
                $questionId = 2;
                $answer_id .= 2;
            } else if ($QandA1 < 9 && $QandA1 > 6) {
                $questionId = 3;
                $answer_id .= 3;
            } else {
                $questionId = 4;
                $answer_id .= 4;
            }
            $model = new TenantModel();
            $tenant = $model->where('tenant_id', $tenantId)->first();
            // if($tenantId==1) 
            // {
            //     $dbname = "nps_shared";
            // }
            // else
            // {
            //     $dbname = "nps_".$tenant['tenant_name'];
            // }
            // //new DB creation for Tenant details
            // $db = db_connect();
            // $db->query('USE '.$dbname);
            // //questionList
            // $questionQuery ="SELECT * FROM ".$dbname.".nps_question_details WHERE `question_id`=".$questionId;
            // $questionResult=$db->query($questionQuery)->getResultArray();
            $model = new QuestionModel();
            $questionResult = $model->where('question_id', $questionId)->find();
            $question = [];
            foreach ($questionResult as $key => $value) {
                $question["q_id"] = $value["question_id"];
                $question["q_name"] = $value["question_name"];
            }



            //new DB creation for Tenant details
            $db = db_connect();
            if ($tenantId == 1) {
                $dbname = "nps_shared";
            } else {
                $dbname = "nps_" . $tenant['tenant_name'];
            }
            $db->query('USE ' . $dbname);
            //answerIds
            $answerIdsQuery = "SELECT $answer_id FROM " . $dbname . ".nps_survey_details WHERE `campaign_id`=" . $campaignId;
            $answerIdsResult = $db->query($answerIdsQuery)->getResultArray();
            $answerIdsList = $answerIdsResult[0][$answer_id];
            $answerIdsarray = explode(",", $answerIdsList);

            //answerList
            $db->close();
            $answerListResult = array();
            $model = new AnswerListModel();
            $defaultAnswerList = $model->whereIn('answer_id', $answerIdsarray)->find();
            $final = array_merge($answerListResult, $defaultAnswerList);
            $db = db_connect();
            $db->query('USE ' . $dbname);
            $answerListQuery = "SELECT * FROM " . $dbname . ".`nps_answers_details` WHERE `answer_id` IN(" . $answerIdsList . ")";
            $tenantAnswerList = $db->query($answerListQuery)->getResultArray();
            $db->close();
            // if (count($tenantAnswerList) > 0) {
            //     array_merge($answerListResult, $tenantAnswerList);
            // }
            $answerListResult = array_merge($defaultAnswerList, $tenantAnswerList);
            foreach ($answerListResult as $key => $value) {
                $answerList[$value["answer_id"]] = $value["answer_name"];
            }

            $QandA2[0] = $question;
            $QandA2[1] = $answerList;

            echo json_encode(['success' => $output, 'csrf' => csrf_hash(), 'query' => $QandA2]);
        }
    }


    public function CheckResponse(string $email, int $campaignId)
    {
        $flag = false;

        $model = new SurveyResponseModel();
        $condition = ['email' => $email, 'campaign_id' => $campaignId];
        $returnkey = $model->where($condition)->first();

        $flag = $returnkey ? true : false;
        return $flag;
    }

    public function CheckSurvey(int $campaignId)
    {
        $flag = false;
        $model = new SurveyModel();
        $condition = ['campaign_id' => $campaignId, 'status' => '1'];
        $returnkey  = $model->where($condition)->first();
        $flag = $returnkey ? true : false;
        return $flag;
    }
    public function ConnectDB($db_name)
    {
        $db = db_connect();
        if ($db_name === null || trim($db_name) === '') {

            $model = new TenantModel();

            $tenant = $model->where('tenant_id', session()->get('tenant_id'))->first();
            $dbname = "nps_" . $tenant['tenant_name'];
            $db->query('USE ' . $dbname);
        } else {
            $db->query('USE ' . $db_name);
        }
    }

    public function SearchMails()
    {
        $db_name = "";
        $this->ConnectDB($db_name);
        $like = $this->request->getGet('like');
        $model = new ExternalcontactsModel();
        $selectArray = ['id', 'email_id', 'status'];
        $result = $model->select($selectArray)->where('status', 1)->like('email_id', $like)->findAll();


        $customerController = new CustomerController();
        $segments = $customerController->GetSegments($like);

        $data = ["status" => '1'];
        $combinedData = [];

        for ($i = 0; $i < count($segments); $i++) {
            # code...
            $combinedData[$i]['index'] = $i;
            $combinedData[$i]['id'] = $segments[$i]['segment_id'];
            $combinedData[$i]['name'] = $segments[$i]['segment_name'];
            $combinedData[$i]['status'] = 0;
            $combinedData[$i]['count'] = $segments[$i]['total_count'];
        }
        $count = count($combinedData);
        for ($i = 0; $i < count($result); $i++) {
            # code...
            $count++;
            $combinedData[$count]['index'] = $i;
            $combinedData[$count]['id'] = $result[$i]['id'];
            $combinedData[$count]['name'] = $result[$i]['email_id'];
            $combinedData[$count]['status'] = $result[$i]['status'];
        }



        echo json_encode(['success' => true, 'csrf' => csrf_hash(), 'output' => $combinedData]);
    }
}
