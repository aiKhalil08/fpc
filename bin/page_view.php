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
function create_sidebar($array) {
	foreach ($array as $key => $value) {
		echo '<p><a href='.$value.'>'.$key.'</a></p>'."\n";
	}
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
				$array = array('JSS 1A', 'JSS 1B', 'JSS 2A', 'JSS 2B', 'JSS 3A', 'JSS 3B', 'SSS 1 ART', 'SSS 1 COMMERCIAL', 'SSS 1 SCIENCE',
				 'SSS 2 ART', 'SSS 2 COMMERCIAL', 'SSS 2 SCIENCE', 'SSS 3 ART', 'SSS 3 COMMERCIAL', 'SSS 3 SCIENCE');
				foreach ($array as $key) {
					echo '<option value=\''.$key.'\'';
					if ($key == $sel) {
						echo ' selected';
					}
					echo '>'.$key.'</option>';
				}
			}
			$student_fn = $this->student_field_array['student_fn'];
			$student_ln = $this->student_field_array['student_ln'];
			$student_class = $this->student_field_array['student_class'];
			$student_username = $this->student_field_array['student_username'];
			$student_id = $this->student_field_array['student_id'];
			echo '<form method=\'post\' action=\'addst.php\'>';
			echo '<p>STUDENT\'S FIRST NAME: <input type=\'text\' name=\'student_first_name\' value=\''.$student_fn.'\' maxlength=\'20\' /></p>';
			echo '<p>STUDENT\'S LAST NAME: <input type=\'text\' name=\'student_last_name\' value=\''.$student_ln.'\' maxlength=\'25\' /></p>';
			echo '<p>STUDENT\'S USERNAME: <input type=\'text\' name=\'student_username\' value=\''.$student_username.'\' maxlength=\'12\' /></p>';
			echo '<p>STUDENT\'S CLASS: <select name=\'student_class\'>';
			echo '<option value=\'\'>---</option>';
			class_options($this->student_field_array['student_class']);
			echo '</select></p>';
			echo '<input type=\'hidden\' name=\'type\' value=\'student\' />';
			echo '<input type=\'hidden\' name=\'existing\' value=\''.$this->existing.'\' />';
			echo '<input type=\'hidden\' name=\'id\' value=\''.$student_id.'\' />';
			echo '<p><input type=\'submit\' name=\'addst_submit\' value=\'ADD STUDENT\'></p>';
			echo '</form>';
		} else if ($this->type == 'staff') {
			$this->set_add_fields();
			function role_options($sel) {
				$array = array('PRINCIPAL', 'VICE PRINCIPAL', 'TEACHER', 'SECURITY', 'SANITARY PERSONEL', 'OTHERS');
				foreach ($array as $key) {
					echo '<option value=\''.$key.'\'';
					if ($key == $sel) {
						echo ' selected';
					}
					echo '>'.$key.'</option>';
				}
			}
			$staff_fn = $this->staff_field_array['staff_fn'];
			$staff_ln = $this->staff_field_array['staff_ln'];
			$staff_role = $this->staff_field_array['staff_role'];
			$staff_username = $this->staff_field_array['staff_username'];
			$staff_id = $this->staff_field_array['staff_id'];
			echo '<form method=\'post\' action=\'addst.php\'>';
			echo '<p>STAFF\'S FIRST NAME: <input type=\'text\' name=\'staff_first_name\' value=\''.$staff_fn.'\' maxlength=\'20\' /></p>';
			echo '<p>STAFF\'S LAST NAME: <input type=\'text\' name=\'staff_last_name\' value=\''.$staff_ln.'\' maxlength=\'25\' /></p>';
			echo '<p>STAFF\'S USERNAME: <input type=\'text\' name=\'staff_username\' value=\''.$staff_username.'\' maxlength=\'12\' /></p>';
			echo '<p>STAFF\'S ROLE: <select name=\'staff_role\'>';
			echo '<option value=\'\'>---</option>';
			role_options($staff_role);
			echo '</select></p>';
			echo '<input type=\'hidden\' name=\'type\' value=\'staff\' />';
			echo '<input type=\'hidden\' name=\'existing\' value=\''.$this->existing.'\' />';
			echo '<input type=\'hidden\' name=\'id\' value=\''.$staff_id.'\' />';
			echo '<p><input type=\'submit\' name=\'addst_submit\' value=\'ADD STAFF\'></p>';
			echo '</form>';
		}
	}
}
class Dec_Editst_Bio {//shows the staff of student add form
	private $type;
	private $existing;
	private $array;
	private $id;
	private $student_field_array = array('student_id' => '', 'p_name' => '', 'p_phone' => '', 'p_email' => '', 's_dob' => '', 's_address' => '',
		 's_storg' => '', 's_gender' => '', 's_religion' => '', 's_passport' => '');
	private $staff_field_array = array('staff_id' => '', 'staff_phone' => '', 'staff_email' => '', 'staff_dob' => '', 'nok_name' => '', 'nok_phone' => '', 'staff_address' => '', 'staff_storg' => '', 'staff_gender' => '', 'staff_religion' => '', 'staff_passport' => '');
	public function __construct($type, $id, $existing = false, $array = false) {
		$this->type = $type;
		$this->id = $id;
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
		if ($this->type == 'student') {
			$this->set_add_fields();
			function state_options($sel) {
				$states = array('FCT','ABIA', 'ADAMAWA', 'AKWA IBOM', 'ANAMBRA', 'BAUCHI', 'BAYELSA', 'BENUE', 'BORNO', 'CROSS RIVER', 'DELTA', 'EBONYI','EDO', 'EKITI', 'ENUGU', 'GOMBE', 'IMO', 'JIGAWA', 'KADUNA', 'KANO', 'KATSINA', 'KEBBI', 'KOGI', 'KWARA', 'LAGOS', 'NASARAWA', 'NIGER', 'OGUN', 'ONDO', 'OSUN', 'OYO', 'PLATEAU', 'RIVERS', 'SOKOTO', 'TARABA', 'YOBE', 'ZAMFARA');
				foreach ($states as $key) {
					echo '<option value=\''.$key.'\' ';
					if ($key == $sel) {
						echo 'selected';
					}
					echo '>'.$key.'</option>';
				}
			}
			function gender_options($sel) {
				$genders = array('FEMALE', 'MALE');
				foreach ($genders as $key) {
					echo '<option value=\''.$key.'\' ';
					if ($key == $sel) {
						echo 'selected';
					}
					echo '>'.$key.'</option>';
				}
			}
			function religion_options($sel) {
				$religions = array('ISLAM', 'CHRISTIANITY', 'OTHERS');
				foreach ($religions as $key) {
					echo '<option value=\''.$key.'\' ';
					if ($key == $sel) {
						echo 'selected';
					}
					echo '>'.$key.'</option>';
				}
			}
			$student_id = $this->id;
			$p_name = $this->student_field_array['p_name'];
			$p_phone = $this->student_field_array['p_phone'];
			$p_email = $this->student_field_array['p_email'];
			$s_dob = $this->student_field_array['s_dob'];
			$s_address = $this->student_field_array['s_address'];
			$s_storg = $this->student_field_array['s_storg'];
			$s_gender = $this->student_field_array['s_gender'];
			$s_religion = $this->student_field_array['s_religion'];
			$s_passport = $this->student_field_array['s_passport'];
			echo '<form method=\'post\' action=\'editst_bio.php\' enctype=\'multipart/form-data\'>';
			echo '<p>NAME OF PARENT/ GUARDIAN: <input type=\'text\' name=\'parent_name\' value=\''.$p_name.'\' maxlength=\'40\' /></p>';
			echo '<p>PARENT\'S OR GUARDIAN\'S PHONE NUMBER: <input type=\'text\' name=\'parent_phone\' value=\''.$p_phone.'\' maxlength=\'14\' /></p>';
			echo '<p>PARENT\'S OR GUARDIAN\'S EMAIL ADDRESS (OPTIONAL): <input type=\'text\' name=\'parent_email\' value=\''.$p_email.'\' maxlength=\'35\' /></p>';
			echo '<p>STUDENT\'S DATE OF BIRTH (yyyy/mm/dd): <input type=\'text\' name=\'student_dob\' value=\''.$s_dob.'\' maxlength=\'10\' /></p>';
			echo '<p>STUDENT\'S RESIDENTIAL ADDRESS: <textarea name=\'student_address\' cols=\'30\' rows=\'5\' resizeable=\'no\' maxlength=\'100\'>'.$s_address.'</textarea></p>';
			echo '<p>STUDENT\'S STATE OF ORIGIN: <select name=\'student_storg\'>';
			echo '<option value=\'\'>---</option>';
			state_options($s_storg);
			echo '</select></p>';
			echo '<p>STUDENT\'S GENDER: <select name=\'student_gender\'>';
			echo '<option value=\'\'>---</option>';
			gender_options($s_gender);
			echo '</select></p>';
			echo '<p>STUDENT\'S RELIGION: <select name=\'student_religion\'>';
			echo '<option value=\'\'>---</option>';
			religion_options($s_religion);
			echo '</select></p>';
			echo '<p>CHOOSE A PASSPORT FILE: <input type=\'file\' name=\'student_passport\' value=\''.$s_passport.'\' /></p>';
			echo '<input type=\'hidden\' name=\'type\' value=\'student\' \>';
			echo '<input type=\'hidden\' name=\'existing\' value=\''.$this->existing.'\' />';
			echo '<input type=\'hidden\' name=\'id\' value=\''.$student_id.'\' \>';
			echo '<p><input type=\'submit\' name=\'editst_submit\' value=\'EDIT STUDENT\'></p>';
			echo '</form>';
		} else if ($this->type == 'staff') {
			$this->set_add_fields();
			function state_options($sel) {
				$states = array('FCT','ABIA', 'ADAMAWA', 'AKWA IBOM', 'ANAMBRA', 'BAUCHI', 'BAYELSA', 'BENUE', 'BORNO', 'CROSS RIVER', 'DELTA', 'EBONYI','EDO', 'EKITI', 'ENUGU', 'GOMBE', 'IMO', 'JIGAWA', 'KADUNA', 'KANO', 'KATSINA', 'KEBBI', 'KOGI', 'KWARA', 'LAGOS', 'NASARAWA', 'NIGER', 'OGUN', 'ONDO', 'OSUN', 'OYO', 'PLATEAU', 'RIVERS', 'SOKOTO', 'TARABA', 'YOBE', 'ZAMFARA');
				foreach ($states as $key) {
					echo '<option value=\''.$key.'\' ';
					if ($key == $sel) {
						echo 'selected';
					}
					echo '>'.$key.'</option>';
				}
			}
			function gender_options($sel) {
				$genders = array('FEMALE', 'MALE');
				foreach ($genders as $key) {
					echo '<option value=\''.$key.'\' ';
					if ($key == $sel) {
						echo 'selected';
					}
					echo '>'.$key.'</option>';
				}
			}
			function religion_options($sel) {
				$religions = array('ISLAM', 'CHRISTIANITY', 'OTHERS');
				foreach ($religions as $key) {
					echo '<option value=\''.$key.'\' ';
					if ($key == $sel) {
						echo 'selected';
					}
					echo '>'.$key.'</option>';
				}
			}
			$staff_id = $this->id;
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
			echo '<form method=\'post\' action=\'editst_bio.php\' enctype=\'multipart/form-data\'>';
			echo '<p>STAFF\'S PHONE NUMBER: <input type=\'text\' name=\'staff_phone\' value=\''.$s_phone.'\' maxlength=\'14\' /></p>';
			echo '<p>STAFF\'S EMAIL ADDRESS: <input type=\'text\' name=\'staff_email\' value=\''.$s_email.'\' maxlength=\'35\' /></p>';
			echo '<p>STAFF\'S DATE OF BIRTH (yyyy/mm/dd): <input type=\'text\' name=\'staff_dob\' value=\''.$s_dob.'\' maxlength=\'10\' /></p>';
			echo '<p>NAME OF NEXT OF KIN: <input type=\'text\' name=\'nok_name\' value=\''.$n_name.'\' maxlength=\'45\' /></p>';
			echo '<p>PHONE NUMBER OF NEXT OF KIN: <input type=\'text\' name=\'nok_phone\' value=\''.$n_phone.'\' maxlength=\'14\' /></p>';
			echo '<p>STAFF\'S ADDRESS: <textarea name=\'staff_address\' cols=\'30\' rows=\'5\' resizeable=\'no\' maxlength=\'100\'>'.$s_address.'</textarea></p>';
			echo '<p>STAFF\'S STATE OF ORIGIN: <select name=\'staff_storg\'>';
			echo '<option value=\'\'>---</option>';
			state_options($s_storg);
			echo '</select></p>';
			echo '<p>STAFF\'S GENDER: <select name=\'staff_gender\'>';
			echo '<option value=\'\'>---</option>';
			gender_options($s_gender);
			echo '</select></p>';
			echo '<p>STAFF\'S RELIGION: <select name=\'staff_religion\'>';
			echo '<option value=\'\'>---</option>';
			religion_options($s_religion);
			echo '</select></p>';
			echo '<p>CHOOSE A PASSPORT FILE: <input type=\'file\' name=\'staff_passport\' value=\''.$s_passport.'\' /></p>';
			echo '<input type=\'hidden\' name=\'type\' value=\'staff\' \>';
			echo '<input type=\'hidden\' name=\'existing\' value=\''.$this->existing.'\' />';
			echo '<input type=\'hidden\' name=\'id\' value=\''.$staff_id.'\' \>';
			echo '<p><input type=\'submit\' name=\'editst_submit\' value=\'EDIT STAFF\'></p>';
			echo '</form>';
		}
	}
}
class Dec_Student_Search {//shows student search form
	private $method;
	public function __construct($type) {
		$this->method = $type;
	}
	public function dec_form() {
		$array = array('JSS 1A', 'JSS 1B', 'JSS 2A', 'JSS 2B', 'JSS 3A', 'JSS 3B', 'SSS 1 ART', 'SSS 1 COMMERCIAL', 'SSS 1 SCIENCE',
		 'SSS 2 ART', 'SSS 2 COMMERCIAL', 'SSS 2 SCIENCE', 'SSS 3 ART', 'SSS 3 COMMERCIAL', 'SSS 3 SCIENCE');
		if ($this->method == 'class') {
			$method = 'lc';
		} else if ($this->method == 'surname') {
			$method = 'us';
		}
		$form = '<form method=\'post\' action=\'search_st.php?type=nt&method='.$method.'\'>';
		switch ($this->method) {
			case 'class':
				$form .= '<p>CHOOSE STUDENT\'S CLASS: <select name=\'class_role\'>';
				foreach ($array as $key) {
					$form .= '<option value=\''.$key.'\'>'.$key.'</option>';
				}
				$form .= '</select></p>';
				break;
			case 'surname':
				$form .= '<p>INPUT STUDENT\'S SURNAME: <input type=\'text\' name=\'surname\' /></p>';
				break;
			default:
				break;
		}
		$form .= '<p><input type=\'submit\' value=\'SEARCH\' name=\'search_sub\' /></p>';
		$form .= '</form>';
		return $form;
	}
}
class Dec_Staff_Search {//shows staff search form
	private $method;
	public function __construct($type) {
		$this->method = $type;
	}
	public function dec_form() {
		$array = array('PRINCIPAL', 'VICE PRINCIPAL', 'TEACHER', 'SECURITY', 'SANITARY PERSONEL', 'OTHERS');
		if ($this->method == 'role') {
			$method = 'or';
		} else if ($this->method == 'surname') {
			$method = 'us';
		}
		$form = '<form method=\'post\' action=\'search_st.php?type=fa&method='.$method.'\'>';
		switch ($this->method) {
			case 'role':
				$form .= '<p>CHOOSE STAFF\'S ROLE: <select name=\'class_role\'>';
				foreach ($array as $key) {
					$form .= '<option value=\''.$key.'\'>'.$key.'</option>';
				}
				$form .= '</select></p>';
				break;
			case 'surname':
				$form .= '<p>INPUT STAFF\'S SURNAME: <input type=\'text\' name=\'surname\' /></p>';
				break;
			default:
				break;
		}
		$form .= '<p><input type=\'submit\' value=\'SEARCH\' name=\'search_sub\' /></p>';
		$form .= '</form>';
		return $form;
	}
}
class Dec_Student_Delete {//shows student delete form
	public function dec_form() {
		$array = array('JSS 1A', 'JSS 1B', 'JSS 2A', 'JSS 2B', 'JSS 3A', 'JSS 3B', 'SSS 1 ART', 'SSS 1 COMMERCIAL', 'SSS 1 SCIENCE',
		 'SSS 2 ART', 'SSS 2 COMMERCIAL', 'SSS 2 SCIENCE', 'SSS 3 ART', 'SSS 3 COMMERCIAL', 'SSS 3 SCIENCE');
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
		$array = array('PRINCIPAL', 'VICE PRINCIPAL', 'TEACHER', 'SECURITY', 'SANITARY PERSONEL', 'OTHERS');
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
		function session_options($sel) {
			$sess_array = array('2020/2021', '2021/2022', '2022/2023', '2023/2024', '2024/2025', '2025/2026', '2026/2027', '2027/2028', '2028/2029', '2029/2030');
			foreach ($sess_array as $key) {
				echo '<option value=\''.$key.'\' ';
				if ($key == $sel) {
					echo 'selected';
				}
				echo '>'.$key.'</option>';
			}
		}
		function term_options($sel) {
			$term_array = array('FIRST TERM', 'SECOND TERM', 'THIRD TERM');
			foreach ($term_array as $key) {
				echo '<option value=\''.$key.'\' ';
				if ($key == $sel) {
					echo 'selected';
				}
				echo '>'.$key.'</option>';
			}
		}	
		echo '<form method=\'post\' action=\'set_sess.php\'>';
		echo '<p>PLEASE SELECT A SESSION: <select name=\'session\'>';
		session_options($this->cur_session);
		echo '</select></p>';
		echo '<p>PLEASE SELECT A TERM: <select name=\'term\'>';
		term_options($this->cur_term);
		echo '</select></p>';
		echo '<p><input type=\'submit\' name=\'sess_submit\' value=\'SET SESSION\' /></p>';
		echo '</form>';
	}
}
class Dec_Set_All_Subjects {//shows set all subjects form... instantiated in set_all_subjects.php
	public function dec_form() {
		echo '<form method=\'post\' action=\'./set_allsubjects.php\'>';
		echo '<p>TYPE IN THE SUBJECTS YOU WANT TO ADD TO THE DATABASE: ';
		echo '<textarea name=\'all_subjects\' cols=\'50\' rows=\'10\'></textarea>';
		echo '<br>(Separate subject names by comma(,) if you want to add more than one subjects.)</p>';
		echo '<p><input type=\'submit\' name=\'add_su_sub\' value=\'ADD SUBJECTS\' /></p>';
		echo '</form>';
	}
}
class Dec_Set_Class_Subjects {//shows set class subject form... instantiated in set_class_subject.php
	private $all_subjects;
	public function __construct($all = false) {
		$this->all_subjects = $all;
	}
	public function dec_classes() {
		$class_array = array('JSS 1', 'JSS 2', 'JSS 3', 'SSS 1 ART', 'SSS 1 COMMERCIAL', 'SSS 1 SCIENCE',
		 'SSS 2 ART', 'SSS 2 COMMERCIAL', 'SSS 2 SCIENCE', 'SSS 3 ART', 'SSS 3 COMMERCIAL', 'SSS 3 SCIENCE');
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
		$class_array = array('JSS 1A', 'JSS 1B', 'JSS 2A', 'JSS 2B', 'JSS 3A', 'JSS 3B', 'SSS 1 ART', 'SSS 1 COMMERCIAL', 'SSS 1 SCIENCE', 'SSS 2 ART', 'SSS 2 COMMERCIAL', 'SSS 2 SCIENCE', 'SSS 3 ART', 'SSS 3 COMMERCIAL', 'SSS 3 SCIENCE');
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
		$class_array = array('JSS 1', 'JSS 2', 'JSS 3', 'SSS 1 ART', 'SSS 1 COMMERCIAL', 'SSS 1 SCIENCE',
		 'SSS 2 ART', 'SSS 2 COMMERCIAL', 'SSS 2 SCIENCE', 'SSS 3 ART', 'SSS 3 COMMERCIAL', 'SSS 3 SCIENCE');
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
		$sender_type = base64_decode($this->sender_type);
		echo '<form method=\'post\' action=\'./send_mail.php?pe='.$this->sender_type.'&me='.$this->sender_username.'\'>';
		echo '<h4>PLEASE SELECT WHO YOU WANT TO SEND MAIL TO:</h4>';
		if ($sender_type == 'admin' || $sender_type == 'staff') {
			echo '<p><input type=\'radio\' name=\'type\' value=\'staff_username\' />STAFF(USERNAME)</p>';
		}
		if ($sender_type == 'admin') {
			echo '<p><input type=\'radio\' name=\'type\' value=\'staff_role\' />STAFFS(ROLE)</p>';
		}
		if ($sender_type == 'admin' || $sender_type == 'staff' || $sender_type == 'student') {
			echo '<p><input type=\'radio\' name=\'type\' value=\'student_username\' />STUDENT(USERNAME)</p>';
		}
		if ($sender_type == 'admin') {
			echo '<p><input type=\'radio\' name=\'type\' value=\'student_class\' />STUDENTS(CLASS)</p>';
		}
		if ($sender_type == 'staff') {
			echo '<p><input type=\'radio\' name=\'type\' value=\'admin\' />ADMIN</p>';
			echo '<p><input type=\'radio\' name=\'type\' value=\'subject_students\' />SUBJECT STUDENTS</p>';
			echo '<p><input type=\'radio\' name=\'type\' value=\'class_students\' />CLASS STUDENTS</p>';
		}
		if ($sender_type == 'student') {
			echo '<p><input type=\'radio\' name=\'type\' value=\'subject_teachers\' />SUBJECT TEACHER</p>';
			echo '<p><input type=\'radio\' name=\'type\' value=\'class_teacher\' />CLASS TEACHER</p>';
		}
		echo '<p><input type=\'submit\' name=\'send_mail_su\' value=\'SEND\' /></p>';
		echo '</form>';
	}
	public function dec_form($type, $array = false) {
		$role_array = array('PRINCIPAL', 'VICE PRINCIPAL', 'TEACHER', 'SECURITY', 'SANITARY PERSONEL', 'OTHERS');
		$class_array = array('JSS 1', 'JSS 2', 'JSS 3', 'SSS 1 ART', 'SSS 1 COMMERCIAL', 'SSS 1 SCIENCE',
		 'SSS 2 ART', 'SSS 2 COMMERCIAL', 'SSS 2 SCIENCE', 'SSS 3 ART', 'SSS 3 COMMERCIAL', 'SSS 3 SCIENCE');
		if (isset($_POST['send_mail_su']) && !isset($_POST['type'])) {
			$_SESSION['errors'] = 'PLEASE SELECT A TYPE.';
			header('location: ./send_mail.php?pe='.$this->sender_type.'&me='.$this->sender_username);
			die();
		}
		echo '<form method=\'post\' action=\'./sendmail.php?pe='.$this->sender_type.'&me='.$this->sender_username.'\' enctype=\'multipart/form-data\'>';
		echo '<h4>CREATE MAIL:</h4>';
		switch ($_POST['type']) {
			case 'staff_username':
				echo '<p>STAFF\'S USERNAME(S): <input type=\'text\' name=\'receipient\' /></p>';
				echo '<p><b>Separate usernames by comma if you want to send mail to more than one receipients.</b></p>';
				break;
			case 'staff_role':
				echo '<p>STAFF(S) ROLE: <select name=\'receipient\'>';
				echo '<option value=\'\'>---</option>';
				foreach ($role_array as $role) {
					echo '<option value=\''.$role.'\'>'.$role.'</option>';
				}
				echo '</select>';
				echo '</p>';
				break;
			case 'student_username':
				echo '<p>STUDENT\'S USERNAME(S): <input type=\'text\' name=\'receipient\' /></p>';
				echo '<p><b>Separate usernames by comma if you want to send mail to more than one receipients.</b></p>';
				break;
			case 'student_class':
				echo '<p>STUDENT(S) CLASS: <select name=\'receipient\'>';
				echo '<option value=\'\'>---</option>';
				foreach ($class_array as $class) {
					echo '<option value=\''.$class.'\'>'.$class.'</option>';
				}
				echo '</select>';
				echo '</p>';
				break;
			case 'admin':
				echo '<p>RECEIPIENT: ADMIN. <input type=\'hidden\' name=\'receipient\' value=\'admin\' /></p>';
				break;
			case 'subject_students':
				echo '<p>CHOOSE CLASS: <select name=\'receipient\'>';
				echo '<option value=\'\'>---</option>';
				foreach ($array as $class) {
					echo '<option value=\''.$class.'\'>'.$class.'</option>';
				}
				echo '</select>';
				echo '</p>';
				break;
			case 'class_students':
				echo '<p>CHOOSE CLASS: <select name=\'receipient\'>';
				echo '<option value=\'\'>---</option>';
				foreach ($array as $class) {
					echo '<option value=\''.$class.'\'>'.$class.'</option>';
				}
				echo '</select>';
				echo '</p>';
				break;
			case 'subject_teachers':
				echo '<p>CHOOSE A TEACHER: <select name=\'receipient\'>';
				echo '<option value=\'\'>---</option>';
				foreach ($array as $teacher) {
					echo '<option value=\''.$teacher['teacher_username'].'\'>'.$teacher['teacher_name'].' '.$teacher['subject'].'</option>';
				}
				echo '</select>';
				echo '</p>';
				break;
			case 'class_teacher':
				echo '<p>RECEIPIENT: '.$array[1].'. <input type=\'hidden\' name=\'receipient\' value=\''.$array[0].'\' /></p>';
				echo '</p>';
				break;
			default:
				// code...
				break;
		}
		echo '<p>MAIL TITLE (optional): <input type=\'text\' name=\'mail_title\' /></p>';
		echo '<p>MAIL: <textarea name=\'mail_message\' cols=\'40\' rows=\'10\'></textarea></p>';
		echo '<p>APPEND FILE(S): <input type=\'file\' name=\'appendages[]\' multiple /></p>';
		echo '<p>(Note: you can append up to three files but no single file must be more than 1 mb.)</p>';
		echo '<input type=\'hidden\' name=\'type\' value=\''.$type.'\'>';
		echo '<p><input type=\'submit\' name=\'send_mail\' value=\'SEND MAIL\' /></p>';
		echo '</form>';
	}
}
class Dec_Add_Results {//declares form to add result
	private $classes;
	private $period;
	public function __construct($classes, $period) {
		$this->classes = $classes;
		$this->period = $period;
	}
	public function dec_form() {
		$res_types = array('1ST C.A. TEST', '2ND C.A. TEST', 'ASSIGNMENT', 'EXAMINATION'); 
		echo '<form method=\'post\' action=\'./addresults.php\'>';
		echo '<p>SESSION: '.$this->period['session'].'</p>';
		echo '<p>TERM: '.$this->period['term'].'</p>';
		echo '<p>SELECT A CLASS: <select name=\'subject_class\'>';
		echo '<option value=\'\'>---</option>';
		foreach ($this->classes as $class) {
			echo '<option value=\''.$class.'\'>'.$class.'</option>';
		}
		echo '</select></p>';
		echo '<p>SELECT RESULT TYPE: <select name=\'result_type\'>';
		echo '<option value=\'\'>---</option>';
		foreach ($res_types as $type) {
			echo '<option value=\''.$type.'\'>'.$type.'</option>';
		}
		echo '</select></p>';
		echo '<input type=\'hidden\' name=\'session\' value=\''.$this->period['session'].'\' />';
		echo '<input type=\'hidden\' name=\'term\' value=\''.$this->period['term'].'\' />';
		echo '<input type=\'submit\' name=\'add_res_sub\' value=\'ADD\' />';
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
	private $classes;
	private $period;
	public function __construct($classes, $period) {
		$this->classes = $classes;
		$this->period = $period;
	}
	public function dec_form() {
		$terms = array('FIRST TERM', 'SECOND TERM', 'THIRD TERM'); 
		echo '<form method=\'post\' action=\'./spreadsheets.php\'>';
		echo '<p>SESSION: '.$this->period['session'].'</p>';
		echo '<p>SELECT A CLASS: <select name=\'subject_class\'>';
		echo '<option value=\'\'>---</option>';
		foreach ($this->classes as $class) {
			echo '<option value=\''.$class.'\'>'.$class.'</option>';
		}
		echo '</select></p>';
		echo '<p>SELECT TERM: <select name=\'term\'>';
		echo '<option value=\'\'>---</option>';
		foreach ($terms as $term) {
			echo '<option value=\''.$term.'\'>'.$term.'</option>';
		}
		echo '</select></p>';
		echo '<input type=\'hidden\' name=\'session\' value=\''.$this->period['session'].'\' />';
		echo '<input type=\'submit\' name=\'view_res_sub\' value=\'VIEW\' />';
		echo '</form>';
	}
}
class Dec_Classes_Results {//declares form to view class results
	private $classes;
	private $period;
	public function __construct($classes, $period) {
		$this->classes = $classes;
		$this->period = $period;
	}
	public function dec_select_class() {
		echo '<form method=\'post\' action=\'./class_results.php\'>';
		echo '<p>SELECT A CLASS: <select name=\'class\'>';
		echo '<option value=\'\'>---</option>';
		foreach ($this->classes as $class) {
			echo '<option value=\''.$class.'\'>'.$class.'</option>';
		}
		echo '</select></p>';
		echo '<input type=\'submit\' name=\'sel_class_sub\' value=\'SELECT\' />';
		echo '</form>';
	}
 	public function dec_select_subject($class, $subjects) {
 		echo '<form method=\'post\' action=\'./class_results.php\'>';
		echo '<p>SELECT A SUBJECT: <select name=\'subject\'>';
		echo '<option value=\'\'>---</option>';
		foreach ($subjects as $subject) {
			echo '<option value=\''.$subject['subject'].'\'>'.strtoupper($subject['subject']).'</option>';
		}
		echo '</select></p>';
		echo '<input type=\'hidden\' name=\'class\' value=\''.$class.'\' />';
		echo '<input type=\'hidden\' name=\'session\' value=\''.$this->period['session'].'\' />';
		echo '<input type=\'submit\' name=\'sel_subject_sub\' value=\'SELECT\' />';
		echo '</form>';
 	}
 	public function dec_select_term($class, $subject, $session) {
 		$terms = array('FIRST TERM', 'SECOND TERM', 'THIRD TERM');
 		echo '<p>CLASS: '.$class.'.</p>';
 		echo '<p>SUBJECT: '.strtoupper($subject).'.</p>';
 		echo '<p>SESSION: '.$session.'.</p>';
 		echo '<form method=\'post\' action=\'./spreadsheets.php\'>';
		echo '<p>SELECT A TERM: <select name=\'term\'>';
		echo '<option value=\'\'>---</option>';
		foreach ($terms as $term) {
			echo '<option value=\''.$term.'\'>'.$term.'</option>';
		}
		echo '</select></p>';
		echo '<input type=\'hidden\' name=\'class\' value=\''.$class.'\' />';
		echo '<input type=\'hidden\' name=\'subject\' value=\''.$subject.'\' />';
		echo '<input type=\'hidden\' name=\'session\' value=\''.$session.'\' />';
		echo '<input type=\'submit\' name=\'sel_term_sub\' value=\'VIEW SPREADSHEET\' />';
		echo '</form>';
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
		echo '<form method=\'post\' action=\'./student_results.php\'>';
		echo '<p>SELECT A CLASS: <select name=\'class\'>';
		echo '<option value=\'\'>---</option>';
		foreach ($this->classes as $class) {
			echo '<option value=\''.$class.'\'>'.$class.'</option>';
		}
		echo '</select></p>';
		echo '<input type=\'submit\' name=\'sel_class_sub\' value=\'SELECT\' />';
		echo '</form>';
	}
 	public function dec_select_student($students, $class) {
 		echo '<form method=\'post\' action=\'./student_results.php\'>';
		echo '<p>SELECT A STUDENT: <select name=\'student\'>';
		echo '<option value=\'\'>---</option>';
		foreach ($students as $student) {
			$name = $student['student_first_name'].' '.$student['student_last_name'];
			echo '<option value=\''.$student['student_id'].'_'.$name.'\'>'.strtoupper($name).'</option>';
		}
		echo '</select></p>';
		echo '<input type=\'hidden\' name=\'class\' value=\''.$class.'\' />';
		echo '<input type=\'submit\' name=\'sel_student_sub\' value=\'SELECT\' />';
		echo '</form>';
 	}
 	public function dec_select_session($student_id, $student_name, $sessions, $class) {
 		echo '<form method=\'post\' action=\'./student_results.php\'>';
		echo '<p>SELECT SESSION: <select name=\'session\'>';
		echo '<option value=\'\'>---</option>';
		foreach ($sessions as $session) {
			echo '<option value=\''.$session.'\'';
			if ($this->period['session'] == $session) {
				echo ' selected'; 
			}
			echo '>'.$session.'</option>';
		}
		echo '</select></p>';
		echo '<input type=\'hidden\' name=\'class\' value=\''.$class.'\' />';
		echo '<input type=\'hidden\' name=\'student_id\' value=\''.$student_id.'\' />';
		echo '<input type=\'hidden\' name=\'student_name\' value=\''.$student_name.'\' />';
		echo '<input type=\'submit\' name=\'sel_session_sub\' value=\'SELECT\' />';
		echo '</form>';
 	}
 	public function dec_select_sub_term($id, $name, $session, $class) {
 		$terms = array('FIRST TERM', 'SECOND TERM', 'THIRD TERM');
 		echo '<p>STUDENT\'S NAME: '.$name.'.</p>';
 		echo '<p>CLASS: '.$class.'.</p>';
 		echo '<p>SESSION: '.$session.'.</p>';
 		echo '<form method=\'post\' action=\'./result.php\'>';
		echo '<p>SELECT A TERM: <select name=\'term\'>';
		echo '<option value=\'\'>---</option>';
		foreach ($terms as $term) {
			echo '<option value=\''.$term.'\'>'.$term.'</option>';
		}
		echo '</select></p>';
		echo '<input type=\'hidden\' name=\'student_id\' value=\''.$id.'\' />';
		echo '<input type=\'hidden\' name=\'student_name\' value=\''.$name.'\' />';
		echo '<input type=\'hidden\' name=\'class\' value=\''.$class.'\' />';
		echo '<input type=\'hidden\' name=\'session\' value=\''.$session.'\' />';
		echo '<input type=\'submit\' name=\'sel_term_sub\' value=\'VIEW RESULT\' />';
		echo '</form>';
 	}
}
class Dec_Publish_Results {//declares form to publish results
	private $classes;
	public function __construct($classes) {
		$this->classes = $classes;
	}
	public function dec_form() {
		echo '<form method=\'post\' action=\'publishresults.php\'>';
		echo '<p>SELECT A CLASS: <select name=\'class\'>';
		echo '<option value=\'\'>---</option>';
		foreach ($this->classes as $class) {
			echo '<option value=\''.$class.'\'>'.$class.'</option>';
		}
		echo '</select></p>';
		echo '<input type=\'submit\' name=\'pub_res_sub\' value=\'SELECT\' />';
		echo '</form>';
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
		echo '<form method=\'post\' action=\'mark_attendance.php\'>';
		echo '<p>SELECT A CLASS: <select name=\'class\'>';
		echo '<option value=\'\'>---</option>';
		foreach ($this->classes as $class) {
			echo '<option value=\''.$class.'\'>'.$class.'</option>';
		}
		echo '</select></p>';
		echo '<input type=\'submit\' name=\'take_attend_sub\' value=\'SELECT\' />';
		echo '</form>';
	}
}
class Dec_Promote_Classes {
	private $promoted;
	public function __construct($prom) {
		$this->promoted = $prom;
	}
	public function dec_form() {
		$class_array = array('JSS 1A', 'JSS 1B', 'JSS 2A', 'JSS 2B', 'JSS 3A', 'JSS 3B', 'SSS 1 ART', 'SSS 1 COMMERCIAL', 'SSS 1 SCIENCE', 'SSS 2 ART', 'SSS 2 COMMERCIAL', 'SSS 2 SCIENCE', 'SSS 3 ART', 'SSS 3 COMMERCIAL', 'SSS 3 SCIENCE');
		$classes = array();
		foreach ($class_array as $class) {
			if (!in_array($class, $this->promoted) && !Database::check_unique_class_role($class, 'students')) {
				$classes[] = $class;
			}
		}
		echo '<form method=\'post\' action=\'./promote_studentsx.php\'>';
		echo '<p>NOTE THAT CLASSES ARE PROMOTED IN DESCENDING ORDER. THEREFORE, SSS 3 SHOULD/MUST BE PROMOTED BEFORE SSS 2 AND SSS 2 BEFORE SSS 1 AND SO ON.</p>';
		echo '<p><select name=\'class\'>';
		foreach ($class_array as $class) {
			echo '<option value=\''.$class.'\'>'.$class;
			if (in_array($class, $this->promoted)) {
				echo '- promoted';
			} else {
				echo '- not promoted';
			}
			echo '</option>';
		}
		echo '</select>';
		echo '<p><input type=\'submit\' name=\'promote_sub\' value=\'SELECT\' /></p>';
		echo '</form>';
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
		echo '<p><input type=\'submit\' name=\'sel_student_sub\' value=\'SELECT\' /></p>';
		echo '</form>';
	}
}
class Dec_Select_Result_Period {
	private $id;
	private $sessions;
	private $period;
	private $passport;
	public function __construct($id, $sess, $period, $passport) {
		$this->id = $id;
		$this->sessions = $sess;
		$this->period = $period;
		$this->passport = $passport;
	}
	public function dec_form() {
		$terms = array('FIRST TERM', 'SECOND TERM', 'THIRD TERM'); 
		echo '<div>';
		echo '<form method=\'post\' action=\'./result.php\'>';
		echo '<p>SELECT A SESSION: <select name=\'session\'>';
		echo '<option value=\'\'>---</option>';
		foreach ($this->sessions as $session) {
			echo '<option value=\''.$session.'\' ';
			if ($session == $this->period['session']) echo 'selected';
			echo '>'.$session.'</option>';
		}
		echo '</select></p>';
		echo '<p>SELECT A TERM: <select name=\'term\'>';
		echo '<option value=\'\'>---</option>';
		foreach ($terms as $term) {
			echo '<option value=\''.$term.'\' ';
			if ($term == $this->period['term']) echo 'selected';
			echo '>'.$term.'</option>';
		}
		echo '</select></p>';
		echo '<input type=\'hidden\' name=\'student_id\' value=\''.$this->id.'\' />';
		echo '<input type=\'hidden\' name=\'student_passport\' value=\''.$this->passport.'\' />';
		echo '<p><input type=\'submit\' name=\'sel_period_sub\' value=\'CHECK RESULT\' /></p>';
		echo '</form>';
		echo '</div>';
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
			$this->classes = array('JSS 1A', 'JSS 1B', 'JSS 2A', 'JSS 2B', 'JSS 3A', 'JSS 3B', 'SSS 1 ART', 'SSS 1 COMMERCIAL', 'SSS 1 SCIENCE', 'SSS 2 ART', 'SSS 2 COMMERCIAL', 'SSS 2 SCIENCE', 'SSS 3 ART', 'SSS 3 COMMERCIAL', 'SSS 3 SCIENCE');
		}
	}
	public function dec_select_class() {
		echo '<form method=\'post\' action=\'./write_comments.php\'>';
		echo '<p>SELECT A CLASS: <select name=\'class\'>';
		echo '<option value=\'\'>---</option>';
		foreach ($this->classes as $class) {
			echo '<option value=\''.$class.'\'>'.$class.'</option>';
		}
		echo '</select></p>';
		echo '<input type=\'hidden\' name=\'type\' value=\''.$this->type.'\' />';
		echo '<p><input type=\'submit\' name=\'sel_class_sub\' value=\'SELECT\' /></p>';
		echo '</form>';
	}
}
?>