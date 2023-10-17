<?php
//the following class interracts with db
inthenameofAll
//require '../bin/errorlib.php';
class Database {
	public static function connect_db($type) {//creates a connection with db
		switch ($type) {
			case 'admin':
				$config_file = '../bin/admin_confg.txt';
				break;
			case 'staff':
				$config_file = '../bin/admin_confg.txt';
				break;
			case 'student':
				$config_file = '../bin/admin_confg.txt';
				break;
			case 'blog_user':
				$config_file = '../bin/admin_confg.txt';
				break;
			case 'blog_writer':
				$config_file = '../bin/admin_confg.txt';
				break;
			default:
				throw new CustomException(debug_backtrace(), 'UNKOWN USER TYPE TRYING TO ACCESS DB');
				break;
		}
		$config = parse_ini_file($config_file);
		if (!$conn = new PDO('uri:../bin/fpc_db.dsn', $config['username'], $config['password'])) {
			throw new CustomException(debug_backtrace(), 'UNABLE TO CONNECT TO DATABASE');
		}
		return $conn;
	}
	public static function check_unique_username($username, $table, $ret = false) {//fetchs info using username
		$conn = self::connect_db('admin');
		if ($table == 'students') {
			$column = 'student_username';
		} else if ($table == 'staffs') {
			$column = 'staff_username';
		}
		$sql_statement = 'SELECT * FROM '.$table.' WHERE '.$column.' = :username';
		$sql_prep = $conn->prepare($sql_statement);
		$sql_prep->bindValue(':username', $username);
		$sql_prep->execute();
		if ($ret != false) {
			$array = $sql_prep->fetch(PDO::FETCH_ASSOC);
			if ($array != false) {
				return $array;
			} else {
				return false;
			}
		} else if ($ret == false) {
			if ($sql_prep->fetch(PDO::FETCH_ASSOC) == false) {
				return true;
			}
		}
	}
	public static function check_unique_class_role($class_role, $table, $ret = false) {//fetchs info using class_role
		$conn = self::connect_db('admin');
		if ($table == 'students') {
			$column = 'student_class';
		} else if ($table == 'staffs') {
			$column = 'staff_role';
		}
		$sql_statement = 'SELECT * FROM '.$table.' WHERE '.$column.' = :username';
		$sql_prep = $conn->prepare($sql_statement);
		$sql_prep->bindValue(':username', $class_role);
		$sql_prep->execute();
		if ($ret != false) {
			$array = $sql_prep->fetchAll(PDO::FETCH_ASSOC);
			if ($array != false) {
				return $array;
			} else {
				return false;
			}
		} else if ($ret == false) {
			if ($sql_prep->fetch(PDO::FETCH_ASSOC) == false) {
				return true;
			} else return false;
		}
	}
	public static function check_unique_id($id, $table, $ret = false) {//fetchs info using id
		$conn = self::connect_db('admin');
		if ($table == 'students' || $table == 'students_bio') {
			$column = 'student_id';
		} else if ($table == 'staffs' || $table == 'staffs_bio') {
			$column = 'staff_id';
		}
		$sql_statement = 'SELECT * FROM '.$table.' WHERE '.$column.' = :id';
		$sql_prep = $conn->prepare($sql_statement);
		$sql_prep->bindValue(':id', $id);
		$sql_prep->execute();
		if ($ret != false) {
			$array = $sql_prep->fetch(PDO::FETCH_ASSOC);
			if ($array != false) {
				return $array;
			} else {
				return false;
			}
		} else if ($ret == false) {
			if ($sql_prep->fetch(PDO::FETCH_ASSOC) == false) {
				return true;
			}
		}
	}
	public static function get_info_from_db($type, $obj, $id) {
		$conn = $obj;
		if ($type == 'student') {
			$table = 'students';
			$column = 'student_id';
		} else if ($type == 'staff') {
			$table = 'staffs';
			$column = 'staff_id';
		}
		$sql_statement = 'SELECT * FROM '.$table.' WHERE '.$column.' = :id';
		$sql_prep = $conn->prepare($sql_statement);
		$sql_prep->bindValue(':id', $id);
		$sql_prep->execute();
		$r = $sql_prep->fetch(PDO::FETCH_ASSOC);
		return $r;
	}
	public static function get_bio_from_db($type, $obj, $id) {
		$conn = $obj;
		if ($type == 'student') {
			$table = 'students_bio';
			$column = 'student_id';
		} else if ($type == 'staff') {
			$table = 'staffs_bio';
			$column = 'staff_id';
		}
		$sql_statement = 'SELECT * FROM '.$table.' WHERE '.$column.' = :id';
		$sql_prep = $conn->prepare($sql_statement);
		$sql_prep->bindValue(':id', $id);
		$sql_prep->execute();
		$r = $sql_prep->fetch(PDO::FETCH_ASSOC);
		return $r;
	}
	public static function get_info_bio($obj, $id, $type) {//gets basic info and bio info from db
		if ($type == 'student') {
			$statement = 'SELECT tab1.*, tab2.* FROM students AS tab1 ';
			$statement .= 'INNER JOIN students_bio AS tab2 ';
			$statement .= 'ON tab1.student_id = tab2.student_id ';
			$statement .= 'WHERE tab1.student_id = '.$id;
		} else if ($type == 'staff') {
			$statement = 'SELECT tab1.*, tab2.* FROM staffs AS tab1 ';
			$statement .= 'INNER JOIN staffs_bio AS tab2 ';
			$statement .= 'ON tab1.staff_id = tab2.staff_id ';
			$statement .= 'WHERE tab1.staff_id = '.$id;
		}
		$result = $obj->query($statement);
		$array = $result->fetch(PDO::FETCH_ASSOC);
		return $array;
	}
	public static function get_all_from_db($obj, $type, $id = false) {//gets basic info and passport info from db
		if ($type == 'student') {
			$statement = 'SELECT tab1.*, tab2.student_passport FROM students AS tab1 ';
			$statement .= 'INNER JOIN students_bio AS tab2 ';
			$statement .= 'ON tab1.student_id = tab2.student_id ';
			if ($id) {
				$statement .= 'WHERE tab1.student_id = '.$id.' ';
			}
			$statement .= 'ORDER BY student_class, student_first_name';
		} else if ($type == 'staff') {
			$statement = 'SELECT tab1.*, tab2.staff_passport FROM staffs AS tab1 ';
			$statement .= 'INNER JOIN staffs_bio AS tab2 ';
			$statement .= 'ON tab1.staff_id = tab2.staff_id ';
			if ($id) {
				$statement .= 'WHERE tab1.staff_id = '.$id.' ';
			}
			$statement .= 'ORDER BY staff_role, staff_first_name';
		}
		$result = $obj->query($statement);
		$array = $result->fetchAll(PDO::FETCH_ASSOC);
		return $array;
	}
	public static function get_subjects($class, $offered = false) {//fetchs subjects offered or not offered and respective teachers
		$conn = Database::connect_db('admin');
		if (preg_match('/JSS/', $class)) {
			$class = substr($class, 0, 5);
		}
		$class_col = strtolower(str_replace(' ', '_', $class));
		$class = $conn->quote('%'.$class.'%');
		if ($offered == true) {
			$result = array();
			$sql = 'SELECT subject_name, '.$class_col.' FROM subjects WHERE classes LIKE '.$class;
			if (!$res = $conn->query($sql)) throw new CustomException('UNABLE TO EXECUTE SQL STATEMENT');
			$res = $res->fetchAll(PDO::FETCH_ASSOC);
			$index = 0;
			foreach ($res as $key) {
				$result[$index]['subject'] = $key['subject_name'];
				$result[$index]['teacher_id'] = $key[$class_col];
				if ($key[$class_col]) {
					$data = self::check_unique_id($key[$class_col], 'staffs', 1);
					if ($data) {
						$result[$index]['teacher_name'] = $data['staff_first_name'].' '.$data['staff_last_name']; 
					} else $result[$index]['teacher_name'] = 'NONE';
				} else {
					$result[$index]['teacher_name'] = 'NONE';
				}
				$index++;
			}
		} else if ($offered == false) {
			$sql = 'SELECT subject_name FROM subjects WHERE subject_name NOT IN (SELECT subject_name FROM subjects WHERE classes LIKE '.$class.')';
			$res = $conn->query($sql);
			$result = [];
			$subject = $res->fetch(PDO::FETCH_ASSOC);
			while ($subject) {
				$result[] = strtolower($subject['subject_name']);
				$subject = $res->fetch(PDO::FETCH_ASSOC);
			}
		}
		return $result;
	}
	public static function get_all_subjects($classes = false) {
		$conn = Database::connect_db('admin');
		$array = array();
		$sql = 'SELECT subject_name, classes FROM subjects ORDER BY subject_name';
		$res = $conn->query($sql);
		while ($re = $res->fetch(PDO::FETCH_ASSOC)) {
			if (!$classes) {
				$array[] = $re['subject_name'];
			} else {
				$arr = [];
				$arr['name'] = $re['subject_name'];
				$arr['classes'] = $re['classes'];
				$array[] = $arr;
			}
		}
		return $array;
	}
	public static function check_if_subject_exists($new_subjects, $ret = false) {//checks if subject exists in db
		$exists = array();
		$conn = Database::connect_db('admin');
		$new = $new_subjects;
		if (!$ret) {
			foreach ($new as $ne) {
				$ne = $conn->quote($ne);
				$sql = 'SELECT * FROM subjects WHERE subject_name = '.$ne;
				$res = $conn->query($sql);
				if ($res->fetch(PDO::FETCH_ASSOC)) {
					$exists[] = 'exists';
				}
			}
		} else {
			$res = $conn->query('SELECT * FROM subjects WHERE subject_name = '.$conn->quote($new_subjects));
			return $res->fetch(PDO::FETCH_ASSOC);
		}
		if (sizeof($exists) > 0) {
			return true;
		} else {
			return false;
		}
	}
	public static function read_classes_in_subject($subject) {//fetchs classes offering a subject
		$conn = Database::connect_db('admin');
		$subject = $conn->quote($subject);
		$check = $conn->query('SELECT classes FROM subjects WHERE subject_name = '.$subject);
		$check = $check->fetch(PDO::FETCH_ASSOC);
		return $check['classes'];
	}
	public static function read_classes($type, $input, $ret = false) {//fetchs class teacher of individual class 
		$conn = self::connect_db('admin');
		if ($type == 'teacher_id') {
			$column = 'class_teacher_id';
		} else if ($type == 'class_name') {
			$column = 'class_name';
		}
		$sql_statement = 'SELECT * FROM classes WHERE '.$column.' = :input';
		$sql_prep = $conn->prepare($sql_statement);
		$sql_prep->bindValue(':input', $input);
		$sql_prep->execute();
		if ($ret != false) {
			$array = $sql_prep->fetch(PDO::FETCH_ASSOC);
			if ($array != false) {
				return $array;
			} else {
				return false;
			}
		} else if ($ret == false) {
			if ($sql_prep->fetch(PDO::FETCH_ASSOC) == false) {
				return true;
			}
		}
	}
	public static function get_classes_info($class) {//fetchs all class teachers
		$info = array();
		$conn = Database::connect_db('admin');
		if ($class) {
			$class = $conn->quote($class);
			$sql = 'SELECT class_teacher_id FROM classes WHERE class_name = '.$class;
		} else {
			$sql = 'SELECT class_name, class_teacher_id FROM classes';
		}
		$pdos_obj = $conn->query($sql);
		$pdos_obj->setFetchMode(PDO::FETCH_ASSOC);
		if ($class) {
			$res = $pdos_obj->fetch();
			if (!$res['class_teacher_id']) {
				$info = 'NONE';
			} else {
				$id = $res['class_teacher_id'];
				$data = self::check_unique_id($id, 'staffs', 1);
				$info = $data['staff_first_name'].' '.$data['staff_last_name'];
			}
		} else {
			$res = $pdos_obj->fetchAll();
			$index = 0;
			foreach ($res as $key) {
				$info[$index]['class'] = $key['class_name'];
				if ($key['class_teacher_id']) {
					$data = self::check_unique_id($key['class_teacher_id'], 'staffs', 1);
					$info[$index]['teacher'] = $data['staff_first_name'].' '.$data['staff_last_name']; 
				} else {
					$info[$index]['teacher'] = 'NONE';
				}
				$index++;
			}
		}
		return $info;
	}
	public static function check_subject_teacher($username, $ret = false) {//checks subjects taught by teacher
		$classes = CLASSES;
		$array = array();
		$conn = Database::connect_db('admin');
		$orig_id = self::check_unique_username($username, 'staffs', 1)['staff_id'];
		$id = $conn->quote($orig_id);
		$sql = 'SELECT * FROM subjects WHERE jss_1 = '.$id.' OR jss_2 = '.$id.' OR jss_3 = '.$id.' OR sss_1_art = '.$id.' OR sss_1_science = '.$id.' OR sss_1_commercial = '.$id.' OR sss_2_art = '.$id.' OR sss_2_science = '.$id.' OR sss_2_commercial = '.$id.' OR sss_3_art = '.$id.' OR sss_3_science = '.$id.' OR sss_3_commercial = '.$id;
		$pdos_obj = $conn->query($sql);
		$pdos_obj->setFetchMode(PDO::FETCH_ASSOC);
		$res = $pdos_obj->fetchAll();
		foreach ($res as $re) {
			$fetched = [];
			foreach ($classes as $class) {
				$arr = [];
				if (preg_match('/^(jss) (\d)(\w)/i', $class, $arr)) {
					$class = $arr[1].' '.$arr[2];
					if (in_array($class, $fetched)) continue;
					array_push($fetched, $class);
				}
				$index = str_replace(' ', '_', strtolower($class));
				if ($re[$index] == $orig_id) $array[] = strtoupper($re['subject_name']).' - '.$class;
			}
		}
		if ($ret != false) {
			if ($array) {
				return $array;
			} else {
				return false;
			}
		} else if ($ret == false) {
			if ($array) {
				return true;
			} else {
				return false;
			}
		}
	}
	public static function get_subjects_teachers($array, $class) {
		$teachers = array();
		$column = strtolower(str_replace(' ', '_', $class)); 
		$sql = 'SELECT '.$column.' FROM subjects WHERE subject_name = :sub_name';
		$conn = Database::connect_db('admin');
		$pdos = $conn->prepare($sql);
		$index = 0;
		foreach ($array as $subject) {
			$pdos->bindValue(':sub_name', $subject);
			$pdos->execute();
			$teacher = $pdos->fetch(PDO::FETCH_ASSOC);
			$teacher = $teacher[$column];
			$info = self::check_unique_id($teacher, 'staffs', 1);
			$teachers[$index]['teacher_username'] = $info['staff_username'];
			$name = $info['staff_first_name'].' '.$info['staff_last_name'];
			$teachers[$index]['teacher_name'] = $name;
			$teachers[$index]['subject'] = $subject;
			$index++;
		}
		return $teachers;
	}
	public static function check_class_teacher($username, $ret = false) {//checks classes of a class teacher
		$array = array();
		$conn = Database::connect_db('admin');
		$id = Database::check_unique_username($username, 'staffs', 1)['staff_id'];
		$id = $conn->quote($id);
		$sql = 'SELECT class_name FROM classes WHERE class_teacher_id = '.$id;
		$res = $conn->query($sql);
		while ($r = $res->fetch(PDO::FETCH_ASSOC)) {
			$array[] = $r['class_name'];
		}
		if ($ret != false) {
			if ($array) {
				return $array;
			} else {
				return false;
			}
		} else if ($ret == false) {
			if ($array) {
				return true;
			} else {
				return false;
			}
		}
	}
	public static function get_subject_students($subject, $class, $sess, $ret = false, $spec = false) {//fetchs all students offering a subject
		$array = array();
		if ($spec) {
			$orig_class = $class;
			if ($class == 'JSS 1A' || $class == 'JSS 1B') {
				$class = 'JSS 1';
			}
			if ($class == 'JSS 2A' || $class == 'JSS 2B') {
				$class = 'JSS 2';
			}
			if ($class == 'JSS 3A' || $class == 'JSS 3B') {
				$class = 'JSS 3';
			}
		}
		switch ($class) {
			case 'JSS 1':
				$class = 1;
				break;
			case 'JSS 2':
				$class = 2;
				break;
			case 'JSS 3':
				$class = 3;
				break;
			case 'SSS 1 ART':
				$class = 4;
				break;
			case 'SSS 1 COMMERCIAL':
				$class = 5;
				break;
			case 'SSS 1 SCIENCE':
				$class = 6;
				break;
			case 'SSS 2 ART':
				$class = 7;
				break;
			case 'SSS 2 COMMERCIAL':
				$class = 8;
				break;
			case 'SSS 2 SCIENCE':
				$class = 9;
				break;
			case 'SSS 3 ART':
				$class = 10;
				break;
			case 'SSS 3 COMMERCIAL':
				$class = 11;
				break;
			case 'SSS 3 SCIENCE':
				$class = 12;
				break;
			default:
				// code...
				break;
		}
		$subject = strtolower(str_replace(' ', '_', $subject));
		$conn = Database::connect_db('admin');
		$session = $conn->quote($sess);
		if (!$spec) {
			$sql = 'SELECT '.$subject.'.student_id FROM '.$subject.', students WHERE '.$subject.'.student_class = '.$class.' AND '.$subject.'.session = '.$session.' AND '.$subject.'.student_id = students.student_id ORDER BY students.student_first_name';	
		} else {
			$orig_class = $conn->quote($orig_class);
			$sql = 'SELECT '.$subject.'.student_id FROM  '.$subject.', students WHERE '.$subject.'.student_class = '.$class.' AND '.$subject.'.session = '.$session.' AND '.$subject.'.student_id = students.student_id AND '.$subject.'.student_id IN (SELECT student_id FROM students WHERE student_class = '.$orig_class.') ORDER BY students.student_first_name';
		}
		$res = $conn->query($sql);
		while ($r = $res->fetch(PDO::FETCH_ASSOC)) {
			if ($ret == 'id') {
				$array[] = $r['student_id'];
			} else if ($ret == 'username') {
				$array[] = Database::check_unique_id($r['student_id'], 'students', 1)['student_username'];
			}
		}
		if ($ret != false) {
			if ($array) {
				return $array;
			} else {
				return false;
			}
		} else if ($ret == false) {
			if ($array) {
				return true;
			} else {
				return false;
			}
		}
	}
	public static function check_class_result($subject, $class, $session, $term, $type, $ret = false, $class_sub = false) {
		$conn = Database::connect_db('staff');
		if ($class_sub == 'class') {
			$orig_class = $class;
			if ($class == 'JSS 1A' || $class == 'JSS 1B') {
				$class = 'JSS 1';
			}
			if ($class == 'JSS 2A' || $class == 'JSS 2B') {
				$class = 'JSS 2';
			}
			if ($class == 'JSS 3A' || $class == 'JSS 3B') {
				$class = 'JSS 3';
			}
		}
		switch ($class) {
			case 'JSS 1':
				$class = 1;
				break;
			case 'JSS 2':
				$class = 2;
				break;
			case 'JSS 3':
				$class = 3;
				break;
			case 'SSS 1 ART':
				$class = 4;
				break;
			case 'SSS 1 COMMERCIAL':
				$class = 5;
				break;
			case 'SSS 1 SCIENCE':
				$class = 6;
				break;
			case 'SSS 2 ART':
				$class = 7;
				break;
			case 'SSS 2 COMMERCIAL':
				$class = 8;
				break;
			case 'SSS 2 SCIENCE':
				$class = 9;
				break;
			case 'SSS 3 ART':
				$class = 10;
				break;
			case 'SSS 3 COMMERCIAL':
				$class = 11;
				break;
			case 'SSS 3 SCIENCE':
				$class = 12;
				break;
			default:
				// code...
				break;
		}
		$column = '';
		$subject = strtolower(str_replace(' ', '_', $subject));
		$session = $conn->quote($session);
		if ($term == 'FIRST TERM') {
			$column .= $subject.'.first_';
		} else if ($term == 'SECOND TERM') {
			$column .= $subject.'.second_';
		} else if ($term == 'THIRD TERM') {
			$column .= $subject.'.third_';
		}
		if ($type == '1ST C.A. TEST') {
			$column .= '1_ca';
		} else if ($type == '2ND C.A. TEST') {
			$column .= '2_ca';
		} else if ($type == 'ASSIGNMENT') {
			$column .= 'ass';
		} else if ($type == 'EXAMINATION') {
			$column .= 'exam';
		} else if ($type == 'all') {
			$column .= '1_ca, '.$column.'2_ca, '.$column.'ass, '.$column.'exam';
		}
		if ($class_sub == 'subject') {
			$sql = 'SELECT '.$subject.'.student_id, '.$column.' FROM  '.$subject.', students WHERE '.$subject.'.student_class = '.$class.' AND '.$subject.'.session = '.$session.' AND '.$subject.'.student_id = students.student_id ORDER BY students.student_first_name';	
		} else if ($class_sub == 'class') {
			$orig_class = $conn->quote($orig_class);
			$sql = 'SELECT '.$subject.'.student_id, '.$column.' FROM  '.$subject.', students WHERE '.$subject.'.student_class = '.$class.' AND '.$subject.'.session = '.$session.' AND '.$subject.'.student_id = students.student_id AND '.$subject.'.student_id IN (SELECT student_id FROM students WHERE student_class = '.$orig_class.') ORDER BY students.student_first_name';
		}
		if (!$res = $conn->query($sql)) throw new CustomException(debug_backtrace(), 'UNABLE TO EXECUTE SQL STATEMENT');
		if ($ret) {
			$array = array();
			$index = 0;
			while ($re = $res->fetch(PDO::FETCH_ASSOC)) {
				foreach ($re as $key => $value) {
					if ($key == 'student_id') {
						$name = Database::check_unique_id($re['student_id'], 'students', 1);
						$name = $name['student_first_name'].' '.$name['student_last_name'];
						$array[$index]['name'] = $name;
						$array[$index]['student_id'] = $value;
					} else {
						$array[$index][$key] = $value;
					}
				}
				$index++;
			}
			return $array;
		} else if (!$ret) {
			$column = explode(',', $column);
			$array = $res->fetch(PDO::FETCH_ASSOC);
			if ($array[$column[0]] == null) {
				return false;
			} else {
				return true;
			}
		}
	}
	public static function check_student_result($id, $subjects, $session, $term) {
		$array = array();
		$status = array();
		$conn = Database::connect_db('staff');
		$session = $conn->quote($session);
		$column = '';
		if ($term == 'FIRST TERM') {
			$column .= 'first_';
		} else if ($term == 'SECOND TERM') {
			$column .= 'second_';
		} else if ($term == 'THIRD TERM') {
			$column .= 'third_';
		}
		$column .= '1_ca, '.$column.'2_ca, '.$column.'ass, '.$column.'exam';
		$index = 0;
		foreach ($subjects as $subject) {
			$sub = $subject;
			$subject = strtolower(str_replace(' ', '_', $subject));
			$sql = 'SELECT '.$column.' FROM  '.$subject.' WHERE student_id = '.$id.' AND session = '.$session;	
			if (!$res = $conn->query($sql)) throw new CustomException(debug_backtrace(), 'UNABLE TO EXECUTE SQL STATEMENT');
			$re = $res->fetch(PDO::FETCH_ASSOC);
			$array[$index]['subject'] = $sub;
			foreach ($re as $key => $value) {
				if (preg_match('/1_ca/', $key)) {
					$array[$index]['first_ca'] = $value;
				} else if (preg_match('/2_ca/', $key)) {
					$array[$index]['second_ca'] = $value;
				} else if (preg_match('/ass/', $key)) {
					$array[$index]['ass'] = $value;
				} else if (preg_match('/exam/', $key)) {
					$array[$index]['exam'] = $value;
				}
			}
			$index++;
		}
		return $array;
	}
}
//the following classes handle the logic behind XMLs interaction
class XML {
	public static function create_file_name($id, $type) {
		$filename = $id;
		$filename = '../bin/xmls/'.$type.'s/'.$filename.'.xml';
		return $filename;
	}
	public static function get_sessions_for_student($student_id) {//gets sessions for student from xml
		$array = array();
		$file = self::create_file_name($student_id, 'student');
		if (!$xml = simplexml_load_file($file)) throw new CustomException(debug_backtrace(), 'UNABLE TO LOAD XML FILE');
		$sessions = $xml->sessions;
		foreach ($sessions->children() as $session) {
			$array[] = $session['session'];
		}
		return $array;
	}
	public static function get_session_subjects($student_id, $sess) {
		$array = array();
		$file = self::create_file_name($student_id, 'student');
		if (!$xml = simplexml_load_file($file)) throw new CustomException(debug_backtrace(), 'UNABLE TO READ XML FILE');
		$sessions = $xml->sessions;
		foreach ($sessions->children() as $session) {
			
			if (strval($session['session']) == strval($sess)) {
				$sel_sess = $session;
				foreach ($sel_sess->subject as $sub) {
					$array[] = $sub;
				}
				break;
			}
		}

		return $array;
	}
	public static function get_session_class($student_id, $sess) {
		$file = self::create_file_name($student_id, 'student');
		if (!$xml = simplexml_load_file($file)) throw new CustomException(debug_backtrace(), 'UNABLE TO READ XML FILE');
		$sessions = $xml->sessions;
		$class = null;
		foreach ($sessions->children() as $session) {
			if (strval($session['session']) == strval($sess)) {
				$class = $session['class'];
				break;
			}
		}

		return $class;
	}
}
//the following classes handle the login logics
class Login {
	protected $input_username;
	protected $input_password;
	protected static $login_errors = false;
	public function __construct($username, $password) {
		//session_start();
		$this->input_username = $username;
		$this->input_password = $password;
	}
	protected static function redirect($url) {
		return header('location: '.$url);
	}
	protected static function set_session($name, $message) {
		$_SESSION[$name] = $message;
	}
	protected function create_username_cookie($cookie_name,$username) {
		setcookie($cookie_name, $username, 0);
	}
}
class Mod_AdminLogin extends Login {
	private static $usernames = array();
	private static $passwords = array();
	private function set_arrays() {//retrieves preset usernames and passwords from config file
		$config = parse_ini_file('../admin/admin_config.txt');
		foreach ($config as $key => $value) {
			if (preg_match('/user/i', $key)) {
				self::$usernames[$key] =  $value;
			} else if (preg_match('/pass/i', $key)) {
				self::$passwords[$key] = md5($value);
			}
		}
	}
	private function get_password_key($username) {//creates a passwords index from the corresponding username
		foreach (self::$usernames as $key => $value) {
			if ($value === $username) {
				$index = $key;
				break;
			}
		}
		$index = str_replace('user', 'pass', $index);
		return $index;
	}
	public function mod_admin_validate() {//checks if username and password exist for admin login. Called in contrl
		self::set_arrays();
		if (preg_grep('/'.$this->input_username.'/', self::$usernames)) {
			$index = $this->get_password_key($this->input_username);
			if (self::$passwords[$index] === md5($this->input_password)) {
				$this->create_username_cookie('admin_username', $this->input_username);
				$this->create_username_cookie('admin_password', $this->input_password);
				$this->create_username_cookie('user_type', 'admin');
				Login::redirect('./index.php');
			} else {
				Login::$login_errors = ['The password you have inputted is wrong.'];
			}
		} else {
			Login::$login_errors = ['Please input a valid username.'];
		}
		if (Login::$login_errors) {
			Login::set_session('errors', self::$login_errors);
			Login::redirect('./login.php');
		}
	}
}
class Mod_St_Login extends Login {
	private $type;
	private $username;
	private $password;
	public function __construct($type, $username, $password) {
		$this->type = $type;
		$this->username = $username;
		$this->password = $password;
	}
	private function get_lastname($obj) {
		$table = $this->type.'s';
		$username = $this->type.'_username';
		$lastname = $this->type.'_last_name';
		$sql = 'SELECT '.$lastname.' FROM '.$table.' WHERE '.$username.' = :username';
		if (!$pdos_obj = $obj->prepare($sql)) throw new CustomException(debug_backtrace(), 'UNABLE TO PREPARE LOGIN SQL STATEMENT.');
		$pdos_obj->bindValue(':username', $this->username);
		if (!$pdos_obj->execute()) throw new CustomException(debug_backtrace(), 'UNABLE TO EXECUTE LOGIN SQL');
		$lastname = $pdos_obj->fetch(PDO::FETCH_ASSOC)[$lastname];
		return $lastname;
	}
	private function validate_password($lastname) {
		if (strtoupper(trim($this->password)) === $lastname) {
			$info = Database::check_unique_username($this->username, $this->type.'s', 1);
			setcookie($this->type.'_id', $info[$this->type.'_id'], 0);
			setcookie($this->type.'_username', $info[$this->type.'_username'], 0);
			setcookie($this->type.'_first_name', $info[$this->type.'_first_name'], 0);
			setcookie($this->type.'_last_name', $info[$this->type.'_last_name'], 0);
			if ($this->type == 'staff') {
				setcookie($this->type.'_role', $info[$this->type.'_role'], 0);
			} else if ($this->type == 'student') {
				setcookie($this->type.'_class', $info[$this->type.'_class'], 0);
			}
			setcookie('user_type', $this->type, 0);
			return true;
		} else {
			return false;
		}
	}
	public function st_login() {
		$conn = Database::connect_db($this->type);
		$lastname = $this->get_lastname($conn);
		if (!$this->validate_password($lastname)) {
			$_SESSION['errors'] = ['You have inputted a wrong password.'];
			header('location: ./login.php');
			die();
		} else {
			Parent::redirect('./index.php');
		}
	}
}
//the following classes handle the addst logics
Class Mod_Addst {
	private $type;
	private $first_name;
	private $last_name;
	private $username;
	private $class_role;
	private $existing;
	private $id;
	public function __construct($type, $fname, $lname, $uname, $class, $existing = false, $id = false) {
		$this->type = $type;
		$this->first_name = $fname;
		$this->last_name = $lname;
		$this->username = $uname;
		$this->class_role = $class;
		$this->existing = $existing;
		$this->id = $id;
	}
	private function create_statement() {//creates SQL statement based on if existing or not and based on either student or staff
		if ($this->type == 'student') {
			if ($this->existing == false) {
				$statement = 'INSERT INTO students ';
				$statement .= 'SET student_first_name = :first_name, ';
				$statement .= 'student_last_name = :last_name, ';
				$statement .= 'student_username = :username, ';
				$statement .= 'student_class = :class';
			} else if ($this->existing == true) {
				$statement = 'UPDATE students ';
				$statement .= 'SET student_first_name = :first_name, ';
				$statement .= 'student_last_name = :last_name, ';
				$statement .= 'student_username = :username, ';
				$statement .= 'student_class = :class ';
				$statement .= 'WHERE student_id = :id';
			}
		} else if ($this->type = 'staff') {
			if ($this->existing == false) {
				$statement = 'INSERT INTO staffs ';
				$statement .= 'SET staff_first_name = :first_name, ';
				$statement .= 'staff_last_name = :last_name, ';
				$statement .= 'staff_username = :username, ';
				$statement .= 'staff_role = :class';
			} else if ($this->existing == true) {
				$statement = 'UPDATE staffs ';
				$statement .= 'SET staff_first_name = :first_name, ';
				$statement .= 'staff_last_name = :last_name, ';
				$statement .= 'staff_username = :username, ';
				$statement .= 'staff_role = :class ';
				$statement .= 'WHERE staff_id = :id';
			}
		}
		return $statement;
	}
	private function prep_statement($obj, $statement) {//prepares the SQL statement
		if (!$pdos_obj = $obj->prepare($statement)) throw new CustomException(debug_backtrace(), 'UNABLE TO PREPARE THE SQL STATEMENT');
		return $pdos_obj;
	}
	private function deregister_student() {
		if ($this->existing) {
			$session = new Mod_Change_Session();
			$cur_session = $session->get_current_info()['session'];
			$check_reg = new Mod_Check_Registered([['student_id'=>$this->id]], $cur_session);
			$present_class = Database::check_unique_id($this->id, 'students', 1)['student_class'];
			if ($check_reg->check_registered()[0]['status'] == 'reg' && $this->class_role != $present_class) {
				$match1 = [];
				$match2 = [];
				if (preg_match('/^JSS (\d)/', $this->class_role, $match1) && preg_match('/^JSS (\d)/', $present_class, $match2)) {
					if ($match1[1] != $match2[1]) {
						deregister($this->id);
					} else {return true;}
				}
				deregister($this->id);
			}
		}
		return true;
	}
	private function execute_statement($obj) {//binds and execute the prepared SQL statement
		$sql_prep = $obj;
		if ($this->existing == false) {
			$sql_prep->bindValue(':first_name', $this->first_name);
			$sql_prep->bindValue(':last_name', $this->last_name);
			$sql_prep->bindValue(':username', $this->username);
			$sql_prep->bindValue(':class', $this->class_role);
		} else if ($this->existing == true) {
			$sql_prep->bindValue(':first_name', $this->first_name);
			$sql_prep->bindValue(':last_name', $this->last_name);
			$sql_prep->bindValue(':username', $this->username);
			$sql_prep->bindValue(':class', $this->class_role);
			$sql_prep->bindValue(':id', $this->id);
		}
		if (!$sql_prep->execute()) throw new CustomException(debug_backtrace(), 'UNABLE TO EXECUTE THE SQL STATEMENT');
		return true;
	}
	private function redr_to_edit_bio($type, $index) {
		header('location: ./edit_bio.php?pe='.$type.'&id='.$index);
	}
	public function mod_add_st() {//compiles all add function. Called in contrl.	
		$conn = Database::connect_db('admin');
		if (!$statement = $this->create_statement()) throw new CustomException(debug_backtrace(), 'UNABLE TO CREATE THE SQL STATEMENT');
		$sql = $this->prep_statement($conn, $statement);
		if ($this->deregister_student() && $this->execute_statement($sql)) {
			
		}
	}
}
//the following classes handle the editst logics
class Mod_Editst {
	protected static function set_passport_dir($type, $id, $passport) {
		$conn = Database::connect_db('admin');		
		$extension = pathinfo($passport['name'], PATHINFO_EXTENSION);
		if ($type == 'student') {
			$filedir = '../bin/passports/students/'.$id.'.'.$extension;
		} else if ($type == 'staff') {
			$filedir = '../bin/passports/staffs/'.$id.'.'.$extension;
		}
		return $filedir;
	}
	protected static function set_xml_dir($type, $id) {
		$conn = Database::connect_db('admin');
		$name = $id;
		$extension = 'xml';
		if ($type == 'student') {
			$filedir = '../bin/xmls/students/'.$name.'.'.$extension;
		} else if ($type == 'staff') {
			$filedir = '../bin/xmls/staffs/'.$name.'.'.$extension;
		}
		return $filedir;
	}
	protected function create_xml_file($type, $id) {
		$xml_dir = self::set_xml_dir($type, $id);
		if ($type == 'student') {
			$content = '<?xml version=\'1.0\' encoding=\'utf-8\'?>'."\n";
			$content .= '<student id=\''.$id.'\'>'."\n";
			$content .= '<mails>'."\n";
			$content .= '<received>'."\n";
			$content .= '</received>'."\n";
			$content .= '<sent>'."\n";
			$content .= '</sent>'."\n";
			$content .= '</mails>'."\n";
			$content .= '<sessions>'."\n";
			$content .= '</sessions>'."\n";
			$content .= '</student>'; 
		} else if ($type == 'staff') {
			$content = '<?xml version=\'1.0\' encoding=\'utf-8\'?>'."\n";
			$content .= '<staff id=\''.$id.'\'>'."\n";
			$content .= '<permission subject_name=\'\'></permission>'."\n";
			$content .= '<mails>'."\n";
			$content .= '<received>'."\n";
			$content .= '</received>'."\n";
			$content .= '<sent>'."\n";
			$content .= '</sent>'."\n";
			$content .= '</mails>'."\n";
			$content .= '</staff>'; 
		}
		if (file_put_contents($xml_dir, $content)) {
			return true;
		} else {
			return false;
		}
	}
	protected static function upload_passport($type, $id, $passport) {//uploads student passport
		$passport_dir = self::set_passport_dir($type, $id, $passport);
		if (is_file($passport_dir)) unlink($passport_dir);
		if (move_uploaded_file($passport['tmp_name'], $passport_dir)) {
			return true;
		}
	}
	protected function add_to_mails($type, $id) {
		$mail_stmt = 'INSERT INTO mails SET username = :username';
		$conn = Database::connect_db('admin');
		$sql_pdos = $conn->prepare($mail_stmt);
		$username = $type.'_'.$id;
		$sql_pdos->bindValue(':username', $username);
		if (!$sql_pdos->execute()) throw new CustomException(debug_backtrace(), 'UNABLE TO EXECUTE ADD TO MAIL STATEMENT');
		return true;
	}
}
class Mod_Editstudent_bio extends Mod_Editst {
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
	public function __construct($id, $pname, $pphone, $pmail, $dob, $address, $storg, $gender, $religion, $passport, $existing = false) {
		$this->student_id = $id;
		$this->parent_name = strtoupper($pname);
		$this->parent_phone = $pphone;
		if ($pmail == '') {
			$this->parent_email = NULL;
		} else {
			$this->parent_email = $pmail;
		}
		$this->student_dob = $dob;
		$this->student_address = strtoupper($address);
		$this->student_storg = strtoupper($storg);
		switch ($gender) {
			case 'FEMALE':
				$this->student_gender = 1;
				break;
			case 'MALE':
				$this->student_gender = 2;
				break;
			default:
				throw new CustomException(debug_backtrace(),'SOMETHING WENT WRONG WHILE SETTING GENDER.');				
				break;
		}
		switch ($religion) {
			case 'CHRISTIANITY':
				$this->student_religion = 1;
				break;
			case 'ISLAM':
				$this->student_religion = 2;
				break;
			case 'OTHERS':
				$this->student_religion = 3;
				break;
			default:
				throw new CustomException(debug_backtrace(),'SOMETHING WENT WRONG WHILE SETTING RELIGION.');				
				break;
		}
		$this->existing = $existing;
		$this->student_passport = $passport;
	}
	private function create_statement() {//creates SQL statement based on if existing or not
		if ($this->existing == false) {
			$statement = 'INSERT INTO students_bio ';
			$statement .= 'SET student_id = :id, ';
			$statement .= 'parent_name = :p_name, ';
			$statement .= 'parent_phone_number = :p_phone, ';
			$statement .= 'parent_email = :p_email, ';
			$statement .= 'student_dob = :s_dob, ';
			$statement .= 'student_address = :s_address, ';
			$statement .= 'student_storg = :s_storg, ';
			$statement .= 'student_gender = :s_gender, ';
			$statement .= 'student_religion = :s_religion, ';
			$statement .= 'student_passport = :s_passport ';
		} else if ($this->existing == true) {
			$statement = 'UPDATE students_bio ';
			$statement .= 'SET parent_name = :p_name, ';
			$statement .= 'parent_phone_number = :p_phone, ';
			$statement .= 'parent_email = :p_email, ';
			$statement .= 'student_dob = :s_dob, ';
			$statement .= 'student_address = :s_address, ';
			$statement .= 'student_storg = :s_storg, ';
			$statement .= 'student_gender = :s_gender, ';
			$statement .= 'student_religion = :s_religion';
			if (!empty($this->student_passport['name'])) $statement .= ', student_passport = :s_passport';
			$statement .= ' WHERE student_id = :id';
		}
		return $statement;
	}
	private function prep_statement($obj, $statement) {//prepares the SQL statement
		if (!$pdos_obj = $obj->prepare($statement)) throw new CustomException(debug_backtrace(), 'UNABLE TO PREPARE THE SQL STATEMENT');
		return $pdos_obj;
	}
	private function execute_statement($obj) {//binds and execute the prepared SQL statement
		$passport_dir = Parent::set_passport_dir('student', $this->student_id, $this->student_passport); 
		$sql_prep = $obj;
		$sql_prep->bindValue(':id', $this->student_id);
		$sql_prep->bindValue(':p_name', $this->parent_name);
		$sql_prep->bindValue(':p_phone', $this->parent_phone);
		$sql_prep->bindValue(':p_email', $this->parent_email);
		$sql_prep->bindValue(':s_dob', $this->student_dob);
		$sql_prep->bindValue(':s_address', $this->student_address);
		$sql_prep->bindValue(':s_storg', $this->student_storg);
		$sql_prep->bindValue(':s_gender', $this->student_gender);
		$sql_prep->bindValue(':s_religion', $this->student_religion);
		if (!empty($this->student_passport['name'])) $sql_prep->bindValue(':s_passport', $passport_dir);
		if ($sql_prep->execute()) {
			return true;
		} else {
			throw new CustomException(debug_backtrace(), 'UNABLE TO EXECUTE THE SQL STATEMENT');
		}
	}
	public function mod_edit_bio() {
		$conn = Database::connect_db('admin');
		if (!$statement = $this->create_statement()) throw new CustomException(debug_backtrace(), 'UNABLE TO CREATE SQL STATEMENT');
		$sql = $this->prep_statement($conn, $statement);
		if (!empty($this->student_passport['name']) && !Parent::upload_passport('student', $this->student_id, $this->student_passport)) {
			throw new CustomException(debug_backtrace(), 'UNABLE TO UPLOAD STUDENT PASSPORT');
		}
		if ($this->existing == false) {
			if (!Parent::create_xml_file('student', $this->student_id)) {
				throw new CustomException(debug_backtrace(), 'UNABLE TO CREATE STUDENT XML FILE.');
			}
			Parent::add_to_mails('student', $this->student_id);
		}
		if ($this->execute_statement($sql)) {
			echo 'STUDENT\'S BIO HAS BEEN SUCCESSFULLY UPDATED!';
			echo '<article class=\'homepage\'><div><a href=\'./index.php\'>GO TO HOMEPAGE</a></div>';
			echo '<div><a href=\'./student_bio.php?id='.$this->student_id.'\'>VIEW BIO...</a></div></article>';
			unset($_SESSION['basic_info']);
		}
	}
}
class Mod_Editstaff_Bio extends Mod_Editst {
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
	protected $existing;
	public function __construct($id, $s_phone, $s_email, $s_dob, $n_name, $n_phone, $s_address, $s_storg, $s_gender, $s_religion, $s_passport, $existing = false) {
		$this->staff_id = $id;
		$this->staff_phone = $s_phone;
		$this->staff_email = strtoupper($s_email);
		$this->staff_dob = $s_dob;
		$this->nok_name = strtoupper($n_name);
		$this->nok_phone = $n_phone;
		$this->staff_address = strtoupper($s_address);
		$this->staff_storg = strtoupper($s_storg);
		switch ($s_gender) {
			case 'FEMALE':
				$this->staff_gender = 1;
				break;
			case 'MALE':
				$this->staff_gender = 2;
				break;
			default:
				throw new CustomException(debug_backtrace(),'SOMETHING WENT WRONG WHILE SETTING STAFF GENDER.');				
				break;
		}
		switch ($s_religion) {
			case 'CHRISTIANITY':
				$this->staff_religion = 1;
				break;
			case 'ISLAM':
				$this->staff_religion = 2;
				break;
			case 'OTHERS':
				$this->staff_religion = 3;
				break;
			default:
				throw new CustomException(debug_backtrace(),'SOMETHING WENT WRONG WHILE SETTING RELIGION.');				
				break;
		}
		$this->existing = $existing;
		$this->staff_passport = $s_passport;
	}
	private function create_statement() {//creates SQL statement based on if existing or not
		if ($this->existing == false) {
			$statement = 'INSERT INTO staffs_bio ';
			$statement .= 'SET staff_id = :id, ';
			$statement .= 'staff_phone_number = :s_phone, ';
			$statement .= 'staff_email = :s_email, ';
			$statement .= 'staff_dob = :s_dob, ';
			$statement .= 'nok_name = :n_name, ';
			$statement .= 'nok_phone_number = :n_phone, ';
			$statement .= 'staff_address = :s_address, ';
			$statement .= 'staff_storg = :s_storg, ';
			$statement .= 'staff_gender = :s_gender, ';
			$statement .= 'staff_religion = :s_religion, ';
			$statement .= 'staff_passport = :s_passport';
		} else if ($this->existing == true) {
			$statement = 'UPDATE staffs_bio ';
			$statement .= 'SET staff_phone_number = :s_phone, ';
			$statement .= 'staff_email = :s_email, ';
			$statement .= 'staff_dob = :s_dob, ';
			$statement .= 'nok_name = :n_name, ';
			$statement .= 'nok_phone_number = :n_phone, ';
			$statement .= 'staff_address = :s_address, ';
			$statement .= 'staff_storg = :s_storg, ';
			$statement .= 'staff_gender = :s_gender, ';
			$statement .= 'staff_religion = :s_religion';
			if (!empty($this->staff_passport['name'])) $statement .= ', staff_passport = :s_passport';
			$statement .= ' WHERE staff_id = :id';
		}
		return $statement;
	}
	private function prep_statement($obj, $statement) {//prepares the SQL statement
		if (!$pdos_obj = $obj->prepare($statement)) throw new CustomException(debug_backtrace(), 'UNABLE TO PREPARE THE SQL STATEMENT');
		return $pdos_obj;
	}
	private function execute_statement($obj) {//binds and execute the prepared SQL statement
		$passport_dir = Parent::set_passport_dir('staff', $this->staff_id, $this->staff_passport);
		$sql_prep = $obj;
		$sql_prep->bindValue(':id', $this->staff_id);
		$sql_prep->bindValue(':s_phone', $this->staff_phone);
		$sql_prep->bindValue(':s_email', $this->staff_email);
		$sql_prep->bindValue(':s_dob', $this->staff_dob);	
		$sql_prep->bindValue(':n_name', $this->nok_name);
		$sql_prep->bindValue(':n_phone', $this->nok_phone);
		$sql_prep->bindValue(':s_address', $this->staff_address);
		$sql_prep->bindValue(':s_storg', $this->staff_storg);
		$sql_prep->bindValue(':s_gender', $this->staff_gender);
		$sql_prep->bindValue(':s_religion', $this->staff_religion);
		if (!empty($this->staff_passport['name'])) $sql_prep->bindValue(':s_passport', $passport_dir);
		if ($sql_prep->execute()) {
			return true;
		} else {
			throw new CustomException(debug_backtrace(), 'UNABLE TO EXECUTE THE SQL STATEMENT');
		}
	}
	public function mod_edit_bio() {
		$conn = Database::connect_db('admin');
		if (!$statement = $this->create_statement()) throw new CustomException(debug_backtrace(), 'UNABLE TO CREATE SQL STATEMENT');
		$sql = $this->prep_statement($conn,$statement);
		if (!empty($this->staff_passport['name']) && !Parent::upload_passport('staff', $this->staff_id, $this->staff_passport)) {
			throw new CustomException(debug_backtrace(), 'UNABLE TO UPLOAD STAFF PASSPORT');
		}
		if ($this->existing == false) {
			if (!Parent::create_xml_file('staff', $this->staff_id)) {
				throw new CustomException(debug_backtrace(), 'UNABLE TO CREATE STAFF XML FILE.');
			}
			Parent::add_to_mails('staff', $this->staff_id);
		}
		if ($this->execute_statement($sql)) {
			unset($_SESSION['basic_info']);
			
			echo 'STAFF\'S BIO HAS BEEN SUCCESSFULLY UPDATED!';
			echo '<article class=\'homepage\'><div><a href=\'./index.php\'>GO TO HOMEPAGE</a></div>';
			echo '<div><a href=\'./staff_bio.php?id='.$this->staff_id.'\'>VIEW BIO...</a></div></article>';
			unset($_SESSION['basic_info']);
		}
	}
}
//the following class handles the st search logics
class Mod_Search_St {
	private $type;
	private $method;
	private $input;
	public function __construct($type, $method, $input) {
		$this->type = $type;
		$this->method = $method;
		$this->input = $input;
	}
	private function create_statement() {
		if ($this->type == 'student') {
			$table_1 = 'students';
			$table_2 = 'students_bio';
			$passport = 'student_passport';
			$id = 'student_id';
			$order = 'student_first_name';
			if ($this->method == 'class') {
				$column = 'student_class';
			} else if ($this->method == 'username') {
				$column = 'student_username';
			} else if ($this->method == 'surname') {
				$column = 'student_last_name';
			}
		} else if ($this->type == 'staff') {
			$table_1 = 'staffs';
			$table_2 = 'staffs_bio';
			$passport = 'staff_passport';
			$id = 'staff_id';
			$order = 'staff_first_name';
			if ($this->method == 'role') {
				$column = 'staff_role';
			} else if ($this->method == 'username') {
				$column = 'staff_username';
			} else if ($this->method == 'surname') {
				$column = 'staff_last_name';
			}
		}
		$statement = 'SELECT tab1.*, tab2.'.$passport.' FROM '.$table_1.' AS tab1 ';
		$statement .= 'INNER JOIN '.$table_2.' AS tab2 ';
		$statement .= 'ON tab1.'.$id.' = tab2.'.$id.' ';
		if ($this->method == 'class' || $this->method == 'role') {
			$statement .= 'WHERE tab1.'.$column.' = :input ';
		} else if ($this->method == 'surname' || $this->method == 'username') {
			$statement .= 'WHERE tab1.'.$column.' LIKE :input ';
		}
		$statement .= 'ORDER BY tab1.'.$order;
		return $statement;
	}
	private function prep_statement($obj, $statement) {
		if (!$pdos_obj = $obj->prepare($statement)) throw new CustomException(debug_backtrace(), 'UNABLE TO PREPARE THE SQL STATEMENT');
		return $pdos_obj;
	}
	private function execute_statement($obj) {
		$sql_prep = $obj;
		if ($this->method == 'class' || $this->method == 'role') {
			$sql_prep->bindValue(':input', $this->input);
		} else if ($this->method == 'surname' || $this->method == 'username') {
			$sql_prep->bindValue(':input', '%'.$this->input.'%');
		}
		if ($sql_prep->execute()) {
			$result = $sql_prep->fetchAll(PDO::FETCH_ASSOC);
		} else {
			throw new CustomException(debug_backtrace(), 'UNABLE TO EXECUTE THE SQL STATEMENT.');
		}
		return $result;
	}
	public function mod_search() {
		if (!$statement = $this->create_statement()) throw new CustomException(debug_backtrace(), 'UNABLE TO CREATE SQL STATEMENT');
		$conn = Database::connect_db('admin');
		$pdos = $this->prep_statement($conn, $statement);
		return $this->execute_statement($pdos);
	}
}
//the following class handles the st delete logics
class Mod_Delete_St {
	private $type;
	private $input;
	private $multiple = false;
	private $ids = false;
	public function __construct($type, $input) {
		$this->type = $type;
		$this->input = $input;
	}
	private function explode_input() {
		if (is_array($this->input)) {
			for ($i = 0; $i < sizeof($this->input); $i++) { 
				$this->input[$i] = trim($this->input[$i]);
			}
			foreach ($this->input as $username) {
				$info = Database::check_unique_username($username, $this->type.'s', 1);
				$this->ids[] = $info[$this->type.'_id'];
			}
			$this->multiple = true;
		} else {
			$info = Database::check_unique_username($this->input, $this->type.'s', 1);
			$this->ids[] = $info[$this->type.'_id'];	
		}
	}
	private function create_statement() {
		if ($this->type == 'student') {
			$table_1 = 'students';
			$table_2 = 'students_bio';
			$id = 'student_id';
			$column = 'student_username';
		} else if ($this->type == 'staff') {
			$table_1 = 'staffs';
			$table_2 = 'staffs_bio';
			$id = 'staff_id';
			$column = 'staff_username';
		}
		$statement = 'DELETE t1, t2, t3 FROM '.$table_1.' as t1 INNER JOIN '.$table_2.' as t2 ON t1.'.$id.' = t2.'.$id.' INNER JOIN mails as t3 ON CONCAT(\''.$this->type.'_\', t1.'.$this->type.'_id) = t3.username ';
		if ($this->multiple) {
			$count = sizeof($this->input);
			$statement .= 'WHERE t1.'.$column.' IN (';
			for ($i = 0; $i < $count; $i++) {
				if ($i == ($count - 1))  {
					$statement .= ':u_'.$i;
				} else {
					$statement .= ':u_'.$i.', ';
				}
			}
			$statement .= ')';
		} else {
			$statement .= 'WHERE t1.'.$column.' = :input ';
		}
		return $statement;
	}
	private function prep_statement($obj, $statement) {
		if (!$pdos_obj = $obj->prepare($statement)) throw new CustomException(debug_backtrace(), 'UNABLE TO PREPARE THE SQL STATEMENT');
		return $pdos_obj;
	}
	private function execute_statement($obj) {
		$sql_prep = $obj;
		if ($this->multiple) {
			$count = sizeof($this->input);
			for ($i = 0; $i < $count; $i++) {
				$sql_prep->bindValue(':u_'.$i, $this->input[$i]);
			}
		} else {
			$sql_prep->bindValue(':input', $this->input);
		}
		if ($sql_prep->execute()) {
			return true;
		} else {
			throw new CustomException(debug_backtrace(), 'UNABLE TO EXECUTE THE SQL STATEMENT.');
		}
	}
	private function delete_from_subjects() {
		if ($this->type == 'student') {
			$conn = Database::connect_db('admin');
			$subjects = Database::get_all_subjects();
			foreach ($subjects as $subject) {
				$subject = str_replace(' ', '_', $subject);
				if ($this->multiple) {
					$sql = 'DELETE FROM '.$subject.' WHERE student_id IN (';
					for ($i = 0; $i < sizeof($this->ids); $i++) { 
						if ($i == (sizeof($this->ids) - 1)) {
							$sql .= $this->ids[$i].')';
						} else {
							$sql .= $this->ids[$i].',';
						}
					}
					if (!$conn->query($sql)) {
						throw new CustomException(debug_backtrace(), 'UNABLE TO DELETE IDS FROM '.$subject);
					}	
				} else {
					$sql = 'DELETE FROM '.$subject.' WHERE student_id = '.$this->ids[0];
					if (!$conn->query($sql)) {
						throw new CustomException(debug_backtrace(), 'UNABLE TO DELETE '.$this->id[0].' FROM '.$subject);
					}
				}
			}
			return true;
		}
	}
	private function delete_files() {
		$conn = Database::connect_db('admin');
		foreach ($this->ids as $id) {
			if (!$res = $conn->query('SELECT '.$this->type.'_passport FROM '.$this->type.'s_bio WHERE '.$this->type.'_id = '.$id))  throw new CustomException(debug_backtrace(), 'UNABLE TO FETCH PASSPORTS FROM DB');
			$passport = $res->fetch(PDO::FETCH_ASSOC)[$this->type.'_passport'];
			if (!unlink($passport)) {
				throw new CustomException(debug_backtrace(), 'UNABLE TO DELETE PASSPORT FILE '.$passport);
			}
		}
		foreach ($this->ids as $id) {
			$file = '../bin/xmls/'.$this->type.'s/'.$id.'.xml';
			if (!unlink($file)) {
				throw new CustomException(debug_backtrace(), 'UNABLE TO DELETE XML FILE '.$file);
			}
		}
		return true;
	}
	private function archive_results() {
		if ($this->type == 'student') {
			if (create_archive($this->ids)) return true;
		}
		return true;
	}
	public function mod_delete() {
		$this->explode_input();
		if (!$statement = $this->create_statement()) throw new CustomException(debug_backtrace(), 'UNABLE TO CREATE SQL STATEMENT');
		 $conn = Database::connect_db('admin');
		 $pdos = $this->prep_statement($conn, $statement);
		if ($this->type == 'student') {
			if ($this->archive_results() && $this->delete_files() && $this->delete_from_subjects() && $this->execute_statement($pdos)) {
				echo strtoupper($this->type).'(S) HAVE BEEN DELETED SUCCESSFULLY';
				echo '<article class=\'homepage\'><a href=\'./index.php\'>GO TO HOMEPAGE</a></article>';
			}
		} else {
			if ($this->delete_files() && $this->execute_statement($pdos)) {
				echo strtoupper($this->type).'(S) HAVE BEEN DELETED SUCCESSFULLY';
				echo '<article class=\'homepage\'><a href=\'./index.php\'>GO TO HOMEPAGE</a></article>';
			}
		}
	}
}
//the following classes handle the logics of changing session/term
class Mod_Change_Session {
	private $input_session;
	private $input_term;
	private $start_date;
	private static $cur_session;
	private static $cur_term;
	private static $cur_start_date;
	private static $file;
	public function __construct ($session = false, $term = false, $start_date = null) {
		$this->input_session = $session;
		$this->input_term = $term;
		$this->start_date = $start_date;
		self::$file = '../bin/session_term.txt';
		self::set_cur_session();
		self::set_cur_term();
		self::set_cur_start_date();
	}
	private function set_cur_session() {
		if (!$file = parse_ini_file(self::$file)) throw new CustomException(debug_backtrace(), 'COULDN\'T OPEN session_term.txt');
		self::$cur_session = $file['session'];
	}
	private function set_cur_term() {
		if (!$file = parse_ini_file(self::$file)) throw new CustomException(debug_backtrace(), 'COULDN\'T OPEN session_term.txt');
		self::$cur_term = $file['term'];
	}
	private function set_cur_start_date() {
		if (!$file = parse_ini_file(self::$file)) throw new CustomException(debug_backtrace(), 'COULDN\'T OPEN session_term.txt');
		self::$cur_start_date = $file['start_date'];
	}
	public static function get_current_info() {//called in contr.php
		$array['session'] = self::$cur_session;
		$array['term'] = self::$cur_term;
		$array['start_date'] = self::$cur_start_date;
		return $array;
	}
	public function set_sess() {
		if ($this->input_session === self::$cur_session) {//changes only term and start date
			$content = 'session = '.self::$cur_session."\n";
			$content .= 'term = '.$this->input_term."\n";
			$content .= 'start_date = '.$this->start_date."\n";
			
		} else if ($this->input_session != self::$cur_session) {//changes session and term and start date
			$content = 'session = '.$this->input_session."\n";
			$content .= 'term = '.$this->input_term."\n";
			$content .= 'start_date = '.$this->start_date."\n";
		}
		if (!file_put_contents(self::$file, $content)) {
			throw new CustomException(debug_backtrace(), 'COULDN\'T ADD CONTENT TO session_term.txt');
		} else {
			$this->set_cur_session();
			$this->set_cur_term();
			echo '<strong>THE SCHOOL HAS BEEN SET TO '.self::$cur_session.' '.self::$cur_term.'.</strong>';
			echo '<article class=\'homepage\'><a href=\'./index.php\'>GO TO HOMEPAGE</a></article>';
		}
	}
}
//the following classes handle the logics of setting all subjects/class subjects
class Mod_Add_Subjects {
	private $subjects;
	public function __construct ($subjects) {
		$this->subjects = $subjects;
	}
	private function create_subject_name($subject) {
		if (strpos($subject, ' ')) {
			$subject = str_replace(' ', '_', $subject);
			$subject = strtolower($subject);
		}
		return $subject;
	}
	private function add_subjects() {
		$status = array();
		function execute($subject) {
			$status = false;
			$conn = Database::connect_db('admin');
			$subject = $conn->quote(strtoupper($subject));
			$sql = 'INSERT INTO subjects SET subject_name = '.$subject;
			if ($conn->query($sql) == false) {
				throw new CustomException(debug_backtrace(), 'COULDN\'N ADD '.$subject.' TO subjects.');
			} else {
				return true;
			}
		}
		if (is_array($this->subjects)) {
			foreach ($this->subjects as $subject) {
				if (!execute($subject)) $status[] = 'status';
			}
		} else {
			if (!execute($this->subjects)) $status[] = 'status';
		}
		if (sizeof($status) > 0) {
			return false;
		} else {
			return true;
		}
	}
	private function create_subject_table($obj) {
		$conn = $obj;
		$sql_txt = file_get_contents('../bin/new_subject_sql.txt');
		$sql_txt = trim($sql_txt);
		if (is_array($this->subjects)) {//adds multiple subjects
			foreach ($this->subjects as $subject) {
				$subject = $this->create_subject_name($subject);
				$sql = 'CREATE TABLE IF NOT EXISTS '.$subject.' ';
				$sql .= $sql_txt;
				if (!$conn->query($sql)) {
					throw new CustomException(debug_backtrace(), 'COULDN\'T CREATE TABLE '.$subject);
				}
			}
		} else {//adds just one subject
			$subject = $this->create_subject_name($this->subjects);
			$sql = 'CREATE TABLE IF NOT EXISTS '.$subject.' ';
			$sql .= $sql_txt;
			if (!$conn->query($sql)) {
				throw new CustomException(debug_backtrace(), 'COULDN\'T CREATE TABLE '.$subject);
			}
		}
		return true;
	}
	public function add_all_subjects() {
		$conn = Database::connect_db('admin');
		if ($this->create_subject_table($conn) && $this->add_subjects()) {
			echo '<strong>';
			if (is_array($this->subjects)) {//adds multiple subjects
				for ($i = 0; $i < sizeof($this->subjects); $i++) {
					if ($i == (sizeof($this->subjects) - 1))  {
						echo strtoupper($this->subjects[$i]).' ';
					} else {
						echo strtoupper($this->subjects[$i]).', ';
					}
				}
				echo 'HAVE BEEN ADDED TO THE SUBJECTS OFFERED IN THE SCHOOL.</h2>';
			} else {//adds just one subject
				echo strtoupper($this->subjects).' HAS BEEN ADDED TO THE SUBJECTS OFFERED IN THE SCHOOL.<strong>';
			}
		}
	}
}
class Mod_Add_Subject_Classes {
	private $subject;
	private $classes;
	public function __construct($subject, $classes) {
		$this->subject = $subject;
		$this->classes = $classes;
	}
	private function add_classes() {
		$conn = Database::connect_db('admin');
		function create_classes($subject, $classes) {
			$new_classes = '';
			for($i = 0; $i < sizeof($classes); $i++) {
				if ($i == sizeof($classes) - 1) {
					$new_classes .= trim($classes[$i]);
				} else $new_classes .= trim($classes[$i]).',';
			}
			return $new_classes;
		}
		function execute($obj, $subject, $classes) {
			if (empty($classes)) {
				$classes = 'NULL';
			} else {
				$classes = create_classes($subject, $classes);
				$classes = $obj->quote($classes);
			}
			$subject = $obj->quote($subject);
			$sql = 'UPDATE subjects SET classes = '.$classes.' WHERE subject_name = '.$subject;
			if (!$obj->query($sql)) {
				throw new CustomException(debug_backtrace(), 'COULDN\'T ADD '.$classes.' TO '.$subject);
			} else {
				return true;
			}
		}
		return execute($conn, $this->subject, $this->classes);
	}
	public function add_class_subjects() {
		if ($this->add_classes()) {
			if (!$this->classes) {
				echo '<strong>NO CLASS NOW OFFERS '.strtoupper($this->subject).'.</strong>';
			} else {
				echo '<strong>';
				if (sizeof($this->classes) > 1) {//adds multiple classes
					for ($i = 0; $i < sizeof($this->classes); $i++) {
						if ($i == (sizeof($this->classes) - 1))  {
							echo strtoupper($this->classes[$i]).' ';
						} else {
							echo strtoupper($this->classes[$i]).', ';
						}
					}
					echo 'CAN NOW REGISTER FOR '.strtoupper($this->subject).'.</strong>';
				} else {//adds just one subject
					echo strtoupper($this->classes[0]).' CAN NOW REGISTER FOR '.strtoupper($this->subject).'.</strong>';
				}
			}
		}
		echo '<article class=\'homepage\'><a href=\'./index.php\'>GO TO HOMEPAGE</a></article>';
	}
}
class Mod_Set_Teacher {
	private $type;
	private $class_subject;
	private $teacher_id;
	private $subject_teachers;
	private $subject_name;
	public function __construct ($type, $class_subject, $id) {
		$this->type = $type;
		$this->class_subject = $class_subject;
		if ($this->type == 'class') {
			$this->teacher_id = $id;
		} else if ($this->type == 'subject') {
			$this->subject_teachers = $id;
		}
	}
	private function create_statement($class = false) {//creates SQL statement
		if ($this->type == 'class') {
			$statement = 'UPDATE classes ';
			$statement .= 'SET class_teacher_id = :id ';
			$statement .= 'WHERE class_name = :class';
		} else if ($this->type == 'subject') {
			$statement = 'UPDATE subjects ';
			$statement .= 'SET '.$class.' = :id ';
			$statement .= 'WHERE subject_name = :subject';
		}
		return $statement;
	}
	private function prep_statement($obj, $statement) {//prepares the SQL statement
		if (!$pdos_obj = $obj->prepare($statement)) throw new CustomException(debug_backtrace(), 'UNABLE TO PREPARE THE SQL STATEMENT');
		return $pdos_obj;
	}
	private function execute_statement($obj = false) {//binds and execute the prepared SQL statement
		$sql_prep = $obj;
		if ($this->type == 'class') {
			$sql_prep->bindValue(':id', $this->teacher_id);
			$sql_prep->bindValue(':class', $this->class_subject);
			if (!$sql_prep->execute()) {
				throw new CustomException(debug_backtrace(), 'UNABLE TO EXECUTE THE SQL STATEMENT');
			} else {
				return true;
			}
		} else if ($this->type == 'subject') {
			foreach ($this->subject_teachers as $key => $value) {
				$sql_prep = $this->prep_statement(Database::connect_db('admin'), $this->create_statement($key));
				if (empty($value)) $value = NULL;
				$sql_prep->bindValue(':id', $value);
				$sql_prep->bindValue(':subject', $this->class_subject);
				if (!$sql_prep->execute()) {
					throw new CustomException(debug_backtrace(), 'UNABLE TO EXECUTE THE SQL STATEMENT');
				}
			}
			return true;
		}
	}
	public function set_teacher() {//compiles all set function. Called in contrl.
		$conn = Database::connect_db('admin');
		if ($this->type == 'class') {
			if (!$statement = $this->create_statement()) throw new CustomException(debug_backtrace(), 'UNABLE TO CREATE THE SQL STATEMENT');
			$pdos_obj = $this->prep_statement($conn, $statement);
			if (!$this->teacher_id) {
				$this->teacher_id = null;
			}
			if ($this->execute_statement($pdos_obj)) {
				if (!$this->teacher_id) {
					$name = 'NO ONE';
				} else {
					$name = Database::check_unique_id($this->teacher_id, 'staffs', 1);
					$name = $name['staff_first_name'].' '.$name['staff_last_name'];
				}
				echo '<b>'.$name.'</b> HAS BEEN SET AS '.$this->class_subject.' CLASS TEACHER.';
				echo '<article class=\'homepage\'><a href=\'./index.php\'>GO TO HOMEPAGE</a></article>';
			}
		} else if ($this->type == 'subject') {
			if ($this->execute_statement()) {
				echo '<p><strong>SUBJECT TEACHERS SUCCESSFULLY SET</strong><p>';
				echo '<article class=\'homepage\'><a href=\'./index.php\'>GO TO HOMEPAGE</a></article>';
			}
		}
	}
}
//the following classes handle the logics of sending mails
class Mod_Send_Mail {
	private $send_type;
	private $send_username;
	private $rec_type;
	private $receipient;
	private $title;
	private $mail;
	private $appendages;
	private static $mail_dir;
	private static $mail_id;
	private $orig_re;
	public function __construct($sender, $sender_user, $rec_type, $re, $title, $mail, $appendages = false) {
		$this->send_type = $sender;
		$this->send_username = $sender_user;
		$this->rec_type = $this->set_rec_type($rec_type);
		$this->orig_rec_type = $rec_type;
		$this->orig_re = $re[0];
		$this->receipient = $this->set_receipients($rec_type, $re);
		$this->title = $title;
		$this->mail = $mail;
		$this->appendages = $appendages;
		self::$mail_dir = '../bin/mails';
		self::$mail_id = $this->create_mail_identity();
		if ($this->receipient == false || sizeof($this->receipient) == 0) {
			$_SESSION['errors'] = ['Invalid destination'];
			header('location: ./send_mail.php?pe='.base64_encode($this->send_type).'&me='.base64_encode($this->send_username));
			die();
		}
	}
	private function set_receipients($rec_type, $re) {
		if ($rec_type == 'staff_username' || $rec_type == 'student_username') {
			$receipients = $re;
		} else if ($rec_type == 'staff_role') {
			$receipients = array();
			$role = $re[0];
			$array = Database::check_unique_class_role($role, 'staffs', 1);
			foreach ($array as $staff) {
				$receipients[] = $staff['staff_username'];
			}
		} else if ($rec_type == 'student_class') {
			$receipients = array();
			$class = $re[0];
			$conn = Database::connect_db('admin');
			$class = $conn->quote($class.'%');
			$sql = 'SELECT student_username FROM students WHERE student_class LIKE '.$class;
			$res = $conn->query($sql);
			while ($r = $res->fetch(PDO::FETCH_ASSOC)) {
				$receipients[] = $r['student_username'];
			}
		} else if ($rec_type == 'admin') {
			$receipients = array();
			$receipients[] = 'admin';
		} else if ($rec_type == 'subject_students') {
			$rec_array = explode('-',$re[0]);
			$subject = trim($rec_array[0]);
			$class = trim($rec_array[1]);
			$session =  new Mod_Change_Session;
			$session = $session->get_current_info()['session'];
			$receipients = Database::get_subject_students($subject, $class, $session, 'username');
		} else if ($rec_type == 'class_students') {
			$receipients = array();
			$class = trim($re[0]);
			$array = Database::check_unique_class_role($class, 'students', 1);
			foreach ($array as $student) {
				$receipients[] = $student['student_username'];
			}
		} else if ($rec_type == 'subject_teachers') {
			$receipients = $re;
		} else if ($rec_type == 'class_teacher') {
			$receipients = $re;
		}
		return $receipients;
	}
	private function set_rec_type($rec_type) {
		if ($rec_type == 'staff_username' || $rec_type == 'subject_teachers' || $rec_type == 'class_teacher' || $rec_type == 'staff_role') {
			$type = 'staff';
		} else if ($rec_type == 'student_username' || $rec_type == 'student_class' || $rec_type == 'subject_students' || $rec_type == 'class_students') {
			$type = 'student';
		} else if ($rec_type == 'admin') {
			$type = 'admin';
		}
		return $type;
	}
	private function create_mail_identity() {
		$letters = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
		$string = '';
		for ($i = 0; $i < 10; $i++) {
			$type = rand(1,3);
			if ($type == 1) {
				$string .= rand(0,9);
			} else {
				$string .= $letters[rand(0,25)];
			}
		}
		$dir = $string;
		return $dir;
	}
	private function upload_appendages() {
		if ($this->appendages == true) {
			$dir = '../bin/mails/appendages';
			$status = array();
			$index = 1;
			for ($i = 0; $i < sizeof($this->appendages['name']); $i++) { 
				if (!move_uploaded_file($this->appendages['tmp_name'][$i], $dir.'/'.self::$mail_id.'_'.$index.'.'.pathinfo($this->appendages['name'][$i], PATHINFO_EXTENSION))) {
					$status[] = 'status';
				}
				$index++;
			}
			if (sizeof($status) > 0) {
				throw new CustomException(debug_backtrace(), 'UNABLE TO UPLOAD APPENDAGE FOR '.self::$mail_id);	
			}
		}
		return true;
	}
	private function create_xml_content() {
		$content = '<?xml version=\'1.0\' encoding=\'utf-8\'?>'."\n";
		$content .= '<mail>'."\n";
		switch ($this->send_type) {
			case 'admin':
				$sender = 'ADMIN';
				break;
			case 'staff':
				$name = Database::check_unique_username($this->send_username, 'staffs', 1);
				$sender = $name['staff_first_name'].' '.$name['staff_last_name'];
				break;
			case 'student':
				$name = Database::check_unique_username($this->send_username, 'students', 1);
				$sender = $name['student_first_name'].' '.$name['student_last_name'];
				break;
			default:
				// code...
				break;
		}
		$content .= '<sender>'.$sender.'</sender>'."\n";
		$content .= '<receipients type=\''.$this->rec_type.'\'>'."\n";
		if ($this->orig_rec_type == 'staff_username' || $this->orig_rec_type == 'student_username' || $this->orig_rec_type == 'class_teacher' || $this->orig_rec_type == 'subject_teachers') {
			foreach ($this->receipient as $key) {
				$name = Database::check_unique_username($key, $this->rec_type.'s', 1);
				$receipient = $name[$this->rec_type.'_first_name'].' '.$name[$this->rec_type.'_last_name'];
				$content .= '<name>'.$receipient.'</name>'."\n";
			}
		} else {
			if ($this->orig_re == 'TEACHER') {
				$content .= '<name>'.strtoupper($this->orig_re).'S</name>'."\n";
			} else {
				$content .= '<name>'.strtoupper($this->orig_re).'</name>'."\n";
			}
		}
		$content .= '</receipients>'."\n";
		$content .= '<date>'.date('d-M-Y H:i').'</date>'."\n";
		$content .= '<title>'.$this->title.'</title>'."\n";
		if ($this->appendages) {
			$content .= '<appendages>'."\n";
			$index = 1;
			foreach ($this->appendages['name'] as $appendage) {
				$content .= '<appendage type=\''.pathinfo($appendage, PATHINFO_EXTENSION).'\'>';
				$content .= self::$mail_id.'_'.$index;
				$content .= '</appendage>';
				$index++;
			}
			$content .= '</appendages>'."\n";
		}
		$content .= '<message>'."\n";
		$content .= $this->mail."\n";
		$content .= '</message>'."\n";
		$content .= '</mail>'; 
		return $content;
	}
	private function get_receipient_file($rec, $rec_type) {
		if ($rec_type == 'admin') {
			$file = '../bin/xmls/admin_mails.xml';
		} else {
			$name = Database::check_unique_username($rec, $rec_type.'s', 1);
			$file = '../bin/xmls/'.$rec_type.'s/'.$name[$rec_type.'_id'].'.xml';
		}
		return $file;
	}
	private function add_to_receipient() {
		$status = array();
		foreach ($this->receipient as $receipient) {
			$filename = $this->get_receipient_file($receipient, $this->rec_type);
			$xml = simplexml_load_file($filename);
			$mail_obj = $xml->mails->received;
			$mail = $mail_obj->addChild('mail', self::$mail_id);
			if (!file_put_contents($filename, $xml->asXML())) throw new CustomException(debug_backtrace(), 'UNABLE TO ADD ID TO RECEIPIENT');
		}
		return true;
	}
	private function add_to_sender() {
		switch ($this->send_type) {
			case 'admin':
				$filename = '../bin/xmls/admin_mails.xml';
				break;
			case 'staff':
				$sender = $this->send_username;
				$filename = $this->get_receipient_file($sender, $this->send_type);
				break;
			case 'student':
				$sender = $this->send_username;
				$filename = $this->get_receipient_file($sender, $this->send_type);
				break;
			default:
				// code...
				break;
		}
		$xml = simplexml_load_file($filename);
		$mail_obj = $xml->mails->sent;
		$mail = $mail_obj->addChild('mail', self::$mail_id);
		if (!file_put_contents($filename, $xml->asXML())) throw new CustomException(debug_backtrace(), 'UNABLE TO ADD ID TO SENDER');
		return true;
	}
	private function update_counter() {
		$status = array();
		$conn = Database::connect_db('admin');
		foreach ($this->receipient as $receipient) {
			if ($this->rec_type != 'admin') {
				$info = Database::check_unique_username($receipient, $this->rec_type.'s', 1);
				$id = $info[$this->rec_type.'_id'];
				$username = $this->rec_type.'_'.$id;
				$username = $conn->quote($username);
			} else {
				$username = $conn->quote('admin');
			}
			if (!$conn->query('UPDATE mails SET counter = counter + 1 WHERE username = '.$username)) $status[] = 'status';
		}
		if (sizeof($status) > 0) {
			throw new CustomException(debug_backtrace(), 'UNABLE TO INCREMENT COUNTER');
		} else {
			return true;
		}
	}
	private function create_mail($dir, $content) {
		if (!file_put_contents($dir, $content)) {
			throw new CustomException(debug_backtrace(), 'UNABLE TO PUT MAIL IN XML FILE');
		} else {
			return true;
		}
	}
	public function send_mail() {
		$file_dir = self::$mail_dir.'/'.self::$mail_id.'.xml';
		$mail_content = $this->create_xml_content();
		if ($this->create_mail($file_dir, $mail_content) && $this->add_to_receipient() && $this->add_to_sender() && $this->update_counter() && $this->upload_appendages()) {
			if ((basename($_SERVER['HTTP_REFERER']) != 'addresults.php') && (basename($_SERVER['HTTP_REFERER']) != 'promote_students.php')) {
				echo '<b>MAIL HAS BEEN SUCCESSFULLY SENT TO ';
				if ($this->orig_rec_type == 'staff_username' || $this->orig_rec_type == 'student_username' || $this->orig_rec_type == 'class_teacher' || $this->orig_rec_type == 'subject_teachers') {
					for ($i = 0; $i < sizeof($this->receipient); $i++) {
						$name = Database::check_unique_username($this->receipient[$i], $this->rec_type.'s', 1);
						$receipient = $name[$this->rec_type.'_first_name'].' '.$name[$this->rec_type.'_last_name'];
						if ($i == (sizeof($this->receipient) - 1)) {
							echo strtoupper($receipient).'.';
						} else {
							echo strtoupper($receipient).', ';
						}
					}
				} else {
					if ($this->orig_re == 'TEACHER') {
						echo strtoupper($this->orig_re).'S.';
					} else {
						echo strtoupper($this->orig_re).'.';
					}
				}
				echo '<b>';
				echo '<article class=\'homepage\'><a href=\'./index.php?pe='.base64_encode($this->send_type).'&me='.base64_encode($this->send_username).'\'>BACK TO MAILBOX.</a></article>';
				echo '<p></p>';
			}
		}
	}
}
class Mod_Read_Mails {
	private $type;
	private $mode;
	private $username;
	private $search_text;
	private $search = false;
	public function __construct($mode, $type, $username = false, string $search_text = null) {
		$this->mode = $mode;
		$this->type = $type;
		$this->username = $username;
		if ($search_text) {
			$this->search = true;
			$this->search_text = $search_text;
		}
	}
	private function create_filename() {
		if ($this->type == 'admin') {
			$file = '../bin/xmls/admin_mails.xml';
		} else {
			$name = Database::check_unique_username($this->username, $this->type.'s', 1);
			$name = $name[$this->type.'_id'];
			$file = '../bin/xmls/'.$this->type.'s'.'/'.$name.'.xml';
		}
		return $file;
	}
	private function retrieve_mail_ids() {
		$array = array();
		$xml = simplexml_load_file($this->create_filename());
		if ($this->mode == 'sent') {
			foreach ($xml->mails->sent->children() as $mail_id) {
				if ($this->search) {
					$file = '../bin/mails/'.$mail_id.'.xml';
					$xml = @simplexml_load_file($file);
					if (preg_match('/'.$this->search_text.'/i', $xml->title)) {
						$array[] = $mail_id;
					}
				} else {
					$array[] = $mail_id;
				}
			}
		} else if ($this->mode == 'received') {
			foreach ($xml->mails->received->children() as $mail_id) {
				if ($this->search) {
					$file = '../bin/mails/'.$mail_id.'.xml';
					$xml = @simplexml_load_file($file);
					if (preg_match('/'.$this->search_text.'/i', $xml->title)) {
						$array[] = $mail_id;
					}
				} else {
					$array[] = $mail_id;
				}
			}
		}
		if (sizeof($array) > 0) {
			return array_reverse($array);
		} else {
			return null;
		}
	}
	public function count_all_mails() {
		return $this->retrieve_mail_ids() ? count($this->retrieve_mail_ids()) : 0;
	}
	private function create_read_links(array $array = null, string $new = null) : string {
		$string = '';
		if ($array) {
			$index = 1;
			foreach ($array as $mail) {
				$receivers = array();
				$file = '../bin/mails/'.$mail.'.xml';
				$xml = @simplexml_load_file($file);
				if ($xml) {
					if ($this->type == 'admin' && $xml->sender == 'ADMIN') {
						$sender = 'You';
					} else if ($this->type == 'staff' || $this->type == 'student') {
						$name = Database::check_unique_username($this->username, $this->type.'s', 1);
						$name = $name[$this->type.'_first_name'].' '.$name[$this->type.'_last_name'];
						if ($xml->sender == $name) {
							$sender = 'You';
						} else {
							$sender = $xml->sender;
						}
					} else {
						$sender = $xml->sender;
					}
					foreach ($xml->receipients->children() as $name) {
						$receivers[] = $name;
					}
					$date = $xml->date;
					$title = $xml->title;
					if (strlen($xml->message) > 90) {
						$message = substr($xml->message, 0, 90).'...';
					} else {
						$message = $xml->message;
					}
					if ($this->mode == 'sent') {
						$link = './read_mail.php?id='.$mail.'&mode=nt&pe='.base64_encode($this->type).'&me='.base64_encode($this->username);
					} else if ($this->mode == 'received') {
						$link = './read_mail.php?id='.$mail.'&mode=ed&pe='.base64_encode($this->type).'&me='.base64_encode($this->username);
					}
					$string .= '<article class=\'mails_item';
					$string .= $index++ <= $new ? ' new_mail' : '';
					$string .= '\' >';
					$string .= '<a href=\''.$link.'\'>';
					if (isset($xml->appendages)) $string .= '<i class=\'fa-solid fa-paperclip fa-lg\'></i>';
					$string .= '<div class=\'mails_item_info\'>';
					$string .= '<b>From:</b> '.$sender.'.<br>';
					$string .= '<b>To:</b> ';
					if ($this->mode == 'sent') {
						for ($i = 0; $i < sizeof($receivers); $i++) {
							if ($i == 2) {
								$string .= 'and others.';
								break;
							} else {
								if ($i == (sizeof($receivers) - 1)) {
									$string .= $receivers[$i].'.';
								} else {
									$string .= $receivers[$i].', ';
								}
							}
						}
					} else if ($this->mode == 'received') {
						if (sizeof($receivers) > 1) {
							$string .= 'You and others.';
						} else {
							if ($this->type != 'admin') {
								$name = Database::check_unique_username($this->username, $this->type.'s', 1);
								$name = $name[$this->type.'_first_name'].' '.$name[$this->type.'_last_name'];
								if (strtoupper($name) == strtoupper($receivers[0])) {
									$string .= 'You.';
								} else {
									$string .= $receivers[0].'.';
								}
							} else {$string .= 'You.';}
						}
					}
					$string .= '<br>';
					$string .= '<b>Date: </b> '.$date.'.<br>';
					$string .= '<b>Title of mail: </b> '.$title.'<br>';
					$string .= '</div><div class=\'mails_item_message\'>';
					$string .= '<b>Message: </b>'.evaluateText($message).'</div>';
					$string .= '</a>';
					$string .= '</article><hr>';
				}
			}
		} else {
			if ($this->search) {
				$string .= '<strong>NO MATCH FOUND.</strong>';
			} else {
				if ($this->mode == 'sent') {
					$string .= '<strong>YOU HAVE NOT SENT ANY MAILS YET.</strong>';
				} else if ($this->mode == 'received') {
					$string .= '<strong>YOU HAVE NOT RECEIVED ANY MAILS YET.</strong>';
				}
			}
		}
		return $string;
	}
	private function reset_counter() {
		$conn = Database::connect_db('admin');
		if ($this->type != 'admin') {
			$info = Database::check_unique_username($this->username, $this->type.'s', 1);
			$id = $info[$this->type.'_id'];		
			$username = $this->type.'_'.$id;
			$username = $conn->quote($username);
		} else {
			$username = $conn->quote('admin');
		}
		$sql = 'UPDATE mails SET counter = 0 WHERE username = '.$username;
		if (!$conn->query($sql)) throw new CustomException(debug_backtrace(), 'UNABLE TO RESET COUNTER');
		return true;
	}
	public function ret_mails(string $new = null) {
		$this->reset_counter();
		$mails = $this->retrieve_mail_ids();
		return $this->create_read_links($mails, $new);
	}
}
//the following classes handle the logics behind promoting(updating) students classes
class Mod_Promote_Students {
	private $type;
	private $students;
	protected $current_class;
	private $next_class;
	protected $session;
	public function __construct($type, $studs, $cur, $next, $sess) {
		$this->type = $type;
		$this->students = $studs;
		$this->current_class = $cur;
		$this->next_class = $next;
		$this->session = $sess;
	}
	private function create_statement($student, $next) {
		if ($this->type == 'all') {
			$sql = 'UPDATE students SET student_class = '.$next.' WHERE student_class = '.$student;
		} else if ($this->type == 'selected') {
			$sql = 'UPDATE students SET student_class = '.$next.' WHERE student_id = '.$student;
		}
		return $sql;
	}
	private function execute_statement() {
		$status = array();
		$conn = Database::connect_db('admin');
		if ($this->type == 'all') {
			$class = $conn->quote($this->students);
			$next = $conn->quote($this->next_class);
			if (!$conn->query($this->create_statement($class, $next))) throw new CustomException(debug_backtrace(), 'UNABLE TO UPDATE STUDENT CLASS');
		} else if ($this->type == 'selected') {
			$next = $conn->quote($this->next_class);
			foreach ($this->students as $student) {
				if (!$conn->query($this->create_statement($student, $next))) $status[] = 'status';
				if (sizeof($status) > 0) {
					throw new CustomException(debug_backtrace(), 'UNABLE TO UPDATE STUDENT CLASS');
				}
			}
		}
		return true;
	}
	protected function update_sessions_file() {
		$file = '../bin/sessions.xml';
		$session_exist = false;
		if (!$xml = simplexml_load_file($file)) throw new CustomException(debug_backtrace(), 'UNABLE TO LOAD XML FILE');
		foreach ($xml->children() as $sess) {
			if ($sess['session'] == $this->session) {
				$session = $sess;
				$session_exist = true;
				break;
			}
		}
		if (!$session_exist) {
			$session = $xml->addChild('session');
			$session->addAttribute('session', $this->session);
		}
		$class_exist = false;
		$higher_classes = [];
		if (!preg_match('/SSS 3/', $this->current_class)) {
			$next_class = [];
			preg_match('/(\w+) (\d+)(.*)/', $this->current_class, $next_class);
			if ($next_class[2] + 1 > 3) {
				$next_class[1] = 'SSS';
				$next_class[2] = 0;
			}
			$next_class = $next_class[1].' '.++$next_class[2];
			foreach (CLASSES as $key => $value) {
				if (preg_match('/'.$next_class.'/', $value)) {
					$higher_classes = array_slice(CLASSES, $key);
					break;
				}
			}
		}
		$already_promoted = [];
		foreach($session->children() as $class) {
			$already_promoted[] = $class;
			if ($class == $this->current_class) {
				$class_exist = true;
			}
		}
		foreach ($higher_classes as $class) {//promotes all higher classes that haven't been already promoted in the case where a lower class is being promoted before other empty higher classes.
			if (!in_array($class, $already_promoted)) {
				$session->addChild('class', $class);
			}
		}
		if (!$class_exist) {
			$session->addChild('class', $this->current_class);
		}
		$content = $xml->asXML();
		if (!file_put_contents($file, $content)) throw new CustomException(debug_backtrace(), 'UNABLE TO PUT CONTENT IN SESSIONS XML FILE');
		return true;
	}
	public static function get_promoted_classes($sess) {
		$classes = array();
		$file = '../bin/sessions.xml';
		$session_exist = false;
		if (!$xml = simplexml_load_file($file)) throw new CustomException(debug_backtrace(), 'UNABLE TO LOAD XML FILE');
		foreach ($xml->children() as $child_sess) {
			if ($child_sess['session'] == $sess) {
				$session = $child_sess;
				$session_exist = true;
				break;
			}
		}
		if ($session_exist) {
			foreach ($session->children() as $class) {
				$classes[] = $class;
			}
		}
		return $classes;
	}
	public function promote_students() {
		if ($this->execute_statement() && $this->update_sessions_file()) {
			if ($this->type == 'all') {
				echo 'ALL STUDENTS IN '.$this->current_class.' HAVE BEEN PROMOTED TO '.$this->next_class.'.';
			} else if ($this->type == 'selected') {
				echo 'SELECTED STUDENTS FROM '.$this->current_class.' HAVE BEEN PROMOTED TO '.$this->next_class.'.';
			}
			echo '<article class=\'homepage\'><div><a href=\'./index.php\'>GO TO HOMEPAGE</a></div></article>';
		}
	}
}
class Mod_Graduate_Students extends Mod_Promote_Students{
	private $type;
	private $students;
	protected $current_class;
	protected $session;
	private $orig_session;
	public function __construct($type, $studs, $cur, $sess, $orig_sess) {
		$this->type = $type;
		$this->students = $studs;
		$this->current_class = $cur;
		$this->session = $sess;
		$this->orig_session = $orig_sess;
	}
	private function get_info() {
		$infos = array();
		if ($this->type == 'all') {
			$students = Database::check_unique_class_role($this->current_class, 'students', 1);
			foreach ($students as $student) {
				$class = explode(' ', $student['student_class']);
				$class = $class[2];
				$infos[] = $student['student_first_name'].' '.$student['student_last_name'].'/'.$class.'/'.$student['student_username'];
			}
		} else if ($this->type == 'selected') {
			foreach ($this->students as $student) {
				$info = Database::check_unique_id($student, 'students', 1);
				$class = explode(' ', $info['student_class']);
				$class = $class[2];
 				$infos[] = $info['student_first_name'].' '.$info['student_last_name'].'/'.$class.'/'.$info['student_username'];
			}
		}
		return $infos;
	}
	private function create_string($array) {
		$string = '';
		foreach ($array as $stud) {
			$string .= $stud."\n";
		}
		return $string;
	}
	private function create_graduate_file($string) {
		$filename = str_replace('/', '-', $this->orig_session).'_graduands';
		$file_dir = '../bin/graduands/'.$filename.'.txt';
		$dir = '../bin/graduands';
		$dir = opendir($dir);
		$file = readdir($dir);
		$files = array();
		while($file != false) {
			$files[] = $file;
			$file = readdir($dir);
		}
		if (in_array(basename($file_dir), $files)) {
			if (!file_put_contents($file_dir, $string, FILE_APPEND)) throw new CustomException(debug_backtrace(), 'UNABLE TO PUT CONTENT IN GRADUAND FILE');
		} else {
			if (!file_put_contents($file_dir, $string)) throw new CustomException(debug_backtrace(), 'UNABLE TO PUT CONTENT IN GRADUAND FILE');
		}
		return true;
	}
	private function delete_students($db_handle) {
		$conn = $db_handle;
		$class = $conn->quote($this->current_class);
		if ($this->type == 'all') {
			$sql = 'DELETE t1, t2, t3 FROM students as t1 INNER JOIN students_bio as t2 ON t1.student_id = t2.student_id INNER JOIN mails as t3 ON concat(\'student_\', t1.student_id) = t3.username WHERE t1.student_class = '.$class;
			if (!$conn->query($sql)) throw new CustomException(debug_backtrace(), 'UNABLE TO DELETE STUDENTS IN '.$this->current_class);
		} else if ($this->type == 'selected') {
			foreach ($this->students as $student) {
				$sql = 'DELETE t1, t2, t3 FROM students as t1 INNER JOIN students_bio as t2 ON t1.student_id = t2.student_id INNER JOIN mails as t3 ON concat(\'student_\', t1.student_id) = t3.username WHERE t1.student_id = '.$student;
				if (!$conn->query($sql)) throw new CustomException(debug_backtrace(), 'UNABLE TO DELETE STUDENTS IN '.$this->current_class);
			}
		}
		return true;
	}
	private function delete_from_subjects($db_handle) {
		$conn = $db_handle;
		$subjects = Database::get_all_subjects();
		foreach ($subjects as $subject) {
			$subject = str_replace(' ', '_', $subject);
			if ($this->type == 'all') {
				$students = Database::check_unique_class_role($this->current_class, 'students', 1);
				$sql = 'DELETE FROM '.$subject.' WHERE student_id IN (';
				for ($i = 0; $i < sizeof($students); $i++) { 
					if ($i == (sizeof($students) - 1)) {
						$sql .= $students[$i]['student_id'].')';
					} else {
						$sql .= $students[$i]['student_id'].',';
					}
				}
				if (!$conn->query($sql)) {
					throw new CustomException(debug_backtrace(), 'UNABLE TO DELETE IDS FROM '.$subject);
				}	
			} else if ($this->type == 'selected') {
				foreach ($this->students as $student) {
					$sql = 'DELETE FROM '.$subject.' WHERE student_id = '.$student;
					if (!$conn->query($sql)) {
						throw new CustomException(debug_backtrace(), 'UNABLE TO DELETE '.$student.' FROM '.$subject);
					}
				}
			}
		}
		return true;
	}
	private function delete_files($db_handle) {
		$conn = $db_handle;
		if ($this->type == 'all') {
			$students = Database::check_unique_class_role($this->current_class, 'students', 1);
			foreach ($students as $student) {
				if (!$res = $conn->query('SELECT student_passport FROM students_bio WHERE student_id = '.$student['student_id']))  throw new CustomException(debug_backtrace(), 'UNABLE TO FETCH PASSPORTS FROM DB');
				$passport = $res->fetch(PDO::FETCH_ASSOC)['student_passport'];
				if (!unlink($passport)) {
					throw new CustomException(debug_backtrace(), 'UNABLE TO DELETE PASSPORT FILE '.$passport);
				}
			}

			foreach ($students as $student) {
				$file = '../bin/xmls/students/'.$student['student_id'].'.xml';
				if (!unlink($file)) {
					throw new CustomException(debug_backtrace(), 'UNABLE TO DELETE XML FILE '.$file);
				}
			}

		} else if ($this->type == 'selected') {
			foreach ($this->students as $student) {
				if (!$res = $conn->query('SELECT student_passport FROM students_bio WHERE student_id = '.$student))  throw new CustomException(debug_backtrace(), 'UNABLE TO FETCH PASSPORTS FROM DB');
				$passport = $res->fetch(PDO::FETCH_ASSOC)['student_passport'];
				if (!unlink($passport)) {
					throw new CustomException(debug_backtrace(), 'UNABLE TO DELETE PASSPORT FILE '.$passport);
				}
			}

			foreach ($this->students as $student) {
				$file = '../bin/xmls/students/'.$student.'.xml';
				if (!unlink($file)) {
					throw new CustomException(debug_backtrace(), 'UNABLE TO DELETE XML FILE '.$file);
				}
			}

		}
		
		return true;
	}
	private function archive_results() {
		if ($this->type == 'all') {
			$students = Database::check_unique_class_role($this->current_class, 'students', 1);
			$array = [];
			foreach ($students as $student) {
				$array[] = $student['student_id'];
			}
			$students = $array;
		} else if ($this->type == 'selected') {
			$students = $this->students;
		}
		if (create_archive($students)) return true;
	}
	public function graduate_students() {
		$students = $this->get_info();
		$string = $this->create_string($students);
		$conn = Database::connect_db('admin');
		if ($this->create_graduate_file($string) && $this->update_sessions_file() && $this->archive_results()) {
			$conn->beginTransaction();
			if ($this->delete_files($conn) && $this->delete_from_subjects($conn)) {
				if ($this->delete_students($conn)) {
					$conn->commit();
					echo '<p>THE SELECTED STUDENT(S) HAVE BEEN SUCCESSFULLY PASSED OUT OF THE SCHOOL.</p>';
					echo '<article class=\'homepage\'><div><a href=\'./index.php\'>GO TO HOMEPAGE</a></div></article>';
				} else $conn->rollBack();
			} else $conn->rollBack();
		}
	}
}
//the following classes handle student registration logics
class Mod_Register_Student {
	private $subjects;
	private $student_id;
	private $student_class;
	private $orig_class;
	private $session;
	public function __construct($subs, $id, $class, $sess) {
		$this->subjects = $subs;
		$this->student_id = $id;
		$this->orig_class = $class;
		switch ($class) {
			case 'JSS 1':
				$this->student_class = 1;
				break;
			case 'JSS 2':
				$this->student_class = 2;
				break;
			case 'JSS 3':
				$this->student_class = 3;
				break;
			case 'SSS 1 ART':
				$this->student_class = 4;
				break;
			case 'SSS 1 COMMERCIAL':
				$this->student_class = 5;
				break;
			case 'SSS 1 SCIENCE':
				$this->student_class = 6;
				break;
				case 'SSS 2 ART':
				$this->student_class = 7;
				break;
			case 'SSS 2 COMMERCIAL':
				$this->student_class = 8;
				break;
			case 'SSS 2 SCIENCE':
	 			$this->student_class = 9;
				break;
				case 'SSS 3 ART':
				$this->student_class = 10;
				break;
			case 'SSS 3 COMMERCIAL':
				$this->student_class = 11;
				break;
			case 'SSS 3 SCIENCE':
				$this->student_class = 12;
				break;
			default:
				// code...
				break;
		}
		$this->session = $sess;
	}
	private function insert_into_subject_table() {
		$status = array();
		foreach ($this->subjects as $subject) {
			$subject = str_replace(' ', '_', $subject);
			$conn = Database::connect_db('staff');
			$id = $this->student_id;
			$class = $this->student_class;
			$session = $conn->quote($this->session);
			$sql = 'INSERT INTO '.$subject.' SET student_id = '.$id.', student_class = '.$class.', session = '.$session;
			if (!$conn->query($sql)) $status[] = 'status'; 
		}
		if (sizeof($status) > 0) {
			throw new CustomException(debug_backtrace(), 'UNABLE TO INSERT STUDENT INTO SUBJECT');
		}
		return true;
	}
	private function update_student_xml() {
		$terms = array('first_term', 'second_term', 'third_term');
		$file = $this->student_id;
		$file = '../bin/xmls/students/'.$file.'.xml';
		if (!$xml = simplexml_load_file($file)) throw new CustomException(debug_backtrace(), 'UNABLE TO OPEN XML FOR STUDENT '.$this->student_id);
		$session = $xml->sessions->addChild('session');
		$session->addAttribute('session',$this->session);
		$session->addAttribute('class', Database::check_unique_id($this->student_id, 'students', 1)['student_class']);
		foreach ($this->subjects as $subject) {
			$session->addChild('subject', $subject);
		}
		foreach ($terms as $term) {
			$new_term = $session->addChild($term);
		}
		$new_xml = $xml->asXML();
		if (!file_put_contents($file, $new_xml)) throw new CustomException(debug_backtrace(), 'UNABLE TO PUT NEW XML CONTENT IN FILE');
		return true;
	}
	public function register_student() {
		if ($this->insert_into_subject_table() && $this->update_student_xml()) {
			$name = Database::check_unique_id($this->student_id, 'students', 1);
			$name = $name['student_first_name'].' '.$name['student_last_name'];
			echo '<p>'.$name .' HAS BEEN SUCCESSFULLY REGISTERED INTO '.$this->orig_class.'.</p>';
			echo '<article class=\'homepage\'><div><a href=\'./index.php\'>GO TO HOMEPAGE</a></div></article>';
		}
	}
}
class Mod_Check_Registered {
	private $students;
	private $session;
	public function __construct($array, $sess) {
		$this->students = $array;
		$this->session = $sess;
	}
	private function read_xmls($student) {
		$file = $student['student_id'];
		$file = '../bin/xmls/students/'.$file.'.xml';
		return $file;
	}
	private function check_session() {
		$checked = array();
		$index = 0;
		foreach ($this->students as $student) {
			$reg = false;
			$file = $this->read_xmls($student);
			if (!$xml = simplexml_load_file($file)) throw new CustomException(debug_backtrace(), 'UNABLE TO OPEN XML FOR STUDENT');
			foreach ($xml->sessions->children() as $session) {
				if ($session['session'] == $this->session) {
					$reg = true;
					break;
				}
			}
			if ($reg) {
				$checked[$index]['student'] = $student;
				$checked[$index]['status'] = 'reg';
			} else {
				$checked[$index]['student'] = $student;
				$checked[$index]['status'] = 'no_reg';
			}
			$index++;
		}
		return $checked;
	}
	public function check_registered() {
		return $this->check_session();
	}
}
//the following classes handles the logics of adding student results to db
class Mod_Add_Results {
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
	private function create_statement() {
		$subject = strtolower(str_replace(' ', '_', $this->subject));
		$column = '';
		if ($this->term == 'FIRST TERM') {
			$column .= 'first_';
		} else if ($this->term == 'SECOND TERM') {
			$column .= 'second_';
		} else if ($this->term == 'THIRD TERM') {
			$column .= 'third_';
		}
		if ($this->res_type == '1ST C.A. TEST') {
			$column .= '1_ca';
		} else if ($this->res_type == '2ND C.A. TEST') {
			$column .= '2_ca';
		} else if ($this->res_type == 'ASSIGNMENT') {
			$column .= 'ass';
		} else if ($this->res_type == 'EXAMINATION') {
			$column .= 'exam';
		}
		$sql = 'UPDATE '.$subject.' SET '.$column.' = :score WHERE student_id = :id AND session = :sess';
		return $sql;
	}
	private function prep_statement($obj, $statement) {
		if (!$pdos_obj = $obj->prepare($statement)) throw new CustomException (debug_backtrace(), 'UNABLE TO PREPARE STATEMENT.');
		return $pdos_obj;
	}
	private function execute_statement($pdos) {
		$status = array();
		for ($i = 0; $i < sizeof($this->ids); $i++) { 
			if (empty($this->scores[$i]) && $this->scores[$i] != '0') {$this->scores[$i] = null;}
			$pdos->bindValue(':score', $this->scores[$i]);
			$pdos->bindValue(':id', $this->ids[$i]);
			$pdos->bindValue(':sess', $this->session);
			if (!$pdos->execute()) $status[] = 'status';
		}
		if (sizeof($status) > 0) {
			throw new CustomException(debug_backtrace(), 'UNABLE TO EXECUTE SQL STATEMENT');
		}
		return true;
	}
	public function add_results() {
		$conn = Database::connect_db('staff');
		if (!$sql = $this->create_statement()) throw new CustomException(debug_backtrace(), 'UNABLE CREATE SQL STATEMENT.');
		$pdos_obj = $this->prep_statement($conn, $sql);
		if ($this->execute_statement($pdos_obj)) {
			echo $this->class.' '.$this->res_type.' RESULTS HAVE BEEN SUCCESSFULLY ADDED.';
			echo '<article class=\'homepage\'><div><a href=\'./index.php\'>GO TO HOMEPAGE</a></div></article>';
		}

	}
}
//the following classes handle the logic behind checking of student result
class Mod_Check_Student_Result {
	private $student_id;
	private $session;
	private $term;
	public function __construct($student_id, $sess, $term) {
		$this->student_id = $student_id;
		$this->session = $sess;
		$this->term = $term;
	}
	private function get_session_subjects() {
		$subjects = xml::get_session_subjects($this->student_id, $this->session);
		return $subjects;
	}
	private function get_results($subs) {
		$results = Database::check_student_result($this->student_id, $subs, $this->session, $this->term);
		return $results;
	}
	public function check_student_result() {
		$subjects = $this->get_session_subjects();
		$result = $this->get_results($subjects);
		return $result;
	}
}
class Mod_Get_Unpublished_Results {
	private $class;
	private $unpublished;
	private $cur_session;
	private $cur_term;
	public function __construct($class, $sess, $term) {
		$this->class = $class;
		$this->unpublished = array();
		$this->cur_session = $sess;
		$this->cur_term = $term;
	}
	private function get_students_ids() {
		$ids = array();
		$students = Database::check_unique_class_role($this->class, 'students', 1);
		foreach ($students as $student) {
			$ids[] = $student['student_id'];
		}
		return $ids;
	}
	private function get_files($ids) {
		$files = array();
		foreach ($ids as $id) {
			$files[] = XML::create_file_name($id, 'student');
		}
		return $files;
	}
	private function check_status($files) {
		$index = 0;
		foreach ($files as $file) {
			if (!$xml = simplexml_load_file($file)) throw new CustomException(debug_backtrace(), 'UNABLE TO LOAD XML FILE.');
			$sessions = $xml->sessions->session;
			foreach ($sessions as $session) {
				if ($session['session'] != $this->cur_session) {
					if (!$session->first_term->published) {
						$this->unpublished[$index][0]['student_id'] = $xml['id'];
						$name = Database::check_unique_id($xml['id'], 'students', 1);
						$name = $name['student_first_name'].' '.$name['student_last_name'];
						$this->unpublished[$index][0]['name'] = $name;
						$this->unpublished[$index][0]['session'] = $session['session'];
						$this->unpublished[$index][0]['term'] = 'first term';	
					}
					if (!$session->second_term->published) {
						$this->unpublished[$index][1]['student_id'] = $xml['id'];
						$name = Database::check_unique_id($xml['id'], 'students', 1);
						$name = $name['student_first_name'].' '.$name['student_last_name'];
						$this->unpublished[$index][1]['name'] = $name;
						$this->unpublished[$index][1]['session'] = $session['session'];
						$this->unpublished[$index][1]['term'] = 'second term';	
					} 
					if (!$session->third_term->published) {
						$this->unpublished[$index][2]['student_id'] = $xml['id'];
						$name = Database::check_unique_id($xml['id'], 'students', 1);
						$name = $name['student_first_name'].' '.$name['student_last_name'];
						$this->unpublished[$index][2]['name'] = $name;
						$this->unpublished[$index][2]['session'] = $session['session'];
						$this->unpublished[$index][2]['term'] = 'third term';	
					}
				} else {
					if (!$session->first_term->published) {
						$this->unpublished[$index][0]['student_id'] = $xml['id'];
						$name = Database::check_unique_id($xml['id'], 'students', 1);
						$name = $name['student_first_name'].' '.$name['student_last_name'];
						$this->unpublished[$index][0]['name'] = $name;
						$this->unpublished[$index][0]['session'] = $session['session'];
						$this->unpublished[$index][0]['term'] = 'first term';	
					}
					if (!$session->second_term->published && $this->cur_term != 'FIRST TERM') {
						$this->unpublished[$index][1]['student_id'] = $xml['id'];
						$name = Database::check_unique_id($xml['id'], 'students', 1);
						$name = $name['student_first_name'].' '.$name['student_last_name'];
						$this->unpublished[$index][1]['name'] = $name;
						$this->unpublished[$index][1]['session'] = $session['session'];
						$this->unpublished[$index][1]['term'] = 'second term';	
					} 
					if (!$session->third_term->published && $this->cur_term != 'FIRST TERM' && $this->cur_term != 'SECOND TERM') {
						$this->unpublished[$index][2]['student_id'] = $xml['id'];
						$name = Database::check_unique_id($xml['id'], 'students', 1);
						$name = $name['student_first_name'].' '.$name['student_last_name'];
						$this->unpublished[$index][2]['name'] = $name;
						$this->unpublished[$index][2]['session'] = $session['session'];
						$this->unpublished[$index][2]['term'] = 'third term';	
					}

				}
				$index++;
			}
		}
		return true;
	}
	public function get_unpublished_results() {
		$students_ids = $this->get_students_ids();
		$files = $this->get_files($students_ids);
		if ($this->check_status($files)) {
			$unpublished = $this->unpublished;
			return $unpublished;
		}
	}
}
class Mod_Publish_Results {
	private $results;
	public function __construct($res) {
		$this->results = array();
		foreach ($res as $re) {
			$this->results[] = explode('_', $re);
		}
 	}
 	private function add_publish_element() {
 		foreach ($this->results as $result) {
 			$id = trim($result[0]);
 			$session = trim($result[1]);
 			$term = str_replace(' ', '_', trim($result[2]));
 			$file = XML::create_file_name($id, 'student');
 			if (!$xml = simplexml_load_file($file)) throw new CustomException(debug_backtrace(), 'UNABLE TO OPEN XML FILE.');
 			foreach ($xml->sessions->session as $sess) {
 				if ($sess['session'] == $session) {
 					if ($term == 'first_term') {
 						$sess->first_term->addChild('published');
 					} else if ($term == 'second_term') {
 						$sess->second_term->addChild('published');
 					} else if ($term == 'third_term') {
 						$sess->third_term->addChild('published');
 					}
 					break;
 				}
 			}
 			$content = $xml->asXML();
 			if (!file_put_contents($file, $content)) throw new CustomException(debug_backtrace(), 'UNABLE TO PUT CONTENT IN FILE.');
 		}
 		return true;
 	}
 	public function publish_results() {
 		if ($this->add_publish_element()) {
 			echo '<p>SELECTED RESULTS HAVE BEEN PUBLISHED.</p>';
 			echo '<article class=\'homepage\'><div><a href=\'./index.php\'>GO TO HOMEPAGE</a></div></article>';
 		}
 	}
}
//the following classes handle the logics behind marking attendance
class Mod_Mark_Attendance {
	private $presents;
	private $class;
	private $period;
	public function __construct($pres = false, $class, $period) {
		$this->presents = $pres;
		$this->class = $class;
		$this->period = $period;
	}
	private function get_class_file($class, $session, $term) {
		switch ($class) {
			case 'JSS 1A':
				$class = 1;
				break;
			case 'JSS 1B':
				$class = 2;
				break;
			case 'JSS 2A':
				$class = 3;
				break;
			case 'JSS 2B':
				$class = 4;
				break;
			case 'JSS 3A':
				$class = 5;
				break;
			case 'JSS 3B':
				$class = 6;
				break;
			case 'SSS 1 ART':
				$class = 7;
				break;
			case 'SSS 1 COMMERCIAL':
				$class = 8;
				break;
			case 'SSS 1 SCIENCE':
				$class = 9;
				break;
			case 'SSS 2 ART':
				$class = 10;
				break;
			case 'SSS 2 COMMERCIAL':
				$class = 11;
				break;
			case 'SSS 2 SCIENCE':
				$class = 12;
				break;
			case 'SSS 3 ART':
				$class = 13;
				break;
			case 'SSS 3 COMMERCIAL':
				$class = 14;
				break;
			case 'SSS 3 SCIENCE':
				$class = 15;
				break;
			default:
				// code...
				break;
		}
		$session = str_replace('/', '-', strtolower($session));
		$term = $term;
		if ($term == 'FIRST TERM') {
			$term = 1;
		} else if ($term == 'SECOND TERM') {
			$term = 2;
		} else if ($term == 'THIRD TERM') {
			$term = 3;
		}
		$string = '';
		$string .= '../bin/attendance/'.$class.'_'.$session.'_'.$term.'.txt';
		return $string;
	}
	private function create_attendance($presents) {
		$day = date('M-d-Y');
		$attendance = '';
		if ($presents == 'all') {
			$presents = Database::check_unique_class_role($this->class, 'students', 1);
			$array = [];
			foreach ($presents as $present) {
				array_push($array, $present['student_id']);
			}
			$presents = $array;
		}
		for ($i = 0; $i < sizeof($presents); $i++) {
			if ($i == (sizeof($presents) - 1)) {
				$attendance .= $presents[$i]."\n";
			} else {
				$attendance .= $presents[$i].',';
			}
		}
		$string = $day.'/'.$attendance;
		return $string;
	}
	private function update_file($attendance, $file) {
		$dir = getcwd();
		$dir = '../bin/attendance/';
		$open_dir = opendir($dir);
		$files = array();
		$fi = readdir($open_dir);
		while ($fi != false) {
			$files[] = $fi;
			$fi = readdir($open_dir);
		}
		function check_date($date, $file) {
			$lines = file($file);
			$status = true;
			foreach ($lines as $line) {
				$day = explode('/', $line);
				$day = $day[0];
				if (trim($day) == trim($date)) {
					$status = false;
					break;
				} else {
					$status = true;
				}
			}
			return $status;
		}
		$date = explode('/', $attendance);
		$date = $date[0];
		if (in_array(basename($file), $files)) {
			if (check_date($date, $file)) {
				if (!file_put_contents($file, $attendance, FILE_APPEND)) throw new CustomException(debug_backtrace(), 'UNABLE TO PUT ATTENDANCE IN FILE');
				return true;
			} else {
				return false;
			}
		} else if (!in_array(basename($file), $files)) {
			if (!file_put_contents($file, $attendance)) throw new CustomException(debug_backtrace(), 'UNABLE TO PUT ATTENDANCE IN FILE');
			return true;
		}
	}
	public function calculate_attendance($id, $sess, $term) {
		$attendances = array();
		$total = 0;
		$count = 0;
		$class = XML::get_session_class($id, $sess);
		$file = self::get_class_file($class, $sess, $term);
		if (!$lines = file($file)) return false;
		foreach ($lines as $line) {
			$array = explode('/', $line);
			$temp = explode(',', $array[1]);
			$temp_1 = array();
			foreach ($temp as $id) {
				$temp_1[] = trim($id);
			}
			$attendances[] = $temp_1;
		}
		foreach ($attendances as $day) {
			$total += 1;
			if (in_array(trim($id), $day)) {
				$count += 1;
			}
		}
		$perc = ($count / $total) * 100;
		$res['count'] = $count;
		$res['total'] = $total;
		$res['perc'] = $perc;
		return $res;
	}
	public function mark_attendance() {
		$file = $this->get_class_file($this->class, $this->period['session'], $this->period['term']);
		$attendance = $this->create_attendance($this->presents);
		if ($this->update_file($attendance, $file)) {
			echo '<p>SELECTED STUDENTS HAVE BEEN MARKED PRESENT.</p>';
			echo '<p>CLASS: '.$this->class.'</p>';
			echo '<p>DATE: '.date('M-d-Y').'</p>';
			echo '<p>SESSION: '.$this->period['session'].'</p>';
			echo '<p>TERM: '.$this->period['term'].'</p>';
			echo '<article class=\'homepage\'><div><a href=\'./index.php\'>GO TO HOMEPAGE</a></div></article>';
		} else {
			echo '<p>ATTENDANCE FOR TODAY HAS BEEN TAKEN BEFORE.</p>';
			echo '<article class=\'homepage\'><div><a href=\'./index.php\'>GO TO HOMEPAGE</a></div></article>';
		}
	}
}
//the following classes handles the logics of writing students comments
class Mod_Write_Comments {
	private $ids_comments;
	private static $session;
	private static $term;
	private static $type;
	public function __construct($ids_comms, $sess, $term, $type) {
		self::$session = $sess;
		self::$term = $term;
		self::$type = $type;
		$array = array();
		foreach($ids_comms as $id) {
			$id['session'] = self::$session;
			$id['term'] = self::$term;
			$id['type'] = self::$type;
			$array[] = $id;
		}
		$this->ids_comments = $array;
	}
	private function write_func() {
		function write_to_xml($array) {
			$id = $array['student_id'];
			$comm = $array['comment'];
			$sess = $array['session'];
			$term = $array['term'];
			$type = $array['type'];
			$file = XML::create_file_name($id, 'student');
			$xml = simplexml_load_file($file);
			foreach ($xml->sessions->children() as $ses) {
				if ($sess == $ses['session']) {
					$session = $ses;
					break;
				}
			}
			if (!$session) throw new CustomException(debug_backtrace(), 'SESSION NOT IN STUDENT '.$id.' XML FILE.');
			if ($term == 'FIRST TERM') {
				$term = $session->first_term;
			} else if ($term == 'SECOND TERM') {
				$term = $session->second_term;
			} else if ($term == 'THIRD TERM') {
				$term = $session->third_term;
			}
			if ($type == 'class_teacher') {
				$type = 'class_teacher_remark';
			} else if ($type == 'principal') {
				$type = 'principal_remark';
			}
			$remark_exists = false;
			foreach ($term->children() as $remark) {
				if ($remark->getName() == $type) {
					$remark_exists = true;
					break;
				}
			}
			if (!$remark_exists) {
				if (!$term->addChild($type, $comm)) throw new CustomException(debug_backtrace(), 'UNABLE TO ADD COMMENT TO XML');
				$content = $xml->asXML();
				if (!file_put_contents($file, $content)) throw new CustomException(debug_backtrace(), 'UNABLE TO UPDATE XML FILE');
			}
		}
		if (@array_walk($this->ids_comments, write_to_xml)) {
			return true;
		}
	}
	public static function get_comments($id, $sess, $term) {
		$remarks = array();
		$file = XML::create_file_name($id, 'student');
		$xml = simplexml_load_file($file);
		foreach ($xml->sessions->children() as $ses) {
			if ($sess == $ses['session']) {
				$session = $ses;
				break;
			}
		}
		if (!isset($session)) return false;
		if ($term == 'FIRST TERM') {
			$term = $session->first_term;
		} else if ($term == 'SECOND TERM') {
			$term = $session->second_term;
		} else if ($term == 'THIRD TERM') {
			$term = $session->third_term;
		}
		foreach ($term->children() as $remark) {
			if ($remark->getName() == 'class_teacher_remark') {
				$remarks['class_teacher_remark'] = $remark;
			}
			if ($remark->getName() == 'principal_remark') {
				$remarks['principal_remark'] = $remark;
			}
		}
		return $remarks;
	}
	public function write_comments() {
		if ($this->write_func()) {
			echo '<p>COMMENTS HAVE BEEN ADDED FOR THE STUDENTS IN SELECTED CLASS.</p>';
			echo '<p>SESSION: '.self::$session.'.</p>';
			echo '<p>TERM: '.self::$term.'.</p>';
			echo '<article class=\'homepage\'><div><a href=\'./index.php\'>GO TO HOMEPAGE</a></div></article>';
		}
	}
}

//following is a class class
class Mod_Class {
	private $class_name;
	private $conn;
	public function __construct($class_name) {
		$this->class_name = $class_name;
		$this->conn = Database::connect_db('admin');
	}
	public function get_class_name() {
		return $this->class_name;
	}
	public function get_class_teacher() {
		$conn = $this->conn;
		try {
			if (!$query = $conn->query('SELECT class_teacher_id FROM classes WHERE class_name = '.$conn->quote($this->class_name))) throw new CustomException(debug_backtrace(), 'UNABLE TO EXECUTE SQL QUERY');
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('Something went wrong, please try again.');
			Error_Reg::set_err_session();
			header('location: ./class_info.php?'.$_SERVER['QUERY_STRING']);
			die();
		}
		$res = $query->fetch(PDO::FETCH_ASSOC)['class_teacher_id'];
		if ($res == null) {
			return false;
		}
		$teacher = Database::check_unique_id($res, 'staffs', 1);
		return ['name' => $teacher['staff_first_name'].' '.$teacher['staff_last_name'], 'id' => $teacher['staff_id']];
	}
	public function set_class_teacher(string $id) {
		// if (empty($id)) {
		// 	Error_Reg::set_errors('Please select a class teacher.');
		// }
		if (sizeof(Error_Reg::$errors) > 0) {
			Error_Reg::set_err_session();
			header('location: ./class_info.php?'.$_SERVER['QUERY_STRING']);
			die();
		}
		$conn = $this->conn;
		$prepared_query = $conn->prepare('UPDATE classes SET class_teacher_id = :id WHERE class_name = '.$conn->quote($this->class_name));
		if (empty($id)) $id = NULL;
		$prepared_query->bindValue(':id', $id);
		try {
			if (!$result = $prepared_query->execute()) throw new CustomException(debug_backtrace(), 'UNABLE TO EXECUTE SQL QUERY');
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('Something went wrong, please try again.');
			Error_Reg::set_err_session();
			header('location: ./class_info.php?'.$_SERVER['QUERY_STRING']);
			die();
		}
	}
	public function get_students() {
		$conn = $this->conn;
		if (!$query = $conn->query('SELECT * FROM students WHERE student_class = '.$conn->quote($this->class_name))) throw new CustomExecption(debug_backtrace(), 'UNABLE TO EXECUTE SQL QUERY');
		$student = $query->fetch(PDO::FETCH_ASSOC);
		$results = [];
		while ($student) {
			array_push($results, ['name' => $student['student_first_name'].' '.$student['student_last_name'], 'id' => $student['student_id']]);
			$student = $query->fetch(PDO::FETCH_ASSOC);
		}
		return $results;
	}
	public function student_count() {
		return count($this->get_students());
	}
	public function get_subjects() {
		$conn = $this->conn;
		$array = [];
		if (preg_match('/(jss) (\d)(\w)/i', $this->class_name, $array)) {
			$this->class_name = $array[1].' '.$array[2];
		}
		try {
			if (!$query = $conn->query('SELECT subject_name FROM subjects WHERE classes LIKE '.$conn->quote('%'.$this->class_name.'%'))) throw new CustomExecption(debug_backtrace(), 'UNABLE TO EXECUTE SQL QUERY');
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('Something went wrong, please try again.');
			Error_Reg::set_err_session();
			header('location: ./class_info.php?'.$_SERVER['QUERY_STRING']);
			die();
		}
		$subject = $query->fetch(PDO::FETCH_ASSOC);
		$results = [];
		while ($subject) {
			$results[] = $subject['subject_name'];
			$subject = $query->fetch(PDO::FETCH_ASSOC);
		}
		return $results;
	}
}

// following snippet takes care of school blog

class Mod_Blog_Admin {
	public function get_writers() {
		$file = './writers.txt';
		return array_map('trim', file($file));
	}
	public function set_writers(string $username, string $type) {
		$file = './writers.txt';
		if (empty($username) || Database::check_unique_username($username, $type.'s')) {
			Error_Reg::set_errors('User does not exist.');
			Error_Reg::set_err_session();
			header('location: ./writers.php');
			die();
		}
		try {
			$writer = trim($username).','.trim($type);
			if (!file_put_contents($file, $writer."\n", FILE_APPEND)) throw new CustomException(debug_backtrace(), 'UNABLE TO PUT WRITER IN FILE.');
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('Something went wrong, please try again.');
			Error_Reg::set_err_session();
			header('location: ./writers.php');
			die();
		}
		return true;
	}
	public function delete_writers() {
		$file = './writers.txt';
		$list = Self::get_writers();
		function filter_func($e) {
			list($username, $type) = explode(',', $e);
			return !in_array($username, $_POST['writers']);
		} 
		$new_writers = array_filter($list, 'filter_func');
		$writers = '';
		foreach ($new_writers as $writer) {
			$writers .= $writer."\n";
		}
		file_put_contents($file, $writers);
	}
	public static function delete_posts(array $array) {
		$conn = Database::connect_db('admin');
		$prepared_statement = $conn->prepare('DELETE FROM blog_posts WHERE post_id = :id');
		$conn->beginTransaction();
		try {
			foreach($array as $post) {
				$prepared_statement->bindValue(':id', $post);
				$file = $conn->query('SELECT file_type FROM blog_posts WHERE post_id = '.$post)->fetch(PDO::FETCH_ASSOC)['file_type'];
				if (is_file('./posts/images/'.$post.'.'.trim($file))) {
					unlink('./posts/images/'.$post.'.'.trim($file));
				}
				if (!$prepared_statement->execute()) {
					$conn->rollBack();
					throw new CustomException(debug_backtrace(), 'UNABLE TO EXECUTE STATEMENT.');
				}
			}
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('Something went wrong, please try again.');
			Error_Reg::set_err_session();
			header('location: ./writers.php');
			die();
		}
		$conn->commit();
		return true;
	}
}

class Mod_Blogs {
	private $set;
	private $search;
	public function __construct(int $set = null, string $search = null) {
		$this->offset = $set * 5;
		$this->search = $search;
	}
	public function retrieve_posts($recent = false) {
		$count = 5;
		if ($recent) {
			$this->offset = 0;
			$count = 15;	
		} 
		$conn = Database::connect_db('blog_user');
		if (!$this->search) {
			$prepared_statement = $conn->prepare('SELECT post_id, post_title, LEFT(post_content, 300) as subcontent, DATE_FORMAT(post_time, "%d %b, %Y. %h:%i %p") as post_date, file_type FROM blog_posts ORDER BY post_time DESC LIMIT '.$this->offset.', '.$count);
		} else {
			$prepared_statement = $conn->prepare('SELECT post_id, post_title, LEFT(post_content, 300) as subcontent, DATE_FORMAT(post_time, "%d %b, %Y. %h:%i %p") as post_date, file_type FROM blog_posts WHERE MATCH (post_content) AGAINST ('.$conn->quote($this->search).') ORDER BY post_time DESC LIMIT '.$this->offset.', '.$count);
		}
		try {
			if (!$prepared_statement->execute()) throw new CustomException(debug_backtrace(), 'UNABLE TO RETRIEVE POSTS.');
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('Something went wrong, please try again.');
			Error_Reg::set_err_session();
			header('location: ./manage_blog.php');
			die();
		}
		return $prepared_statement->fetchAll(PDO::FETCH_ASSOC);
	}
	public function count_posts() {
		$conn = Database::connect_db('blog_user');
		if (!$this->search) {
			return $conn->query('SELECT count(post_id) as number FROM blog_posts')->fetch(PDO::FETCH_ASSOC)['number'];
		} else {
			return $conn->query('SELECT count(post_id) as number FROM blog_posts WHERE MATCH (post_content) AGAINST ('.$conn->quote($this->search).')')->fetch(PDO::FETCH_ASSOC)['number'];
		}
	}
}

class Mod_Blog {
	private $data;
	private $image;
	public function __construct(array $array = null, $image = null) {
		if ($array) $this->data = $array;
		$this->image = $image;
	}
	public function create_post() {
		$conn = Database::connect_db('blog_writer');
		$prepared_statement = $conn->prepare('INSERT INTO blog_posts SET post_title = :title, post_content = :content, post_time = NOW(), file_type = :image');
		try {
			if (!$prepared_statement->execute($this->data)) throw new CustomException(debug_backtrace(), 'UNABLE TO CREATE BLOG POST.');
			$id = $conn->lastInsertId();
			$image_name = './posts/images/'.$id.'.'.$this->data[':image'];
			if ($this->image) {
				if (!move_uploaded_file($this->image, $image_name)) {
					Mod_Blog_Admin::delete_posts([$id]);
					throw new CustomException(debug_backtrace(), 'UNABLE TO UPLOAD ARTICLE IMAGE.');
				}
			}
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('Something went wrong, please try again.');
			Error_Reg::set_err_session();
			header('location: '.$_SERVER['HTTP_REFERER']);
			die();
		}
		return $id;
	}
	public function retrieve_post(int $id) {
		$conn = Database::connect_db('blog_user');
		if (!$conn->query('SELECT post_id FROM blog_posts WHERE post_id = '.$conn->quote($id))->fetch(PDO::FETCH_ASSOC)) {
			Error_Reg::set_errors('Something went wrong, please try again.');
			Error_Reg::set_err_session();
			header('location: ./index.php');
			die();
		}
		$prepared_statement = $conn->prepare('SELECT post_id, post_title, post_content, DATE_FORMAT(post_time, "%d %b, %Y. %h:%i %p") as post_date, file_type FROM blog_posts WHERE post_id = :id');
		$prepared_statement->bindValue(':id', $id);
		try {
			if (!$prepared_statement->execute()) throw new CustomException(debug_backtrace(), 'UNABLE TO RETRIEVE POST.');
		} catch (CustomException $e) {
			handle_exception_obj($e);
			Error_Reg::set_errors('Something went wrong, please try again.');
			Error_Reg::set_err_session();
			header('location: ./index.php');
			die();
		}
		return $prepared_statement->fetch(PDO::FETCH_ASSOC);
	}
}

function schoolInfo() {
	$conn = Database::connect_db('admin');
	$array = [];
	$current = new Mod_Change_Session;
	$current = $current->get_current_info();
	$array['current_session'] = $current['session'];
	$array['current_term'] = $current['term'];
	$start_date = $current['start_date'];
	$fmt_start_date = new DateTime($start_date);
	$array['start_date'] = $fmt_start_date->format('d-M-Y');
	$now = new DateTime();
	$array['days_open'] = $now->diff($fmt_start_date)->format('%a days open');
	if ($now < $fmt_start_date) $array['days_open'] = '-'.$array['days_open'];
	$array['students_count'] = $conn->query('SELECT COUNT(student_id) total FROM students')->fetch(PDO::FETCH_ASSOC)['total'];
	$array['staff_count'] = $conn->query('SELECT COUNT(staff_id) total FROM staffs')->fetch(PDO::FETCH_ASSOC)['total'];
	$array['subjects_count'] = $conn->query('SELECT COUNT(subject_name) total FROM subjects')->fetch(PDO::FETCH_ASSOC)['total'];
	$array['class_count'] = sizeof(CLASSES);
	return $array;
}


function create_archive(array $students) : bool {
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
	$terms = ['FIRST TERM', 'SECOND TERM', 'THIRD TERM'];
	foreach ($students as $student) {
		$info = Database::check_unique_id($student, 'students', 1);
		$string = <<<ddd
		<!doctype html>
		<html>
		<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name='viewport' content='width=device-width, initial-scale=.5'>
		<link rel="stylesheet" href="../archive_style.css">
		<title>$info[student_first_name] $info[student_last_name] RESULTS ARCHIVE</title>
	</head>
	<body>
ddd;
		$string .= '<h2>'.$info['student_first_name'].' '.$info['student_last_name'].' RESULTS ARCHIVE</h2>';
		$string .= '<p>Last class: '.$info['student_class'].'</p>';
		$sessions = XML::get_sessions_for_student($student);
		foreach ($sessions as $session) {
			$string .= '<article class=\'session\'>';
			$class = XML::get_session_class($student, $session);
			$string .= '<h3>'.$session.' SESSION ('.$class.')</h3>';
			foreach ($terms as $term) {
				$results = new Mod_Check_Student_Result($student, $session, $term);
				$results = $results->check_student_result();
				$subjects_scores = array();
				$string .= '<h4>'.$term.' RESULT</h4>';
				if ($results) {
					$string .= '<table class=\'results\'>';
					$string .= '<thead><tr><th rowspan=\'2\'>S/N</th><th rowspan=\'2\'>SUBJECT</th><th colspan=\'2\'>1ST C.A. TEST</th><th colspan=\'2\'>2ND C.A. TEST</th><th colspan=\'2\'>ASSIGNMENT</th><th colspan=\'2\'>EXAMINATION</th><th colspan=\'2\'>TOTAL</th><th rowspan=\'2\'>GRADE</th></tr>';
					$string .= '<tr>';
					for ($i = 0; $i < 5; $i++) { 
						$string .= '<th>SCORE OBTAINED</th>';
						$string .= '<th>SCORE OBTAINABLE</th>';
					}
					$string .= '</tr></thead>';
					$index = 1;
					$string .= '<tbody>';
					foreach ($results as $result) {
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
					$string .= '<article class=\'student_performance_data field_set\'>';
					$total_score_obtained = total_obtained($subjects_scores);
					$string .= '<div class=\'s_ed\'>Total score obtained: '.$total_score_obtained.'</div>';
					$total_score_obtainable = sizeof($results) * 100;
					$string .= '<div class=\'s_able\'>Total score obtainable: '.$total_score_obtainable.'</div>';
					$percentage = get_term_percentage($subjects_scores, sizeof($results));
					$string .= '<div class=\'s_tage\'>Score percentage: '.round($percentage, 2).'%</div>';
					$string .= '</article>';
				} else $string .= '<p>NO RESULTS.</p>';
			}
			$string .= '</article>';
		}
		$string .= '</body><html>';
		$current_session = new Mod_Change_Session();
		$current_session = $current_session->get_current_info()['session'];
		$current_session = preg_replace('/\//', '_', $current_session);
		if (!is_dir('../results_archive/'.$current_session.'/')) {
			mkdir('../results_archive/'.$current_session.'/');
		}
		$dir_name = '../results_archive/'.$current_session.'/';
		$file_name = $dir_name.strtolower($info['student_first_name']).'_'.strtolower($info['student_last_name']).'_'.strtolower($info['student_id']).'.html';
		if (!file_put_contents($file_name, $string)) throw new CustomException(debug_backtrace(), 'UNABLE TO CREATE ARCHIVE FILE FOR '.$info['student_id']);
	}
	return true;
}

function deregister($id) {
	// delete current session element from xml file
	$file = '../bin/xmls/students/'.$id.'.xml';
	$doc = new DOMDocument();
	$doc->load($file);
	$session = new Mod_Change_Session();
	$cur_session = $session->get_current_info()['session'];
	$sessions = $doc->getElementsByTagName('session');
	$subjects = false;
	foreach($sessions as $session) {
		if ($session->getAttribute('session') == $cur_session) {
			$subjects = $session->getElementsByTagName('subject');
			$doc->getElementsByTagName('sessions')[0]->removeChild($session);
		}
	}
	if (!file_put_contents($file, $doc->saveXml())) throw new CustomException(debug_backtrace(), 'UNABLE TO REMOVE SESSION FROM XML FILE '.$file);

	// delete student from all registered subjects
	if ($subjects) {
		$conn = Database::connect_db('admin');
		$session = new Mod_Change_Session();
		$cur_session = $session->get_current_info()['session'];
		foreach ($subjects as $subject) {
			$subject = strtolower(trim(str_replace(' ', '_', $subject->textContent)));
			$sql = 'DELETE FROM '.$subject.' WHERE student_id = '.$id.' AND session = '.$conn->quote($cur_session);
			if (!$conn->query($sql)) throw new CustomException(debug_backtrace(), 'UNABLE TO REMOVE SESSION FROM XML FILE '.$file);
		}
	}
	
	// returns true if nothing went wrong
	return true;
}