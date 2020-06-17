<?php

namespace app\components;

class Time
{
	public static function showDate( $date ) // $date --> время в формате Unix time
	{
		$stf = 0;
		$cur_time = time();
		$diff = $cur_time - strtotime($date);

		$seconds = array( 'секунда', 'секунды', 'секунд' );
		$minutes = array( 'минута', 'минуты', 'минут' );
		$hours = array( 'час', 'часа', 'часов' );
		$days = array( 'день', 'дня', 'дней' );
		$weeks = array( 'неделя', 'недели', 'недель' );
		$months = array( 'месяц', 'месяца', 'месяцев' );
		$years = array( 'год', 'года', 'лет' );
		$decades = array( 'десятилетие', 'десятилетия', 'десятилетий' );

		$phrase = array( $seconds, $minutes, $hours, $days, $weeks, $months, $years, $decades );
		$length = array( 1, 60, 3600, 86400, 604800, 2630880, 31570560, 315705600 );

		for ( $i = sizeof( $length ) - 1; ( $i >= 0 ) && ( ( $no = $diff / $length[ $i ] ) <= 1 ); $i -- ) {
			;
		}
		if ( $i < 0 ) {
			$i = 0;
		}
		$_time = $cur_time - ( $diff % $length[ $i ] );
		$no = floor( $no );
		$value = sprintf( "%d %s ", $no, self::getPhrase( $no, $phrase[ $i ] ) );

		if ( ( $stf == 1 ) && ( $i >= 1 ) && ( ( $cur_time - $_time ) > 0 ) ) {
			$value .= $_time;
		}

		return $value . ' назад';
	}

	private static function getPhrase( $number, $titles ) {
		$cases = array( 2, 0, 1, 1, 1, 2 );

		return $titles[ ( $number % 100 > 4 && $number % 100 < 20 ) ? 2 : $cases[ min( $number % 10, 5 ) ] ];
	}


	/**
	 * Счетчик обратного отсчета
	 *
	 * @param mixed $date
	 * @return
	 */
	public static function downcounter($date){
		$check_time = strtotime($date) - time();

		if($check_time <= 0){
			return false;
		}

		$days = floor($check_time/86400);
		$hours = floor(($check_time%86400)/3600);
		$minutes = floor(($check_time%3600)/60);
		$seconds = $check_time%60;

		$str = '';
		if($days > 0) $str .= self::declension($days,array('день','дня','дней')).' ';
		if($days < 1 && $hours > 0) $str .= self::declension($hours,array('час','часа','часов')).' ';
		if($days < 1 && $hours < 1 && $minutes > 0) $str .= self::declension($minutes,array('минута','минуты','минут')).' ';
		if($days < 1 && $hours < 1 && $minutes < 1 && $seconds > 0) $str .= self::declension($seconds,array('секунда','секунды','секунд'));

		return $str;
	}


	/**
	 * Функция склонения слов
	 *
	 * @param mixed $digit
	 * @param mixed $expr
	 * @param bool $onlyword
	 * @return
	 */
	public static function declension($digit,$expr,$onlyword=false){
		if(!is_array($expr)) $expr = array_filter(explode(' ', $expr));
		if(empty($expr[2])) $expr[2]=$expr[1];
		$i=preg_replace('/[^0-9]+/s','',$digit)%100;
		if($onlyword) $digit='';
		if($i>=5 && $i<=20) $res=$digit.' '.$expr[2];
		else
		{
			$i%=10;
			if($i==1) $res=$digit.' '.$expr[0];
			elseif($i>=2 && $i<=4) $res=$digit.' '.$expr[1];
			else $res=$digit.' '.$expr[2];
		}
		return trim($res);
	}
}