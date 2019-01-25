<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_reward_model extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();	
		$this->image_name_path='';
	}
	public $reward_validation_rule =  array
	(	
		array('field' => 'title', 'label' => 'Reward Title', 'rules' => 'required|min_length[2]|max_length[20]'),
		array('field' => 'description', 'label' => 'Description', 'rules' => 'required|min_length[2]|max_length[50]'),
		array('field' => 'points', 'label' => 'Required Points', 'rules' => 'required'),
		
	);
	
	//function to count total products
	public function count_total_rewards()
	{
		$this->db->select('*');
		$this->db->from('referral_prize');
		if($this->input->post('srch')!=""){
			$this->db->where("(title LIKE '%".$this->input->post('srch',TRUE)."%' OR points LIKE '%".$this->input->post('srch',TRUE)."%')");
		}
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function get_rewards_lists($limit, $start)
	{

		$this->db->select('*');
		$this->db->from('referral_prize');
		if($this->input->post('srch')!="")
		{
			$this->db->where("(title LIKE '%".$this->input->post('srch',TRUE)."%' OR points LIKE '%".$this->input->post('srch',TRUE)."%')");
		}
		$this->db->order_by('id','DESC');
		$this->db->limit($limit, $start);	
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		  return $query->result();
		}
		return FALSE;
	}

	//function to resize images
	public function resize_image($location,$source_image,$new_image,$width,$height)
	{
		$config['image_library'] = 'gd2';
		$config['source_image'] = './'.$location.$source_image;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = $width;
		$config['height'] = $height;
		$config['master_dim'] = 'width';
		$config['new_image'] = './'.$location.$new_image;
		$this->image_lib->initialize($config);
		$resize = $this->image_lib->resize();
	}

	public function file_settings_do_upload($file)
	{
		$config['upload_path'] = './'.PRODUCT_IMAGE_PATH;//define in constants
		$config['allowed_types'] = 'gif|jpg|png';
		$config['remove_spaces'] = TRUE;		
		$config['max_size'] = '2000';
		$config['max_width'] = '1000';
		$config['max_height'] = '1000';
		$this->upload->initialize($config);
		
		$this->upload->do_upload($file);

		if($this->upload->display_errors())
		{
			 $this->error_img = $this->upload->display_errors();
			return false;
		}
		else
		{
			$data = $this->upload->data();
			return $data;
		}			
	}

	public function add_rewards($id=false)
	{
		$data = array(
			'title' => $this->input->post('title', TRUE),
			'description' =>$this->input->post('description'),
			'is_display' => $this->input->post('is_display', TRUE),
			'points' => $this->input->post('points', TRUE),
		);

		if($_FILES)
		{
				if($_FILES['uploadimage']['name'])
					{

						$fdata=$this->file_settings_do_upload('uploadimage',PRODUCT_IMAGE_PATH,'encrypt');

						if($fdata)
						{
							$image			= $fdata['file_name'];
							$data['image']=$image;
						}
						else
						{
							
							return array('error'=>$this->error_img);
						}

					}
		}

		if($id)
		{
			$this->db->update('referral_prize',$data,array('id'=>$id));
		}
		else
		{
			$this->db->insert('referral_prize',$data);	
		}
		
		$reward = $this->db->affected_rows();
		if($reward)
		{
			return array('success'=>'Reward added Successfully'); 
		}

	}
	public function file_settings_do_upload_ajax($file, $location, $encrypt_filename='')
 	{

		$config['upload_path'] = './'.$location;   //file upload location
		$config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
		$config['remove_spaces'] = TRUE;  
		$config['max_size'] = '5000';
		$config['max_width'] = '2000';
		$config['max_height'] = '2000';
		if($encrypt_filename='encrypt')
		{
			$config['encrypt_name'] = TRUE;
		}
		$this->upload->initialize($config);
		$this->upload->do_upload($file);
		if($this->upload->display_errors())
		{
			$this->error_img = $this->upload->display_errors();
			return false;
		}
		else
		{
			$data = $this->upload->data();
			return $data;
		}
	}	
}

