<?php
$error_message = ""; // Variable to store error messages

// Function to sanitize input data
function sanitize($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

// Initialize variables to store results
$average = '';
$status = '';
$fname = '';
$lname = '';
$age = '';
$gender = '';
$course = '';
$email = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check which form was submitted
    if (isset($_POST['submit_enrollment'])) {
        // Validate enrollment form data
        if (empty($_POST['course'])) {
            $error_message = "Please select a valid course.";
        } elseif (empty($_POST['gender'])) {
            $error_message = "Please select a gender.";
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error_message = "Please enter a valid email address.";
        } else {
            // Move to grade form step
            $step = 'grade_form';
            // Store enrollment form data for the next step
            $fname = sanitize($_POST['fname']);
            $lname = sanitize($_POST['lname']);
            $age = sanitize($_POST['age']);
            $gender = sanitize($_POST['gender']);
            $course = sanitize($_POST['course']);
            $email = sanitize($_POST['email']);
        }
    } elseif (isset($_POST['submit_grades'])) {
        // Handle grade form submission
        $average = ($_POST['prelim'] + $_POST['midterm'] + $_POST['final']) / 3;
        $average = round($average, 2);
        $status = $average >= 75 ? "Passed" : "Failed";

        // Clear enrollment form data after processing grades
        $step = 'enrollment_form';
        $fname = '';
        $lname = '';
        $age = '';
        $gender = '';
        $course = '';
        $email = '';
    } elseif (isset($_POST['restart'])) {
        // Restart the process
        $step = 'enrollment_form';
        // Optionally clear all fields as well
        $fname = '';
        $lname = '';
        $age = '';
        $gender = '';
        $course = '';
        $email = '';
    }
} else {
    // Default step if no form is submitted
    $step = 'enrollment_form';
}
?>
<!DOCTYPE html>
<html lang="en" >
<!-- data-bs-theme="dark" -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container ps-5 pe-5 ">
        <h1 class="text-center my-4 ">Student Enrollment and Grade Processing System</h1>

        <?php if (!empty($error_message)): ?>
            <!-- Display error message if there is one -->
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if ($step === 'enrollment_form'): ?>
            <!-- Enrollment Form -->
            <form method="POST">
                <h1 class="h4 fw-normal">Student Enrollment Form</h1>

                <div class="mb-3">
                    <label for="fname" class="form-label">First Name</label>
                    <input type="text" name="fname" id="fname" required class="form-control"
                        value="<?php echo htmlspecialchars($fname); ?>">
                </div>

                <div class="mb-3">
                    <label for="lname" class="form-label">Last Name</label>
                    <input type="text" name="lname" id="lname" required class="form-control"
                        value="<?php echo htmlspecialchars($lname); ?>">
                </div>

                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" name="age" id="age" required class="form-control"
                        value="<?php echo htmlspecialchars($age); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Gender</label>
                    <div>
                        <input type="radio" name="gender" value="Male" id="gender_male" required <?php echo ($gender === 'Male') ? 'checked' : ''; ?>>
                        <label for="gender_male">Male</label>

                        <input type="radio" name="gender" value="Female" id="gender_female" required <?php echo ($gender === 'Female') ? 'checked' : ''; ?>>
                        <label for="gender_female">Female</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="course" class="form-label">Course</label>
                    <select name="course" id="course" class="form-select" required>
                        <option value="" selected>Select Course</option>
                        <option value="BSIT" <?php echo ($course === 'BSIT') ? 'selected' : ''; ?>>BSIT</option>
                        <option value="BSCS" <?php echo ($course === 'BSCS') ? 'selected' : ''; ?>>BSCS</option>
                        <option value="BSME" <?php echo ($course === 'BSME') ? 'selected' : ''; ?>>BSME</option>
                        <option value="BSEE" <?php echo ($course === 'BSEE') ? 'selected' : ''; ?>>BSEE</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" required class="form-control"
                        value="<?php echo htmlspecialchars($email); ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                        title="Please enter a valid email address.">
                </div>

                <button type="submit" name="submit_enrollment" class="btn btn-primary">Submit Enrollment</button>
            </form>

            <?php if ($average !== '' && $status !== ''): ?>
                <div class="mt-4">
                    <h3 class=" h4 fw-normal">Student Details</h3>
                    <p><strong>First name:</strong> <?php echo sanitize($_POST['fname']); ?></p>
                    <p><strong>Last name:</strong> <?php echo sanitize($_POST['lname']); ?></p>
                    <p><strong>Age:</strong> <?php echo sanitize($_POST['age']); ?></p>
                    <p><strong>Gender:</strong> <?php echo sanitize($_POST['gender']); ?></p>
                    <p><strong>Course:</strong> <?php echo sanitize($_POST['course']); ?></p>
                    <p><strong>Email:</strong> <?php echo sanitize($_POST['email']); ?></p>

                    <h3 class=" h4 fw-normal">Grades</h3>
                    <p><strong>Prelim:</strong> <?php echo sanitize($_POST['prelim']); ?></p>
                    <p><strong>Midterm:</strong> <?php echo sanitize($_POST['midterm']); ?></p>
                    <p><strong>Final:</strong> <?php echo sanitize($_POST['final']); ?></p>
                    <h3 class=" h4 fw-normal">Average Grade</h3>
                    <p> <?php echo $average; ?> -
                        <span class='<?php echo ($status == 'Failed') ? 'text-danger' : 'text-success'; ?>'>
                            <?php echo $status; ?>
                        </span>
                    </p>
                </div>
            <?php endif; ?>

        <?php elseif ($step === 'grade_form'): ?>
            <!-- Grade Form -->
            <form method="POST">
                <h1 class=" h4 fw-normal">Enter Grades for <?php echo sanitize($_POST['fname']); ?>
                    <?php echo sanitize($_POST['lname']); ?>
                </h1>

                <!-- Hidden fields to pass previous data -->
                <input type="hidden" name="fname" value="<?php echo sanitize($_POST['fname']); ?>">
                <input type="hidden" name="lname" value="<?php echo sanitize($_POST['lname']); ?>">
                <input type="hidden" name="age" value="<?php echo sanitize($_POST['age']); ?>">
                <input type="hidden" name="gender" value="<?php echo sanitize($_POST['gender']); ?>">
                <input type="hidden" name="course" value="<?php echo sanitize($_POST['course']); ?>">
                <input type="hidden" name="email" value="<?php echo sanitize($_POST['email']); ?>">

                <div class="mb-3">
                    <label for="prelim" class="form-label">Prelim</label>
                    <input type="number" name="prelim" id="prelim" required class="form-control">
                </div>

                <div class="mb-3">
                    <label for="midterm" class="form-label">Midterm</label>
                    <input type="number" name="midterm" id="midterm" required class="form-control">
                </div>

                <div class="mb-3">
                    <label for="final" class="form-label">Final</label>
                    <input type="number" name="final" id="final" required class="form-control">
                </div>

                <button type="submit" name="submit_grades" class="btn btn-success">Submit Grades</button>
            </form>

        <?php endif; ?>
    </div>
</body>

</html>