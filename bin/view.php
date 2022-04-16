<?php
//the following classes handle displaying student info and bio
class View {
	public static function show_pic($src, $alt, $id = false, $class = false) {
		return '<img src='.$src.' alt='.$alt.' id='.$id.' class='.$class.' />';
	}
	public static function back_to_homepage() {
		echo '<p><a href=\'./index.php\'>BACK TO HOME PAGE</a></p>';
	}
}
class Display_Student_Bio {//instantiated in student_bio.php
	private $result_set;
	private $type;
	public function __construct($array, $type) {
		$this->result_set = $array;
		$this->type = $type;
	}
	public function create_view() {
		if ($this->type == 'student') {
			$first_name = $this->result_set['student_first_name'];
			$last_name = $this->result_set['student_last_name'];
			$username = $this->result_set['student_username'];
			$class = $this->result_set['student_class'];
			$parent_name = $this->result_set['parent_name'];
			$parent_phone = $this->result_set['parent_phone_number'];
			$parent_email = $this->result_set['parent_email'];
			$student_dob = $this->result_set['student_dob'];
			$student_address = $this->result_set['student_address'];
			$student_storg = $this->result_set['student_storg'];
			$student_gender = $this->result_set['student_gender'];
			$student_religion = $this->result_set['student_religion'];
			$passport_src = $this->result_set['student_passport'];
			echo View::show_pic($passport_src, $first_name);
			echo '<div>';
			echo '<span><b>STUDENT\'S BASIC INFO</b></span>';
			echo '<p><b>STUDENT\'S FIRST NAME:</b> '.$first_name.'.</p>';
			echo '<p><b>STUDENT\'S LAST NAME:</b> '.$last_name.'.</p>';
			echo '<p><b>STUDENT\'S USERNAME:</b> '.$username.'.</p>';
			echo '<p><b>STUDENT\'S CLASS:</b> '.$class.'.</p>';
			echo '<p><b>STUDENT\'S GENDER:</b> '.$student_gender.'.</p>';
			echo '</div>';
			echo '<div>';
			echo '<span><b>STUDENT\'S BIO</b></span>';
			echo '<p><b>PARENT\'S NAME:</b> '.$parent_name.'.</p>';
			echo '<p><b>PARENT\'S PHONE NUMBER:</b> '.$parent_phone.'.</p>';
			echo '<p><b>PARENT\'S EMAIL ADDRESS:</b> '.$parent_email.'.</p>';
			echo '<p><b>STUDENT\'S DATE OF BIRTH:</b> '.$student_dob.'.</p>';
			echo '<p><b>STUDENT\'S ADDRESS OF RESIDENCE:</b> '.$student_address.'.</p>';
			echo '<p><b>STUDENT\'S STATE OF ORIGIN:</b> '.$student_storg.'.</p>';
			echo '<p><b>STUDENT\'S RELIGION:</b> '.$student_religion.'.</p>';
			View::back_to_homepage();
			echo '</div>';
		} else if ($this->type == 'staff') {
			$first_name = $this->result_set['staff_first_name'];
			$last_name = $this->result_set['staff_last_name'];
			$username = $this->result_set['staff_username'];
			$role = $this->result_set['staff_role'];
			$staff_phone = $this->result_set['staff_phone_number'];
			$staff_email = $this->result_set['staff_email'];
			$staff_dob = $this->result_set['staff_dob'];
			$nok_name = $this->result_set['nok_name'];
			$nok_phone = $this->result_set['nok_phone_number'];
			$staff_address = $this->result_set['staff_address'];
			$staff_storg = $this->result_set['staff_storg'];
			$staff_gender = $this->result_set['staff_gender'];
			$staff_religion = $this->result_set['staff_religion'];
			$passport_src = $this->result_set['staff_passport'];
			echo View::show_pic($passport_src, $first_name);
			echo '<div>';
			echo '<span><b>STAFF\'S BASIC INFO</b></span>';
			echo '<p><b>STAFF\'S FIRST NAME:</b> '.$first_name.'.</p>';
			echo '<p><b>STAFF\'S LAST NAME:</b> '.$last_name.'.</p>';
			echo '<p><b>STAFF\'S USERNAME:</b> '.$username.'.</p>';
			echo '<p><b>STAFF\'S ROLE:</b> '.$role.'.</p>';
			echo '<p><b>STAFF\'S GENDER:</b> '.$staff_gender.'.</p>';
			echo '</div>';
			echo '<div>';
			echo '<span><b>STAFF\'S BIO</b></span>';
			echo '<p><b>STAFF\'S PHONE NUMBER:</b> '.$staff_phone.'.</p>';
			echo '<p><b>STAFF\'S EMAIL:</b> '.$staff_email.'.</p>';
			echo '<p><b>STAFF\'S DATE OF BIRTH:</b> '.$staff_dob.'.</p>';
			echo '<p><b>NEX OF KIN\'S NAME:</b> '.$nok_name.'.</p>';
			echo '<p><b>NEXT OF KIN\'S PHONE:</b> '.$nok_phone.'.</p>';
			echo '<p><b>STAFF\'S ADDRESS:</b> '.$staff_address.'.</p>';
			echo '<p><b>STAFF\'S STATE OF ORIGIN:</b> '.$staff_storg.'.</p>';
			echo '<p><b>STAFF\'S RELIGION:</b> '.$staff_religion.'.</p>';
			View::back_to_homepage();
			echo '</div>';
		}
	}
}
class Display_St {//instantiated in students_regx.php
	private $result;
	private $type;
	public function __construct($array, $type) {
		$this->result = $array;
		$this->type = $type;
	}
	public function display() {
		if ($this->type == 'student') {
			$first_name = $this->result[0]['student_first_name'];
			$last_name = $this->result[0]['student_last_name'];
			$username = $this->result[0]['student_username'];
			$class = $this->result[0]['student_class'];
			$passport_src = $this->result[0]['student_passport'];
			echo View::show_pic($passport_src, $first_name);
			echo '<div>';
			echo '<span><b>STUDENT\'S BASIC INFO</b></span>';
			echo '<p><b>STUDENT\'S FIRST NAME:</b> '.$first_name.'.</p>';
			echo '<p><b>STUDENT\'S LAST NAME:</b> '.$last_name.'.</p>';
			echo '<p><b>STUDENT\'S USERNAME:</b> '.$username.'.</p>';
			echo '<p><b>STUDENT\'S CLASS:</b> '.$class.'.</p>';
			echo '</div>';
			echo '</div>';
		} else if ($this->type == 'staff') {
			$first_name = $this->result[0]['staff_first_name'];
			$last_name = $this->result[0]['staff_last_name'];
			$username = $this->result[0]['staff_username'];
			$class = $this->result[0]['staff_class'];
			$passport_src = $this->result[0]['staff_passport'];
			echo View::show_pic($passport_src, $first_name);
			echo '<div>';
			echo '<span><b>STAFF\'S BASIC INFO</b></span>';
			echo '<p><b>STAFF\'S FIRST NAME:</b> '.$first_name.'.</p>';
			echo '<p><b>STAFF\'S LAST NAME:</b> '.$last_name.'.</p>';
			echo '<p><b>STAFF\'S USERNAME:</b> '.$username.'.</p>';
			echo '<p><b>STAFF\'S CLASS:</b> '.$class.'.</p>';
			echo '</div>';
			echo '</div>';
		}
	}
}
class Display_All_St {//instantiated in allstudents.php and allstaffs.php and search_st.php
	private $result_set;
	private $type;
	public function __construct($array, $type) {
		$this->result_set = $array;
		$this->type = $type;
	}
	public function create_view() {
		if (sizeof($this->result_set) == 0) {
			echo '<h1>DATA DOES NOT EXIST!</h1>';
			View::back_to_homepage();
			die();
		}
		if ($this->type == 'student') {
			echo '<table id=\'\'>';
			echo '<tr>';
			echo '<th>STUDENT\'S PICTURE</th>';
			echo '<th>STUDENT\'S NAME</th>';
			echo '<th>STUDENT\'S USERNAME</th>';
			echo '<th>STUDENT\'S CLASS</th>';
			echo '<th>VIEW BIO</th>';
			echo '<th>EDIT STUDENT</th>';
			echo '</tr>';
			foreach ($this->result_set as $student) {
				echo '<tr>';
				echo '<td>'.View::show_pic($student['student_passport'], $student['student_first_name']).'</td>';
				echo '<td>'.$student['student_first_name'].' '.$student['student_last_name'].'</td>';
				echo '<td>'.$student['student_username'].'</td>';
				echo '<td>'.$student['student_class'].'</td>';
				echo '<td><a href=\'./student_bio.php?id='.$student['student_id'].'\'>VIEW BIO</a></td>';
				echo '<td><a href=\'./addstudent.php?id='.$student['student_id'].'\'>EDIT INFO</a></td>';
				echo '</tr>';
			}
			echo '</table>';
			View::back_to_homepage();
		} else if ($this->type == 'staff') {
			echo '<table id=\'\'>';
			echo '<tr>';
			echo '<th>STAFF\'S PICTURE</th>';
			echo '<th>STAFF\'S NAME</th>';
			echo '<th>STAFF\'S USERNAME</th>';
			echo '<th>STAFF\'S ROLE</th>';
			echo '<th>VIEW BIO</th>';
			echo '<th>EDIT STAFF</th>';
			echo '</tr>';
			foreach ($this->result_set as $staff) {
				echo '<tr>';
				echo '<td>'.View::show_pic($staff['staff_passport'], $staff['staff_first_name']).'</td>';
				echo '<td>'.$staff['staff_first_name'].' '.$staff['staff_last_name'].'</td>';
				echo '<td>'.$staff['staff_username'].'</td>';
				echo '<td>'.$staff['staff_role'].'</td>';
				echo '<td><a href=\'./staff_bio.php?id='.$staff['staff_id'].'\'>VIEW BIO</a></td>';
				echo '<td><a href=\'./addstaff.php?id='.$staff['staff_id'].'\'>EDIT INFO</a></td>';
				echo '</tr>';
			}
			echo '</table>';
			View::back_to_homepage();
		}
	}
}
class Proceed_Delete {//instantiated in delete_st.php
	private $type;
	private $input;
	private $list;
	public function __construct($type, $input, $list) {
		$this->type = $type;
		$this->input = $input;
		$this->list = $list;
	}
	public function proceed() {
		switch ($this->type) {
			case 'student':
				$fn = 'student_first_name';
				$ln = 'student_last_name';
				$cl = 'student_class';
				$type = 'STUDENT';
				$form = '<form method=\'post\' action=\'delete_st.php?type=nt\'>';
				break;
			case 'staff':
				$type = 'STAFF';
				$fn = 'staff_first_name';
				$ln = 'staff_last_name';
				$cl = 'staff_role';
				$form = '<form method=\'post\' action=\'delete_st.php?type=fa\'>';
				break;
		}
		$form .= '<p>ARE YOU SURE YOU WANT TO DELETE THE FOLLOWING '.$type.'(S)?</p>';
		if (strpos($this->input, ',')) {
			foreach ($this->list as $value) {
				$form .= '<p>'.$value[$fn].' '.$value[$ln].' IN '.$value[$cl].'</p>';
			}
		} else {
			$form .= '<p>'.$this->list[$fn].' '.$this->list[$ln].' IN '.$this->list[$cl].'</p>';
		}
		$form .= '<p><strong>BE INFORMED THAT ALL DATA PERTAINING TO THE LISTED '.strtoupper($this->type).'(S) WILL BE DELETED AND CANNOT BE REVERSED.</strong></p>';
		$form .= '<p><input type=\'hidden\' name=\'input\' value=\''.$this->input.'\' /></p>';
		$form .= '<p><input type=\'submit\' name=\'delete\' value=\'DELETE\' /></p>';
		$form .= '</form>';
		echo $form;
	}
}
class Proceed_Change_Term {
	private $input_session;
	private $input_term;
	private $current_session;
	private $current_term;
	public function __construct($in_sess, $in_term, $cur_sess, $cur_term) {
		$this->input_session = $in_sess;
		$this->input_term = $in_term;
		$this->current_session = $cur_sess;
		$this->current_term = $cur_term;
	}
	public function dec_proceed() {
		$form = '<form method=\'post\' action=\'set_sess.php\'>';
		if ($this->current_session == $this->input_session) {
			$form .= '<p><strong>ARE YOU SURE YOU WANT TO CHANGE THE CURRENT TERM ('.$this->current_term.') TO '.$this->input_term.'?</strong></p>';
		} else {
			$form .= '<p><strong>ARE YOU SURE YOU WANT TO CHANGE THE CURRENT SESSION AND TERM ('.$this->current_session.' '.$this->current_term.') TO '.$this->input_session.' '.$this->input_term.'?</strong></p>';
		}
		$form .= '<p>PLEASE INPUT YOUR PASSWORD: <input type=\'password\' name=\'set_sess_password\' value=\'\' /></p>';
		$form .= '<input type=\'hidden\' name=\'session\' value=\''.$this->input_session.'\' />';
		$form .= '<input type=\'hidden\' name=\'term\' value=\''.$this->input_term.'\' />';
		$form .= '<p><input type=\'submit\' name=\'set_sess\' value=\'CHANGE TERM\' /></p>';
		$form .= '</form>';
		return $form;
	}
}
class Read_Mails {
	private static $id;
	private static $type;
	private $username;
	private $mode;
	public function __construct($id, $type, $username) {
		self::$id = $id;
		if ($_GET['mode'] == 'nt') {
			$this->mode = 'sent';
		} else if ($_GET['mode'] == 'ed') {
			$this->mode = 'received';
		}
		self::$type = base64_decode($type);
		$this->username = base64_decode($username);
	}
	public function read_xml() {
		$file = '../bin/mails/'.self::$id.'.xml';
		$xml = simplexml_load_file($file);
		$receivers = array();
		$appendages = array();
		if ($xml->sender == $this->username) {
			$sender = 'YOU';
		} else {
			$sender = $xml->sender;
		}
		foreach ($xml->receipients->children() as $name) {
			$receivers[] = $name;
		}
		$date = $xml->date;
		$title = $xml->title;
		$message = $xml->message;
		if ($xml->appendages) {
			foreach ($xml->appendages->children() as $appendage) {
				$appendages[] = $appendage;
			}
		}
		echo '<div>';
		echo '<p><b>FROM:</b> '.$sender.'.</p><br>';
		echo '<p><b>TO:</b> ';
		if ($this->mode == 'sent') {
			for ($i = 0; $i < sizeof($receivers); $i++) {
				if ($i == 2) {
					echo 'and others...';
					break;
				} else {
					if ($i == (sizeof($receivers) - 1)) {
						echo $receivers[$i].'.';
					} else {
						echo $receivers[$i].', ';
					}
				}
			}
		} else if ($this->mode == 'received') {
			if (sizeof($receivers) > 1) {
				echo 'YOU AND OTHERS.';
			} else {
				echo 'YOU.';
			}
		}
		echo '</p><br>';
		echo '<p><b>DATE: </b> '.$date.'.</p><br>';
		echo '<p><b>TITLE OF MAIL: </b> '.$title.'</p><br>';
		echo '<p><b>MESSAGE: </b> '.$message.'</p><br>';
		if ($appendages) {
			echo '<p><b>APPENDAGES: </b>';
			foreach ($appendages as $appendage) {
				if ($appendage['type'] == 'png' || $appendage['type'] == 'jpeg' || $appendage['type'] == 'gif') {
					$link= 'DOWNLOAD IMAGE';
				} else if ($appendage['type'] == 'mp3') {
					$link= 'DOWNLOAD AUDIO';
				} else if ($appendage['type'] == 'mp4' || $appendage['type'] == 'mkv') {
					$link= 'DOWNLOAD VIDEO';
				} else {
					$link= 'DOWNLOAD FILE';
				}
				echo '<span><a href=\'./download_appendage.php?id='.$appendage.'&type='.$appendage['type'].'\'>'.$link.'</a></span> ';
			}
			echo '</p>';
		}
		echo '</div>';
	}
}
class Dec_Students_Reg {
	private $students;
	public function __construct($studs) {
		$this->students = $studs;
	}
	public function dec_form() {
		echo '<table>';
		echo '<tr><th>S/N</th><th>CLASS STUDENTS</th><th>REGISTER</th></tr>';
		$index = 1;
		foreach ($this->students as $student) {
			echo '<tr>';
			echo '<td>'.$index.'</td>';
			echo '<td>'.$student['student']['student_first_name'].' '.$student['student']['student_last_name'].'</td>';
			if ($student['status'] == 'no_reg') {
				echo '<td><a href=\'./students_regx.php?id='.base64_encode($student['student']['student_id']).'&cl='.base64_encode($student['student']['student_class']).'\'>register...</a></td>';
			} else {
				echo '<td>REGISTERED</td>';
			}
			echo '</tr>';
			$index++;
		}
		echo '</table>';
	}
}
class Dec_Registration {
	private $subjects;
	private $student_id;
	private $student_class;
	private $session;
	public function __construct($id, $class, $sess, $subs) {
		$this->student_id = $id;
		$this->student_class = $class;
		$this->session = $sess['session'];
		$this->subjects = $subs;
	}
	public function dec_form() {
		echo '<form method=\'post\' action=\'./registration.php\'>';
		echo '<table>';
		echo '<tr><th>S/N</th><th>SUBJECT</th><th>TICK</th><th>SUBJECT TEACHER</th><tr>';
		$index = 1;
		foreach ($this->subjects as $subject) {
			echo '<tr>';
			echo '<td>'.$index.'</td>';
			echo '<td>'.strtoupper($subject['subject']).'</td>';
			echo '<td><input type=\'checkbox\' name=\'subjects[]\' value=\''.$subject['subject'].'\' /></td>';
			echo '<td>'.$subject['teacher_name'].'</td>';
			echo '</tr>';
			$index++;
		}
		echo '<input type=\'hidden\' name=\'student_id\' value=\''.$this->student_id.'\' />';
		echo '<input type=\'hidden\' name=\'student_class\' value=\''.$this->student_class.'\' />';
		echo '<input type=\'hidden\' name=\'session\' value=\''.$this->session.'\' />';
		echo '<tr><td colspan=\'4\'><input type=\'submit\' name=\'reg_sub\' value=\'REGISTER STUDENT\' /></td></tr>';
		echo '</table>';
		echo '</form>';
	}
}
class Dec_Input_Results {
	private $students;
	private $subject;
	private $class;
	private $session;
	private $term;
	private $result_type;
	public function __construct($studs, $subject, $class, $sess, $term, $type) {
		$this->students = $studs;
		$this->subject = $subject;
		$this->class = $class;
		$this->session = $sess;
		$this->term = $term;
		$this->result_type = $type;
	}
	public function dec_form() {
		if ($this->result_type == '1ST C.A. TEST' || $this->result_type == '2ND C.A. TEST') {
			$obtainable = 15;
		} else if ($this->result_type == 'ASSIGNMENT') {
			$obtainable = 10;
		} else if ($this->result_type == 'EXAMINATION') {
			$obtainable = 60;
		}
		echo '<p>SUBJECT: '.$this->subject.'</p>';
		echo '<p>CLASS: '.$this->class.'</p>';
		echo '<p>SESSION: '.$this->session.'</p>';
		echo '<p>TERM: '.$this->term.'</p>';
		echo '<p>RESULT TYPE: '.$this->result_type.'</p>';
		echo '<form method=\'post\' action=\'./addresultsx.php\'>';
		echo '<table>';
		echo '<tr><th>S/N</th><th>STUDENT\'S NAME</th><th>SCORE OBTAINED</th><th>SCORE OBTAINABLE</th></tr>';
		for ($i = 0; $i < sizeof($this->students); $i++) {
			echo '<tr>';
			echo '<td>'.($i + 1).'</td>';
			foreach ($this->students[$i] as $key => $value) {
				if ($key == 'name') {
					echo '<td>'.$value.'</td>';
				} else if ($key == 'student_id') {
					echo '<td><input type=\'hidden\' name=\'id[]\' value=\''.$value.'\' />';
				} else {
					echo '<input type=\'text\' name=\'score[]\' value=\''.$value.'\' /></td>';
				}
			}
			echo '<td>'.$obtainable.'</td>';
			echo '</tr>';
		}
		echo '<input type=\'hidden\' name=\'subject\' value=\''.$this->subject.'\' />';
		echo '<input type=\'hidden\' name=\'class\' value=\''.$this->class.'\' />';
		echo '<input type=\'hidden\' name=\'session\' value=\''.$this->session.'\' />';
		echo '<input type=\'hidden\' name=\'term\' value=\''.$this->term.'\' />';
		echo '<input type=\'hidden\' name=\'res_type\' value=\''.$this->result_type.'\' />';
		echo '<tr><td colspan=\'4\'><input type=\'submit\' name=\'add_results_sub\' value=\'ADD RESULTS\' /></td></tr>';
		echo '</table>';
		echo '</form>';
	}
}
class Show_Spreadsheet {
	private $results;
	private $subject;
	private $class;
	private $session;
	private $term;
	private $result_type;
	public function __construct($res, $subject, $class, $sess, $term, $type) {
		$this->results = $res;
		$this->subject = $subject;
		$this->class = $class;
		$this->session = $sess;
		$this->term = $term;
		$this->result_type = $type;
	}
	public function show() {
		function total($array) {
			$total = 0;
			foreach($array as $score) {
				$total = $total + $score;
			}
			return $total;
		}
		function get_grade($score) {
			if ($score >= 70) {
				$grade = 'A';
			} else if ($score >= 60 && $score < 70) {
				$grade = 'B';
			} else if ($score >= 50 && $score < 60) {
				$grade = 'C';
			} else if ($score >= 45 && $score < 50) {
				$grade = 'D';
			} else if ($score >= 40 && $score < 45) {
				$grade = 'E';
			} else if ($score < 40) {
				$grade = 'F';
			} else {
				$grade = '-';
			}
			return $grade;
		}
		echo '<p>SUBJECT: '.strtoupper($this->subject).'</p>';
		echo '<p>CLASS: '.$this->class.'</p>';
		echo '<p>SESSION: '.$this->session.'</p>';
		echo '<p>TERM: '.$this->term.'</p>';
		echo '<table>';
		echo '<tr><th rowspan=\'2\'>S/N</th><th rowspan=\'2\'>STUDENT\'S NAME</th><th colspan=\'2\'>1ST C.A. TEST</th><th colspan=\'2\'>2ND C.A. TEST</th><th colspan=\'2\'>ASSIGNMENT</th><th colspan=\'2\'>EXAMINATION</th><th colspan=\'2\'>TOTAL</th><th rowspan=\'2\'>GRADE</th></tr>';
		echo '<tr>';
		for ($i = 0; $i < 5; $i++) { 
			echo '<th>SCORE OBTAINED</th>';
			echo '<th>SCORE OBTAINABLE</th>';
		}
		echo '</tr>';
		$index = 1;
		foreach ($this->results as $result) {
			$scores = array();
			echo '<tr>';
			echo '<td>'.$index.'</td>';
			foreach ($result as $key => $value) {
				if ($key == 'name') {
					echo '<td>'.$value.'</td>';
				} else if ($key != 'student_id') {
					if (preg_match('/ca/i', $key)) {
						$obtainable = 15;
					} else if (preg_match('/ass/i', $key)) {
						$obtainable = 10;
					} else if (preg_match('/exam/i', $key)) {
						$obtainable = 60;
					}
					$scores[] = $value;
					echo $value != null ? '<td>'.$value.'</td>' : '<td>-</td>';
					echo '<td>'.$obtainable.'</td>';
				}
			}
			$total = total($scores);
			echo '<td>'.$total.'</td>';
			echo '<td>100</td>';
			echo '<td>'.get_grade($total).'</td>';
			echo '</tr>';
			$index++;
		}
		echo '</table>';
		echo View::back_to_homepage();
	}
}
class Show_Student_Result {
	private $results;
	private $attendance;
	private $comments;
	private $name;
	private $class;
	private $session;
	private $term;
	private $passport;
	public function __construct($res, $attend, $comms, $name, $class, $sess, $term, $passport) {
		$this->results = $res;
		$this->attendance = $attend;
		$this->comments = $comms;
		$this->name = $name;
		$this->class = $class;
		$this->session = $sess;
		$this->term = $term;
		$this->passport = $passport;
	}
	public function show() {
		$subjects_scores = array();
		function total($array) {
			$total = 0;
			foreach($array as $score) {
				$total = $total + $score;
			}
			return $total;
		}
		function get_grade($score) {
			if ($score >= 70) {
				$grade = 'A';
			} else if ($score >= 60 && $score < 70) {
				$grade = 'B';
			} else if ($score >= 50 && $score < 60) {
				$grade = 'C';
			} else if ($score >= 45 && $score < 50) {
				$grade = 'D';
			} else if ($score >= 40 && $score < 45) {
				$grade = 'E';
			} else if ($score < 40) {
				$grade = 'F';
			} else {
				$grade = '-';
			}
			return $grade;
		}
		function total_obtained($score_array) {
			$obtained = 0;
			foreach ($score_array as $score) {
				$obtained = $obtained + $score;
			}
			return $obtained;
		}
		function get_term_percentage($score_array, $no_subjects) {
			$obtained = total_obtained($score_array);
			$obtainable = 100 * $no_subjects;
			$perc = ($obtained / $obtainable) * 100;
			return $perc;
		}
		echo '<p>'.View::show_pic($this->passport, strtolower($this->name)).'</p>';
		echo '<p>STUDENT\'S NAME: '.strtoupper($this->name).'</p>';
		echo '<p>CLASS: '.$this->class.'</p>';
		echo '<p>SESSION: '.$this->session.'</p>';
		echo '<p>TERM: '.$this->term.'</p>';
		echo '<table>';
		echo '<tr><th rowspan=\'2\'>S/N</th><th rowspan=\'2\'>SUBJECT</th><th colspan=\'2\'>1ST C.A. TEST</th><th colspan=\'2\'>2ND C.A. TEST</th><th colspan=\'2\'>ASSIGNMENT</th><th colspan=\'2\'>EXAMINATION</th><th colspan=\'2\'>TOTAL</th><th rowspan=\'2\'>GRADE</th></tr>';
		echo '<tr>';
		for ($i = 0; $i < 5; $i++) { 
			echo '<th>SCORE OBTAINED</th>';
			echo '<th>SCORE OBTAINABLE</th>';
		}
		echo '</tr>';
		if ($this->results) {
			$index = 1;
			foreach ($this->results as $result) {
				$scores = array();
				echo '<tr>';
				echo '<td>'.$index.'</td>';
				foreach ($result as $key => $value) {
					if ($key == 'subject') {
						echo '<td>'.strtoupper($value).'</td>';
					} else {
						if (preg_match('/ca/i', $key)) {
							$obtainable = 15;
						} else if (preg_match('/ass/i', $key)) {
							$obtainable = 10;
						} else if (preg_match('/exam/i', $key)) {
							$obtainable = 60;
						}
						$scores[] = $value;
						echo $value != null ? '<td>'.$value.'</td>' : '<td>-</td>';
						echo '<td>'.$obtainable.'</td>';
					}
				}
				$total = total($scores);
				$subjects_scores[] = $total;
				echo '<td>'.$total.'</td>';
				echo '<td>100</td>';
				echo '<td>'.get_grade($total).'</td>';
				echo '</tr>';
				$index++;
			}
			echo '</table>';
			echo '<div>';
			$total_score_obtained = total_obtained($subjects_scores);
			echo '<p>TOTAL SCORE OBTAINED: '.$total_score_obtained.'</p>';
			$total_score_obtained = sizeof($this->results) * 100;
			echo '<p>TOTAL SCORE OBTAINABLE: '.$total_score_obtained.'</p>';
			$percentage = get_term_percentage($subjects_scores, sizeof($this->results));
			echo '<p>TERM PERCENTAGE: '.$percentage.'%</p>';
			echo '<p>TOTAL NUMBER OF DAYS PRESENT: '.$this->attendance['count'].'</p>';
			echo '<p>TOTAL NUMBER OF DAYS SCHOOL WAS OPEN: '.$this->attendance['total'].'</p>';
			echo '<p>PERCENTAGE OF ATTENDANCE: '.$this->attendance['perc'].'%</p>';
			echo '<p>CLASS TEACHER\'S COMMENT: '.strtoupper($this->comments['class_teacher_remark']).'</p>';
			echo '<p>PRINCIPAL\'S COMMENT: '.strtoupper($this->comments['principal_remark']).'</p>';
			echo '</div>';
		}
		else {
			echo '</table><h4>THIS RESULT IS NOT PUBLISHED YET. PLEASE CHECK BACK LATER OR MEET YOUR CLASS TEACHER.</h4>';
		}
		echo View::back_to_homepage();
	}
}
class Dec_Choose_Publish {//declares form to choose result to publish
	private $results;
	public function __construct($results) {
		$this->results = $results;
	}
	public function dec_form() {
		$students = $this->results;
		$all = '';
		echo '<form method=\'post\' action=\'publishresults.php\'>';
		foreach ($students as $student) {
			foreach ($student as $session) {
				$all .= $session['student_id'].'_'.$session['session'].'_'.$session['term'].'&';
				echo '<p><input type=\'checkbox\' name=\'to_publish[]\' value=\''.$session['student_id'].'_'.$session['session'].'_'.$session['term'].'\' />'.$session['name'].' '.$session['session'].' '.$session['term'].'.</p>';
			}
		}
		echo '<p><input type=\'checkbox\' name=\'check_all\' value=\''.$all.'\' />CHECK ALL.</p>';
		echo '<input type=\'submit\' name=\'pub_sub\' value=\'PUBLISH SELECTED\' />';
		echo '</form>';
	}
}
class Dec_Mark_Attendance {//declares form to mark attendance from
	private $students;
	private $class;
	public function __construct($studs, $class) {
		$this->students = $studs;
		$this->class = $class;
	}
	public function dec_form() {
		$all = '';
		echo '<form method=\'post\' action=\'attendance.php\'>';
		echo '<table>';
		echo '<tr><th>S/N</th><th>STUDENT\'S NAME</th><th>MARK PRESENT</th></tr>';
		$index = 1;
		foreach ($this->students as $student) {
			echo '<tr>';
			echo '<td>'.$index.'</td>';
			$all .= $student['student_id'].'&';
			$name = $student['student_first_name'].' '.$student['student_last_name'];
			echo '<td>'.$name.'</td><td><input type=\'checkbox\' name=\'presents[]\' value=\''.$student['student_id'].'\' /></td>';
			echo '</tr>';
			$index++;
		}
		echo '<tr><td>'.$index.'</td><td>MARK ALL</td><td><input type=\'checkbox\' name=\'check_all\' value=\''.$all.'\' /></td>';
		echo '<input type=\'hidden\' name=\'class\' value=\''.$this->class.'\' />';
		echo '<tr><td colspan=\'3\'><input type=\'submit\' name=\'attendance_sub\' value=\'MARK ATTENDANCE\' /></td></tr>';
		echo '<table>';
		echo '</form>';
	}
}
class Dec_Choose_Promote {
	private $students;
	private $class;
	public function __construct($studs, $class) {
		$this->students = $studs;
		$this->class = $class; 
	}
	private function get_next_class($class) {
		switch ($class) {
			case 'JSS 1A':
				$next_class = 'JSS 2A';
				break;
			case 'JSS 1B':
				$next_class = 'JSS 2B';
				break;
			case 'JSS 2A':
				$next_class = 'JSS 3A';
				break;
			case 'JSS 2B':
				$next_class = 'JSS 3B';
				break;
			case 'SSS 1 ART':
				$next_class = 'SSS 2 ART';
				break;
			case 'SSS 1 COMMERCIAL':
				$next_class = 'SSS 2 COMMERCIAL';
				break;
			case 'SSS 1 SCIENCE':
				$next_class = 'SSS 2 SCIENCE';
				break;
			case 'SSS 2 ART':
				$next_class = 'SSS 3 ART';
				break;
			case 'SSS 2 COMMERCIAL':
				$next_class = 'SSS 3 COMMERCIAL';
				break;
			case 'SSS 2 SCIENCE':
				$next_class = 'SSS 3 SCIENCE';
				break;
			default:
				// code...
				break;
		}
		return $next_class;
	}
	public function dec_form() {
		echo '<form method=\'post\' action=\'promote.php\'>';
		echo '<table>';
		echo '<tr><th>S/N</th><th>MARK</th><th>STUDENT</th></th></tr>';
		echo '<tr><td>-</td><td><input type=\'checkbox\' name=\'mark_all\' value=\''.$this->class.'\' /></td><td>MARK ALL</td></tr>';
		$index = 1;
		foreach ($this->students as $student) {
			echo '<tr>';
			echo '<td>'.$index.'</td>';
			$name = $student['student_first_name'].' '.$student['student_last_name'];
			echo '<td><input type=\'checkbox\' name=\'students[]\' value=\''.$student['student_id'].'\' /></td><td>'.$name.'</td>';
			echo '</tr>';
			$index++;
		}
		echo '<input type=\'hidden\' name=\'class\' value=\''.$this->class.'\'>';
		if (preg_match('/[12]/', $this->class)) {
			$next = $this->get_next_class($this->class);
			echo '<input type=\'hidden\' name=\'next_class\' value=\''.$next.'\' />';
			echo '<tr><td colspan=\'3\'><input type=\'submit\' name=\'sub_promote\' value=\'PROMOTE TO '.$next.'\' /></td></tr>';
			echo '</table>';
		} else {
			if ($this->class == 'JSS 3A' || $this->class == 'JSS 3B') {
				echo '</table>';
				echo '<p>CHOOSE NEXT CLASS FOR SELECTED STUDENTS: ';
				echo '<select name=\'next_class\'>';
				echo '<option value=\'SSS 1 ART\'>SSS 1 ART';
				echo '<option value=\'SSS 1 COMMERCIAL\'>SSS 1 COMMERCIAL';
				echo '<option value=\'SSS 1 SCIENCE\'>SSS 1 SCIENCE';
				echo '</select>';
				echo '</p>';
				echo '<p><input type=\'submit\' name\'sub_promote\' value=\'PROMOTE TO NEXT CLASS\' /></p>';
			} else if ($this->class == 'SSS 3 ART' || $this->class == 'SSS 3 COMMERCIAL' || $this->class == 'SSS 3 SCIENCE') {
				echo '<tr><td colspan=\'3\'><input type=\'submit\' name=\'sub_promote\' value=\'PASS OUT SELECTED STUDENTS\' /></td></tr>';
			echo '</table>';
			}
		}
		echo '</form>';
	}
}
class Show_Info_Box {//shows box containing st info
	private $info;
	private $type;
	public function __construct($info, $type) {
		$this->info = $info;
		$this->type = $type;
	}
	public function show() {
		$name = $this->info['student_first_name'].' '.$this->info['student_last_name'];
		$class = $this->info['student_class'];
		$class_teacher = $this->info['class_teacher'];
		$passport = $this->info['student_passport'];
		echo '<div id=\'info_box\'>';
		echo '<table>';
		echo '<tr>';
		echo '<td rowspan=\'4\'>'.View::show_pic($passport, $name).'</td>';
		echo '<tr><td>STUDENT NAME</td><td>'.$name.'</td></tr>';
		echo '<tr><td>STUDENT CLASS</td><td>'.$class.'</td></tr>';
		echo '<tr><td>CLASS TEACHER</td><td>'.$class_teacher.'</td></tr>';
		echo '</tr>';
		echo '</table>';
		echo '</div>';
	}
}
class Show_Student_Subjects {//shows all class subjects and subjects offered ny specific student
	private $all_subjects;
	private $student_subjects;
	public function __construct($all, $spec) {
		$this->all_subjects = $all;
		$this->student_subjects = $spec;
	}
	public function show() {
		echo '<div>';
		echo '<p>ALL SUBJECTS OFFERED IN CLASS:</p>';
		echo '<table>';
		echo '<tr><th>S/N</th><th>SUBJECT</th><th>SUBJECT TEACHER</th></tr>';
		$index = 1;
		foreach ($this->all_subjects as $subject) {
			echo '<tr>';
			echo '<td>'.$index.'</td>';
			echo '<td>'.strtoupper($subject['subject']).'</td><td>'.$subject['teacher_name'].'</td>';
			echo '</tr>';
			$index++;
		}
		echo '</table>';
		echo '</div>';
		echo '<div>';
		echo '<p>ALL SUBJECTS OFFERED BY STUDENT:</p>';
		echo '<table>';
		echo '<tr><th>S/N</th><th>SUBJECT</th><th>SUBJECT TEACHER</th></tr>';
		$index = 1;
		foreach ($this->student_subjects as $subject) {
			echo '<tr>';
			echo '<td>'.$index.'</td>';
			for($i = 0; $i < sizeof($this->all_subjects); $i++) {
				if ($subject == $this->all_subjects[$i]['subject']) {
					echo '<td>'.strtoupper($subject).'</td><td>'.$this->all_subjects[$i]['teacher_name'].'</td>';
					break;
				}
			}
			echo '</tr>';
			$index++;
		}
		echo '</table>';
		echo '</div>';
	}
}
class Dec_Write_Students_Comments {
	private $students;
	private $class;
	private $session;
	private $term;
	private $type;
	public function __construct($studs, $class, $sess, $term, $type) {
		$this->students = $studs;
		$this->class = $class;
		$this->session = $sess;
		$this->term = $term;
		$this->type = $type;
	}
	public function dec_form() {
		echo '<p>CLASS: '.$this->class.'</p>';
		echo '<p>SESSION: '.$this->session.'</p>';
		echo '<p>TERM: '.$this->term.'</p>';
		if ($this->type == 'class_teacher') {
			$type = 'CLASS TEACHER\'S COMMENTS.';
		} else {
			$type = 'PRINCIPAL\'S COMMENTS.';
		}
		echo '<p>COMMENT TYPE: '.$type.'</p>';
		echo '<form method=\'post\' action=\'./writecomments.php\'>';
		echo '<table>';
		echo '<tr><th>S/N</th><th>STUDENT\'S NAME</th><th>WRITE COMMENT</th></tr>';
		$index = 1;
		foreach ($this->students as $student) {
			echo '<tr>';
			echo '<td>'.$index.'</td>';
			$name = $student['student_first_name'].' '.$student['student_last_name'];
			echo '<td>'.$name.'</td>';
			echo '<td><input type=\'hidden\' name=\'student_ids[]\' value=\''.$student['student_id'].'\' /><textarea name=comments[] cols=\'16\' rows=\'2\'></textarea></td>';
			echo '</tr>';
			$index++;
		}
		echo '<input type=\'hidden\' name=\'session\' value=\''.$this->session.'\' />';
		echo '<input type=\'hidden\' name=\'term\' value=\''.$this->term.'\' />';
		echo '<input type=\'hidden\' name=\'type\' value=\''.$this->type.'\' />';
		echo '<tr><td colspan=\'3\'><input type=\'submit\' name=\'add_comments_sub\' value=\'ADD COMMENTS\' /></td></tr>';
		echo '</table>';
		echo '</form>';
	}
}
?>