<?php
/**
 * Background Updater
 *
 * Uses https://github.com/A5hleyRich/wp-background-processing to handle DB updates in the background.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * The7_Background_Updater Class.
 */
class The7_Background_Updater extends \The7\Vendor\WP_Background_Processing\WP_Background_Process {

	/**
	 * @var string
	 */
	protected $action = 'the7_updater';

	/**
	 * Handle cron healthcheck
	 *
	 * Restart the background process if not already running
	 * and data exists in the queue.
	 */
	public function handle_cron_healthcheck() {
		if ( $this->is_process_running() ) {
			// Background process already running.
			return;
		}

		if ( $this->is_queue_empty() ) {
			// No data to process.
			$this->clear_scheduled_event();
			return;
		}

		$this->handle();
	}

	/**
	 * Handle
	 *
	 * Pass each queue item to the task handler, while remaining
	 * within server memory and time limit constraints.
	 */
	protected function handle() {
		$this->lock_process();

		do {
			$batch = $this->get_batch();

			foreach ( $batch->data as $key => $value ) {
				$task = $this->task( $value );

				if ( false !== $task ) {
					$batch->data[ $key ] = $task;
					break;
				} else {
					unset( $batch->data[ $key ] );
				}

				if ( $this->time_exceeded() || $this->memory_exceeded() ) {
					// Batch limits reached.
					break;
				}
			}

			// Update or delete current batch.
			if ( ! empty( $batch->data ) ) {
				$this->update( $batch->key, $batch->data );
			} else {
				$this->delete( $batch->key );
			}
		} while ( ! $this->time_exceeded() && ! $this->memory_exceeded() && ! $this->is_queue_empty() );

		$this->unlock_process();

		// Start next batch or complete process.
		if ( ! $this->is_queue_empty() ) {
			$this->dispatch();
		} else {
			$this->complete();
		}
	}

	/**
	 * Schedule fallback event.
	 */
	protected function schedule_event() {
		if ( ! wp_next_scheduled( $this->cron_hook_identifier ) ) {
			wp_schedule_event( time() + 10, $this->cron_interval_identifier, $this->cron_hook_identifier );
		}
	}

	/**
	 * Return true if updater is running.
	 *
	 * @return boolean
	 */
	public function is_updating() {
		return ! $this->is_queue_empty();
	}

	/**
	 * Return true if updater is locked.
	 *
	 * @return boolean
	 */
	public function is_locked() {
		return $this->is_process_running();
	}

	/**
	 * Get batches.
	 *
	 * @return stdClass Return the first batch from the queue
	 */
	public function get_batches() {
		global $wpdb;

		$table        = $wpdb->options;
		$column       = 'option_name';
		$key_column   = 'option_id';
		$value_column = 'option_value';

		if ( is_multisite() ) {
			$table        = $wpdb->sitemeta;
			$column       = 'meta_key';
			$key_column   = 'meta_id';
			$value_column = 'meta_value';
		}

		$key = $this->identifier . '_batch_%';

		$query = $wpdb->get_results(
			$wpdb->prepare(
				"
				SELECT *
				FROM {$table}
				WHERE {$column} LIKE %s
				ORDER BY {$key_column} ASC
				",
				$key
			)
		);

		$batches = array();
		foreach ( $query as $row ) {
			$batch       = new \stdClass();
			$batch->key  = $row->$column;
			$batch->data = maybe_unserialize( $row->$value_column );
			$batches[]   = $batch;
		}

		return $batches;
	}

	/**
	 * Task
	 *
	 * Override this method to perform any actions required on each
	 * queue item. Return the modified item for further processing
	 * in the next pass through. Or, return false to remove the
	 * item from the queue.
	 *
	 * @param string $callback Update callback function.
	 *
	 * @return mixed
	 */
	protected function task( $callback ) {
		if ( ! defined( 'THE7_UPDATING' ) ) {
			define( 'THE7_UPDATING', true );
		}

		// Bump db version shortcut.
		if ( is_string( $callback ) && strpos( $callback, 'bump_db_version_to_' ) === 0 ) {
			$version = str_replace( 'bump_db_version_to_', '', $callback );
			The7_Install::update_db_version( $version );

			return false;
		}

		$task = false;
		if ( isset( $callback['callback'], $callback['args'] ) && is_callable( $callback['callback'] ) ) {
			$task = call_user_func_array( $callback['callback'], (array) $callback['args'] );
		} elseif ( is_callable( $callback ) ) {
			$task = $callback();
		}

		return ( $task ?: false );
	}

	/**
	 * Complete
	 *
	 * Override if applicable, but ensure that the below actions are
	 * performed, or, call parent::complete().
	 */
	protected function complete() {
		parent::complete();

		if ( function_exists( 'presscore_refresh_dynamic_css' ) ) {
			presscore_refresh_dynamic_css();
		}
	}
}
