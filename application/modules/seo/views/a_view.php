<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; SEO  Management</h2>
  </div>
</section>

<article id="bodysec" class="sep">
	<div class="wrap">
		<aside class="lftsec"><?php $this->load->view('menu'); ?></aside>
		<section class="smfull">
			<?php
				 if($this->session->flashdata('message')) 
				 {
					 ?>
						<div id="displayErrorMessage" class="confrmmsg">
  							<p><?php echo $this->session->flashdata('message'); ?></p>
						</div>
					<?php
                 }
			?>

			<div class="box_block">
  				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_list tbl_full">
    				<thead>
                        <tr>
                            <th width="18%">Page</th>
                            <th width="18%">SEO Page Title</th>
                            <th width="20%">SEO Meta Key</th>
                            <th width="17%">SEO Meta Description</th>
                            <th width="15%">Last Update</th>
                            <th width="8%" class="optn"> Operations </th>
                        </tr>
                    </thead>
    				<tbody>
					<?php 
                    $sn_count=0;
                    if($seo_data)
                    {
                        foreach($seo_data as $value)
                        { ?>
                          <tr>
                            <td><?php echo $value->seo_page_name; ?></td>
                            <td><?php echo $this->general->string_limit($value->page_title,25); ?></td>
                            <td><?php echo $this->general->string_limit($value->meta_key,25); ?></td>
                            <td><?php echo $this->general->string_limit($value->meta_description,25); ?></td>
                            <td><?php echo $value->last_update;?></td>
                            <td class="optn">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="10">
                                            <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/seo/edit/<?php echo $value->id;?>" style="margin-right:5px;"><span>Edit</span></a>
                                        </td>
                                       
                                    </tr>
                                </table>
                            </td>
                          </tr>
                        <?php 
                        }
                    }
					else
					{
						?>
                             <tr>
                                <td colspan="9">
                                    <div class="confrmmsg">
                                        <p>SEO Pages not found</p>
                                    </div>
                                </td>
                            </tr>
                        <?php
					}
                    ?>
                </tbody>
  				</table>
  			</div>
		</section>
  		<div class="clearfix"></div>
	</div>
</article>
<div> </div>
