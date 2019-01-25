<div class="col-md-8 col-sm-7">
    <div class="log-form">
        <h4>Choose Expertise Area</h4>
        <form action="" method="post">
        <?php //echo '<pre>'; print_r($category_tree); echo '</pre>'; ?>
        <?php
        $exparea = array_column($expertise_area, 'category_id');
       
        // echo '<pre>';
        // print_r($expertise_area);
            // $category_array = array();
            // foreach ($category_tree as $category) 
            // {
            //     $category_array[$category['id']] = $category['name'];
            // }
        ?>
         <?php //echo form_multiselect('expertise', $category_array, '', 'class="form-control"'); ?>  

         <?php if (isset($category_tree) && (!empty($category_tree))){ ?>
                       
                <div class="from-group">
                    <ul class="subcategoryexpertise">
                    <?php
                    // echo '<pre>';
                    // print_r($category_tree);
                    
                        if($category_tree)
                        {
                            foreach($category_tree as $category)
                            {
                                ?>
                                <li>
                                <?php if($category['subcat']){
                                    ?>
                                    <span class="glyphicon glyphicon-plus"></span>
                                    <?php 
                                    }
                                    else{
                                        ?>
                                          <input type="checkbox" name="categories[]" class="" value="<?php echo $category['id'] ?>" class="cat<?php echo $category['id'] ?>" <?php if (!empty($exparea) && in_array($category['id'], $exparea)) echo ' checked'; ?> />
                                        <?php 
                                        }
                                         echo $category['name']; 
                                      if($category['subcat']!=''){ ?>
                                        <ul class="accordionContent">
                                            <?php
                                             foreach($category['subcat'] as $subcat){?>
                                                <li>
                                                      <input type="checkbox" class="" name="categories[]" value="<?php echo $subcat['id'] ?>" class="subcat<?php echo $subcat['parent_id']; ?>"  <?php if (!empty($exparea) && in_array($subcat['id'], $exparea)) echo ' checked'; ?>  /><?php echo $subcat['name']; ?>
                                                </li>
                                            <?php 
                                             } ?>
                                        </ul>
                                    <?php } ?> 
                                </li>
                                <?php
                            }
                        }
                     ?>
                     <?php echo form_error('categories[]'); ?>
                    </ul> 
                </div>
        <?php } ?>
        <div class='form-group'>
        <button type="submit" class="form-control">Submit</button>
        </div>
        </form>
    </div>
</div>