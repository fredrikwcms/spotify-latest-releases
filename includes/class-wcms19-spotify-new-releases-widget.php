<?php

/**
 * Adds Wcms19_Spotify_New_Releases widget.
 */

class Wcms19_Spotify_New_Releases_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'wcms19-spotify-new-releases', // Base ID
			'WCMS19 Spotify New Releases', // Name
			[
				'description' => __('A Widget for displaying latest releases from Spotify', 'wcms19-spotify-new-releases'),
			] // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);

		// start widget
		echo $before_widget;

		// title
		if (! empty($title)) {
			echo $before_title . $title . $after_title;
		}

		// content
		?>
			<div class="content">
				<span class="loading">
					<marquee behavior="alternate"><?php _e('Loading...', 'wcms19-spotify-new-releases'); ?></marquee>
				</span>
			</div>
		<?php

		$spotify_api = new SpotifyAPI(SPOTIFY_NEW_RELEASES_CLIENT_ID, SPOTIFY_NEW_RELEASES_CLIENT_SECRET);
		$releases = $spotify_api->getNewReleases();
		var_dump($spotify_api);

		// close widget
		echo $after_widget;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance) {
		if (isset($instance['title'])) {
			$title = $instance['title'];
		} else {
			$title = __('Latest Hits', 'wcms19-spotify-new-releases');
		}

		if (isset($instance['client_id'])) {
			$client_id = $instance['client_id'];
		} else {
			$client_id = '';
		}

		if (isset($instance['client_secret'])) {
			$client_secret = $instance['client_secret'];
		} else {
			$client_secret = '';
		}

		?>

		<!-- title -->
		<p>
			<label
				for="<?php echo $this->get_field_name('title'); ?>"
			>
				<?php _e('Title:'); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo $this->get_field_id('title'); ?>"
				name="<?php echo $this->get_field_name('title'); ?>"
				type="text"
				value="<?php echo esc_attr($title); ?>"
			/>
		</p>
		<!-- /title -->
		<!-- client_id -->
		<p>
			<label
				for="<?php echo $this->get_field_name('client_id'); ?>"
			>
				<?php _e('Client ID'); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo $this->get_field_id('client_id'); ?>"
				name="<?php echo $this->get_field_name('client_id'); ?>"
				type="text"
				value="<?php echo esc_attr($client_id); ?>"
			/>
		</p>
		<!-- /client_id -->
		<!-- client_secret -->
		<p>
			<label
				for="<?php echo $this->get_field_name('client_secret'); ?>"
			>
				<?php _e('Client Secret'); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo $this->get_field_id('client_secret'); ?>"
				name="<?php echo $this->get_field_name('client_secret'); ?>"
				type="password"
				value="<?php echo esc_attr($client_secret); ?>"
			/>
		</p>
		<!-- /client_secret -->
	<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update($new_instance, $old_instance) {
		$instance = [];

		$instance['title'] = (!empty($new_instance['title']))
			? strip_tags($new_instance['title'])
			: '';

		$instance['client_id'] = (!empty($new_instance['client_id']))
			? strip_tags($new_instance['client_id'])
			: '';

		$instance['client_secret'] = (!empty($new_instance['client_secret']))
			? strip_tags($new_instance['client_secret'])
			: '';
		return $instance;
	}

} // class Wcms19_Spotify_New_Releases_Widget