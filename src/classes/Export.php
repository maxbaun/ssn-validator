<?php

namespace D3\SSN;

class Export
{
	public static function init()
	{
		add_action('wp_ajax_ssn_validator_export_data', array('D3\\SSN\\Export', 'exportData'));
	}

	public static function exportLink()
	{
		$ajaxUrl = admin_url('admin-ajax.php');
		$ajaxUrl = "admin-ajax.php?action=ssn_validator_export_data";
		return esc_url($ajaxUrl);
	}

	public static function exportData()
	{
		$csvHeaders = array();

		$ssns = SSNData::getAll();
		$csvData = self::parseDataForCsv($ssns);

		if ($ssns) {
			$now = new \DateTime();

			$fileName = 'ssn-validator-data-' . $now->format('Ymd') . '.csv';
			$path = plugin_dir_path(dirname(dirname(__FILE__))) . 'exports/' . $fileName;

			$fp = \fopen($path, 'w');

			foreach ($csvData[0] as $key => $value) {
				\array_push($csvHeaders, $key);
			}

			\fputcsv($fp, $csvHeaders);

			foreach ($csvData as $ssn) {
				\fputcsv($fp, $ssn);
			}

			$fp = \fopen($path, 'r');
			$fc = \fread($fp, filesize($path));
			\fclose($fp);

			\header('Content-type: application/csv');
			\header('Content-Disposition: attachment; filename=' . $fileName);
			echo $fc;

			exit;
		}

		return false;
	}

	private static function parseDataForCsv($data)
	{
		$returnData = array();
		foreach ($data as $row) {
			array_push($returnData, array(
				'STATE' => $row->state,
				'SSN' => $row->ssn,
				'FIRSTISSUED' => $row->first_issued,
				'LASTISSUED' => $row->last_issued,
				'ESTAGE' => $row->age
			));
		}

		return $returnData;
	}
}
