<?php defined('BASEPATH') OR exit('No direct script access allowed');
 /**
  * Author @sagar
  * This class overwrites the native yt session by codeigniter session in yt sdk
  */

      
  
class Google{

    // const UPLOAD_TYPE_VIDEO = 'video';
    // const UPLOAD_TYPE_IMAGE = 'image';
    
    // private $permissions=array('email','user_hometown','user_about_me','user_location','read_insights');
    /**
     * @var client
     */
    private $client;

    private $youtube;
    /**
     * Google constructor.
     */
    public function __construct()
    {
        if((defined('YOUTUBE_APP_KEY') && defined('YOUTUBE_APP_SECRET')))
       {
          
        if (!isset($this->client))
        {
              $this->client = new Google_Client;
              $this->client->setClientId(YOUTUBE_APP_KEY);
              $this->client->setClientSecret(YOUTUBE_APP_SECRET);
              $this->client->addScope("https://www.googleapis.com/auth/youtube");
              $this->client->setAccessType("offline"); 
              $this->client->setRedirectUri(YOUTUBE_APP_REDIRECT_URI);
          }
       
          $this->youtube = new Google_Service_YouTube($this->client);
        if(isset($_GET['code'])) {
        if (strval( $this->session->userdata('yt_state')) !== strval($_GET['state'])) {
               die('The session state did not match.');
         }
         $this->client->authenticate($_GET['code']);
         $this->session->set_userdata('yt_access_token',$this->client->getAccessToken());
         header('Location: ' . filter_var(YOUTUBE_APP_REDIRECT_URI, FILTER_SANITIZE_URL));exit;
        }
        
    }
    
    }
    public function youtubeobj()
    {
         return $this->youtube;
    }
      /**
     * @return FB
     */
    public function object()
    {
        return $this->client;
    }

     /**
     * Check if user are logged in by checking if we have a Facebook
     * session active.
     *
     * @return mixed|boolean
     */
    public function is_authenticated()
    {
        $access_token = $this->authenticate();

        if (isset($access_token))
        {
            return $access_token;
        }

        return false;
    }

     private function authenticate()
    {
        $access_token = $this->get_access_token();

        if ($access_token && $this->get_expire_time() > (time() + 30) || $access_token && !$this->get_expire_time())
        {
            $this->set_access_token($access_token);
            $this->client->setAccessToken($access_token);
            return $access_token;
        }

        // // If we did not have a stored access token or if it has expired, try get a new access token
        if (!$access_token)
        {
            try
            {
                $access_token = $this->client->getAccessToken();
                $this->set_expire_time($access_token->getExpiresAt());
                $this->set_access_token($access_token);
                return $access_token;
            }
            catch (OAuthException $e)
            {
                $this->logError($e->getCode(), $e->getMessage());
                return null;
            }

            
        }


        return $access_token;
    }

   function getChannelLocalization( Google_Service_YouTube $youtube,$channelId=false,$language=false) {
  // Call the YouTube Data API's channels.list method to retrieve channels.
  $channelsResponse = $youtube->subscriptions->listSubscriptions('snippet', array(
  'mySubscribers' => 'true',
));
  // echo '<pre>';
  // print_r($channelsResponse);
    }
    /**
     * Do Graph request
     *
     * @param       $method
     * @param       $endpoint
     * @param array $params
     * @param null  $access_token
     *
     * @return array
     */
    // public function request($method, $endpoint, $params = [], $access_token = null)
    // {
    //     try
    //     {
    //         $response = $this->client->{strtolower($method)}($endpoint, $params, $access_token);
    //         return $response->getDecodedBody();
    //     }
    //     catch(FacebookResponseException $e)
    //     {
    //         return $this->logError($e->getCode(), $e->getMessage());
    //     }
    //     catch (FacebookSDKException $e)
    //     {
    //         return $this->logError($e->getCode(), $e->getMessage());
    //     }
    // }

    /**
     * Upload image or video to user profile
     *
     * @param        $path_to_file
     * @param array  $params
     * @param string $type
     * @param null   $access_token
     *
     * @return array
     */
    // public function user_upload_request($path_to_file, $params = [], $type = self::UPLOAD_TYPE_IMAGE, $access_token = null)
    // {
    //     if ($type === self::UPLOAD_TYPE_IMAGE)
    //     {
    //         $data = ['source' => $this->client->fileToUpload($path_to_file)] + $params;
    //         $endpoint = '/me/photos';
    //     }
    //     elseif ($type === self::UPLOAD_TYPE_VIDEO)
    //     {
    //         $data = ['source' => $this->client->videoToUpload($path_to_file)] + $params;
    //         $endpoint = '/me/videos';
    //     }
    //     else
    //     {
    //         return $this->logError(400, 'Invalid upload type');
    //     }

    //     try
    //     {
    //         $response = $this->client->post($endpoint, $data, $access_token);
    //         return $response->getDecodedBody();
    //     }
    //     catch(FacebookSDKException $e)
    //     {
    //         return $this->logError($e->getCode(), $e->getMessage());
    //     }
    // }
    //  /**
    //  * Add request to batch
    //  *
    //  * @param       $key
    //  * @param       $method
    //  * @param       $endpoint
    //  * @param array $params
    //  * @param null  $access_token
    //  */
    // public function add_to_batch_pool($key, $method, $endpoint, $params = [], $access_token = null)
    // {
    //     $this->batch_request_pool = array_merge(
    //         $this->batch_request_pool,
    //         [$key => $this->client->request($method, $endpoint, $params, $access_token)]
    //     );
    // }

    // /**
    //  * Remove request from batch
    //  *
    //  * @param $key
    //  */
    // public function remove_from_batch_pool($key)
    // {
    //     if (isset($this->batch_request_pool[$key]))
    //     {
    //         unset($this->batch_request_pool[$key]);
    //     }
    // }

    // /**
    //  * Send all request in the batch pool
    //  *
    //  * @return array|FacebookBatchResponse
    //  */
    // public function send_batch_pool()
    // {
    //     try
    //     {
    //         $responses = $this->client->sendBatchRequest($this->batch_request_pool);
    //         $this->batch_request_pool = [];

    //         $data = [];
    //         foreach ($responses as $key => $response)
    //         {
    //             $data[$key] = $response->getDecodedBody();
    //         }

    //         return $data;
    //     }
    //     catch(FacebookResponseException $e)
    //     {
    //         return $this->logError($e->getCode(), $e->getMessage());
    //     }
    //     catch(FacebookSDKException $e)
    //     {
    //         return $this->logError($e->getCode(), $e->getMessage());
    //     }
    // }
    

    /**
     * Generate Facebook login url for Facebook Redirect Login (web)
     *
     * @return  string
     */
    public function login_url()
    {
       
        return $this->client->createAuthUrl();
    }
    //  public function relogin_url($permissions)
    // {
    //     // Login type must be web, else return empty string
    //     if (FACEBOOK_LOGIN_TYPE != 'web')
    //     {
    //         return '';
    //     }

    //     return $this->helper->getReRequestUrl(
    //         FACEBOOK_APP_REDIRECT_URI,
    //         $this->permissions
    //     );
    // }


    /**
     * Generate Facebook login url for Facebook Redirect Login (web)
     *
     * @return string
     * @throws FacebookSDKException
     */
    public function logout_url()
    {
      
        // Create logout url
        // return $this->helper->getLogoutUrl(
        //     $this->get_access_token(),
        //     FACEBOOK_LOGOUT_REDIRECT_URI
        // );
    }

    /**
     * Destroy our local Facebook session
     */
    public function destroy_session()
    {
        $this->session->unset_userdata('yt_access_token');
    }


    /**
     * Get stored access token
     *
     * @return mixed
     */
    private function get_access_token()
    {
        return $this->session->userdata('yt_access_token');
    }

    /**
     * Store access token
     *
     * @param AccessToken $access_token
     */
    private function set_access_token($access_token)
    {
        $this->session->set_userdata('yt_access_token', $access_token);
    }

    /**
     * @return mixed
     */
    private function get_expire_time()
    {
        return $this->session->userdata('yt_expire');
    }

    /**
     * @param DateTime $time
     */
    private function set_expire_time(DateTime $time = null)
    {
        if ($time) {
            $this->session->set_userdata('yt_expire', $time->getTimestamp());
        }
    }

    // private function long_lived_token($access_token)
    // {
    //       if (!$access_token->isLongLived())
    //     {
    //         $oauth2_client = $this->client->getOAuth2Client();

    //         try
    //         {
    //             return $oauth2_client->getLongLivedAccessToken($access_token);
    //         }
    //         catch (FacebookSDKException $e)
    //         {
    //             $this->logError($e->getCode(), $e->getMessage());
    //             return null;
    //         }
    //     }

    //     return $access_token;

    // }

    /**
     * @param $code
     * @param $message
     *
     * @return array
     */
    private function logError($code, $message)
    {
        log_message('error', '[Google PHP SDK] code: ' . $code.' | message: '.$message);
        return ['error' => $code, 'message' => $message];
    }

    /**
     * Enables the use of CI super-global without having to define an extra variable.
     * I can't remember where I first saw this, so thank you if you are the original author.
     *
     * Borrowed from the Ion Auth library (http://benedmunds.com/ion_auth/)
     *
     * @param $var
     *
     * @return mixed
     */
    public function __get($var)
    {
        return get_instance()->$var;
    }



}