<?php
function show_header($title, $stylesheet = '') {
	echo '<!doctype>'."\n";
	echo '<html lang=\'en-US\'>'."\n";
	echo '<head>';
	echo '<style>';
	echo 'table, th, td {border: 1px solid red; border-collapse: collapse; padding: 3px}';
	echo '</style>';
	echo '<meta charset=\'utf-8\' \>'."\n";
	echo '<meta name=\'viewport\' content=\'width=device-width, initial-scale=1\' />'."\n";
	echo '<title>'.$title.'</title>';
	echo '<link rel=\'stylesheet\' type=\'text/css\' href='.$stylesheet.' />'."\n";
	echo '</head>'."\n";
	echo '<body>'."\n";
}
function show_footer() {
	echo '</body>'."\n";
	echo '</html>'."\n";
}
class Dec_Addst {//shows the staff of student add form
	private $existing;
	private $student_field_array = array('student_id' => '', 'student_fn' => '', 'student_ln' => '', 'student_username' => '', 'student_class' => '');
	private $staff_field_array = array('staff_id' => '', 'staff_fn' => '', 'staff_ln' => '', 'staff_username' => '', 'staff_role' => '');
	private $array;
	private $type;
	public function __construct($type, $existing = false, $array = false) {
		$this->type = $type;
		$this->existing = $existing;
		$this->array = $array;
	}
	private function set_add_fields() {//sets the default values for all fields
		if ($this->type == 'student') {
			$this->student_field_array['student_fn'] = $this->array['student_first_name'];
			$this->student_field_array['student_ln'] = $this->array['student_last_name'];
			$this->student_field_array['student_class'] = $this->array['student_class'];
			$this->student_field_array['student_username'] = $this->array['student_username'];
			$this->student_field_array['student_id'] = $this->array['student_id'];
		} else if ($this->type == 'staff') {
			$this->staff_field_array['staff_fn'] = $this->array['staff_first_name'];
			$this->staff_field_array['staff_ln'] = $this->array['staff_last_name'];
			$this->staff_field_array['staff_role'] = $this->array['staff_role'];
			$this->staff_field_array['staff_username'] = $this->array['staff_username'];
			$this->staff_field_array['staff_id'] = $this->array['staff_id'];
		}
	}
	public function dec_addst() {//called in addstudent.php and addstaff.php
		if ($this->type == 'student') {
			$this->set_add_fields();
			function class_options($sel) {
				$array = CLASSES;
				$string = '';
				foreach ($array as $key) {
					$string .= '<option value=\''.$key.'\'';
					if ($key == $sel) {
						$string .= ' selected';
					}
					$string .= '>'.$key.'</option>';
				}
				return $string;
			}
			$student_fn = $this->student_field_array['student_fn'];
			$student_ln = $this->student_field_array['student_ln'];
			$student_class = $this->student_field_array['student_class'];
			$student_username = $this->student_field_array['student_username'];
			$student_id = $this->student_field_array['student_id'];
			$string = '<p><label>Student\'s first name: </label><input type=\'text\' name=\'student_first_name\' value=\''.$student_fn.'\' maxlength=\'20\' /></p>';
			$string .= '<p><label>Student\'s last name: </label><input type=\'text\' name=\'student_last_name\' value=\''.$student_ln.'\' maxlength=\'25\' /></p>';
			$string .= '<p><label>Student\'s username: </label><input type=\'text\' name=\'student_username\' value=\''.$student_username.'\' maxlength=\'12\' /></p>';
			$string .= '<p><label>Students\'s class: </label><select name=\'student_class\'>';
			$string .= '<option value=\'\'>---</option>';
			$string .= class_options($this->student_field_array['student_class']);
			$string .= '</select></p>';
			$string .= '<input type=\'hidden\' name=\'type\' value=\'student\' />';
			$string .= '<input type=\'hidden\' name=\'existing\' value=\''.$this->existing.'\' />';
			$string .= '<input type=\'hidden\' name=\'id\' value=\''.$student_id.'\' />';
			$string .= '<p><input type=\'submit\' name=\'addst_submit\' value=\'Add student\'></p>';
		} else if ($this->type == 'staff') {
			$this->set_add_fields();
			function role_options($sel) {
				$array = ROLES;
				$string = '';
				foreach ($array as $key) {
					$string .= '<option value=\''.$key.'\'';
					if ($key == $sel) {
						$string .= ' selected';
					}
					$string .= '>'.$key.'</option>';
				}
				return $string;
			}
			$staff_fn = $this->staff_field_array['staff_fn'];
			$staff_ln = $this->staff_field_array['staff_ln'];
			$staff_role = $this->staff_field_array['staff_role'];
			$staff_username = $this->staff_field_array['staff_username'];
			$staff_id = $this->staff_field_array['staff_id'];
			$string = '<p><label>Staff\'s first name: </label><input type=\'text\' name=\'staff_first_name\' value=\''.$staff_fn.'\' maxlength=\'20\' /></p>';
			$string .= '<p><label>Staff\'s last name: </label><input type=\'text\' name=\'staff_last_name\' value=\''.$staff_ln.'\' maxlength=\'25\' /></p>';
			$string .= '<p><label>Staff\'s username: </label><input type=\'text\' name=\'staff_username\' value=\''.$staff_username.'\' maxlength=\'12\' /></p>';
			$string .= '<p><label>Staff\'s role: </label><select name=\'staff_role\'>';
			$string .= '<option value=\'\'>---</option>';
			$string .= role_options($staff_role);
			$string .= '</select></p>';
			$string .= '<input type=\'hidden\' name=\'type\' value=\'staff\' />';
			$string .= '<input type=\'hidden\' name=\'existing\' value=\''.$this->existing.'\' />';
			$string .= '<input type=\'hidden\' name=\'id\' value=\''.$staff_id.'\' />';
			$string .= '<p><input type=\'submit\' name=\'addst_submit\' value=\'Add staff\'></p>';
		}
		return $string;
	}
}
class Dec_Editst_Bio {//shows the staff of student add form
	private $type;
	private $existing;
	private $array;
	private $student_field_array = array('student_id' => '', 'p_name' => '', 'p_phone' => '', 'p_email' => '', 's_dob' => '', 's_address' => '',
		 's_storg' => '', 's_gender' => '', 's_religion' => '', 's_passport' => '');
	private $staff_field_array = array('staff_id' => '', 'staff_phone' => '', 'staff_email' => '', 'staff_dob' => '', 'nok_name' => '', 'nok_phone' => '', 'staff_address' => '', 'staff_storg' => '', 'staff_gender' => '', 'staff_religion' => '', 'staff_passport' => '');
	public function __construct($type, $existing = false, $array = false) {
		$this->type = $type;
		$this->existing = $existing;
		$this->array = $array;
	}
	private function set_add_fields() {//sets default values for all fields
		if ($this->type == 'student') {
			$this->student_field_array['student_id'] = $this->array['student_id'];
			$this->student_field_array['p_name'] = $this->array['parent_name'];
			$this->student_field_array['p_phone'] = $this->array['parent_phone_number'];
			$this->student_field_array['p_email'] = $this->array['parent_email'];
			$this->student_field_array['s_dob'] = $this->array['student_dob'];
			$this->student_field_array['s_address'] = $this->array['student_address'];
			$this->student_field_array['s_storg'] = $this->array['student_storg'];
			$this->student_field_array['s_gender'] = $this->array['student_gender'];
			$this->student_field_array['s_religion'] = $this->array['student_religion'];
			$this->student_field_array['s_passport'] = $this->array['student_passport'];
		} else if ($this->type == 'staff') {
			$this->staff_field_array['staff_id'] = $this->array['staff_id'];
			$this->staff_field_array['staff_phone'] = $this->array['staff_phone_number'];
			$this->staff_field_array['staff_email'] = $this->array['staff_email'];
			$this->staff_field_array['staff_dob'] = $this->array['staff_dob'];
			$this->staff_field_array['nok_name'] = $this->array['nok_name'];
			$this->staff_field_array['nok_phone'] = $this->array['nok_phone_number'];
			$this->staff_field_array['staff_address'] = $this->array['staff_address'];
			$this->staff_field_array['staff_storg'] = $this->array['staff_storg'];
			$this->staff_field_array['staff_gender'] = $this->array['staff_gender'];
			$this->staff_field_array['staff_religion'] = $this->array['staff_religion'];
			$this->staff_field_array['staff_passport'] = $this->array['staff_passport'];
		}
	}
	public function dec_addst_bio() {
		$string = '';
		if ($this->type == 'student') {
			$this->set_add_fields();
			function state_options($sel) {
				$states = array('FCT','ABIA', 'ADAMAWA', 'AKWA IBOM', 'ANAMBRA', 'BAUCHI', 'BAYELSA', 'BENUE', 'BORNO', 'CROSS RIVER', 'DELTA', 'EBONYI','EDO', 'EKITI', 'ENUGU', 'GOMBE', 'IMO', 'JIGAWA', 'KADUNA', 'KANO', 'KATSINA', 'KEBBI', 'KOGI', 'KWARA', 'LAGOS', 'NASARAWA', 'NIGER', 'OGUN', 'ONDO', 'OSUN', 'OYO', 'PLATEAU', 'RIVERS', 'SOKOTO', 'TARABA', 'YOBE', 'ZAMFARA');
				$string = '';
				foreach ($states as $key) {
					$string .= '<option value=\''.$key.'\' ';
					if ($key == $sel) {
						$string .= 'selected';
					}
					$string .= '>'.$key.'</option>';
				}
				return $string;
			}
			function gender_options($sel) {
				$string = '';
				$genders = array('FEMALE', 'MALE');
				foreach ($genders as $key) {
					$string .= '<option value=\''.$key.'\' ';
					if ($key == $sel) {
						$string .= 'selected';
					}
					$string .= '>'.$key.'</option>';
				}
				return $string;
			}
			function religion_options($sel) {
				$religions = array('CHRISTIANITY', 'ISLAM', 'OTHERS');
				$string = '';
				foreach ($religions as $key) {
					$string .= '<option value=\''.$key.'\' ';
					if ($key == $sel) {
						$string .= 'selected';
					}
					$string .= '>'.$key.'</option>';
				}
				return $string;
			}
			$student_id = $this->student_field_array['student_id'];
			$p_name = $this->student_field_array['p_name'];
			$p_phone = $this->student_field_array['p_phone'];
			$p_email = $this->student_field_array['p_email'];
			$s_dob = $this->student_field_array['s_dob'];
			$s_address = $this->student_field_array['s_address'];
			$s_storg = $this->student_field_array['s_storg'];
			$s_gender = $this->student_field_array['s_gender'];
			$s_religion = $this->student_field_array['s_religion'];
			$s_passport = $this->student_field_array['s_passport'];
			$string .= '<p><label>Name of parent / guardian: </label><input type=\'text\' name=\'parent_name\' value=\''.$p_name.'\' maxlength=\'45\' required /></p>';
			$string .= '<p><label>Parent\'s / guardian\'s phone number: </label><input type=\'number\' name=\'parent_phone\' value=\''.$p_phone.'\' maxlength=\'14\' /></p>';
			$string .= '<p><label>Parent\'s / guardian\'s email address (optional): </label><input type=\'email\' name=\'parent_email\' value=\''.$p_email.'\' maxlength=\'35\' /></p>';
			$string .= '<p><label>Student\'s date of birth (yyyy/mm/dd): </label><input type=\'date\' name=\'student_dob\' value=\''.$s_dob.'\'/></p>';
			$string .= '<p><label>Student\'s residential address: </label><textarea name=\'student_address\' cols=\'30\' rows=\'5\' resizeable=\'no\' maxlength=\'100\'>'.$s_address.'</textarea></p>';
			$string .= '<p><label>Student\'s state of origin: </label><select name=\'student_storg\'>';
			$string .= '<option value=\'\'>---</option>';
			$string .= state_options($s_storg);
			$string .= '</select></p>';
			$string .= '<p><label>Student\'s gender: </label><select name=\'student_gender\'>';
			$string .= '<option value=\'\'>---</option>';
			$string .= gender_options($s_gender);
			$string .= '</select></p>';
			$string .= '<p><label>Student\'s religion: </label><select name=\'student_religion\'>';
			$string .= '<option value=\'\'>---</option>';
			$string .= religion_options($s_religion);
			$string .= '</select></p>';
			$string .= '<p><label>Choose a passport file <span class=\'guidelines_icon\'>?</span>';
			$string .= $this->existing ? ' (optional)' : '';
			$string .= ': </label><input type=\'file\' name=\'student_passport\' value=\''.$s_passport.'\' /></p>';
			$string .= '<input type=\'hidden\' name=\'type\' value=\'student\' \>';
			$string .= '<input type=\'hidden\' name=\'existing\' value=\''.$this->existing.'\' />';
			$string .= '<input type=\'hidden\' name=\'id\' value=\''.$student_id.'\' \>';
			$string .= '<p><input type=\'submit\' name=\'editst_submit\' value=\'Add student bio\'></p>';
		} else if ($this->type == 'staff') {
			$this->set_add_fields();
			function state_options($sel) {
				$string = '';
				$states = array('FCT','ABIA', 'ADAMAWA', 'AKWA IBOM', 'ANAMBRA', 'BAUCHI', 'BAYELSA', 'BENUE', 'BORNO', 'CROSS RIVER', 'DELTA', 'EBONYI','EDO', 'EKITI', 'ENUGU', 'GOMBE', 'IMO', 'JIGAWA', 'KADUNA', 'KANO', 'KATSINA', 'KEBBI', 'KOGI', 'KWARA', 'LAGOS', 'NASARAWA', 'NIGER', 'OGUN', 'ONDO', 'OSUN', 'OYO', 'PLATEAU', 'RIVERS', 'SOKOTO', 'TARABA', 'YOBE', 'ZAMFARA');
				foreach ($states as $key) {
					$string .= '<option value=\''.$key.'\' ';
					if ($key == $sel) {
						$string .= 'selected';
					}
					$string .= '>'.$key.'</option>';
				}
				return $string;
			}
			function gender_options($sel) {
				$string = '';
				$genders = array('FEMALE', 'MALE');
				foreach ($genders as $key) {
					$string .= '<option value=\''.$key.'\' ';
					if ($key == $sel) {
						$string .= 'selected';
					}
					$string .= '>'.$key.'</option>';
				}
				return $string;
			}
			function religion_options($sel) {
				$string = '';
				$religions = array('CHRISTIANITY', 'ISLAM', 'OTHERS');
				foreach ($religions as $key) {
					$string .= '<option value=\''.$key.'\' ';
					if ($key == $sel) {
						$string .= 'selected';
					}
					$string .= '>'.$key.'</option>';
				}
				return $string;
			}
			$staff_id = $this->staff_field_array['staff_id'];
			$s_phone = $this->staff_field_array['staff_phone'];
			$s_email = $this->staff_field_array['staff_email'];
			$s_dob = $this->staff_field_array['staff_dob'];
			$n_name = $this->staff_field_array['nok_name'];
			$n_phone = $this->staff_field_array['nok_phone'];
			$s_address = $this->staff_field_array['staff_address'];
			$s_storg = $this->staff_field_array['staff_storg'];
			$s_gender = $this->staff_field_array['staff_gender'];
			$s_religion = $this->staff_field_array['staff_religion'];
			$s_passport = $this->staff_field_array['staff_passport'];
			$string .= '<p><label>Staff\'s phone number: </label><input type=\'number\' name=\'staff_phone\' value=\''.$s_phone.'\' maxlength=\'14\' /></p>';
			$string .= '<p><label>Staff\'s email address: </label><input type=\'email\' name=\'staff_email\' value=\''.$s_email.'\' maxlength=\'35\' /></p>';
			$string .= '<p><label>Staff\'s date of birth (yyyy/mm/dd): </label><input type=\'date\' name=\'staff_dob\' value=\''.$s_dob.'\' maxlength=\'10\' /></p>';
			$string .= '<p><label>Name of next of kin: </label><input type=\'text\' name=\'nok_name\' value=\''.$n_name.'\' maxlength=\'45\' /></p>';
			$string .= '<p><label>Phone number of next of kin: </label><input type=\'number\' name=\'nok_phone\' value=\''.$n_phone.'\' maxlength=\'14\' /></p>';
			$string .= '<p><label>Staff\'s address: </label><textarea name=\'staff_address\' cols=\'30\' rows=\'5\' resizeable=\'no\' maxlength=\'100\'>'.$s_address.'</textarea></p>';
			$string .= '<p><label>Staff\'s state of origin: </label><select name=\'staff_storg\'>';
			$string .= '<option value=\'\'>---</option>';
			$string .= state_options($s_storg);
			$string .= '</select></p>';
			$string .= '<p><label>Staff\'s gender: </label><select name=\'staff_gender\'>';
			$string .= '<option value=\'\'>---</option>';
			$string .= gender_options($s_gender);
			$string .= '</select></p>';
			$string .= '<p><label>Staff\'s religion: </label><select name=\'staff_religion\'>';
			$string .= '<option value=\'\'>---</option>';
			$string .= religion_options($s_religion);
			$string .= '</select></p>';
			$string .= '<p><label>Choose a passport file <span class=\'guidelines_icon\'>?</span>';
			$string .= $this->existing ? ' (optional)' : '';
			$string .= ': </label><input type=\'file\' name=\'staff_passport\' value=\''.$s_passport.'\' /></p>';
			$string .= '<input type=\'hidden\' name=\'type\' value=\'staff\' \>';
			$string .= '<input type=\'hidden\' name=\'existing\' value=\''.$this->existing.'\' />';
			$string .= '<input type=\'hidden\' name=\'id\' value=\''.$staff_id.'\' \>';
			$string .= '<p><input type=\'submit\' name=\'editst_submit\' value=\'Add staff bio\'></p>';
		}
		return $string;
	}
}
class Dec_Student_Delete {//shows student delete form
	public function dec_form() {
		$array = CLASSES;
		$form = '<form method=\'post\' action=\'delete_st.php?type=nt\'>';
		$form .= '<p>INPUT STUDENT\'S USERNAME(S): <input type=\'text\' name=\'input\' />';
		$form .= '<br>(Separate usernames by comma(,) if you want to delete more than one student.)</p>';
		$form .= '<p><input type=\'submit\' value=\'DELETE\' name=\'search_sub\' /></p>';
		$form .= '</form>';
		return $form;
	}
}
class Dec_Staff_Delete {//shows staff delete form
	public function dec_form() {
		$array = ROLES;
		$form = '<form method=\'post\' action=\'delete_st.php?type=fa\'>';
		$form .= '<p>INPUT STAFF\'S USERNAME(S): <input type=\'text\' name=\'input\' />';
		$form .= '<br>(Separate usernames by comma(,) if you want to delete more than one staff.)</p>';
		$form .= '<p><input type=\'submit\' value=\'DELETE\' name=\'search_sub\' /></p>';
		$form .= '</form>';
		return $form;
	}
}
class Dec_Set_Session {//shows set session/term form... instantiated in set_session.php
	private $cur_session;
	private $cur_term;
	public function __construct($sess, $term) {
		$this->cur_session = $sess;
		$this->cur_term = $term;
	}
	public function dec_form() {
		$string = '';
		function session_options($sel) {
			$sess_array = array('2020/2021', '2021/2022', '2022/2023', '2023/2024', '2024/2025', '2025/2026', '2026/2027', '2027/2028', '2028/2029', '2029/2030', '2030/2031');
			$string = '';
			foreach ($sess_array as $key) {
				$string .= '<option value=\''.$key.'\' ';
				if ($key == $sel) {
					$string .= 'selected';
				}
				$string .= '>'.$key.'</option>';
			}
			return $string;
		}
		function term_options($sel) {
			$term_array = array('FIRST TERM', 'SECOND TERM', 'THIRD TERM');
			$string = '';
			foreach ($term_array as $key) {
				$string .= '<option value=\''.$key.'\' ';
				if ($key == $sel) {
					$string .= 'selected';
				}
				$string .= '>'.$key.'</option>';
			}
			return $string;
		}	
		$string .= '<form method=\'post\' action=\'set_session.php\'>';
		$string .= '<p>Please select a session: <select name=\'session\'>';
		$string .= session_options($this->cur_session);
		$string .= '</select></p>';
		$string .= '<p>Please select a term: <select name=\'term\'>';
		$string .= term_options($this->cur_term);
		$string .= '</select></p>';
		$string .= '<p>Please select the date the selected period starts: <input type=\'date\' name=\'start_date\'>';
		$string .= '<p><input type=\'submit\' name=\'sess_submit\' value=\'Set session\' /></p>';
		$string .= '</form>';
		return $string;
	}
}
class Dec_Set_All_Subjects {//shows set all subjects form... instantiated in set_all_subjects.php
	public function dec_form() {
		echo '<form method=\'post\' action=\'./set_all_subjects.php\'>';
		echo '<p>Type in the subjects you want to add to the curriculum into the field below.</p> <p>*Separate subject names by comma(,) if you want to add more than one subject.</p>';
		echo '<p><textarea name=\'all_subjects\' cols=\'40\' rows=\'8\' autofocus></textarea></p>';
		echo '<p><input type=\'submit\' name=\'add_su_sub\' value=\'Add subjects\' /></p>';
		echo '</form>';
	}
}
class Dec_Set_Class_Subjects {//shows set class subject form... instantiated in set_class_subject.php
	private $all_subjects;
	public function __construct($all = false) {
		$this->all_subjects = $all;
	}
	public function dec_classes() {
		$class_array = CLASSES;
		echo '<form method=\'post\' action=\'./set_class_subjects.php\' enctype=\'multipart/form-data\'>';
		echo '<p>PLEASE SELECT A CLASS: <select name=\'class\'>';
		foreach ($class_array as $class) {
			echo '<option value=\''.$class.'\'>'.$class.'</option>';
		}
		echo '</select></p>';
		echo '<p><input type=\'submit\' name=\'show_subjects\' value=\'ADD SUBJECTS\' /></p>';
		echo '</form>';
	}
	public function dec_form($class) {
		echo '<form method=\'post\' action=\'./set_classsubjects.php\' enctype=\'multipart/form-data\'>';
		echo '<p>PLEASE TICK THE SUBJECTS TO BE OFFERED BY THE CLASS SELECTED: </p>';
		echo '<p><strong>NOTE:</strong> Only subjects that are not being offered in '.$_POST['class'].' already are shown below.</p>';
		echo '<p>';
		foreach ($this->all_subjects as $subject) {
			echo '<input type=\'checkbox\' name=\'class_subjects[]\' value=\''.$subject['subject_name'].'\' />'.strtoupper($subject['subject_name']).'<br>';	
		}
		echo '</p>';
		echo '<input type=\'hidden\' name=\'class\' value=\''.$class.'\'>';
		echo '<p><input type=\'submit\' name=\'add_su_sub\' value=\'ADD\' /></p>';
		echo '</form>';
	}
}
class Dec_Set_Class_teacher {//shows set class teacher form... instantiated in set_class_teacher.php
	private $all_teachers;
	private $classes_info;
	public function __construct($all = false, $classes) {
		$this->all_teachers = $all;
		$this->classes_info = $classes;
	}
	public function dec_form() {
		echo '<table>';
		echo '<tr><th>CLASS</th><th>CLASS TEACHER</th></tr>';
		foreach ($this->classes_info as $key) {
			echo '<tr>';
			echo '<td>'.$key['class'].'</td>';
			echo '<td>'.$key['teacher'].'</td>';
			echo '</tr>';
		}
		echo '</table>';
		$class_array = CLASSES;
		echo '<form method=\'post\' action=\'./set_classteacher.php\' enctype=\'multipart/form-data\'>';
		echo '<p>PLEASE SELECT A CLASS: <select name=\'class\'>';
		foreach ($class_array as $class) {
			echo '<option value=\''.$class.'\'>'.$class.'</option>';
		}
		echo '</select></p>';
		echo '<p>PLEASE SELECT A TEACHER: <select name=\'class_teacher_id\'>';
		echo '<option value=\'\'>---</option>';
		foreach ($this->all_teachers as $teacher) {
			echo '<option value=\''.$teacher['staff_id'].'\'>'.$teacher['staff_first_name'].' '.$teacher['staff_last_name'].'</option>';
		}
		echo '</select></p>';
		echo '</p>';
		echo '<p><input type=\'submit\' name=\'add_su_ct\' value=\'ADD\' /></p>';
		echo '</form>';
	}
}
class Dec_Set_Subject_Teacher {//shows set subject teacher form... instantiated in set_subject_teacher.php
	private $all_teachers;
	private $all_subjects;
	private $class;
	public function __construct($class = false, $subjects = false, $teachers = false) {
		$this->class = $class;
		$this->all_subjects = $subjects;
		$this->all_teachers = $teachers;
	}
	public function dec_classes() {
		$class_array = CLASSES;
		echo '<form method=\'post\' action=\'./set_subject_teacher.php\' enctype=\'multipart/form-data\'>';
		echo '<p>PLEASE SELECT A CLASS: <select name=\'class\'>';
		foreach ($class_array as $class) {
			echo '<option value=\''.$class.'\'>'.$class.'</option>';
		}
		echo '</select></p>';
		echo '<p><input type=\'submit\' name=\'show_subjects\' value=\'SET SUBJECT TEACHER\' /></p>';
		echo '</form>';
	}
	private function create_teacher_select($subject, $sel) {
		echo '<select name=\'subjects[]\'>';
		echo '<option value=\''.$subject.'-\'>---</option>';
		foreach ($this->all_teachers as $teacher) {
			echo '<option value=\''.$subject.'-'.$teacher['staff_id'].'\' ';
			if ($teacher['staff_id'] == $sel) echo 'selected';
 			echo '>'.$teacher['staff_first_name'].' '.$teacher['staff_last_name'].'</option>';
		}
		echo '</select>';
	}
	public function dec_form() {
		echo '<form method=\'post\' action=\'set_subjectteacher.php\'>';
		echo '<h3>SET SUBJECT TEACHERS.</h3>';
		echo '<table>';
		echo '<tr><th>SUBJECTS</th><th>SUBJECT TEACHERS</th></tr>';
		foreach ($this->all_subjects as $subject) {
			echo '<tr>';
			echo '<td>'.strtoupper($subject['subject']);
			echo (!$subject['teacher_id']) ? ' (not set)</td>' : '</td>';
			echo '<td>';
			$this->create_teacher_select($subject['subject'], $subject['teacher_id']);
			echo '</td>';
			echo '</tr>';
		}
		echo '<input type=\'hidden\' name=\'class\' value=\''.$this->class.'\'>';
		echo '<tr><td colspan = \'2\'><input type=\'submit\' name=\'sub_teacher_su\' value=\'SET SUBJECT TEACHERS\'></td></tr>';
		echo '</table>';
		echo '</form>';
	}
}
class Dec_Send_Mail {//declares the form to send mail to either staff or students
	private $sender_type;
	private $sender_username;
	public function __construct($sender_type, $sender_user) {
		$this->sender_type = $sender_type;
		$this->sender_username = $sender_user;
	}
	public function dec_type() {
		$sender_type = $this->sender_type;
		$string = '';
		$string .= '<form method=\'post\' action=\'./send_mail.php?pe='.base64_encode($this->sender_type).'&me='.base64_encode($this->sender_username).'\' class=\'select_receipient\'>';
		$string .= '<p>Please select whom you want to send the mail to:</p>';
		if ($sender_type == 'admin' || $sender_type == 'staff') {
			$string .= '<p><input type=\'radio\' name=\'type\' value=\'staff_username\' /><label>Staff (username)</label></p>';
		}
		if ($sender_type == 'admin') {
			$string .= '<p><input type=\'radio\' name=\'type\' value=\'staff_role\' /><label>Staff (role)</label></p>';
		}
		if ($sender_type == 'admin' || $sender_type == 'staff' || $sender_type == 'student') {
			$string .= '<p><input type=\'radio\' name=\'type\' value=\'student_username\' /><label>Student (username)<label></p>';
		}
		if ($sender_type == 'admin') {
			$string .= '<p><input type=\'radio\' name=\'type\' value=\'student_class\' /><label>Students (class)</label></p>';
		}
		if ($sender_type == 'staff') {
			$string .= '<p><input type=\'radio\' name=\'type\' value=\'admin\' /><label>Admin</label></p>';
			$string .= '<p><input type=\'radio\' name=\'type\' value=\'subject_students\' /><label>Subject students</label></p>';
			$string .= '<p><input type=\'radio\' name=\'type\' value=\'class_students\' /><label>Class students</label></p>';
		}
		if ($sender_type == 'student') {
			$string .= '<p><input type=\'radio\' name=\'type\' value=\'subject_teachers\' /><label>Subject teacher</label></p>';
			$string .= '<p><input type=\'radio\' name=\'type\' value=\'class_teacher\' /><label>Class teacher</label></p>';
		}
		$string .= '<p><input type=\'submit\' name=\'send_mail_su\' value=\'Select\' /></p>';
		$string .= '</form>';
		return $string;
	}
	public function dec_form($type, $array = false) {
		$role_array = ROLES;
		$class_array = CLASSES;
		if (isset($_POST['send_mail_su']) && !isset($_POST['type'])) {
			$_SESSION['errors'] = ['Please select a type.'];
			header('location: ./send_mail.php?pe='.base64_encode($this->sender_type).'&me='.base64_encode($this->sender_username));
			die();
		}
		$string = '';
		$string .=  '<form method=\'post\' action=\'./sendmail.php?pe='.base64_encode($this->sender_type).'&me='.base64_encode($this->sender_username).'\' enctype=\'multipart/form-data\' class=\'compose_mail\'>';
		$string .=  '<h4>CREATE MAIL:</h4>';
		switch ($_POST['type']) {
			case 'staff_username':
				$string .=  '<p><label>Staff\'s username(s) <span class=\'guidelines_icon mail_usernames\'>?</span>: </label><input type=\'text\' name=\'receipient\' /></p>';
				break;
			case 'staff_role':
				$string .=  '<input type=\'hidden\' name=\'regarding\' value=\'staff_role\'>';
				$string .=  '<p><label>Staff(s)\'s role: </label><select name=\'receipient\'>';
				$string .=  '<option value=\'\'>---</option>';
				foreach ($role_array as $role) {
					$string .=  '<option value=\''.$role.'\'>'.$role.'</option>';
				}
				$string .=  '</select>';
				$string .=  '</p>';
				break;
			case 'student_username':
				$string .=  '<p><label>Student\'s username(s) <span class=\'guidelines_icon mail_usernames\'>?</span>: </label><input type=\'text\' name=\'receipient\' /></p>';
				break;
			case 'student_class':
				$string .=  '<input type=\'hidden\' name=\'regarding\' value=\'student_class\'>';
				$string .=  '<p><label>Student(s)\'s class: </label><select name=\'receipient\'>';
				$string .=  '<option value=\'\'>---</option>';
				foreach ($class_array as $class) {
					$string .=  '<option value=\''.$class.'\'>'.$class.'</option>';
				}
				$string .=  '</select>';
				$string .=  '</p>';
				break;
			case 'admin':
				$string .=  '<p><label>Receipient: ADMIN. </label><input type=\'hidden\' name=\'receipient\' value=\'admin\' /></p>';
				break;
			case 'subject_students':
				$string .=  '<input type=\'hidden\' name=\'regarding\' value=\'subject_students\'>';
				$string .=  '<p><label>Choose subject: </label><select name=\'receipient\'>';
				$string .=  '<option value=\'\'>---</option>';
				foreach ($array as $class) {
					$string .=  '<option value=\''.$class.'\'>'.$class.'</option>';
				}
				$string .=  '</select>';
				$string .=  '</p>';
				break;
			case 'class_students':
				$string .=  '<input type=\'hidden\' name=\'regarding\' value=\'class_students\'>';
				$string .=  '<p><label>Choose class: </label><select name=\'receipient\'>';
				$string .=  '<option value=\'\'>---</option>';
				foreach ($array as $class) {
					$string .=  '<option value=\''.$class.'\'>'.$class.'</option>';
				}
				$string .=  '</select>';
				$string .=  '</p>';
				break;
			case 'subject_teachers':
				$string .=  '<input type=\'hidden\' name=\'regarding\' value=\'subject_teacher\'>';
				$string .=  '<p><label>Choose a teacher: </label><select name=\'receipient\'>';
				$string .=  '<option value=\'\'>---</option>';
				foreach ($array as $teacher) {
					$string .=  '<option value=\''.$teacher['teacher_username'].'\'>'.$teacher['teacher_name'].' - '.$teacher['subject'].'</option>';
				}
				$string .=  '</select>';
				$string .=  '</p>';
				break;
			case 'class_teacher':
				$string .=  '<input type=\'hidden\' name=\'regarding\' value=\'class_teacher\'>';
				$string .=  '<p><label>Receipient: '.$array[1].'. </label><input type=\'hidden\' name=\'receipient\' value=\''.$array[0].'\' /></p>';
				$string .=  '</p>';
				break;
			default:
				// code...
				break;
		}
		$string .=  '<p><label>Mail title (optional): </label><input type=\'text\' name=\'mail_title\' /></p>';
		$string .=  '<p><label>Message: </label><textarea name=\'mail_message\'></textarea></p>';
		$string .=  '<p><label>Append file(s) <span class=\'guidelines_icon appendage\'>?</span>: </label><input type=\'file\' name=\'appendages[]\' multiple /></p>';
		$string .=  '<input type=\'hidden\' name=\'type\' value=\''.$type.'\'>';
		$string .=  '<p><input type=\'submit\' name=\'send_mail\' value=\'Send mail\' /></p>';
		$string .=  '</form>';
		return $string;
	}
}
class Dec_Add_Results {//declares form to add result   *****
	private $class;
	private $period;
	public function __construct($class, $period) {
		$this->class = $class;
		$this->period = $period;
	}
	public function dec_form() {
		$res_types = array('1ST C.A. TEST', '2ND C.A. TEST', 'ASSIGNMENT', 'EXAMINATION'); 
		echo '<form method=\'post\' action=\'./addresults.php\'>';
		echo '<p>Subject: '.$this->class.'</p>';
		echo '<p>Session: '.$this->period['session'].'</p>';
		echo '<p>Term: '.$this->period['term'].'</p>';
		echo '<p>Select result type: <select name=\'result_type\'>';
		echo '<option value=\'\'>---</option>';
		foreach ($res_types as $type) {
			echo '<option value=\''.$type.'\'>'.$type.'</option>';
		}
		echo '</select></p>';
		echo '<input type=\'hidden\' name=\'session\' value=\''.$this->period['session'].'\' />';
		echo '<input type=\'hidden\' name=\'term\' value=\''.$this->period['term'].'\' />';
		echo '<input type=\'hidden\' name=\'subject_class\' value=\''.$this->class.'\' />';
		echo '<input type=\'submit\' name=\'add_res_sub\' value=\'Add\' />';
		echo '</form>';
	}
}
class Dec_Subjects_Registration {//declares form to register student
	private $classes;
	private $period;
	public function __construct($classes, $period) {
		$this->classes = $classes;
		$this->period = $period;
	}
	public function dec_form() {
		echo '<form method=\'post\' action=\'./students_reg.php\'>';
		echo '<p>SESSION: '.$this->period['session'].'</p>';
		echo '<p>TERM: '.$this->period['term'].'</p>';
		echo '<p>SELECT A CLASS: <select name=\'class\'>';
		echo '<option value=\'\'>---</option>';
		foreach ($this->classes as $class) {
			echo '<option value=\''.$class.'\'>'.$class.'</option>';
		}
		echo '</select></p>';
		echo '<input type=\'hidden\' name=\'session\' value=\''.$this->period['session'].'\' />';
		echo '<input type=\'hidden\' name=\'term\' value=\''.$this->period['term'].'\' />';
		echo '<input type=\'submit\' name=\'sub_reg_sub\' value=\'ADD\' />';
		echo '</form>';
	}
}
class Dec_View_Results {//declares form to view subject result
	private $class;
	private $period;
	public function __construct($class, $period) {
		$this->class = $class;
		$this->period = $period;
	}
	public function dec_form() {
		$string = '';
		$terms = array('FIRST TERM', 'SECOND TERM', 'THIRD TERM'); 
		$string .= '<form method=\'post\' action=\'./spreadsheets.php\'>';
		$string .= '<p>Class: '.$this->class.'</p>';
		$string .= '<p>Session: '.$this->period['session'].'</p>';
		$string .= '<p>Select term: <select name=\'term\'>';
		$string .= '<option value=\'\'>---</option>';
		foreach ($terms as $term) {
			$string .= '<option value=\''.$term.'\'>'.$term.'</option>';
		}
		$string .= '</select></p>';
		$string .= '<input type=\'hidden\' name=\'session\' value=\''.$this->period['session'].'\' />';
		$string .= '<input type=\'hidden\' name=\'subject_class\' value=\''.$this->class.'\' />';
		$string .= '<input type=\'submit\' name=\'view_res_sub\' value=\'View\' />';
		$string .= '</form>';
		return $string;
	}
}
class Dec_Classes_Results {//declares form to view class results
	private $classes;
	private $period;
	public function __construct($classes, $period) {
		$this->classes = $classes;
		$this->period = $period;
	}
 	public function dec_select_subject($class, $subjects) {
		$string = '';
 		$string .= '<form method=\'post\' action=\'./class_results.php\'>';
		$string .= '<p>Select a subject: <select name=\'subject\'>';
		$string .= '<option value=\'\'>---</option>';
		foreach ($subjects as $subject) {
			$string .= '<option value=\''.$subject['subject'].'\'>'.strtoupper($subject['subject']).'</option>';
		}
		$string .= '</select></p>';
		$string .= '<input type=\'hidden\' name=\'class\' value=\''.$class.'\' />';
		$string .= '<input type=\'hidden\' name=\'session\' value=\''.$this->period['session'].'\' />';
		$string .= '<input type=\'submit\' name=\'sel_subject_sub\' value=\'Select\' />';
		$string .= '</form>';
		return $string;
 	}
 	public function dec_select_term($class, $subject, $session) {
		$string = '';
 		$terms = array('FIRST TERM', 'SECOND TERM', 'THIRD TERM');
 		$string .= '<p>Class: '.$class.'.</p>';
 		$string .= '<p>Subject: '.strtoupper($subject).'.</p>';
 		$string .= '<p>Session: '.$session.'.</p>';
 		$string .= '<form method=\'post\' action=\'./spreadsheets.php\'>';
		$string .= '<p>Select a term: <select name=\'term\'>';
		$string .= '<option value=\'\'>---</option>';
		foreach ($terms as $term) {
			$string .= '<option value=\''.$term.'\'>'.$term.'</option>';
		}
		$string .= '</select></p>';
		$string .= '<input type=\'hidden\' name=\'class\' value=\''.$class.'\' />';
		$string .= '<input type=\'hidden\' name=\'subject\' value=\''.$subject.'\' />';
		$string .= '<input type=\'hidden\' name=\'session\' value=\''.$session.'\' />';
		$string .= '<input type=\'submit\' name=\'sel_term_sub\' value=\'View spreadsheet\' />';
		$string .= '</form>';
		return $string;
 	}
}
class Dec_Students_Results {//declares form to view class results
	private $classes;
	private $period;
	public function __construct($classes, $period) {
		$this->classes = $classes;
		$this->period = $period;
	}
	public function dec_select_class() {
		$string = '';
		$string .= '<form method=\'post\' action=\'./student_results.php\'>';
		$string .= '<p>Select a class: <select name=\'class\'>';
		$string .= '<option value=\'\'>---</option>';
		foreach ($this->classes as $class) {
			$string .= '<option value=\''.$class.'\'>'.$class.'</option>';
		}
		$string .= '</select></p>';
		$string .= '<input type=\'submit\' name=\'sel_class_sub\' value=\'Select\' />';
		$string .= '</form>';
		return $string;
	}
 	public function dec_select_student($students, $class) {
		$string = '';
		$string .= '<table>';
		$index = 0;
		foreach ($students as $student) {
			$string .= '<tr>';
			$string .= '<td>'.++$index.'.</td>';
			$name = $student['student_first_name'].' '.$student['student_last_name'];
			$string .= '<td>'.$name.'</td>';
			$string .= '<td>';
			$string .= '<form method=\'post\' action=\'./student_results.php\'>';
			$string .= '<input type=\'hidden\' name=\'student\' value=\''.$student['student_id'].'_'.$name.'\' />';
			$string .= '<input type=\'hidden\' name=\'class\' value=\''.$class.'\' />';
			$string .= '<input type=\'submit\' name=\'sel_student_sub\' value=\'Select\' />';
			$string .= '</form>';
			$string .= '</td>';
			$string .= '<tr>';
		}
		$string .= '</table>';
		return $string;
 	}
 	public function dec_select_period($student_id, $student_name, $sessions, $class) {
		$string = '';
		$terms = array('FIRST TERM', 'SECOND TERM', 'THIRD TERM');
		$string .= '<form method=\'post\' action=\'./result.php\'>';
		$string .= '<p>Student\'s name: '.$student_name.'.</p>';
 		$string .= '<p>Class: '.$class.'.</p>';
		$string .= '<p>Select a session: <select name=\'session\'>';
		$string .= '<option value=\'\'>---</option>';
		foreach ($sessions as $session) {
			$string .= '<option value=\''.$session.'\'';
			if ($this->period['session'] == $session) {
				$string .= ' selected'; 
			}
			$string .= '>'.$session.'</option>';
		}
		$string .= '</select></p>';
		$string .= '<p>Select a term: <select name=\'term\'>';
		$string .= '<option value=\'\'>---</option>';
		foreach ($terms as $term) {
			$string .= '<option value=\''.$term.'\'>'.$term.'</option>';
		}
		$string .= '</select></p>';
		$string .= '<input type=\'hidden\' name=\'class\' value=\''.$class.'\' />';
		$string .= '<input type=\'hidden\' name=\'student_id\' value=\''.$student_id.'\' />';
		$string .= '<input type=\'hidden\' name=\'student_name\' value=\''.$student_name.'\' />';
		$string .= '<input type=\'submit\' name=\'sel_term_sub\' value=\'View result\' />';
		$string .= '</form>';
		return $string;
 	}
 	public function dec_select_sub_term($id, $name, $session, $class) {
 	}
}
class Dec_Publish_Results {//declares form to publish results
	private $classes;
	public function __construct($classes) {
		$this->classes = $classes;
	}
	public function dec_form() {
		$string = '';
		$string .= '<form method=\'post\' action=\'publish_results.php\'>';
		$string .= '<p>Select a class: <select name=\'class\'>';
		$string .= '<option value=\'\'>---</option>';
		foreach ($this->classes as $class) {
			$string .= '<option value=\''.$class.'\'>'.$class.'</option>';
		}
		$string .= '</select></p>';
		$string .= '<input type=\'submit\' name=\'pub_res_sub\' value=\'Select\' />';
		$string .= '</form>';
		return $string;
	}
}
class Dec_Authenticate_Publish {//declares form to authenticate publish results
	private $results;
	public function __construct($res) {
		$this->results = $res;
	}
	public function dec_form() {
		echo '<form method=\'post\' action=\'publishresultsx.php\'>';
		echo '<p>PLEASE INPUT YOUR PASSWORD TO CONTINUE: <input name=\'password\' /></p>';
		echo '<input type=\'hidden\' name=\'result\' value=\''.$this->results.'\'>';
		echo '<p><input type=\'submit\' name=\'authenticate_btn\' value=\'AUTHENTICATE\' /></p>';
		echo '</form>';
	}
}
class Dec_Take_Attendance {//declares form to take attendance
	private $classes;
	public function __construct($classes) {
		$this->classes = $classes;
	}
	public function dec_form() {
		$string = '';
		$string .= '<form method=\'post\' action=\'take_attendance.php\'>';
		$string .= '<p>Select a class: <select name=\'class\'>';
		$string .= '<option value=\'\'>---</option>';
		foreach ($this->classes as $class) {
			$string .= '<option value=\''.$class.'\'>'.$class.'</option>';
		}
		$string .= '</select></p>';
		$string .= '<input type=\'submit\' name=\'take_attend_sub\' value=\'Select\' />';
		$string .= '</form>';
		return $string;
	}
}
class Dec_Promote_Classes {
	private $promoted;
	public function __construct($prom) {
		$this->promoted = $prom;
	}
	public function dec_form() {
		$string = '';
		$class_array = CLASSES;
		$order = ['SSS 3', 'SSS 2', 'SSS 1', 'JSS 3', 'JSS 2', 'JSS 1'];
		$valid_for_promotion = [];
		for ($i = 0; $i < count($order); $i++) {
			$highest = $order[$i];
			$classes = [];
			$all_of_class = 0;
			$all_of_class_promoted = 0;
			foreach ($class_array as $class) {
				if (preg_match('/^'.$highest.'.*/', $class, $classes)) {
					array_push($valid_for_promotion, $classes[0]);
					if (!Database::check_unique_class_role($class, 'students')) $all_of_class++;
				}
			}
			foreach ($this->promoted as $class) {
				if (preg_match('/^'.$highest.'/', $class)) {
					$all_of_class_promoted++;
				}
			}
			if ($all_of_class_promoted < $all_of_class) break;
		}
		$string .= '<form method=\'post\' action=\'./promote_students.php\'>';
		$string .= '<p><em>Note that classes should be promoted in descending order, i.e all SSS 3 classes have to be promoted before any other lower class...</em></p>';
		$string .= '<p><select name=\'class\'>';
		foreach ($valid_for_promotion as $class) {
			$string .= '<option value=\''.$class.'\'>'.$class;
			if (in_array($class, $this->promoted)) {
				$string .= ' -- PROMOTED';
			} else {
				$string .= ' -- NOT PROMOTED';
			}
			$string .= '</option>';
		}
		$string .= '</select></p>';
		$string .= '<p><input type=\'submit\' name=\'promote_sub\' value=\'Select\' /></p>';
		$string .= '</form>';
		return $string;
	}
}
class Dec_Select_View_Student {
	private $classes;
	public function __construct($classes) {
		$this->classes = $classes;
	}
	public function dec_select_class() {
		echo '<form method=\'post\' action=\'./view_student.php\'>';
		echo '<p>SELECT A CLASS: <select name=\'class\'>';
		echo '<option value=\'\'>---</option>';
		foreach ($this->classes as $class) {
			echo '<option value=\''.$class.'\'>'.$class.'</option>';
		}
		echo '</select></p>';
		echo '<p><input type=\'submit\' name=\'sel_class_sub\' value=\'SELECT\' /></p>';
		echo '</form>';
	}
	public function dec_select_student($students) {
		echo '<form method=\'post\' action=\'student_bio.php\'>';
		echo '<p>SELECT A STUDENT: <select name=\'student\'>';
		echo '<option value=\'\'>---</option>';
		foreach ($students as $student) {
			$name = $student['student_first_name'].' '.$student['student_last_name'];
			echo '<option value=\''.$student['student_id'].'\'>'.$name.'</option>';
		}
		echo '</select></p>';
		echo '<p><input type=\'submit\' name=\'sel_student_sub\' value=\'Select\' /></p>';
		echo '</form>';
	}
}
class Dec_Select_Result_Period {
	private $id;
	private $sessions;
	private $period;
	private $class;
	public function __construct($id, $sess, $period, $class) {
		$this->id = $id;
		$this->sessions = $sess;
		$this->period = $period;
		$this->class = $class;
	}
	public function dec_form() {
		$string = '';
		$terms = array('FIRST TERM', 'SECOND TERM', 'THIRD TERM'); 
		$string .= '<div>';
		$string .= '<form method=\'post\' action=\'./result.php\'>';
		$string .= '<p>Select a session: <select name=\'session\'>';
		$string .= '<option value=\'\'>---</option>';
		foreach ($this->sessions as $session) {
			$string .= '<option value=\''.$session.'\' ';
			if ($session == $this->period['session']) $string .= 'selected';
			$string .= '>'.$session.'</option>';
		}
		$string .= '</select></p>';
		$string .= '<p>Select a term: <select name=\'term\'>';
		$string .= '<option value=\'\'>---</option>';
		foreach ($terms as $term) {
			$string .= '<option value=\''.$term.'\' ';
			if ($term == $this->period['term']) $string .= 'selected';
			$string .= '>'.$term.'</option>';
		}
		$string .= '</select></p>';
		$string .= '<input type=\'hidden\' name=\'student_id\' value=\''.$this->id.'\' />';
		$string .= '<input type=\'hidden\' name=\'student_class\' value=\''.$this->class.'\' />';
		$string .= '<p><input type=\'submit\' name=\'sel_period_sub\' value=\'Check result\' /></p>';
		$string .= '</form>';
		$string .= '</div>';
		return $string;
	}
}
class Dec_Write_Comments {
	private $type;
	private $classes;
	public function __construct($type, $classes = false) {
		$this->type = $type;
		if ($this->type == 'class_teacher') {
			$this->classes = $classes;
		} else {
			$this->classes = CLASSES;
		}
	}
	public function dec_select_class() {
		$string = '';
		$string .= '<form method=\'post\' action=\'./write_comments.php\'>';
		$string .= '<p>Select a class: <select name=\'class\'>';
		$string .= '<option value=\'\'>---</option>';
		foreach ($this->classes as $class) {
			$string .= '<option value=\''.$class.'\'>'.$class.'</option>';
		}
		$string .= '</select></p>';
		$string .= '<input type=\'hidden\' name=\'type\' value=\''.$this->type.'\' />';
		$string .= '<p><input type=\'submit\' name=\'sel_class_sub\' value=\'Select\' /></p>';
		$string .= '</form>';
		return $string;
	}
}


// parses text for rendering
function evaluateText(string $text) : string {
	$array = preg_split('/\n/', $text);
	$string = '';
	foreach ($array as $paragraph) {
		$string .= '<p>'.$paragraph.'</p>';
	}
	return $string;
}
?>