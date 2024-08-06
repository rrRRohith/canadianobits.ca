<?php
/**
 * Revisions class with database interaction, data, and methods.
 *
 * @package CFF.
 * @since 1.0.232
 */

if ( ! class_exists( 'CPCFF_REVISIONS' ) ) {
	class CPCFF_REVISIONS {

		/**
		 * CPCFF_FORM instance
		 */
		private $_form_obj;

		/**
		 * List of revisions rows corresponding to the form
		 */
		private $_revisions;

		/**
		 * Instance of the $wpdb object
		 */
		private $_db;

		/**
		 * Name of revisions table
		 */
		private $_table;

		/**
		 * The number of revisions per form
		 */
		private $_max = 20;

		/**
		 * Constructs a CPCFF_REVISIONS object.
		 *
		 * @param integer $form_obj instance of CPCFF_FORM
		 */
		public function __construct( $form_obj ) {
			global $wpdb;
			$this->_db       = $wpdb;
			$this->_table    = $wpdb->prefix . CP_CALCULATEDFIELDSF_FORMS_REVISIONS_TABLE;
			$this->_form_obj = $form_obj;
		} // End construct

		/**
		 * Returns the list of revisions rows in the database as array
		 */
		public function revisions_list() {
			if ( empty( $this->_revisions ) ) {
				$results            = $this->_db->get_results(
					$this->_db->prepare(
						'SELECT * FROM ' . $this->_table . ' WHERE formid=%d ORDER BY time DESC',
						$this->_form_obj->get_id()
					),
					ARRAY_A
				);
				  $this->_revisions = array();
				foreach ( $results as $revision ) {
					$this->_revisions[ $revision['id'] ] = $revision;
				}
			}
			return $this->_revisions;

		} // End revisions_list

		/**
		 * Creates a new entry in the revisions table, if there are more than _max revisions remove the older.
		 *
		 * @return int returns the revision's id or false if fails.
		 */
		public function create_revision() {
			 $form_data = $this->_form_obj->get_raw_data();

			$data = array(
				'formid'   => $this->_form_obj->get_id(),
				'time'     => current_time( 'mysql' ),
				'revision' => serialize( $form_data ),
			);

			if (
				$this->_db->insert(
					$this->_table,
					$data,
					array( '%d', '%s', '%s' )
				)
			) {
				$this->revisions_list();
				$data['id']                      = $this->_db->insert_id;
				$this->_revisions[ $data['id'] ] = $data;
				krsort( $this->_revisions );
				if ( $this->_max < count( $this->_revisions ) ) {
					array_splice( $this->_revisions, $this->_max );
					$this->_delete_older();
				}
				return $data['id'];
			}
			return false;
		} // End create_revision

		/**
		 * returns the form data unserialized or an empty array
		 */
		public function data( $revision_id ) {
			$this->revisions_list();
			if (
				! empty( $this->_revisions ) &&
				isset( $this->_revisions[ $revision_id ] )
			) {
				return unserialize( $this->_revisions[ $revision_id ]['revision'] );
			}
			return array();
		} // End data

		/**
		 * Deletes the list of revisions belonging to the form
		 */
		public function delete_form() {
			$this->_db->delete(
				$this->_table,
				array( 'formid' => $this->_form_obj->get_id() ),
				array( '%d' )
			);
			$this->_revisions = array();
		} // End delete_form


		/*********************************** PRIVATE METHODS  ********************************************/

		/**
		 * Deletes the older revisions, leaving only the _max
		 */
		private function _delete_older() {
			$formid = $this->_form_obj->get_id();
			$this->_db->query(
				$this->_db->prepare(
					'DELETE FROM ' . $this->_table . ' WHERE formid=%d AND id IN (SELECT * FROM (SELECT id FROM ' . $this->_table . ' WHERE formid=%d ORDER BY time DESC LIMIT %d,18446744073709551615) AS tmp)',
					$formid,
					$formid,
					$this->_max
				)
			);
		} // End _delete_older
	} // End CPCFF_REVISIONS
}
