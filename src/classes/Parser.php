<?php

namespace D3\SSN;

class Parser
{
	private $filename = '';
	private $start = 0;
	private $end = 100;
	private $data = array();
	private $fileContents = array();

	public function __construct($filename, $start, $end)
	{
		$this->data = array();
		$this->filename = $filename;
		$this->start = ((int)$start === 0) ? 1 : (int)$start;
		$this->end = (int)$end;
		$this->count = 0;
		$contents = file_get_contents($this->filename);
		$this->fileContents = explode("\n", $contents);
	}

	public function start()
	{
		$firstRow = $this->fileContents[0];
		$firstRowData = explode(",", $this->fileContents[0]);
		$firstRowCount = count($firstRowData);

		for ($c=0; $c < $firstRowCount; $c++) {
			$header[] = $firstRowData[$c];
		}

		$t = $this->end;

		if ($this->end === 0 || $this->end > $this->getTotal()) {
			$t = $this->getTotal();
		}

		for ($row = $this->start; $row < $t; $row++) {
			if ($row === $total - 1) {
				break;
			}

			$data = explode(",", $this->fileContents[$row]);

			$lineItem = array(
				'state' => $data[0],
				'ssn' => $data[1],
				'first_issued' => $data[2],
				'last_issued' => $data[3],
				'age' => $data[4]
			);

			$this->data[] = $lineItem;
		}
	}

	public function getTotal()
	{
		return count($this->fileContents) - 1;
	}

	public function getData()
	{
		return $this->data;
	}
}
