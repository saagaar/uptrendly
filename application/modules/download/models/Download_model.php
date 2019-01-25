<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Download_Model extends CI_Model 
{
	 var $download_hook = array();
     private $args = array();
     private $extensions = array();
     private $mime_type = NULL;
    

    public function get_args(){
        $args = array(
			'download_path'			=>	NULL,
			'file'					=>	NULL,
			'file_name'				=>  NULL,												
			'extension_check'		=>	TRUE,
			'referrer_check'		=>	FALSE,	
			'referrer'				=>	NULL,					
		);
        return $args;
    }
    
    public function get_extensions(){
        $extensions = array(
						
						/* Archives */
						'zip'	=> 'application/zip',
						'7z'	=> 'application/octet-stream',
            's7z'   => 'application/x-7z-compressed',
            'tar'   => 'application/x-tar',
            'rar'   => 'application/x-rar-compressed',
            'gz'    => 'application/x-gzip',
            'bz2'   => 'application/x-bzip2',
					
					  	/* Documents */
					  	'txt'	=> 'text/plain',
						'pdf'	=> 'application/pdf',
					  	'doc' 	=> 'application/msword',
            'docx' 	=> 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
					  	'xls'	=> 'application/vnd.ms-excel',
            'xlsx'	=> 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'csv'       => 'application/csv',
					  	'ppt'	=> 'application/vnd.ms-powerpoint',
            'pptx'	=> 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                        'html' => 'text/html',
                        'htm' => 'text/html',
                        'php' => 'text/plain',
					  
					  	/* Executables */
					  	'exe'	=> 'application/octet-stream',
					
					  	/* Images */
					  	'gif'	=> 'image/gif',
					  	'png'	=> 'image/png',
					  	'jpg'	=> 'image/jpeg',
					  	'jpeg'	=> 'image/jpeg',
					
					  	/* Audio */
					  	'mp3'	=> 'audio/mpeg',
					  	'wav'	=> 'audio/x-wav',
					
					  	/* Video */
					  	'mpeg'	=> 'video/mpeg',
					  	'mpg'	=> 'video/mpeg',
					  	'mpe'	=> 'video/mpeg',
					  	'mov'	=> 'video/quicktime',
					  	'avi'	=> 'video/x-msvideo'
					
					);
        return $extensions;
    }
    
    public function set_args($args=array()){
        $this->args = array_merge($this->get_args(),$args);
    }
    
    public function set_extensions($extensions = array()){
        $this->extensions = array_merge($this->get_extensions(),$extensions);
    }
    
    public function check_directory(){
        
        /* Directory Depth */
        $dir_depth = dirname( $this->args['file'] );
        if ( !empty( $dir_depth ) && $dir_depth != "." ) {
                $this->args['download_path'] = $this->args['download_path'] . $dir_depth ;
        }
        
        /* File Name */
        $file = basename( $this->args['file']);
		
		/* File Path */		
        $file_path = $this->args['download_path']. $file;
        $file_info = pathinfo($file);
        
	$this->download_hook['file_path'] = $file_path;
        $this->download_hook['file'] = $file;
        //$this->download_hook['file_name'] = $file_info['filename'];
		/*The file may be saved with other name but the download filename can be different*/
		$this->download_hook['file_name'] = $this->args['file_name'];
                $this->download_hook['file_extension'] = $file_info['extension'];
                if(file_exists($file_path)){
                    $this->download_hook['file_size'] = filesize($file_path);
                }else{
                    $this->download_hook['file_size'] = 0;
                }
        
    }
    
    public function check_file(){
        /* File and File Path Validation */
		if( empty( $this->download_hook['file']) || !file_exists( $this->download_hook['file_path'] ) ) {
			$this->download_hook['download'] = FALSE;
			$this->download_hook['message'] = "Invalid File or File Path.";
			return false;
		}
        else{
            $this->download_hook['download'] = TRUE;
        }
    }
    
    public function check_extension(){
        
        /* Allowed Extension - Validation */
		if ( $this->args['extension_check'] == TRUE && !array_key_exists( $this->download_hook['file_extension'], $this->extensions ) ) {
		  $this->download_hook['download'] = FALSE;
		  $this->download_hook['message'] = "File is not allowed to download"; 
		  return false;
		}
        else{
            $this->download_hook['download'] = TRUE;
        }
    }
    
    public function check_referrer(){
        $this->load->library('user_agent');
        $come_from = $this->agent->referrer();
        /* Referrer - Validation */
        //Check if the referer is an array or string.
        if($this->args['referrer_check'] == TRUE  && is_array($this->args['referrer'])){
            $referer_found = true;
            foreach($this->args['referrer'] as $referer){
                if ( $this->args['referrer_check'] == TRUE && !empty( $referer) && strpos( strtoupper( $come_from ), strtoupper( $referer ) ) === FALSE ) {
			$referer_found = false;
                        
		}else{
                    $referer_found = true; break;
                }
            }
            
            if($referer_found === FALSE){
                $this->download_hook['download'] = FALSE;
                $this->download_hook['message'] = "Download not allowed from here. Please contact system administrator";
                return 0;
            }else{
                $this->download_hook['download'] = TRUE;
            }
        }elseif ( $this->args['referrer_check'] == TRUE && !empty( $this->args['referrer']) && ( strpos( strtoupper( $come_from ), strtoupper( $this->args['referrer'] ) ) === FALSE) ) {
			
                        $this->download_hook['download'] = FALSE;
		 	$this->download_hook['message'] = "Download not allowed from here. Please contact system administrator";
			return 0;
		}
        else{
            $this->download_hook['download'] = TRUE;
        }
    }
    public function set_mime_type(){
        if(array_key_exists($this->download_hook['file_extension'],$this->extensions)){
            $allowed_mime_type = $this->extensions[$this->download_hook['file_extension']];
        }
        else
            $allowed_mime_type = false;
        
        
        
        /* by Function - mime_content_type */
		if( function_exists( 'mime_content_type' ) ) {
			$file_mime_type = @mime_content_type( $this->download_hook['file_path'] );
		}
		
		/* by Function - mime_content_type */
		else if( function_exists( 'finfo_file' ) ) {
			
			$finfo = @finfo_open(FILEINFO_MIME);
			$file_mime_type = @finfo_file($finfo, $this->download_hook['file_path']);
			finfo_close($finfo);  
		
		}
        /*Allowed Extensions*/
        elseif($allowed_mime_type){
            $file_mime_type = $allowed_mime_type;
        }		
		/* Default - force download */
		else {
			$file_mime_type = 'application/force-download';
		 }
         $this->download_hook['file_mime_type'] = $file_mime_type;
    }
    public function prepare_download(){
        
        $this->check_directory();
        $this->check_file();
        if($this->download_hook['download'])
            $this->check_extension();
        else
            return false;
        if($this->download_hook['download'])             
            $this->check_referrer();
        else
            return false;
        $this->set_mime_type();
        
    }
    
    
    public function set_download(){
        /* Execution Time Unlimited */
		set_time_limit(0);
        
        // required for IE, otherwise Content-Disposition may be ignored
        if(ini_get('zlib.output_compression'))
            ini_set('zlib.output_compression', 'Off');
            
        header('Content-Type: ' .  $this->download_hook['file_mime_type']);
        header('Content-Disposition: attachment; filename="'.$this->download_hook['file_name'].'"');
        header("Content-Transfer-Encoding: binary");
        header('Accept-Ranges: bytes');
        
        /* The three lines below basically make the 
        download non-cacheable */
        header("Cache-control: private");
        header('Pragma: private');
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        
        $this->set_resume();
    }
    
    private function set_resume(){
        
        // multipart-download and download resuming support
        if(isset($_SERVER['HTTP_RANGE']))
        {
            list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
            list($range) = explode(",",$range,2);
            list($range, $range_end) = explode("-", $range);
            $range=intval($range);
            if(!$range_end) {
                $range_end=$this->download_hook['file_size']-1;
            } else {
                $range_end=intval($range_end);
            }
            /*
            ------------------------------------------------------------------------------------------------------
            //This application is developed by www.webinfopedia.com
            //visit www.webinfopedia.com for PHP,Mysql,html5 and Designing tutorials for FREE!!!
            ------------------------------------------------------------------------------------------------------
            */
            $new_length = $range_end-$range+1;
            header("HTTP/1.1 206 Partial Content");
            header("Content-Length: $new_length");
            header("Content-Range: bytes $range-$range_end/$size");
            $this->download_hook['range'] = $range;
        } else {
            $new_length=$this->download_hook['file_size'];
            header("Content-Length: ".$this->download_hook['file_size']);
        }
        
        
        $this->download_hook['new_length'] = $new_length;
    }
    
    
    public function start_download(){                
        
        
        
        /* Will output the file itself */
        $chunksize = 1*(1024*1024); //you may want to change this
        $bytes_send = 0;
        if ($file = fopen($this->download_hook['file_path'], 'r')){
            if(isset($_SERVER['HTTP_RANGE']))
                fseek($file, $this->download_hook['range']);
            
            while(!feof($file) && (!connection_aborted()) && ($bytes_send<$this->download_hook['new_length'])){
                $buffer = fread($file, $chunksize);
                print($buffer); //echo($buffer); // can also possible
                flush();
                $bytes_send += strlen($buffer);
            }
            //close the file if reading is done.
            fclose($file);
        } else{
            //If no permissiion
            die('Error - can not open file.');
        }
        
        
    }
    
    
    

    public function __destruct() {
	}
}