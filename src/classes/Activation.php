<?php

namespace D3\SSN;

class Activation
{
	public static function init()
	{
		self::createDb();
	}

	private static function createDb()
	{
		global $wpdb;

		try {
			$tableName = $wpdb->prefix . "ssn_validator_data";
			$charset = $wpdb->get_charset_collate();

			$sql = "CREATE TABLE $tableName (
				id mediumint(11) NOT NULL AUTO_INCREMENT,
				ssn varchar(16) NOT NULL,
				state varchar(50) NOT NULL,
				first_issued varchar(10) NOT NULL,
				last_Issued varchar(10) NOT NULL,
				age varchar(50) NOT NULL,
				UNIQUE KEY id (id)
			) $charset;";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

			$resp = dbDelta($sql);

			return true;
		} catch (Exception $e) {
			var_dump($e->getMessage());
			die();
		}

		return true;
	}
}
