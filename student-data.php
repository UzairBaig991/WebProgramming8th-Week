<?php
require_once __DIR__ . '/common.php';
$title = 'Student Data';
$active = 'student-data';

$students = $con->query(
    'SELECT s.sap_id, s.name, s.father_name, d.department_name, s.created_at
     FROM students s
     LEFT JOIN departments d ON d.id = s.department_id
     ORDER BY s.name, s.sap_id'
)->fetch_all(MYSQLI_ASSOC);

require __DIR__ . '/header.php';
?>
<section class="panel">
    <h2>Saved student records</h2>
    <?php if ($students): ?>
        <div class="table-wrap"><table>
            <thead>
                <tr><th>SAP / Student ID</th><th>Name</th><th>Father's Name</th><th>Department</th><th>Added</th></tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo e($student['sap_id']); ?></td>
                        <td><?php echo e($student['name']); ?></td>
                        <td><?php echo e($student['father_name']); ?></td>
                        <td><?php echo e($student['department_name'] ?: '—'); ?></td>
                        <td><?php echo e($student['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table></div>
    <?php else: ?>
        <p class="empty">No student records saved yet.</p>
    <?php endif; ?>
    <a class="button" href="students.php">Add a student</a>
</section>
<?php require __DIR__ . '/footer.php'; ?>
