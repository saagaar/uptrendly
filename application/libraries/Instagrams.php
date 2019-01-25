<?php defined('BASEPATH') OR exit('No direct script access allowed');
 /**
  * Author @sagar
  * This class is codeigniter version of Elogram Instagram api 
  * https://github.com/larabros/elogram
  */
use MetzWeb\Instagram\Instagram;

class Instagrams{

    const UPLOAD_TYPE_VIDEO = 'video';
    const UPLOAD_TYPE_IMAGE = 'image';
    
    private $permissions=array(
                'basic',
                'follower_list',
                'relationships',
                'likes',
                'public_content' 
                ); 
    /**
     * @var FB
     */
    private $insta;

   

    /**
     * @var array
     */
    private $batch_request_pool = [];

    /**
     * Instagram constructor.
     */
    public function __construct()
    {
        if((defined('INSTAGRAM_APP_KEY') && defined('INSTAGRAM_APP_SECRET')))
       {
             
        if (!isset($this->insta))
        {
            $this->insta =     new  Instagram([
                'apiKey'               =>   INSTAGRAM_APP_KEY,
                'apiSecret'            =>   INSTAGRAM_APP_SECRET,
                'apiCallback'          =>   INSTAGRAM_APP_REDIRECT_URI
            ]);
          }
        
       if(isset($_GET['code'])){
             $data = $this->insta->getOAuthToken($_GET['code']);
             $this->insta->setAccessToken($data);
             $this->set_access_token($data);
             
        }
                

    }
}

      /**
     * @return FB
     */
    public function object()
    {
        return $this->insta;
    }
     public function login_url()
    {
        
        return $this->insta->getLoginUrl($this->permissions);
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
            $this->insta->setAccessToken($access_token);
            $this->set_access_token($access_token);
            return $access_token->access_token;
        }

        // // If we did not have a stored access token or if it has expired, try get a new access token
        else
        {
 
            if(isset($_GET['code'])){
             $data = $this->insta->getOAuthToken($_GET['code']);

             
             $this->insta->setAccessToken($data);
             $this->set_access_token($access_token);
             $access_tokens=$this->insta->getAccessToken();

             return $access_tokens;
            }
          return false;
            
        }
 
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
    public function request($method,$parameters=false,$second_param=false)
    {

     if($second_param)
         return $this->insta->{$method}($parameters,$second_param);
      else if($parameters)  
        return $this->insta->{$method}($parameters);
    else
          return $this->insta->{$method}();
    }

 
    public function get_app_access_token()
    {
        // https://www.instagram.com/oauth/access_token?client_id=883511eba48e497b9386495f5b275861&client_secret=9ff1bbd42f7c43fbb86a062862161ccc&grant_type=authorization_code&redirect_uri=http://localhost/famebit/my-account/contents&response_type=code
       $url='https://api.instagram.com/oauth/access_token/?client_id='.INSTAGRAM_APP_KEY.'&client_secret='.INSTAGRAM_APP_SECRET.'&grant_type=authorization_code&redirect_uri=http://localhost/famebit/my-account/contents/&code=CODE';
        $curl=curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url,
        CURLOPT_HTTPGET=>1
    ));

    // Send the request
    $response = curl_exec($curl);
    
    // Close request to clear up some resources
    curl_close($curl);
    return $response;


    }
    

    /**
     * Destroy our local Instagram session
     */
    public function destroy_session()
    {
        $this->session->unset_userdata('ins_access_token');
    }


    /**
     * Get stored access token
     *
     * @return mixed
     */
    private function get_access_token()
    {
        return $this->session->userdata('ins_access_token');
    }

    /**
     * Store access token
     *
     * @param AccessToken $access_token
     */
    public function set_access_token($access_token)
    {
        $this->session->set_userdata('ins_access_token', $access_token);
    }

    /**
     * @return mixed
     */
    private function get_expire_time()
    {
        return $this->session->userdata('ins_expire');
    }

    /**
     * @param DateTime $time
     */
    private function set_expire_time(DateTime $time = null)
    {
        if ($time) {
            $this->session->set_userdata('ins_expire', $time->getTimestamp());
        }
    }

    // private function long_lived_token($access_token)
    // {
    //       if (!$access_token->isLongLived())
    //     {
    //         $oauth2_client = $this->fb->getOAuth2Client();

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
        log_message('error', '[Instagram PHP SDK] code: ' . $code.' | message: '.$message);
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