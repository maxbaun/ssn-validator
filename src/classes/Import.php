<?php

namespace D3\SSN;

use D3\SSN\Ajax;
use D3\SSN\SSNData;
use D3\SSN\Parser;

class Import
{
	public static function init()
	{
		add_action('wp_ajax_ssn_validator_get_total_csv_rows', array('D3\\SSN\\Import', 'getTotalRows'));
		add_action('wp_ajax_ssn_validator_parse_csv', array('D3\\SSN\\Import', 'parseData'));
	}

	private function getFile($attachmentId)
	{
		$filename = get_attached_file($attachmentId);

		if (!\file_exists($filename) || !\is_readable($filename)) {
			return false;
		}

		return $filename;
	}

	public static function getTotalRows()
	{
		$attachmentId = (isset($_POST['ssn_validator_import_file_id'])) ? $_POST['ssn_validator_import_file_id'] : 0;
		$data = array();
		try {
			$filename = self::getFile($attachmentId);

			if (!$filename) {
				return false;
			}

			$parser = new Parser($filename);
			$data = $parser->getTotal();
		} catch (Exception $e) {
			Ajax::error($e->getMessage());
		}

		Ajax::success('', $data);
	}

	public static function parseData()
	{
		try {
			$attachmentId = (isset($_POST['fileid'])) ? $_POST['fileid'] : 0;
			$start = (isset($_POST['start'])) ? (int)$_POST['start'] : 1;
			$end = (isset($_POST['end'])) ? (int)$_POST['end'] : 1000;

			$filename = self::getFile($attachmentId);

			if (!$filename) {
				Ajax::error('File does not exist');
			}

			$parser = new Parser($filename, $start, $end);
			$parser->start();
			$data = $parser->getData();

			if (count($data)) {
				self::insertData($data);
			}
		} catch (Exception $e) {
			Ajax::error($e->getMessage());
		}

		Ajax::success('CSV Import data parsed successfully', $csvData);
	}

	private static function insertData($data)
	{
		foreach ($data as $row) {
			SSNData::insertRow($row);
		}
	}
}
