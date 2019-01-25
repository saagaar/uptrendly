  <?php 
  $filterclass='';
  if($account_menu_active=='create_campaign') : 
   if(isset($product_id) && $product['detail']->campaign_type=='smart')
    {
       $campaign_type=$product['detail']->campaign_type;
       $tentative_date=$product['detail']->tentative_date;
       $tentative_budget=$product['detail']->tentative_budget;
       $no_influencer=$product['detail']->no_influencer;
       $gender_preference=$product['detail']->preferred_gender;
       $age_preference=$product['detail']->preferred_age;      
    } 
    else 
    {
        if($this->input->post("campaign_type",true)) $campaign_type=$this->input->post("campaign_type",true); else $campaign_type='normal';
       if($this->input->post('tentative_date',true)) $tentative_date=$this->input->post('tentative_date',true); else $tentative_date='';
       if($this->input->post('tentative_budget',true)) $tentative_budget=$this->input->post('tentative_budget',true);else $tentative_budget='';
       if($this->input->post('no_influencer',true)) $no_influencer=$this->input->post('no_influencer',true);else $no_influencer=0;
       if($this->input->post('preferred_gender',true)) $gender_preference=$this->input->post('preferred_gender',true);else $gender_preference='';
       if($this->input->post('preferred_age',true)) $age_preference=$this->input->post('preferred_age',true);else $age_preference='';
    }
  ?>
<style>/*.p-relavtive{ position:relative;}*/ .fixed{ background:red; position:fixed;top: 10px; right:15px; z-index:99;}
.navbar-main, .navbar-main.fixed, .fix-btn { transition: 0.8s;   -webkit-transition: 0.8s;}
</style>  
<div class="main-filter m-0"><!-- <form> -->
  <div class="capm_type">
    <section class="plan">
      <input type="radio" name="campaign_type" class="campaign_type" id="campaign_normal" value="normal" <?php if($campaign_type=='normal') echo 'checked';?>>
      <label class="four col" for="campaign_normal"><span>Influencer Campaign<br>
        Campaign</span></label>
      <input type="radio" name="campaign_type" class="campaign_type" id="campaign_budget" value="budget" <?php if($campaign_type=='budget') echo 'checked';?>>
      <label class="four col" for="campaign_budget"><span>Budget<br>
        Campaign</span></label>
      <input type="radio" name="campaign_type" class="campaign_type" id="campaign_smart" value="smart" <?php if($campaign_type=='smart') echo 'checked';?>>
      <label class="four col" for="campaign_smart"><span>Smart<br>
        Campaign</span></label>
    </section>
    <div class="clearfix"></div>
  </div>
  
  <!--  <div class="text-center capm_type">
      <div class="col-xs-4">
        <label class="radio">
          <input type="radio" name="campaign_type" class="campaign_type" value="normal" checked="checked">
          <span>Normal / Standard Campaign</span>
        </label>
      </div>

      <div class="col-xs-4">
        <label class="radio">
          <input type="radio" name="campaign_type" class="campaign_type" value="budget">
          <span>Budget Campaign</span>
        </label>
      </div>

      <div class="col-xs-4">
        <label class="radio">
          <input type="radio" name="campaign_type" class="campaign_type" value="smart">
          <span>Smart Campaign</span>
        </label>
      </div>

      <div class="clearfix"></div>
    </div> -->
  <?php

  $sum=0;
if($product_id)
{
  $creators=$product['creators'];  
}
else
{
  if($this->input->post('creators',true)) $creators=$this->input->post('creators',true);else $creators=array();
}
  if(is_array($creators) && count($creators)>0)
  {
    foreach($creators as $creatdata)
    {
      $sum+=$creatdata->price;
    }
  } 
  
  if($campaign_type=='normal')
  {
      $normalclass='';
      $budgetclass='hidden';
      $smartclass='hidden';


  }
  if($campaign_type=='budget')
  {
     $normalclass='hidden';
     $budgetclass='';
     $smartclass='hidden';
  }
  if($campaign_type=='smart')
  {
     $normalclass='hidden';
     $budgetclass='hidden';
     $smartclass='';
     $filterclass='hidden';
  }
   

  ?>
  <div class="costgroup text-right <?php echo $normalclass;?>" id="normal">
    <div class="btn btn-danger navbar-main">
      <label>Your Total Budget </label>
      <input name="budgetamount"  readonly="readonly" class="form-control budgetamount normalelement total_bdgt" id="" value="<?php echo $sum;?>">
    </div>
  </div>
  <div class="costgroup text-right <?php echo $budgetclass;?>" id="budget">
    <div class="btn btn-danger ps-15 navbar-main">
      <div class="row"> 
       <!--  <span class="col-xs-5">
        <label>Budget Amount</label>
        <input name="budgetamount"  readonly="readonly" disabled class="form-control budgetamount budgetelement total_bdgt" value="<?php echo $sum;?>">
        </span> -->
         <span>
        <label>Budget Amount box</label>
        <input name="budget_limit" class="form-control budgetelement total_bdgt"  id="budget_limit" value="0">
        </span> </div>
    </div>
  </div>
  <div class="row form-group costgroup p-relavtive   <?php echo $smartclass;?>" id="smart">
    <div class="col-xs-6 form-group">
      <label> Tentative Budget <span class="asterick">*</span></label>
      <input name="tentative_budget" id="tentative_budget" class="form-control  budgetelement" value="<?php echo $tentative_budget;?>">
    </div>
    <div class="col-xs-6 form-group">
      <label>Tentative Date <span class="asterick">*</span></label>
      <input name="tentative_date" class="form-control input-group budgetelement datepicker"   id="tentative_date" value="<?php echo $tentative_date;?>">
    </div>
    <div class="col-xs-6 form-group">
      <label>No of Influencer <span class="asterick">*</span></label>
      <input name="no_influencer" class="form-control budgetelement"    value="<?php echo $no_influencer;?>">
    </div>
    <div class="col-xs-6 form-group">
      <label>Gender Preference <span class="asterick">*</span></label>
      <select name="preferred_gender"  class="form-control" >
        <option value="">--ALL--</option>
        <option <?php if($gender_preference=='m') echo 'selected'?> value="m">Male</option>
        <option <?php if($gender_preference=='f') echo 'selected'?> value="f">Female</option>
      </select>
    </div>
    <div class="col-xs-6">
      <label>Age Group <span class="asterick">*</span></label>
      <select class="form-control age" id="preferred_age" name="preferred_age">
        <option value=""> Age</option>
        <option <?php if($age_preference=='15-25') echo 'selected'?> value="15-25">15-25</option>
        <option <?php if($age_preference=='25-35') echo 'selected'?> value="25-35">25-35</option>
        <option <?php if($age_preference=='35-45') echo 'selected'?> value="35-45">35-45</option>
        <option <?php if($age_preference=='45-55') echo 'selected'?> value="45-55">45-55</option>
        <option <?php if($age_preference=='55') echo 'selected'?> value="55">55-above</option>
      </select>
    </div>
  </div>
  <hr class="seperator">
  <?php endif;?>
  <div class="row selections creatorslist <?php echo $filterclass?>">
    <div class="col-md-2 col-xs-4 form-group "> 
      <!-- <label>Ceiling likes</label>-->
      <select class="form-control filter ceiling_likes">
        <option value="">Ceiling likes </option>
        <option value="0_5000">0-5000</option>
        <option value="5000_10000">5000-10000</option>
        <option value="10000_15000">5000-10000</option>
        <option value="15000">15000-above</option>
      </select>
    </div>
    <div class="col-md-2 col-xs-4 form-group"> 
      <!-- <label>Profession</label>-->
      <?php $professions=$this->general->get_profession();?>
      <select  class="form-control  filter professions">
        <option value="">Select Profession</option>
        <?php foreach($professions as $eachprof):?>
        <option value="<?php echo $eachprof->id;?>"><?php echo $eachprof->profession;?></option>
        <?php endforeach;?>
      </select>
    </div>
    <div class="col-md-2 col-xs-4 form-group">
      <select class="form-control filter age">
        <option value=""> Age</option>
        <option value="5_15">5-15</option>
        <option value="15_25">15-25</option>
        <option value="25_35">25-35</option>
        <option value="35_45">35-45</option>
        <option value="45_55">45-55</option>
        <option value="55">55-above</option>
      </select>
    </div>
    <div class="col-md-2 col-xs-4 form-group"> 
      <!--<label>Gender</label>-->
      <select class="form-control filter gender">
        <option value="">Gender</option>
        <option value="m">Male</option>
        <option value="f">Female</option>
        <option value="o">Other</option>
      </select>
    </div>
    <div class="col-md-4 col-xs-4 form-group"> 
      <!--<label>Product Preference for Promotion</label>-->
      <select class="form-control filter category">
        <option value="">Product Preference for Promotion</option>
        <?php 
            $category=$this->general->get_category_tree();
               
            if(count($category)>0)
            {
              foreach ($category as $key => $value) {
              ?>
        <option label="<?php echo $value['name'];?>" value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
        <?php 
                }
            }
            ?>
      </select>
    </div>
    
    <!--<div class="col-xs-12"><hr></div>-->
    <div class="clearfix"></div>
    <form>
      <div class="col-md-6 col-lg-4 form-group">
        <fieldset>
          <input type="text" class="form-control name" placeholder="Search by a name">
          <button class="btn btn-primary filteroptname"><i class="fa fa-search"></i></button>
        </fieldset>
      </div>
    </form>
  </div>
</div>
<div class="filterview">
  <?php $this->load->view('ajax_filter_result_creators');?>
</div>
<script type="text/javascript">
    var searchurl='<?php echo site_url('/'.BRAND.'/ajax_creators/'.$account_menu_active)?>'
</script> 
<script>
$(document).on('focus','.datepicker',function(){
  $(this).datepicker({
        format: "yyyy/mm/dd",
        todayBtn: "linked",
         startDate:new Date(),
        autoclose: true,
        todayHighlight: true
    });
})
</script>

<!--<script>
var affixElement = '.navbar-main';
$(affixElement).affix({
  offset: { // Distance of between element and top page
    top: function () {
      return (this.top = $(affixElement).offset().top)
    }
  }
});
</script>-->
<script>
//for Sticky header 
$(window).scroll(function() {
    if ($(this).scrollTop() > 200){  
        $('.navbar-main').addClass("fixed");
    }
    else{
        $('.navbar-main').removeClass("fixed");
    }
});
</script>