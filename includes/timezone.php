<?php
	$timezones;
	$timezones[] = "(GMT-12:00) International Date Line West";
	$timezones[] = "(GMT-11:00) Midway Island, Samoa";
	$timezones[] = "(GMT-10:00) Hawaii";
	$timezones[] = "(GMT-09:00) Alaska";
	$timezones[] = "(GMT-08:00) Pacific Time (US & Canada)";
	$timezones[] = "(GMT-08:00) Tijuana, Baja California";
	$timezones[] = "(GMT-07:00) Arizona";
	$timezones[] = "(GMT-07:00) Chihuahua, La Paz, Mazatlan";
	$timezones[] = "(GMT-07:00) Mountain Time (US & Canada)";
	$timezones[] = "(GMT-06:00) Central America";
	$timezones[] = "(GMT-06:00) Central Time (US & Canada)";
	$timezones[] = "(GMT-06:00) Guadalajara, Mexico City, Monterrey";
	$timezones[] = "(GMT-06:00) Saskatchewan";
	$timezones[] = "(GMT-05:00) Bogota, Lima, Quito, Rio Branco";
	$timezones[] = "(GMT-05:00) Eastern Time (US & Canada)";
	$timezones[] = "(GMT-05:00) Indiana (East)";
	$timezones[] = "(GMT-04:00) Atlantic Time (Canada)";
	$timezones[] = "(GMT-04:00) Caracas, La Paz";
	$timezones[] = "(GMT-04:00) Manaus";
	$timezones[] = "(GMT-04:00) Santiago";
	$timezones[] = "(GMT-03:30) Newfoundland";
	$timezones[] = "(GMT-03:00) Brasilia";
	$timezones[] = "(GMT-03:00) Buenos Aires, Georgetown";
	$timezones[] = "(GMT-03:00) Greenland";
	$timezones[] = "(GMT-03:00) Montevideo";
	$timezones[] = "(GMT-02:00) Mid-Atlantic";
	$timezones[] = "(GMT-01:00) Cape Verde Is.";
	$timezones[] = "(GMT-01:00) Azores";
	$timezones[] = "(GMT+00:00) Casablanca, Monrovia, Reykjavik";
	$timezones[] = "(GMT+00:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London";
	$timezones[] = "(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna";
	$timezones[] = "(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague";
	$timezones[] = "(GMT+01:00) Brussels, Copenhagen, Madrid, Paris";
	$timezones[] = "(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb";
	$timezones[] = "(GMT+01:00) West Central Africa";
	$timezones[] = "(GMT+02:00) Amman";
	$timezones[] = "(GMT+02:00) Athens, Bucharest, Istanbul";
	$timezones[] = "(GMT+02:00) Beirut";
	$timezones[] = "(GMT+02:00) Cairo";
	$timezones[] = "(GMT+02:00) Harare, Pretoria";
	$timezones[] = "(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius";
	$timezones[] = "(GMT+02:00) Jerusalem";
	$timezones[] = "(GMT+02:00) Minsk";
	$timezones[] = "(GMT+02:00) Windhoek";
	$timezones[] = "(GMT+03:00) Kuwait, Riyadh, Baghdad";
	$timezones[] = "(GMT+03:00) Moscow, St. Petersburg, Volgograd";
	$timezones[] = "(GMT+03:00) Nairobi";
	$timezones[] = "(GMT+03:00) Tbilisi";
	$timezones[] = "(GMT+03:30) Tehran";
	$timezones[] = "(GMT+04:00) Abu Dhabi, Muscat";
	$timezones[] = "(GMT+04:00) Baku";
	$timezones[] = "(GMT+04:00) Yerevan";
	$timezones[] = "(GMT+04:30) Kabul";
	$timezones[] = "(GMT+05:00) Yekaterinburg";
	$timezones[] = "(GMT+05:00) Islamabad, Karachi, Tashkent";
	$timezones[] = "(GMT+05:30) Sri Jayawardenapura";
	$timezones[] = "(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi";
	$timezones[] = "(GMT+05:45) Kathmandu";
	$timezones[] = "(GMT+06:00) Almaty, Novosibirsk";
	$timezones[] = "(GMT+06:00) Astana, Dhaka";
	$timezones[] = "(GMT+06:30) Yangon (Rangoon)";
	$timezones[] = "(GMT+07:00) Bangkok, Hanoi, Jakarta";
	$timezones[] = "(GMT+07:00) Krasnoyarsk";
	$timezones[] = "(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi";
	$timezones[] = "(GMT+08:00) Kuala Lumpur, Singapore";
	$timezones[] = "(GMT+08:00) Irkutsk, Ulaan Bataar";
	$timezones[] = "(GMT+08:00) Perth";
	$timezones[] = "(GMT+08:00) Taipei";
	$timezones[] = "(GMT+09:00) Osaka, Sapporo, Tokyo";
	$timezones[] = "(GMT+09:00) Seoul";
	$timezones[] = "(GMT+09:00) Yakutsk";
	$timezones[] = "(GMT+09:30) Adelaide";
	$timezones[] = "(GMT+09:30) Darwin";
	$timezones[] = "(GMT+10:00) Brisbane";
	$timezones[] = "(GMT+10:00) Canberra, Melbourne, Sydney";
	$timezones[] = "(GMT+10:00) Hobart";
	$timezones[] = "(GMT+10:00) Guam, Port Moresby";
	$timezones[] = "(GMT+10:00) Vladivostok";
	$timezones[] = "(GMT+11:00) Magadan, Solomon Is., New Caledonia";
	$timezones[] = "(GMT+12:00) Auckland, Wellington";
	$timezones[] = "(GMT+12:00) Fiji, Kamchatka, Marshall Is.";
	$timezones[] = "(GMT+13:00) Nuku'alofa";

	echo '<select name="timezone">';
	foreach ($timezones as $t)
	{
		if (isset($appt))
		{
			if ($appt->getTimeZone() == $t)
				echo '<option value="'.$t.'" selected>'.$t.'</option>';
			else
				echo '<option value="'.$t.'">'.$t.'</option>';
		}
		else
			echo '<option value="'.$t.'">'.$t.'</option>';
	}
	echo '</select>';