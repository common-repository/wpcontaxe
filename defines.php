<?php

$WPCONTAXE_BANNER_OPTIMIZATION = array(
	1	=> 'kontextsensitiv, mit zufälliger Werbung auffüllen wenn nicht ausreichend relevante Anzeigen vorhanden sind',
	0	=> 'kontextsensitiv',
	2	=> 'nur zufällige Werbung'
);

$WPCONTAXE_BANNER_OPTIMIZATION_MAP = array(
	0	=> 0,
	1	=> 0,
	2	=> 0,
	3	=> 1,
	4	=> 2,
);

$WPCONTAXE_POSITIONS	= array(
	1	=> array(
		'title'		=> 'oben, zentriert',
		'type'		=> 'single',
		'align'		=> 'center',
		'valign'	=> 'top'
	),
	2	=> array(
		'title'		=> 'oben, rechts',
		'type'		=> 'single',
		'align'		=> 'right',
		'valign'	=> 'top'
	),
	3	=> array(
		'title'		=> 'oben, links',
		'type'		=> 'single',
		'align'		=> 'left',
		'valign'	=> 'top'
	),
	4	=> array(
		'title'		=> 'mitte, zentriert',
		'type'		=> 'single',
		'align'		=> 'center',
		'valign'	=> 'middle'
	),
	5	=> array(
		'title'		=> 'mitte, rechts',
		'type'		=> 'single',
		'align'		=> 'right',
		'valign'	=> 'middle'
	),
	6	=> array(
		'title'		=> 'mitte, links',
		'type'		=> 'single',
		'align'		=> 'left',
		'valign'	=> 'middle'
	),
	7	=> array(
		'title'		=> 'unten, zentriert',
		'type'		=> 'single',
		'align'		=> 'center',
		'valign'	=> 'bottom'
	),
	8	=> array(
		'title'		=> 'oben, zentriert',
		'type'		=> 'page',
		'align'		=> 'center',
		'valign'	=> 'top'
	),
	9	=> array(
		'title'		=> 'oben, rechts',
		'type'		=> 'page',
		'align'		=> 'right',
		'valign'	=> 'top'
	),
	10	=> array(
		'title'		=> 'oben, links',
		'type'		=> 'page',
		'align'		=> 'left',
		'valign'	=> 'top'
	),
	11	=> array(
		'title'		=> 'mitte, zentriert',
		'type'		=> 'page',
		'align'		=> 'center',
		'valign'	=> 'middle'
	),
	12	=> array(
		'title'		=> 'mitte, rechts',
		'type'		=> 'page',
		'align'		=> 'right',
		'valign'	=> 'middle'
	),
	13	=> array(
		'title'		=> 'mitte, links',
		'type'		=> 'page',
		'align'		=> 'left',
		'valign'	=> 'middle'
	),
	14	=> array(
		'title'		=> 'unten, zentriert',
		'type'		=> 'page',
		'align'		=> 'center',
		'valign'	=> 'bottom'
	),
	15	=> array(
		'title'		=> 'oben, zentriert',
		'type'		=> 'multiple',
		'align'		=> 'center',
		'valign'	=> 'top'
	),
	16	=> array(
		'title'		=> 'oben, rechts',
		'type'		=> 'multiple',
		'align'		=> 'right',
		'valign'	=> 'top'
	),
	17	=> array(
		'title'		=> 'oben, links',
		'type'		=> 'multiple',
		'align'		=> 'left',
		'valign'	=> 'top'
	),
	18	=> array(
		'title'		=> 'mitte, zentriert',
		'type'		=> 'multiple',
		'align'		=> 'center',
		'valign'	=> 'middle'
	),
	19	=> array(
		'title'		=> 'mitte, rechts',
		'type'		=> 'multiple',
		'align'		=> 'right',
		'valign'	=> 'middle'
	),
	20	=> array(
		'title'		=> 'mitte, links',
		'type'		=> 'multiple',
		'align'		=> 'left',
		'valign'	=> 'middle'
	),
	21	=> array(
		'title'		=> 'unten, zentriert',
		'type'		=> 'multiple',
		'align'		=> 'center',
		'valign'	=> 'bottom'
	),
);

$WPCONTAXE_POSITION_TYPES = array(
		'single'	=> array(
			'title'	=> 'Beitrag',
			'desc'	=> ''
		),
		'page'		=> array(
			'title'	=> 'Seite',
			'desc'	=> ''
		),
		'multiple'	=> array(
			'title'	=> 'Startseite/Kategorien/Archiv',
			'desc'	=> ''
		)
);

$WPCONTAXE_RULES = array(
	'fromsearchengine',
	'regularvisitor',
	'date',
	'home',
	'loggedin',
	'olderthan',
	'postdate',
	'wordcount',
	'fallback',
	'any',
);

$WPCONTAXE_ADDIMENSIONS = array(
	1	=> array(
		'title'		=>	'Fullbanner (468x60)',
		'desc'		=>	'Fullbanner',
		'width'		=>	'468',
		'height'	=>	'60',
		'txt'		=>	1,
		'imgtxt'	=>	1,
		'img'		=>	1,
		'flash'		=>	1
	),
	2	=> array(
		'title'		=>	'Halfbanner (234x60)',
		'desc'		=>	'Halfbanner',
		'width'		=>	'234',
		'height'	=>	'60',
		'txt'		=>	1,
		'imgtxt'	=>	0,
		'img'		=>	1,
		'flash'		=>	1
	),
	3	=> array(
		'title'		=>	'Vertical Banner (120x240)',
		'desc'		=>	'Vertical Banner',
		'width'		=>	'120',
		'height'	=>	'240',
		'txt'		=>	1,
		'imgtxt'	=>	1,
		'img'		=>	1,
		'flash'		=>	1
	),
	4	=> array(
		'title'		=>	'Leaderboard (728x90)',
		'desc'		=>	'Leaderboard',
		'width'		=>	'728',
		'height'	=>	'90',
		'txt'		=>	1,
		'imgtxt'	=>	1,
		'img'		=>	1,
		'flash'		=>	1
	),
	5	=> array(
		'title'		=>	'Skyscraper (120x600)',
		'desc'		=>	'Skyscraper',
		'width'		=>	'120',
		'height'	=>	'600',
		'txt'		=>	1,
		'imgtxt'	=>	1,
		'img'		=>	1,
		'flash'		=>	1
	),
	6	=> array(
		'title'		=>	'Wide Skyscraper (160x600)',
		'desc'		=>	'Wide Skyscraper',
		'width'		=>	'160',
		'height'	=>	'600',
		'txt'		=>	1,
		'imgtxt'	=>	1,
		'img'		=>	1,
		'flash'		=>	1
	),
	7	=> array(
		'title'		=>	'Half Wide Skyscraper (160x300)',
		'desc'		=>	'Half Wide Skyscraper',
		'width'		=>	'160',
		'height'	=>	'300',
		'txt'		=>	1,
		'imgtxt'	=>	1,
		'img'		=>	1,
		'flash'		=>	1
	),
	8	=> array(
		'title'		=>	'Rectangle (180x150)',
		'desc'		=>	'Rectangle',
		'width'		=>	'180',
		'height'	=>	'150',
		'txt'		=>	1,
		'imgtxt'	=>	1,
		'img'		=>	1,
		'flash'		=>	1
	),
	9	=> array(
		'title'		=>	'Vertical Rectangle (240x400)',
		'desc'		=>	'Vertical Rectangle',
		'width'		=>	'240',
		'height'	=>	'400',
		'txt'		=>	1,
		'imgtxt'	=>	1,
		'img'		=>	1,
		'flash'		=>	1
	),
	10	=> array(
		'title'		=>	'Medium Rectangle (300x250)',
		'desc'		=>	'Medium Rectangle',
		'width'		=>	'300',
		'height'	=>	'250',
		'txt'		=>	1,
		'imgtxt'	=>	1,
		'img'		=>	1,
		'flash'		=>	1
	),
	11	=> array(
		'title'		=>	'Large Rectangle (336x280)',
		'desc'		=>	'Large Rectangle',
		'width'		=>	'336',
		'height'	=>	'280',
		'txt'		=>	1,
		'imgtxt'	=>	1,
		'img'		=>	1,
		'flash'		=>	1
	),
	12	=> array(
		'title'		=>	'Button 1 (120x90)',
		'desc'		=>	'Button 1',
		'width'		=>	'120',
		'height'	=>	'90',
		'txt'		=>	0,
		'imgtxt'	=>	0,
		'img'		=>	1,
		'flash'		=>	1
	),
	13	=> array(
		'title'		=>	'Button 2 (120x60)',
		'desc'		=>	'Button 2',
		'width'		=>	'120',
		'height'	=>	'60',
		'txt'		=>	0,
		'imgtxt'	=>	0,
		'img'		=>	1,
		'flash'		=>	1
	),
	14	=> array(
		'title'		=>	'Micro Button (80x15)',
		'desc'		=>	'Micro Button',
		'width'		=>	'80',
		'height'	=>	'15',
		'txt'		=>	0,
		'imgtxt'	=>	0,
		'img'		=>	1,
		'flash'		=>	1
	),
	15	=> array(
		'title'		=>	'Micro Bar (88x31)',
		'desc'		=>	'Micro Bar',
		'width'		=>	'88',
		'height'	=>	'31',
		'txt'		=>	0,
		'imgtxt'	=>	0,
		'img'		=>	1,
		'flash'		=>	1
	)
);

$WPCONTAXE_FORMAT_MAP = array(
	1	=>	array('dimension'	=>	1,	'txt'	=>	0,	'imgtxt'	=>	0,	'img'	=>	1,	'flash'	=>	0),
	2	=>	array('dimension'	=>	4,	'txt'	=>	0,	'imgtxt'	=>	0,	'img'	=>	1,	'flash'	=>	0),
	3	=>	array('dimension'	=>	2,	'txt'	=>	0,	'imgtxt'	=>	0,	'img'	=>	1,	'flash'	=>	0),
	4	=>	array('dimension'	=>	3,	'txt'	=>	0,	'imgtxt'	=>	0,	'img'	=>	1,	'flash'	=>	0),
	5	=>	array('dimension'	=>	8,	'txt'	=>	0,	'imgtxt'	=>	0,	'img'	=>	1,	'flash'	=>	0),
	6	=>	array('dimension'	=>	10,	'txt'	=>	0,	'imgtxt'	=>	0,	'img'	=>	1,	'flash'	=>	0),
	7	=>	array('dimension'	=>	11,	'txt'	=>	0,	'imgtxt'	=>	0,	'img'	=>	1,	'flash'	=>	0),
	8	=>	array('dimension'	=>	9,	'txt'	=>	0,	'imgtxt'	=>	0,	'img'	=>	1,	'flash'	=>	0),
	9	=>	array('dimension'	=>	5,	'txt'	=>	0,	'imgtxt'	=>	0,	'img'	=>	1,	'flash'	=>	0),
	10	=>	array('dimension'	=>	6,	'txt'	=>	0,	'imgtxt'	=>	0,	'img'	=>	1,	'flash'	=>	0),
	11	=>	array('dimension'	=>	12,	'txt'	=>	0,	'imgtxt'	=>	0,	'img'	=>	1,	'flash'	=>	0),
	12	=>	array('dimension'	=>	13,	'txt'	=>	0,	'imgtxt'	=>	0,	'img'	=>	1,	'flash'	=>	0),
	13	=>	array('dimension'	=>	15,	'txt'	=>	0,	'imgtxt'	=>	0,	'img'	=>	1,	'flash'	=>	0),
	14	=>	array('dimension'	=>	14,	'txt'	=>	0,	'imgtxt'	=>	0,	'img'	=>	1,	'flash'	=>	0),
	16	=>	array('dimension'	=>	3,	'txt'	=>	1,	'imgtxt'	=>	0,	'img'	=>	0,	'flash'	=>	0),
	17	=>	array('dimension'	=>	6,	'txt'	=>	0,	'imgtxt'	=>	1,	'img'	=>	0,	'flash'	=>	0),
	18	=>	array('dimension'	=>	1,	'txt'	=>	1,	'imgtxt'	=>	0,	'img'	=>	0,	'flash'	=>	0),
	19	=>	array('dimension'	=>	1,	'txt'	=>	0,	'imgtxt'	=>	1,	'img'	=>	0,	'flash'	=>	0),
	21	=>	array('dimension'	=>	1,	'txt'	=>	0,	'imgtxt'	=>	0,	'img'	=>	0,	'flash'	=>	1),
	22	=>	array('dimension'	=>	4,	'txt'	=>	0,	'imgtxt'	=>	0,	'img'	=>	0,	'flash'	=>	1),
	23	=>	array('dimension'	=>	2,	'txt'	=>	0,	'imgtxt'	=>	0,	'img'	=>	0,	'flash'	=>	1),
	24	=>	array('dimension'	=>	3,	'txt'	=>	0,	'imgtxt'	=>	0,	'img'	=>	0,	'flash'	=>	1),
	25	=>	array('dimension'	=>	8,	'txt'	=>	0,	'imgtxt'	=>	0,	'img'	=>	0,	'flash'	=>	1),
	26	=>	array('dimension'	=>	10,	'txt'	=>	0,	'imgtxt'	=>	0,	'img'	=>	0,	'flash'	=>	1),
	27	=>	array('dimension'	=>	11,	'txt'	=>	0,	'imgtxt'	=>	0,	'img'	=>	0,	'flash'	=>	1),
	28	=>	array('dimension'	=>	9,	'txt'	=>	0,	'imgtxt'	=>	0,	'img'	=>	0,	'flash'	=>	1),
	29	=>	array('dimension'	=>	5,	'txt'	=>	0,	'imgtxt'	=>	0,	'img'	=>	0,	'flash'	=>	1),
	30	=>	array('dimension'	=>	6,	'txt'	=>	0,	'imgtxt'	=>	0,	'img'	=>	0,	'flash'	=>	1),
	31	=>	array('dimension'	=>	4,	'txt'	=>	1,	'imgtxt'	=>	0,	'img'	=>	0,	'flash'	=>	0),
	32	=>	array('dimension'	=>	8,	'txt'	=>	1,	'imgtxt'	=>	0,	'img'	=>	0,	'flash'	=>	0),
	33	=>	array('dimension'	=>	2,	'txt'	=>	1,	'imgtxt'	=>	0,	'img'	=>	0,	'flash'	=>	0),
	34	=>	array('dimension'	=>	10,	'txt'	=>	1,	'imgtxt'	=>	0,	'img'	=>	0,	'flash'	=>	0),
	35	=>	array('dimension'	=>	11,	'txt'	=>	1,	'imgtxt'	=>	0,	'img'	=>	0,	'flash'	=>	0),
	36	=>	array('dimension'	=>	5,	'txt'	=>	1,	'imgtxt'	=>	0,	'img'	=>	0,	'flash'	=>	0),
	37	=>	array('dimension'	=>	6,	'txt'	=>	1,	'imgtxt'	=>	0,	'img'	=>	0,	'flash'	=>	0),
	38	=>	array('dimension'	=>	9,	'txt'	=>	1,	'imgtxt'	=>	0,	'img'	=>	0,	'flash'	=>	0),
	39	=>	array('dimension'	=>	4,	'txt'	=>	0,	'imgtxt'	=>	1,	'img'	=>	0,	'flash'	=>	0),
	41	=>	array('dimension'	=>	3,	'txt'	=>	0,	'imgtxt'	=>	1,	'img'	=>	0,	'flash'	=>	0),
	42	=>	array('dimension'	=>	8,	'txt'	=>	0,	'imgtxt'	=>	1,	'img'	=>	0,	'flash'	=>	0),
	43	=>	array('dimension'	=>	10,	'txt'	=>	0,	'imgtxt'	=>	1,	'img'	=>	0,	'flash'	=>	0),
	44	=>	array('dimension'	=>	11,	'txt'	=>	0,	'imgtxt'	=>	1,	'img'	=>	0,	'flash'	=>	0),
	45	=>	array('dimension'	=>	5,	'txt'	=>	0,	'imgtxt'	=>	1,	'img'	=>	0,	'flash'	=>	0),
	46	=>	array('dimension'	=>	9,	'txt'	=>	0,	'imgtxt'	=>	1,	'img'	=>	0,	'flash'	=>	0),
	49	=>	array('dimension'	=>	9,	'txt'	=>	1,	'imgtxt'	=>	0,	'img'	=>	0,	'flash'	=>	0),
	50	=>	array('dimension'	=>	10,	'txt'	=>	1,	'imgtxt'	=>	0,	'img'	=>	0,	'flash'	=>	0),
	51	=>	array('dimension'	=>	11,	'txt'	=>	1,	'imgtxt'	=>	0,	'img'	=>	0,	'flash'	=>	0),
	52	=>	array('dimension'	=>	7,	'txt'	=>	1,	'imgtxt'	=>	0,	'img'	=>	0,	'flash'	=>	0),
	53	=>	array('dimension'	=>	7,	'txt'	=>	0,	'imgtxt'	=>	1,	'img'	=>	0,	'flash'	=>	0),
);

?>
