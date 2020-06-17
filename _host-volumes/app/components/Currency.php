<?php


namespace app\components;


class Currency
{
	// MAIN CURRENCY OF THE SITE
	const BITS_CURRENCY = 'BITS';
	// SECONDS CURRENCIES OF THE SITE
	const USD_CURRENCY = 'USD';

	// LIST OF COURSES
	const COURSE = [
		self::USD_CURRENCY => 0.10,
		self::BITS_CURRENCY => 1,
	];

	// LIST OF CURRENCIES IN THE SITE
	const CURRENCIES = [
		self::USD_CURRENCY => [
			'symbol_left' => '$',
			'symbol_right' => '',
			'decimal_place' => 2,
			'value' => self::COURSE[self::USD_CURRENCY]
		],
		self::BITS_CURRENCY => [
			'symbol_left' => '',
			'symbol_right' => ' BITS',
			'decimal_place' => 0,
			'value' => self::COURSE[self::BITS_CURRENCY]
		]
	];

	const DECIMAL_POINT = '.';
	const THOUSAND_POINT = ' ';

	public static function format($number, $currency, $value = '', $format = true) {
		$symbol_left = self::CURRENCIES[$currency]['symbol_left'];
		$symbol_right = self::CURRENCIES[$currency]['symbol_right'];
		$decimal_place = self::CURRENCIES[$currency]['decimal_place'];

		if (!$value) {
			$value = self::CURRENCIES[$currency]['value'];
		}

		$amount = $value ? (float)$number * $value : (float)$number;

		$amount = round($amount, (int)$decimal_place);

		if (!$format) {
			return $amount;
		}

		$string = '';

		if ($symbol_left) {
			$string .= $symbol_left;
		}

		$string .= number_format($amount, (int)$decimal_place, self::DECIMAL_POINT,  self::THOUSAND_POINT);

		if ($symbol_right) {
			$string .= $symbol_right;
		}

		return $string;
	}

	public static function convert($value, $from, $to) {
		if (isset(self::COURSE[$from])) {
			$from = self::COURSE[$from];
		} else {
			$from = 1;
		}

		if (isset(self::COURSE[$to])) {
			$to = self::COURSE[$to];
		} else {
			$to = 1;
		}

		return $value * ($to / $from);
	}

	public static function getValue($currency) {
		if (isset(self::CURRENCIES[$currency])) {
			return self::CURRENCIES[$currency]['value'];
		} else {
			return 0;
		}
	}

	public static function has($currency) {
		return isset(self::CURRENCIES[$currency]);
	}
}