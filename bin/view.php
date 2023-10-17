<?php
//the following classes handle displaying student info and bio
class View {
	public static function show_pic($src, $alt, $id = false, $class = false) {
		return '<img src=\''.$src.'\' alt=\''.$alt.'\' id=\''.$id.'\' class=\'passports\'>';
	}
	public static function back_to_homepage() {
		echo '<article class=\'homepage\'><a href=\'./index.php\'>GO TO HOMEPAGE</a></article>';
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
class Display_St {//instantiated in students_regx.php *****
	private $result;
	private $type;
	public function __construct($array, $type) {
		$this->result = $array;
		$this->type = $type;
	}
	public function display() {
		$string = '';
		if ($this->type == 'student') {
			$first_name = $this->result[0]['student_first_name'];
			$last_name = $this->result[0]['student_last_name'];
			$username = $this->result[0]['student_username'];
			$class = $this->result[0]['student_class'];
			$passport_src = $this->result[0]['student_passport'];
			$string .= View::show_pic($passport_src, $first_name);
			$string .= '<section class=\'basic_info field_set\'>';
			$string .= '<span class=\'legend\'>Students basic info </span>';
			$string .= '<p><b>STUDENT\'S FIRST NAME:</b> '.$first_name.'.</p>';
			$string .= '<p><b>STUDENT\'S LAST NAME:</b> '.$last_name.'.</p>';
			$string .= '<p><b>STUDENT\'S USERNAME:</b> '.$username.'.</p>';
			$string .= '<p><b>STUDENT\'S CLASS:</b> '.$class.'.</p>';
			$string .= '</div>';
			$string .= '</div>';
		} else if ($this->type == 'staff') {
			$first_name = $this->result[0]['staff_first_name'];
			$last_name = $this->result[0]['staff_last_name'];
			$username = $this->result[0]['staff_username'];
			$class = $this->result[0]['staff_class'];
			$passport_src = $this->result[0]['staff_passport'];
			$string .= View::show_pic($passport_src, $first_name);
			$string .= '<div>';
			$string .= '<span><b>STAFF\'S BASIC INFO</b></span>';
			$string .= '<p><b>STAFF\'S FIRST NAME:</b> '.$first_name.'.</p>';
			$string .= '<p><b>STAFF\'S LAST NAME:</b> '.$last_name.'.</p>';
			$string .= '<p><b>STAFF\'S USERNAME:</b> '.$username.'.</p>';
			$string .= '<p><b>STAFF\'S CLASS:</b> '.$class.'.</p>';
			$string .= '</div>';
			$string .= '</div>';
		}
		return $string;
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
		$string = '';
		if (sizeof($this->result_set) == 0) {
			$string .= '<strong>DATA DOES NOT EXIST!</strong>';
			return $string;
			die();
		}
		if ($this->type == 'student') {
			$string .= '<table id=\'\'>';
			$string .= '<tr>';
			$string .= '<th>S/N</th>';
			$string .= '<th>STUDENT\'S PICTURE</th>';
			$string .= '<th>STUDENT\'S NAME</th>';
			$string .= '<th>STUDENT\'S USERNAME</th>';
			$string .= '<th>STUDENT\'S CLASS</th>';
			$string .= '<th>VIEW BIO</th>';
			$string .= '<th>EDIT STUDENT</th>';
			$string .= '</tr>';
			$index = 1;
			foreach ($this->result_set as $student) {
				$string .= '<tr>';
				$string .= '<td>'.$index++.'.</td>';
				$string .= '<td>'.View::show_pic($student['student_passport'], $student['student_first_name']).'</td>';
				$string .= '<td>'.$student['student_first_name'].' '.$student['student_last_name'].'</td>';
				$string .= '<td>'.$student['student_username'].'</td>';
				$string .= '<td>'.$student['student_class'].'</td>';
				$string .= '<td><a href=\'./student_bio.php?id='.$student['student_id'].'\'>VIEW BIO</a></td>';
				$string .= '<td><a href=\'./addstudent.php?id='.$student['student_id'].'\'>EDIT INFO</a></td>';
				$string .= '</tr>';
			}
			$string .= '</table>';
		} else if ($this->type == 'staff') {
			$string .= '<table id=\'\'>';
			$string .= '<tr>';
			$string .= '<th>S/N</th>';
			$string .= '<th>STAFF\'S PICTURE</th>';
			$string .= '<th>STAFF\'S NAME</th>';
			$string .= '<th>STAFF\'S USERNAME</th>';
			$string .= '<th>STAFF\'S ROLE</th>';
			$string .= '<th>VIEW BIO</th>';
			$string .= '<th>EDIT STAFF</th>';
			$string .= '</tr>';
			$index = 1;
			foreach ($this->result_set as $staff) {
				$string .= '<tr>';
				$string .= '<td>'.$index++.'.</td>';
				$string .= '<td>'.View::show_pic($staff['staff_passport'], $staff['staff_first_name']).'</td>';
				$string .= '<td>'.$staff['staff_first_name'].' '.$staff['staff_last_name'].'</td>';
				$string .= '<td>'.$staff['staff_username'].'</td>';
				$string .= '<td>'.$staff['staff_role'].'</td>';
				$string .= '<td><a href=\'./staff_bio.php?id='.$staff['staff_id'].'\'>VIEW BIO</a></td>';
				$string .= '<td><a href=\'./addstaff.php?id='.$staff['staff_id'].'\'>EDIT INFO</a></td>';
				$string .= '</tr>';
			}
			$string .= '</table>';
		}
		return $string;
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
				$method = 'nt';
				break;
			case 'staff':
				$type = 'STAFF';
				$fn = 'staff_first_name';
				$ln = 'staff_last_name';
				$cl = 'staff_role';
				$method = 'fa';
				break;
		}
		$form = '<p>Are you sure you want to delete the following '.strtolower($this->type).'(s)?</p><ul>';
		if (strpos($this->input, ',')) {
			foreach ($this->list as $value) {
				$form .= '<li>'.$value[$fn].' '.$value[$ln].' IN '.$value[$cl].'</li>';
			}
		} else {
			$form .= '<li>'.$this->list[$fn].' '.$this->list[$ln].' IN '.$this->list[$cl].'</li>';
		}
		$form .= '</ul><p><strong>BE INFORMED THAT ALL DATA PERTAINING TO THE LISTED '.strtoupper($this->type).'(S) WILL BE DELETED AND CANNOT BE REVERSED.</strong></p>';
		$form .= '<form method=\'post\' action=\'delete_st.php?type='.$method.'\'>';
		$form .= '<p><input type=\'hidden\' name=\'usernames\' value=\''.$this->input.'\' /></p>';
		$form .= '<p><input type=\'submit\' name=\'proceed\' id=\'delete\' value=\'DELETE\' /></p>';
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
		self::$type = $type;
		$this->username = $username;
	}
	public function read_xml() {
		$file = '../bin/mails/'.self::$id.'.xml';
		$xml = simplexml_load_file($file);
		$receivers = array();
		$appendages = array();
		$sender = $xml->sender;
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
		$string = '';
		$string .= '<div id=\'mail_info\'><p><b>Title of mail: </b> '.$title.'</p>';
		$string .= '<p><b>From:</b> '.$sender.'.</p>';
		$string .= '<p><b>To:</b> ';
		if ($this->mode == 'sent') {
			for ($i = 0; $i < sizeof($receivers); $i++) {
				if ($i == (sizeof($receivers) - 1)) {
					$string .= $receivers[$i].'.';
				} else {
					$string .= $receivers[$i].', ';
				}
			}
		} else if ($this->mode == 'received') {
			if (self::$type != 'admin') {
				$name = Database::check_unique_username($this->username, self::$type.'s', 1);
				$name = $name[self::$type.'_first_name'].' '.$name[self::$type.'_last_name'];
			} else {$name = 'ADMIN';}
			if (sizeof($receivers) > 1) {
				$string .= $name.' and others.';
			} else {
				$string .= $name.'.';
			}
		}
		$string .= '</p>';
		$string .= '<p><b>Date: </b> '.$date.'.</p></div>';
		$string .= '<div id=\'mail_message\'><p><b>Message: </b> '.evaluateText($message).'</p></div>';
		$string .= '<div id=\'mail_appendages\'><p><b>Appendages: </b>';
		if ($appendages) {
			
			foreach ($appendages as $appendage) {
				if ($appendage['type'] == 'png' || $appendage['type'] == 'jpeg' || $appendage['type'] == 'jpg' || $appendage['type'] == 'gif') {
					$link= '<span class=\'download_appendage_icon\'>image</span>';
				} else if ($appendage['type'] == 'mp3') {
					$link= '<span class=\'download_appendage_icon\'>audio</span>';
				} else if ($appendage['type'] == 'mp4' || $appendage['type'] == 'mkv') {
					$link= '<span class=\'download_appendage_icon\'>video</span>';
				} else {
					$link= '<span class=\'download_appendage_icon\'>file</span>';
				}
				$string .= '<span><a class=\'download_appendage_link\' href=\'./download_appendage.php?id='.$appendage.'&type='.$appendage['type'].'\'>'.$link.'</a></span> ';
			}
			
		}
		$string .= '</p></div>';
		return $string;
	}
}
class Dec_Students_Reg {
	private $students;
	public function __construct($studs) {
		$this->students = $studs;
	}
	public function dec_form() {
		$string = '';
		$string .= '<table>';
		$string .= '<tr><th>S/N</th><th>CLASS STUDENTS</th><th>REGISTER</th></tr>';
		$index = 1;
		foreach ($this->students as $student) {
			$string .= '<tr>';
			$string .= '<td>'.$index.'.</td>';
			$string .= '<td>'.$student['student']['student_first_name'].' '.$student['student']['student_last_name'].'</td>';
			if ($student['status'] == 'no_reg') {
				$string .= '<td><a href=\'./student_registration.php?id='.base64_encode($student['student']['student_id']).'&cl='.base64_encode($student['student']['student_class']).'\'>register...</a></td>';
			} else {
				$string .= '<td>REGISTERED</td>';
			}
			$string .= '</tr>';
			$index++;
		}
		$string .= '</table>';
		return $string;
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
		$string = '';
		$string .= '<form method=\'post\' action=\'./student_registration.php\'>';
		$string .= '<table>';
		$string .= '<tr><th>S/N</th><th>SUBJECT</th><th>TICK</th><th>SUBJECT TEACHER</th><tr>';
		$index = 1;
		$string .= '<tr><td>-</td><td>SELECT ALL</td><td><input type=\'checkbox\' name=\'mark_all\' value=\'all\' /></td><td>-</td></tr>';
		foreach ($this->subjects as $subject) {
			$string .= '<tr>';
			$string .= '<td>'.$index.'.</td>';
			$string .= '<td>'.strtoupper($subject['subject']).'</td>';
			$string .= '<td><input type=\'checkbox\' name=\'subjects[]\' value=\''.$subject['subject'].'\' /></td>';
			$string .= '<td>'.$subject['teacher_name'].'</td>';
			$string .= '</tr>';
			$index++;
		}
		$string .= '<input type=\'hidden\' name=\'student_id\' value=\''.$this->student_id.'\' />';
		$string .= '<input type=\'hidden\' name=\'student_class\' value=\''.$this->student_class.'\' />';
		$string .= '<input type=\'hidden\' name=\'session\' value=\''.$this->session.'\' />';
		$string .= '<tr><td colspan=\'4\'><input type=\'submit\' name=\'reg_sub\' value=\'Register student\' /></td></tr>';
		$string .= '</table>';
		$string .= '</form>';
		return $string;
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
		$string = '';
		$string .= '<p>Subject: '.$this->subject.'</p>';
		$string .= '<p>Class: '.$this->class.'</p>';
		$string .= '<p>Session: '.$this->session.'</p>';
		$string .= '<p>Term: '.$this->term.'</p>';
		$string .= '<p>Result type: '.$this->result_type.'</p>';
		$string .= '<form method=\'post\' action=\'./addresults.php\'>';
		$string .= '<table>';
		$string .= '<tr><th>S/N</th><th>STUDENT\'S NAME</th><th>SCORE OBTAINED</th><th>SCORE OBTAINABLE</th></tr>';
		for ($i = 0; $i < sizeof($this->students); $i++) {
			$string .= '<tr>';
			$string .= '<td>'.($i + 1).'.</td>';
			foreach ($this->students[$i] as $key => $value) {
				if ($key == 'name') {
					$string .= '<td>'.$value.'</td>';
				} else if ($key == 'student_id') {
					$string .= '<td><input type=\'hidden\' name=\'id[]\' value=\''.$value.'\' />';
				} else {
					$string .= '<input type=\'number\' max=\''.$obtainable.'\' name=\'score[]\' value=\''.$value.'\' /></td>';
				}
			}
			$string .= '<td>'.$obtainable.'</td>';
			$string .= '</tr>';
		}
		$string .= '<input type=\'hidden\' name=\'subject\' value=\''.$this->subject.'\' />';
		$string .= '<input type=\'hidden\' name=\'class\' value=\''.$this->class.'\' />';
		$string .= '<input type=\'hidden\' name=\'session\' value=\''.$this->session.'\' />';
		$string .= '<input type=\'hidden\' name=\'term\' value=\''.$this->term.'\' />';
		$string .= '<input type=\'hidden\' name=\'res_type\' value=\''.$this->result_type.'\' />';
		$string .= '<tr><td colspan=\'4\'><input type=\'submit\' name=\'add_results_sub\' value=\'Add results\' /></td></tr>';
		$string .= '</table>';
		$string .= '</form>';
		return $string;
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
		
		$string = '';
		$string .= '<p>Subject: '.strtoupper($this->subject).'</p>';
		$string .= '<p>Class: '.$this->class.'</p>';
		$string .= '<p>Session: '.$this->session.'</p>';
		$string .= '<p>Term: '.$this->term.'</p>';
		$string .= '<span class=\'toggle_result_view\'>full view</span>';
		$string .= '<article class=\'results_table\'>';
		$string .= '<table class=\'sticky_parts\'>';
		$string .= '<thead>';
		$string .= '<tr><th rowspan=\'2\' class=\'top_sticky left_sticky\' >S/N</th><th rowspan=\'2\' class=\'top_sticky left_sticky\'>STUDENT\'S NAME</th><th colspan=\'2\' class=\'top_sticky\' id=\'top1\'>1ST C.A. TEST</th><th colspan=\'2\' class=\'top_sticky\'>2ND C.A. TEST</th><th colspan=\'2\' class=\'top_sticky\'>ASSIGNMENT</th><th colspan=\'2\' class=\'top_sticky\'>EXAMINATION</th><th colspan=\'2\' class=\'top_sticky\'>TOTAL</th><th rowspan=\'2\' class=\'top_sticky\'>GRADE</th></tr>';
		$string .= '<tr>';
		for ($i = 0; $i < 5; $i++) { 
			$string .= '<th id=\'top2\' class=\'top_sticky\'>SCORE OBTAINED</th>';
			$string .= '<th class=\'top_sticky\'>SCORE OBTAINABLE</th>';
		}
		$string .= '</tr>';
		$string .= '</thead>';
		$index = 1;
		$string .= '<tbody>';
		foreach ($this->results as $result) {
			$scores = array();
			$string .= '<tr>';
			$string .= '<th class=\'left_sticky\' id=\'left1\'>'.$index.'.</th>';
			foreach ($result as $key => $value) {
				if ($key == 'name') {
					$string .= '<th class=\'left_sticky\' id=\'left2\'>'.$value.'</th>';
				} else if ($key != 'student_id') {
					if (preg_match('/ca/i', $key)) {
						$obtainable = 15;
					} else if (preg_match('/ass/i', $key)) {
						$obtainable = 10;
					} else if (preg_match('/exam/i', $key)) {
						$obtainable = 60;
					}
					$scores[] = $value;
					$string .= $value != null ? '<td>'.$value.'</td>' : '<td>-</td>';
					$string .= '<td>'.$obtainable.'</td>';
				}
			}
			$total = total($scores);
			$string .= '<td>'.$total.'</td>';
			$string .= '<td>100</td>';
			$string .= '<td>'.get_grade($total).'</td>';
			$string .= '</tr>';
			$index++;
		}
		$string .= '</tbody>';
		$string .= '</table>';
		$string .= '</article>';
		$string .= '<article class=\'homepage\'><a href=\'./index.php\'>GO TO HOMEPAGE</a></article>';
		return $string;
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
	private $gender;
	private $passport;
	public function __construct($res, $attend, $comms, $name, $class, $sess, $term, $gender, $passport) {
		$this->results = $res;
		$this->attendance = $attend;
		$this->comments = $comms;
		$this->name = $name;
		$this->class = $class;
		$this->session = $sess;
		$this->term = $term;
		$this->gender = $gender;
		$this->passport = $passport;
	}
	public function show() {
		$string = '';
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
		$string .= '<section class=\'basic_info field_set\'>';
		$string .= '<article id=\'passport\'>'.View::show_pic($this->passport, strtolower($this->name)).'</article>';
		$string .= '<article class=\'names\'>';
		$string .= '<div><span>Student\'s name: </span><span>'.strtoupper($this->name).'</span></div>';
		$string .= '<div><span>Student\'s class: </span><span>'.$this->class.'</span></div>';
		$string .= '<div><span>Result session: </span><span>'.$this->session.'</span></div>';
		$string .= '<div><span>Result term: </span><span>'.$this->term.'</span></div>';
		$string .= '<div><span>Student\'s gender: </span><span>'.$this->gender.'</span></div>';
		$string .= '<img src=\'../school/fpclogo.jpeg\' id=\'result_logo\'>';
		$string .= '</section>';
		if ($this->results) {
			$string .= '<span class=\'toggle_result_view\'>full view</span>';
			$string .= '<article class=\'results_table\'>';
			$string .= '<table class=\'sticky_parts\'>';
			$string .= '<thead><tr><th rowspan=\'2\'>S/N</th><th rowspan=\'2\'>SUBJECT</th><th colspan=\'2\'>1ST C.A. TEST</th><th colspan=\'2\'>2ND C.A. TEST</th><th colspan=\'2\'>ASSIGNMENT</th><th colspan=\'2\'>EXAMINATION</th><th colspan=\'2\'>TOTAL</th><th rowspan=\'2\'>GRADE</th></tr>';
			$string .= '<tr>';
			for ($i = 0; $i < 5; $i++) { 
				$string .= '<th>SCORE OBTAINED</th>';
				$string .= '<th>SCORE OBTAINABLE</th>';
			}
			$string .= '</tr></thead>';
			$index = 1;
			$string .= '<tbody>';
			foreach ($this->results as $result) {
				$scores = array();
				$string .= '<tr>';
				$string .= '<th>'.$index.'.</th>';
				foreach ($result as $key => $value) {
					if ($key == 'subject') {
						$string .= '<th>'.strtoupper($value).'</th>';
					} else {
						if (preg_match('/ca/i', $key)) {
							$obtainable = 15;
						} else if (preg_match('/ass/i', $key)) {
							$obtainable = 10;
						} else if (preg_match('/exam/i', $key)) {
							$obtainable = 60;
						}
						$scores[] = $value;
						$string .= $value != null ? '<td>'.$value.'</td>' : '<td>-</td>';
						$string .= '<td>'.$obtainable.'</td>';
					}
				}
				$total = total($scores);
				$subjects_scores[] = $total;
				$string .= '<td>'.$total.'</td>';
				$string .= '<td>100</td>';
				$string .= '<td>'.get_grade($total).'</td>';
				$string .= '</tr>';
				$index++;
			}
			$string .= '</tbody></table>';
			$string .= '</article>';
			$string .= '<article class=\'student_performance_data field_set\'>';
			$total_score_obtained = total_obtained($subjects_scores);
			$string .= '<div class=\'s_ed\'>Total score obtained: '.$total_score_obtained.'</div>';
			$total_score_obtainable = sizeof($this->results) * 100;
			$string .= '<div class=\'s_able\'>Total score obtainable: '.$total_score_obtainable.'</div>';
			$percentage = get_term_percentage($subjects_scores, sizeof($this->results));
			$string .= '<div class=\'s_tage\'>Score percentage: '.round($percentage, 2).'%</div>';
			$string .= '<div class=\'a_ent\'>Number of days present: '.$this->attendance['count'].'</div>';
			$string .= '<div class=\'a_pen\'>Total number of school days: '.$this->attendance['total'].'</div>';
			$string .= '<div class=\'a_tage\'>Percentage of attendance: '.round($this->attendance['perc'], 2).'%</div>';
			$string .= '<div class=\'c_er\'>Class teacher\'s comment: '.@strtoupper($this->comments['class_teacher_remark']).'</div>';
			$string .= '<div class=\'c_al\'>Principal\'s comment: '.@strtoupper($this->comments['principal_remark']).'</div>';
			$string .= '</article>';
		}
		else {
			$string .= '<strong>THIS RESULT IS NOT PUBLISHED YET. PLEASE CHECK BACK LATER OR MEET YOUR CLASS TEACHER.</strong>';
		}
		$string .= '<article class=\'homepage\'><a href=\'./index.php\'>GO TO HOMEPAGE</a></article>';
		return $string;
	}
}
class Dec_Choose_Publish {//declares form to choose result to publish
	private $results;
	public function __construct($results) {
		$this->results = $results;
	}
	public function dec_form() {
		$students = $this->results;
		$string = '';
		$all = '';
		if (sizeof($this->results) > 0) {
			$string .= '<form method=\'post\' action=\'publishresults.php\'>';
			$string .= '<table>';
			$string .= '<tr><th>-</th><th>STUDENT\'S NAME</th><th>SESSION</th><th>TERM</th></tr>';
			$string1 = '';
			foreach ($students as $student) {
				foreach ($student as $session) {
					$string1 .= '<tr>';
					$all .= $session['student_id'].'_'.$session['session'].'_'.$session['term'].'&';
					$string1 .= '<td>
					<input type=\'checkbox\' name=\'to_publish[]\' value=\''.$session['student_id'].'_'.$session['session'].'_'.$session['term'].'\'>
					</td>
					<td>'.$session['name'].'</td>
					<td>'.$session['session'].'</td>
					<td>'.strtoupper($session['term']).'</td>';
					$string1 .= '</tr>';
				}
			}
			$string .= '<tr><td><input type=\'checkbox\' name=\'mark_all\' value=\''.$all.'\' /></td><td colspan=\'3\'>SELECT ALL</td></tr>';
			$string .= $string1;
			$string .= '<tr><td colspan=\'4\'><input type=\'submit\' name=\'pub_sub\' value=\'Publish Selected\' /></td></tr>';
			$string .= '</table>';
			$string .= '</form>';
		} else {
			echo '<strong>NO RESULT LEFT TO PUBLISH FOR THIS CLASS.</strong>';
		}
		return $string;
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
		$string = '';
		$string .= '<form method=\'post\' action=\'attendance.php\'>';
		$string .= '<table>';
		$string .= '<tr><th>S/N</th><th>STUDENT\'S NAME</th><th>MARK PRESENT</th></tr>';
		$string .= '<tr><td>-</td><td>SELECT ALL</td><td><input type=\'checkbox\' name=\'mark_all\' value=\'all\' /></td>';
		$index = 1;
		foreach ($this->students as $student) {
			$string .= '<tr>';
			$string .= '<td>'.$index.'.</td>';
			$name = $student['student_first_name'].' '.$student['student_last_name'];
			$string .= '<td>'.$name.'</td><td><input type=\'checkbox\' name=\'presents[]\' value=\''.$student['student_id'].'\' /></td>';
			$string .= '</tr>';
			$index++;
		}
		$string .= '<input type=\'hidden\' name=\'class\' value=\''.$this->class.'\' />';
		$string .= '<tr><td colspan=\'3\'><input type=\'submit\' name=\'attendance_sub\' value=\'Mark attendance\' /></td></tr>';
		$string .= '</table>';
		$string .= '</form>';
		return $string;
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
		$string = '';
		$string .= '<form method=\'post\' action=\'promote.php\'>';
		$string .= '<p>Select students to promote:</p>';
		$string .= '<table>';
		$string .= '<tr><td>-</td><td>MARK ALL</td><td><input type=\'checkbox\' name=\'mark_all\' value=\''.$this->class.'\' /></td></tr>';
		$index = 1;
		foreach ($this->students as $student) {
			$string .= '<tr><td>'.$index++.'.</td>';
			$name = $student['student_first_name'].' '.$student['student_last_name'];
			$string .= '<td>'.$name.'</td><td><input type=\'checkbox\' name=\'students[]\' value=\''.$student['student_id'].'\' /></td>';
			$string .= '</tr>';
		}
		$string .= '<input type=\'hidden\' name=\'class\' value=\''.$this->class.'\'>';
		if (preg_match('/[12]/', $this->class)) {
			$next = $this->get_next_class($this->class);
			$string .= '<input type=\'hidden\' name=\'next_class\' value=\''.$next.'\' />';
			$string .= '<tr><td colspan=\'3\'><input type=\'submit\' name=\'sub_promote\' value=\'Promote to '.$next.'\' /></td></tr>';
			$string .= '</table>';
		} else {
			if ($this->class == 'JSS 3A' || $this->class == 'JSS 3B') {
				$string .= '</table>';
				$string .= '<p><label>Choose next class for selected students: </label>';
				$string .= '<select name=\'next_class\'>';
				$string .= '<option value=\'\'>---</option>';
				$string .= '<option value=\'SSS 1 ART\'>SSS 1 ART</option>';
				$string .= '<option value=\'SSS 1 COMMERCIAL\'>SSS 1 COMMERCIAL</option>';
				$string .= '<option value=\'SSS 1 SCIENCE\'>SSS 1 SCIENCE</option>';
				$string .= '</select></p>';
				$string .= '<p><input type=\'submit\' name=\'sub_promote\' value=\'Promote to next class\' /></p>';
			} else if ($this->class == 'SSS 3 ART' || $this->class == 'SSS 3 COMMERCIAL' || $this->class == 'SSS 3 SCIENCE') {
				$string .= '<tr><td colspan=\'3\'><input type=\'submit\' name=\'sub_promote\' value=\'Pass out selected students\' /></td></tr>';
			$string .= '</table>';
			}
		}
		$string .= '</form>';
		return $string;
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
		$string = '';
		$string .= '<div>';
		$string .= '<p>All subjects offered in '.$_COOKIE['student_class'].':</p>';
		$string .= '<table>';
		$string .= '<tr><th>S/N</th><th>SUBJECT</th><th>SUBJECT TEACHER</th></tr>';
		$index = 1;
		foreach ($this->all_subjects as $subject) {
			$string .= '<tr>';
			$string .= '<td>'.$index.'.</td>';
			$string .= '<td>'.strtoupper($subject['subject']).'</td><td>'.$subject['teacher_name'].'</td>';
			$string .= '</tr>';
			$index++;
		}
		$string .= '</table>';
		$string .= '</div>';
		$string .= '<div>';
		$string .= '<p>All subjects registered by you:</p>';
		if (!$this->student_subjects) {
			$string .= 'NO REGISTERED SUBJECTS.';
		} else {
			$index = 1;
			$string .= '<table>';
			$string .= '<tr><th>S/N</th><th>SUBJECT</th><th>SUBJECT TEACHER</th></tr>';
			foreach ($this->student_subjects as $subject) {
				$string .= '<tr>';
				$string .= '<td>'.$index++.'.</td>';
				for($i = 0; $i < sizeof($this->all_subjects); $i++) {
					if ($subject == $this->all_subjects[$i]['subject']) {
						$string .= '<td>'.strtoupper($subject).'</td><td>'.$this->all_subjects[$i]['teacher_name'].'</td>';
						break;
					}
				}
				$string .= '</tr>';
			}
			$string .= '</table>';
			$string .= '</div>';
		}
		return $string;
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
	public function dec_form() { /* ****** */
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