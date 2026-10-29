<?php
require_once __DIR__ . '/common.php';
$title = 'Students';
$active = 'students';
$message = '';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $sapId = post('sap_id');
    $name = post('name');
    $fatherName = post('father_name');
    $department = post('department');

    try {
        if ($sapId === '' || $name === '') {
            throw new InvalidArgumentException('Student ID and name are required.');
        }
        $con->begin_transaction();
        $departmentId = null;
        if ($department !== '') {
            $stmt = $con->prepare(
                'INSERT INTO departments (department_name) VALUES (?)
                 ON DUPLICATE KEY UPDATE id = LAST_INSERT_ID(id)'
            );
            $stmt->bind_param('s', $department);
            $stmt->execute();
            $departmentId = $con->insert_id;
            $stmt->close();
        }

        $stmt = $con->prepare(
            'INSERT INTO students (sap_id, name, father_name, department_id) VALUES (?, ?, ?, ?)'
        );
        $stmt->bind_param('sssi', $sapId, $name, $fatherName, $departmentId);
        $stmt->execute();
        $stmt->close();
        $con->commit();
        header('Location: students.php?success=Student+saved+to+database');
        exit;
    } catch (InvalidArgumentException $exception) {
        $message = $exception->getMessage();
    } catch (mysqli_sql_exception $exception) {
        $con->rollback();
        $message = saveError($exception);
    }
}

require __DIR__ . '/header.php';
?>
<?php if (isset($_GET['success'])): ?><p class="message"><?php echo e($_GET['success']); ?></p><?php endif; ?>
<?php if ($message !== ''): ?><p class="message error"><?php echo e($message); ?></p><?php endif; ?>
<section class="panel form-panel">
    <h2>Register a student</h2>
    <form method="post">
        <label for="sap_id">SAP / student ID</label>
        <input id="sap_id" name="sap_id" maxlength="30" required>
        <label for="name">Student name</label>
        <input id="name" name="name" maxlength="150" required>
        <label for="father_name">Father's name</label>
        <input id="father_name" name="father_name" maxlength="150">
        <label for="department">Department</label>
        <input id="department" name="department" maxlength="120" placeholder="e.g. Computer Science">
        <button type="submit">Save Student Data</button>
    </form>
    <p class="quick-link"><a href="student-data.php">View saved student records →</a></p>
</section>
<?php require __DIR__ . '/footer.php'; ?>
