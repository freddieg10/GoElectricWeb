<?php
// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

/**
 *  Autos Post Types
 * ====================
 * @since 1.0
 */
if( ! class_exists( 'PIXAD_Post_Types' ) ) {
	class PIXAD_Post_Types
	{
		public function __construct() {
			add_action( 'init', array( $this, 'create_taxonomies' ), 0 );
			add_action( 'init', array( $this, 'post_type_init' ) );
			
			// Insert auto makes & models to database on request
			if( isset( $_GET['import_autos'] ) ) {
				add_action( 'init', array( $this, 'insert_terms' ) );
			}
			else
			if( isset( $_GET['remove_autos'] ) ) {
				add_action( 'init', array( $this, 'remove_terms' ) );
			}
		}
		
		/**
		 * Remove Makes & Models
		 * =====================
		 * @since 1.0
		 */
		function remove_terms() {
			if( is_admin() ) {
				ini_set('memory_limit', '512M');
				$terms = get_terms( 'auto-model', array( 'fields' => 'ids', 'hide_empty' => false ) );
				foreach ( $terms as $value ) {
					wp_delete_term( $value, 'auto-model' );
				}
			}
		}
		
		/**
		 * Autos Makes & Models
		 * ===================
		 * @since 1.0
		 */
		public function insert_terms() {
			ini_set('memory_limit', '512M');
			$autos = array(
				'AC' => array( 
					'Cobra', 
					'Other' 
				),
				'Alfa Romeo' => array( 
					'33', 
					'75',
					'145',
					'146',
					'147',
					'155',
					'156',
					'156 Crosswagon',
					'159',
					'164',
					'166',
					'Brera',
					'Giulietta',
					'GT',
					'GTV',
					'MiTo',
					'Spider',
					'Sprint',
					'Other'
				),
				'Alpina' => array( 
					'B 5', 'Other' 
				),
				'Aro' => array( 
					'Series 10', 
					'Other' 
				),
				'Audi' => array( 
					'80', 
					'90',
					'100',
					'200',
					'A1',
					'A2',
					'A3',
					'A4',
					'A4 Allroad',
					'A5',
					'A6',
					'A6 Allroad',
					'A7',
					'A8',
					'Q3',
					'Q5',
					'Q7',
					'S3',
					'S4',
					'S6',
					'S8',
					'TT',
					'R8',
					'RS4',
					'Coupe',
					'V8',
					'Other'
				),
				'Bentley' => array( 
					'Continental', 
					'Other' 
				),
				'BMW' => array(
					'114',
					'116',
					'118',
					'120',
					'123',
					'216',
					'218',
					'315',
					'316',
					'318',
					'320',
					'323',
					'324',
					'325',
					'328',
					'330',
					'335',
					'420',
					'428',
					'518',
					'520',
					'523',
					'524',
					'525',
					'528',
					'530',
					'535',
					'540',
					'545',
					'550',
					'630',
					'635',
					'640',
					'645',
					'650',
					'725',
					'728',
					'730',
					'735',
					'740',
					'745',
					'750',
					'850',
					'M1',
					'M3',
					'M5',
					'M6',
					'Z3 M',
					'X1',
					'X3',
					'X4',
					'X5',
					'X6',
					'Z3',
					'Z4',
					'1602',
					'Other'
				),
				'Buick' => array( 
					'Electra', 
					'Riviera', 
					'Other' 
				),
				'Cadillac' => array( 
					'BLS',
					'CTS',
					'Deville',
					'Escalade',
					'Fleetwood',
					'Other'
				),
				'Chery' => array(
					'Ego',
					'Tiggo',
					'Other'
				),
				'Chevrolet' => array(
					'Aveo',
					'Beretta',
					'Blazer',
					'Camaro',
					'Captiva',
					'Cavalier',
					'Chevelle',
					'Corsica',
					'Cruze',
					'Epica',
					'Evanda',
					'Impala',
					'Kalos',
					'Lacetti',
					'Lumina',
					'Matiz',
					'Niva',
					'Nubira',
					'Orlando',
					'Spark',
					'Tacuma',
					'Tracker',
					'Trailblazer',
					'Trax',
					'Other'
				),
				'Chrysler' => array(
					'300M',
					'300C',
					'Concorde',
					'Crossfire',
					'Grand Voyager',
					'Le Baron',
					'Neon',
					'Pacifica',
					'PT Cruiser',
					'Saratoga',
					'Sebring',
					'Stratus',
					'Sunbeam',
					'Voyager',
					'Other'
				),
				'Citroen' => array(
					'2CV',
					'Ami',
					'AX',
					'Berlingo',
					'BX',
					'C-Crosser',
					'C-ELYSEE',
					'C1',
					'C2',
					'C3',
					'C3 Picasso',
					'C3 pluriel',
					'C4',
					'C4 Aircross',
					'C4 Grand Picasso',
					'C4 Picasso',
					'C5',
					'C6',
					'C8',
					'C15',
					'CX',
					'DS',
					'DS3',
					'DS4',
					'DS5',
					'Dyane',
					'Evasion',
					'GS',
					'Jumpy',
					'Nemo',
					'Saxo',
					'Visa',
					'Xantia',
					'XM',
					'Xsara',
					'Xsara Picasso',
					'ZX',
					'Other'
				),
				'Dacia' => array(
					'1304',
					'1307',
					'Double',
					'Duster',
					'Logan',
					'Nova',
					'Pickup',
					'Sandero',
					'Solenza',
					'Stepway',
					'Super Nova',
					'Other'
				),
				'Daewoo' => array(
					'Espero',
					'Evanda',
					'Kalos',
					'Korando',
					'Lacetti',
					'Lanos',
					'Leganza',
					'Matiz',
					'Musso',
					'Nexia',
					'Nubira',
					'Racer',
					'Tacuma',
					'Tico',
					'Other'
				),
				'Daihatsu' => array(
					'Applause',
					'Charade',
					'Cuore',
					'Feroza',
					'Gran Move',
					'Move',
					'Rocky',
					'Sirion',
					'Terios',
					'YRV',
					'Other'
				),
				'Dodge' => array(
					'Avenger',
					'Caliber',
					'Autoavan',
					'Grand Autoavan',
					'Intrepid',
					'Journey',
					'Neon',
					'Nitro',
					'RAM',
					'Stratus',
					'Other'
				),
				'Ferrari' => array(
					'308',
					'Other'
				),
				'Fiat' => array(
					'124',
					'125',
					'126',
					'127',
					'128',
					'131',
					'500',
					'500L',
					'500X',
					'850',
					'1100',
					'1107',
					'1300',
					'Albea',
					'Barchetta',
					'Brava',
					'Bravo',
					'Campagnola',
					'Cinquecento',
					'Coupe',
					'Chroma',
					'Doblo',
					'Duna',
					'Fiorino',
					'Freemont',
					'Grande Punto',
					'Idea',
					'Linea',
					'Marea',
					'Marengo',
					'Multipla',
					'Palio',
					'Panda',
					'Punto',
					'Qubo',
					'Regata',
					'Ritmo',
					'Scudo',
					'Sedici',
					'Seicento',
					'Spider Europa',
					'Stilo',
					'Tempra',
					'Tipo',
					'Ulysse',
					'x 1/9',
					'Other'
				),
				'Ford' => array(
					'Aerostar',
					'B-Max',
					'Bronco',
					'Capri',
					'Cougar',
					'Courier',
					'Escort',
					'Excursion',
					'Explorer',
					'F 250',
					'Festiva',
					'Fiesta',
					'Focus',
					'Focus C-Max',
					'Fusion',
					'Galaxy',
					'Granada',
					'Ka',
					'Kuga',
					'Maverick',
					'Mondeo',
					'Mustang',
					'Orion',
					'Probe',
					'Puma',
					'Ranger',
					'S-Max',
					'Scorpio',
					'Sierra',
					'Street Ka',
					'Taunus',
					'Taurus',
					'Thunderbird',
					'Tourneo',
					'Transit Connect',
					'Windstar',
					'Other'
				),
				'GAZ' => array(
					'3102',
					'Other'
				),
				'Honda' => array(
					'Accord',
					'Civic',
					'Concerto',
					'CR-V',
					'CRX',
					'Element',
					'FR-V',
					'HR-V',
					'Insight',
					'Integra',
					'Jazz',
					'Legend',
					'Prelude',
					'Other'
				),
				'Hummer' => array(
					'H1',
					'H2',
					'H3',
					'Other'
				),
				'Hyundai' => array(
					'Accent',
					'Atos',
					'Coupe',
					'Elantra',
					'Galloper',
					'Genesis',
					'Getz',
					'Grandeur',
					'H 100',
					'H 1',
					'i10',
					'i20',
					'i30',
					'i40',
					'ix20',
					'ix35',
					'ix55',
					'Lantra',
					'Matrix',
					'Pony',
					'Santa Fe',
					'S-Coupe',
					'Sonata',
					'Terracan',
					'Trajet',
					'Tucson',
					'XG 30',
					'Other'
				),
				'Infinity' => array(
					'FX35',
					'Other'
				),
				'Isuzu' => array(
					'D-Max',
					'Gemini',
					'Trooper',
					'Other'
				),
				'Jaguar' => array(
					'S-Type',
					'XF',
					'XJ',
					'XJ6',
					'XK',
					'X-Type',
					'Other'
				),
				'Jeep' => array(
					'Cherokee',
					'CJ',
					'Commander',
					'Compass',
					'Grand Cherokee',
					'Liberty',
					'Patriot',
					'Renegade',
					'Willys',
					'Wrangler',
					'Other'
				),
				'Katay Gonow' => array(
					'Victory',
					'Other'
				),
				'Kia' => array(
					'Autoens',
					'Autonival',
					"cee'd",
					"cee'd sw",
					'Cerato',
					'Clarus',
					'Joice',
					'Magentis',
					'Picanto',
					'Pride',
					"pro_cee'd",
					'Rio',
					'Sephia',
					'Shuma',
					'Sorento',
					'Soul',
					'Spectra',
					'Sportage',
					'Other'
				),
				'Lada' => array(
					'110',
					'111',
					'112',
					'1200',
					'1300',
					'1500',
					'1600',
					'2101',
					'2104',
					'2105',
					'2107',
					'Aleko',
					'Kalina',
					'Niva',
					'Riva',
					'Samara',
					'Other'
				),
				'Lancia' => array(
					'Beta',
					'Dedra',
					'Delta',
					'Kappa',
					'Lybra',
					'Musa',
					'Phedra',
					'Prisma',
					'Thema',
					'Thesis',
					'Ypsilon',
					'Zeta',
					'Other'
				),
				'Land Rover' => array(
					'Defender',
					'Discovery',
					'Freelander',
					'Range Rover',
					'Range Rover Evoque',
					'Range Rover Sport',
					'Series II',
					'Series III',
					'Other'
				),
				'Lexus' => array(
					'CT 200h',
					'GS 300',
					'GS 450',
					'IS 200',
					'IS 220',
					'LS 460',
					'RX 300',
					'RX 400',
					'Other'
				),
				'Lincoln' => array(
					'Navigator',
					'Town auto',
					'Other'
				),
				'Lotus' => array(
					'Elise',
					'Esprit',
					'Super Seven',
					'Other'
				),
				'Mahindra' => array(
					'Bolero',
					'CJ',
					'Goa',
					'Other'
				),
				'Maserati' => array(
					'4200',
					'Ghibli',
					'Granturismo',
					'Quattroporte',
					'Other'
				),
				'Mazda' => array(
					'121',
					'2',
					'3',
					'323',
					'5',
					'6',
					'626',
					'BT-50',
					'CX-5',
					'CX-7',
					'Demio',
					'MPV',
					'MX-3',
					'MX-6',
					'Premacy',
					'RX-7',
					'RX-8',
					'Series B',
					'Tribute',
					'Xedos',
					'Other'
				),
				'Mercedez Benz' => array(
					'A140',
					'A150',
					'A160',
					'A170',
					'A180',
					'A190',
					'A200',
					'A250',
					'B150',
					'B160',
					'B170',
					'B180',
					'B200',
					'C180',
					'C200',
					'C220',
					'C230',
					'C240',
					'C250',
					'C270',
					'C280',
					'C300',
					'C320',
					'C 63 AMG',
					'CE 200',
					'CE 230',
					'CE 300',
					'CLA 180',
					'CLA 200',
					'CLA 220',
					'CL 500',
					'CL 55 AMG',
					'CLC 200',
					'CLC 220',
					'CLK 200',
					'CLK 220',
					'CLK 230',
					'CLK 270',
					'CLK 320',
					'CLS 320',
					'CLS 350',
					'CLS 500',
					'CLS 55 AMG',
					'E 200',
					'E 220',
					'E 230',
					'E 240',
					'E 250',
					'E 260',
					'E 270',
					'E 280',
					'E 290',
					'E 300',
					'E 320',
					'E 350',
					'E 420',
					'E 500',
					'G 240',
					'G 250',
					'G 290',
					'G 300',
					'G 500',
					'GL 320',
					'GL 350',
					'GL 420',
					'GL 450',
					'GLA 200',
					'GLA 220',
					'GLK 200',
					'GLK 220',
					'GLK 250',
					'GLK 320',
					'MB 100',
					'ML 230',
					'ML 250',
					'ML 270',
					'ML 280',
					'ML 300',
					'ML 320',
					'ML 350',
					'ML 400',
					'ML 430',
					'ML 500',
					'ML 55 AMG',
					'ML 63 AMG',
					'R 280',
					'R 320',
					'S 250',
					'S 260',
					'S 280',
					'S 300',
					'S 320',
					'S 350',
					'S 400',
					'S 420',
					'S 500',
					'S 55',
					'S 600',
					'SL 280',
					'SL 300',
					'SL 350',
					'SL 380',
					'SL 500',
					'SLK 200',
					'SLK 230',
					'Vaneo',
					'180',
					'190',
					'Other'
				),
				'Mercury' => array(
					'Capri',
					'Other'
				),
				'Mini' => array(
					
				),
				'MG' => array(
					'MGF',
					'TF',
					'ZR',
					'ZS',
					'ZT',
					'Other'
				),
				'Mitsubishi' => array(
					'3000GT',
					'ASX',
					'Autoisma',
					'Colt',
					'Eclipse',
					'Galant',
					'Grandis',
					'L200',
					'L300',
					'Lancer',
					'Outlander',
					'Pajero',
					'Pajero Pinin',
					'Sigma',
					'Space Runner',
					'Space Star',
					'Space Wagon',
					'Other'
				),
				'Moszkvics' => array(
					'2140',
					'Aleko 2141',
					'Other'
				),
				'Nissan' => array(
					'100 NX',
					'200 SX',
					'350Z',
					'370Z',
					'Almera',
					'Almera Tino',
					'Bluebird',
					'Cherry',
					'Juke',
					'Kubistar',
					'Maxima',
					'Micra',
					'Murano',
					'Navara',
					'Note',
					'Pathfinder',
					'Patrol',
					'Praire',
					'Primastar',
					'Primera',
					'Qashqai',
					'Qashqai + 2',
					'Serena',
					'Silvia',
					'Sunny',
					'Terrano',
					'Tiida',
					'Vanette',
					'Xterra',
					'X-Trail',
					'Other'
				),
				'Oldsmobile' => array(
					'Ninety Eight',
					'Other'
				),
				'Opel' => array(
					'Adam',
					'Agila',
					'Antara',
					'Ascona',
					'Astra F',
					'Astra G',
					'Astra H',
					'Astra J',
					'Calibra',
					'Combo',
					'Commodore',
					'Corsa A',
					'Corsa B',
					'Corsa C',
					'Corsa D',
					'Frontera',
					'GT',
					'Insignia',
					'Kadett',
					'Manta',
					'Meriva',
					'Mokka',
					'Olympia',
					'Omega',
					'Rekord',
					'Senator',
					'Signum',
					'Sintra',
					'Tigra',
					'Vectra A',
					'Vectra B',
					'Vectra C',
					'Zafira',
					'Other'
				),
				'Peugot' => array(
					'104',
					'106',
					'107',
					'108',
					'204',
					'205',
					'206',
					'207',
					'208',
					'301',
					'304',
					'305',
					'306',
					'307',
					'308',
					'309',
					'404',
					'405',
					'406',
					'407',
					'504',
					'505',
					'508',
					'605',
					'607',
					'806',
					'807',
					'1007',
					'2008',
					'3008',
					'4007',
					'5008',
					'Bipper',
					'Expert',
					'Partner',
					'Ranch',
					'RCZ',
					'Other'
				),
				'Piaggio' => array(
					'Ape',
					'Other'
				),
				'Plymouth' => array(
					'Breeze',
					'Voyager',
					'Other'
				),
				'Polski Fiat' => array(
					'125 P',
					'Other'
				),
				'Pontiac' => array(
					'Fiero',
					'Firebird',
					'Grand Prix',
					'Sunfire',
					'Trans Am',
					'Trans Sport',
					'Other'
				),
				'Porsche' => array(
					'356',
					'911',
					'924',
					'928',
					'944',
					'997',
					'Boxter',
					'Cayenne',
					'Cayman',
					'Panamera',
					'Other'
				),
				'Proton' => array(
					'Series 400',
					'Other'
				),
				'Renault' => array(
					'Captur',
					'Clio',
					'Espace',
					'Express',
					'Fluence',
					'Fuego',
					'Grand Espace',
					'Grand Modus',
					'Grand Scenic',
					'Kangoo',
					'Koleos',
					'Laguna',
					'Latitude',
					'Megane',
					'Modus',
					'Nevada',
					'R 4',
					'R 5',
					'R 8',
					'R 9',
					'R 10',
					'R 11',
					'R 18',
					'R 19',
					'R 21',
					'R 25',
					'Rapid',
					'Safrane',
					'Scenic',
					'Thalia',
					'Twingo',
					'Vel Satis',
					'Other'
				),
				'Rolls Royce' => array(
					'Wraith',
					'Other'
				),
				'Rover' => array(
					'100',
					'200',
					'214',
					'216',
					'220',
					'25',
					'400',
					'416',
					'45',
					'600',
					'620',
					'75',
					'800',
					'820',
					'825',
					'Streetwise',
					'Other'
				),
				'Saab' => array(
					'90',
					'900',
					'9000',
					'9-3',
					'9-5',
					'99',
					'Other'
				),
				'Seat' => array(
					'Alhambra',
					'Altea',
					'Arosa',
					'Cordoba',
					'Exeo',
					'Ibiza',
					'Inca',
					'Leon',
					'Marbella',
					'Terra',
					'Toledo',
					'Other'
				),
				'Shuanghuan' => array(
					'CEO',
					'Other'
				),
				'Smart' => array(
					'Crossblade',
					'ForFour',
					'ForTwo',
					'Roadster',
					'Other'
				),
				'SsangYong' => array(
					'Actyon',
					'Korando',
					'Kyron',
					'Musso',
					'Rexton',
					'Other'
				),
				'Subaru' => array(
					'1800',
					'Forester',
					'Impreza',
					'Justy',
					'Legacy',
					'Leone',
					'Libero',
					'Outback',
					'SVX',
					'Tribeca',
					'Vivio',
					'Other'
				),
				'Suzuki' => array(
					'Alto',
					'Baleno',
					'Autory',
					'Grand Vitara',
					'Ignis',
					'Jimny',
					'Liana',
					'Maruti',
					'SJ Samurai',
					'Splash',
					'Swift',
					'SX4',
					'Vitara',
					'Wagon R+',
					'Other'
				),
				'Škoda' => array(
					'100',
					'105',
					'120',
					'135',
					'1000 MB',
					'Citigo',
					'Fabia',
					'Favorit',
					'Felicia',
					'Forman',
					'Octavia',
					'Praktik',
					'Rapid',
					'Roomster',
					'Superb',
					'Yeti',
					'Other'
				),
				'Talbot' => array(
					'Solara',
					'Other'
				),
				'Tata' => array(
					'Indica',
					'Safari',
					'Other'
				),
				'Tavria' => array(
					'1102',
					'Other'
				),
				'Toyota' => array(
					'4Runner',
					'Auris',
					'Avensis',
					'Avensis Verso',
					'Aygo',
					'Camry',
					'Autoina',
					'Celica',
					'Corolla',
					'Corolla Verso',
					'Hilux',
					'iQ',
					'Land Cruiser',
					'Liteace',
					'MR2',
					'Paseo',
					'Picnic',
					'Previa',
					'Prius',
					'RAV 4',
					'Starlet',
					'Supra',
					'Tercel',
					'Urban Cruiser',
					'Verso',
					'Yaris',
					'Yaris Verso',
					'Other'
				),
				'Trabant' => array(
					'601',
					'Other'
				),
				'Triumph' => array(
					'Herald',
					'Spitfire',
					'Other'
				),
				'UAZ' => array(
					'69',
					'452',
					'469',
					'31514',
					'Other'
				),
				'Vauxhall' => array(
					'Vectra',
					'Other'
				),
				'Volkswagen' => array(
					'181',
					'Amarok',
					'Bora',
					'Buggy',
					'Buba',
					'Nova Buba',
					'Caddy',
					'Corrado',
					'EOS',
					'Fox',
					'Golf 1',
					'Golf 2',
					'Golf 3',
					'Golf 4',
					'Golf 5',
					'Golf 6',
					'Golf 7',
					'Golf Plus',
					'Jetta',
					'Lupo',
					'Passat B1',
					'Passat B2',
					'Passat B3',
					'Passat B4',
					'Passat B5',
					'Passat B5.5',
					'Passat B6',
					'Passat B7',
					'Passat B8',
					'Phaeton',
					'Polo',
					'Santana',
					'Scirocco',
					'Sharan',
					'Tiguan',
					'Touareg',
					'Touran',
					'up!',
					'Vento',
					'Other'
				),
				'Volvo' => array(
					'240',
					'244',
					'245',
					'340',
					'360',
					'440',
					'460',
					'480',
					'740',
					'745',
					'760',
					'850',
					'940',
					'960',
					'Amazon',
					'C30',
					'C70',
					'S40',
					'S60',
					'S70',
					'S80',
					'V40',
					'V50',
					'V60',
					'V70',
					'XC60',
					'XC70',
					'XC90',
					'Other'
				),
				'Wartburg' => array(
					'311',
					'353',
					'Other'
				),
				'Zastava' => array(
					'10',
					'101',
					'128',
					'1300',
					'1500',
					'750',
					'850',
					'AR 55',
					'Florida',
					'Florida In',
					'Koral',
					'Koral In',
					'Poly',
					'Skala 55',
					'Yugo 45',
					'Yugo 55',
					'Yugo 60',
					'Yugo 65',
					'Yugo Cabrio',
					'Yugo Ciao',
					'Yugo In L',
					'Yugo Tempo',
					'Other'
				),
				'Other' => array()
			);
			foreach( $autos as $make => $models ) {
				if( ! term_exists( $make ) ) {
					$parent = wp_insert_term( sanitize_text_field($make), 'auto-model' );
					foreach( $models as $model ) {
						wp_insert_term( sanitize_text_field($model), 'auto-model', array('parent' => $parent['term_id']) );
					}	
				}
			}
			delete_option( 'auto-model_children' );
		}

		/**
		 * Register a "pixad-autos" post_type
		 *
		 * @since 1.0
		 */
		function post_type_init() {
			$labels = array(
				'name'               => __( 'Autos', 'pixad' ),
				'singular_name'      => __( 'Autos', 'pixad' ),
				'menu_name'          => __( 'Autos', 'pixad' ),
				'name_admin_bar'     => __( 'Autos', 'pixad' ),
				'add_new'            => __( 'New Auto', 'pixad' ),
				'add_new_item'       => __( 'New Auto', 'pixad' ),
				'new_item'           => __( 'New Auto', 'pixad' ),
				'edit_item'          => __( 'Edit Auto', 'pixad' ),
				'view_item'          => __( 'View Auto', 'pixad' ),
				'all_items'          => __( 'All Autos', 'pixad' ),
				'search_items'       => __( 'Search Autos', 'pixad' ),
				'parent_item_colon'  => __( 'Parent Autos:', 'pixad' ),
				'not_found'          => __( 'No autos found.', 'pixad' ),
				'not_found_in_trash' => __( 'No autos found in Trash.', 'pixad' )
			);

			$args = array(
				'labels'            	=> $labels,
				'public'             	=> true,
				'publicly_queryable' 	=> true,
				'show_ui'            	=> true,
				'show_in_menu'       	=> true,
				'query_var'          	=> true,
				'rewrite'            	=> array( 'slug' => 'autos' ),
				'capability_type'    	=> 'post',
				'has_archive'        	=> false,
				'hierarchical'       	=> false,
				'menu_position'      	=> null,
				'menu_icon'			 	=> PIXAD_AUTO_URI . 'assets/img/pixad.png',
				'supports'           	=> array( 'title', 'editor', 'thumbnail', 'author', 'comments', 'page-attributes', 'excerpt' ),
				'register_meta_box_cb'	=> 'add_pixad_auto_meta_boxes',
			);

			register_post_type( 'pixad-autos', $args );


			add_filter('manage_edit-pixad-autos_columns', 'pixad_autos_edit_columns');
			add_action('manage_posts_custom_column',  'pixad_autos_custom_columns');

			function pixad_autos_edit_columns($columns){
				$columns = array(
					'cb' => '<input type="checkbox" />',
					'title' => 'Title',
					'auto_image' => 'Featured Image',
					'id' => 'ID',
					'auto_model' => 'Model',
					'auto_body' => 'Body Style',
					'date' => 'Date',
					'purpose' => 'Auto Purpose'

				);

				return $columns;
			}

			function pixad_autos_custom_columns($column){
				global $post;
				switch ($column)
				{
					case "id":
						echo $post->ID;
						break;

					case "auto_model":
						echo get_the_term_list($post->ID, 'auto-model', '', ', ','');
						break;

					case 'auto_body':
						echo get_the_term_list($post->ID, 'auto-body', '', ', ','');
						break;

					case 'auto_image':
						the_post_thumbnail( 'autozone-thumb' );
						break;

                    case 'purpose':
                        $metaData = get_post_meta( $post->ID , '_auto_purpose' , true );
                        echo $metaData;
                        break;
				}
			}

		}

		/**
		 * Create Two Taxonomies, "models" && "equipments" For The Post Type "pixad-autos"
		 *
		 * @since 1.0
		 */
		function create_taxonomies() {
			// Add new taxonomy, make it hierarchical (like categories)
			$labels = array(
				'name'              => __( 'Model', 'pixad' ),
				'singular_name'     => __( 'Models', 'pixad' ),
				'search_items'      => __( 'Search Auto Models', 'pixad' ),
				'all_items'         => __( 'All Auto Models', 'pixad' ),
				'parent_item'       => __( 'Parent Auto Model', 'pixad' ),
				'parent_item_colon' => __( 'Parent Auto Model:', 'pixad' ),
				'edit_item'         => __( 'Edit Auto Model', 'pixad' ),
				'update_item'       => __( 'Update Auto Model', 'pixad' ),
				'add_new_item'      => __( 'Add Auto Model', 'pixad' ),
				'new_item_name'     => __( 'New Auto Model Name', 'pixad' ),
				'menu_name'         => __( 'Models', 'pixad' ),
			);

			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'auto-model' ),
			);

			register_taxonomy( 'auto-model', array( 'pixad-autos' ), $args );


			// Add new taxonomy, make it hierarchical (like categories)
			$labels = array(
				'name'              => __( 'Body Style', 'pixad' ),
				'singular_name'     => __( 'Body Styles', 'pixad' ),
				'search_items'      => __( 'Search Body Style', 'pixad' ),
				'all_items'         => __( 'All Body Styles', 'pixad' ),
				'parent_item'       => __( 'Parent Body Style', 'pixad' ),
				'parent_item_colon' => __( 'Parent Body Style:', 'pixad' ),
				'edit_item'         => __( 'Edit Body Style', 'pixad' ),
				'update_item'       => __( 'Update Body Style', 'pixad' ),
				'add_new_item'      => __( 'Add Car Body Style', 'pixad' ),
				'new_item_name'     => __( 'New Body Style Name', 'pixad' ),
				'menu_name'         => __( 'Body Styles', 'pixad' ),
			);

			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'auto-body' ),
			);

			register_taxonomy( 'auto-body', array( 'pixad-autos' ), $args );


			// Add new taxonomy, make it hierarchical (like categories)
			$labels = array(
				'name'              => __( 'Equipment', 'pixad' ),
				'singular_name'     => __( 'Equipments', 'pixad' ),
				'search_items'      => __( 'Search Equipment', 'pixad' ),
				'all_items'         => __( 'All Equipments', 'pixad' ),
				'parent_item'       => __( 'Parent Equipment', 'pixad' ),
				'parent_item_colon' => __( 'Parent Eqipment:', 'pixad' ),
				'edit_item'         => __( 'Edit Equipment', 'pixad' ),
				'update_item'       => __( 'Update Equipment', 'pixad' ),
				'add_new_item'      => __( 'Add Car Equipment', 'pixad' ),
				'new_item_name'     => __( 'New Equipment Name', 'pixad' ),
				'menu_name'         => __( 'Equipments', 'pixad' ),
			);

			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'auto-equipment' ),
			);

			register_taxonomy( 'auto-equipment', array( 'pixad-autos' ), $args );

			add_filter('manage_edit-auto-body_columns', 'pixad_auto_body_columns');
			add_filter('manage_auto-body_custom_column', 'pixad_auto_body_custom_column', 10, 3);

			function pixad_auto_body_columns($columns){
				unset(
					$columns['cb']
				);
				$new_columns = array(
					'cb' => '<input type="checkbox" />',
					'thumbnail' =>  __('Thumbnail', 'pixad'),
				);
			    return array_merge($new_columns, $columns);
			}

			function pixad_auto_body_custom_column($c, $column_name, $term_id){
				$t_id = $term_id;
				$pixad_body_thumb_url = get_option("pixad_body_thumb".$t_id);
				switch ($column_name)
				{
					case "thumbnail": ;
						if(!empty($pixad_body_thumb_url))
			                echo '<img src="'.esc_url($pixad_body_thumb_url).'" style="max-width:100px;" >';
						break;

					default:
						break;
				}
			}
			
			add_filter('manage_edit-auto-model_columns', 'pixad_auto_model_columns');
			add_filter('manage_auto-model_custom_column', 'pixad_auto_model_custom_column', 10, 3);

			function pixad_auto_model_columns($columns){
				unset(
					$columns['cb']
				);
				$new_columns = array(
					'cb' => '<input type="checkbox" />',
					'thumbnail' =>  __('Thumbnail', 'pixad'),
				);
			    return array_merge($new_columns, $columns);
			}

			function pixad_auto_model_custom_column($c, $column_name, $term_id){
				$t_id = $term_id;
				$pixad_model_thumb_url = get_option("pixad_model_thumb".$t_id);
				switch ($column_name)
				{
					case "thumbnail": ;
						if(!empty($pixad_model_thumb_url))
			                echo '<img src="'.esc_url($pixad_model_thumb_url).'" style="max-width:100px;" >';
						break;

					default:
						break;
				}
			}
			
			
			

			add_filter('manage_edit-auto-equipment_columns', 'pixad_auto_equipment_columns');
			add_filter('manage_auto-equipment_custom_column', 'pixad_auto_equipment_custom_column', 10, 3);

			function pixad_auto_equipment_columns($columns){

				$new_columns = array(
					'icon' =>  __('Icon class', 'pixad'),
				);
			    return array_merge($columns, $new_columns);
			}

			function pixad_auto_equipment_custom_column($c, $column_name, $term_id){
				$t_id = $term_id;
				$equipment_icon = get_option("auto_equipment_icon_$t_id");
				switch ($column_name)
				{
					case "icon": ;
						if(!empty($equipment_icon))
			                echo esc_attr($equipment_icon);
						break;

					default:
						break;
				}
			}
			
		}
	}
	new PIXAD_Post_Types;
	
	
	add_action('admin_init', 'pixad_body_custom_fields', 1);
	function pixad_body_custom_fields()	{
		add_action( 'edited_auto-body', 'pixad_body_custom_fields_save' );
		add_action( 'auto-body_edit_form_fields', 'pixad_body_custom_fields_form' );
        add_action( 'auto-body_add_form_fields', 'pixad_body_custom_fields_add_form' );
        add_action( 'created_auto-body', 'pixad_body_custom_fields_save' );
	}

	function pixad_body_custom_fields_form($tag){
		$t_id = $tag->term_id;
		$cat_meta = get_option("auto_body_$t_id");
		$pixad_body_thumb_url = get_option('pixad_body_thumb' . $t_id);

		$pixad_body_thumb_filter_url = get_option('pixad_body_thumb_filter' . $t_id);

	?>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="tag-pixad_body_icon"><?php _e('Icon', 'pixad'); ?></label></th>
			<td>
				<input type="text" name="pixad_body_icon" id="tag-pixad_body_icon" size="25" style="width:60%;" value="<?php echo esc_attr($cat_meta['pixad_body_icon']) ? esc_attr($cat_meta['pixad_body_icon']) : ''; ?>">
				<button type="button" class="btn pix-reset pix-btn-icon"><i class="fa fa-trash-o"></i></button><br />
				<span class="description"><?php _e('Icon class', 'pixad'); ?></span>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="tag-pixad_body_thumb"><?php _e('Thumbnail', 'pixad'); ?></label></th>
			<td>
				<input type="text" name="pixad_body_thumb" id="tag-pixad_body_thumb" style="width:60%;" value="<?php echo isset($pixad_body_thumb_url) ? esc_url($pixad_body_thumb_url) : ''; ?>" />
				<button data-input="tag-pixad_body_thumb" class="btn pix-image-upload pix-btn-icon"><i class="fa fa-picture-o"></i></button>
				<button type="button" class="btn pix-reset pix-btn-icon"><i class="fa fa-trash-o"></i></button>
				<?php if(isset($pixad_body_thumb_url) && $pixad_body_thumb_url){ ?><p class="pix-bg"> <img src="<?php echo esc_url($pixad_body_thumb_url) ?>" alt="<?php esc_attr_e('Thumbnail', 'pixad') ?>"> </p><?php } ?>
			</td>
		</tr>


		<tr class="form-field">
			<th scope="row" valign="top"><label for="tag-pixad_body_thumb_filter"><?php _e('Thumbnail for filter', 'pixad'); ?></label></th>
			<td>
				<input type="text" name="pixad_body_thumb_filter" id="tag-pixad_body_thumb_filter" style="width:60%;" value="<?php echo isset($pixad_body_thumb_filter_url) ? esc_url($pixad_body_thumb_filter_url) : ''; ?>" />
				<button data-input="tag-pixad_body_thumb_filter" class="btn pix-image-upload pix-btn-icon"><i class="fa fa-picture-o"></i></button>
				<button type="button" class="btn pix-reset pix-btn-icon"><i class="fa fa-trash-o"></i></button>
				<?php if(isset($pixad_body_thumb_filter_url) && $pixad_body_thumb_filter_url){ ?><p class="pix-bg"> <img src="<?php echo esc_url($pixad_body_thumb_filter_url) ?>" alt="<?php esc_attr_e('Thumbnail for filter', 'pixad') ?>"> </p><?php } ?>
			</td>
		</tr>






		<?php
	}

	function pixad_body_custom_fields_add_form($tag) {
	?>
		<div class="form-field">
			<label for="tag-pixad_body_icon"><?php _e('Icon', 'pixad'); ?></label>
			<input type="text" name="pixad_body_icon" id="tag-pixad_body_icon" size="40" value="">
			<br />
			<p><?php _e('Icon class', 'pixad'); ?></p>
		</div>
		<div class="form-field">
			<label for="tag-pixad_body_thumb"><?php _e('Image', 'pixad'); ?></label>
			<input type="text" name="pixad_body_thumb" id="tag-pixad_body_thumb" value="">
			<button data-input="tag-pixad_body_thumb" class="btn pix-image-upload pix-btn-icon"><i class="fa fa-picture-o"></i></button>
			<button type="button" class="btn pix-reset pix-btn-icon"><i class="fa fa-trash-o"></i></button>
		</div>
	<?php
	}

	function pixad_body_custom_fields_save($term_id) {
		if (isset($_POST['pixad_body_thumb']) || isset($_POST['pixad_body_thumb_filter']) || isset($_POST['pixad_body_icon'])) {
			$cat_meta = get_option("auto_body_$term_id");
			if (isset($_POST['pixad_body_thumb'])) {
				update_option('pixad_body_thumb' . $term_id, $_POST['pixad_body_thumb']);
			}
			if (isset($_POST['pixad_body_thumb_filter'])) {
				update_option('pixad_body_thumb_filter' . $term_id, $_POST['pixad_body_thumb_filter']);
			}
			if (isset($_POST['pixad_body_icon'])) {
				$cat_meta['pixad_body_icon'] = $_POST['pixad_body_icon'];
			}

			//save the option array
			update_option("auto_body_$term_id", $cat_meta);
		}
	}
	
	
	add_action('admin_init', 'pixad_model_custom_fields', 1);
	function pixad_model_custom_fields()	{
		add_action( 'edited_auto-model', 'pixad_model_custom_fields_save' );
		add_action( 'auto-model_edit_form_fields', 'pixad_model_custom_fields_form' );
        add_action( 'auto-model_add_form_fields', 'pixad_model_custom_fields_add_form' );
        add_action( 'created_auto-model', 'pixad_model_custom_fields_save' );
	}

	function pixad_model_custom_fields_form($tag){
		$t_id = $tag->term_id;
		$cat_meta = get_option("auto_model_$t_id");
		$pixad_model_thumb_url = get_option('pixad_model_thumb' . $t_id);
	?>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="tag-pixad_model_icon"><?php _e('Icon', 'pixad'); ?></label></th>
			<td>
				<input type="text" name="pixad_model_icon" id="tag-pixad_model_icon" size="25" style="width:60%;" value="<?php echo esc_attr($cat_meta['pixad_model_icon']) ? esc_attr($cat_meta['pixad_model_icon']) : ''; ?>">
				<button type="button" class="btn pix-reset pix-btn-icon"><i class="fa fa-trash-o"></i></button><br />
				<span class="description"><?php _e('Icon class', 'pixad'); ?></span>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="tag-pixad_model_thumb"><?php _e('Thumbnail', 'pixad'); ?></label></th>
			<td>
				<input type="text" name="pixad_model_thumb" id="tag-pixad_model_thumb" style="width:60%;" value="<?php echo isset($pixad_model_thumb_url) ? esc_url($pixad_model_thumb_url) : ''; ?>" />
				<button data-input="tag-pixad_model_thumb" class="btn pix-image-upload pix-btn-icon"><i class="fa fa-picture-o"></i></button>
				<button type="button" class="btn pix-reset pix-btn-icon"><i class="fa fa-trash-o"></i></button>
				<?php if(isset($pixad_model_thumb_url) && $pixad_model_thumb_url){ ?><p class="pix-bg"> <img src="<?php echo esc_url($pixad_model_thumb_url) ?>" alt="<?php esc_attr_e('Thumbnail', 'pixad') ?>"> </p><?php } ?>
			</td>
		</tr>






		<?php
	}

	function pixad_model_custom_fields_add_form($tag) {
	?>
		<div class="form-field">
			<label for="tag-pixad_model_icon"><?php _e('Icon', 'pixad'); ?></label>
			<input type="text" name="pixad_model_icon" id="tag-pixad_model_icon" size="40" value="">
			<br />
			<p><?php _e('Icon class', 'pixad'); ?></p>
		</div>
		<div class="form-field">
			<label for="tag-pixad_model_thumb"><?php _e('Image', 'pixad'); ?></label>
			<input type="text" name="pixad_model_thumb" id="tag-pixad_model_thumb" value="">
			<button data-input="tag-pixad_model_thumb" class="btn pix-image-upload pix-btn-icon"><i class="fa fa-picture-o"></i></button>
			<button type="button" class="btn pix-reset pix-btn-icon"><i class="fa fa-trash-o"></i></button>
		</div>
	<?php
	}

	function pixad_model_custom_fields_save($term_id) {
		if (isset($_POST['pixad_model_thumb']) || isset($_POST['pixad_model_icon'])) {
			$cat_meta = get_option("auto_model_$term_id");
			if (isset($_POST['pixad_model_thumb'])) {
				update_option('pixad_model_thumb' . $term_id, $_POST['pixad_model_thumb']);
			}
			if (isset($_POST['pixad_model_icon'])) {
				$cat_meta['pixad_model_icon'] = $_POST['pixad_model_icon'];
			}

			//save the option array
			update_option("auto_model_$term_id", $cat_meta);
		}
	}
	

	
	add_action('admin_init', 'pixad_equipment_custom_fields', 1);
	function pixad_equipment_custom_fields()	{
		add_action( 'edited_auto-equipment', 'pixad_equipment_custom_fields_save' );
		add_action( 'auto-equipment_edit_form_fields', 'pixad_equipment_custom_fields_form' );
        add_action( 'auto-equipment_add_form_fields', 'pixad_equipment_custom_fields_add_form' );
        add_action( 'created_auto-equipment', 'pixad_equipment_custom_fields_save' );
	}

	function pixad_equipment_custom_fields_form($tag){
		$t_id = $tag->term_id;
		$equipment_icon = get_option("auto_equipment_icon_$t_id");
	?>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="tag-pixad_equipment_icon"><?php _e('Icon', 'pixad'); ?></label></th>
			<td>
				<input type="text" name="pixad_equipment_icon" id="tag-pixad_equipment_icon" size="25" style="width:60%;" value="<?php echo esc_attr($equipment_icon) ? esc_attr($equipment_icon) : ''; ?>">
				<button type="button" class="btn pix-reset pix-btn-icon"><i class="fa fa-trash-o"></i></button><br />
				<span class="description"><?php _e('Icon class', 'pixad'); ?></span>
			</td>
		</tr>
		<?php
	}

	function pixad_equipment_custom_fields_add_form($tag) {
	?>
		<div class="form-field">
			<label for="tag-pixad_equipment_icon"><?php _e('Icon', 'pixad'); ?></label>
			<input type="text" name="pixad_equipment_icon" id="tag-pixad_equipment_icon" size="40" value="">
			<br />
			<p><?php _e('Icon class', 'pixad'); ?></p>
		</div>
	<?php
	}

	function pixad_equipment_custom_fields_save($term_id) {
		if (isset($_POST['pixad_equipment_icon'])) {
			update_option("auto_equipment_icon_$term_id", $_POST['pixad_equipment_icon']);
		}
	}


}