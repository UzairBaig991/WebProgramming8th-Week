<?php
$title = isset($title) ? $title : 'CourseDesk';
$active = isset($active) ? $active : '';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($title); ?> | CourseDesk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="topbar">
        <a class="brand" href="index.php"><span class="brand-icon">C</span> CourseDesk</a>
        <nav aria-label="Main navigation">
            <a class="<?php echo $active === 'home' ? 'active' : ''; ?>" href="index.php">Dashboard</a>
            <a class="<?php echo $active === 'students' ? 'active' : ''; ?>" href="students.php">Students</a>
            <a class="<?php echo $active === 'student-data' ? 'active' : ''; ?>" href="student-data.php">Student Data</a>
            <a class="<?php echo $active === 'courses' ? 'active' : ''; ?>" href="courses.php">Courses</a>
            <a class="<?php echo $active === 'allocations' ? 'active' : ''; ?>" href="allocations.php">Allocations</a>
        </nav>
    </header>
    <main class="container">
        <div class="page-heading">
            <div><p class="eyebrow">STUDENT MANAGEMENT</p><h1><?php echo e($title); ?></h1></div>
        </div>
