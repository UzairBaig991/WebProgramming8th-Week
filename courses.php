<?php
require_once __DIR__ . '/common.php';
$title = 'Courses';
$active = 'courses';
$message = '';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = strtoupper(post('course_code'));
    $name = post('course_name');
    $credits = filter_var(post('credits'), FILTER_VALIDATE_INT);

    try {
        if ($code === '' || $name === '' || $credits === false || $credits < 1 || $credits > 30) {
            throw new InvalidArgumentException('Enter the course details and credits from 1 to 30.');
        }
        $stmt = $con->prepare(
            'INSERT INTO courses (course_code, course_name, credits) VALUES (?, ?, ?)'
        );
        $stmt->bind_param('ssi', $code, $name, $credits);
        $stmt->execute();
        $stmt->close();
        header('Location: courses.php?success=Course+added');
        exit;
    } catch (InvalidArgumentException $exception) {
        $message = $exception->getMessage();
    } catch (mysqli_sql_exception $exception) {
        $message = saveError($exception);
    }
}

$courses = $con->query(
    'SELECT course_code, course_name, credits FROM courses ORDER BY course_name'
)->fetch_all(MYSQLI_ASSOC);
require __DIR__ . '/header.php';
?>
<?php if (isset($_GET['success'])): ?><p class="message"><?php echo e($_GET['success']); ?></p><?php endif; ?>
<?php if ($message !== ''): ?><p class="message error"><?php echo e($message); ?></p><?php endif; ?>
<div class="grid">
    <section class="panel">
        <h2>Add a course</h2>
        <form method="post">
            <label for="course_code">Course code</label>
            <input id="course_code" name="course_code" maxlength="30" required>
            <label for="course_name">Course name</label>
            <input id="course_name" name="course_name" maxlength="150" required>
            <label for="credits">Credits</label>
            <input id="credits" name="credits" type="number" min="1" max="30" required>
            <button type="submit">Save course</button>
        </form>
    </section>
    <section class="panel">
        <h2>Course catalogue</h2>
        <?php if ($courses): ?>
            <div class="table-wrap"><table>
                <thead><tr><th>Code</th><th>Course name</th><th>Credits</th></tr></thead>
                <tbody><?php foreach ($courses as $course): ?>
                    <tr>
                        <td><?php echo e($course['course_code']); ?></td>
                        <td><?php echo e($course['course_name']); ?></td>
                        <td><?php echo e($course['credits']); ?></td>
                    </tr>
                <?php endforeach; ?></tbody>
            </table></div>
        <?php else: ?><p class="empty">No courses added yet.</p><?php endif; ?>
    </section>
</div>
<?php require __DIR__ . '/footer.php'; ?>
