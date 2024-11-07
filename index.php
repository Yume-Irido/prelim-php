<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <h1 class="text-center">Student Enrollment and Grade Processing System</h1>

    <form id="enrollmentForm" class="container" style="display: block;">
        <h2>Student Enrollment Form</h2>

        <div class="form-group">
            <label for="fname">First Name</label>
            <input type="text" name="fname" id="fname" required class="form-control">
        </div>

        <div class="form-group">
            <label for="gname">Last Name</label>
            <input type="text" name="gname" id="gname" required class="form-control">
        </div>

        <div class="form-group">
            <label for="age">Age</label>
            <input type="number" name="age" id="age" required class="form-control">
        </div>

        <div class="form-group">
            <label>Gender</label>
            <div>
                <label><input type="radio" name="gender" value="Male" checked> Male</label>

                <label><input type="radio" name="gender" value="Female"> Female</label>
            </div>
        </div>

        <div class="form-group">
            <label for="coursename">Course</label>
            <select name="coursename" id="coursename" class="form-control">
                <option value="BSIT">BSIT</option>
                <option value="BSCS">BSCS</option>
                <option value="BSME">BSME</option>
                <option value="BSEE">BSEE</option>
            </select>
        </div>

        <div class="form-group">
            <label for="emailname">Email</label>
            <input type="email" name="emailname" id="emailname" required class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Submit Student Information</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>