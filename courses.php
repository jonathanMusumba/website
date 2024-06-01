<?php
include_once "db_connection.php";


$courses = []; 

?>

<div class="container-fluid mt-3">
    <h2>Courses</h2>

    <div class="mb-3">
        <a href="#" class="btn btn-primary">Add Course</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Course Name</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $course) : ?>
            <tr>
                <td><?php echo $course['id']; ?></td>
                <td><?php echo $course['course_name']; ?></td>
                <td>
                    <a href="#" class="btn btn-info btn-sm">Edit</a>
                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
