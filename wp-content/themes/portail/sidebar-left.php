<div id="sidebar">
	<?php if( !dynamic_sidebar( 'sidebar-left' ) ) : ?>
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-f1') )?> 			
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-f2') )?> 			
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-f3') )?> 			
	<?php endif; ?>
</div>
