<?php 
/**
* Created A new custom post type which helps to capture every submission of contact form 7
*
*/
/*Code to add custom Js to the plugin*/

add_action('admin_enqueue_scripts', 'cfl_scripts');

function cfl_scripts() {
	
	// register scripts with WordPress's internal library
	wp_register_script('cfleads-js', plugins_url('/js/script.js',__FILE__), array('jquery'),'',true);

	
	// add to que of scripts that get loaded into every page
	wp_enqueue_script('cfleads-js');

	
}
/*Code to add custom Js to the plugin*/


add_action( 'init', 'contact_lead_post' );
function contact_lead_post() {
    register_post_type( 'cflead',
        array(
            'labels' => array(
                'name' => 'Lead',
                'singular_name' => 'Lead',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Lead',
                'edit' => 'Edit',
                'edit_item' => 'Edit Lead',
                'new_item' => 'New Lead',
                'show_in_menu'  => false,
                'show_in_nav_menus' => false,
                'view' => 'View',
                'view_item' => 'View Lead',
                'search_items' => 'Search Leads',
                'not_found' => 'No Leads found',
                'not_found_in_trash' => 'No Leads found in Trash',
                'parent' => 'Parent Lead'
            ),
 
            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title', 'editor', 'comments', 'thumbnail', 'custom-fields' ),
            'taxonomies' => array( '' ),
            'has_archive' => true
        )
    );
}

add_action('wpcf7_before_send_mail','cfl_add_lead');


function cfl_remove_menu_items() {
    
        remove_menu_page( 'edit.php?post_type=cflead' );
    
}
add_action( 'admin_menu', 'cfl_remove_menu_items' );

add_action( 'admin_menu', 'cfl_admin_menu' );

function cfl_admin_menu() {
	add_menu_page( 'Contact Form 7 Leads', 'Leads', 'manage_options', 'contact-form-lead/contact-form-lead-admin-page.php', 'cfl_display_leads', 'dashicons-email-alt', 6  );
}

function cfl_display_leads()
{
   
    ?>
    <table class="wp-list-table widefat fixed striped">

	<thead>
<tr>
    <td id="cb" class="manage-column column-cb check-column"></td>
    <th scope="col" id="name" class="manage-column column-name column-primary "><span>Contact Form</span><span class="sorting-indicator"></span></th>
    <th scope="col" id="data" class="manage-column column-data "><span>Data</span><span class="sorting-indicator"></span></th>
    <th scope="col" id="data" class="manage-column column-data "><span>Time of form submission</span><span class="sorting-indicator"></span></th>
        
</tr>
	</thead>

	<tbody id="the-list" data-wp-lists="list:wpenlight">
	 <?php
    $mypost = array( 'post_type' => 'cflead', );
    $loop = new WP_Query( $mypost );
    ?>
    <?php while ( $loop->have_posts() ) : $loop->the_post();?>
    		<!--<tr class="no-items"><td class="colspanchange" colspan="4">No items found.</td></tr>-->	</tbody>
    		
<tr>
    <th scope="row" class="check-column"><input name="id[]" value="1" type="checkbox"></th>
    <td class="name column-name has-row-actions column-primary" data-colname="Name"><?php the_title();?>
       </td>
    <td class="data column-data" data-colname="data"><?php the_content();?></td>
    <td class="data column-data" data-colname="data"><?php echo get_the_date('r');?></td>
  
</tr>
    <?php endwhile; ?>
		

	<tfoot>
	
	</tfoot>

</table>
<input type="button" id="export-csv" value="Export CSV" style="background-color: #4CAF50; border: none;  color: white;  padding: 15px 32px;  text-align: center;  text-decoration: none;  display: inline-block;  font-size: 16px;  margin: 4px 2px;  cursor: pointer;">
<?php 
}
?>