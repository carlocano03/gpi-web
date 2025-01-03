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

}