<?php
/**
 * Uninstall
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

$options = get_option( 'unlinebreak' );
if ( $options['lnt'] )
	delete_option( 'unlinebreak' );
