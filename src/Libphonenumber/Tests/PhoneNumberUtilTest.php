<?php

namespace Libphonenumber;

require_once dirname(__FILE__) . '/../PhoneNumberUtil.php';
require_once dirname(__FILE__) . '/../RegionCode.php';
require_once dirname(__FILE__) . '/../PhoneNumber.php';
require_once dirname(__FILE__) . '/../CountryCodeToRegionCodeMapForTesting.php';

/**
 * Test class for PhoneNumberUtil.
 * Generated by PHPUnit on 2012-02-12 at 00:30:35.
 */
class PhoneNumberUtilTest extends \PHPUnit_Framework_TestCase {

	private static $bsNumber = NULL;
	private static $internationalTollFree = NULL;
	private static $sgNumber = NULL;
	private static $usShortByOneNumber = NULL;
	private static $usTollFree = NULL;
	private static $usNumber = NULL;
	private static $usLocalNumber = NULL;
	private static $nzNumber = NULL;
	private static $usPremium = NULL;
	private static $usSpoof = NULL;
	private static $usSpoofWithRawInput = NULL;
	private static $gbMobile = NULL;
	private static $gbNumber = NULL;
	private static $deShortNumber = NULL;
	private static $itMobile = NULL;
	private static $itNumber = NULL;
	private static $auNumber = NULL;
	private static $arMobile = NULL;
	private static $arNumber = NULL;
	private static $mxMobile1 = NULL;
	private static $mxNumber1 = NULL;
	private static $mxMobile2 = NULL;
	private static $mxNumber2 = NULL;

	const TEST_META_DATA_FILE_PREFIX = "PhoneNumberMetadataForTesting";

	/**
	 * @var PhoneNumberUtil
	 */
	protected $phoneUtil;

	public function __construct() {
		$this->phoneUtil = self::initializePhoneUtilForTesting();
	}

	private static function initializePhoneUtilForTesting() {
		self::$bsNumber = new PhoneNumber();
		self::$bsNumber->setCountryCode(1)->setNationalNumber(2423651234);
		self::$internationalTollFree = new PhoneNumber();
		self::$internationalTollFree->setCountryCode(800)->setNationalNumber(12345678);
		self::$sgNumber = new PhoneNumber();
		self::$sgNumber->setCountryCode(65)->setNationalNumber(65218000);
		self::$usShortByOneNumber = new PhoneNumber();
		self::$usShortByOneNumber->setCountryCode(1)->setNationalNumber(650253000);
		self::$usTollFree = new PhoneNumber();
		self::$usTollFree->setCountryCode(1)->setNationalNumber(8002530000);
		self::$usNumber = new PhoneNumber();
		self::$usNumber->setCountryCode(1)->setNationalNumber(6502530000);
		self::$usLocalNumber = new PhoneNumber();
		self::$usLocalNumber->setCountryCode(1)->setNationalNumber(2530000);
		self::$nzNumber = new PhoneNumber();
		self::$nzNumber->setCountryCode(64)->setNationalNumber(33316005);
		self::$usPremium = new PhoneNumber();
		self::$usPremium->setCountryCode(1)->setNationalNumber(9002530000);
		self::$usSpoof = new PhoneNumber();
		self::$usSpoof->setCountryCode(1)->setNationalNumber(0);
		self::$usSpoofWithRawInput = new PhoneNumber();
		self::$usSpoofWithRawInput->setCountryCode(1)->setNationalNumber(0)->setRawInput("000-000-0000");
		self::$gbMobile = new PhoneNumber();
		self::$gbMobile->setCountryCode(44)->setNationalNumber(7912345678);
		self::$gbNumber = new PhoneNumber();
		self::$gbNumber->setCountryCode(44)->setNationalNumber(2070313000);
		self::$deShortNumber = new PhoneNumber();
		self::$deShortNumber->setCountryCode(49)->setNationalNumber(1234);
		self::$itMobile = new PhoneNumber();
		self::$itMobile->setCountryCode(39)->setNationalNumber(345678901);
		self::$itNumber = new PhoneNumber();
		self::$itNumber->setCountryCode(39)->setNationalNumber(236618300)->setItalianLeadingZero(true);
		self::$auNumber = new PhoneNumber();
		self::$auNumber->setCountryCode(61)->setNationalNumber(236618300);
		self::$arMobile = new PhoneNumber();
		self::$arMobile->setCountryCode(54)->setNationalNumber(91187654321);
		self::$arNumber = new PhoneNumber();
		self::$arNumber->setCountryCode(54)->setNationalNumber(1187654321);

		self::$mxMobile1 = new PhoneNumber();
		self::$mxMobile1->setCountryCode(52)->setNationalNumber(12345678900);
		self::$mxNumber1 = new PhoneNumber();
		self::$mxNumber1->setCountryCode(52)->setNationalNumber(3312345678);
		self::$mxMobile2 = new PhoneNumber();
		self::$mxMobile2->setCountryCode(52)->setNationalNumber(15512345678);
		self::$mxNumber2 = new PhoneNumber();
		self::$mxNumber2->setCountryCode(52)->setNationalNumber(8211234567);

		PhoneNumberUtil::resetInstance();
		return PhoneNumberUtil::getInstance(self::TEST_META_DATA_FILE_PREFIX, CountryCodeToRegionCodeMapForTesting::$countryCodeToRegionCodeMap);
	}

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp() {
		
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown() {
		
	}

	public function testGetSupportedRegions() {
		$this->assertGreaterThan(0, count($this->phoneUtil->getSupportedRegions()));
	}

	public function testGetInstanceLoadUSMetadata() {
		$metadata = $this->phoneUtil->getMetadataForRegion(RegionCode::US);
		$this->assertEquals("US", $metadata->getId());
		$this->assertEquals(1, $metadata->getCountryCode());
		$this->assertEquals("011", $metadata->getInternationalPrefix());
		$this->assertTrue($metadata->hasNationalPrefix());
		$this->assertEquals(2, $metadata->numberFormatSize());
		$this->assertEquals("(\\d{3})(\\d{3})(\\d{4})", $metadata->getNumberFormat(1)->getPattern());
		$this->assertEquals("$1 $2 $3", $metadata->getNumberFormat(1)->getFormat());
		$this->assertEquals("[13-689]\\d{9}|2[0-35-9]\\d{8}", $metadata->getGeneralDesc()->getNationalNumberPattern());
		$this->assertEquals("\\d{7}(?:\\d{3})?", $metadata->getGeneralDesc()->getPossibleNumberPattern());
		$this->assertTrue($metadata->getGeneralDesc()->exactlySameAs($metadata->getFixedLine()));
		$this->assertEquals("\\d{10}", $metadata->getTollFree()->getPossibleNumberPattern());
		$this->assertEquals("900\\d{7}", $metadata->getPremiumRate()->getNationalNumberPattern());
		// No shared-cost data is available, so it should be initialised to "NA".
		$this->assertEquals("NA", $metadata->getSharedCost()->getNationalNumberPattern());
		$this->assertEquals("NA", $metadata->getSharedCost()->getPossibleNumberPattern());
	}

	public function testGetInstanceLoadDEMetadata() {
		$metadata = $this->phoneUtil->getMetadataForRegion(RegionCode::DE);
		$this->assertEquals("DE", $metadata->getId());
		$this->assertEquals(49, $metadata->getCountryCode());
		$this->assertEquals("00", $metadata->getInternationalPrefix());
		$this->assertEquals("0", $metadata->getNationalPrefix());
		$this->assertEquals(6, $metadata->numberFormatSize());
		$this->assertEquals(1, $metadata->getNumberFormat(5)->leadingDigitsPatternSize());
		$this->assertEquals("900", $metadata->getNumberFormat(5)->getLeadingDigitsPattern(0));
		$this->assertEquals("(\\d{3})(\\d{3,4})(\\d{4})", $metadata->getNumberFormat(5)->getPattern());
		$this->assertEquals("$1 $2 $3", $metadata->getNumberFormat(5)->getFormat());
		$this->assertEquals("(?:[24-6]\\d{2}|3[03-9]\\d|[789](?:[1-9]\\d|0[2-9]))\\d{1,8}", $metadata->getFixedLine()->getNationalNumberPattern());
		$this->assertEquals("\\d{2,14}", $metadata->getFixedLine()->getPossibleNumberPattern());
		$this->assertEquals("30123456", $metadata->getFixedLine()->getExampleNumber());
		$this->assertEquals("\\d{10}", $metadata->getTollFree()->getPossibleNumberPattern());
		$this->assertEquals("900([135]\\d{6}|9\\d{7})", $metadata->getPremiumRate()->getNationalNumberPattern());
	}

	public function testGetInstanceLoadARMetadata() {
		$metadata = $this->phoneUtil->getMetadataForRegion(RegionCode::AR);
		$this->assertEquals("AR", $metadata->getId());
		$this->assertEquals(54, $metadata->getCountryCode());
		$this->assertEquals("00", $metadata->getInternationalPrefix());
		$this->assertEquals("0", $metadata->getNationalPrefix());
		$this->assertEquals("0(?:(11|343|3715)15)?", $metadata->getNationalPrefixForParsing());
		$this->assertEquals("9$1", $metadata->getNationalPrefixTransformRule());
		$this->assertEquals("$2 15 $3-$4", $metadata->getNumberFormat(2)->getFormat());
		$this->assertEquals("(9)(\\d{4})(\\d{2})(\\d{4})", $metadata->getNumberFormat(3)->getPattern());
		$this->assertEquals("(9)(\\d{4})(\\d{2})(\\d{4})", $metadata->getIntlNumberFormat(3)->getPattern());
		$this->assertEquals("$1 $2 $3 $4", $metadata->getIntlNumberFormat(3)->getFormat());
	}

	public function testGetInstanceLoadInternationalTollFreeMetadata() {
		$metadata = $this->phoneUtil->getMetadataForNonGeographicalRegion(800);
		$this->assertEquals("001", $metadata->getId());
		$this->assertEquals(800, $metadata->getCountryCode());
		$this->assertEquals("$1 $2", $metadata->getNumberFormat(0)->getFormat());
		$this->assertEquals("(\\d{4})(\\d{4})", $metadata->getNumberFormat(0)->getPattern());
		$this->assertEquals("12345678", $metadata->getGeneralDesc()->getExampleNumber());
		$this->assertEquals("12345678", $metadata->getTollFree()->getExampleNumber());
	}

	public function testIsLeadingZeroPossible() {
		$this->assertTrue($this->phoneUtil->isLeadingZeroPossible(39));  // Italy
		$this->assertFalse($this->phoneUtil->isLeadingZeroPossible(1));  // USA
		$this->assertFalse($this->phoneUtil->isLeadingZeroPossible(800));  // International toll free numbers
		$this->assertFalse($this->phoneUtil->isLeadingZeroPossible(888));  // Not in metadata file, just default to false.
	}

	public function testGetLengthOfGeographicalAreaCode() {
		// Google MTV, which has area code "650".
		$this->assertEquals(3, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$usNumber));

		// A North America toll-free number, which has no area code.
		$this->assertEquals(0, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$usTollFree));

		// Google London, which has area code "20".
		$this->assertEquals(2, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$gbNumber));

		// A UK mobile phone, which has no area code.
		$this->assertEquals(0, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$gbMobile));

		// Google Buenos Aires, which has area code "11".
		$this->assertEquals(2, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$arNumber));

		// Google Sydney, which has area code "2".
		$this->assertEquals(1, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$auNumber));

		// Google Singapore. Singapore has no area code and no national prefix.
		$this->assertEquals(0, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$sgNumber));

		// An invalid US number (1 digit shorter), which has no area code.
		$this->assertEquals(0, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$usShortByOneNumber));

		// An international toll free number, which has no area code.
		$this->assertEquals(0, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$internationalTollFree));
	}

	public function testFormatUSNumber() {
		$this->assertEquals("650 253 0000", $this->phoneUtil->format(self::$usNumber, PhoneNumberFormat::NATIONAL));
		$this->assertEquals("+1 650 253 0000", $this->phoneUtil->format(self::$usNumber, PhoneNumberFormat::INTERNATIONAL));

		$this->assertEquals("800 253 0000", $this->phoneUtil->format(self::$usTollFree, PhoneNumberFormat::NATIONAL));
		$this->assertEquals("+1 800 253 0000", $this->phoneUtil->format(self::$usTollFree, PhoneNumberFormat::INTERNATIONAL));

		$this->assertEquals("900 253 0000", $this->phoneUtil->format(self::$usPremium, PhoneNumberFormat::NATIONAL));
		$this->assertEquals("+1 900 253 0000", $this->phoneUtil->format(self::$usPremium, PhoneNumberFormat::INTERNATIONAL));
		$this->assertEquals("+1-900-253-0000", $this->phoneUtil->format(self::$usPremium, PhoneNumberFormat::RFC3966));
		// Numbers with all zeros in the national number part will be formatted by using the raw_input
		// if that is available no matter which format is specified.
		$this->assertEquals("000-000-0000", $this->phoneUtil->format(self::$usSpoofWithRawInput, PhoneNumberFormat::NATIONAL));
		$this->assertEquals("0", $this->phoneUtil->format(self::$usSpoof, PhoneNumberFormat::NATIONAL));
	}

	public function testFormatBSNumber() {
		$this->assertEquals("242 365 1234", $this->phoneUtil->format(self::$bsNumber, PhoneNumberFormat::NATIONAL));
		$this->assertEquals("+1 242 365 1234", $this->phoneUtil->format(self::$bsNumber, PhoneNumberFormat::INTERNATIONAL));
	}

	public function testFormatGBNumber() {
		$this->assertEquals("(020) 7031 3000", $this->phoneUtil->format(self::$gbNumber, PhoneNumberFormat::NATIONAL));
		$this->assertEquals("+44 20 7031 3000", $this->phoneUtil->format(self::$gbNumber, PhoneNumberFormat::INTERNATIONAL));

		$this->assertEquals("(07912) 345 678", $this->phoneUtil->format(self::$gbMobile, PhoneNumberFormat::NATIONAL));
		$this->assertEquals("+44 7912 345 678", $this->phoneUtil->format(self::$gbMobile, PhoneNumberFormat::INTERNATIONAL));
	}

	public function testFormatDENumber() {
		$deNumber = new PhoneNumber();
		$deNumber->setCountryCode(49)->setNationalNumber(301234);
		$this->assertEquals("030/1234", $this->phoneUtil->format($deNumber, PhoneNumberFormat::NATIONAL));
		$this->assertEquals("+49 30/1234", $this->phoneUtil->format($deNumber, PhoneNumberFormat::INTERNATIONAL));
		$this->assertEquals("+49-30-1234", $this->phoneUtil->format($deNumber, PhoneNumberFormat::RFC3966));

		$deNumber->clear();
		$deNumber->setCountryCode(49)->setNationalNumber(291123);
		$this->assertEquals("0291 123", $this->phoneUtil->format($deNumber, PhoneNumberFormat::NATIONAL));
		$this->assertEquals("+49 291 123", $this->phoneUtil->format($deNumber, PhoneNumberFormat::INTERNATIONAL));

		$deNumber->clear();
		$deNumber->setCountryCode(49)->setNationalNumber(29112345678);
		$this->assertEquals("0291 12345678", $this->phoneUtil->format($deNumber, PhoneNumberFormat::NATIONAL));
		$this->assertEquals("+49 291 12345678", $this->phoneUtil->format($deNumber, PhoneNumberFormat::INTERNATIONAL));

		$deNumber->clear();
		$deNumber->setCountryCode(49)->setNationalNumber(912312345);
		$this->assertEquals("09123 12345", $this->phoneUtil->format($deNumber, PhoneNumberFormat::NATIONAL));
		$this->assertEquals("+49 9123 12345", $this->phoneUtil->format($deNumber, PhoneNumberFormat::INTERNATIONAL));
		$deNumber->clear();
		$deNumber->setCountryCode(49)->setNationalNumber(80212345);
		$this->assertEquals("08021 2345", $this->phoneUtil->format($deNumber, PhoneNumberFormat::NATIONAL));
		$this->assertEquals("+49 8021 2345", $this->phoneUtil->format($deNumber, PhoneNumberFormat::INTERNATIONAL));
		// Note this number is correctly formatted without national prefix. Most of the numbers that
		// are treated as invalid numbers by the library are short numbers, and they are usually not
		// dialed with national prefix.
		$this->assertEquals("1234", $this->phoneUtil->format(self::$deShortNumber, PhoneNumberFormat::NATIONAL));
		$this->assertEquals("+49 1234", $this->phoneUtil->format(self::$deShortNumber, PhoneNumberFormat::INTERNATIONAL));

		$deNumber->clear();
		$deNumber->setCountryCode(49)->setNationalNumber(41341234);
		$this->assertEquals("04134 1234", $this->phoneUtil->format($deNumber, PhoneNumberFormat::NATIONAL));
	}

	public function testFormatITNumber() {
		$this->assertEquals("02 3661 8300", $this->phoneUtil->format(self::$itNumber, PhoneNumberFormat::NATIONAL));
		$this->assertEquals("+39 02 3661 8300", $this->phoneUtil->format(self::$itNumber, PhoneNumberFormat::INTERNATIONAL));
		$this->assertEquals("+390236618300", $this->phoneUtil->format(self::$itNumber, PhoneNumberFormat::E164));

		$this->assertEquals("345 678 901", $this->phoneUtil->format(self::$itMobile, PhoneNumberFormat::NATIONAL));
		$this->assertEquals("+39 345 678 901", $this->phoneUtil->format(self::$itMobile, PhoneNumberFormat::INTERNATIONAL));
		$this->assertEquals("+39345678901", $this->phoneUtil->format(self::$itMobile, PhoneNumberFormat::E164));
	}

	public function testFormatAUNumber() {
		$this->assertEquals("02 3661 8300", $this->phoneUtil->format(self::$auNumber, PhoneNumberFormat::NATIONAL));
		$this->assertEquals("+61 2 3661 8300", $this->phoneUtil->format(self::$auNumber, PhoneNumberFormat::INTERNATIONAL));
		$this->assertEquals("+61236618300", $this->phoneUtil->format(self::$auNumber, PhoneNumberFormat::E164));

		$auNumber = new PhoneNumber();
		$auNumber->setCountryCode(61)->setNationalNumber(1800123456);
		$this->assertEquals("1800 123 456", $this->phoneUtil->format($auNumber, PhoneNumberFormat::NATIONAL));
		$this->assertEquals("+61 1800 123 456", $this->phoneUtil->format($auNumber, PhoneNumberFormat::INTERNATIONAL));
		$this->assertEquals("+611800123456", $this->phoneUtil->format($auNumber, PhoneNumberFormat::E164));
	}

	public function testFormatARNumber() {
		$this->assertEquals("011 8765-4321", $this->phoneUtil->format(self::$arNumber, PhoneNumberFormat::NATIONAL));
		$this->assertEquals("+54 11 8765-4321", $this->phoneUtil->format(self::$arNumber, PhoneNumberFormat::INTERNATIONAL));
		$this->assertEquals("+541187654321", $this->phoneUtil->format(self::$arNumber, PhoneNumberFormat::E164));

		$this->assertEquals("011 15 8765-4321", $this->phoneUtil->format(self::$arMobile, PhoneNumberFormat::NATIONAL));
		$this->assertEquals("+54 9 11 8765 4321", $this->phoneUtil->format(self::$arMobile, PhoneNumberFormat::INTERNATIONAL));
		$this->assertEquals("+5491187654321", $this->phoneUtil->format(self::$arMobile, PhoneNumberFormat::E164));
	}

	  public function testFormatMXNumber() {
	  $this->assertEquals("045 234 567 8900", $this->phoneUtil->format(self::$mxMobile1, PhoneNumberFormat::NATIONAL));
	  $this->assertEquals("+52 1 234 567 8900", $this->phoneUtil->format(self::$mxMobile1, PhoneNumberFormat::INTERNATIONAL));
	  $this->assertEquals("+5212345678900", $this->phoneUtil->format(self::$mxMobile1, PhoneNumberFormat::E164));

	  $this->assertEquals("045 55 1234 5678", $this->phoneUtil->format(self::$mxMobile2, PhoneNumberFormat::NATIONAL));
	  $this->assertEquals("+52 1 55 1234 5678", $this->phoneUtil->format(self::$mxMobile2, PhoneNumberFormat::INTERNATIONAL));
	  $this->assertEquals("+5215512345678", $this->phoneUtil->format(self::$mxMobile2, PhoneNumberFormat::E164));

	  $this->assertEquals("01 33 1234 5678", $this->phoneUtil->format(self::$mxNumber1, PhoneNumberFormat::NATIONAL));
	  $this->assertEquals("+52 33 1234 5678", $this->phoneUtil->format(self::$mxNumber1, PhoneNumberFormat::INTERNATIONAL));
	  $this->assertEquals("+523312345678", $this->phoneUtil->format(self::$mxNumber1, PhoneNumberFormat::E164));

	  $this->assertEquals("01 821 123 4567", $this->phoneUtil->format(self::$mxNumber2, PhoneNumberFormat::NATIONAL));
	  $this->assertEquals("+52 821 123 4567", $this->phoneUtil->format(self::$mxNumber2, PhoneNumberFormat::INTERNATIONAL));
	  $this->assertEquals("+528211234567", $this->phoneUtil->format(self::$mxNumber2, PhoneNumberFormat::E164));
	  }

	/**
	 * 
	 */
	public function testIsValidNumberForRegion() {
		// This number is valid for the Bahamas, but is not a valid US number.
		$this->assertTrue($this->phoneUtil->isValidNumber(self::$bsNumber));
		$this->assertTrue($this->phoneUtil->isValidNumberForRegion(self::$bsNumber, RegionCode::BS));
		$this->assertFalse($this->phoneUtil->isValidNumberForRegion(self::$bsNumber, RegionCode::US));
		$bsInvalidNumber = new PhoneNumber();
		$bsInvalidNumber->setCountryCode(1)->setNationalNumber(2421232345);
		// This number is no longer valid.
		$this->assertFalse($this->phoneUtil->isValidNumber($bsInvalidNumber));

		// La Mayotte and Reunion use 'leadingDigits' to differentiate them.
		$reNumber = new PhoneNumber();
		$reNumber->setCountryCode(262)->setNationalNumber(262123456);
		$this->assertTrue($this->phoneUtil->isValidNumber($reNumber));
		$this->assertTrue($this->phoneUtil->isValidNumberForRegion($reNumber, RegionCode::RE));
		$this->assertFalse($this->phoneUtil->isValidNumberForRegion($reNumber, RegionCode::YT));
		// Now change the number to be a number for La Mayotte.
		$reNumber->setNationalNumber(269601234);
		$this->assertTrue($this->phoneUtil->isValidNumberForRegion($reNumber, RegionCode::YT));
		$this->assertFalse($this->phoneUtil->isValidNumberForRegion($reNumber, RegionCode::RE));
		// This number is no longer valid for La Reunion.
		$reNumber->setNationalNumber(269123456);
		$this->assertFalse($this->phoneUtil->isValidNumberForRegion($reNumber, RegionCode::YT));
		$this->assertFalse($this->phoneUtil->isValidNumberForRegion($reNumber, RegionCode::RE));
		$this->assertFalse($this->phoneUtil->isValidNumber($reNumber));
		// However, it should be recognised as from La Mayotte, since it is valid for this region.
		$this->assertEquals(RegionCode::YT, $this->phoneUtil->getRegionCodeForNumber($reNumber));
		// This number is valid in both places.
		$reNumber->setNationalNumber(800123456);
		$this->assertTrue($this->phoneUtil->isValidNumberForRegion($reNumber, RegionCode::YT));
		$this->assertTrue($this->phoneUtil->isValidNumberForRegion($reNumber, RegionCode::RE));
		$this->assertTrue($this->phoneUtil->isValidNumberForRegion(self::$internationalTollFree, RegionCode::UN001));
		$this->assertFalse($this->phoneUtil->isValidNumberForRegion(self::$internationalTollFree, RegionCode::US));
		$this->assertFalse($this->phoneUtil->isValidNumberForRegion(self::$internationalTollFree, RegionCode::ZZ));

		$invalidNumber = new PhoneNumber();
		// Invalid country calling codes.
		$invalidNumber->setCountryCode(3923)->setNationalNumber(2366);
		$this->assertFalse($this->phoneUtil->isValidNumberForRegion($invalidNumber, RegionCode::ZZ));
		$invalidNumber->setCountryCode(3923)->setNationalNumber(2366);
		$this->assertFalse($this->phoneUtil->isValidNumberForRegion($invalidNumber, RegionCode::UN001));
		$invalidNumber->setCountryCode(0)->setNationalNumber(2366);
		$this->assertFalse($this->phoneUtil->isValidNumberForRegion($invalidNumber, RegionCode::UN001));
		$invalidNumber->setCountryCode(0);
		$this->assertFalse($this->phoneUtil->isValidNumberForRegion($invalidNumber, RegionCode::ZZ));
	}

	public function testCanBeInternationallyDialled() {
		// We have no-international-dialling rules for the US in our test metadata that say that
		// toll-free numbers cannot be dialled internationally.
		$this->assertFalse($this->phoneUtil->canBeInternationallyDialled(self::$usTollFree));
		// Normal US numbers can be internationally dialled.
		$this->assertTrue($this->phoneUtil->canBeInternationallyDialled(self::$usNumber));

		// Invalid number.
		$this->assertTrue($this->phoneUtil->canBeInternationallyDialled(self::$usLocalNumber));

		// We have no data for NZ - should return true.
		$this->assertTrue($this->phoneUtil->canBeInternationallyDialled(self::$nzNumber));
		$this->assertTrue($this->phoneUtil->canBeInternationallyDialled(self::$internationalTollFree));
	}

	public function testIsAlphaNumber() {
		$this->assertTrue($this->phoneUtil->isAlphaNumber("1800 six-flags"));
		$this->assertTrue($this->phoneUtil->isAlphaNumber("1800 six-flags ext. 1234"));
		$this->assertTrue($this->phoneUtil->isAlphaNumber("+800 six-flags"));
		$this->assertFalse($this->phoneUtil->isAlphaNumber("1800 123-1234"));
		$this->assertFalse($this->phoneUtil->isAlphaNumber("1800 123-1234 extension: 1234"));
		$this->assertFalse($this->phoneUtil->isAlphaNumber("+800 1234-1234"));
	}

}