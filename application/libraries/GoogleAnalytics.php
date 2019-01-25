<?php defined('BASEPATH') OR exit('No direct script access allowed');
 /**
  * Author @sagar
  * This class overwrites the native yt session by codeigniter session in yt sdk
  */

      
  
class GoogleAnalytics{

    /**
     * @refer main  https://developers.google.com/analytics/devguides/reporting/core/v4/quickstart/web-php
     *@refer for dimensions and metrices https://developers.google.com/analytics/devguides/reporting/core/dimsmets
     */
    private $client;

    private $analytics;
    /**
     * Google constructor.
     */
    public function __construct()
    {
       /**
        File for Authenticating user
       */
            $KEY_FILE_LOCATION = __DIR__.'/vid-energy-4340085007a9.json';
            chmod($KEY_FILE_LOCATION,'777');
            if(file_exists($KEY_FILE_LOCATION))
            {
                  $this->client = new Google_Client();
            
                  $this->client->setApplicationName("Vid.Energy");
                  $this->client->setAuthConfig($KEY_FILE_LOCATION);
                  $this->client->addScope("https://www.googleapis.com/auth/youtube");
                  $this->client->addScope("https://www.googleapis.com/auth/yt-analytics.readonly");
                  $this->client->addScope('https://www.googleapis.com/auth/analytics.readonly');
                  $this->client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
                  $this->client->setAccessType("offline");  
                  $this->analytics = new Google_Service_Analytics($this->client);
                  $this->getdetail();
            }
            else{
                echo 'Some error Occured';exit;
            }
    }
    
    
    public function analyticsobj()
    {
         return $this->analytics;
    }
    
    public function getdetail()
    {

            $accounts =  $this->analytics->management_accounts->listManagementAccounts();
                    if (count($accounts->getItems()) > 0) 
                    {
                        $items = $accounts->getItems();
                        $firstAccountId = $items[0]->getId();
                        // Get the list of properties for the authorized user.
                $properties =  $this->analytics->management_webproperties
                            ->listManagementWebproperties($firstAccountId);
                        if (count($properties->getItems()) > 0) 
                        {
                              $items = $properties->getItems();
                              $firstPropertyId = $items[0]->getId();

                      // Get the list of views (profiles) for the authorized user.
                      $profiles =  $this->analytics->management_profiles
                              ->listManagementProfiles($firstAccountId, $firstPropertyId);

                          if (count($profiles->getItems()) > 0) 
                          {
                                $items = $profiles->getItems();
                        $this->accountId=$items['0']->accountId;
                        $this->currency=$items['0']->currency;
                        $this->id=$items['0']->getId();
                        $this->currency=$items['0']->currency;
                        $this->trackcode=$items['0']->webPropertyId;
                   } 
                   else 
                   {
                    throw new Exception('No views (profiles) found for this user.');
                   }
                } 
                else 
                {
                  throw new Exception('No properties found for this user.');
                }
          } 
          else 
          {
            throw new Exception('No accounts found for this user.');
          }

    } 
  
    public function get_custom_event_data($dimensions,$filters,$reportstart,$reportend)
    {
                            $optParams = array(
                                               
                                                  'filters' => $filters,
                                                  'max-results' => '100'
                                               );

                          $data=  $this->analytics->data_ga->get(
                                                                  'ga:'.$this->id,
                                                                  $reportstart,
                                                                  $reportend,
                                                                  $dimensions,
                                                                  $optParams
                                                                );
                          return $data;                              
    }


}