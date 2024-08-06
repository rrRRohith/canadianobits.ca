<?php

namespace FernleafSystems\Wordpress\Services\Core;

class Db {

	/**
	 * @var \wpdb
	 */
	protected $wpdb;

	private $resultShowTables;

	/**
	 * @return array
	 */
	public function dbDelta( string $sql ) {
		require_once( ABSPATH.'wp-admin/includes/upgrade.php' );
		return dbDelta( $sql );
	}

	/**
	 * @return false|int
	 */
	public function deleteRowsFromTableWhere( string $table, array $where ) {
		return $this->loadWpdb()->delete( $table, $where );
	}

	/**
	 * Will completely remove this table from the database
	 * @return bool|int
	 */
	public function doDropTable( string $table ) {
		return $this->doSql( sprintf( 'DROP TABLE IF EXISTS `%s`', $table ) );
	}

	/**
	 * Alias for doTruncateTable()
	 * @return bool|int
	 */
	public function doEmptyTable( string $table ) {
		return $this->doTruncateTable( $table );
	}

	/**
	 * Given any SQL query, will perform it using the WordPress database object.
	 * @return mixed|int|bool (number of rows affected or just true/false)
	 */
	public function doSql( string $sqlQuery ) {
		return $this->loadWpdb()->query( $sqlQuery );
	}

	/**
	 * @return bool|int
	 */
	public function doTruncateTable( string $table ) {
		return $this->getIfTableExists( $table ) ?
			$this->doSql( sprintf( 'TRUNCATE TABLE `%s`', $table ) )
			: false;
	}

	public function getCharCollate() :string {
		return $this->getWpdb()->get_charset_collate();
	}

	public function tableExists( string $table ) :bool {
		$tables = $this->showTables();
		return empty( $tables ) ?
			!\is_null( $this->getVar( sprintf( "SHOW TABLES LIKE '%s'", $table ) ) )
			: \in_array( \strtolower( $table ), $tables );
	}

	public function showTables() :array {
		if ( !isset( $this->resultShowTables ) ) {
			$res = $this->selectCustom( "SHOW TABLES" );
			$this->resultShowTables = \array_filter( \array_map(
				function ( $table ) {
					return \strtolower( \is_array( $table ) ? (string)\current( $table ) : '' );
				},
				\is_array( $res ) ? $res : []
			) );
		}
		return $this->resultShowTables;
	}

	/**
	 * @param string   $tableName
	 * @param callable $callBack
	 * @return array
	 */
	public function getColumnsForTable( $tableName, $callBack = '' ) :array {
		$columns = $this->loadWpdb()->get_col( "DESCRIBE ".$tableName );

		if ( !empty( $callBack ) && \function_exists( $callBack ) ) {
			return \array_map( $callBack, $columns );
		}
		return \is_array( $columns ) ? $columns : [];
	}

	public function getPrefix( bool $siteBase = true ) :string {
		return $siteBase ? $this->loadWpdb()->base_prefix : $this->loadWpdb()->prefix;
	}

	public function getAllTables( string $filter = '' ) :array {
		$showRes = $this->selectCustom( sprintf( "SHOW TABLES%s", empty( $filter ) ? '' : 'LIKE '.$filter ) );
		return \array_map(
			function ( $res ) {
				return \array_pop( $res );
			},
			\is_array( $showRes ) ? $showRes : []
		);
	}

	public function getTable_Comments() :string {
		return $this->loadWpdb()->comments;
	}

	public function getTable_Options() :string {
		return $this->loadWpdb()->options;
	}

	public function getTable_Posts() :string {
		return $this->loadWpdb()->posts;
	}

	public function getTable_Users() :string {
		return $this->loadWpdb()->users;
	}

	public function getMysqlServerInfo() :string {
		$db = $this->loadWpdb();
		$info = \method_exists( $db, 'db_server_info' ) ?
			$db->db_server_info() : \mysqli_get_server_info( $db->dbh );
		return (string)$info;
	}

	/**
	 * @param string $sql
	 * @return null|mixed
	 */
	public function getVar( $sql ) {
		return $this->loadWpdb()->get_var( $sql );
	}

	/**
	 * @param string $table
	 * @param array  $data
	 * @return int|bool
	 */
	public function insertDataIntoTable( $table, $data ) {
		return $this->loadWpdb()->insert( $table, $data );
	}

	/**
	 * @param string $table
	 * @param string $format
	 * @return mixed
	 */
	public function selectAllFromTable( string $table, $format = ARRAY_A ) {
		return $this->loadWpdb()
					->get_results( sprintf( "SELECT * FROM `%s` WHERE `deleted_at` = 0", $table ), $format );
	}

	/**
	 * @param string $query
	 * @param        $format
	 * @return array|bool
	 */
	public function selectCustom( $query, $format = ARRAY_A ) {
		return $this->loadWpdb()->get_results( $query, $format );
	}

	/**
	 * @param string $query
	 * @param string $format
	 * @return null|object|array
	 */
	public function selectRow( string $query, $format = ARRAY_A ) {
		return $this->loadWpdb()->get_row( $query, $format );
	}

	/**
	 * @param string $table
	 * @param array  $data  - new insert data (associative array, column=>data)
	 * @param array  $where - insert where (associative array)
	 * @return int|bool (number of rows affected)
	 */
	public function updateRowsFromTableWhere( string $table, array $data, array $where ) {
		return $this->loadWpdb()->update( $table, $data, $where );
	}

	public function loadWpdb() :\wpdb {
		if ( !$this->wpdb instanceof \wpdb ) {
			$this->wpdb = $this->getWpdb();
		}
		return $this->wpdb;
	}

	/**
	 * @return \wpdb
	 */
	private function getWpdb() {
		global $wpdb;
		return $wpdb;
	}

	public function clearResultShowTables() :self {
		unset( $this->resultShowTables );
		return $this;
	}

	/**
	 * @deprecated 2.25
	 */
	public function getIfTableExists( string $table ) :bool {
		return $this->tableExists( $table );
	}
}