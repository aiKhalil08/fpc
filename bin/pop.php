<?php

// $conn = new PDO('mysql:host=localhost;dbname=fpc', 'admin', 'fpcadmin1234');


// $students = $conn->query('select student_id from students')->fetchAll(PDO::FETCH_ASSOC);



// $subjects = ['agricultural science', 'mathematics', 'english language', 'social studies', 'french', 'arabic', 'economics'];

// $term = 'third';

// $session = '2030/2031';

// foreach ($subjects as $subject) {
//     $subject = strtolower(trim(str_replace(' ', '_', $subject)));
//     foreach ($students as $id) {
//         $firstca = rand(0,15);
//         $secondca = rand(0,15);
//         $ass = rand(0,10);
//         $exam = rand(10,60);
//         $sql = 'UPDATE '.$subject.' SET '.$term.'_1_ca = '.$firstca.', '.$term.'_2_ca = '.$secondca.', '.$term.'_ass = '.$ass.', '.$term.'_exam = '.$exam.' WHERE student_id = '.$id['student_id'].' AND session = '.$conn->quote($session);
//         if ($conn->query($sql)) echo 'DONE';
//     }
// }

?>