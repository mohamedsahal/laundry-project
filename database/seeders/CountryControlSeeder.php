<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountryControlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries =[
            [

                'country_code'=>'AF',
                'country_name'=>'Afghanistan',
                'phone_code'=>93
            ],
            [

                'country_code'=>'AL',
                'country_name'=>'Albania',
                'phone_code'=>355
            ],
            [

                'country_code'=>'DZ',
                'country_name'=>'Algeria',
                'phone_code'=>213
            ],
            [

                'country_code'=>'AS',
                'country_name'=>'American Samoa',
                'phone_code'=>1684
            ],
            [

                'country_code'=>'AD',
                'country_name'=>'Andorra',
                'phone_code'=>376
            ],
            [

                'country_code'=>'AO',
                'country_name'=>'Angola',
                'phone_code'=>244
            ],
            [

                'country_code'=>'AI',
                'country_name'=>'Anguilla',
                'phone_code'=>1264
            ],
            [

                'country_code'=>'AQ',
                'country_name'=>'Antarctica',
                'phone_code'=>0
            ],
            [

                'country_code'=>'AG',
                'country_name'=>'Antigua And Barbuda',
                'phone_code'=>1268
            ],
            [

                'country_code'=>'AR',
                'country_name'=>'Argentina',
                'phone_code'=>54
            ],
            [

                'country_code'=>'AM',
                'country_name'=>'Armenia',
                'phone_code'=>374
            ],
            [

                'country_code'=>'AW',
                'country_name'=>'Aruba',
                'phone_code'=>297
            ],
            [

                'country_code'=>'AU',
                'country_name'=>'Australia',
                'phone_code'=>61
            ],
            [

                'country_code'=>'AT',
                'country_name'=>'Austria',
                'phone_code'=>43
            ],
            [

                'country_code'=>'AZ',
                'country_name'=>'Azerbaijan',
                'phone_code'=>994
            ],
            [

                'country_code'=>'BS',
                'country_name'=>'Bahamas The',
                'phone_code'=>1242
            ],
            [

                'country_code'=>'BH',
                'country_name'=>'Bahrain',
                'phone_code'=>973
            ],
            [

                'country_code'=>'BD',
                'country_name'=>'Bangladesh',
                'phone_code'=>880
            ],
            [

                'country_code'=>'BB',
                'country_name'=>'Barbados',
                'phone_code'=>1246
            ],
            [

                'country_code'=>'BY',
                'country_name'=>'Belarus',
                'phone_code'=>375
            ],
            [

                'country_code'=>'BE',
                'country_name'=>'Belgium',
                'phone_code'=>32
            ],
            [

                'country_code'=>'BZ',
                'country_name'=>'Belize',
                'phone_code'=>501
            ],
            [

                'country_code'=>'BJ',
                'country_name'=>'Benin',
                'phone_code'=>229
            ],
            [

                'country_code'=>'BM',
                'country_name'=>'Bermuda',
                'phone_code'=>1441
            ],
            [

                'country_code'=>'BT',
                'country_name'=>'Bhutan',
                'phone_code'=>975
            ],
            [

                'country_code'=>'BO',
                'country_name'=>'Bolivia',
                'phone_code'=>591
            ],
            [

                'country_code'=>'BA',
                'country_name'=>'Bosnia and Herzegovina',
                'phone_code'=>387
            ],
            [

                'country_code'=>'BW',
                'country_name'=>'Botswana',
                'phone_code'=>267
            ],
            [

                'country_code'=>'BV',
                'country_name'=>'Bouvet Island',
                'phone_code'=>0
            ],
            [

                'country_code'=>'BR',
                'country_name'=>'Brazil',
                'phone_code'=>55
            ],
            [

                'country_code'=>'IO',
                'country_name'=>'British Indian Ocean Territory',
                'phone_code'=>246
            ],
            [

                'country_code'=>'BN',
                'country_name'=>'Brunei',
                'phone_code'=>673
            ],
            [

                'country_code'=>'BG',
                'country_name'=>'Bulgaria',
                'phone_code'=>359
            ],
            [

                'country_code'=>'BF',
                'country_name'=>'Burkina Faso',
                'phone_code'=>226
            ],
            [

                'country_code'=>'BI',
                'country_name'=>'Burundi',
                'phone_code'=>257
            ],
            [

                'country_code'=>'KH',
                'country_name'=>'Cambodia',
                'phone_code'=>855
            ],
            [

                'country_code'=>'CM',
                'country_name'=>'Cameroon',
                'phone_code'=>237
            ],
            [

                'country_code'=>'CA',
                'country_name'=>'Canada',
                'phone_code'=>1
            ],
            [

                'country_code'=>'CV',
                'country_name'=>'Cape Verde',
                'phone_code'=>238
            ],
            [

                'country_code'=>'KY',
                'country_name'=>'Cayman Islands',
                'phone_code'=>1345
            ],
            [

                'country_code'=>'CF',
                'country_name'=>'Central African Republic',
                'phone_code'=>236
            ],
            [

                'country_code'=>'TD',
                'country_name'=>'Chad',
                'phone_code'=>235
            ],
            [

                'country_code'=>'CL',
                'country_name'=>'Chile',
                'phone_code'=>56
            ],
            [

                'country_code'=>'CN',
                'country_name'=>'China',
                'phone_code'=>86
            ],
            [

                'country_code'=>'CX',
                'country_name'=>'Christmas Island',
                'phone_code'=>61
            ],
            [

                'country_code'=>'CC',
                'country_name'=>'Cocos (Keeling) Islands',
                'phone_code'=>672
            ],
            [

                'country_code'=>'CO',
                'country_name'=>'Colombia',
                'phone_code'=>57
            ],
            [

                'country_code'=>'KM',
                'country_name'=>'Comoros',
                'phone_code'=>269
            ],
            [

                'country_code'=>'CG',
                'country_name'=>'Republic Of The Congo',
                'phone_code'=>242
            ],
            [

                'country_code'=>'CD',
                'country_name'=>'Democratic Republic Of The Congo',
                'phone_code'=>242
            ],
            [

                'country_code'=>'CK',
                'country_name'=>'Cook Islands',
                'phone_code'=>682
            ],
            [

                'country_code'=>'CR',
                'country_name'=>'Costa Rica',
                'phone_code'=>506
            ],
            [

                'country_code'=>'CI',
                'country_name'=>'Cote D Ivoire (Ivory Coast)',
                'phone_code'=>225
            ],
            [

                'country_code'=>'HR',
                'country_name'=>'Croatia (Hrvatska)',
                'phone_code'=>385
            ],
            [

                'country_code'=>'CU',
                'country_name'=>'Cuba',
                'phone_code'=>53
            ],
            [

                'country_code'=>'CY',
                'country_name'=>'Cyprus',
                'phone_code'=>357
            ],
            [

                'country_code'=>'CZ',
                'country_name'=>'Czech Republic',
                'phone_code'=>420
            ],
            [

                'country_code'=>'DK',
                'country_name'=>'Denmark',
                'phone_code'=>45
            ],
            [

                'country_code'=>'DJ',
                'country_name'=>'Djibouti',
                'phone_code'=>253
            ],
            [

                'country_code'=>'DM',
                'country_name'=>'Dominica',
                'phone_code'=>1767
            ],
            [

                'country_code'=>'DO',
                'country_name'=>'Dominican Republic',
                'phone_code'=>1809
            ],
            [

                'country_code'=>'TP',
                'country_name'=>'East Timor',
                'phone_code'=>670
            ],
            [

                'country_code'=>'EC',
                'country_name'=>'Ecuador',
                'phone_code'=>593
            ],
            [

                'country_code'=>'EG',
                'country_name'=>'Egypt',
                'phone_code'=>20
            ],
            [

                'country_code'=>'SV',
                'country_name'=>'El Salvador',
                'phone_code'=>503
            ],
            [

                'country_code'=>'GQ',
                'country_name'=>'Equatorial Guinea',
                'phone_code'=>240
            ],
            [

                'country_code'=>'ER',
                'country_name'=>'Eritrea',
                'phone_code'=>291
            ],
            [

                'country_code'=>'EE',
                'country_name'=>'Estonia',
                'phone_code'=>372
            ],
            [

                'country_code'=>'ET',
                'country_name'=>'Ethiopia',
                'phone_code'=>251
            ],
            [

                'country_code'=>'XA',
                'country_name'=>'External Territories of Australia',
                'phone_code'=>61
            ],
            [

                'country_code'=>'FK',
                'country_name'=>'Falkland Islands',
                'phone_code'=>500
            ],
            [

                'country_code'=>'FO',
                'country_name'=>'Faroe Islands',
                'phone_code'=>298
            ],
            [

                'country_code'=>'FJ',
                'country_name'=>'Fiji Islands',
                'phone_code'=>679
            ],
            [

                'country_code'=>'FI',
                'country_name'=>'Finland',
                'phone_code'=>358
            ],
            [

                'country_code'=>'FR',
                'country_name'=>'France',
                'phone_code'=>33
            ],
            [

                'country_code'=>'GF',
                'country_name'=>'French Guiana',
                'phone_code'=>594
            ],
            [

                'country_code'=>'PF',
                'country_name'=>'French Polynesia',
                'phone_code'=>689
            ],
            [

                'country_code'=>'TF',
                'country_name'=>'French Southern Territories',
                'phone_code'=>0
            ],
            [

                'country_code'=>'GA',
                'country_name'=>'Gabon',
                'phone_code'=>241
            ],
            [

                'country_code'=>'GM',
                'country_name'=>'Gambia The',
                'phone_code'=>220
            ],
            [

                'country_code'=>'GE',
                'country_name'=>'Georgia',
                'phone_code'=>995
            ],
            [

                'country_code'=>'DE',
                'country_name'=>'Germany',
                'phone_code'=>49
            ],
            [

                'country_code'=>'GH',
                'country_name'=>'Ghana',
                'phone_code'=>233
            ],
            [

                'country_code'=>'GI',
                'country_name'=>'Gibraltar',
                'phone_code'=>350
            ],
            [

                'country_code'=>'GR',
                'country_name'=>'Greece',
                'phone_code'=>30
            ],
            [

                'country_code'=>'GL',
                'country_name'=>'Greenland',
                'phone_code'=>299
            ],
            [

                'country_code'=>'GD',
                'country_name'=>'Grenada',
                'phone_code'=>1473
            ],
            [

                'country_code'=>'GP',
                'country_name'=>'Guadeloupe',
                'phone_code'=>590
            ],
            [

                'country_code'=>'GU',
                'country_name'=>'Guam',
                'phone_code'=>1671
            ],
            [

                'country_code'=>'GT',
                'country_name'=>'Guatemala',
                'phone_code'=>502
            ],
            [

                'country_code'=>'XU',
                'country_name'=>'Guernsey and Alderney',
                'phone_code'=>44
            ],
            [

                'country_code'=>'GN',
                'country_name'=>'Guinea',
                'phone_code'=>224
            ],
            [

                'country_code'=>'GW',
                'country_name'=>'Guinea-Bissau',
                'phone_code'=>245
            ],
            [

                'country_code'=>'GY',
                'country_name'=>'Guyana',
                'phone_code'=>592
            ],
            [

                'country_code'=>'HT',
                'country_name'=>'Haiti',
                'phone_code'=>509
            ],
            [

                'country_code'=>'HM',
                'country_name'=>'Heard and McDonald Islands',
                'phone_code'=>0
            ],
            [

                'country_code'=>'HN',
                'country_name'=>'Honduras',
                'phone_code'=>504
            ],
            [

                'country_code'=>'HK',
                'country_name'=>'Hong Kong S.A.R.',
                'phone_code'=>852
            ],
            [

                'country_code'=>'HU',
                'country_name'=>'Hungary',
                'phone_code'=>36
            ],
            [

                'country_code'=>'IS',
                'country_name'=>'Iceland',
                'phone_code'=>354
            ],
            [

                'country_code'=>'IN',
                'country_name'=>'India',
                'phone_code'=>91
            ],
            [

                'country_code'=>'ID',
                'country_name'=>'Indonesia',
                'phone_code'=>62
            ],
            [

                'country_code'=>'IR',
                'country_name'=>'Iran',
                'phone_code'=>98
            ],
            [

                'country_code'=>'IQ',
                'country_name'=>'Iraq',
                'phone_code'=>964
            ],
            [

                'country_code'=>'IE',
                'country_name'=>'Ireland',
                'phone_code'=>353
            ],
            [

                'country_code'=>'IL',
                'country_name'=>'Israel',
                'phone_code'=>972
            ],
            [

                'country_code'=>'IT',
                'country_name'=>'Italy',
                'phone_code'=>39
            ],
            [

                'country_code'=>'JM',
                'country_name'=>'Jamaica',
                'phone_code'=>1876
            ],
            [

                'country_code'=>'JP',
                'country_name'=>'Japan',
                'phone_code'=>81
            ],
            [

                'country_code'=>'XJ',
                'country_name'=>'Jersey',
                'phone_code'=>44
            ],
            [

                'country_code'=>'JO',
                'country_name'=>'Jordan',
                'phone_code'=>962
            ],
            [

                'country_code'=>'KZ',
                'country_name'=>'Kazakhstan',
                'phone_code'=>7
            ],
            [

                'country_code'=>'KE',
                'country_name'=>'Kenya',
                'phone_code'=>254
            ],
            [

                'country_code'=>'KI',
                'country_name'=>'Kiribati',
                'phone_code'=>686
            ],
            [

                'country_code'=>'KP',
                'country_name'=>'Korea North',
                'phone_code'=>850
            ],
            [

                'country_code'=>'KR',
                'country_name'=>'Korea South',
                'phone_code'=>82
            ],
            [

                'country_code'=>'KW',
                'country_name'=>'Kuwait',
                'phone_code'=>965
            ],
            [

                'country_code'=>'KG',
                'country_name'=>'Kyrgyzstan',
                'phone_code'=>996
            ],
            [

                'country_code'=>'LA',
                'country_name'=>'Laos',
                'phone_code'=>856
            ],
            [

                'country_code'=>'LV',
                'country_name'=>'Latvia',
                'phone_code'=>371
            ],
            [

                'country_code'=>'LB',
                'country_name'=>'Lebanon',
                'phone_code'=>961
            ],
            [

                'country_code'=>'LS',
                'country_name'=>'Lesotho',
                'phone_code'=>266
            ],
            [

                'country_code'=>'LR',
                'country_name'=>'Liberia',
                'phone_code'=>231
            ],
            [

                'country_code'=>'LY',
                'country_name'=>'Libya',
                'phone_code'=>218
            ],
            [

                'country_code'=>'LI',
                'country_name'=>'Liechtenstein',
                'phone_code'=>423
            ],
            [

                'country_code'=>'LT',
                'country_name'=>'Lithuania',
                'phone_code'=>370
            ],
            [

                'country_code'=>'LU',
                'country_name'=>'Luxembourg',
                'phone_code'=>352
            ],
            [

                'country_code'=>'MO',
                'country_name'=>'Macau S.A.R.',
                'phone_code'=>853
            ],
            [

                'country_code'=>'MK',
                'country_name'=>'Macedonia',
                'phone_code'=>389
            ],
            [

                'country_code'=>'MG',
                'country_name'=>'Madagascar',
                'phone_code'=>261
            ],
            [

                'country_code'=>'MW',
                'country_name'=>'Malawi',
                'phone_code'=>265
            ],
            [

                'country_code'=>'MY',
                'country_name'=>'Malaysia',
                'phone_code'=>60
            ],
            [

                'country_code'=>'MV',
                'country_name'=>'Maldives',
                'phone_code'=>960
            ],
            [

                'country_code'=>'ML',
                'country_name'=>'Mali',
                'phone_code'=>223
            ],
            [

                'country_code'=>'MT',
                'country_name'=>'Malta',
                'phone_code'=>356
            ],
            [

                'country_code'=>'XM',
                'country_name'=>'Man (Isle of)',
                'phone_code'=>44
            ],
            [

                'country_code'=>'MH',
                'country_name'=>'Marshall Islands',
                'phone_code'=>692
            ],
            [

                'country_code'=>'MQ',
                'country_name'=>'Martinique',
                'phone_code'=>596
            ],
            [

                'country_code'=>'MR',
                'country_name'=>'Mauritania',
                'phone_code'=>222
            ],
            [

                'country_code'=>'MU',
                'country_name'=>'Mauritius',
                'phone_code'=>230
            ],
            [

                'country_code'=>'YT',
                'country_name'=>'Mayotte',
                'phone_code'=>269
            ],
            [

                'country_code'=>'MX',
                'country_name'=>'Mexico',
                'phone_code'=>52
            ],
            [

                'country_code'=>'FM',
                'country_name'=>'Micronesia',
                'phone_code'=>691
            ],
            [

                'country_code'=>'MD',
                'country_name'=>'Moldova',
                'phone_code'=>373
            ],
            [

                'country_code'=>'MC',
                'country_name'=>'Monaco',
                'phone_code'=>377
            ],
            [

                'country_code'=>'MN',
                'country_name'=>'Mongolia',
                'phone_code'=>976
            ],
            [

                'country_code'=>'MS',
                'country_name'=>'Montserrat',
                'phone_code'=>1664
            ],
            [

                'country_code'=>'MA',
                'country_name'=>'Morocco',
                'phone_code'=>212
            ],
            [

                'country_code'=>'MZ',
                'country_name'=>'Mozambique',
                'phone_code'=>258
            ],
            [

                'country_code'=>'MM',
                'country_name'=>'Myanmar',
                'phone_code'=>95
            ],
            [

                'country_code'=>'NA',
                'country_name'=>'Namibia',
                'phone_code'=>264
            ],
            [

                'country_code'=>'NR',
                'country_name'=>'Nauru',
                'phone_code'=>674
            ],
            [

                'country_code'=>'NP',
                'country_name'=>'Nepal',
                'phone_code'=>977
            ],
            [

                'country_code'=>'AN',
                'country_name'=>'Netherlands Antilles',
                'phone_code'=>599
            ],
            [

                'country_code'=>'NL',
                'country_name'=>'Netherlands The',
                'phone_code'=>31
            ],
            [

                'country_code'=>'NC',
                'country_name'=>'New Caledonia',
                'phone_code'=>687
            ],
            [

                'country_code'=>'NZ',
                'country_name'=>'New Zealand',
                'phone_code'=>64
            ],
            [

                'country_code'=>'NI',
                'country_name'=>'Nicaragua',
                'phone_code'=>505
            ],
            [

                'country_code'=>'NE',
                'country_name'=>'Niger',
                'phone_code'=>227
            ],
            [

                'country_code'=>'NG',
                'country_name'=>'Nigeria',
                'phone_code'=>234
            ],
            [

                'country_code'=>'NU',
                'country_name'=>'Niue',
                'phone_code'=>683
            ],
            [

                'country_code'=>'NF',
                'country_name'=>'Norfolk Island',
                'phone_code'=>672
            ],
            [

                'country_code'=>'MP',
                'country_name'=>'Northern Mariana Islands',
                'phone_code'=>1670
            ],
            [

                'country_code'=>'NO',
                'country_name'=>'Norway',
                'phone_code'=>47
            ],
            [

                'country_code'=>'OM',
                'country_name'=>'Oman',
                'phone_code'=>968
            ],
            [

                'country_code'=>'PK',
                'country_name'=>'Pakistan',
                'phone_code'=>92
            ],
            [

                'country_code'=>'PW',
                'country_name'=>'Palau',
                'phone_code'=>680
            ],
            [

                'country_code'=>'PS',
                'country_name'=>'Palestinian Territory Occupied',
                'phone_code'=>970
            ],
            [

                'country_code'=>'PA',
                'country_name'=>'Panama',
                'phone_code'=>507
            ],
            [

                'country_code'=>'PG',
                'country_name'=>'Papua new Guinea',
                'phone_code'=>675
            ],
            [

                'country_code'=>'PY',
                'country_name'=>'Paraguay',
                'phone_code'=>595
            ],
            [

                'country_code'=>'PE',
                'country_name'=>'Peru',
                'phone_code'=>51
            ],
            [

                'country_code'=>'PH',
                'country_name'=>'Philippines',
                'phone_code'=>63
            ],
            [

                'country_code'=>'PN',
                'country_name'=>'Pitcairn Island',
                'phone_code'=>0
            ],
            [

                'country_code'=>'PL',
                'country_name'=>'Poland',
                'phone_code'=>48
            ],
            [

                'country_code'=>'PT',
                'country_name'=>'Portugal',
                'phone_code'=>351
            ],
            [

                'country_code'=>'PR',
                'country_name'=>'Puerto Rico',
                'phone_code'=>1787
            ],
            [

                'country_code'=>'QA',
                'country_name'=>'Qatar',
                'phone_code'=>974
            ],
            [

                'country_code'=>'RE',
                'country_name'=>'Reunion',
                'phone_code'=>262
            ],
            [

                'country_code'=>'RO',
                'country_name'=>'Romania',
                'phone_code'=>40
            ],
            [

                'country_code'=>'RU',
                'country_name'=>'Russia',
                'phone_code'=>70
            ],
            [

                'country_code'=>'RW',
                'country_name'=>'Rwanda',
                'phone_code'=>250
            ],
            [

                'country_code'=>'SH',
                'country_name'=>'Saint Helena',
                'phone_code'=>290
            ],
            [

                'country_code'=>'KN',
                'country_name'=>'Saint Kitts And Nevis',
                'phone_code'=>1869
            ],
            [

                'country_code'=>'LC',
                'country_name'=>'Saint Lucia',
                'phone_code'=>1758
            ],
            [

                'country_code'=>'PM',
                'country_name'=>'Saint Pierre and Miquelon',
                'phone_code'=>508
            ],
            [

                'country_code'=>'VC',
                'country_name'=>'Saint Vincent And The Grenadines',
                'phone_code'=>1784
            ],
            [

                'country_code'=>'WS',
                'country_name'=>'Samoa',
                'phone_code'=>684
            ],
            [

                'country_code'=>'SM',
                'country_name'=>'San Marino',
                'phone_code'=>378
            ],
            [

                'country_code'=>'ST',
                'country_name'=>'Sao Tome and Principe',
                'phone_code'=>239
            ],
            [

                'country_code'=>'SA',
                'country_name'=>'Saudi Arabia',
                'phone_code'=>966
            ],
            [

                'country_code'=>'SN',
                'country_name'=>'Senegal',
                'phone_code'=>221
            ],
            [

                'country_code'=>'RS',
                'country_name'=>'Serbia',
                'phone_code'=>381
            ],
            [

                'country_code'=>'SC',
                'country_name'=>'Seychelles',
                'phone_code'=>248
            ],
            [

                'country_code'=>'SL',
                'country_name'=>'Sierra Leone',
                'phone_code'=>232
            ],
            [

                'country_code'=>'SG',
                'country_name'=>'Singapore',
                'phone_code'=>65
            ],
            [

                'country_code'=>'SK',
                'country_name'=>'Slovakia',
                'phone_code'=>421
            ],
            [

                'country_code'=>'SI',
                'country_name'=>'Slovenia',
                'phone_code'=>386
            ],
            [

                'country_code'=>'XG',
                'country_name'=>'Smaller Territories of the UK',
                'phone_code'=>44
            ],
            [

                'country_code'=>'SB',
                'country_name'=>'Solomon Islands',
                'phone_code'=>677
            ],
            [

                'country_code'=>'SO',
                'country_name'=>'Somalia',
                'phone_code'=>252
            ],
            [

                'country_code'=>'ZA',
                'country_name'=>'South Africa',
                'phone_code'=>27
            ],
            [

                'country_code'=>'GS',
                'country_name'=>'South Georgia',
                'phone_code'=>0
            ],
            [

                'country_code'=>'SS',
                'country_name'=>'South Sudan',
                'phone_code'=>211
            ],
            [

                'country_code'=>'ES',
                'country_name'=>'Spain',
                'phone_code'=>34
            ],
            [

                'country_code'=>'LK',
                'country_name'=>'Sri Lanka',
                'phone_code'=>94
            ],
            [

                'country_code'=>'SD',
                'country_name'=>'Sudan',
                'phone_code'=>249
            ],
            [

                'country_code'=>'SR',
                'country_name'=>'Suricountry_name',
                'phone_code'=>597
            ],
            [

                'country_code'=>'SJ',
                'country_name'=>'Svalbard And Jan Mayen Islands',
                'phone_code'=>47
            ],
            [

                'country_code'=>'SZ',
                'country_name'=>'Swaziland',
                'phone_code'=>268
            ],
            [

                'country_code'=>'SE',
                'country_name'=>'Sweden',
                'phone_code'=>46
            ],
            [

                'country_code'=>'CH',
                'country_name'=>'Switzerland',
                'phone_code'=>41
            ],
            [

                'country_code'=>'SY',
                'country_name'=>'Syria',
                'phone_code'=>963
            ],
            [

                'country_code'=>'TW',
                'country_name'=>'Taiwan',
                'phone_code'=>886
            ],
            [

                'country_code'=>'TJ',
                'country_name'=>'Tajikistan',
                'phone_code'=>992
            ],
            [

                'country_code'=>'TZ',
                'country_name'=>'Tanzania',
                'phone_code'=>255
            ],
            [

                'country_code'=>'TH',
                'country_name'=>'Thailand',
                'phone_code'=>66
            ],
            [

                'country_code'=>'TG',
                'country_name'=>'Togo',
                'phone_code'=>228
            ],
            [

                'country_code'=>'TK',
                'country_name'=>'Tokelau',
                'phone_code'=>690
            ],
            [

                'country_code'=>'TO',
                'country_name'=>'Tonga',
                'phone_code'=>676
            ],
            [

                'country_code'=>'TT',
                'country_name'=>'Trincountry_idad And Tobago',
                'phone_code'=>1868
            ],
            [

                'country_code'=>'TN',
                'country_name'=>'Tunisia',
                'phone_code'=>216
            ],
            [

                'country_code'=>'TR',
                'country_name'=>'Turkey',
                'phone_code'=>90
            ],
            [

                'country_code'=>'TM',
                'country_name'=>'Turkmenistan',
                'phone_code'=>7370
            ],
            [

                'country_code'=>'TC',
                'country_name'=>'Turks And Caicos Islands',
                'phone_code'=>1649
            ],
            [

                'country_code'=>'TV',
                'country_name'=>'Tuvalu',
                'phone_code'=>688
            ],
            [

                'country_code'=>'UG',
                'country_name'=>'Uganda',
                'phone_code'=>256
            ],
            [

                'country_code'=>'UA',
                'country_name'=>'Ukraine',
                'phone_code'=>380
            ],
            [

                'country_code'=>'AE',
                'country_name'=>'United Arab Emirates',
                'phone_code'=>971
            ],
            [

                'country_code'=>'GB',
                'country_name'=>'United Kingdom',
                'phone_code'=>44
            ],
            [

                'country_code'=>'US',
                'country_name'=>'United States',
                'phone_code'=>1
            ],
            [

                'country_code'=>'UM',
                'country_name'=>'United States Minor Outlying Islands',
                'phone_code'=>1
            ],
            [

                'country_code'=>'UY',
                'country_name'=>'Uruguay',
                'phone_code'=>598
            ],
            [

                'country_code'=>'UZ',
                'country_name'=>'Uzbekistan',
                'phone_code'=>998
            ],
            [

                'country_code'=>'VU',
                'country_name'=>'Vanuatu',
                'phone_code'=>678
            ],
            [

                'country_code'=>'VA',
                'country_name'=>'Vatican City State (Holy See)',
                'phone_code'=>39
            ],
            [

                'country_code'=>'VE',
                'country_name'=>'Venezuela',
                'phone_code'=>58
            ],
            [

                'country_code'=>'VN',
                'country_name'=>'Vietnam',
                'phone_code'=>84
            ],
            [

                'country_code'=>'VG',
                'country_name'=>'Virgin Islands (British)',
                'phone_code'=>1284
            ],
            [

                'country_code'=>'VI',
                'country_name'=>'Virgin Islands (US)',
                'phone_code'=>1340
            ],
            [

                'country_code'=>'WF',
                'country_name'=>'Wallis And Futuna Islands',
                'phone_code'=>681
            ],
            [

                'country_code'=>'EH',
                'country_name'=>'Western Sahara',
                'phone_code'=>212
            ],
            [

                'country_code'=>'YE',
                'country_name'=>'Yemen',
                'phone_code'=>967
            ],
            [

                'country_code'=>'YU',
                'country_name'=>'Yugoslavia',
                'phone_code'=>38
            ],
            [

                'country_code'=>'ZM',
                'country_name'=>'Zambia',
                'phone_code'=>260
            ],
            [

                'country_code'=>'ZW',
                'country_name'=>'Zimbabwe',
                'phone_code'=>26
            ],
        ];
        Country::insert($countries);
    }

}