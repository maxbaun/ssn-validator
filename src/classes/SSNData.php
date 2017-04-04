<?php

namespace D3\SSN;

class SSNData
{
	private static $tableName = "ssn_validator_data";

	public static function getAll()
	{
		global $wpdb;

		$tableName = $wpdb->prefix . "ssn_validator_data";

		$query = $wpdb->prepare(
			"
				SELECT * FROM $tableName
			",
			$tableName
		);

		$data = $wpdb->get_results($query);

		return self::query();
	}

	public static function insertRow($data)
	{
		global $wpdb;
		$tableName = $wpdb->prefix . self::$tableName;

		$wpdb->insert(
			$tableName,
			$data
		);
	}

	public static function getRowBySSN($ssn)
	{
		return self::query(array('ssn' => $ssn));
	}

	private static function query($args = array())
	{
		global $wpdb;
		$tableName = $wpdb->prefix . self::$tableName;

		$query = "SELECT * FROM $tableName";

		if ($args['ssn']) {
			$query = $wpdb->prepare(
				"
					SELECT * FROM $tableName
					WHERE ssn = %s
				",
				$args['ssn']
			);
		}

		$data = $wpdb->get_results($query);

		return $data;
	}
}
