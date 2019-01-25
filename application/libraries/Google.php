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
              $this->client->addScope("https://www.googleapis.com/auth/yt-analytics.readonly");
              $this->client->addScope('https://www.googleapis.com/auth/analytics.readonly');
              $this->client->addScope("https://www.googleapis.com/auth/userinfo.profile");
              $this->client->addScope("https://www.googleapis.com/auth/userinfo.email");
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
    public function channelobj()
    {
        return new \Google_Service_YouTube_ChannelSnippet($this->client);
    }

      public function googleoauthobj()
    {
          return new \Google_Service_Oauth2($this->client);
    }
      /**
     * @return FB
     */
    public function object()
    {
        return $this->client;
    }
    public function reportingobj()
    {
        return new \Google_Service_YouTubeReporting($this->client);
    }
      public function analyticsobj()
    {
        return new \Google_Service_YouTubeAnalytics($this->client);
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

    function getUserinfo(Google_Service_Oauth2 $googleapis) {
     // Call the YouTube Data API's channels.list method to retrieve channels.
          $userinfo = $googleapis->userinfo->get();
          return $userinfo;
    }

   function getChannelinfo( Google_Service_YouTube  $youtube,$channelId=false,$language=false) {
  // Call the YouTube Data API's channels.list method to retrieve channels.
      $channelsResponse = $youtube->channels->listChannels('id,statistics',array(
          'mine' => true
      ))->items;
      return $channelsResponse;
        
    }
   /* function getchannelsubscribers(Google_Service_YouTube $youtube,$channelId=false,$language=false)
    {
         $channelsResponse = $youtube->channels->listChannels('statistics',array(
          'mine' => true
          ));
          echo '<pre>';
          print_r($channelsResponse);
    }*/
    function listReportingJobs(Google_Service_YouTubeReporting $youtubeReporting) {
          // Call the YouTube Reporting API's jobs.list method to retrieve reporting jobs.
          $reportingJobs = $youtubeReporting->jobs_reports->listJobsReports('channel_demographics_a1');
          return $reportingJobs;
}

function getanalyticsreport(Google_Service_YouTubeAnalytics $youtubeAnalytics,$metric,$optparams) {
  // Call the YouTube Reporting API's jobs.list method to retrieve reporting jobs.
  $channel_url='channel==MINE';
  $ids = $channel_url;
  $end_date = date("Y-m-d"); 
  $start_date = date('Y-m-d', strtotime("-180 days"));
  $api = $youtubeAnalytics->reports->query($channel_url, $start_date, $end_date, $metric, $optparams);
  return $api;
}


 function listVideoLocalizations(Google_Service_YouTube $youtube, $videoId) {
  // Call the YouTube Data API's videos.list method to retrieve videos.
  $videos = $youtube->videos->listVideos("snippet,localizations", array(
      'id' => $videoId
  ));
}
    /**
     * Generate Google login url for Google Redirect Login (web)
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

    /**
 * get youtube video ID from URL
 *
 * @param string $url
 * @return string Youtube video id or FALSE if none found. 
 */
function youtube_id_from_url($url) 
{
    $pattern = 
        '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x'
        ;
    $result = preg_match($pattern, $url, $matches);
    if ($result) {
        return $matches[1];
    }
    return false;
}

}