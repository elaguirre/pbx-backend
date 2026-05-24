<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimezoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('timezones')->insert([
            [
                "name" => "Etc/GMT-1",
                "description" => "+01:00",
                "timezone_offset" => 60
            ],
            [
                "name" => "Etc/GMT-2",
                "description" => "+02:00",
                "timezone_offset" => 120
            ],
            [
                "name" => "Etc/GMT-3",
                "description" => "+03:00",
                "timezone_offset" => 180
            ],
            [
                "name" => "Etc/GMT-4",
                "description" => "+04:00",
                "timezone_offset" => 240
            ],
            [
                "name" => "Etc/GMT-5",
                "description" => "+05:00",
                "timezone_offset" => 300
            ],
            [
                "name" => "Etc/GMT-6",
                "description" => "+06:00",
                "timezone_offset" => 360
            ],
            [
                "name" => "Etc/GMT-7",
                "description" => "+07:00",
                "timezone_offset" => 420
            ],
            [
                "name" => "Etc/GMT-8",
                "description" => "+08:00",
                "timezone_offset" => 480
            ],
            [
                "name" => "Etc/GMT-9",
                "description" => "+09:00",
                "timezone_offset" => 540
            ],
            [
                "name" => "Etc/GMT-10",
                "description" => "+10:00",
                "timezone_offset" => 600
            ],
            [
                "name" => "Etc/GMT-11",
                "description" => "+11:00",
                "timezone_offset" => 660
            ],
            [
                "name" => "Etc/GMT-12",
                "description" => "+12:00",
                "timezone_offset" => 720
            ],
            [
                "name" => "Etc/GMT-13",
                "description" => "+13:00",
                "timezone_offset" => 780
            ],
            [
                "name" => "Etc/GMT-14",
                "description" => "+14:00",
                "timezone_offset" => 840
            ],
            [
                "name" => "Etc/GMT+1",
                "description" => "-01:00",
                "timezone_offset" => -60
            ],
            [
                "name" => "Etc/GMT+2",
                "description" => "-02:00",
                "timezone_offset" => -120
            ],
            [
                "name" => "Etc/GMT+3",
                "description" => "-03:00",
                "timezone_offset" => -180
            ],
            [
                "name" => "Etc/GMT+4",
                "description" => "-04:00",
                "timezone_offset" => -240
            ],
            [
                "name" => "Etc/GMT+5",
                "description" => "-05:00",
                "timezone_offset" => -300
            ],
            [
                "name" => "Etc/GMT+6",
                "description" => "-06:00",
                "timezone_offset" => -360
            ],
            [
                "name" => "Etc/GMT+7",
                "description" => "-07:00",
                "timezone_offset" => -420
            ],
            [
                "name" => "Etc/GMT+8",
                "description" => "-08:00",
                "timezone_offset" => -480
            ],
            [
                "name" => "Etc/GMT+9",
                "description" => "-09:00",
                "timezone_offset" => -540
            ],
            [
                "name" => "Etc/GMT+10",
                "description" => "-10:00",
                "timezone_offset" => -600
            ],
            [
                "name" => "Etc/GMT+11",
                "description" => "-11:00",
                "timezone_offset" => -660
            ],
            [
                "name" => "Etc/GMT+12",
                "description" => "-12:00",
                "timezone_offset" => -720
            ],
            [
                "name" => "America/Eirunepe",
                "description" => "Acre Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "America/Porto_Acre",
                "description" => "Acre Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "America/Rio_Branco",
                "description" => "Acre Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "Brazil/Acre",
                "description" => "Acre Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "Asia/Kabul",
                "description" => "Afghanistan Time",
                "timezone_offset" => 270
            ],
            [
                "name" => "America/Anchorage",
                "description" => "Alaska Daylight Time",
                "timezone_offset" => -480
            ],
            [
                "name" => "America/Juneau",
                "description" => "Alaska Daylight Time",
                "timezone_offset" => -480
            ],
            [
                "name" => "America/Nome",
                "description" => "Alaska Daylight Time",
                "timezone_offset" => -480
            ],
            [
                "name" => "America/Sitka",
                "description" => "Alaska Daylight Time",
                "timezone_offset" => -480
            ],
            [
                "name" => "America/Yakutat",
                "description" => "Alaska Daylight Time",
                "timezone_offset" => -480
            ],
            [
                "name" => "US/Alaska",
                "description" => "Alaska Daylight Time",
                "timezone_offset" => -480
            ],
            [
                "name" => "Asia/Almaty",
                "description" => "Alma-Ata Time",
                "timezone_offset" => 360
            ],
            [
                "name" => "America/Boa_Vista",
                "description" => "Amazon Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Campo_Grande",
                "description" => "Amazon Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Cuiaba",
                "description" => "Amazon Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Manaus",
                "description" => "Amazon Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Porto_Velho",
                "description" => "Amazon Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "Brazil/West",
                "description" => "Amazon Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "Asia/Anadyr",
                "description" => "Anadyr Time",
                "timezone_offset" => 720
            ],
            [
                "name" => "Asia/Aqtau",
                "description" => "Aqtau Time",
                "timezone_offset" => 300
            ],
            [
                "name" => "Asia/Aqtobe",
                "description" => "Aqtobe Time",
                "timezone_offset" => 300
            ],
            [
                "name" => "Asia/Aden",
                "description" => "Arabia Standard Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Asia/Baghdad",
                "description" => "Arabia Standard Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Asia/Bahrain",
                "description" => "Arabia Standard Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Asia/Kuwait",
                "description" => "Arabia Standard Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Asia/Qatar",
                "description" => "Arabia Standard Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Asia/Riyadh",
                "description" => "Arabia Standard Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "America/Argentina/Buenos_Aires",
                "description" => "Argentine Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Argentina/Catamarca",
                "description" => "Argentine Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Argentina/ComodRivadavia",
                "description" => "Argentine Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Argentina/Cordoba",
                "description" => "Argentine Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Argentina/Jujuy",
                "description" => "Argentine Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Argentina/La_Rioja",
                "description" => "Argentine Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Argentina/Mendoza",
                "description" => "Argentine Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Argentina/Rio_Gallegos",
                "description" => "Argentine Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Argentina/Salta",
                "description" => "Argentine Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Argentina/San_Juan",
                "description" => "Argentine Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Argentina/San_Luis",
                "description" => "Argentine Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Argentina/Tucuman",
                "description" => "Argentine Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Argentina/Ushuaia",
                "description" => "Argentine Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Buenos_Aires",
                "description" => "Argentine Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Catamarca",
                "description" => "Argentine Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Cordoba",
                "description" => "Argentine Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Jujuy",
                "description" => "Argentine Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Mendoza",
                "description" => "Argentine Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Rosario",
                "description" => "Argentine Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "Asia/Yerevan",
                "description" => "Armenia Time",
                "timezone_offset" => 240
            ],
            [
                "name" => "America/Glace_Bay",
                "description" => "Atlantic Daylight Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Goose_Bay",
                "description" => "Atlantic Daylight Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Halifax",
                "description" => "Atlantic Daylight Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Moncton",
                "description" => "Atlantic Daylight Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Thule",
                "description" => "Atlantic Daylight Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "Atlantic/Bermuda",
                "description" => "Atlantic Daylight Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "Canada/Atlantic",
                "description" => "Atlantic Daylight Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Anguilla",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Antigua",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Aruba",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Barbados",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Blanc-Sablon",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Curacao",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Dominica",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Grand_Turk",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Grenada",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Guadeloupe",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Kralendijk",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Lower_Princes",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Marigot",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Martinique",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Montserrat",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Port_of_Spain",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Puerto_Rico",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Santo_Domingo",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/St_Barthelemy",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/St_Kitts",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/St_Lucia",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/St_Thomas",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/St_Vincent",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Tortola",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Virgin",
                "description" => "Atlantic Standard Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "Australia/Darwin",
                "description" => "Australian Central Standard Time (Northern Territory)",
                "timezone_offset" => 570
            ],
            [
                "name" => "Australia/North",
                "description" => "Australian Central Standard Time (Northern Territory)",
                "timezone_offset" => 570
            ],
            [
                "name" => "Australia/Adelaide",
                "description" => "Australian Central Standard Time (South Australia)",
                "timezone_offset" => 570
            ],
            [
                "name" => "Australia/South",
                "description" => "Australian Central Standard Time (South Australia)",
                "timezone_offset" => 570
            ],
            [
                "name" => "Australia/Broken_Hill",
                "description" => "Australian Central Standard Time (South Australia/New South Wales)",
                "timezone_offset" => 570
            ],
            [
                "name" => "Australia/Yancowinna",
                "description" => "Australian Central Standard Time (South Australia/New South Wales)",
                "timezone_offset" => 570
            ],
            [
                "name" => "Australia/Eucla",
                "description" => "Australian Central Western Standard Time",
                "timezone_offset" => 525
            ],
            [
                "name" => "Australia/ACT",
                "description" => "Australian Eastern Standard Time (New South Wales)",
                "timezone_offset" => 600
            ],
            [
                "name" => "Australia/Canberra",
                "description" => "Australian Eastern Standard Time (New South Wales)",
                "timezone_offset" => 600
            ],
            [
                "name" => "Australia/Currie",
                "description" => "Australian Eastern Standard Time (New South Wales)",
                "timezone_offset" => 600
            ],
            [
                "name" => "Australia/NSW",
                "description" => "Australian Eastern Standard Time (New South Wales)",
                "timezone_offset" => 600
            ],
            [
                "name" => "Australia/Sydney",
                "description" => "Australian Eastern Standard Time (New South Wales)",
                "timezone_offset" => 600
            ],
            [
                "name" => "Australia/Brisbane",
                "description" => "Australian Eastern Standard Time (Queensland)",
                "timezone_offset" => 600
            ],
            [
                "name" => "Australia/Lindeman",
                "description" => "Australian Eastern Standard Time (Queensland)",
                "timezone_offset" => 600
            ],
            [
                "name" => "Australia/Queensland",
                "description" => "Australian Eastern Standard Time (Queensland)",
                "timezone_offset" => 600
            ],
            [
                "name" => "Australia/Hobart",
                "description" => "Australian Eastern Standard Time (Tasmania)",
                "timezone_offset" => 600
            ],
            [
                "name" => "Australia/Tasmania",
                "description" => "Australian Eastern Standard Time (Tasmania)",
                "timezone_offset" => 600
            ],
            [
                "name" => "Australia/Melbourne",
                "description" => "Australian Eastern Standard Time (Victoria)",
                "timezone_offset" => 600
            ],
            [
                "name" => "Australia/Victoria",
                "description" => "Australian Eastern Standard Time (Victoria)",
                "timezone_offset" => 600
            ],
            [
                "name" => "Antarctica/Casey",
                "description" => "Australian Western Standard Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "Australia/Perth",
                "description" => "Australian Western Standard Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "Australia/West",
                "description" => "Australian Western Standard Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "Asia/Baku",
                "description" => "Azerbaijan Summer Time",
                "timezone_offset" => 300
            ],
            [
                "name" => "Atlantic/Azores",
                "description" => "Azores Summer Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Asia/Dacca",
                "description" => "Bangladesh Time",
                "timezone_offset" => 360
            ],
            [
                "name" => "Asia/Dhaka",
                "description" => "Bangladesh Time",
                "timezone_offset" => 360
            ],
            [
                "name" => "Asia/Thimbu",
                "description" => "Bhutan Time",
                "timezone_offset" => 360
            ],
            [
                "name" => "Asia/Thimphu",
                "description" => "Bhutan Time",
                "timezone_offset" => 360
            ],
            [
                "name" => "America/La_Paz",
                "description" => "Bolivia Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "Pacific/Bougainville",
                "description" => "Bougainville Standard Time",
                "timezone_offset" => 660
            ],
            [
                "name" => "America/Araguaina",
                "description" => "Brasilia Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Bahia",
                "description" => "Brasilia Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Belem",
                "description" => "Brasilia Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Fortaleza",
                "description" => "Brasilia Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Maceio",
                "description" => "Brasilia Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Recife",
                "description" => "Brasilia Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Santarem",
                "description" => "Brasilia Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Sao_Paulo",
                "description" => "Brasilia Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "Brazil/East",
                "description" => "Brasilia Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "Europe/Belfast",
                "description" => "British Summer Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Europe/Guernsey",
                "description" => "British Summer Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Europe/Isle_of_Man",
                "description" => "British Summer Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Europe/Jersey",
                "description" => "British Summer Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Europe/London",
                "description" => "British Summer Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "GB",
                "description" => "British Summer Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "GB-Eire",
                "description" => "British Summer Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Asia/Brunei",
                "description" => "Brunei Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "Atlantic/Cape_Verde",
                "description" => "Cape Verde Time",
                "timezone_offset" => -60
            ],
            [
                "name" => "Africa/Blantyre",
                "description" => "Central African Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Africa/Bujumbura",
                "description" => "Central African Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Africa/Gaborone",
                "description" => "Central African Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Africa/Harare",
                "description" => "Central African Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Africa/Kigali",
                "description" => "Central African Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Africa/Lubumbashi",
                "description" => "Central African Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Africa/Lusaka",
                "description" => "Central African Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Africa/Maputo",
                "description" => "Central African Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "America/Bahia_Banderas",
                "description" => "Central Daylight Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "America/Chicago",
                "description" => "Central Daylight Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "America/Indiana/Knox",
                "description" => "Central Daylight Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "America/Indiana/Tell_City",
                "description" => "Central Daylight Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "America/Knox_IN",
                "description" => "Central Daylight Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "America/Matamoros",
                "description" => "Central Daylight Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "America/Menominee",
                "description" => "Central Daylight Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "America/Merida",
                "description" => "Central Daylight Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "America/Mexico_City",
                "description" => "Central Daylight Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "America/Monterrey",
                "description" => "Central Daylight Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "America/North_Dakota/Beulah",
                "description" => "Central Daylight Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "America/North_Dakota/Center",
                "description" => "Central Daylight Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "America/North_Dakota/New_Salem",
                "description" => "Central Daylight Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "America/Rainy_River",
                "description" => "Central Daylight Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "America/Rankin_Inlet",
                "description" => "Central Daylight Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "America/Resolute",
                "description" => "Central Daylight Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "America/Winnipeg",
                "description" => "Central Daylight Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "Canada/Central",
                "description" => "Central Daylight Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "CST6CDT",
                "description" => "Central Daylight Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "Mexico/General",
                "description" => "Central Daylight Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "US/Central",
                "description" => "Central Daylight Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "US/Indiana-Starke",
                "description" => "Central Daylight Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "Africa/Ceuta",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Antarctica/Troll",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Arctic/Longyearbyen",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Atlantic/Jan_Mayen",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "CET",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Amsterdam",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Andorra",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Belgrade",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Berlin",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Bratislava",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Brussels",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Budapest",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Busingen",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Copenhagen",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Gibraltar",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Ljubljana",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Luxembourg",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Madrid",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Malta",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Monaco",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Oslo",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Paris",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Podgorica",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Prague",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Rome",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/San_Marino",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Sarajevo",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Skopje",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Stockholm",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Tirane",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Vaduz",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Vatican",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Vienna",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Warsaw",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Zagreb",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Zurich",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Poland",
                "description" => "Central European Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Africa/Algiers",
                "description" => "Central European Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Africa/Tunis",
                "description" => "Central European Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Asia/Makassar",
                "description" => "Central Indonesia Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "Asia/Ujung_Pandang",
                "description" => "Central Indonesia Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "America/Belize",
                "description" => "Central Standard Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "America/Costa_Rica",
                "description" => "Central Standard Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "America/El_Salvador",
                "description" => "Central Standard Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "America/Guatemala",
                "description" => "Central Standard Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "America/Managua",
                "description" => "Central Standard Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "America/Regina",
                "description" => "Central Standard Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "America/Swift_Current",
                "description" => "Central Standard Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "America/Tegucigalpa",
                "description" => "Central Standard Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "Canada/East-Saskatchewan",
                "description" => "Central Standard Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "Canada/Saskatchewan",
                "description" => "Central Standard Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "Pacific/Guam",
                "description" => "Chamorro Standard Time",
                "timezone_offset" => 600
            ],
            [
                "name" => "Pacific/Saipan",
                "description" => "Chamorro Standard Time",
                "timezone_offset" => 600
            ],
            [
                "name" => "NZ-CHAT",
                "description" => "Chatham Standard Time",
                "timezone_offset" => 765
            ],
            [
                "name" => "Pacific/Chatham",
                "description" => "Chatham Standard Time",
                "timezone_offset" => 765
            ],
            [
                "name" => "America/Santiago",
                "description" => "Chile Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "Antarctica/Palmer",
                "description" => "Chile Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "Chile/Continental",
                "description" => "Chile Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "Asia/Chongqing",
                "description" => "China Standard Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "Asia/Chungking",
                "description" => "China Standard Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "Asia/Harbin",
                "description" => "China Standard Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "Asia/Macao",
                "description" => "China Standard Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "Asia/Macau",
                "description" => "China Standard Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "Asia/Shanghai",
                "description" => "China Standard Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "Asia/Taipei",
                "description" => "China Standard Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "PRC",
                "description" => "China Standard Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "ROC",
                "description" => "China Standard Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "Asia/Choibalsan",
                "description" => "Choibalsan Summer Time",
                "timezone_offset" => 540
            ],
            [
                "name" => "Indian/Christmas",
                "description" => "Christmas Island Time",
                "timezone_offset" => 420
            ],
            [
                "name" => "Pacific/Chuuk",
                "description" => "Chuuk Time",
                "timezone_offset" => 600
            ],
            [
                "name" => "Pacific/Truk",
                "description" => "Chuuk Time",
                "timezone_offset" => 600
            ],
            [
                "name" => "Pacific/Yap",
                "description" => "Chuuk Time",
                "timezone_offset" => 600
            ],
            [
                "name" => "Indian/Cocos",
                "description" => "Cocos Islands Time",
                "timezone_offset" => 390
            ],
            [
                "name" => "America/Bogota",
                "description" => "Colombia Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "Pacific/Rarotonga",
                "description" => "Cook Is. Time",
                "timezone_offset" => -600
            ],
            [
                "name" => "Etc/UCT",
                "description" => "Coordinated Universal Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Etc/Universal",
                "description" => "Coordinated Universal Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Etc/UTC",
                "description" => "Coordinated Universal Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Etc/Zulu",
                "description" => "Coordinated Universal Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "UCT",
                "description" => "Coordinated Universal Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Universal",
                "description" => "Coordinated Universal Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "UTC",
                "description" => "Coordinated Universal Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Zulu",
                "description" => "Coordinated Universal Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "America/Havana",
                "description" => "Cuba Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "Cuba",
                "description" => "Cuba Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "Antarctica/Davis",
                "description" => "Davis Time",
                "timezone_offset" => 420
            ],
            [
                "name" => "Antarctica/DumontDUrville",
                "description" => "Dumont-d'Urville Time",
                "timezone_offset" => 600
            ],
            [
                "name" => "Asia/Jayapura",
                "description" => "East Indonesia Time",
                "timezone_offset" => 540
            ],
            [
                "name" => "Chile/EasterIsland",
                "description" => "Easter Is. Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "Pacific/Easter",
                "description" => "Easter Is. Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "Africa/Addis_Ababa",
                "description" => "Eastern African Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Africa/Asmara",
                "description" => "Eastern African Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Africa/Asmera",
                "description" => "Eastern African Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Africa/Dar_es_Salaam",
                "description" => "Eastern African Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Africa/Djibouti",
                "description" => "Eastern African Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Africa/Juba",
                "description" => "Eastern African Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Africa/Kampala",
                "description" => "Eastern African Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Africa/Khartoum",
                "description" => "Eastern African Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Africa/Mogadishu",
                "description" => "Eastern African Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Africa/Nairobi",
                "description" => "Eastern African Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Indian/Antananarivo",
                "description" => "Eastern African Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Indian/Comoro",
                "description" => "Eastern African Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Indian/Mayotte",
                "description" => "Eastern African Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "America/Cayman",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Detroit",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Fort_Wayne",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Indiana/Indianapolis",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Indiana/Marengo",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Indiana/Petersburg",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Indiana/Vevay",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Indiana/Vincennes",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Indiana/Winamac",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Indianapolis",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Iqaluit",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Kentucky/Louisville",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Kentucky/Monticello",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Louisville",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Montreal",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Nassau",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/New_York",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Nipigon",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Pangnirtung",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Port-au-Prince",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Thunder_Bay",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Toronto",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "Canada/Eastern",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "EST5EDT",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "US/East-Indiana",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "US/Eastern",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "US/Michigan",
                "description" => "Eastern Daylight Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "Asia/Amman",
                "description" => "Eastern European Summer Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Asia/Beirut",
                "description" => "Eastern European Summer Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Asia/Damascus",
                "description" => "Eastern European Summer Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Asia/Gaza",
                "description" => "Eastern European Summer Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Asia/Hebron",
                "description" => "Eastern European Summer Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Asia/Istanbul",
                "description" => "Eastern European Summer Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Asia/Nicosia",
                "description" => "Eastern European Summer Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "EET",
                "description" => "Eastern European Summer Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Europe/Athens",
                "description" => "Eastern European Summer Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Europe/Bucharest",
                "description" => "Eastern European Summer Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Europe/Chisinau",
                "description" => "Eastern European Summer Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Europe/Helsinki",
                "description" => "Eastern European Summer Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Europe/Istanbul",
                "description" => "Eastern European Summer Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Europe/Kiev",
                "description" => "Eastern European Summer Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Europe/Mariehamn",
                "description" => "Eastern European Summer Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Europe/Nicosia",
                "description" => "Eastern European Summer Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Europe/Riga",
                "description" => "Eastern European Summer Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Europe/Sofia",
                "description" => "Eastern European Summer Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Europe/Tallinn",
                "description" => "Eastern European Summer Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Europe/Tiraspol",
                "description" => "Eastern European Summer Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Europe/Uzhgorod",
                "description" => "Eastern European Summer Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Europe/Vilnius",
                "description" => "Eastern European Summer Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Europe/Zaporozhye",
                "description" => "Eastern European Summer Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Turkey",
                "description" => "Eastern European Summer Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Africa/Cairo",
                "description" => "Eastern European Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Africa/Tripoli",
                "description" => "Eastern European Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Egypt",
                "description" => "Eastern European Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Kaliningrad",
                "description" => "Eastern European Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Libya",
                "description" => "Eastern European Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "America/Scoresbysund",
                "description" => "Eastern Greenland Summer Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "America/Atikokan",
                "description" => "Eastern Standard Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "America/Cancun",
                "description" => "Eastern Standard Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "America/Coral_Harbour",
                "description" => "Eastern Standard Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "America/Jamaica",
                "description" => "Eastern Standard Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "America/Panama",
                "description" => "Eastern Standard Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "EST",
                "description" => "Eastern Standard Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "Jamaica",
                "description" => "Eastern Standard Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "America/Guayaquil",
                "description" => "Ecuador Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "Atlantic/Stanley",
                "description" => "Falkland Is. Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "America/Noronha",
                "description" => "Fernando de Noronha Time",
                "timezone_offset" => -120
            ],
            [
                "name" => "Brazil/DeNoronha",
                "description" => "Fernando de Noronha Time",
                "timezone_offset" => -120
            ],
            [
                "name" => "Pacific/Fiji",
                "description" => "Fiji Time",
                "timezone_offset" => 720
            ],
            [
                "name" => "America/Cayenne",
                "description" => "French Guiana Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "Indian/Kerguelen",
                "description" => "French Southern \u0026 Antarctic Lands Time",
                "timezone_offset" => 300
            ],
            [
                "name" => "Pacific/Galapagos",
                "description" => "Galapagos Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "Pacific/Gambier",
                "description" => "Gambier Time",
                "timezone_offset" => -540
            ],
            [
                "name" => "Asia/Tbilisi",
                "description" => "Georgia Time",
                "timezone_offset" => 240
            ],
            [
                "name" => "Africa/Accra",
                "description" => "Ghana Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Pacific/Tarawa",
                "description" => "Gilbert Is. Time",
                "timezone_offset" => 720
            ],
            [
                "name" => "Africa/Abidjan",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Africa/Bamako",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Africa/Banjul",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Africa/Bissau",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Africa/Conakry",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Africa/Dakar",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Africa/Freetown",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Africa/Lome",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Africa/Monrovia",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Africa/Nouakchott",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Africa/Ouagadougou",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Africa/Sao_Tome",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Africa/Timbuktu",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "America/Danmarkshavn",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Atlantic/Reykjavik",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Atlantic/St_Helena",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Etc/GMT",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Etc/GMT+0",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Etc/GMT-0",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Etc/GMT0",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Etc/Greenwich",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "GMT",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "GMT+0",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "GMT-0",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "GMT0",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Greenwich",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Iceland",
                "description" => "Greenwich Mean Time",
                "timezone_offset" => 0
            ],
            [
                "name" => "Asia/Dubai",
                "description" => "Gulf Standard Time",
                "timezone_offset" => 240
            ],
            [
                "name" => "Asia/Muscat",
                "description" => "Gulf Standard Time",
                "timezone_offset" => 240
            ],
            [
                "name" => "America/Guyana",
                "description" => "Guyana Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Adak",
                "description" => "Hawaii Daylight Time",
                "timezone_offset" => -540
            ],
            [
                "name" => "America/Atka",
                "description" => "Hawaii Daylight Time",
                "timezone_offset" => -540
            ],
            [
                "name" => "US/Aleutian",
                "description" => "Hawaii Daylight Time",
                "timezone_offset" => -540
            ],
            [
                "name" => "HST",
                "description" => "Hawaii Standard Time",
                "timezone_offset" => -600
            ],
            [
                "name" => "Pacific/Honolulu",
                "description" => "Hawaii Standard Time",
                "timezone_offset" => -600
            ],
            [
                "name" => "Pacific/Johnston",
                "description" => "Hawaii Standard Time",
                "timezone_offset" => -600
            ],
            [
                "name" => "US/Hawaii",
                "description" => "Hawaii Standard Time",
                "timezone_offset" => -600
            ],
            [
                "name" => "Asia/Hong_Kong",
                "description" => "Hong Kong Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "Hongkong",
                "description" => "Hong Kong Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "Asia/Hovd",
                "description" => "Hovd Summer Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "Asia/Calcutta",
                "description" => "India Standard Time",
                "timezone_offset" => 330
            ],
            [
                "name" => "Asia/Colombo",
                "description" => "India Standard Time",
                "timezone_offset" => 330
            ],
            [
                "name" => "Asia/Kolkata",
                "description" => "India Standard Time",
                "timezone_offset" => 330
            ],
            [
                "name" => "Indian/Chagos",
                "description" => "Indian Ocean Territory Time",
                "timezone_offset" => 360
            ],
            [
                "name" => "Asia/Bangkok",
                "description" => "Indochina Time",
                "timezone_offset" => 420
            ],
            [
                "name" => "Asia/Ho_Chi_Minh",
                "description" => "Indochina Time",
                "timezone_offset" => 420
            ],
            [
                "name" => "Asia/Phnom_Penh",
                "description" => "Indochina Time",
                "timezone_offset" => 420
            ],
            [
                "name" => "Asia/Saigon",
                "description" => "Indochina Time",
                "timezone_offset" => 420
            ],
            [
                "name" => "Asia/Vientiane",
                "description" => "Indochina Time",
                "timezone_offset" => 420
            ],
            [
                "name" => "Asia/Tehran",
                "description" => "Iran Daylight Time",
                "timezone_offset" => 270
            ],
            [
                "name" => "Iran",
                "description" => "Iran Daylight Time",
                "timezone_offset" => 270
            ],
            [
                "name" => "Eire",
                "description" => "Irish Summer Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Europe/Dublin",
                "description" => "Irish Summer Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Asia/Chita",
                "description" => "Irkutsk Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "Asia/Irkutsk",
                "description" => "Irkutsk Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "Asia/Jerusalem",
                "description" => "Israel Daylight Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Asia/Tel_Aviv",
                "description" => "Israel Daylight Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Israel",
                "description" => "Israel Daylight Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Asia/Tokyo",
                "description" => "Japan Standard Time",
                "timezone_offset" => 540
            ],
            [
                "name" => "Japan",
                "description" => "Japan Standard Time",
                "timezone_offset" => 540
            ],
            [
                "name" => "Asia/Khandyga",
                "description" => "Khandyga Time",
                "timezone_offset" => 540
            ],
            [
                "name" => "Asia/Bishkek",
                "description" => "Kirgizstan Time",
                "timezone_offset" => 360
            ],
            [
                "name" => "Asia/Pyongyang",
                "description" => "Korea Standard Time",
                "timezone_offset" => 540
            ],
            [
                "name" => "Asia/Seoul",
                "description" => "Korea Standard Time",
                "timezone_offset" => 540
            ],
            [
                "name" => "ROK",
                "description" => "Korea Standard Time",
                "timezone_offset" => 540
            ],
            [
                "name" => "Pacific/Kosrae",
                "description" => "Kosrae Time",
                "timezone_offset" => 660
            ],
            [
                "name" => "Asia/Krasnoyarsk",
                "description" => "Krasnoyarsk Time",
                "timezone_offset" => 420
            ],
            [
                "name" => "Asia/Novokuznetsk",
                "description" => "Krasnoyarsk Time",
                "timezone_offset" => 420
            ],
            [
                "name" => "Pacific/Kiritimati",
                "description" => "Line Is. Time",
                "timezone_offset" => 840
            ],
            [
                "name" => "Australia/LHI",
                "description" => "Lord Howe Standard Time",
                "timezone_offset" => 630
            ],
            [
                "name" => "Australia/Lord_Howe",
                "description" => "Lord Howe Standard Time",
                "timezone_offset" => 630
            ],
            [
                "name" => "Antarctica/Macquarie",
                "description" => "Macquarie Island Standard Time",
                "timezone_offset" => 660
            ],
            [
                "name" => "Asia/Magadan",
                "description" => "Magadan Time",
                "timezone_offset" => 600
            ],
            [
                "name" => "Asia/Kuala_Lumpur",
                "description" => "Malaysia Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "Asia/Kuching",
                "description" => "Malaysia Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "Indian/Maldives",
                "description" => "Maldives Time",
                "timezone_offset" => 300
            ],
            [
                "name" => "Pacific/Marquesas",
                "description" => "Marquesas Time",
                "timezone_offset" => -570
            ],
            [
                "name" => "Kwajalein",
                "description" => "Marshall Islands Time",
                "timezone_offset" => 720
            ],
            [
                "name" => "Pacific/Kwajalein",
                "description" => "Marshall Islands Time",
                "timezone_offset" => 720
            ],
            [
                "name" => "Pacific/Majuro",
                "description" => "Marshall Islands Time",
                "timezone_offset" => 720
            ],
            [
                "name" => "Indian/Mauritius",
                "description" => "Mauritius Time",
                "timezone_offset" => 240
            ],
            [
                "name" => "Antarctica/Mawson",
                "description" => "Mawson Time",
                "timezone_offset" => 300
            ],
            [
                "name" => "MET",
                "description" => "Middle Europe Summer Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Europe/Minsk",
                "description" => "Moscow Standard Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Europe/Moscow",
                "description" => "Moscow Standard Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Europe/Simferopol",
                "description" => "Moscow Standard Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Europe/Volgograd",
                "description" => "Moscow Standard Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "W-SU",
                "description" => "Moscow Standard Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "America/Boise",
                "description" => "Mountain Daylight Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "America/Cambridge_Bay",
                "description" => "Mountain Daylight Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "America/Chihuahua",
                "description" => "Mountain Daylight Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "America/Denver",
                "description" => "Mountain Daylight Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "America/Edmonton",
                "description" => "Mountain Daylight Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "America/Inuvik",
                "description" => "Mountain Daylight Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "America/Mazatlan",
                "description" => "Mountain Daylight Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "America/Ojinaga",
                "description" => "Mountain Daylight Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "America/Shiprock",
                "description" => "Mountain Daylight Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "America/Yellowknife",
                "description" => "Mountain Daylight Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "Canada/Mountain",
                "description" => "Mountain Daylight Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "Mexico/BajaSur",
                "description" => "Mountain Daylight Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "MST7MDT",
                "description" => "Mountain Daylight Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "Navajo",
                "description" => "Mountain Daylight Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "US/Mountain",
                "description" => "Mountain Daylight Time",
                "timezone_offset" => -360
            ],
            [
                "name" => "America/Creston",
                "description" => "Mountain Standard Time",
                "timezone_offset" => -420
            ],
            [
                "name" => "America/Dawson_Creek",
                "description" => "Mountain Standard Time",
                "timezone_offset" => -420
            ],
            [
                "name" => "America/Hermosillo",
                "description" => "Mountain Standard Time",
                "timezone_offset" => -420
            ],
            [
                "name" => "America/Phoenix",
                "description" => "Mountain Standard Time",
                "timezone_offset" => -420
            ],
            [
                "name" => "MST",
                "description" => "Mountain Standard Time",
                "timezone_offset" => -420
            ],
            [
                "name" => "US/Arizona",
                "description" => "Mountain Standard Time",
                "timezone_offset" => -420
            ],
            [
                "name" => "Asia/Rangoon",
                "description" => "Myanmar Time",
                "timezone_offset" => 390
            ],
            [
                "name" => "Pacific/Nauru",
                "description" => "Nauru Time",
                "timezone_offset" => 720
            ],
            [
                "name" => "Asia/Kathmandu",
                "description" => "Nepal Time",
                "timezone_offset" => 345
            ],
            [
                "name" => "Asia/Katmandu",
                "description" => "Nepal Time",
                "timezone_offset" => 345
            ],
            [
                "name" => "Pacific/Noumea",
                "description" => "New Caledonia Time",
                "timezone_offset" => 660
            ],
            [
                "name" => "Antarctica/McMurdo",
                "description" => "New Zealand Standard Time",
                "timezone_offset" => 720
            ],
            [
                "name" => "Antarctica/South_Pole",
                "description" => "New Zealand Standard Time",
                "timezone_offset" => 720
            ],
            [
                "name" => "NZ",
                "description" => "New Zealand Standard Time",
                "timezone_offset" => 720
            ],
            [
                "name" => "Pacific/Auckland",
                "description" => "New Zealand Standard Time",
                "timezone_offset" => 720
            ],
            [
                "name" => "America/St_Johns",
                "description" => "Newfoundland Daylight Time",
                "timezone_offset" => -150
            ],
            [
                "name" => "Canada/Newfoundland",
                "description" => "Newfoundland Daylight Time",
                "timezone_offset" => -150
            ],
            [
                "name" => "Pacific/Niue",
                "description" => "Niue Time",
                "timezone_offset" => -660
            ],
            [
                "name" => "Pacific/Norfolk",
                "description" => "Norfolk Time",
                "timezone_offset" => 690
            ],
            [
                "name" => "Asia/Novosibirsk",
                "description" => "Novosibirsk Time",
                "timezone_offset" => 360
            ],
            [
                "name" => "Asia/Omsk",
                "description" => "Omsk Time",
                "timezone_offset" => 360
            ],
            [
                "name" => "Asia/Oral",
                "description" => "Oral Time",
                "timezone_offset" => 300
            ],
            [
                "name" => "America/Dawson",
                "description" => "Pacific Daylight Time",
                "timezone_offset" => -420
            ],
            [
                "name" => "America/Ensenada",
                "description" => "Pacific Daylight Time",
                "timezone_offset" => -420
            ],
            [
                "name" => "America/Los_Angeles",
                "description" => "Pacific Daylight Time",
                "timezone_offset" => -420
            ],
            [
                "name" => "America/Santa_Isabel",
                "description" => "Pacific Daylight Time",
                "timezone_offset" => -420
            ],
            [
                "name" => "America/Tijuana",
                "description" => "Pacific Daylight Time",
                "timezone_offset" => -420
            ],
            [
                "name" => "America/Vancouver",
                "description" => "Pacific Daylight Time",
                "timezone_offset" => -420
            ],
            [
                "name" => "America/Whitehorse",
                "description" => "Pacific Daylight Time",
                "timezone_offset" => -420
            ],
            [
                "name" => "Canada/Pacific",
                "description" => "Pacific Daylight Time",
                "timezone_offset" => -420
            ],
            [
                "name" => "Canada/Yukon",
                "description" => "Pacific Daylight Time",
                "timezone_offset" => -420
            ],
            [
                "name" => "Mexico/BajaNorte",
                "description" => "Pacific Daylight Time",
                "timezone_offset" => -420
            ],
            [
                "name" => "PST8PDT",
                "description" => "Pacific Daylight Time",
                "timezone_offset" => -420
            ],
            [
                "name" => "US/Pacific",
                "description" => "Pacific Daylight Time",
                "timezone_offset" => -420
            ],
            [
                "name" => "US/Pacific-New",
                "description" => "Pacific Daylight Time",
                "timezone_offset" => -420
            ],
            [
                "name" => "America/Metlakatla",
                "description" => "Pacific Standard Time",
                "timezone_offset" => -480
            ],
            [
                "name" => "Asia/Karachi",
                "description" => "Pakistan Time",
                "timezone_offset" => 300
            ],
            [
                "name" => "Pacific/Palau",
                "description" => "Palau Time",
                "timezone_offset" => 540
            ],
            [
                "name" => "Pacific/Port_Moresby",
                "description" => "Papua New Guinea Time",
                "timezone_offset" => 600
            ],
            [
                "name" => "America/Asuncion",
                "description" => "Paraguay Time",
                "timezone_offset" => -240
            ],
            [
                "name" => "America/Lima",
                "description" => "Peru Time",
                "timezone_offset" => -300
            ],
            [
                "name" => "Asia/Kamchatka",
                "description" => "Petropavlovsk-Kamchatski Time",
                "timezone_offset" => 720
            ],
            [
                "name" => "Asia/Manila",
                "description" => "Philippines Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "Pacific/Enderbury",
                "description" => "Phoenix Is. Time",
                "timezone_offset" => 780
            ],
            [
                "name" => "America/Miquelon",
                "description" => "Pierre \u0026 Miquelon Daylight Time",
                "timezone_offset" => -120
            ],
            [
                "name" => "Pacific/Pitcairn",
                "description" => "Pitcairn Standard Time",
                "timezone_offset" => -480
            ],
            [
                "name" => "Pacific/Pohnpei",
                "description" => "Pohnpei Time",
                "timezone_offset" => 660
            ],
            [
                "name" => "Pacific/Ponape",
                "description" => "Pohnpei Time",
                "timezone_offset" => 660
            ],
            [
                "name" => "Asia/Qyzylorda",
                "description" => "Qyzylorda Time",
                "timezone_offset" => 360
            ],
            [
                "name" => "Indian/Reunion",
                "description" => "Reunion Time",
                "timezone_offset" => 240
            ],
            [
                "name" => "Antarctica/Rothera",
                "description" => "Rothera Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "Asia/Sakhalin",
                "description" => "Sakhalin Time",
                "timezone_offset" => 600
            ],
            [
                "name" => "Europe/Samara",
                "description" => "Samara Time",
                "timezone_offset" => 240
            ],
            [
                "name" => "Pacific/Midway",
                "description" => "Samoa Standard Time",
                "timezone_offset" => -660
            ],
            [
                "name" => "Pacific/Pago_Pago",
                "description" => "Samoa Standard Time",
                "timezone_offset" => -660
            ],
            [
                "name" => "Pacific/Samoa",
                "description" => "Samoa Standard Time",
                "timezone_offset" => -660
            ],
            [
                "name" => "US/Samoa",
                "description" => "Samoa Standard Time",
                "timezone_offset" => -660
            ],
            [
                "name" => "Indian/Mahe",
                "description" => "Seychelles Time",
                "timezone_offset" => 240
            ],
            [
                "name" => "Asia/Singapore",
                "description" => "Singapore Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "Singapore",
                "description" => "Singapore Time",
                "timezone_offset" => 480
            ],
            [
                "name" => "Pacific/Guadalcanal",
                "description" => "Solomon Is. Time",
                "timezone_offset" => 660
            ],
            [
                "name" => "Africa/Johannesburg",
                "description" => "South Africa Standard Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Africa/Maseru",
                "description" => "South Africa Standard Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Africa/Mbabane",
                "description" => "South Africa Standard Time",
                "timezone_offset" => 120
            ],
            [
                "name" => "Atlantic/South_Georgia",
                "description" => "South Georgia Standard Time",
                "timezone_offset" => -120
            ],
            [
                "name" => "Asia/Srednekolymsk",
                "description" => "Srednekolymsk Time",
                "timezone_offset" => 660
            ],
            [
                "name" => "America/Paramaribo",
                "description" => "Suriname Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "Antarctica/Syowa",
                "description" => "Syowa Time",
                "timezone_offset" => 180
            ],
            [
                "name" => "Pacific/Tahiti",
                "description" => "Tahiti Time",
                "timezone_offset" => -600
            ],
            [
                "name" => "Asia/Dushanbe",
                "description" => "Tajikistan Time",
                "timezone_offset" => 300
            ],
            [
                "name" => "Asia/Dili",
                "description" => "Timor-Leste Time",
                "timezone_offset" => 540
            ],
            [
                "name" => "Pacific/Fakaofo",
                "description" => "Tokelau Time",
                "timezone_offset" => 780
            ],
            [
                "name" => "Pacific/Tongatapu",
                "description" => "Tonga Time",
                "timezone_offset" => 780
            ],
            [
                "name" => "Asia/Ashgabat",
                "description" => "Turkmenistan Time",
                "timezone_offset" => 300
            ],
            [
                "name" => "Asia/Ashkhabad",
                "description" => "Turkmenistan Time",
                "timezone_offset" => 300
            ],
            [
                "name" => "Pacific/Funafuti",
                "description" => "Tuvalu Time",
                "timezone_offset" => 720
            ],
            [
                "name" => "Asia/Ulaanbaatar",
                "description" => "Ulaanbaatar Summer Time",
                "timezone_offset" => 540
            ],
            [
                "name" => "Asia/Ulan_Bator",
                "description" => "Ulaanbaatar Summer Time",
                "timezone_offset" => 540
            ],
            [
                "name" => "America/Montevideo",
                "description" => "Uruguay Time",
                "timezone_offset" => -180
            ],
            [
                "name" => "Asia/Ust-Nera",
                "description" => "Ust-Nera Time",
                "timezone_offset" => 600
            ],
            [
                "name" => "Asia/Samarkand",
                "description" => "Uzbekistan Time",
                "timezone_offset" => 300
            ],
            [
                "name" => "Asia/Tashkent",
                "description" => "Uzbekistan Time",
                "timezone_offset" => 300
            ],
            [
                "name" => "Pacific/Efate",
                "description" => "Vanuatu Time",
                "timezone_offset" => 660
            ],
            [
                "name" => "America/Caracas",
                "description" => "Venezuela Time",
                "timezone_offset" => -270
            ],
            [
                "name" => "Asia/Vladivostok",
                "description" => "Vladivostok Time",
                "timezone_offset" => 600
            ],
            [
                "name" => "Antarctica/Vostok",
                "description" => "Vostok Time",
                "timezone_offset" => 360
            ],
            [
                "name" => "Pacific/Wake",
                "description" => "Wake Time",
                "timezone_offset" => 720
            ],
            [
                "name" => "Pacific/Wallis",
                "description" => "Wallis \u0026 Futuna Time",
                "timezone_offset" => 720
            ],
            [
                "name" => "Asia/Jakarta",
                "description" => "West Indonesia Time",
                "timezone_offset" => 420
            ],
            [
                "name" => "Asia/Pontianak",
                "description" => "West Indonesia Time",
                "timezone_offset" => 420
            ],
            [
                "name" => "Pacific/Apia",
                "description" => "West Samoa Standard Time",
                "timezone_offset" => 780
            ],
            [
                "name" => "Africa/Bangui",
                "description" => "Western African Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Africa/Brazzaville",
                "description" => "Western African Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Africa/Douala",
                "description" => "Western African Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Africa/Kinshasa",
                "description" => "Western African Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Africa/Lagos",
                "description" => "Western African Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Africa/Libreville",
                "description" => "Western African Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Africa/Luanda",
                "description" => "Western African Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Africa/Malabo",
                "description" => "Western African Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Africa/Ndjamena",
                "description" => "Western African Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Africa/Niamey",
                "description" => "Western African Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Africa/Porto-Novo",
                "description" => "Western African Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Africa/Windhoek",
                "description" => "Western African Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Africa/Casablanca",
                "description" => "Western European Summer Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Africa/El_Aaiun",
                "description" => "Western European Summer Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Atlantic/Canary",
                "description" => "Western European Summer Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Atlantic/Faeroe",
                "description" => "Western European Summer Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Atlantic/Faroe",
                "description" => "Western European Summer Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Atlantic/Madeira",
                "description" => "Western European Summer Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Europe/Lisbon",
                "description" => "Western European Summer Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "Portugal",
                "description" => "Western European Summer Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "WET",
                "description" => "Western European Summer Time",
                "timezone_offset" => 60
            ],
            [
                "name" => "America/Godthab",
                "description" => "Western Greenland Summer Time",
                "timezone_offset" => -120
            ],
            [
                "name" => "Asia/Kashgar",
                "description" => "Xinjiang Standard Time",
                "timezone_offset" => 360
            ],
            [
                "name" => "Asia/Urumqi",
                "description" => "Xinjiang Standard Time",
                "timezone_offset" => 360
            ],
            [
                "name" => "Asia/Yakutsk",
                "description" => "Yakutsk Time",
                "timezone_offset" => 540
            ],
            [
                "name" => "Asia/Yekaterinburg",
                "description" => "Yekaterinburg Time",
                "timezone_offset" => 300
            ]
        ]);
    }
}
