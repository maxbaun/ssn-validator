<?php
/**
 * Class ShorcodeResultsTest
 *
 * @package Sample_Plugin
 */

namespace D3\SSN;

use D3\SSN\Shortcodes\ShortcodeResults;

class ShorcodeResultsTest extends \WP_UnitTestCase
{
	public function testGetIssuedByRangeReturnsAStringWithTwoValidNumbers()
	{
		$res = ShortcodeResults::getIssuedByRange(1976, 1978);
		$exp = "1976 - 1978";
		$this->assertEquals($res, $exp);
	}

	public function testGetIssuedByRangeReturnsAStringWithTwoValidStrings()
	{
		$res = ShortcodeResults::getIssuedByRange("1976", "1978");
		$exp = "1976 - 1978";
		$this->assertEquals($res, $exp);
	}

	public function testGetIssuedByRangeReturnsTheFirstValueIfTheSecondValueIsNotPassedIn()
	{
		$res = ShortcodeResults::getIssuedByRange(1976);
		$exp = "1976";
		$this->assertEquals($res, $exp);
	}

	public function testGetIssuedByRangeReturnsTheFirstValueIfTheSecondValueIsUnknown()
	{
		$res = ShortcodeResults::getIssuedByRange(1976, 'unknown');
		$exp = "1976";
		$this->assertEquals($res, $exp);
	}

	public function testGetIssuedByRangeReturnsTheFirstValueIfTheSecondValueIsAnEmptyString()
	{
		$res = ShortcodeResults::getIssuedByRange(1976, '');
		$exp = "1976";
		$this->assertEquals($res, $exp);
	}

	public function testGetIssuedByRangeReturnsTheSecondValueIfTheFirstValueIsNull()
	{
		$res = ShortcodeResults::getIssuedByRange(null, 1976);
		$exp = "1976";
		$this->assertEquals($res, $exp);
	}

	public function testGetIssuedByRangeReturnsTheSecondValueIfTheFirstValueIsUnknown()
	{
		$res = ShortcodeResults::getIssuedByRange('unknown', 1976);
		$exp = "1976";
		$this->assertEquals($res, $exp);
	}

	public function testGetIssuedByRangeReturnsTheSecondValueIfTheFirstValueIsAnEmptyString()
	{
		$res = ShortcodeResults::getIssuedByRange('', 1976);
		$exp = "1976";
		$this->assertEquals($res, $exp);
	}

	public function testGetAgeByFirstIssuedReturnsAValidNumber()
	{
		$res = ShortcodeResults::getAgeByRange(1976);
		$this->assertEquals($res, 41);
	}

	public function testGetAgeByFirstIssuedReturnsAValidNumberWithAStringPassedIn()
	{
		$res = ShortcodeResults::getAgeByRange("1976");
		$this->assertEquals($res, 41);
	}

	public function testGetAgeByFirstIssuedReturnsNotAvailableStringIfAValueIsNotPassedIn()
	{
		$res = ShortcodeResults::getAgeByRange(null, 1976);
		$this->assertEquals($res, 41);
	}

	public function testGetAgeByFirstIssuedReturnsAValidAgeIfAnEmptyStringIsPassedIn()
	{
		$res = ShortcodeResults::getAgeByRange("", 1976);
		$this->assertEquals($res, 41);
	}

	public function testGetAgeByFirstIssuedReturnsNotAvailableStringIfUnknownIsPassedIn()
	{
		$res = ShortcodeResults::getAgeByRange("unknown", "unknown");
		$this->assertEquals($res, "Not Available");
	}

	public function testGetAgeByFirstIssuedReturnsAnAgeRangeIfBothArePassedIn()
	{
		$res = ShortcodeResults::getAgeByRange(1976, 1978);
		$this->assertEquals("39 to 41 yrs", $res);
	}
}
