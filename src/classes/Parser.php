<?php

namespace D3\SSN;

class Parser
{
	private $filename = '';
	private $begin = 0;
	private $chunk = 100;
	private $data = array();

	public function __construct($filename, $begin, $chunk)
	{
		$this->filename = $filename;
		$this->begin = ((int)$begin === 0) ? 1 : (int)$begin;
		$this->chunk = (int)$chunk;
	}

	public function start()
	{
		$contents = file_get_contents($this->filename);
		$rows = explode("\n", $contents);
		$total = count($rows);

		$firstRow = $rows[0];
		$firstRowData = explode(",", $rows[0]);
		$firstRowCount = count($firstRowData);

		for ($c=0; $c < $firstRowCount; $c++) {
			$header[] = $firstRowData[$c];
		}

		for ($row = $this->begin; $row < $this->chunk + $this->begin; $row++) {
			if ($row === $total - 1) {
				break;
			}

			$data = explode(",", $rows[$row]);
			$count = count($data);

			for ($c=0; $c < $count; $c++) {
				$this->data[$row - 1][$header[$c]] = $data[$c];
			}
		}
	}

	public function getData()
	{
		return $this->data;
	}
}
