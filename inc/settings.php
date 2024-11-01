<?php
/**
 * Settings
 */
$unlinebreak = get_option( 'unlinebreak' );
?>

<h3><?php _e( 'A very specific purpose', 'un-line-break' ); ?></h3>

<p><?php _e( 'Normally, in the post editor, placing shortcodes on separate lines (like HTML formatting) results in extra line breaks in the rendered output, thanks to the WordPress auto-paragraph function (wpautop).', 'un-line-break' ); ?></p>

<p><?php _e( 'This plugin removes those extra line breaks from the rendered output so, in the post editor, you can place shortcodes on separate lines, thus making it easier to read and edit them.', 'un-line-break' ); ?></p>

<p><?php _e( 'It will not remove any double-spacing or <code>&lt;p&gt;</code> or <code>&lt;br&gt;</code> tags that you have added.', 'un-line-break' ); ?></p>

<p><a href="https://strongdemos.com/un-line-break/" target="_blank"><?php _e( 'See examples here', 'un-line-break' ); ?></a>.</p>

<h3><?php _e( 'Select which shortcodes to un-line-break', 'un-line-break' ); ?></h3>

<p><?php _e( 'Only shortcodes that use content need to be selected. For example, those that create columns or tabs.', 'un-line-break' ); ?></p>

<?php foreach ( $groups as $key => $shortcodes ) : ?>
	<div class="unlinebreak-group">
		<div class="unlinebreak-group-header">
			<strong><?php echo $key; ?></strong>
			<div class="buttons">
				<input type="button" class="button select-all" value="<?php _e( 'select all', 'un-line-break' ); ?>">
				<input type="button" class="button deselect-all" value="<?php _e( 'deselect all', 'un-line-break' ); ?>">
			</div>
		</div>
		<div class="columned">
			<?php foreach ( $shortcodes as $shortcode ) : ?>
				<label>
					<input type="checkbox" class="shortcode" name="unlinebreak[shortcodes][]" value="<?php esc_attr_e( $shortcode ); ?>"<?php checked( $unlinebreak['shortcodes'] ? in_array( $shortcode, $unlinebreak['shortcodes'] ) : false ); ?> /><?php echo $shortcode; ?>
				</label>
			<?php endforeach; ?>
		</div>
	</div>
<?php endforeach; ?>

<div class="leave-no-trace">
	<h3><?php _e( 'Leave No Trace', 'un-line-break' ); ?></h3>
	<label>
		<select name="unlinebreak[lnt]">
			<option value="1" <?php selected( $unlinebreak['lnt'], 1 ); ?>>
				<?php _e( 'YES - Deleting this plugin will also delete these settings.', 'un-line-break' ); ?>
			</option>
			<option value="0" <?php selected( $unlinebreak['lnt'], 0 ); ?>>
				<?php _e( 'NO - These settings will remain after deleting this plugin.', 'un-line-break' ); ?>
			</option>
		</select>
	</label>
	<p class="description"><?php _e( 'Deactivating this plugin will not delete anything.', 'un-line-break' ); ?></p>
</div>

<?php submit_button(); ?>
