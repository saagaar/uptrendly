<div class="col-md-8 col-sm-7">
    <div class="log-form">
        <h4>Choose Expertise Area</h4>
    	<form action="" method="post">
        <?php
        $exparea = array_column($expertise_area, 'category_id');
        ?>
         <?php if (isset($category_tree) && (!empty($category_tree))){ ?>
                       
                <div class="from-group">
                    <ul>
                    <?php
                    // echo '<pre>';
                    // print_r($category_tree);
                    
                        if($category_tree)
                        {
                            foreach($category_tree as $category)
                            {
                            ?>
                                <li>
                                     <span class="accordionTrigger"></span>
                                     <input type="checkbox" name="categories[]" value="<?php echo $category['id'] ?>" class="cat<?php echo $category['id'] ?>" <?php if (!empty($exparea) && in_array($category['id'], $exparea)) echo 'checked'; ?> /><?php echo $category['name']; ?>
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