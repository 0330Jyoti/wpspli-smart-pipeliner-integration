<?php
	
	$wpspli_smart_pipeliner 				= get_option( 'wpspli_smart_pipeliner' );
	$wpspli_smart_pipeliner_settings 		= get_option( 'wpspli_smart_pipeliner_settings' );

	$client_id 						=  isset($wpspli_smart_pipeliner_settings['client_id']) ? $wpspli_smart_pipeliner_settings['client_id'] : "";
	$client_secret 					= isset($wpspli_smart_pipeliner_settings['client_secret']) ? $wpspli_smart_pipeliner_settings['client_secret'] : "";
	$wpspli_smart_pipeliner_data_center 	= isset($wpspli_smart_pipeliner_settings['data_center']) ? $wpspli_smart_pipeliner_settings['data_center'] : "";

	$wpspli_smart_pipeliner_data_center 	= ( $wpspli_smart_pipeliner_data_center ? $wpspli_smart_pipeliner_data_center : 'https://accounts.pipeliner.com' );
?>

<div class="wrap">                
	
	<h1><?php echo esc_html__( 'PipeLiner CRM Settings and Authorization' ); ?></h1>
	<hr>

	<form method="post">
		<?php 
			$tab = isset( $_REQUEST['tab'] ) ? $_REQUEST['tab'] : 'general';
		?>

		<nav class="nav-tab-wrapper woo-nav-tab-wrapper">
			<a href="<?php echo admin_url('admin.php?page=wpspli-smart-pipeliner-integration&tab=general'); ?>" class="nav-tab <?php if($tab == 'general'){ echo 'nav-tab-active';} ?>"><?php echo esc_html__( 'General', 'wpspli-smart-pipeliner' ); ?></a>
			<a href="<?php echo admin_url('admin.php?page=wpspli-smart-pipeliner-integration&tab=synch_settings'); ?>" class="nav-tab <?php if($tab == 'synch_settings'){ echo 'nav-tab-active';} ?>"><?php echo esc_html__( 'Synch Settings', 'wpspli-smart-pipeliner' ); ?></a>
		</nav>
		
		<input type="hidden" name="tab" value="<?php echo esc_html($tab); ?>">

		<?php if( isset($tab) && 'general' == $tab ){ ?>
			
			<table class="form-table general_settings">
				<tbody>
					<tr>
						<th scope="row"><label><?php echo esc_html__( 'Data Center', 'wpspli-smart-pipeliner' ); ?></label></th>
						<td>
							<fieldset>
								<label>
									<input 
										type="radio" 
										name="wpspli_smart_pipeliner_settings[data_center]" 
										value="https://accounts.pipeliner.com"
										<?php echo esc_html( $wpspli_smart_pipeliner_data_center == 'https://accounts.pipeliner.com' ? ' checked="checked"' : '' ); ?> />
										United States (US)
								</label><br>

								<label>
									<input 
										type="radio" 
										name="wpspli_smart_pipeliner_settings[data_center]" 
										value="https://accounts.pipeliner.eu"
										<?php echo esc_html( $wpspli_smart_pipeliner_data_center == 'https://accounts.pipeliner.eu' ? ' checked="checked"' : '' ); ?> />
										Europe (EU)
								</label><br>

								<label>
									<input 
										type="radio" 
										name="wpspli_smart_pipeliner_settings[data_center]" 
										value="https://accounts.pipeliner.com.cn"
										<?php echo esc_html( $wpspli_smart_pipeliner_data_center == 'https://accounts.pipeliner.com.cn' ? ' checked="checked"' : '' ); ?> />
										China (CN)
								</label>
							</fieldset>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label><?php echo esc_html__( 'Client ID', 'wpspli-smart-pipeliner' ); ?></label>
						</th>
						<td>
							<input class="regular-text" type="text" name="wpspli_smart_pipeliner_settings[client_id]" value="<?php echo esc_attr($client_id); ?>" required />
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label><?php echo esc_html__( 'Client Secret', 'wpspli-smart-pipeliner' ); ?></label>
						</th>
						<td>
							<input class="regular-text" type="text" name="wpspli_smart_pipeliner_settings[client_secret]" value="<?php echo esc_attr($client_secret); ?>" required />
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label><?php echo esc_attr( 'Redirect URI', 'wpspli-smart-pipeliner' ); ?></label>
						</th>
						<td>
							<input class="regular-text" type="text" value="<?php echo esc_url(WPSPLI_REDIRECT_URI); ?>" readonly />
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label><?php echo esc_html__( 'Access Token', 'wpspli-smart-pipeliner' ); ?></label>
						</th>
						<td>
							
							<?php 
								if(isset($wpspli_smart_pipeliner->access_token)){
									echo esc_html($wpspli_smart_pipeliner->access_token);
								}
							?>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label><?php echo esc_html__( 'Refresh Token', 'wpspli-smart-pipeliner' ); ?></label>
						</th>
						<td>
							<?php 
								if(isset($wpspli_smart_pipeliner->refresh_token)){
									echo esc_html($wpspli_smart_pipeliner->refresh_token);
								}
							?>
						</td>
					</tr>
					
				</tbody>
			</table>

			<div class="inline">
				<p>
					<input type='submit' class='button-primary' name="submit" value="<?php echo esc_html__( 'Save & Authorize', 'wpspli-smart-pipeliner' ); ?>" />
				</p>

				<?php 
					if(isset($wpspli_smart_pipeliner->refresh_token)){
						echo '<p class="success">'.esc_html__('Authorized', 'wpspli-smart-pipeliner').'</p>';
					}
				?>
			</div>

		<?php }else if( isset($tab) && 'synch_settings' == $tab ){ ?>
			<?php 
				$smart_pipeliner_obj   = new WPSPLI_Smart_Pipeliner();
		        $wp_modules 	= $smart_pipeliner_obj->get_wp_modules();
		        $getListModules = $smart_pipeliner_obj->get_pipeliner_modules();
			?>
			<table class="form-table synch_settings">
				<tbody>
					<?php
						if($getListModules['modules']){
					        foreach ($getListModules['modules'] as $key => $singleModule) {
					            if( $singleModule['deletable'] &&  $singleModule['creatable'] ){
					            	foreach ($wp_modules as $wp_module_key => $wp_module_name) {
					            		?>
						            		<tr>
												<th scope="row"><label><?php echo esc_html__( "Enable {$wp_module_key} to Pipeliner {$singleModule['api_name']} Sync", 'wpspli-smart-pipeliner' ); ?></label></th>
												<td>
													<fieldset>
														<label>
															<input 
																type="checkbox" 
																name="wpspli_smart_pipeliner_settings[synch][<?php echo $wp_module_key.'_'.$singleModule['api_name']; ?>]" 
																<?php @checked( $wpspli_smart_pipeliner_settings['synch']["{$wp_module_key}_{$singleModule['api_name']}"], 1 ); ?>
																value="1" />
																Enable
														</label>
													</fieldset>
												</td>
											</tr>
						            	<?php	
					            	}
					            }
					        }
					    }
					?>    
    				
				</tbody>
			</table>
			<p><input type='submit' class='button-primary' name="submit" value="<?php echo esc_html__( 'Save', 'wpspli-smart-pipeliner' ); ?>" /></p>
		
		<?php }?>	
		
	</form>
</div>