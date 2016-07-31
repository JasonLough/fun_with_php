<?php

	include 'turn-err-reporting-on.php';
	//goals :
	//cement the OOP of PHP in
	//session bs



	class Organ {

		public $name = '';
		public $purpose = '';

		public function __construct($details) {
			$this->name = isset($details->name) ? $details->name : 'err :name not set';
			$this->purpose = isset($details->purpose) ? $details->purpose : 'err :purpose not set';
		}


	}

	class Muscle extends Organ {

		public $state = '';

		public function flex() {
			if($this->state === 'flexed')
				return 'already flexed';
			else
				$this->state = 'flexed';
		}

		public function relax() {
			if($this->state === 'relax')
				return 'already relaxed';
			else
				$this->state = 'relaxed';
		}	

	}

	class Bone extends Organ {
		public $muscles = [];

		public function __construct($details) {

		}

	}
	
	class Heart extends Organ {
		public $state = 'beating';
		private $bpm = 50;

		public function beats($set) {
			if( isset($set) )
				$this->bpm = $set;
			else 
				return $this->bpm;

		}
	}

	class Liver extends Organ {
		public $state = 'filtering blood';

	}

	//top level stuff like an arm, head, torso
	class Bodypart {

		private $name = '';
		private $bones = [];
		private $muscles = [];
		private $side = ''; //left, right, center
		private $position = ''; //top, middle, bottom

		public function __construct($details) {
			show($details);
			$this->bones = $details['bones'];
			$this->muscles = $details['muscles'];
			$this->name = $details['name'];
			$this->side = $details['side'];
			$this->position = $details['position'];
		}

		public function get_details() {
			return "name : {$this->name}<br>" .
			"bones : {$this->bones}<br>" .
			"muscles : {$this->muscles}<br>" .
			"side : {$this->side}<br>" .
			"position : {$this->position}<br>";
		}
	}

	class Leg extends Bodypart {

		public function construct($details) {

			parent::__construct($details);
		}

	}

	class Arm extends Bodypart {
		public function __construct($details) {
			
			//show($details);
			parent::__construct($details);
		}
		
	}

	class Torso extends Bodypart {
		public $organs;

		public function __construct() {
			$this->organs = array();
			$heart = new Heart();
			$liver = new Liver();
			array_push( $this->organs, ['heart'=>$heart, 'liver'=>$liver] );
		}
	}

	class Head extends Bodypart {
		public function __construct($details) {
			
		}		
	}

	class Body {

		public $l_arm;
		public $r_arm;
		public $head;
		public $torso;
		public $l_leg;
		public $r_leg;
		

		public function __construct($details) {
			
			$this->l_arm = new Arm($details['arm']);
			$this->r_arm = new Arm($details->arm);
			$this->torso = new Torso($details->torso);
			$this->head = new Head($details->head);
			$this->l_leg = new Leg($details->leg);
			$this->r_leg = new Leg($details->leg);			
		}

	}

	$arm = ['name'=>'arm',
			'position'=>'top',
			'side'=>'',
			'bones'=> 
				['humerus', 
		         'radius', 
		         'ulna', 
		         'handbones'
		        ],
		     'muscles'=>
		     	['bicep', 
		     	 'tricep',
		     	 'forearm',
		     	 'shoulder'
		     	]
		    ];



	$defaults = [
		'arm' => $arm,
		'torso' => ['clavicle', 
		            'sternum', 
		            'ribs', 
		            'spine', 
		            'coxal'
		            ],
		'head' => ['skull', 
		           'mandible'],
		'leg' => ['femur', 
		            'patella', 
		            'fibula', 
		            'tibia', 
		            'footbones']
	];

		
	$person1 = new Body($defaults);

	function show($part) {
		echo '<pre>';
		echo var_dump($part);
		echo '</pre>';	
	}

	//$person1->torso->organs[0]['heart']
	show($person1->torso->organs[0]['heart']);
	show($person1->l_arm->get_details());
		// echo $person1->organs['heart']->beats();
		// $person1->organs['heart']->beats(128);
		// echo $person1->organs['heart']->beats();

?>

