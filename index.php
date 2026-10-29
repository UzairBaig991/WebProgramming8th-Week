<?php
require_once __DIR__ . '/common.php';
$title = 'Dashboard';
$active = 'home';

$studentCount = $con->query('SELECT COUNT(*) AS total FROM students')->fetch_assoc()['total'];
$courseCount = $con->query('SELECT COUNT(*) AS total FROM courses')->fetch_assoc()['total'];
$allocationCount = $con->query('SELECT COUNT(*) AS total FROM allocations')->fetch_assoc()['total'];
require __DIR__ . '/header.php';
?>
<section class="welcome">
    <h2>Welcome to CourseDesk</h2>
    <p>Keep student records, courses, and course allocations organized in one place.</p>
</section>
<div class="grid">
    <section class="stat">
        <div class="stat-label">REGISTERED STUDENTS</div>
        <div class="stat-value"><?php echo e($studentCount); ?></div>
        <a class="quick-link" href="students.php">Manage students →</a>
    </section>
    <section class="stat">
        <div class="stat-label">AVAILABLE COURSES</div>
        <div class="stat-value"><?php echo e($courseCount); ?></div>
        <a class="quick-link" href="courses.php">Manage courses →</a>
    </section>
    <section class="stat">
        <div class="stat-label">COURSE ALLOCATIONS</div>
        <div class="stat-value"><?php echo e($allocationCount); ?></div>
        <a class="quick-link" href="allocations.php">Manage allocations →</a>
    </section>
</div>
<?php require __DIR__ . '/footer.php'; ?>
