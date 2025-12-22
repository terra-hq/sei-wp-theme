<?php
/**
 * Template for displaying status messages
 * 
 * @var string $message The message to display
 * @var string $type The message type ('success' or 'error')
 */
?>
<div class="status-message <?php echo esc_attr($type); ?>">
    <?php echo esc_html($message); ?>
</div>
