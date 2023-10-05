<?php
    global $wpdb;
    $fieldlists = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}smart_pipeliner_field_mapping");
?>
    <h2><?php echo esc_html__('Fields Mapping List'); ?></h2>

    <table id="mapping-list-table" class="wp-list-table widefat fixed striped table-view-list display">
        <thead>
            <th><?php echo esc_html__('Id', 'wpspli-smart-pipeliner'); ?></th>
            <th><?php echo esc_html__('Zoho Module', 'wpspli-smart-pipeliner'); ?></th>
            <th><?php echo esc_html__('Zoho Field', 'wpspli-smart-pipeliner'); ?></th>
            <th><?php echo esc_html__('WP Module', 'wpspli-smart-pipeliner'); ?></th>
            <th><?php echo esc_html__('WP Field', 'wpspli-smart-pipeliner'); ?></th>
            <th><?php echo esc_html__('Status', 'wpspli-smart-pipeliner'); ?></th>
            <th><?php echo esc_html__('Description', 'wpspli-smart-pipeliner'); ?></th>
            <th><?php echo esc_html__('Action', 'wpspli-smart-pipeliner'); ?></th>
        </thead>

        <tfoot>
            <th><?php echo esc_html__('Id', 'wpspli-smart-pipeliner'); ?></th>
            <th><?php echo esc_html__('Zoho Module', 'wpspli-smart-pipeliner'); ?></th>
            <th><?php echo esc_html__('Zoho Field', 'wpspli-smart-pipeliner'); ?></th>
            <th><?php echo esc_html__('WP Module', 'wpspli-smart-pipeliner'); ?></th>
            <th><?php echo esc_html__('WP Field', 'wpspli-smart-pipeliner'); ?></th>
            <th><?php echo esc_html__('Status', 'wpspli-smart-pipeliner'); ?></th>
            <th><?php echo esc_html__('Description', 'wpspli-smart-pipeliner'); ?></th>
            <th><?php echo esc_html__('Action', 'wpspli-smart-pipeliner'); ?></th>
        </tfoot>
        <tbody>
            <!-- WP Modules Row -->
            <?php
                if ( $fieldlists ) {
                    foreach ( $fieldlists as $singlelist ) {
                        ?>
                        <tr>
                            <td><?php echo esc_html__($singlelist->id, 'wpspli-smart-pipeliner'); ?></td>
                            <td><?php echo esc_html__($singlelist->pipeliner_module, 'wpspli-smart-pipeliner'); ?></td>
                            <td><?php echo esc_html__($singlelist->pipeliner_field, 'wpspli-smart-pipeliner'); ?></td>
                            <td><?php echo esc_html__($singlelist->wp_module, 'wpspli-smart-pipeliner'); ?></td>
                            <td><?php echo esc_html__($singlelist->wp_field, 'wpspli-smart-pipeliner'); ?></td>
                            <td><?php echo ucfirst( esc_html__($singlelist->status, 'wpspli-smart-pipeliner') ); ?></td>
                            <td><?php echo esc_html__($singlelist->description, 'wpspli-smart-pipeliner'); ?></td>
                            <td>
                                <?php if($singlelist->is_predefined != 'yes' ){ ?>
                                    <a href="<?php echo admin_url('admin.php?page=wpspli-smart-pipeliner-mappings&action=trash&id='.$singlelist->id); ?>">
                                        <button type="submit"><?php echo esc_html__('Delete', 'wpspli-smart-pipeliner'); ?></button>
                                    </a>
                                <?php }?>
                            </td>
                        </tr>
                        <?php
                    }   
                } else {
                    ?>
                    <tr>
                        <td colspan="7">
                            <?php echo esc_html__('No Record Found', 'wpspli-smart-pipeliner'); ?>
                        </td>
                    </tr>
                    <?php
                }
            ?>
        </tbody>
    </table>