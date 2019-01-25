<?php defined('BASEPATH') OR exit('No direct script access allowed');
 /**
  * Author @sagar
  * This class overwrites the native fb session by codeigniter session in fb sdk
  */
 use Facebook\PersistentData\CustomPersistentDataHandler;
      
   use Facebook\FacebookRequest;
class Facebook{

    const UPLOAD_TYPE_VIDEO = 'video';
    const UPLOAD_TYPE_IMAGE = 'image';
    
    private $permissions=array('email','user_hometown','user_about_me','user_location','read_insights','user_photos','manage_pages','user_posts');
    /**
     * @var FB
     */
    private $fb;

    /**
     * @var FacebookRedirectLoginHelper|FacebookCanvasHelper|FacebookJavaScriptHelper|FacebookPageTabHelper
     */
    private $helper;

    /**
     * @var array
     */
    private $batch_request_pool = [];

    /**
     * Facebook constructor.
     */
    public function __construct()
    {
        if((defined('FACEBOOK_APP_KEY') && defined('FACEBOOK_APP_SECRET')))
       {
             define('FACEBOOK_LOGIN_TYPE','web');
        if (!isset($this->fb))
        {
            $this->fb = new Facebook\Facebook([
                'app_id'                => FACEBOOK_APP_KEY,
                'app_secret'            => FACEBOOK_APP_SECRET,
                'default_graph_version' => 'v2.7',
                'persistent_data_handler' => new CustomPersistentDataHandler(),//fb sdk uses native session this function is used to rewrite fb session with codeigniter session for session ussage

            ]);
          }
         switch (FACEBOOK_LOGIN_TYPE)
        {
            case 'js':
                $this->helper = $this->fb->getJavaScriptHelper();
                break;

            case 'canvas':
                $this->helper = $this->fb->getCanvasHelper();
                break;

            case 'page_tab':
                $this->helper = $this->fb->getPageTabHelper();
                break;

            case 'web':
                $this->helper = $this->fb->getRedirectLoginHelper();
                break;
        }
       if(isset($_GET['state']))
        $_SESSION['FBRLH_state']=$_GET['state'];
        $helper = $this->fb->getRedirectLoginHelper();
        }
                

    }

      /**
     * @return FB
     */
    public function object()
    {
        return $this->fb;
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
            $this->fb->setDefaultAccessToken($access_token);
            return $access_token;
        }

        // // If we did not have a stored access token or if it has expired, try get a new access token
        if (!$access_token)
        {
            try
            {
                $access_token = $this->helper->getAccessToken();
            }
            catch (FacebookSDKException $e)
            {
                $this->logError($e->getCode(), $e->getMessage());
                return null;
            }

            // If we got a session we need to exchange it for a long lived session.
            if (isset($access_token))
            {
               $access_token = $this->long_lived_token($access_token);

                $this->set_expire_time($access_token->getExpiresAt());
                $this->set_access_token($access_token);
                $this->fb->setDefaultAccessToken($access_token);

                return $access_token;
            }
        }

        // Collect errors if any when using web redirect based login
        if (FACEBOOK_LOGIN_TYPE === 'web')
        {
            if ($this->helper->getError())
            {
                // Collect error data
                $error = array(
                    'error'             => $this->helper->getError(),
                    'error_code'        => $this->helper->getErrorCode(),
                    'error_reason'      => $this->helper->getErrorReason(),
                    'error_description' => $this->helper->getErrorDescription()
                );

                return $error;
            }
        }

        return $access_token;
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
    public function request($method, $endpoint, $params = [], $access_token = null)
    {
        try
        {
            $response = $this->fb->{strtolower($method)}($endpoint, $params, $access_token);
            return $response->getDecodedBody();
        }
        catch(FacebookResponseException $e)
        {
            return $this->logError($e->getCode(), $e->getMessage());
        }
        catch (FacebookSDKException $e)
        {
            return $this->logError($e->getCode(), $e->getMessage());
        }
    }

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
    public function user_upload_request($path_to_file, $params = [], $type = self::UPLOAD_TYPE_IMAGE, $access_token = null)
    {
        if ($type === self::UPLOAD_TYPE_IMAGE)
        {
            $data = ['source' => $this->fb->fileToUpload($path_to_file)] + $params;
            $endpoint = '/me/photos';
        }
        elseif ($type === self::UPLOAD_TYPE_VIDEO)
        {
            $data = ['source' => $this->fb->videoToUpload($path_to_file)] + $params;
            $endpoint = '/me/videos';
        }
        else
        {
            return $this->logError(400, 'Invalid upload type');
        }

        try
        {
            $response = $this->fb->post($endpoint, $data, $access_token);
            return $response->getDecodedBody();
        }
        catch(FacebookSDKException $e)
        {
            return $this->logError($e->getCode(), $e->getMessage());
        }
    }
     /**
     * Add request to batch
     *
     * @param       $key
     * @param       $method
     * @param       $endpoint
     * @param array $params
     * @param null  $access_token
     */
    public function add_to_batch_pool($key, $method, $endpoint, $params = [], $access_token = null)
    {
        $this->batch_request_pool = array_merge(
            $this->batch_request_pool,
            [$key => $this->fb->request($method, $endpoint, $params, $access_token)]
        );
    }

    /**
     * Remove request from batch
     *
     * @param $key
     */
    public function remove_from_batch_pool($key)
    {
        if (isset($this->batch_request_pool[$key]))
        {
            unset($this->batch_request_pool[$key]);
        }
    }

    /**
     * Send all request in the batch pool
     *
     * @return array|FacebookBatchResponse
     */
    public function send_batch_pool()
    {
        try
        {
            $responses = $this->fb->sendBatchRequest($this->batch_request_pool);
            $this->batch_request_pool = [];

            $data = [];
            foreach ($responses as $key => $response)
            {
                $data[$key] = $response->getDecodedBody();
            }

            return $data;
        }
        catch(FacebookResponseException $e)
        {
            return $this->logError($e->getCode(), $e->getMessage());
        }
        catch(FacebookSDKException $e)
        {
            return $this->logError($e->getCode(), $e->getMessage());
        }
    }
    

    /**
     * Generate Facebook login url for Facebook Redirect Login (web)
     *
     * @return  string
     */
    public function login_url()
    {
        // Login type must be web, else return empty string
        if (FACEBOOK_LOGIN_TYPE != 'web')
        {
            return '';
        }

        return $this->helper->getLoginUrl(
            FACEBOOK_APP_REDIRECT_URI,
            $this->permissions
        );
    }
     public function relogin_url($permissions)
    {
        // Login type must be web, else return empty string
        if (FACEBOOK_LOGIN_TYPE != 'web')
        {
            return '';
        }

        return $this->helper->getReRequestUrl(
            FACEBOOK_APP_REDIRECT_URI,
            $this->permissions
        );
    }


    /**
     * Generate Facebook login url for Facebook Redirect Login (web)
     *
     * @return string
     * @throws FacebookSDKException
     */
    public function logout_url()
    {
        // Login type must be web, else return empty string
        if (FACEBOOK_LOGIN_TYPE != 'web')
        {
            return '';
        }

        // Create logout url
        return $this->helper->getLogoutUrl(
            $this->get_access_token(),
            FACEBOOK_LOGOUT_REDIRECT_URI
        );
    }

    /**
     * Destroy our local Facebook session
     */
    public function destroy_session()
    {
        $this->session->unset_userdata('fb_access_token');
    }


    /**
     * Get stored access token
     *
     * @return mixed
     */
    private function get_access_token()
    {
        return $this->session->userdata('fb_access_token');
    }

    /**
     * Store access token
     *
     * @param AccessToken $access_token
     */
    private function set_access_token($access_token)
    {
        $this->session->set_userdata('fb_access_token', $access_token->getValue());
    }

    /**
     * @return mixed
     */
    private function get_expire_time()
    {
        return $this->session->userdata('fb_expire');
    }

    /**
     * @param DateTime $time
     */
    private function set_expire_time(DateTime $time = null)
    {
        if ($time) {
            $this->session->set_userdata('fb_expire', $time->getTimestamp());
        }
    }

    private function long_lived_token($access_token)
    {
          if (!$access_token->isLongLived())
        {
            $oauth2_client = $this->fb->getOAuth2Client();

            try
            {
                return $oauth2_client->getLongLivedAccessToken($access_token);
            }
            catch (FacebookSDKException $e)
            {
                $this->logError($e->getCode(), $e->getMessage());
                return null;
            }
        }

        return $access_token;

    }

    /**
     * @param $code
     * @param $message
     *
     * @return array
     */
    private function logError($code, $message)
    {
        log_message('error', '[FACEBOOK PHP SDK] code: ' . $code.' | message: '.$message);
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