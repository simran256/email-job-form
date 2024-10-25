<?php include("conn.php"); ?>
<!doctype html>
<html lang="en">

<head>
    <title>Job-Apply</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>

    <main>

        <div class="form-container container">
            <h4>JOB APPLICATION</h4>



            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="fname" placeholder="First Name" class="form-control mt-4" required>

                    </div>

                    <div class="col-md-6">
                        <input type="text" name="lname" placeholder="Last Name" class="form-control mt-4" required>




                    </div>
                    <div class="col-md-6">

                        <input type="email" name="email" placeholder="email" class="form-control mt-4" required>
                    </div>
                    <div class="col-md-6">
                        <input type="date" name="dob" placeholder="DOB" class="form-control mt-4" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="post" placeholder="Post applied for.." class="form-control mt-4" required>
                    </div>
                    <div class="col-md-6">
                        <input type="number" name="number" placeholder="Mobile no" class="form-control mt-4" required>
                    </div>
                    <div class="col-md-12">
                        <textarea class="form-control mt-4" rows="4" name="address" placeholder="Enter Address" required></textarea>
                    </div>
                    <div class="col-md-6">

                        <input type="text" name="city" placeholder="City" class="form-control mt-4" required>
                    </div>
                    <div class="col-md-6">

                        <input type="number" name="zip" placeholder="Zip" class="form-control mt-4" required>
                    </div>

                    <div class="col-md-6">
                        <input type="text" name="linkedin" placeholder="Linkedin-Profile-URL" class="form-control mt-4" required>
                    </div>

                    <div class="col-md-6">
                        <select name="experience" id="" class="form-control mt-4" required>
                            <option value="select-experience" disabled selected>select-experience</option>
                            <option value="fresher">Fresher</option>
                            <option value="6 months">6 months</option>
                            <option value="1 year">1 year</option>
                            <option value="2 year">2 year</option>
                            <option value="3 year">3 year</option>
                            <option value="more than 3">more than 3</option>
                        </select>
                    </div>


                    <div class="col-md-12 upload-container">

                        <label for="resume" class="upload-label">
                            <i class="fas fa-file-upload"></i><br>
                            <span>upload your resume here</span>
                        </label>
                        <input type="file" id="resume" name="resume" accept=".pdf, .doc, .docx" required class="upload-input" />
                    </div>
                    <div class="col-md-12">
                        <textarea class="form-control mt-4" rows="4" name="cover_letter" placeholder="write your cover letter here.." required></textarea>

                    </div>

                    <div class="col-md-12">
                        <button class="btn btn-dark mt-4 mb-3 upload-button" name="submit">Submit</button>
                    </div>


                </div>
            </form>
        </div>

    </main>

    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $zip = mysqli_real_escape_string($conn, $_POST['zip']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $linkedin = mysqli_real_escape_string($conn, $_POST['linkedin']);
    $post = mysqli_real_escape_string($conn, $_POST['post']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience']);
    $cover_letter = mysqli_real_escape_string($conn, $_POST['cover_letter']);

    $resume = $_FILES['resume']['name'];
    $temp_name = $_FILES['resume']['tmp_name'];
    $folder = "resume/" . $resume;


    // Upload the resume to the folder
    if (move_uploaded_file($temp_name, $folder)) {
        // Save form data to the database

        $sql = "INSERT INTO `form`(`fname`, `lname`, `dob`, `address`, `zip`, `city`, `email`, `mobile`, `linkedin`, `post`, `experience`, `resume`, `cover_letter`) 
                VALUES ('$fname','$lname','$dob','$address','$zip','$city','$email','$number','$linkedin','$post','$experience','$resume','$cover_letter')";
        $res = mysqli_query($conn, $sql);

        if ($res) {
            // Prepare email content
            $to = "developer.web2techsolutions@gmail.com";
            $subject = "JOB APPLICATION FROM " . $fname;
            $from = "no-reply@Simran-developer.com";

            $boundary = md5(uniqid(time())); // Unique boundary

            // Headers for email
            $headers = "From: $from\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

            // Email body message
            $body = "--$boundary\r\n";
            $body .= "Content-Type: text/html; charset=UTF-8\r\n";
            $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
            $body .= "<html><body>";
            $body .= "<h2>Application from: " . $fname . "</h2>";
            $body .= "<p><strong>Name:</strong> " . $fname . "</p>";
            $body .= "<p><strong>Date of Birth:</strong> " . $dob . "</p>";
            $body .= "<p><strong>Address:</strong> " . $address . "</p>";
            $body .= "<p><strong>Zip:</strong> " . $zip . "</p>";
            $body .= "<p><strong>City:</strong> " . $city . "</p>";
            $body .= "<p><strong>Email:</strong> " . $email . "</p>";
            $body .= "<p><strong>Number:</strong> " . $number . "</p>";
            $body .= "<p><strong>Linkedin Profile:</strong> " . $linkedin . "</p>";
            $body .= "<p><strong>Applying for:</strong> " . $post . "</p>";
            $body .= "<p><strong>Experience:</strong> " . $experience . "</p>";
            $body .= "<p><strong>Resume for:</strong> " . $resume . "</p>";
            $body .= "<p><strong>Cover Letter:</strong> " . $cover_letter . "</p>";
            $body .= "</body></html>\r\n";

            // Read the resume file content
            $file_content = file_get_contents($folder);
            $encoded_file = chunk_split(base64_encode($file_content));

            // Attachment
            $body .= "--$boundary\r\n";
            $body .= "Content-Type: application/octet-stream; name=\"$resume\"\r\n";
            $body .= "Content-Disposition: attachment; filename=\"$resume\"\r\n";
            $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
            $body .= $encoded_file . "\r\n";
            $body .= "--$boundary--\r\n";

            // Send the email

            // Send the email to the employer
            if (mail($to, $subject, $body, $headers)) {
                // Prepare thank-you email content for the candidate
                $thankYouSubject = "Thank You for Your Application";
                $thankYouBody = "<html><body>";
                $thankYouBody .= "<h2>Dear " . $fname . $lname . ",</h2>";
                $thankYouBody .= "<p>Thank you for applying for the position of " . $post . " at developer simran team. We appreciate your interest in joining our team.</p>";
                $thankYouBody .= "<p>We will review your application and get back to you shortly.</p>";
                $thankYouBody .= "<p>Best regards,<br>The Simran Developer Team</p>";
                $thankYouBody .= "</body></html>";

                // Headers for candidate's thank-you email
                $thankYouHeaders = "From: $from\r\n";
                $thankYouHeaders .= "MIME-Version: 1.0\r\n";
                $thankYouHeaders .= "Content-Type: text/html; charset=UTF-8\r\n";

                // Send thank-you email to the candidate
                mail($email, $thankYouSubject, $thankYouBody, $thankYouHeaders);

                // Success message
                echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Application Submitted Successfully",
                        confirmButtonText: "OK"
                    }).then(function() {
                        window.location.href = "index.php";
                    });
                </script>';
            } else {
                echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Email Error!",
                        text: "Failed to send the application email. Please try again later.",
                        confirmButtonText: "OK"
                    });
                </script>';
            }
        } else {
            echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Database Error!",
                    text: "Failed to save the application. Please try again later.",
                    confirmButtonText: "OK"
                });
            </script>';
        }
    } else {
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Upload Error!",
                text: "Failed to upload resume. Please try again.",
                confirmButtonText: "OK"
            });
        </script>';
    }
}

?>