<?php

namespace D3\SSN;

use D3\SSN\Ajax;
use D3\SSN\SSNData;

class Import
{
	public static function init()
	{
		add_action('wp_ajax_ssn_validator_parse_csv', array('D3\\SSN\\Import', 'parseData'));
		add_action('wp_ajax_nopriv_ssn_validator_parse_csv', array('D3\\SSN\\Import', 'parseData'));
		add_action('wp_ajax_ssn_validator_import_data', array('D3\\SSN\\Import', 'importData'));
	}

	public static function importData()
	{
		try {
			$stateColumn = (isset($_POST['ssn_validator_state_column'])) ? (int)$_POST['ssn_validator_state_column'] : 0;
			$ssnColumn = (isset($_POST['ssn_validator_ssn_column'])) ? (int)$_POST['ssn_validator_ssn_column'] : 0;
			$firstIssuedColumn = (isset($_POST['ssn_validator_first_issued_column'])) ? (int)$_POST['ssn_validator_first_issued_column'] : 0;
			$lastIssuedColumn = (isset($_POST['ssn_validator_last_issued_column'])) ? (int)$_POST['ssn_validator_last_issued_column'] : 0;
			$ageIssuedColumn = (isset($_POST['ssn_validator_age_column'])) ? (int)$_POST['ssn_validator_age_column'] : 0;

			$rows = (isset($_POST['ssn_validator_import_rows'])) ? $_POST['ssn_validator_import_rows'] : array();

			foreach ($rows as &$rowId) {
				$data = array(
					'state' => (string)$_POST['s_' . $rowId . '_' . $stateColumn],
					'ssn' => (string)$_POST['s_' . $rowId . '_' . $ssnColumn],
					'first_issued' => (string)$_POST['s_' . $rowId . '_' . $firstIssuedColumn],
					'last_issued' => (string)$_POST['s_' . $rowId . '_' . $lastIssuedColumn],
					'age' => (string)$_POST['s_' . $rowId . '_' . $ageColumn]
				);

				SSNData::insertRow($data);
			}

			Ajax::returnJson(array(
				'status' => 1,
				'message' => 'Data imported successfully'
			));
		} catch (Exception $e) {
			Ajax::returnJson(array(
				'status' => 0,
				'error' => $e->getMessage()
			));
		}
	}

	public static function parseData()
	{
		try {
			$attachmentId = (isset($_POST['ssn_validator_import_file_id'])) ? $_POST['ssn_validator_import_file_id'] : 0;

			$filename = get_attached_file($attachmentId);

			if (!$filename) {
				Ajax::returnJson(array(
					'status' => 0,
					'error' => 'File does not exist'
				));
			}

			$csvData = self::parseCsv($filename);

			if (!$csvData) {
				Ajax::returnJson(array(
					'status' => 0,
					'error' => 'Error parsing CSV'
				));
			}

			$result = array(
				'status' => 1,
				'message' => 'CSV Import data parsed successfully',
				'data' => $csvData
			);
		} catch (Exception $e) {

		}

		Ajax::returnJson($result);
	}

	public static function parseCsv($filename)
	{
		ini_set('auto_detect_line_endings', true);
		ini_set('memory_limit', '100m');

		if (!\file_exists($filename) || !\is_readable($filename)) {
			return false;
		}

		$return_data = array();

		try {
			$handle = \fopen($filename, 'r');

			if ($handle) {
				$row = 0;

				while (($data = \fgetcsv($handle, 0, ",")) !== false) {
			        $num = \count($data);
			        $row++;
			        $row_data = array();
			        for ($c=0; $c < $num; $c++) {
						if ($row == 1) {
							$header[] = $data[$c];
						} else {
							$return_data[$row-2][$header[$c]] = $data[$c];
						}
			        }
			    }

				\fclose($handle);
			}
		} catch (Exception $e) {

		}


		return $return_data;
	}
}
