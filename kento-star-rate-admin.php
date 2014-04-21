<?php	
	
	if(isset($_POST['ksr_hidden'])&& $_POST['ksr_hidden'] == 'Y')
		{
			//Form data sent

			$ksr_bg_color = $_POST['ksr_bg_color'];
			update_option('ksr_bg_color', $ksr_bg_color);
			
			$ksr_mouseenter_color = $_POST['ksr_mouseenter_color'];
			update_option('ksr_mouseenter_color', $ksr_mouseenter_color);			
			
			$ksr_currentrate_color = $_POST['ksr_currentrate_color'];
			update_option('ksr_currentrate_color', $ksr_currentrate_color);			
			
			$ksr_star_size = $_POST['ksr_star_size'];
			update_option('ksr_star_size', $ksr_star_size);				
			
			$ksr_star_design = $_POST['ksr_star_design'];
			update_option('ksr_star_design', $ksr_star_design);
			
			if(!empty($_POST['ksr_deletion']))
				{
				$ksr_deletion = $_POST['ksr_deletion'];
				
				}
			else
				{
					$ksr_deletion = "0";
				}
			
			update_option('ksr_deletion', $ksr_deletion);			
			

			?>
			<div class="updated"><p><strong><?php _e('Changes Saved.' ); ?></strong></p>
            </div>
  
	<?php
		} else {
			//Normal page display
			$ksr_bg_color = get_option( 'ksr_bg_color' );
			$ksr_mouseenter_color = get_option( 'ksr_mouseenter_color' );			
			$ksr_currentrate_color = get_option( 'ksr_currentrate_color' );			
			$ksr_star_size = get_option( 'ksr_star_size' );				
			$ksr_star_design = get_option( 'ksr_star_design' );
			$ksr_deletion = get_option( 'ksr_deletion' );			

		}

?>


<div class="wrap">
	<div id="icon-tools" class="icon32"><br></div><?php echo "<h2>".__('Kento Star Rate Settings')."</h2>";?>
		<form  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="ksr_hidden" value="Y">
        <?php settings_fields( 'kento_star_rate_plugin_options' );
				do_settings_sections( 'kento_star_rate_plugin_options' );
		?>


<table class="form-table">
        
	<tr valign="top">
		<th scope="row"><label for="ksr-bg-color"><?php echo __('KSR Background Color'); ?>: </label></th>
		<td style="vertical-align:middle;">                     
                     <input size='10' name='ksr_bg_color' id='ksr-bg-color' type='text' value='<?php if(!empty($ksr_bg_color )) echo $ksr_bg_color ; else echo "#038a52"; ?>' />
		</td>
	</tr>        
  
 
	<tr valign="top">
		<th scope="row"><label for="ksr-mouseenter-color"><?php echo __('Mouse Hover Color'); ?>: </label></th>
		<td style="vertical-align:middle;">                     
                     <input size='10' name='ksr_mouseenter_color' id='ksr-mouseenter-color' type='text' value='<?php if(!empty($ksr_mouseenter_color )) echo $ksr_mouseenter_color ; else echo "#89ffce"; ?>' />
		</td>
	</tr>    
 
 
	<tr valign="top">
		<th scope="row"><label for="ksr-currentrate-color"><?php echo __('Current Rate Color'); ?>: </label></th>
		<td style="vertical-align:middle;">                     
                     <input size='10' name='ksr_currentrate_color' id='ksr-currentrate-color' type='text' value='<?php if(!empty($ksr_currentrate_color )) echo $ksr_currentrate_color ; else echo "#03ff97"; ?>' />
		</td>
	</tr>    
 <script>
 jQuery(document).ready(function(ksr)
	{
 		ksr("#ksr-bg-color, #ksr-mouseenter-color, #ksr-currentrate-color").wpColorPicker()
	})
 </script>
	<tr valign="top">
		<th scope="row"><label for="ksr-star-size"><?php echo __('Star Size'); ?>: </label></th>
		<td style="vertical-align:middle;">                     
                     <input size='10' name='ksr_star_size' id='ksr-star-size' type='text' value='<?php if(!empty($ksr_star_size )) echo $ksr_star_size ; else echo "30"; ?>' />px
		</td>
	</tr>  
 
	<tr valign="top">
		<th scope="row"><label for="ksr-star-design"><?php echo __('Star Design'); ?>: </label></th>
		<td style="vertical-align:middle;">                     

   
<select name='ksr_star_design' id='ksr-star-design' style="background-image:url('<?php echo KENTO_STAR_RATE_PLUGIN_PATH."css/stars-bg/".$ksr_star_design; ?>')">


	<option  style="background-image:url('<?php echo $plugins_url = KENTO_STAR_RATE_PLUGIN_PATH."css/stars-bg/star-1.png"; ?>')" value='star-1.png' <?php if ( $ksr_star_design=="star-1.png" ) echo "selected='selected'"; ?> >star 1</option>
    
	<option  style="background-image:url('<?php echo $plugins_url = KENTO_STAR_RATE_PLUGIN_PATH."css/stars-bg/star-2.png"; ?>')" value='star-2.png' <?php if ( $ksr_star_design=="star-2.png" ) echo "selected='selected'"; ?> >star 2</option>    
    
	<option  style="background-image:url('<?php echo $plugins_url = KENTO_STAR_RATE_PLUGIN_PATH."css/stars-bg/star-3.png"; ?>')" value='star-3.png' <?php if ( $ksr_star_design=="star-3.png" ) echo "selected='selected'"; ?> >star 3</option>     
    
	<option  style="background-image:url('<?php echo $plugins_url = KENTO_STAR_RATE_PLUGIN_PATH."css/stars-bg/star-4.png"; ?>')" value='star-4.png' <?php if ( $ksr_star_design=="star-4.png" ) echo "selected='selected'"; ?> >star 4</option> 
    
	<option  style="background-image:url('<?php echo $plugins_url = KENTO_STAR_RATE_PLUGIN_PATH."css/stars-bg/star-5.png"; ?>')" value='star-5.png' <?php if ( $ksr_star_design=="star-5.png" ) echo "selected='selected'"; ?> >star 5</option> 

	<option  style="background-image:url('<?php echo $plugins_url = KENTO_STAR_RATE_PLUGIN_PATH."css/stars-bg/star-6.png"; ?>')" value='star-6.png' <?php if ( $ksr_star_design=="star-6.png" ) echo "selected='selected'"; ?> >star 6</option> 




</select>
                     
                     
		</td>
	</tr> 
 
 
 

	<tr valign="top">
		<th scope="row"><?php echo __('Drop Data When Uninstall'); ?>: </th>
		<td style="vertical-align:middle;">  
        <label for="ksr-deletion">                   
                     <input name='ksr_deletion' id='ksr-deletion' type="checkbox" value='1'  <?php if ( $ksr_deletion=="1" ) echo "checked"; ?>  />
                     <span style="color:#f00">Warrning!!</span> to delete all data from database when uninstall.
                     </label>
		</td>
	</tr>
 
 
 
 
 
 
 
 
 
 
 
                

</table>
                <p class="submit">
                    <input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes' ) ?>" />
                </p>
		</form>

        
        
        
</div>
