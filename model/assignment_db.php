<?php 
function get_assignments_by_course($course_id)
{
    //will grab courses based on their ID if the ID is found
    // returns all assignments if not.
    global $db;
    if($course_id)
    {
        $query = 'SELECT A.ID, A.Description, C.courseName 
            FROM assignments A
            LEFT JOIN courses C ON A.courseID = C.courseID
            WHERE A.courseID = :course_id 
            ORDER BY ID';
    } 
    else 
    {
        $query = 'SELECT A.ID, A.Description, C.courseName 
            FROM assignments A
            LEFT JOIN courses C ON A.courseID = C.courseID 
            ORDER BY ID';
    
    }
    $statement = $db->prepare($query);
    if ($course_id)
    {
        $statement->bindValue(':course_id', $course_id);
    }
    $statement->execute();
    $assignments = $statement->fetchAll();
    $statement->closeCursor();
    return $assignments;
}

function delete_assignment($assignment_id)
{
    global $db;
    $query = 'DELETE FROM assignments WHERE ID = :assign_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':assign_id', $assignment_id);
    $statement->execute();
    $statement->closeCursor();
}

function add_assignment($course_id, $description)
{
    global $db;
    $query = 'INSERT INTO assignments (Description, courseID) VALUES (:descr, :courseID)';
    $statement = $db->prepare($query);
    $statement->bindValue(':descr', $description);
    $statement->bindValue(':courseID', $course_id);
    $statement->execute();
    $statement->closeCursor();
}