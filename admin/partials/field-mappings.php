<div class="loader"></div>

<form method="post" action="<?php echo admin_url('/admin.php?page=wpspli-smart-pipeliner-mappings') ?>" id="wpspli-smart-pipeliner-mappings-form">

    <h2><?php echo esc_html__('Fields Mapping', 'wpspli-smart-pipeliner'); ?></h2>

    <table class="form-table">
        <!-- WP Modules Row -->
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label><?php echo  esc_html__( 'WP Modules', 'wpspli-smart-pipeliner' ); ?></label>
            </th>
            <td class="forminp forminp-text">
                <select name="wp_module">
                    <option><?php echo  esc_html__('Select Module', 'wpspli-smart-pipeliner'); ?></option>
                    <?php 
                        if($wp_modules){
                            foreach ($wp_modules as $key => $singleModule) {
                                ?>            
                                <option value = "<?php echo $key; ?>"><?php echo esc_html__($singleModule, 'wpspli-smart-pipeliner'); ?></option>
                                <?php            
                            }
                        }
                    ?>
                </select>
            </td>
        </tr>

        <!-- WP Fields Row -->
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label><?php echo  esc_html__( 'WP Fields', 'wpspli-smart-pipeliner' ); ?></label>
            </th>
            <td class="forminp forminp-text">
                <select name="wp_field">
                    <option><?php echo  esc_html__('Please select WP Modules', 'wpspli-smart-pipeliner'); ?></option>
                </select>
            </td>
        </tr>

        <!-- Zoho Modules Row -->
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label><?php echo  esc_html__( 'Zoho Modules', 'wpspli-smart-pipeliner' ); ?></label>
            </th>
            <td class="forminp forminp-text">
                <select name="pipeliner_module">
                    <option><?php echo  esc_html__('Select Zoho Module', 'wpspli-smart-pipeliner'); ?></option>
                    <?php
                        $pipeliner_modules_options = "";

                        if($getListModules['modules']){
                            foreach ($getListModules['modules'] as $key => $singleModule) {
                                if( $singleModule['deletable'] &&  $singleModule['creatable'] ){
                    ?>
                                <option value = '<?php echo $singleModule['api_name']; ?>'> 
                                    <?php echo  esc_html__($singleModule['plural_label'], 'wpspli-smart-pipeliner'); ?>
                                </option>
                    <?php                
                                }
                            }
                        }
                    ?>
                </select>
            </td>
        </tr>

        <!-- Zoho Fields Row -->
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label><?php echo  esc_html__( 'Zoho Fields', 'wpspli-smart-pipeliner' ); ?></label>
            </th>
            <td class="forminp forminp-text">
                <select name="pipeliner_field">
                    <option><?php echo  esc_html__('Please select Zoho Modules', 'wpspli-smart-pipeliner'); ?></option>
                </select>
            </td>
        </tr>

        <!-- Zoho Modules Row -->
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label><?php echo  esc_html__( 'Status', 'wpspli-smart-pipeliner' ); ?></label>
            </th>
            <td class="forminp forminp-text">
                <select name="status">
                    <option value="active"><?php echo esc_html__( 'Active', 'wpspli-smart-pipeliner' ); ?></option>
                    <option value="inactive"><?php echo esc_html__( 'In Active', 'wpspli-smart-pipeliner' ); ?></option>
                </select>
            </td>
        </tr>

        <!-- Zoho Modules Row -->
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label><?php echo esc_html__( 'Description', 'wpspli-smart-pipeliner' ); ?></label>
            </th>
            <td class="forminp forminp-text">
                <textarea name="description" rows="5" cols="46"></textarea>
            </td>
        </tr>

    </table>

    <p class="submit">
        <input type="submit" name="add_mapping" class="button-primary woocommerce-save-button" value="<?php echo  esc_html__( 'Add Mapping', 'wpspli-smart-pipeliner' ); ?>">
    </p>
</form>