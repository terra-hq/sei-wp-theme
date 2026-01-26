<?php
/**
 * Template for the modules table
 * 
 * @var array $modules The modules data
 * @var ACF_Module_Descriptions $this The class instance for accessing methods
 */
?>
<div class="module-description-intro">
    <p>Manage descriptions for all ACF flexible content modules and heros. These descriptions can help document how to use each module/hero.</p>
</div>

<table class="wp-list-table widefat fixed striped responsive">
    <thead>
        <tr>
            <th class="column-primary column-name">Name</th>
            <th class="column-secondary column-slug">ACF Slug</th>
            <th class="column-secondary column-type">Type</th>
            <th class="column-secondary column-description">Description</th>
            <th class="column-secondary column-preview">Preview</th>
            <th class="column-secondary column-actions">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($modules) > 0): ?>
            <?php foreach ($modules as $slug => $module): ?>
                <tr>
                    <td class="column-primary">
                        <?php echo esc_html($module['label']); ?>
                        <button type="button" class="toggle-row" aria-label="Mostrar más detalles"></button>
                    </td>
                    <td data-colname="ACF Slug"><code><?php echo esc_html($slug); ?></code></td>
                    <td data-colname="Type"><?php echo ucfirst(esc_html($module['type'])); ?></td>
                    <td data-colname="Description" class="column-description">
                        <?php 
                            $has_desc = !empty($this->get_module_description($slug));
                            echo $has_desc ? '<span class="status-check">✓</span>' : '<span class="status-x">✗</span>';
                        ?>
                    </td>
                    <td data-colname="Preview" class="column-preview">
                        <?php 
                            $has_preview = $this->module_has_preview($slug);
                            if ($has_preview) {
                                $preview_url = $this->get_module_preview_url($slug);
                                echo '<a href="' . esc_url($preview_url) . '" target="_blank" title="View preview image"><span class="status-check">✓</span></a>';
                            } else {
                                echo '<span class="status-x">✗</span>';
                            }
                        ?>
                    </td>
                    <td data-colname="Actions">
                        <a href="<?php echo admin_url('admin.php?page=acf-module-descriptions&module=' . urlencode($slug)); ?>" class="button">
                            <?php echo $this->get_action_button_text($has_desc, $has_preview); ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="column-primary">
                    No modules or heros found. Make sure ACF is installed and fields are configured.
                    <button type="button" class="toggle-row" aria-label="Mostrar más detalles"></button>
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
