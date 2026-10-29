<?php
require_once __DIR__ . '/common.php';
$title = 'Allocations';
$active = 'allocations';
$message = '';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $sapId = post('sap_id');
    $courseCode = post('course_code');

    try {
        if ($sapId === '' || $courseCode === '') {
            throw new InvalidArgumentException('Choose both a student and a course.');
        }
        $stmt = $con->prepare(
            'INSERT INTO allocations (sap_id, course_code) VALUES (?, ?)'
        );
        $stmt->bind_param('ss', $sapId, $courseCode);
        $stmt->execute();
        $stmt->close();
        header('Location: allocations.php?success=Course+allocated');
        exit;
    } catch (InvalidArgumentException $exception) {
        $message = $exception->getMessage();
    } catch (mysqli_sql_exception $exception) {
        $message = saveError($exception);
    }
}

$students = $con->query('SELECT sap_id, name FROM students ORDER BY name')->fetch_all(MYSQLI_ASSOC);
$courses = $con->query('SELECT course_code, course_name FROM courses ORDER BY course_name')->fetch_all(MYSQLI_ASSOC);
$allocations = $con->query(
    'SELECT a.sap_id, s.name AS student_name, c.course_code, c.course_name, c.credits, a.allocated_at
     FROM allocations a
     JOIN students s ON s.sap_id = a.sap_id
     JOIN courses c ON c.course_code = a.course_code
     ORDER BY a.allocated_at DESC'
)->fetch_all(MYSQLI_ASSOC);
require __DIR__ . '/header.php';
?>
<?php if (isset($_GET['success'])): ?><p class="message"><?php echo e($_GET['success']); ?></p><?php endif; ?>
<?php if ($message !== ''): ?><p class="message error"><?php echo e($message); ?></p><?php endif; ?>
<div class="grid">
    <section class="panel">
        <h2>Allocate a course</h2>
        <form method="post">
            <label for="sap_id">Student</label>
            <select id="sap_id" name="sap_id" required>
                <option value="">Choose student</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?php echo e($student['sap_id']); ?>">
                        <?php echo e($student['sap_id'] . ' — ' . $student['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="course_code">Course</label>
            <select id="course_code" name="course_code" required>
                <option value="">Choose course</option>
                <?php foreach ($courses as $course): ?>
                    <option value="<?php echo e($course['course_code']); ?>">
                        <?php echo e($course['course_code'] . ' — ' . $course['course_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Allocate course</button>
        </form>
    </section>
    <section class="panel">
        <h2>Current allocations</h2>
        <?php if ($allocations): ?>
            <div class="table-wrap"><table>
                <thead><tr><th>Student ID</th><th>Student</th><th>Course</th><th>Credits</th><th>Allocated</th></tr></thead>
                <tbody><?php foreach ($allocations as $row): ?>
                    <tr>
                        <td><?php echo e($row['sap_id']); ?></td>
                        <td><?php echo e($row['student_name']); ?></td>
                        <td><?php echo e($row['course_code'] . ' — ' . $row['course_name']); ?></td>
                        <td><?php echo e($row['credits']); ?></td>
                        <td><?php echo e($row['allocated_at']); ?></td>
                    </tr>
                <?php endforeach; ?></tbody>
            </table></div>
        <?php else: ?><p class="empty">No courses allocated yet.</p><?php endif; ?>
    </section>
</div>
<?php require __DIR__ . '/footer.php'; ?>
