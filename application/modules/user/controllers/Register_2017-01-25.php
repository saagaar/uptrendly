<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// require_once FCPATH.'vendor/autoload.php';
// require_once __DIR__ . '/vendor/Facebook/autoload.php';

// require(APPPATH.'vendor/fb_persistent_data_interface.php');
class Register extends CI_Controller {

    function __construct() {
        parent::__construct();
     

        //load custom language library

        if (SITE_STATUS == '2') {
            redirect(site_url('/offline'));
            exit;
        } else if (SITE_STATUS == '3') {
            //check whetheh logged in or not. if logged in as maintaince user, let them visit site. else redirect to maintainance page
            if (!$this->session->userdata('MAINTAINANCE_KEY') == 'YES' OR $this->session->userdata('MAINTAINANCE_KEY') != 'YES') {
                redirect(site_url('/maintainance'));
                exit;
            }
        }
        // if ($this->session->userdata(SESSION . 'user_id')) {
        //     redirect(site_url(''));
        //     exit;
        // }

        //check banned IP address
        $this->general->check_banned_ip();

        $this->load->helper('captcha');
        $this->load->helper('cookie');
        $this->load->library('form_validation');
        $this->load->library('antispam');
        
        $this->load->model('register_model');
        $this->load->library('Twitter'); 
        //$this->load->model('login_module');
        $this->form_validation->set_error_delimiters('<span generated="true" class="text-danger">', '</span>');

        //load mailchimp library
        // $this->load->library('mailchimp_library');
    }

//     public function index() {
        
//     }


//     public function email_taken() {
//         $email = trim($this->input->post('email'));
//         // if the username exists return a 1 indicating true
//         $result = $this->register_model->email_exists($email);
//         if ($result) {
//             echo "This Email already exists.";
//             return TRUE;
//         } else {
//             return FALSE;
//         }
//     }

    public function check_email_availability() {
        //exit if the request is not ajax
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $email = trim($this->input->post('email'));
        // if the username exists return a 1 indicating true
        $result = $this->register_model->email_exists($email);
        if (count($result)>0) {
            echo 'taken';
        } else {
            echo 'available';
        }
    }

//     public function check_username_availability() {
//         //exit if the request is not ajax
//         if (!$this->input->is_ajax_request()) {
//             exit('No direct script access allowed');
//         }
//         $username = trim($this->input->post('username'));
//         // if the username exists return a 1 indicating true
//         $result = $this->register_model->username_exists($username);
//         if ($result) {
//             echo 'taken';
//         } else {
//             echo 'available';
//         }
//     }

     // buyer registration
    public function brand() {
        $email=$this->input->post('email',true);
        //set validation rules
        $this->form_validation->set_rules($this->register_model->validate__brand_regisration);
        if ($this->form_validation->run() === TRUE) {
            $activation_code = $this->register_model->insert_brand();
            if ($activation_code != 'system_error') {
                // if email activation is enabled from backend
                if (NEED_USER_ACTIVATION == '1') {
                    // send activation mail
                    $data['userinfo']['email']=$email;
                    $this->register_model->reg_confirmation_email($data,$activation_code);
                    $this->session->set_userdata('registration_success','Registration Success');
                    redirect(site_url('/user/register/registration_error'));
                } else {
                    $user_id = $this->register_model->user_id;
                    $this->register_model->reg_complete_email();
                    $login_status = $this->general->check_login_process($this->input->post("email"), $this->input->post('password'));
                    $this->session->set_flashdata('success_message', 'Registration sucessful.');
                    redirect(site_url(MY_ACCOUNT . 'brand'), 'refersh');
                }
            } else {
                $this->session->set_flashdata('error_message', 'Unable to complete request due to system error. Please try Again.');
                redirect(site_url('/user/register/brand'), 'refersh');
            }
        }
        $this->data['terms_condition'] = $this->general->get_cms_details(6);
        $this->data['meta_keys'] = WEBSITE_NAME;
        $this->data['meta_desc'] = WEBSITE_NAME;
        $this->page_title = WEBSITE_NAME . ' - Buyer Registration';
        $this->template
                ->set_layout('general')
                ->enable_parser(FALSE)
                ->title($this->page_title)
                ->build('v_brand_registration', $this->data);
    }

    // supplier registration
    public function creator() {
        $fburl='';
        $relogin='';
        $this->load->library('Facebook');
        $this->load->library('Instagrams');
        $this->load->library('Google');
         // $this->session->sess_destroy(); 
         $this->load->library('Twitter');
        
      if((defined('FACEBOOK_APP_KEY') && defined('FACEBOOK_APP_SECRET')))
            $fburl=$this->facebook->login_url();    
        else 
            $fburl='#';
     if((defined('INSTAGRAM_APP_KEY') && defined('INSTAGRAM_APP_SECRET')))
                $insurl=$this->instagrams->login_url();
      else
       $insurl='#';
    if((defined('YOUTUBE_APP_KEY') && defined('YOUTUBE_APP_SECRET')))
                $yturl=$this->google->login_url();
      else
       $yturl='#';
      if((defined('TWITTER_APP_KEY') && defined('TWITTER_APP_SECRET')))
                $twurl=$this->twitter->getLoginUrl();
      else 
        $twurl='#';
      if((defined('VINE_APP_KEY') && defined('VINE_APP_SECRET')))
            // $vnurl=$this->facebook->login_url();    
            $vine_url='#';
        else 
            $vine_url='#';
        if((defined('TUMBLR_APP_KEY') && defined('TUMBLR_APP_SECRET')))
            // $vnurl=$this->facebook->login_url();    
            $tm_url='#';
        else 
            $tm_url='#';

        $this->data['terms_condition'] = $this->general->get_cms_details(6);
        $this->data['fb_url']=$fburl;
        $this->data['tw_url']=$twurl;
        $this->data['ins_url']=$insurl;
        $this->data['yt_url']=$yturl;
        $this->data['vine_url']=$vine_url;
        $this->data['tm_url']=$tm_url;
        $this->data['relogin']=$relogin;
        $this->data['meta_keys'] = WEBSITE_NAME;
        $this->data['meta_desc'] = WEBSITE_NAME;
        $this->page_title = WEBSITE_NAME . ' - Supplier Registration';
        $this->template
                ->set_layout('general')
                ->enable_parser(FALSE)
                ->title($this->page_title)
                ->build('v_creator_registration', $this->data);
            // }

    }
    public function signup_facebook()
    {
        $this->load->library('Facebook');
        $access_token=$this->facebook->is_authenticated();
        if($access_token)
        {
          $registrationstatus=false;
           //for user is logged in as creator indicated user is already inserted with one social media
           if(($this->session->userdata(SESSION.'user_id'))  && ($this->session->userdata(SESSION.'usertype')=='4') )
          {
              $me=$this->facebook->request('GET','/me?fields=id,name,first_name,email,permissions',$access_token);
              $primary_media=$this->general->get_single_row('socialmedia_settings',array('media_type'=>'facebook'));  
              $isregistered=$this->general->get_single_row('member_socialmedia',array('socialmedia_id'=>$me['id'],'media_type_id'=>$primary_media->id));
              //since user is registered already he cannot login with same social media account so we update the data for change
              if(count($isregistered)>0)
              {
                        $this->session->set_userdata('pageid',$isregistered->page_id);
                        $this->session->set_userdata('access_token',$access_token);
                        $getaccountslike=$this->facebook->request('GET','/'.$isregistered->page_id.'?fields=fan_count',$access_token);
                        $this->session->set_userdata('page_likes',$getaccountslike['fan_count']);
                         //pass member_socialmedia id as parameter to update the settings   
                        $this->save_registration_creator_facebook($isregistered->id);
              }
              /*current social media is not registered but user is logged in so we insert this media as secondary social media */
              else
              {
                       $userid=$this->session->userdata(SESSION.'user_id');
                       $page=$this->facebook->request('GET','/me/accounts/',$access_token);
                       foreach($page['data'] as  $detail)
                        {  
                             $id=($detail['id']);
                             $name=$detail['name'];
                             $getaccountslike=$this->facebook->request('GET','/'.$id.'?fields=fan_count',$access_token);
                             if($getaccountslike['fan_count']>=FACEBOOK_LEAST_FAN_COUNT)
                             {
                                  $profile=$this->facebook->request('GET','/me',$access_token);
                                  $this->session->set_userdata('pageid',$id);
                                  $this->session->set_userdata('page_likes',$getaccountslike['fan_count']);
                                  $this->session->set_userdata('access_token',$detail['access_token']);

                                  $registrationstatus=1;
                                  $validname=$detail['name'];
                                  $validid=$detail['id'];
                                  $validlike=$getaccountslike['fan_count'];
                                  break;
                            }
                        }
                          if($registrationstatus)
                           {
                               // $this->load->view('user/v_signup_form_creator');
                               $this->session->set_userdata('popup_media','enable');
                               $this->session->set_userdata('media_action','save_registration_creator_facebook');
                               $redirect=$this->session->userdata('redirecturi');
                               $this->add_facebook_secondary_media();
                               $this->session->set_flashdata('success','You have been linked to Facebook');
                               redirect(site_url('/'.$redirect), 'refersh');
                             
                             }
                          else
                            {
                                  $redirect=$this->session->userdata('redirecturi');
                                  $this->session->set_userdata('popup_media','enable');
                                  $this->session->set_flashdata('error','You need a facebook account with page more then 500 likes');
                                   redirect(site_url('/'.$redirect), 'refersh');
                                
                            }
                  }
          }
          else
          {
              $me=$this->facebook->request('GET','/me?fields=id,name,first_name,email,permissions',$access_token);
              $primary_media=$this->general->get_single_row('socialmedia_settings',array('media_type'=>'facebook'));  
              $isregistered=$this->general->get_single_row('member_socialmedia',array('socialmedia_id'=>$me['id'],'media_type_id'=>$primary_media->id));
               /*user is already inserted into our system redirect to login screen to login*/  
              if(count($isregistered)>0)
              {
                    $this->session->set_flashdata('error_message', 'You are already registered.Please login');
                     $this->facebook->destroy_session();
                     $this->facebook->logout_url();
                     redirect(site_url('user/login'), 'refersh');
                     exit;

              }
             /*user is not logged in with any creator account and the social media id is not registered we insert the account as primary account*/
              else
              {
                    
                     //if email is not given permission the user is reallowed with warning to relogin url
                       if(!isset($me['email']))
                       {
                            foreach($me['permissions']['data'] as $value)
                            {
                                if($value['permission']=='email' && $value['status']=='declined' ){
                                    // $me=$this->facebook->request('GET','/me?fields=id,name,first_name,email,permissions',$access_token);
                                     $relogin=$this->facebook->relogin_url(array('email'));
                                
                                }
                            }
                       }else
                       {

                              $me_email=$me['email'];
                              $page=$this->facebook->request('GET','/me/accounts/',$access_token);
                              foreach($page['data'] as  $detail)
                              {
                                    $id=($detail['id']);
                                    $name=$detail['name'];
                                    $getaccountslike=$this->facebook->request('GET','/'.$id.'?fields=fan_count',$access_token);

                                    if($getaccountslike['fan_count']>=FACEBOOK_LEAST_FAN_COUNT)
                                    {
                                      $profile=$this->facebook->request('GET','/me',$access_token);
                                      $this->session->set_userdata('pageid',$id);
                                      $this->session->set_userdata('page_likes',$getaccountslike['fan_count']);
                                      $this->session->set_userdata('access_token',$detail['access_token']);

                                      $registrationstatus=1;
                                      $validname=$detail['name'];
                                      $validid=$detail['id'];
                                      $validlike=$getaccountslike['fan_count'];
                                      break;
                                    }
                              }
                               if($registrationstatus)
                               {
                                 // $this->load->view('user/v_signup_form_creator');
                                  $this->session->set_userdata('popup_media','facebook');
                                  $this->session->set_userdata('media_action','save_registration_creator_facebook');
                                  redirect(site_url('user/register/registration_popup'), 'refersh');
                                  // exit;
                                // Echo 'You are registered.Please login';
                                // redirect('/login'); 
                               }else
                               {
                                    $this->session->set_userdata('registration_error','Facebook');
                                     redirect(site_url('/user/register/registration_error'));
                               }
                        } 
              }
              //if user is registered he cannot login with same social media account
          }

        } 
    }
    
    public function signup_instagram(){
         $this->load->library('Instagrams');
         $access_token=$this->instagrams->is_authenticated();
        if($access_token)
        {
           $registrationstatus=false;
           $user=$this->instagrams->request('getUser',false);
           $primary_media=$this->general->get_single_row('socialmedia_settings',array('media_type'=>'instagram')); 
           $isregistered=$this->general->get_single_row('member_socialmedia',array('socialmedia_id'=>$user->data->id,'media_type_id'=>$primary_media->id));

           //for user is logged in as creator indicated user is already inserted with one social media
           if(($this->session->userdata(SESSION.'user_id'))  && ($this->session->userdata(SESSION.'usertype')=='4') )
            {
                   
                  /* since user is registered already he cannot login with same social media account so we update the data for change */
                    if(count($isregistered)>0)
                    {
                         $this->session->set_userdata('user_followers',$user->data->counts->followed_by);
                         $this->session->set_userdata('access_token',$access_token);
                        /* pass member_socialmedia id as parameter to update the data */
                        $this->save_registration_creator_instagram($isregistered->id);
                    }
                    else
                    {
                      /* current social media is not registered but user is logged in so we insert this media as secondary social media */    
                       if($user->data->counts->followed_by>INSTAGRAM_FAN_COUNT)
                          {

                              $id=$user->data->id;
                              $this->session->set_userdata('popup_media','enable');
                              $redirect=$this->session->userdata('redirecturi');
                              $this->session->set_userdata('media_action','save_registration_creator_instagram');
                              $this->session->set_userdata('user_followers',$user->data->counts->followed_by);
                              $this->session->set_userdata('access_token',$access_token);
                              $this->add_instagram_secondary_media();
                               $this->session->set_flashdata('success','You have been linked to Instagram');
                               redirect(site_url('/'.$redirect), 'refersh');
                          }
                          else
                          {
                              $this->session->set_userdata('registration_error','Instagram');
                               redirect(site_url('/user/register/registration_error'));
                          }    

                    }
            }
            //user is not logged in 
           else
            {
                   /*user is already inserted into our system redirect to login screen to login*/
                    if(count($isregistered)>0)
                    {
                          $this->session->set_flashdata('error_message', 'You are already registered.Please login');
                           $this->session->sess_destroy();
                           redirect(site_url('user/login'), 'refersh');
                           exit;

                    }
                    /*user is not logged in with any creator account and the social media id is not registered we insert the account as primary account*/
                    else
                    {
                        if($user->data->counts->followed_by>INSTAGRAM_FAN_COUNT)
                          {
                              $id=$user->data->id;
                              $this->session->set_userdata('user_followers',$user->data->counts->followed_by);
                              $this->session->set_userdata('access_token',$access_token);
                              $this->session->set_userdata('popup_media','instagram');
                              $this->session->set_userdata('media_action','save_registration_creator_instagram');
                              redirect(site_url('user/register/registration_popup'), 'refersh');
                          }
                          else
                          {
                              $this->session->set_userdata('registration_error','Instagram');
                               redirect(site_url('/user/register/registration_error'));
                          } 
                    }
            }         
        }
        else
        {
              $this->session->set_userdata('registration_error','Instagram');
              redirect(site_url('/user/register/registration_error'));
        }
    }

    public function signup_twitter()
    {               
        $access_token=  $this->twitter->is_authenticated();
        $userid=$access_token['user_id'];
        if($access_token['oauth_token'])
        {
             $registrationstatus=false;
             $user=$this->twitter->twaccount_verify_credentials();
             $primary_media=$this->general->get_single_row('socialmedia_settings',array('media_type'=>'twitter'));
             $isregistered=$this->general->get_single_row('member_socialmedia',array('socialmedia_id'=>$userid,'media_type_id'=>$primary_media->id));
              //for user is logged in as creator indicated user is already inserted with one social media
              if(($this->session->userdata(SESSION.'user_id'))  && ($this->session->userdata(SESSION.'usertype')=='4') )
              {
                  /* since user is registered already he cannot login with same social media account so we update the data for change */
                  if(count($isregistered)>0)
                  {
                     $this->session->set_userdata('user_followers',$user->data->counts->followed_by);
                     $this->session->set_userdata('access_token',$access_token);
                    //pass member_socialmedia id as parameter to update the settings
                     $this->save_registration_creator_twitter($isregistered->id);
                  }
                  else
                  {
                    /* current social media is not registered but user is logged in so we insert this media as secondary social media */  
                     if($user->followers_count>TWITTER_FAN_COUNT)
                      {
                          $id=$user->data->id;
                          $this->session->set_userdata('popup_media','enable');
                          $redirect=$this->session->userdata('redirecturi');      
                          $this->session->set_userdata('user_followers',$user->followers_count);
                          $this->session->set_userdata('access_token',$access_token['oauth_token']);
                          $this->session->set_userdata('popup_media','twitter');
                          $this->session->set_userdata('media_action','save_registration_creator_twitter');
                          $this->add_twitter_secondary_media();
                          redirect(site_url('/'.$redirect), 'refersh');
                      }     
                      else
                      {
                          $this->session->set_userdata('registration_error','Twitter');
                           redirect(site_url('/user/register/registration_error'));
                      } 

                  }
              }
                //user is not logged in 
              else
              {
                  if(count($isregistered)>0)
                  {
                        $this->session->set_flashdata('error_message', 'You are already registered.Please login');
                         $this->session->sess_destroy();
                         redirect(site_url('user/login'), 'refersh');
                         exit;

                  }
                   /*user is not logged in with any creator account and the social media id is not registered we insert the account as primary account*/
                  else
                  {
                      if($user->followers_count>TWITTER_FAN_COUNT)
                      {
                          $id=$user->data->id;
                          $this->session->set_userdata('user_followers',$user->followers_count);
                          $this->session->set_userdata('access_token',$access_token['oauth_token']);
                          $this->session->set_userdata('popup_media','twitter');
                          $this->session->set_userdata('media_action','save_registration_creator_twitter');
                          redirect(site_url('user/register/registration_popup'), 'refersh');
                      }
                      else
                      {
                          $this->session->set_userdata('registration_error','Twitter');
                           redirect(site_url('/user/register/registration_error'));
                      } 
                  }
              }
        }
             
    }
    public function signup_youtube()
    {  
    
        $this->load->library('Google');

        $access_token=$this->google->is_authenticated();
        if($access_token)
        {
           /*Initializing various youtube objects*****/
                
                $ytobj=$this->google->youtubeobj(); 
                $gobj=$this->google->googleoauthobj();
                
                /*get google channel info from its object*/
                $data= $this->google->getChannelinfo($ytobj);
                /*get google user info from its object gobj*/
                $userinfo= $this->google->getUserinfo($gobj);
                 $socialmedia_id= ($userinfo->id);
                 $subscribercount=($data['0']['statistics']->subscriberCount);
                 $primary_media=$this->general->get_single_row('socialmedia_settings',array('media_type'=>'youtube'));
                 $socialmedia_id= ($userinfo->id);
                 $subscribercount=($data['0']['statistics']->subscriberCount);
                 $primary_media=$this->general->get_single_row('socialmedia_settings',array('media_type'=>'youtube'));
            /*for user is logged in as creator indicated user is already inserted with one social media*/
            if(($this->session->userdata(SESSION.'user_id'))  && ($this->session->userdata(SESSION.'usertype')=='4') )
            { 
                 $isregistered=$this->general->get_single_row('member_socialmedia',array('socialmedia_id'=>$socialmedia_id,'media_type_id'=>$primary_media->id));
                  /* since user is registered already he cannot login with same social media account so we update the data for change */
                 if(count($isregistered)>0)
                  {
                         $this->session->set_userdata('user_subscribers',$subscribercount);
                         $this->session->set_userdata('access_token',$access_token['access_token']);
                          /* pass member_socialmedia id as parameter to update the data */
                         $this->save_registration_creator_youtube($isregistered->id);
                  }
                  else
                  {
                     /* current social media is not registered but user is logged in so we insert this media as secondary social media*/    
                         if($subscribercount>1)
                            {

                                $this->session->set_userdata('popup_media','enable');
                                $redirect=$this->session->userdata('redirecturi');
                                $this->session->set_userdata('media_action','save_registration_creator_youtube');
                                $this->session->set_userdata('subscribercount',$subscribercount);
                                $this->session->set_userdata('access_token',$access_token);
                                $this->add_youtube_secondary_media();
                                $this->session->set_flashdata('success','You have been linked to Youtube');
                                redirect(site_url('/'.$redirect), 'refersh');
                            }
                            else
                            {
                                $this->session->set_userdata('registration_error','Youtube');
                                redirect(site_url('/user/register/registration_error'));
                            }    
                  }
            }
            else
            {   
                 $isregistered=$this->general->get_single_row('member_socialmedia',array('socialmedia_id'=>$socialmedia_id,'media_type_id'=>$primary_media->id));
                
                     /*user is already inserted into our system redirect to login screen to login*/
                      if(count($isregistered)>0)
                      {
                             $this->session->set_flashdata('error_message', 'You are already registered.Please login');
                             $this->session->sess_destroy();
                             redirect(site_url('user/login'), 'refersh');
                             exit;

                      }
                      /*user is not logged in with any creator account and the social media id is not registered we insert the account as primary account*/
                      else
                      {
                          if($subscribercount>1)
                            {
                                $id=$socialmedia_id;
                                $this->session->set_userdata('user_subscribers',$subscribercount);
                                $this->session->set_userdata('access_token',$access_token['access_token']);
                                $this->session->set_userdata('popup_media','youtube');
                                $this->session->set_userdata('media_action','save_registration_creator_youtube');
                                redirect(site_url('user/register/registration_popup'), 'refersh');
                            }
                            else
                            {
                                $this->session->set_userdata('registration_error','Instagram');
                                 redirect(site_url('/user/register/registration_error'));
                            } 
                      }
            }

        }
       
       
    }
    public function save_registration_creator_facebook($id=false)
    {   
        $this->load->library('Facebook');
        $access_token=$this->facebook->is_authenticated();
        if($access_token)
        {     
            if(!$id)
            {
                //when user is not registered insert the data to database
               $this->form_validation->set_rules($this->register_model->validate_signup_creator);
              if ($this->form_validation->run() === TRUE) {
                    $page_id=$this->session->userdata('pageid');
                    $this->facebook->add_to_batch_pool('userinfo','GET','/me?fields=name,email,location,gender',[],$access_token);
                    $this->facebook->add_to_batch_pool('pageinfo','GET','/'.$page_id.'?fields=name,id,access_token',[],$access_token);
               
                    $data=$this->facebook->send_batch_pool();
                    $access_token=$this->session->userdata('access_token');
                    $data['picture']='00123456789_profiledefault';
                    $data['ratings']=0;
                    // $engageduser= $this->facebook->request('GET','/'.$page_id.'/insights/page_engaged_users/',$access_token);
                    $rate= $this->facebook->request('GET','/'.$page_id.'/ratings?fields=rating',$data['pageinfo']['access_token']);
                    $picture=$this->facebook->request('GET','me?fields=picture.width(400).height(400)',[],$access_token);
                     if(count($picture['picture'])>0)
                        $data['picture']=$picture['picture']['data']['url']; 
                    if(count($rate['data'])>0)
                        $data['ratings']=$rate['data']['0']['rating'];
                    
                      $activation_code=$this->register_model->insert_member_fb($data,'creator');
                      if($activation_code)
                      {
                            $this->session->set_userdata('registration_success','Registration Success');
                            $this->register_model->reg_confirmation_email($data,$activation_code);
                            $this->facebook->destroy_session();
                            redirect(site_url('/user/register/registration_error'));
                      }    
                }
                else{
                    //error validation when registeration
                      $this->session->set_userdata('popup_media','facebook');
                      $this->session->set_userdata('media_action','save_registration_creator_facebook');
                      $this->registration_popup();
                } 
            }
            else{
                   // When user is already logged in sync facebook current data to database
                    $page_id=$this->session->userdata('pageid');
                    $this->facebook->add_to_batch_pool('userinfo','GET','/me?fields=name,email,location,gender,picture?type=large',[],$access_token);
                    $this->facebook->add_to_batch_pool('pageinfo','GET','/'.$page_id.'?fields=name,id,access_token',[],$access_token);
                   
                    $data=$this->facebook->send_batch_pool();
                   
                    $rate= $this->facebook->request('GET','/'.$page_id.'/ratings?fields=rating',$data['pageinfo']['access_token']);
                    $data['ratings']=$rate['data']['0']['rating'];
                    $access_token=$this->session->userdata('access_token');
                    // $engageduser= $this->facebook->request('GET','/'.$page_id.'/insights/page_engaged_users/',$access_token);
                     $response=$this->register_model->insert_member_fb($data,'creator',$id);
                  
                    $this->facebook->destroy_session();
                    echo 'success to update';
            }
        }  
    }
    public function add_facebook_secondary_media()
    {
        $this->load->library('Facebook');
        $access_token=$this->facebook->is_authenticated();
        if($access_token)
        {
            $page_id=$this->session->userdata('pageid');
            $this->facebook->add_to_batch_pool('userinfo','GET','/me?fields=name,email,location,gender,picture?type=large',[],$access_token);
            $this->facebook->add_to_batch_pool('pageinfo','GET','/'.$page_id.'?fields=name,id,access_token',[],$access_token);
            $data=$this->facebook->send_batch_pool();
            // $pagetoken
            $access_token=$this->session->userdata('access_token');
            // $engageduser= $this->facebook->request('GET','/'.$page_id.'/insights/page_engaged_users/',$access_token);
            $rate= $this->facebook->request('GET','/'.$page_id.'/ratings?fields=rating',$data['pageinfo']['access_token']);
            if(($rate)) $data['ratings']=$rate['data']['0']['rating'];
            else $data['ratings']='0';
            $response=$this->register_model->insert_secondary_media_facebook($data);
            return $response;
        }
    }
    
    public function save_registration_creator_instagram($id=false)
     {
        $this->load->library('Instagrams');
        $access_token=$this->instagrams->is_authenticated();
        if($access_token)
        { 
            if(!$id)
            {
                     $this->form_validation->set_rules($this->register_model->validate_signup_creator);
                 if ($this->form_validation->run() === TRUE) {
                     $data['user']=$this->instagrams->request('getUser',false);

                      $activation_code=$this->register_model->insert_member_insta($data);
                      if($activation_code)
                      {
                            $this->session->set_userdata('registration_success','Registration Success');
                            $this->register_model->reg_confirmation_email($data,$activation_code);
                            redirect(site_url('/user/register/registration_error'));
                      }    
                }
                else{
                      $this->session->set_userdata('popup_media','instagram');
                      $this->session->set_userdata('media_action','save_registration_creator_instagram');
                      $this->registration_popup();
                }

           }  
          else
          {

                $data['user']=$this->instagrams->request('getUser',false);
                $access_token=$this->session->userdata('access_token');
                $response=$this->register_model->insert_member_insta($data,$id);
                 if($response) echo 'update success';
          }
            
        }
        
    }

    public function add_instagram_secondary_media()
    {
        $this->load->library('Instagrams');
        $access_token=$this->instagrams->is_authenticated();
        if($access_token)
        {
              $data['user']=$this->instagrams->request('getUser',false);
              $response=$this->register_model->insert_secondary_media_instagram($data);
              if($response)
              {
                  $this->session->set_userdata('registration_success','Registration Success');
                  return $response;
              }     
        }
    }
    public function save_registration_creator_youtube($id=false)
    {

        $this->load->library('Google');
        $access_token=$this->google->is_authenticated();
        if(count($access_token)>1)
        { 
            if(!$id)
            {

                 $this->form_validation->set_rules($this->register_model->validate_signup_creator);
                 if ($this->form_validation->run() === TRUE) {
                      $analyticsobj=$this->google->analyticsobj();
          
                      $optparams = array('dimensions'=>'country',
                                    'filters'=>'channel==MINE'
                                );
                      $metric = 'views';

                      $countrywiseviews=$this->google->getanalyticsreport($analyticsobj,$metric,$optparams);
                      $params = array('dimensions'=>'ageGroup,gender',
                                       'filters'=>'channel==MINE',
                                       'sort' =>'gender,ageGroup'
                                      );
                      $metric = 'viewerPercentage';
                      $agegroupgender=$this->google->getanalyticsreport($analyticsobj,$metric,$params);
        
                      $gobj=$this->google->googleoauthobj();
                      $ytobj=$this->google->youtubeobj(); 
                      $data['userinfo']= $this->google->getUserinfo($gobj);
                      $data['statistics']= $this->google->getChannelinfo($ytobj);
                      $data['countrywiseviews']=$countrywiseviews;
                      $data['agegroupgender']=$agegroupgender;
                    // $userinfo
                      $activation_code=$this->register_model->insert_member_youtube($data);
                      if($activation_code)
                      {
                            $this->session->unset_userdata('registration_error');
                            $this->session->set_userdata('registration_success','Registration Success');
                            $this->register_model->reg_confirmation_email($data,$activation_code);
                            redirect(site_url('/user/register/registration_error'));
                      }    
                }
                else{
                      $this->session->set_userdata('popup_media','youtube');
                      $this->session->set_userdata('media_action','save_registration_creator_youtube');
                      $this->registration_popup();
                }

            }  
            else{
                $gobj=$this->google->googleoauthobj();
                $data['userinfo']= $this->google->getUserinfo($gobj);
                $access_token=$this->session->userdata('access_token');
                $analyticsobj=$this->google->analyticsobj();
                      $optparams = array('dimensions'=>'country',
                                    'filters'=>'channel==MINE'
                                );
                      $metric = 'views';
                      $countrywiseviews=$this->google->getanalyticsreport($analyticsobj,$metric,$optparams);
                      $params = array('dimensions'=>'ageGroup,gender',
                                       'filters'=>'channel==MINE',
                                       'sort' =>'gender,ageGroup'
                                      );
                      $metric = 'viewerPercentage';
                      $agegroupgender=$this->google->getanalyticsreport($analyticsobj,$metric,$params);
                      $data['countrywiseviews']=$countrywiseviews;
                      $data['agegroupgender']=$agegroupgender;
                $response=$this->register_model->insert_member_youtube($data,$id);
                 if($response) echo 'update success';
            }
            
        }
        
    }
    public function add_youtube_secondary_media()
    {
        $this->load->library('Instagrams');
        $access_token=$this->instagrams->is_authenticated();
        if($access_token)
        {
                $gobj=$this->google->googleoauthobj();
                $data['userinfo']= $this->google->getUserinfo($gobj);
                $access_token=$this->session->userdata('access_token');
                $analyticsobj=$this->google->analyticsobj();
                $optparams = array('dimensions'=>'country',
                              'filters'=>'channel==MINE'
                          );
                $metric = 'views';
                $countrywiseviews=$this->google->getanalyticsreport($analyticsobj,$metric,$optparams);
                $params = array('dimensions'=>'ageGroup,gender',
                                 'filters'=>'channel==MINE',
                                 'sort' =>'gender,ageGroup'
                                );
                $metric = 'viewerPercentage';
                $agegroupgender=$this->google->getanalyticsreport($analyticsobj,$metric,$params);
                $data['countrywiseviews']=$countrywiseviews;
                $data['agegroupgender']=$agegroupgender;
           
                $response=$this->register_model->insert_secondary_media_youtube($data);
                if($response)
                {
                    $this->session->set_userdata('registration_success','Registration Success');
                    return $response;
                }     
        }
    }

    public function save_registration_creator_twitter($id=false)
    {
        $this->load->library('twitter');
        $access_token=$this->twitter->is_authenticated();
        if($access_token['oauth_token'])
        { 
            if(!$id)
            {
                     $this->form_validation->set_rules($this->register_model->validate_signup_creator);
                 if ($this->form_validation->run() === TRUE) {
                      $data['user']=$this->twitter->twaccount_verify_credentials();
                      $activation_code=$this->register_model->insert_member_twitter($data);
                      if($activation_code)
                      {
                            $this->session->set_userdata('registration_success','Registration Success');
                            $this->register_model->reg_confirmation_email($data,$activation_code);
                            redirect(site_url('/user/register/registration_error'));
                      }    
                }
                else{
                      $this->session->set_userdata('popup_media','twitter');
                      $this->session->set_userdata('media_action','save_registration_creator_twitter');
                      $this->registration_popup();
                }

            }  
            else
            {

                $data['user']=$this->instagrams->request('getUser',false);
                $access_token=$this->session->userdata('access_token');
                $response=$this->register_model->insert_member_insta($data,$id);
                 if($response) echo 'update success';
            }
            
        }
        
    }
    public function add_twitter_secondary_media()
    {
        $this->load->library('twitter');
          $access_token=$this->twitter->is_authenticated();
        if($access_token['oauth_token'])
        { 
             $data['user']=$this->twitter->twaccount_verify_credentials();
             $response=$this->register_model->insert_secondary_media_twitter($data);
              if($response)
              {
                  $this->session->set_userdata('registration_success','Registration Success');
                  return $response;
              }     
        }
    }



    public function success() {
    echo 'Twitter connect succeded<br/>';
    echo '<p><a href="' . base_url() . 'twtest/clearsession">Do it again!</a></p>';

    $this->load->library('twconnect');

    // saves Twitter user information to $this->twconnect->tw_user_info
    // twaccount_verify_credentials returns the same information
    $this->twconnect->twaccount_verify_credentials();

    echo 'Authenticated user info ("GET account/verify_credentials"):<br/><pre>';
    print_r($this->twconnect->tw_user_info); echo '</pre>';
        
    }

    public function registration_error(){
    $error=$this->session->userdata('registration_error');
    $success=$this->session->userdata('registration_success');
    if((!$error) && (!$success))
        redirect (site_url(''));
        $this->data['meta_keys'] = WEBSITE_NAME;
        $this->data['meta_desc'] = WEBSITE_NAME;
        $this->page_title = WEBSITE_NAME . ' -  Registration';
        $this->template
                ->set_layout('general')
                ->enable_parser(FALSE)
                ->title($this->page_title)
                ->build('v_registration_error', $this->data);
  }

   public function registration_popup(){
        if(($this->session->userdata('popup_media')))
        {
             $popupmedia=$this->session->userdata('popup_media');
             $action=$this->session->userdata('media_action');
             $this->session->unset_userdata('popup_media');
             $this->session->unset_userdata('media_action');
             $this->data['meta_keys'] = WEBSITE_NAME;
                         $this->data['meta_desc'] = WEBSITE_NAME;
                         $this->data['media']=$popupmedia;
                         $this->data['action']=$action;
                         $this->page_title = WEBSITE_NAME . ' - Supplier Registration';
                         $this->template
                        ->set_layout('general')
                        ->enable_parser(FALSE)
                        ->title($this->page_title)
                        ->build('v_signup_form_creator', $this->data);
        }
         
    }
    //     // member activation function
    public function activation($activation_code, $user_id) {
        if (!isset($user_id) OR $user_id == '') {
            redirect(site_url('/'));
        }
        if (!isset($activation_code) OR $activation_code == '') {
            redirect(site_url('/'));
        }

        $user_type_data = $this->general->fetch_members_selected_fields(array('user_type'), array('id' => $user_id));

        // set member validation settings for user
        // if ($user_type_data->user_type == '3') {
        //     $this->general->set_member_validity_settings_buyer($user_id);
        // } else if ($user_type_data->user_type == '4') {
        //     $this->general->set_member_validity_settings_supplier($user_id);
        // }

        $activation_status = $this->register_model->check_user_activation($activation_code, $user_id);
        //echo var_dump($activation_status); exit;

        if ($activation_status == TRUE) {
            $cms_id = 11;
        } else {
            $cms_id = 12;
        }

        $this->data['cms'] = $this->general->get_cms_details($cms_id);
        // $this->register_model->reg_complete_email();
        //getting seo data for register
        $seo_data = $this->general->get_seo(1);
        if ($seo_data) {
            //set SEO data
            $this->page_title = $seo_data->page_title;
            $this->data['meta_keys'] = $seo_data->meta_key;
            $this->data['meta_desc'] = $seo_data->meta_description;
        } else {
            //set SEO data
            $this->page_title = WEBSITE_NAME;
            $this->data['meta_keys'] = WEBSITE_NAME;
            $this->data['meta_desc'] = WEBSITE_NAME;
        }


        $this->template
                ->set_layout('general')
                ->enable_parser(FALSE)
                ->title($this->page_title)
                ->build('v_cms_data', $this->data);
    }

//     public function check_validuser($str) {

//         if (preg_match('/^[a-zA-Z0-9_]+$/', $str) === 0) {
//             $this->form_validation->set_message('check_validuser', 'The username field is not valid!');
//             return false;
//         } else {
//             return true;
//         }
//     }

    /* authentication un-successful */
    public function logout() {

        $this->session->sess_destroy();
        redirect(site_url('user/register/creator'));
    }

  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */