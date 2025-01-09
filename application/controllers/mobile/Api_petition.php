<?php
defined('BASEPATH') or exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *'); // for allow any domain, insecure
header('Access-Control-Allow-Headers: *'); // for allow any headers, insecure
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE'); // method allowed

require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;

class Api_petition extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mobile/api_petition_model');
    }

    public function create_petition_post()
    {
        $error = '';
        $success = '';

        $encodedData = file_get_contents('php://input');
        $decodedData = json_decode($encodedData, true);

        $dt = Date('His');

        // Attachment
        if (!empty($decodedData['supporting_document'])) {
            $base64DataDocument = $decodedData['supporting_document'];
            $base64DataDocument = preg_replace('/^data:image\/(png|jpeg|jpg|gif);base64,/', '', $base64DataDocument);
            $binaryDataDocument = base64_decode($base64DataDocument);

            if ($binaryDataDocument !== false) {
                $filename = strtoupper($decodedData['petition_title']);
                $filenameDocument = str_replace(' ', '_', $filename) .'document' . rand(10000, 99999) . $dt . '.jpg';
                $uploadPathDocument = 'assets/uploaded_file/supporting_document/';
                file_put_contents($uploadPathDocument . $filenameDocument, $binaryDataDocument);
            } else {
                $filenameDocument = '';
            }
        } else {
            $filenameDocument = '';
        }

        $insert_petition = [
            'petition_title'        => $decodedData['petition_title'],
            'petition_description'  => $decodedData['petition_description'],
            'created_by'            => $decodedData['user_id'],
            'province'              => $decodedData['province'],
            'municipality'          => $decodedData['municipality'],
            'barangay'              => $decodedData['barangay'],
            'petition_remarks'      => 'For Approval',
            'category'              => $decodedData['category'],
            'supporting_document'  => $filenameDocument,
            'date_created'          => date('Y-m-d H:i:s'),
        ];

        $result = $this->api_petition_model->insert_new_petition($insert_petition);
        if ($result == TRUE) {
            $success = 'Petition successfully submitted.';
        } else {
            $error = 'Failed to submit the petition.';
        }
        $output = [
            'success' => $success,
            'error' => $error,
        ];
        $this->response($output, RestController::HTTP_OK);
    }

    public function petition_list_get()
    {
        //http://127.0.0.1/gpi-web/api/petition-list?user_id=0
        $user_id = $this->input->get('user_id', true);

        $petition = $this->api_petition_model->get_petition_list($user_id);
        $petitionArray = array();

        foreach($petition as $list) {

            if ($list->supporting_documents != '') {
                if ((file_exists('assets/uploaded_file/supporting_document/'.$list->supporting_documents))) {
                    $supporting_documents = base_url('assets/uploaded_file/supporting_document/'.$list->supporting_documents);
                } else {
                    $supporting_documents = '';
                }
            } else {
                $supporting_documents = '';
            }

            $total_petition_yes = $this->api_petition_model->get_total_community_petition($list->petition_id, 'YES');
            $total_petition_no = $this->api_petition_model->get_total_community_petition($list->petition_id, 'NO');

            $petitionArray[] = array(
                'petition_id'       => $list->petition_id,
                'petition_title'    => $list->petition_title,
                'petition_description'  => $list->petition_description,
                'petition_remarks'  => $list->petition_remarks,
                'category'          => $list->category,
                'supporting_documents'   => $supporting_documents,
                'total_yes'         => $total_petition_yes->total_count,
                'total_no'          => $total_petition_no->total_count,
                'date_created'      => date('D M j, Y h:i A', strtotime($list->date_created)),
            );
        }

        $output = array(
            'petitionList' => $petitionArray,
        );
        $this->response($output, RestController::HTTP_OK);
    }

    public function delete_petition_post()
    {
        $error = '';
        $success = '';

        $encodedData = file_get_contents('php://input');
        $decodedData = json_decode($encodedData, true);

        $petition_id = $decodedData['petition_id'];

        $update_petition = [
            'is_deleted'  => 'YES',
            'date_deleted'  => date('Y-m-d H:i:s'),
        ];
        $result = $this->api_petition_model->petition_approval_process($update_petition, $petition_id);
        if ($result == TRUE) {
            $success = 'Petition request successfully approved.';
        } else {
            $error = 'Failed to approve the petition.';
        }

        $output = array(
            'success' => $success,
            'error' => $error,
        );
        $this->response($output, RestController::HTTP_OK);
    }

    public function view_petition_get()
    {
        //http://127.0.0.1/gpi-web/api/view-petition?petition_id=0
        $petition_id = $this->input->get('petition_id', true);

        $petition = $this->api_petition_model->get_petition_info($petition_id);
        $total_petition_yes = $this->api_petition_model->get_total_community_petition($petition_id, 'YES');
        $total_petition_no = $this->api_petition_model->get_total_community_petition($petition_id, 'NO');

        if ($petition) {
            if ($petition->supporting_documents != '') {
                if ((file_exists('assets/uploaded_file/supporting_document/'.$petition->supporting_documents))) {
                    $supporting_documents = base_url('assets/uploaded_file/supporting_document/'.$petition->supporting_documents);
                } else {
                    $supporting_documents = '';
                }
            } else {
                $supporting_documents = '';
            }
        } else {
            $supporting_documents = '';
        }
        
        $petitionData = array(
            'petition_id'           => $petition_id,
            'petition_title'        => $petition->petition_title ?? '',
            'petition_description'  => $petition->petition_description ?? '',
            'petition_remarks'      => $petition->petition_remarks ?? '',
            'category'              => $petition->category ?? '',
            'supporting_documents'  => $supporting_documents,
            'total_yes'             => $total_petition_yes->total_count ?? '',
            'total_no'              => $total_petition_no ?? '',
            'date_created'          => date('D M j, Y h:i A', strtotime($petition->date_created)),
        );

        $output = array(
            'petitionData' => $petitionData,
        );

        $this->response($output, RestController::HTTP_OK);
    }

    //==========================BOARD MEMBER SIDE===========================
    public function petition_list_approval_get()
    {
        //http://127.0.0.1/gpi-web/api/petition-approval

        $petition = $this->api_petition_model->get_petition_list_approval();
        $petitionArray = array();

        foreach($petition as $list) {

            if ($list->supporting_documents != '') {
                if ((file_exists('assets/uploaded_file/supporting_document/'.$list->supporting_documents))) {
                    $supporting_documents = base_url('assets/uploaded_file/supporting_document/'.$list->supporting_documents);
                } else {
                    $supporting_documents = '';
                }
            } else {
                $supporting_documents = '';
            }

            $petitionArray[] = array(
                'petition_id'       => $list->petition_id,
                'petition_title'    => $list->petition_title,
                'petition_description'  => $list->petition_description,
                'petition_remarks'  => $list->petition_remarks,
                'category'          => $list->category,
                'supporting_documents'   => $supporting_documents,
                'created_by'        => ucwords($list->created_by),
                'designation'       => $list->name_type,
                'province'          => $list->province,
                'municipality'      => $list->municipality,
                'barangay'          => $list->barangay,
                'residence_address' => ucwords($list->residence_address),
                'date_created'      => date('D M j, Y h:i A', strtotime($list->date_created)),
            );
        }

        $output = array(
            'approvalList' => $petitionArray,
        );
        $this->response($output, RestController::HTTP_OK);
    }

    public function view_petition_approval_get()
    {
        //http://127.0.0.1/gpi-web/api/view-petition-approval?petition_id=0
       $petition_id = $this->input->get('petition_id', true);

       $petition = $this->api_petition_model->get_petition_approval_info($petition_id);

       if ($petition) {
           if ($petition->supporting_documents != '') {
               if ((file_exists('assets/uploaded_file/supporting_document/'.$petition->supporting_documents))) {
                   $supporting_documents = base_url('assets/uploaded_file/supporting_document/'.$petition->supporting_documents);
               } else {
                   $supporting_documents = '';
               }
           } else {
               $supporting_documents = '';
           }
       } else {
           $supporting_documents = '';
       }
       
       $petitionData = array(
           'petition_id'           => $petition_id,
           'petition_title'        => $petition->petition_title ?? '',
           'petition_description'  => $petition->petition_description ?? '',
           'petition_remarks'      => $petition->petition_remarks ?? '',
           'category'              => $petition->category ?? '',
           'supporting_documents'  => $supporting_documents,
           'created_by'            => isset($petition->created_by) ? ucwords($petition->created_by) : '',
           'designation'           => $petition->name_type ?? '',
           'province'              => $petition->province ?? '',
           'municipality'          => $petition->municipality ?? '',
           'barangay'              => $petition->barangay ?? '',
           'residence_address'     => isset($petition->residence_address) ? ucwords($petition->residence_address) : '',
           'date_created'          => isset($petition->date_created) ? date('D M j, Y h:i A', strtotime($petition->date_created)) : '',
       );

       $output = array(
           'petitionDataApproval' => $petitionData,
       );

       $this->response($output, RestController::HTTP_OK);
    }

    public function petition_approval_post()
    {
        $error = '';
        $success = '';

        $encodedData = file_get_contents('php://input');
        $decodedData = json_decode($encodedData, true);

        $petition_id = $decodedData['petition_id'];
        $user_id = $decodedData['user_id'];
        $action = $decodedData['action']; //Approve or Decline

        if ($action == 'Approve') {
            $update_petition = [
                'petition_remarks'  => 'Approved',
                'approved_by'       => $user_id,
            ];
            $result = $this->api_petition_model->petition_approval_process($update_petition, $petition_id);
            if ($result == TRUE) {
                $success = 'Petition request successfully approved.';
            } else {
                $error = 'Failed to approve the petition.';
            }
        } else {
            //Declined
            $update_petition = [
                'petition_remarks'  => 'Declined',
                'approved_by'       => $user_id,
            ];
            $result = $this->api_petition_model->petition_approval_process($update_petition, $petition_id);
            if ($result == TRUE) {
                $success = 'Petition request successfully declined.';
            } else {
                $error = 'Failed to decline the petition.';
            }
        }

        $output = array(
            'success' => $success,
            'error' => $error,
        );
        $this->response($output, RestController::HTTP_OK);
    }
    //==========================END OF BM SIDE==============================
    
    //==========================MEMBER SIDE===========================
    public function brgy_petition_get()
    {
        //http://127.0.0.1/gpi-web/api/barangay-petition?brgy=0

        $brgy_code = $this->input->get('brgy');
        $petition = $this->api_petition_model->get_barangay_petition($brgy_code);
        $petitionArray = array();

        foreach($petition as $list) {

            if ($list->supporting_documents != '') {
                if ((file_exists('assets/uploaded_file/supporting_document/'.$list->supporting_documents))) {
                    $supporting_documents = base_url('assets/uploaded_file/supporting_document/'.$list->supporting_documents);
                } else {
                    $supporting_documents = '';
                }
            } else {
                $supporting_documents = '';
            }

            $total_petition_yes = $this->api_petition_model->get_total_community_petition($list->petition_id, 'YES');
            $total_petition_no = $this->api_petition_model->get_total_community_petition($list->petition_id, 'NO');

            $petitionArray[] = array(
                'petition_id'       => $list->petition_id,
                'petition_title'    => $list->petition_title,
                'petition_description'  => $list->petition_description,
                'petition_remarks'  => $list->petition_remarks,
                'category'          => $list->category,
                'supporting_documents'   => $supporting_documents,
                'total_yes'         => $total_petition_yes->total_count,
                'total_no'          => $total_petition_no->total_count,
                'date_created'      => date('D M j, Y h:i A', strtotime($list->date_created)),
            );
        }

        $output = array(
            'petitionBarangay' => $petitionArray,
        );
        $this->response($output, RestController::HTTP_OK);
    }

    public function view_petition_barangay_get()
    {
        //http://127.0.0.1/gpi-web/api/view-petition?petition_id=0&member_id=0
        $petition_id = $this->input->get('petition_id', true);
        $member_id = $this->input->get('member_id', true);

        $petition = $this->api_petition_model->get_petition_info($petition_id);
        $total_petition_yes = $this->api_petition_model->get_total_community_petition($petition_id, 'YES');
        $total_petition_no = $this->api_petition_model->get_total_community_petition($petition_id, 'NO');
        $check_member = $this->api_petition_model->check_member_sign($petition_id, $member_id);

        if ($petition) {
            if ($petition->supporting_documents != '') {
                if ((file_exists('assets/uploaded_file/supporting_document/'.$petition->supporting_documents))) {
                    $supporting_documents = base_url('assets/uploaded_file/supporting_document/'.$petition->supporting_documents);
                } else {
                    $supporting_documents = '';
                }
            } else {
                $supporting_documents = '';
            }
        } else {
            $supporting_documents = '';
        }

        if ($check_member->num_rows() > 0) {
            $info = $check_member->row();
            $remarks = 'Already Signed';
            $date_signed = date('D M j, Y h:i A', strtotime($info->date_created));
        } else {
            $remarks = '';
            $date_signed = '';
        }
        
        $petitionData = array(
            'petition_id'           => $petition_id,
            'petition_title'        => $petition->petition_title ?? '',
            'petition_description'  => $petition->petition_description ?? '',
            'petition_remarks'      => $petition->petition_remarks ?? '',
            'category'              => $petition->category ?? '',
            'supporting_documents'  => $supporting_documents,
            'total_yes'             => $total_petition_yes->total_count ?? '',
            'total_no'              => $total_petition_no ?? '',
            'remarks'               => $remarks,
            'date_signed'           => $date_signed,
            'date_created'          => date('D M j, Y h:i A', strtotime($petition->date_created)),
        );

        $output = array(
            'petitionDataBarangay' => $petitionData,
        );

        $this->response($output, RestController::HTTP_OK);
    }

    public function signature_process_post()
    {
        $error = '';
        $success = '';
        $encodedData = file_get_contents('php://input');
        $decodedData = json_decode($encodedData, true);
        $dt = Date('His');

        // Signature
        if (!empty($decodedData['signature'])) {
            $base64DataSignature = $decodedData['signature'];
            $base64DataSignature = preg_replace('/^data:image\/(png|jpeg|jpg|gif);base64,/', '', $base64DataSignature);
            $binaryDataSignature = base64_decode($base64DataSignature);

            if ($binaryDataSignature !== false) {
                $filename = $decodedData['first_name'] . '_sign' . rand(10000, 99999) . '_' . $dt . '.png';
                $uploadPath = 'assets/uploaded_file/member_application/signature/';
                file_put_contents($uploadPath . $filename, $binaryDataSignature);
            } else {
                $filename = '';
            }
        } else {
            $filename = '';
        }
        // End of Signature

        $petition_id = $decodedData['petition_id'];
        $member_id = $decodedData['member_id'];
        $action = $decodedData['action']; //Agree and Disagree
        
        $check_member = $this->api_petition_model->check_member_sign($petition_id, $member_id);
        if ($check_member->num_rows() > 0) {
            $error = 'Exist';
        } else {
            if ($action == 'Agree') {
                $insert_signature = [
                    'petition_id'           => $petition_id,
                    'member_id'             => $member_id,
                    'signature'             => $filename,
                    'petition_remarks'      => 'Agree',
                    'reason_supporting'     => $decodedData['reason_supporting'],
                    'additional_comment'    => $decodedData['additional_comment'],
                    'date_created'          => date('Y-m-d H:i:s'),
                ];
                $result = $this->api_petition_model->insert_community_petition($insert_signature);
                if ($result == TRUE) {
                    $success = 'Your response is successfully submitted.';
                } else {
                    $error = 'Failed to submit the response.';
                }
            } else {
                //Disagree
                $insert_signature = [
                    'petition_id'           => $petition_id,
                    'member_id'             => $member_id,
                    'signature'             => $filename,
                    'petition_remarks'      => 'Disagree',
                    'date_created'          => date('Y-m-d H:i:s'),
                ];
                $result = $this->api_petition_model->insert_community_petition($insert_signature);
                if ($result == TRUE) {
                    $success = 'Your response is successfully submitted.';
                } else {
                    $error = 'Failed to submit the response.';
                }
            }
        }

        $output = array(
            'error' => $error,
            'success' => $success,
        );
        $this->response($output, RestController::HTTP_OK);
    }
    //==========================END OF MEMBER SIDE==============================

}