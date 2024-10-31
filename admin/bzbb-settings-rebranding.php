<div class="buddyboss-wl-settings-header">
	<h3><?php _e('Rebrand BuddyBoss', 'bzbb'); ?></h3>
</div>
<div class="buddyboss-wl-settings-wlms">

	<div class="buddyboss-wl-settings">
		<form method="post" id="form" enctype="multipart/form-data">

			<?php wp_nonce_field( 'buddyboss_wl_nonce', 'buddyboss_wl_nonce' ); ?>
			
			<div class="buddyboss-wl-setting-tabs">
				<a href="#buddyboss-wl-branding" class="buddyboss-wl-tab active"><?php _e('Branding', 'bzbb'); ?></a>
				<a href="#buddyboss-wl-branding-settings" class="buddyboss-wl-tab"><?php _e('Settings', 'bzbb'); ?></a>
			</div>
			
			<div class="buddyboss-wl-setting-tabs-content">
			<?php //echo '<pre>'; print_r($branding);echo '</pre>';?>

				<div id="buddyboss-wl-branding" class="buddyboss-wl-setting-tab-content active">
					<h3 class="bzbb-section-title">Branding</h3>
					<p>You can white label the theme as per your requirement.</p>
					<table class="form-table buddyboss-wl-fields">
						<tbody>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="buddyboss_wl_theme_name">Theme Name</label>
								</th>
								<td>
									<input id="buddyboss_wl_theme_name" name="buddyboss_wl_theme_name" type="text" class="regular-text" value="<?php echo esc_attr($branding['theme_name']); ?>" placeholder="" />
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="buddyboss_wl_theme_name">BuddyPanel Title</label>
								</th>
								<td>
									<input id="buddyboss_wl_buddypanel_title" name="buddyboss_wl_buddypanel_title" type="text" class="regular-text" value="" placeholder="" disabled />
									<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="buddyboss_wl_theme_desc">Theme Description</label>
								</th>
								<td>
									<input id="buddyboss_wl_theme_desc" name="buddyboss_wl_theme_desc" type="text" class="regular-text" value="<?php echo esc_attr($branding['theme_desc']); ?>"/>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="buddyboss_wl_theme_author">Developer / Agency</label>
								</th>
								<td>
									<input id="buddyboss_wl_theme_author" name="buddyboss_wl_theme_author" type="text" class="regular-text" value="<?php echo esc_attr($branding['theme_author']); ?>"/>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="buddyboss_wl_theme_uri">Website URL</label>
								</th>
								<td>
									<input id="buddyboss_wl_theme_uri" name="buddyboss_wl_theme_uri" type="text" class="regular-text" value="<?php echo esc_attr($branding['theme_uri']); ?>"/>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row" valign="top">
									<label for="buddyboss_wl_hide_external_links">Theme Preview Image</label>
								</th>
								<td>
									<input id="buddyboss_wl_theme_preview_image" name="buddyboss_wl_theme_preview_image" type="file" class="" accept="image/x-png" disabled >
									<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
								</td>
							</tr>
							
														
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="buddyboss_menu_icon">Menu Icon</label>
								</th>
								<td>
									<input class="regular-text" name="buddyboss_menu_icon" id="buddyboss_menu_icon" type="text" value="" disabled />
									<input class="button dashicons-picker" type="button" value="Choose Icon" data-target="#buddyboss_menu_icon" disabled />
									<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
								</td>
							</tr>
							

						</tbody>
					</table>
				</div>
				
				
				<div id="buddyboss-wl-branding-settings" class="buddyboss-wl-setting-tab-content">
					
					<table class="form-table buddyboss-wl-fields">
			
			
			
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="buddyboss_wl_hide_external_links">Hide License Menu</label>
							</th>
							<td>
								<input id="buddyboss_wl_hide_license_menu" name="buddyboss_wl_hide_license_menu" type="checkbox" class="" value="on" disabled />
								<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
							</td>
						</tr>
						
						<tr valign="top">
								<th scope="row" valign="top">
									<label for="buddyboss_wl_hide_external_links">Hide Help Menu</label>
								</th>
								<td>
									<input id="buddyboss_wl_hide_help_menu" name="buddyboss_wl_hide_help_menu" type="checkbox" class="" value="on" disabled />
									<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
								</td>
						</tr>  
							
						<tr valign="top">
								<th scope="row" valign="top">
									<label for="buddyboss_wl_hide_external_links">Hide Tool Menu</label>
								</th>
								<td>
									<input id="buddyboss_wl_hide_tool_menu" name="buddyboss_wl_hide_tool_menu" type="checkbox" class="" value="on" disabled />
									<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
								</td>
						</tr>
							
															
					 </table>
				
				</div>
				
				<div class="buddyboss-wl-setting-footer">
					<p class="submit">
						<input type="submit" name="buddyboss_submit" id="buddyboss_save_branding" class="button button-primary bzbb-save-button" value="Save Settings" />
					</p>
				</div>
			</div>
		</form>
	</div>
</div>
