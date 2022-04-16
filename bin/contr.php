<?php
require_once '../bin/start_session.php';
require '../bin/modellib.php';
require '../bin/errorlib.php';
//the following class sets input errors and the error session
class Error_Reg {
	public static $errors = array();
	public static function set_errors($error) {//adds error messages to the error session
		array_push(self::$errors, $error);
	}
	public static function set_err_session() {//sets a session containing the errors array
		$_SESSION['errors'] = self::$errors;
	}
	public static function check_username($username, $table) {//checks if username already exists
		return Database::check_unique_username($username, $table);
	}
	public static function check_class_role($class_role, $table, $ret = false) {//checks about class or role
		return Database::check_unique_class_role($class_role, $table);
	}
}
//the following class controls login
class AdminLogin {
	private $username;
	private $password;
	private $model;
	public function __construct($username, $password) {
		$this->username = $username;
		$this->password = $password;
	}
	private function parse_input() {//parses inputted username and password
		$this->username = trim($this->username);
		$this->password = trim($this->password);
	}
	private function get_modellib($username, $password) {//returns an object of modellib
		return new Mod_AdminLogin($username, $password);
	}
	private function validate($username, $password) {//checks input validity
		$validate = $this->get_modellib($username, $password);
		$validate->mod_admin_validate();
	}
	public function admin_login() {//contains all login function. called in loginx.php
		if (!empty($this->username)) {
			if (!empty($this->password)) {
				$this->parse_input();
			} else {
				throw new CustomException(debug_backtrace(),'EMPTY PASSWORD FIELD');
			}
		} else {
			throw new CustomException(debug_backtrace(),'EMPTY USERNAME FIELD');
			
		}
		$this->validate($this->username, $this->password);
	}
}
class St_Login {
	private $type;
	private $username;
	private $password;
	public function __construct($type, $username, $password) {
		$this->type = $type;
		$this->username = $username;
		$this->password = $password;
	}
	private function parse_input() {
		if ($this->username == '' || $this->password == '') {
			Error_Reg::set_errors('PLEASE FILL ALL FIELDS.');
		}
		if (Database::check_unique_username($this->username, $this->type.'s')) {
			Error_Reg::set_errors('USERNAME DOES NOT EXIST.');
		}
		if (sizeof(Error_Reg::$errors) > 0) {
			Error_Reg::set_err_session();
			header('location: ./login.php');
			die();
		}
	}
	private function login() {
		try {
			$login = new Mod_St_Login($this->type, $this->username, $this->password);
			$login->st_login();
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			header('location: ./login.php');
			die();
		}
	}
	public function amalg_login() {
		$this->parse_input();
		$this->login();
	}
}
//the following class controls adding or editing students and staffs info and bio
class Addst {//adds or edits students' basic info 
	protected $type;
	protected $first_name;
	protected $last_name;
	protected $username;
	protected $class_role;
	protected $existing;
	protected $id;
	public function __construct($type, $fname, $lname, $uname, $class, $existing = false, $id = false) {//called in addst.php
		$this->type = $type;
		$this->first_name = trim(strtoupper($fname));
		$this->last_name = trim(strtoupper($lname));
		$this->username = trim(strtoupper($uname));
		$this->class_role = trim(strtoupper($class));
		$this->existing = $existing;
		$this->id = $id;
	}
	private function parse_input() {//checks if all inputs are legal
		if ($this->type == 'student') {
			$type = 'STUDENT';
		} else if ($this->type == 'staff') {
			$type = 'STAFF';
		}
		if ($this->type == 'student') {
			$table_type = 'students';
		} else if ($this->type == 'staff') {
			$table_type = 'staffs';
		}
		if ($this->first_name == '' || $this->last_name == '' || $this->class_role == '' || $this->username == '') {
			Error_Reg::set_errors('ALL FIELDS MUST BE FILLED.');
		}
		if (preg_match('/[0-9]/', $this->first_name) || strpos($this->first_name, ' ')) {
			Error_Reg::set_errors($type.'\'S FIRST NAME MUST ONLY CONTAIN LETTERS.');
		}
		if (strlen($this->first_name) > 20) {
			Error_Reg::set_errors($type.'\'S FIRST NAME MUST NOT BE MORE THAN 20 LETTERS.');
		}
		if (preg_match('/[0-9]/', $this->last_name) || strpos($this->last_name, ' ')) {
			Error_Reg::set_errors($type.'\'S LAST NAME MUST ONLY CONTAIN LETTERS.');
		}
		if (strlen($this->last_name) > 25) {
			Error_Reg::set_errors($type.'\'S LAST NAME MUST NOT BE MORE THAN 25 LETTERS.');
		}
		if (strlen($this->username) > 12) {
			Error_Reg::set_errors($type.'\'S USERNAME MUST NOT BE MORE THAN 12 LETTERS.');
		}
		if (!Error_Reg::check_username($this->username, $table_type) && $this->existing == false) {
			Error_Reg::set_errors('A '.$type.' WITH THIS USERNAME ALREADY EXISTS.');
		}
		if (sizeof(Error_Reg::$errors) > 0) {
			Error_Reg::set_err_session();
			if ($this->type == 'student') {
				$location = 'location: ./addstudent.php';
			} else if ($this->type == 'staff') {
				$location = 'location: ./addstaff.php';
			}
			header($location);
			die();
		}
	}
	private function add_to_table() {//connects to Model library
		$add = new Mod_AddSt($this->type, $this->first_name, $this->last_name, $this->username, $this->class_role, $this->existing, $this->id);
		try {
			$add->mod_add_st();
		} catch(CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			if ($this->type == 'student') {
				$location = 'location: ./addstudent.php';
			} else if ($this->type == 'staff') {
				$location = 'location: ./addstaff.php';
			}
			header($location);
			die();
		}
	}
	public function add_st() {//amalgamates all function. called in addst.php
		$this->parse_input();
		$this->add_to_table();
	}
}
class Editst {
	protected static function check_id($id, $table) {//checks if username already exists
		return Database::check_unique_id($id, $table);
	}
}
class Editstudent_bio extends Editst {
	private $student_id;
	private $parent_name;
	private $parent_phone;
	private $parent_email;
	private $student_dob;
	private $student_address;
	private $student_storg;
	private $student_gender;
	private $student_religion;
	private $student_passport;
	private $existing;
	public function __construct($id, $pname, $pphone, $pmail, $dob, $address, $storg, $gender, $religion, $passport, $existing = false) {//called in editst.php
		$this->student_id = $id;
		$this->parent_name = $pname;
		$this->parent_phone = $pphone;
		$this->parent_email = $pmail;
		$this->student_dob = $dob;
		$this->student_address = $address;
		$this->student_storg = $storg;
		$this->student_gender = $gender;
		$this->student_religion = $religion;
		$this->student_passport = $passport;
		$this->existing = $existing;
	}
	private function parse_input() {//checks if all inouts are legal
		$type = 'STUDENT';
		if ($this->student_id == '' 
			|| $this->parent_name == '' 
			|| $this->parent_phone == ''
			|| $this->student_dob == ''
			|| $this->student_address == ''
			|| $this->student_storg == ''
			|| $this->student_gender == ''
			|| $this->student_religion == ''
		) {
			Error_Reg::set_errors('ALL FIELDS MUST BE FILLED.');
		}
		if (!Parent::check_id($this->student_id, 'students_bio') && $this->existing == false) {
			Error_Reg::set_errors('BIO FOR THIS '.$type.' ALREADY EXISTS.');
		}
		if (Parent::check_id($this->student_id, 'students')) {
			Error_Reg::set_errors($type.' DOES NOT EXIST.');
		}
		if (strlen($this->parent_name) > 45) {
			Error_Reg::set_errors('PARENT\'S NAME MUST NOT BE MORE THAN 45 CHARACTERS.');	
		}
		if (preg_match('/[0-9]/', $this->parent_name)) {
			Error_Reg::set_errors('PARENT\'S NAME MUST ONLY CONTAIN LETTERS.');	
		}
		if (strlen($this->parent_phone) > 14) {
			Error_Reg::set_errors('PARENT\'S PHONE NUMBER MUST NOT BE MORE THAN 14 CHARACTERS.');	
		}
		if (preg_match('/[a-z]/i', $this->parent_phone)) {
			Error_Reg::set_errors('PARENT\'S PHONE NUMBER MUST ONLY CONTAIN DIGITS.');	
		}
		if (strlen($this->parent_email) > 35) {
			Error_Reg::set_errors('PARENT\'S EMAIL MUST NOT BE MORE THAN 35 CHARACTERS.');	
		}
		if ($this->parent_email != '' && !preg_match('/@/', $this->parent_email)) {
			Error_Reg::set_errors('PLEASE INPUT A VALID EMAIL ADDRESS.');
		}
		if (preg_match('/[a-z]/i', $this->student_dob)) {
			Error_Reg::set_errors('PLEASE INPUT A VALID DATE.');	
		}
		if (strlen($this->student_address) > 100) {
			Error_Reg::set_errors($type.'\'S ADDRESS MUST NOT BE MORE THAN 100 CHARACTERS.');	
		}
		if (strlen($this->student_storg) > 12) {
			Error_Reg::set_errors($type.'\'S STATE OF ORIGIN MUST NOT BE MORE THAN 12 CHARACTERS.');	
		}
		if (pathinfo($this->student_passport['name'], PATHINFO_EXTENSION) !== 'png' 
			&& pathinfo($this->student_passport['name'], PATHINFO_EXTENSION) !== 'jpg') {
			Error_Reg::set_errors('PASSPORT MUST ONLY BE PNG OR JPG.');
		}
		if ($this->student_passport['size'] > 150000) {
			Error_Reg::set_errors('SIZE OF PASSPORT MUST NOT BE MORE THAN 150KB.');	
		}
		if (sizeof(Error_Reg::$errors) > 0) {
			Error_Reg::set_err_session();
			header('location: ./edit_bio.php?pe=tn&id='.$this->student_id);
			die();
		}
	}
	private function add_to_table() {//connects to Model library
		try {
			$edit_bio = new Mod_Editstudent_Bio(
			$this->student_id, 
			$this->parent_name, 
			$this->parent_phone, 
			$this->parent_email, 
			$this->student_dob, 
			$this->student_address, 
			$this->student_storg, 
			$this->student_gender, 
			$this->student_religion, 
			$this->student_passport,
			$this->existing
			);
			$edit_bio->mod_edit_bio();
		} catch(CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			header('location: ./edit_bio.php?pe=tn&id='.$this->student_id);
			die();
		}
	}
	public function edit_bio() {//amalgamates all function. called in editst.php
		$this->parse_input();
		$this->add_to_table();	
	}
}
class Editstaff_bio extends Editst {
	private $staff_id;
	private $staff_phone;
	private $staff_email;
	private $staff_dob;
	private $nok_name;
	private $nok_phone;
	private $staff_address;
	private $staff_storg;
	private $staff_gender;
	private $staff_religion;
	private $staff_passport;
	private $existing;
	public function __construct($id, $s_phone, $s_email, $s_dob, $n_name, $n_phone, $s_address, $s_storg, $s_gender, $s_religion, $s_passport, $existing = false) {//called in editst.php
		$this->staff_id = $id;
		$this->staff_phone = $s_phone;
		$this->staff_email = $s_email;
		$this->staff_dob = $s_dob;
		$this->nok_name = $n_name;
		$this->nok_phone = $n_phone;
		$this->staff_address = $s_address;
		$this->staff_storg = $s_storg;
		$this->staff_gender = $s_gender;
		$this->staff_religion = $s_religion;
		$this->staff_passport = $s_passport;
		$this->existing = $existing;
	}
	private function parse_input() {//checks if all inouts are legal
		$type = 'STAFF';
		if ($this->staff_id == '' 
			|| $this->staff_phone == '' 
			|| $this->staff_email == ''
			|| $this->staff_dob == ''
			|| $this->nok_name == ''
			|| $this->nok_phone == ''
			|| $this->staff_address == ''
			|| $this->staff_storg == ''
			|| $this->staff_gender == ''
			|| $this->staff_religion == ''
		) {
			Error_Reg::set_errors('ALL FIELDS MUST BE FILLED.');
		}
		if (!Parent::check_id($this->staff_id, 'staffs_bio') && $this->existing == false) {
			Error_Reg::set_errors('BIO FOR THIS '.$type.' ALREADY EXISTS.');
		}
		if (Parent::check_id($this->staff_id, 'staffs')) {
			Error_Reg::set_errors($type.' DOES NOT EXIST.');
		}
		if (strlen($this->nok_name) > 45) {
			Error_Reg::set_errors('NEXT OF KIN\'S NAME MUST NOT BE MORE THAN 45 CHARACTERS.');	
		}
		if (preg_match('/[0-9]/', $this->nok_name)) {
			Error_Reg::set_errors('NEXT OF KIN\'S NAME MUST ONLY CONTAIN LETTERS.');	
		}
		if (strlen($this->staff_phone) > 14) {
			Error_Reg::set_errors($type.'\'S PHONE NUMBER MUST NOT BE MORE THAN 14 CHARACTERS.');	
		}
		if (strlen($this->nok_phone) > 14) {
			Error_Reg::set_errors('NEXT OF KIN\'S PHONE NUMBER MUST NOT BE MORE THAN 14 CHARACTERS.');	
		}
		if (preg_match('/[a-z]/i', $this->staff_phone)) {
			Error_Reg::set_errors($type.'\'S PHONE NUMBER MUST ONLY CONTAIN DIGITS.');	
		}
		if (preg_match('/[a-z]/i', $this->nok_phone)) {
			Error_Reg::set_errors('NEXT OF KIN\'S PHONE NUMBER MUST ONLY CONTAIN DIGITS.');	
		}
		if (strlen($this->staff_email) > 35) {
			Error_Reg::set_errors($type.'\'S EMAIL MUST NOT BE MORE THAN 35 CHARACTERS.');	
		}
		if ($this->staff_email != '' && !preg_match('/@/', $this->staff_email)) {
			Error_Reg::set_errors('PLEASE INPUT A VALID EMAIL ADDRESS.');
		}
		if (preg_match('/[a-z]/i', $this->staff_dob)) {
			Error_Reg::set_errors('PLEASE INPUT A VALID DATE.');	
		}
		if (strlen($this->staff_address) > 100) {
			Error_Reg::set_errors($type.'\'S ADDRESS MUST NOT BE MORE THAN 100 CHARACTERS.');	
		}
		if (strlen($this->staff_storg) > 12) {
			Error_Reg::set_errors($type.'\'S STATE OF ORIGIN MUST NOT BE MORE THAN 12 CHARACTERS.');	
		}
		if (pathinfo($this->staff_passport['name'], PATHINFO_EXTENSION) !== 'png' 
			&& pathinfo($this->staff_passport['name'], PATHINFO_EXTENSION) !== 'jpg') {
			Error_Reg::set_errors('PASSPORT MUST ONLY BE PNG OR JPG.');
		}
		if ($this->staff_passport['size'] > 150000) {
			Error_Reg::set_errors('SIZE OF PASSPORT MUST NOT BE MORE THAN 150KB.');	
		}
		if (sizeof(Error_Reg::$errors) > 0) {
			Error_Reg::set_err_session();
			header('location: ./edit_bio.php?pe=fa&id='.$this->staff_id);
			die();
		}
	}
	private function add_to_table() {//connects to Model library
		try {
			$edit_bio = new Mod_Editstaff_Bio(
			$this->staff_id, 
			$this->staff_phone, 
			$this->staff_email, 
			$this->staff_dob, 
			$this->nok_name, 
			$this->nok_phone,
			$this->staff_address, 
			$this->staff_storg, 
			$this->staff_gender, 
			$this->staff_religion,
			$this->staff_passport,
			$this->existing
			);
			$edit_bio->mod_edit_bio();
		} catch(CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			header('location: ./edit_bio.php?pe=fa&id='.$this->staff_id);
			die();
		}
	}
	public function edit_bio() {//amalgamates all function. called in editst.php
		$this->parse_input();
		$this->add_to_table();	
	}
}
//the following classes handle getting info from db
class Get_Info {
	private $id;
	private $type;
	private $username;
	public function __construct($type, $id, $username = false) {
		$this->id = $id;
		$this->type = $type;
		$this->username = $username;
		if ($this->username) {
			$info = Database::check_unique_username($id, 'students', 1);
			$this->id = $info[$type.'_id'];
		}
	}
	public function get_infof() {
		$conn = Database::connect_db('admin');
		return Database::get_info_from_db($this->type, $conn, $this->id);
	}
}
class Get_Bio {
	private $id;
	private $type;
	public function __construct($type, $id) {
		$this->id = $id;
		$this->type = $type;
	}
	public function get_biof() {
		$conn = Database::connect_db('admin');
		return Database::get_bio_from_db($this->type, $conn, $this->id);
	}
}
class Get_St_InfoBio {//gets basic info and bio from db
	private $id;
	private $type;
	public function __construct($id, $type) {
		$this->id = $id;
		$this->type = $type;
	}
	public function get_infobio() {
		$conn = Database::connect_db('admin');
		return Database::get_info_bio($conn, $this->id, $this->type);
	}
}
class View_St {
	private $type;
	private $id;
	public function __construct($type, $id = false) {
		$this->type = $type;
		$this->id = $id;
	}
	public function retrieve_all() {
		$conn = Database::connect_db('admin');
		return Database::get_all_from_db($conn, $this->type, $this->id);
	}
}
class Get_Info_Class_Role {
	private $class_role;
	private $table;
	public function __construct($class_role, $table) {
		$this->class_role = $class_role;
		$this->table = $table;
	}
	public function get_infof() {
		return Database::check_unique_class_role($this->class_role, $this->table, 1);
	}
}
class Get_Subjects {
	private $class;
	private $offered;
	public function __construct($class, $off = false) {
		$this->class = $class;
		$this->offered = $off;
	}
	public function get_infof() {
		return Database::get_subjects($this->class, $this->offered);
	}
}
class Get_Classes_Info {
	private $class;
	public function __construct($class = false) {
		$this->class = $class;
	}
	public function get_infof() {
		return Database::get_classes_info($this->class);
	}
}
class Get_User {
	private $type;
	private $username;
	public function __construct ($type, $username) {
		$this->type = $type;
		$this->username = $username;
	}
	public function get_userf() {
		$type = base64_decode($this->type);
		$username = base64_decode($this->username);
		$array['type'] = $type;
		$array['username'] = $username;
		return $array; 
	}
}
class Get_Subject_Classes_For_Teacher {
	private $username;
	public function __construct ($username) {
		$this->username = $username;
	}
	public function get() {
		$array = Database::check_subject_teacher($this->username, 1);
		return $array; 
	}
}
class Get_Class_Students_For_Teacher {
	private $username;
	public function __construct ($username) {
		$this->username = $username;
	}
	public function get() {
		$array = Database::check_class_teacher($this->username, 1);
		return $array; 
	}
}
class Get_Subject_Students {
	private $subject_name;
	private $class;
	private $session;
	private $spec;
	public function __construct($name, $class, $sess, $spec = false) {
		$this->subject_name = $name;
		$this->class = $class;
		$this->session = $sess;
		$this->spec = $spec;
	}
	private function get_ids() {
		$ids = Database::get_subject_students($this->subject_name, $this->class, $this->session, 'id', $this->spec);
		return $ids;
	}
	private function get_info($ids) {
		$array = array();
		$index = 0;
		foreach ($ids as $id) {
			$info = Database::check_unique_id($id, 'students', 1);
			$name = $info['student_first_name'].' '.$info['student_last_name'];
			$array[$index]['name'] = $name;
			$array[$index]['id'] = $info['student_id'];
			$index++;
		}
		return $array;
	}
	public function get() {
		$ids = $this->get_ids();
		$array = $this->get_info($ids);
		return $array;
	}
}
class Get_Subjects_Teachers {
	private $username;
	private $subjects;
	private $class;
	public function __construct($username, $class) {
		$this->username = $username;
		$this->class = $class;
		$this->subjects = $this->get_session_subjects();
	}
	private function get_session_subjects() {
		$info = Database::check_unique_username($this->username, 'students', 1);
		$id = $info['student_id'];
		$period = Set_Session::get_cur_sess_term();
		$session = $period['session'];
		$subjects = new Get_Session_Subjects_For_Student($id, $session);
		return $subjects->get_infof();
	}
	public function get_infof() {
		return Database::get_subjects_teachers($this->subjects, $this->class);
	}
}
class Get_Class_Teacher {
	private $class;
	public function __construct($class) {
		$this->class = $class;
	}
	public function get_infof() {
		$id = Database::read_classes('class_name', $this->class, 1);
		$id = $id['class_teacher_id'];
		$info = new Get_Info('staff', $id);
		$info = $info->get_infof();
		$username = $info['staff_username'];
		$name = $info['staff_first_name'].' '.$info['staff_last_name'];
		$array = array($username, $name);
		return $array; 
	}
}
class Get_Session_Subjects_For_Student {
	private $student_id;
	private $session;
	public function __construct($id, $sess) {
		$this->student_id = $id;
		$this->session = $sess;
	}
	public function get_infof() {
		try {
			return XML::get_session_subjects($this->student_id, $this->session);
		} catch(CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			$location = './index.php';
			header('location: '.$location);
			die();
		}
	}
}
//the following classes handle getting info from xmls
class Read_Sessions {
	private $student_id;
	public function __construct($id) {
		$this->student_id = $id;
	}
	public function read() {
		try {
			return XML::get_sessions_for_student($this->student_id);
		} catch(CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			$location = $_SERVER['HTTP_REFERER'];
			header('location: '.$location);
			die();
		}
	}
}
//the following classes handle searching for sts
class Search_St {
	private $type;
	private $method;
	private $input;
	public function __construct($type, $method, $input) {
		$this->type = $type;
		$this->method = $method;
		$this->input = $input;
	}
	private function parse_input() {
		if ($this->input == '') {
			Error_Reg::set_errors('PLEASE FILL THE SEARCH FIELD.');
		}
		if (sizeof(Error_Reg::$errors) > 0) {
			Error_Reg::set_err_session();
			if ($this->type == 'student') {
				if ($this->method == 'class_role') {
					$method = 'lc';
				} else if ($this->method == 'surname') {
					$method = 'us';
				}
				$location = './search_student.php?method='.$method;
			} else if ($this->type == 'staff') {
				if ($this->method == 'class_role') {
					$method = 'or';
				} else if ($this->method == 'surname') {
					$method = 'us';
				}
				$location = './search_staff.php?method='.$method;
			}
			header('location: '.$location);
			die();
		}
	}
	private function search_db() {//connects with modellib
		try {
			$search = new Mod_Search_St($this->type, $this->method, $this->input);
			return $search->mod_search();
		} catch(CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			if ($this->type == 'student') {
				if ($this->method == 'class_role') {
					$method = 'lc';
				} else if ($this->method == 'surname') {
					$method = 'us';
				}
				$location = './search_student.php?method='.$method;
			} else if ($this->type == 'staff') {
				if ($this->method == 'class_role') {
					$method = 'or';
				} else if ($this->method == 'surname') {
					$method = 'us';
				}
				$location = './search_staff.php?method='.$method;
			}
			header('location: '.$location);
			die();
		}
	}
	public function search() {//amalgamates all functions. called in search_st.php
		$this->parse_input();
		return $this->search_db();
	}
}
//the following classes handle deleting for sts
class Delete_St {
	private $type;
	private $input;
	private $multiple = false;
	public function __construct($type, $input) {
		$this->type = $type;
		$this->input = $input;
	}
	private function parse_input() {
		if ($this->input == '') {
			Error_Reg::set_errors('PLEASE FILL ALL FIELDS.');
		}
		if (Error_Reg::check_username($this->input, $this->type.'s')) {
			Error_Reg::set_errors('USERNAME DOES NOT EXIST.');
		}
		if (sizeof(Error_Reg::$errors) > 0) {
			Error_Reg::set_err_session();
			if ($this->type == 'student') {
				$location = './delete_student.php';
			} else if ($this->type == 'staff') {
				$location = './delete_staff.php';
			}
			header('location: '.$location);
			die();
		}
	}
	private function explode_input() {
		if (stripos($this->input, ',')) {
			$this->input = explode(',', $this->input);
			for ($i = 0; $i < sizeof($this->input); $i++) { 
				$this->input[$i] = trim($this->input[$i]);
			}
			$this->multiple = true;
		}
	}
	private function delete_st_from_db() {//connects with modellib
		try {
			$delete = new Mod_Delete_St($this->type, $this->input);
			$delete->mod_delete();
		} catch(CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			if ($this->type == 'student') {
				$location = './delete_student.php';
			} else if ($this->type == 'staff') {
				$location = './delete_staff.php';
			}
			header('location: '.$location);
			die();
		}
	}
	public function show_info() {//called in delete_st.php. Shows info of st to be deleted
		$this->parse_input();
		$this->explode_input();
		if ($this->multiple) {
			for ($i = 0; $i < sizeof($this->input); $i++) {
				$info[] = Database::check_unique_username($this->input[$i], $this->type.'s', 1);
			}
		} else {
			$info = Database::check_unique_username($this->input, $this->type.'s', 1);
		}
		return $info;
	}
	public function delete() {//amalgamates all functions. called in search_st.php
		$this->parse_input();
		$this->delete_st_from_db();
	}
}
//the following classes handle changing session/term
class Set_Session {
	private $input_session;
	private $input_term;
	private $cur_session;
	private $cur_term;
	public function __construct($session = false, $term = false) {
		$this->input_session = $session;
		$this->input_term = $term;
		$period = $this->get_cur_sess_term();
		$this->cur_session = $period['session'];
		$this->cur_term = $period['term'];
	}
	private function parse_input($password) {
		$class_array = array('JSS 1A', 'JSS 1B', 'JSS 2A', 'JSS 2B', 'JSS 3A', 'JSS 3B', 'SSS 1 ART', 'SSS 1 COMMERCIAL', 'SSS 1 SCIENCE', 'SSS 2 ART', 'SSS 2 COMMERCIAL', 'SSS 2 SCIENCE', 'SSS 3 ART', 'SSS 3 COMMERCIAL', 'SSS 3 SCIENCE');
		$promoted = Promote_Students::get_promoted($this->cur_session);
		$error = false;
		foreach ($class_array as $class) {
			if (!in_array($class, $promoted) && !Database::check_unique_class_role($class, 'students')) {
				$error = true;
				break;
			}
		}
		if ($error && $this->input_session != $this->cur_session) {
			Error_Reg::set_errors('PLEASE PROMOTE ALL CLASSES.');
		}
		$new_sess = explode('/', $this->cur_session);
		$one = $new_sess[0];
		$one += 1;
		$two = $new_sess[1];
		$two += 1;
		$new_sess = $one.'/'.$two;
		if ($this->input_session != $this->cur_session) {
			if ($new_sess != $this->input_session) {
				Error_Reg::set_errors('YOU CAN ONLY CHANGE SESSION TO '.$new_sess.'.');
			}
		}
		switch ($this->cur_term) {
			case 'FIRST TERM':
				$next_term = 'SECOND TERM';
				break;
			case 'SECOND TERM':
				$next_term = 'THIRD TERM';
				break;
			case 'THIRD TERM':
				$next_term = 'FIRST TERM';
				break;
			default:
				// code...
				break;
		}
		if ($this->input_term != $next_term) {
			Error_Reg::set_errors('YOU CAN ONLY CHANGE TERM TO '.$next_term.'.');
		}
		if (empty($password)) {
			Error_Reg::set_errors('PLEASE INPUT A PASSWORD.');
		}
		if (md5($password) !== md5($_COOKIE['admin_password'])) {
			Error_Reg::set_errors('PLEASE INPUT A VALID PASSWORD.');
		}
		if (sizeof(Error_Reg::$errors) > 0) {
			Error_Reg::set_err_session();
			header('location: set_session.php');
			die();
		}
	}
	public function get_cur_sess_term() {//gets current session and term from modellib. called in set_sess.php
		try {
			$cur_info = new Mod_Change_Session();
			$info['session'] = $cur_info->get_current_info()['session'];
			$info['term'] = $cur_info->get_current_info()['term'];		
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			header('location: set_session.php');
			die();
		}
		return $info;
	}
	private function set_sess_term() {//connects to modellib
		try {
			$set = new Mod_Change_Session($this->input_session, $this->input_term);
			$set->set_sess();
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			header('location: set_session.php');
			die();
		}
	}
	public function change_sess_term($password) {//amalgamates all methods. called in set_sess.php
		$this->parse_input($password);
		$this->set_sess_term();
	}
}
//the following classes handle setting all subjects/class subjects offered in the school
class Set_Subjects {
	private $subjects;
	public function __construct($subjects) {
		$this->subjects = $subjects;
	}
	private function parse_input() {
		if (empty($this->subjects)) {
			Error_Reg::set_errors('PLEASE INPUT A SUBJECT TO BE ADDED.');
		}
		if (strpos($this->subjects, ';')) {
			Error_Reg::set_errors('PLEASE INPUT A  VALID SUBJECT NAME.');
		}
		if (strpos($this->subjects, ',')) {
			$subjects = explode(',', $this->subjects);
			for ($i = 0; $i < sizeof($subjects); $i++) { 
				$subjects[$i] = trim($subjects[$i]);
			}
		} else {
			$subjects = array(trim($this->subjects));
		}
		if (Database::check_if_subject_exists($subjects)) {
			Error_Reg::set_errors('SUBJECT(S) ALREADY EXISTS IN DATABASE.');
		}
		if (sizeof(Error_Reg::$errors) > 0) {
			Error_Reg::set_err_session();
			header('location: set_all_subjects.php');
			die();
		}
	}
	private function explode_input() {
		if (stripos($this->subjects, ',')) {
			$this->subjects = explode(',', $this->subjects);
			for ($i = 0; $i < sizeof($this->subjects); $i++) { 
				$this->subjects[$i] = trim($this->subjects[$i]);
			}
			$this->multiple = true;
		}
	}
	private function add_subjects() {//connects to modellib
		try {
			$set = new Mod_Add_Subjects($this->subjects);
			$set->add_all_subjects();
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			header('location: set_all_subjects.php');
			die();
		}
	}
	public function amalg_add_subjects() {//amalgamates all methods. called in set_allsubjects.php
		$this->parse_input();
		$this->explode_input();
		$this->add_subjects();
	}
}
class Set_Class_Subjects {
	private $class_subjects;
	private $class;
	public function __construct($class, $subjects) {
		$this->class = $class;
		$this->class_subjects = $subjects;
	}
	private function parse_input() {
		if (!$this->class_subjects) {
			Error_Reg::set_errors('PLEASE TICK THE SUBJECTS YOU WANT TO ADD TO THE CLASS.');
		}
		if (sizeof(Error_Reg::$errors) > 0) {
			Error_Reg::set_err_session();
			header('location: ./set_class_subjects.php');
			die();
		}
	}
	private function add_class_subjects() {//connects to modellib
		try {
			$set = new Mod_Add_Class_Subjects($this->class, $this->class_subjects);
			$set->add_class_subjects();
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			header('location: ./set_class_subjects.php');
			die();
		}
	}
	public function amalg_add_class_subjects() {//amalgamates all methods. called in set_classsubjects.php
		$this->parse_input();
		$this->add_class_subjects();
	}
}
//the following classes handle setting class and subject teachers
class Set_Teacher {
	private $class;
	private $teacher_id;
	private $type;
	private $subject_teachers;
	public function __construct($type, $class, $id) {
		$this->type = $type;
		$this->class = $class;
		if ($this->type == 'class') {
			$this->teacher_id = $id;
		} else if ($this->type == 'subject') {
			$this->subject_teachers = $id;
		}
	}
	private function parse_input() {
		if (!$this->class) {
			Error_Reg::set_errors('PLEASE SELECT A CLASS.');
		}
		//if ($this->type == 'class' && !$this->teacher_id) {
		//	Error_Reg::set_errors('PLEASE SELECT A TEACHER.');
		//}
		//if ((!Database::read_classes('teacher_id', $this->teacher_id)) && (Database::read_classes('teacher_id', $this->teacher_id, 1)['class_name'] != $this->class)) {
		//	Error_Reg::set_errors('TEACHER IS ALREADY A CLASS TEACHER OF ANOTHER CLASS');
		//}
		if (sizeof(Error_Reg::$errors) > 0) {
			Error_Reg::set_err_session();
			if ($this->type == 'class') {
				$location = './set_class_teacher.php';
			} else if ($this->type == 'subject') {
				$location = './set_subject_teacher.php';
			} 
			header('location: '.$location);
			die();
		}
	}
	private function add_teacher() {//connects to modellib
		try {
			if ($this->type == 'class') {
				$set = new Mod_Set_Teacher($this->type, $this->class, $this->teacher_id);
			} else if ($this->type == 'subject') {
				$set = new Mod_Set_Teacher($this->type, $this->class, $this->subject_teachers);
			}
			$set->set_teacher();
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			if ($this->type == 'class') {
				$location = './set_class_teacher.php';
			} else if ($this->type == 'subject') {
				$location = './set_subject_teacher.php';
			} 
			header('location: '.$location);
			die();
		}
	}
	public function amalg_add_teacher() {//amalgamates all methods. called in set_classteacher.php
		$this->parse_input();
		$this->add_teacher();
	}
}
//the following classes handle sending of mails
class Send_Mail {
	private $send_type;
	private $send_username;
	private $rec_type;
	private $st_type;
	private $receipient;
	private $title;
	private $mail;
	private $appendages;
	public function __construct ($sender, $sender_user, $rec_type, $re, $title, $mail, $appendages = false) {
		$this->send_type = $sender;
		$this->send_username = $sender_user;
		$this->rec_type = $rec_type;
		switch ($this->rec_type) {
			case 'staff_username':
				$this->st_type = 'staff';
				break;
			case 'student_username':
				$this->st_type = 'student';
				break;
			default:
				// code...
				break;
		}
		$this->receipient = $re;
		$this->receipient = $this->explode_input();
		$this->title = $title;
		$this->mail = $mail;
		$this->appendages = $appendages;
	}
	private function parse_input() {
		if (empty($this->mail)) {
			Error_Reg::set_errors('PLEASE FILL ALL FILEDS.');
		}
		if ($this->rec_type != 'student_username' && $this->rec_type != 'staff_username' && $this->rec_type != 'admin') {
			foreach ($this->receipient as $receipient) {
				if (empty($receipient)) {
					Error_Reg::set_errors('PLEASE SELECT A RECEIPIENT.');
					break;
				}
			}
		}
		if ($this->rec_type == 'student_username' || $this->rec_type == 'staff_username') {
			foreach ($this->receipient as $receipient) {
				if (Database::check_unique_username($receipient, $this->st_type.'s')) {
					Error_Reg::set_errors(strtoupper('RECEIPIENT DOES NOT EXIST IN DATABASE.'));
					break;
				}	
			}
		}
		//if ($this->appendages != false) {
		//	foreach ($this->appendages['size'] as $size) {
		//		if ($size > 1000000) {
		//			Error_Reg::set_errors('APPENDED FILE MUST NOT BE MORE THAN 1 MB.');
		//			break;
		//		}
		//	}
		//}
		if (sizeof(Error_Reg::$errors) > 0) {
			Error_Reg::set_err_session();
			$location = basename($_SERVER['HTTP_REFERER']);
			header('location: '.$location);
			die();
		}
	}
	private function explode_input() {
		if (strpos($this->receipient, ',')) {
			$array = explode(',', $this->receipient);
			foreach ($array as $key => $value) {
				$array[$key] = trim($value);
			}
		} else {
			$array = array($this->receipient);
		}
		return $array;
	}
	private function send_mailf() {
		try {
			$send = new Mod_Send_Mail($this->send_type, $this->send_username, $this->rec_type, $this->receipient, $this->title, $this->mail, $this->appendages);
			$send->send_mail();
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			$location = basename($_SERVER['HTTP_REFERER']);
			header('location: '.$location);
			die();
		}
	}
	public function amalg_send_mail() {//amalgamtes all functions. called in sendmail.php
		$this->parse_input();
		$this->send_mailf();
	}
}
class View_Mails {
	private $mode;
	private static $type;
	private $username;
	public function __construct($type, $username, $mode = false) {
		self::$type = $type;
		$this->username = $username;
		$this->mode = $mode;
	}
	public function new_mails() {
		$conn = Database::connect_db('admin');
		if (self::$type != 'admin') {
			$info = Database::check_unique_username($this->username, self::$type.'s', 1);
			$id = $info[self::$type.'_id'];
			$username = self::$type.'_'.$id;
			$username = $conn->quote($username);
		} else {
			$username = $conn->quote('admin');
		}
		$sql = 'SELECT counter FROM mails WHERE username = '.$username;
		$count = $conn->query($sql);
		$count = $count->fetch(PDO::FETCH_ASSOC)['counter'];
		return $count;
	}
	public function amalg_view_mails() {//amalgamates all functions. called in sent_mails.php
		try {
			$sent = new Mod_Read_Mails($this->mode, self::$type, $this->username);
			return $sent->ret_mails();
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			header('location: ./index.php');
			die();
		}
	}
}
//the following classes adds results to db
class Add_Results {
	private $ids;
	private $scores;
	private $subject;
	private $class;
	private $session;
	private $term;
	private $res_type;
	public function __construct($ids, $scores, $sub, $class, $sess, $term, $type) {
		$this->ids = $ids;
		$this->scores = $scores;
		$this->subject = $sub;
		$this->class = $class;
		$this->session = $sess;
		$this->term = $term;
		$this->res_type = $type;
	}
	private function parse_input() {
		foreach ($this->scores as $score) {
			if ($score == '') {
				Error_Reg::set_errors('PLEASE INPUT SCORE FOR ALL STUDENTS.');
				break;
			}	
		}
		foreach ($this->scores as $score) {
			if (preg_match('/[a-z]/i', $score)) {
				echo 'what is this';
				Error_Reg::set_errors('ALL SCORES MUST BE INTEGERS.');
				break;
			}	
		}
		foreach ($this->scores as $score) {
			if ($this->res_type == '1ST C.A. TEST' && $score > 15) {
				Error_Reg::set_errors('SCORE INPUTTED BEYOND OBTAINABLE SCORE.');
				break;
			} else if ($this->res_type == '2ND C.A. TEST' && $score > 15) {
				Error_Reg::set_errors('SCORE INPUTTED BEYOND OBTAINABLE SCORE.');
				break;
			} else if ($this->res_type == 'ASSIGNMENT' && $score > 10) {
				Error_Reg::set_errors('SCORE INPUTTED BEYOND OBTAINABLE SCORE.');
				break;
			} else if ($this->res_type == 'EXAMINATION' && $score > 60) {
				Error_Reg::set_errors('SCORE INPUTTED BEYOND OBTAINABLE SCORE.');
				break;
			}
		}
		if (sizeof(Error_Reg::$errors) > 0) {
			Error_Reg::set_err_session();
			header('location: ./add_results.php');
			die();
		}
	}
	private function insert_results() {
		try {
			$add = new Mod_Add_Results($this->ids, $this->scores, $this->subject, $this->class, $this->session, $this->term, $this->res_type);
			$add->add_results();
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
		    Error_Reg::set_err_session();
			header('location: ./add_results.php');
			die();
		}
	}
	public function amalg_add_results() {
		$this->parse_input();
		$this->insert_results();
	}
}
//the following classes updates student to next class in db
class Promote_Students {
	private $type;
	private $students;
	private $current_class;
	private $next_class;
	private $session;
	public function __construct($type, $studs, $cur, $next, $sess) {
		$this->type = $type;
		$this->students = $studs;
		$this->current_class = $cur;
		$this->next_class = $next;
		$this->orig_session = $sess;
		$session = explode('/', $sess);
		$one = $session[0];
		$one += 1;
		$two = $session[1];
		$two += 1;
		$this->session = $one.'/'.$two;
	}
	private function parse_input() {
		$class_array = array('JSS 1A', 'JSS 1B', 'JSS 2A', 'JSS 2B', 'JSS 3A', 'JSS 3B', 'SSS 1 ART', 'SSS 1 COMMERCIAL', 'SSS 1 SCIENCE', 'SSS 2 ART', 'SSS 2 COMMERCIAL', 'SSS 2 SCIENCE', 'SSS 3 ART', 'SSS 3 COMMERCIAL', 'SSS 3 SCIENCE');
		if (empty($this->students)) {
			Error_Reg::set_errors('PLEASE SELECT STUDENTS TO PROMOTE.');
		}
		if (preg_match('/SSS 2/', $this->current_class)) {
			$classes = array_slice($class_array, 12, 3);
		} else if (preg_match('/SSS 1/', $this->current_class)) {
			$classes = array_slice($class_array, 9, 6);
		} else if (preg_match('/JSS 3/', $this->current_class)) {
			$classes = array_slice($class_array, 6, 9);
		} else if (preg_match('/JSS 2/', $this->current_class)) {
			$classes = array_slice($class_array, 4, 11);
		} else if (preg_match('/JSS 1/', $this->current_class)) {
			$classes = array_slice($class_array, 2, 13);
		}
		$promoted = $this->get_promoted($this->orig_session);
		$error = false;
		foreach ($classes as $class) {
			if (!in_array($class, $promoted) && !Database::check_unique_class_role($class, 'students')) {
				$error = true;
				break;
			}
		}
		if ($error) {
			Error_Reg::set_errors('PLEASE PROMOTE ALL PRECEDING CLASSES.');
		}
		if (sizeof(Error_Reg::$errors) > 0) {
			Error_Reg::set_err_session();
			header('location: ./promote_students.php');
			die();
		}
	}
	private function update_class() {
		try {
			$promote = new Mod_Promote_Students($this->type, $this->students, $this->current_class, $this->next_class, $this->session);
			$promote->promote_students();
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			header('location: ./promote_students.php');
			die();
		}
	}
	public function get_promoted($sess) {
		$session = explode('/', $sess);
		$one = $session[0];
		$one += 1;
		$two = $session[1];
		$two += 1;
		$session = $one.'/'.$two;
		try {
			return Mod_Promote_Students::get_promoted_classes($session);
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			header('location: ./promote_students.php');
			die();
		}
	}
	public function amalg_promote_students() {
		$this->parse_input();
		$this->update_class();
	}
}
class Graduate_Students {
	private $type;
	private $students;
	private $current_class;
	private $session;
	private $orig_session;
	public function __construct($type, $studs, $cur, $sess) {
		$this->type = $type;
		$this->students = $studs;
		$this->current_class = $cur;
		$session = explode('/', $sess);
		$one = $session[0];
		$one += 1;
		$two = $session[1];
		$two += 1;
		$this->session = $one.'/'.$two;
		$this->orig_session = $sess;
	}
	private function parse_input() {
		if (empty($this->students)) {
			Error_Reg::set_errors('PLEASE SELECT STUDENTS TO PROMOTE.');
		}
		if (sizeof(Error_Reg::$errors) > 0) {
			Error_Reg::set_err_session();
			header('location: ./promote_students.php');
			die();
		}
	}
	private function graduate_class() {
		try {
			$graduate = new Mod_Graduate_Students($this->type, $this->students, $this->current_class, $this->session, $this->orig_session);
			$graduate->graduate_students();
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			header('location: ./promote_students.php');
			die();
		}
	}
	public function amalg_graduate_students() {
		$this->parse_input();
		$this->graduate_class();
	}
}
//the following classes registers a student for a session
class Register_Student {
	private $subjects;
	private $student_id;
	private $student_class;
	private $session;
	public function __construct($subs, $id, $class, $sess) {
		$this->subjects = $subs;
		$this->student_id = $id;
		$this->student_class = $class;
		$this->session = $sess;
	}
	private function parse_input() {
		if (!$this->subjects) {
			Error_Reg::set_errors('PLEASE CHOOSE THE SUBJECTS TO REGISTER FOR STUDENT.');
		}
		if (sizeof($this->subjects) > 15) {
			Error_Reg::set_errors('YOU CAN\'T REGISTER MORE THAN 15 SUBJECTS FOR STUDENT.');
		}
		if (sizeof(Error_Reg::$errors) > 0) {
			Error_Reg::set_err_session();
			header('location: ./students_regx.php?id='.base64_encode($this->student_id).'&cl='.base64_encode($this->student_class));
			die();
		}
	}
	public function register() {
		try {
			$reg = new Mod_Register_Student($this->subjects, $this->student_id, $this->student_class, $this->session);
			return $reg->register_student();
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			header('location: ./students_regx.php?id='.base64_encode($this->student_id).'&cl='.base64_encode($this->student_class));
			die();
		}
	}
	public function amalg_register_student() {
		$this->parse_input();
		$this->register();
	}
}
class Check_Registered {
	private $students;
	private $session;
	public function __construct($array, $sess) {
		$this->students = $array;
		$this->session = $sess;
	}
	public function check() {
		try {
			$students = new Mod_Check_Registered($this->students, $this->session);
			return $students->check_registered();
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			header('location: ./student_registration.php?id='.base64_encode($this->student_id).'&cl='.base64_encode($this->student_class));
			die();
		}
	}
}
//the following classes checks students results
class Check_Class_Result {
	private $subject;
	private $class;
	private $session;
	private $term;
	private $type;
	private $ret;
	private $class_sub;
	public function __construct($subject, $class, $sess, $term, $type, $ret, $class_sub) {
		$this->subject = $subject;
		$this->class = $class;
		$this->session = $sess;
		$this->term = $term;
		$this->type = $type;
		$this->ret = $ret;
		$this->class_sub = $class_sub;
	}
	private function parse_input() {
		if (basename($_SERVER['HTTP_REFERER']) == 'subject_results.php') {
			if (empty($this->subject) || empty($this->class)) {
				Error_Reg::set_errors('PLEASE SELECT CLASS AND RESULT TYPE.');
			}
			if (empty($this->term)) {
				Error_Reg::set_errors('PLEASE SELECT A TERM.');
			}
		}
		if (sizeof(Error_Reg::$errors) > 0) {
			Error_Reg::set_err_session();
			$location = $_SERVER['HTTP_REFERER'];
			header('location: '.$location);
			die();
		}
	}
	private function get_results() {
		try {
			return Database::check_class_result($this->subject, $this->class, $this->session, $this->term, $this->type, $this->ret, $this->class_sub);
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			$location = $_SERVER['HTTP_REFERER'];
			header('location: '.$location);
			die();
		}
	}
	public function amalg_check_class_result() {
		$this->parse_input();
		return $this->get_results();
	}
}
class Check_Student_Result {
	private $student_id;
	private $session;
	private $term;
	public function __construct($student_id, $sess, $term) {
		$this->student_id = $student_id;
		$this->session = $sess;
		$this->term = $term;
	}
	private function parse_input() {
		if (empty($this->term)) {
			Error_Reg::set_errors('PLEASE SELECT A TERM.');
		}
		if (sizeof(Error_Reg::$errors) > 0) {
			Error_Reg::set_err_session();
			header('location: ./student_results.php');
			die();
		}
	}
	private function get_results() {
		try {
			$result = new Mod_Check_Student_Result($this->student_id, $this->session, $this->term);
			return $result->check_student_result();
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			$location = './student_results.php';
			//header('location: '.$location);
			//die();
		}
	}
	public function amalg_check_student_result() {
		$this->parse_input();
		return $this->get_results();
	}
}
class Get_Unpublished_Results {
	private $class;
	private $cur_session;
	private $cur_term;
	public function __construct($class, $sess, $term) {
		$this->class = $class;
		$this->cur_session = $sess;
		$this->cur_term = $term;
	}
	private function parse_input() {
		if ($this->class == '') {
			Error_Reg::set_errors('PLEASE SELECT A CLASS.');
		}
		if (sizeof(Error_Reg::$errors) > 0) {
			Error_Reg::set_err_session();
			header('location: '.$_SERVER['HTTP_REFERER']);
			die();
		}
	}
	private function get() {
		try {
			$results = new Mod_Get_Unpublished_Results($this->class, $this->cur_session, $this->cur_term);
			return $results->get_unpublished_results();
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			$location = $_SERVER['HTTP_REFERER'];
			header('location: '.$location);
			die();
		}
	}
	public function amalg_get_unpublished_results() {
		$this->parse_input();
		return $this->get();
	}
}
class Publish_Results {
	private $results;
	public function __construct($res) {
		$this->results = $res;
 	}
 	private function parse_input() {
 		if (sizeof($this->results) < 1) {
 			Error_Reg::set_errors('PLEASE SELECT A RESULT TO PUBLISH.');
 		}
 		if (sizeof(Error_Reg::$errors) > 0) {
 			Error_Reg::set_err_session();
 			header('location: ./publish_results.php');
			die();
 		}
 	}
 	private function publish() {
 		try {
			$publish = new Mod_Publish_Results($this->results);
			$publish->publish_results();
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			$location = './publish_results.php';
			header('location: '.$location);
			die();
		}
 	}
 	public function amalg_publish_results() {
 		$this->parse_input();
 		$this->publish();
 	}
}
//the following classes mark students attendance
class Mark_Attendance {
	private $presents;
	private $class;
	private $period;
	public function __construct($pres, $class, $period) {
		$this->presents = $pres;
		$this->class = $class;
		$this->period = $period;
	}
	private function parse_input() {
 		if (sizeof(Error_Reg::$errors) > 0) {
 			Error_Reg::set_err_session();
 			header('location: ./take_attendance.php');
			die();
 		}
 	}
 	private function mark() {
 		try {
			$mark = new Mod_Mark_Attendance($this->presents, $this->class, $this->period);
			$mark->mark_attendance();
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			$location = './take_attendance.php';
			header('location: '.$location);
			die();
		}
 	}
 	public function get_attendance($id, $class, $sess, $term) {
 		return Mod_Mark_Attendance::calculate_attendance($id, $class, $sess, $term);
 	}
 	public function amalg_mark_attendance() {
 		$this->parse_input();
 		$this->mark();
 	}
}
//the following classes writes students comments
class Write_Comments {
	private $student_ids;
	private $comments;
	private $session;
	private $term;
	private $type;
	public function __construct($ids, $comms, $sess, $term, $type) {
		$this->student_ids = $ids;
		$this->comments = $comms;
		$this->session = $sess;
		$this->term = $term;
		$this->type = $type;
	}
	private function parse_input() {
		$status = false;
		foreach ($this->comments as $key => $value) {
			if ($value == '') {
				$status = true;
				break;
			}
		}
		if ($status) {
			Error_Reg::set_errors('PLEASE WRITE COMMENTS FOR ALL STUDENTS.');
		}
		if (sizeof(Error_Reg::$errors) > 0) {
 			Error_Reg::set_err_session();
 			if ($this->type == 'class_teacher') {
 				$location = './write_classteacher_comments.php';
 			} else {
 				$location = './write_classteacher_comments.php';
 			}
 			header('location: '.$location);
			die();
 		}
	}
	private function set_comments_array() {
		$array = array();
		for ($i = 0; $i < sizeof($this->student_ids); $i++) { 
			$array[$i]['student_id'] = $this->student_ids[$i];
			$array[$i]['comment'] = $this->comments[$i];
		}
		return $array;
	}
	private function write() {
		$comments_array = $this->set_comments_array();
 		try {
			$write = new Mod_Write_Comments($comments_array, $this->session, $this->term, $this->type);
			$write->write_comments();
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('SOMETHING WENT WRONG. PLEASE TRY AGAIN LATER.');
			Error_Reg::set_err_session();
			if ($this->type == 'class_teacher') {
 				$location = './write_classteacher_comments.php';
 			} else {
 				$location = './write_classteacher_comments.php';
 			}
 			header('location: '.$location);
			die();
		}
 	}
 	public function get_comments($id, $session, $term) {
 		return Mod_Write_Comments::get_comments($id, $session, $term);
 	}
	public function amalg_write_comments() {
		$this->parse_input();
		$this->write();
	}
}
?>