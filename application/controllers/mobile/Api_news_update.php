<?php
defined('BASEPATH') or exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *'); // for allow any domain, insecure
header('Access-Control-Allow-Headers: *'); // for allow any headers, insecure
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE'); // method allowed

require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;

class Api_news_update extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mobile/api_news_update_model');
    }

    public function add_news_post()
    {
        $error = '';
        $success = '';

        $encodedData = file_get_contents('php://input');
        $decodedData = json_decode($encodedData, true);

        //Attachment
        if (!empty($decodedData['attachment'])) {
            $base64Data = $decodedData['attachment'];
            
            // Detect the file type from the base64 string
            if ($decodedData['attachment_type'] == 'video') {
                // Handle video file
                $base64Data = preg_replace('/^data:video\/(mp4|webm|ogg);base64,/', '', $base64Data);
                $binaryData = base64_decode($base64Data);
                $extension = '.mp4';
                $uploadPath = 'assets/uploaded_file/news/';
            } else {
                // Handle image file
                $base64Data = preg_replace('/^data:image\/(png|jpeg|jpg|gif);base64,/', '', $base64Data);
                $binaryData = base64_decode($base64Data);
                $extension = '.jpg';
                $uploadPath = 'assets/uploaded_file/news/';
            }
    
            if ($binaryData !== false) {
                $dt = date('His');
                $filename = 'news_' . rand(10000, 99999) . '_' . $dt . $extension;
                file_put_contents($uploadPath . $filename, $binaryData);
            } else {
                $filename = '';
            }
        } else {
            $filename = '';
        }


        $insert_news = [
            'user_id'       => $decodedData['user_id'],
            'caption'       => $decodedData['content'],
            'attachment'    => $filename,
            'attachment_type' => $decodedData['attachment_type'],
            'date_created'  => date('Y-m-d H:i:s'),
        ];

        $result = $this->api_news_update_model->insert_news($insert_news);
        if ($result == TRUE) {
            $success = 'News posted successfully.';
        } else {
            $error = 'Failed to post a news.';
        }

        $output = [
            'success' => $success,
            'error' => $error,
        ];
        $this->response($output, RestController::HTTP_OK);
    }

    public function add_comment_post()
    {
        $error = '';
        $success = '';

        $encodedData = file_get_contents('php://input');
        $decodedData = json_decode($encodedData, true);

        $insert_comment = [
            'news_id'       => $decodedData['news_id'],
            'user_id'       => $decodedData['user_id'],
            'posted_by'     => $decodedData['posted_by'],
            'comment'       => $decodedData['comment'],
            'date_created'  => date('Y-m-d H:i:s'),
        ];
        $result = $this->api_news_update_model->add_news_comment($insert_comment);
        if ($result == TRUE) {
            $success = 'Comment posted successfully.';
        } else {
            $error = 'Failed to post a comment.';
        }

        $output = [
            'success' => $success,
            'error' => $error,
        ];
        $this->response($output, RestController::HTTP_OK);
    }

    public function posted_news_get()
    {
        $newsArray = array();

        $news = $this->api_news_update_model->get_all_news();

        foreach($news as $list) {

            $attachment = '';
            if(!empty($list->attachment)){
                if(file_exists('./assets/uploaded_file/news/'.$list->attachment)){
                    $attachment = base_url()."assets/uploaded_file/news/".$list->attachment;
                }
            }

            $img = base_url()."assets/images/admin/profile.png";
            if(!empty($list->selfie_img)){
                if(file_exists('./assets/uploaded_file/member_application/selfie_img/'.$list->selfie_img)){
                    $img = base_url()."assets/uploaded_file/member_application/selfie_img/".$list->selfie_img;
                }
            }


            $newsArray[] = array(
                'posted_by'     => ucwords($list->posted_name),
                'date_posted'   => date('M D j, Y h:i A', strtotime($list->date_created)),
                'content'       => $list->caption,
                'attachment'    => $attachment,
                'member_no'     => $list->member_no,
                'profile_pic'   => $img,
                'news_id'       => $list->news_id,
            );
        }

        $output = [
            'postedNews' => $newsArray,
        ];
        $this->response($output, RestController::HTTP_OK);
    }

    public function list_comment_get()
    {
        //http://127.0.0.1/gpi-web/api/comment-list?news_id=0
        $news_id = $this->input->get('news_id', true);

        $comment = $this->api_news_update_model->get_comment_list($news_id);
        $commentArray = array();

        foreach($comment as $list) {
            $commentArray[] = array(
                'comment_id'    => $list->comment_id,
                'user_id'       => $list->user_id,
                'posted_by'     => ucwords($list->member_name),
                'comment'       => $list->comment,
                'date_comment'  => date('D M j, Y h:i A', strtotime($list->date_created)),
            );
        }

        $output = array(
            'commentData' => $commentArray,
        );
        $this->response($output, RestController::HTTP_OK);
    }

    public function delete_news_post()
    {
        $error = '';
        $success = '';

        $encodedData = file_get_contents('php://input');
        $decodedData = json_decode($encodedData, true);

        $news_id = $decodedData['news_id'];

        $delete_news = [
            'is_deleted' => 'YES',
            'date_deleted' => date('Y-m-d H:i:s'),
        ];

        $result = $this->api_news_update_model->delete_news($delete_news, $news_id);
        if ($result == TRUE) {
            $success = 'News successfully deleted.';
        } else {
            $error = 'Failed to delete the news.';
        }

        $output = [
            'success' => $success,
            'error' => $error,
        ];
        $this->response($output, RestController::HTTP_OK);
    }

    public function delete_comment_post()
    {
        $error = '';
        $success = '';

        $encodedData = file_get_contents('php://input');
        $decodedData = json_decode($encodedData, true);

        $comment_id = $decodedData['comment_id'];

        $delete_comment = [
            'is_deleted' => 'YES',
            'date_deleted' => date('Y-m-d H:i:s'),
        ];

        $result = $this->api_news_update_model->delete_news_comment($delete_comment, $comment_id);
        if ($result == TRUE) {
            $success = 'Comment successfully deleted.';
        } else {
            $error = 'Failed to delete the comment.';
        }

        $output = [
            'success' => $success,
            'error' => $error,
        ];
        $this->response($output, RestController::HTTP_OK);
    }

}