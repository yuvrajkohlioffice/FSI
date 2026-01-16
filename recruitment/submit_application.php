<?php
require_once 'db_config.php'; // Database connection

// --- Configuration for Uploads ---
$doc_upload_dir = 'documents/';
$photo_upload_dir = 'photos/';
$signature_upload_dir = 'signatures/';

$allowed_pdf_types = ['application/pdf'];
$max_pdf_size = 10 * 1024 * 1024; // 10 MB

$allowed_image_types = ['image/jpeg', 'image/png', 'image/gif'];
$max_photo_size = 2 * 1024 * 1024; // 2 MB
$max_signature_size = 300 * 1024; // 300 KB

// --- Helper Functions ---
function sanitize_input($data) {
    if (is_array($data)) {
        return array_map('sanitize_input', $data);
    }
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function redirect_with_message($status, $message = '') {
    $params = "status=$status";
    if (!empty($message)) {
        $params .= "&message=" . urlencode($message);
    }
    header("Location: index.php?$params"); // Assumes your form is index.php
    exit();
}

// --- Main Script Logic ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- Sanitize all POST data ---
    $post_applied_for = sanitize_input($_POST['post_applied_for']);
    $applicant_name = strtoupper(sanitize_input($_POST['applicant_name']));
    $date_of_birth = $_POST['date_of_birth'];
    $age_as_on = !empty($_POST['age_as_on']) ? (int)$_POST['age_as_on'] : NULL;
    $gender = sanitize_input($_POST['gender']);
    $father_husband_name = sanitize_input($_POST['father_husband_name']);
    $mobile_number = sanitize_input($_POST['mobile_number']);
    $email_id = filter_var($_POST['email_id'], FILTER_SANITIZE_EMAIL);
    $address_correspondence = sanitize_input($_POST['address_correspondence']);
    $permanent_address = sanitize_input($_POST['permanent_address']);
    $category = sanitize_input($_POST['category']);
    $resume_summary = sanitize_input($_POST['resume_summary']);

    $edu_exam = $_POST['edu_exam'] ?? [];
    $edu_board = $_POST['edu_board'] ?? [];
    $edu_year = $_POST['edu_year'] ?? [];
    $edu_division = $_POST['edu_division'] ?? [];
    $edu_marks = $_POST['edu_marks'] ?? [];
    $edu_subjects = $_POST['edu_subjects'] ?? [];

    $work_org = $_POST['work_org'] ?? [];
    $work_from = $_POST['work_from'] ?? [];
    $work_to = $_POST['work_to'] ?? [];
    $work_designation = $_POST['work_designation'] ?? [];
    $work_salary = $_POST['work_salary'] ?? [];
    $work_duties = $_POST['work_duties'] ?? [];

    // --- Basic Validations ---
    $error_messages = [];
    if (empty($post_applied_for)) $error_messages[] = "Post Applied For";
    if (empty($applicant_name)) $error_messages[] = "Applicant Name";
    if (empty($date_of_birth)) $error_messages[] = "Date of Birth";
    if (empty($father_husband_name)) $error_messages[] = "Father/Husband Name";
    if (empty($category)) $error_messages[] = "Category (SC/ST/OBC/General)";
    if (empty($address_correspondence)) $error_messages[] = "Address for Correspondence";
    if (empty($permanent_address)) $error_messages[] = "Permanent Address";
    if (empty(trim($resume_summary))) $error_messages[] = "Resume Summary";
    if (empty($mobile_number)) $error_messages[] = "Mobile Number";
    if (empty($email_id)) $error_messages[] = "Email ID";

    if (!empty($error_messages)) {
        redirect_with_message('error', 'Please fill all required fields: ' . implode(', ', $error_messages) . '.');
    }
    if (!filter_var($email_id, FILTER_VALIDATE_EMAIL)) {
        redirect_with_message('error', 'Invalid email format.');
    }
    if (!isset($_POST['declaration_ack'])) {
        redirect_with_message('error', 'You must agree to the declaration.');
    }

    // --- Check for Duplicate Application ---
    // Checks if an application with the same email for the same post already exists.
    $stmt_check_duplicate = $conn->prepare("SELECT id FROM applications WHERE email_id = ? AND post_applied_for = ? LIMIT 1");
    if (!$stmt_check_duplicate) {
        // Log this error, but give a generic message to the user or let the main try-catch handle it
        error_log("Prepare failed (check_duplicate): " . $conn->error);
        redirect_with_message('error', 'A system error occurred. Please try again.');
    }
    $stmt_check_duplicate->bind_param("ss", $email_id, $post_applied_for);
    $stmt_check_duplicate->execute();
    $stmt_check_duplicate->store_result();

    if ($stmt_check_duplicate->num_rows > 0) {
        $stmt_check_duplicate->close();
        redirect_with_message('duplicate', 'An application with this email address for the selected post already exists.');
    }
    $stmt_check_duplicate->close();
    // --- End Duplicate Check ---


    // --- File Uploads (Proceed only if no duplicate and basic validations passed) ---
    $applicant_photo_path = null;
    // ... (rest of the photo upload code remains the same)
    if (isset($_FILES['applicant_photo']) && $_FILES['applicant_photo']['error'] == UPLOAD_ERR_OK) {
        $photo_tmp_path = $_FILES['applicant_photo']['tmp_name'];
        $photo_name = basename($_FILES['applicant_photo']['name']);
        $photo_size = $_FILES['applicant_photo']['size'];
        $photo_type = $_FILES['applicant_photo']['type'];
        $photo_ext = strtolower(pathinfo($photo_name, PATHINFO_EXTENSION));

        if (!in_array($photo_type, $allowed_image_types) || !in_array($photo_ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            redirect_with_message('error', 'Invalid photo file type. Only JPG, PNG, GIF are allowed.');
        }
        if ($photo_size > $max_photo_size) {
            redirect_with_message('error', 'Photo file size exceeds the maximum limit of 2MB.');
        }
        $new_photo_name = 'photo_' . uniqid('', true) . '.' . $photo_ext;
        $photo_destination = $photo_upload_dir . $new_photo_name;
        if (!is_dir($photo_upload_dir)) mkdir($photo_upload_dir, 0755, true);
        if (move_uploaded_file($photo_tmp_path, $photo_destination)) {
            $applicant_photo_path = $photo_destination;
        } else {
            redirect_with_message('error', 'Failed to move uploaded photo. Check directory permissions.');
        }
    } else {
        redirect_with_message('error', 'Applicant photo is required. Error: ' . ($_FILES['applicant_photo']['error'] ?? 'Unknown'));
    }

    $applicant_signature_path = null;
    // ... (rest of the signature upload code remains the same)
    if (isset($_FILES['applicant_sig']) && $_FILES['applicant_sig']['error'] == UPLOAD_ERR_OK) {
        $sig_tmp_path = $_FILES['applicant_sig']['tmp_name'];
        $sig_name = basename($_FILES['applicant_sig']['name']);
        $sig_size = $_FILES['applicant_sig']['size'];
        $sig_type = $_FILES['applicant_sig']['type'];
        $sig_ext = strtolower(pathinfo($sig_name, PATHINFO_EXTENSION));

        if (!in_array($sig_type, $allowed_image_types) || !in_array($sig_ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            redirect_with_message('error', 'Invalid signature file type. Only JPG, PNG, GIF are allowed.');
        }
        if ($sig_size > $max_signature_size) {
            redirect_with_message('error', 'Signature file size exceeds the maximum limit of 300KB.');
        }
        $new_sig_name = 'sig_' . uniqid('', true) . '.' . $sig_ext;
        $sig_destination = $signature_upload_dir . $new_sig_name;
        if (!is_dir($signature_upload_dir)) mkdir($signature_upload_dir, 0755, true);
        if (move_uploaded_file($sig_tmp_path, $sig_destination)) {
            $applicant_signature_path = $sig_destination;
        } else {
            redirect_with_message('error', 'Failed to move uploaded signature. Check directory permissions.');
        }
    } else {
        redirect_with_message('error', 'Applicant signature is required. Error: ' . ($_FILES['applicant_sig']['error'] ?? 'Unknown'));
    }


    $document_pdf_path = null;
    // ... (rest of the document PDF upload code remains the same)
    if (isset($_FILES['documents_pdf']) && $_FILES['documents_pdf']['error'] == UPLOAD_ERR_OK) {
        $pdf_tmp_path = $_FILES['documents_pdf']['tmp_name'];
        $pdf_name = basename($_FILES['documents_pdf']['name']);
        $pdf_size = $_FILES['documents_pdf']['size'];
        $pdf_type = $_FILES['documents_pdf']['type'];
        $pdf_ext = strtolower(pathinfo($pdf_name, PATHINFO_EXTENSION));

        if ($pdf_ext !== 'pdf' || !in_array($pdf_type, $allowed_pdf_types)) {
            redirect_with_message('error', 'Only PDF files are allowed for documents.');
        }
        if ($pdf_size > $max_pdf_size) {
            redirect_with_message('error', 'Document PDF file size exceeds 10MB.');
        }
        $new_pdf_name = 'doc_' . uniqid('', true) . '.' . $pdf_ext;
        $pdf_destination = $doc_upload_dir . $new_pdf_name;
        if (!is_dir($doc_upload_dir)) mkdir($doc_upload_dir, 0755, true);
        if (move_uploaded_file($pdf_tmp_path, $pdf_destination)) {
            $document_pdf_path = $pdf_destination;
        } else {
            redirect_with_message('error', 'Failed to move uploaded document PDF. Check directory permissions.');
        }
    } else {
        redirect_with_message('error', 'Document PDF is required. Error: ' . ($_FILES['documents_pdf']['error'] ?? 'Unknown'));
    }


    // --- Database Insertion ---
    $conn->begin_transaction();
    try {
        // 1. Insert into applications table
        $stmt_app = $conn->prepare("INSERT INTO applications (post_applied_for, applicant_name, date_of_birth, age_as_on_2025_03_29, gender, father_husband_name, mobile_number, email_id, address_correspondence, permanent_address, category, photo_path, signature_path, resume_summary, document_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt_app) {
            throw new Exception("Prepare failed (applications): " . $conn->error);
        }
        $stmt_app->bind_param("sssisssssssssss",
            $post_applied_for, $applicant_name, $date_of_birth, $age_as_on, $gender,
            $father_husband_name, $mobile_number, $email_id, $address_correspondence,
            $permanent_address, $category, $applicant_photo_path, $applicant_signature_path,
            $resume_summary, $document_pdf_path
        );
        if (!$stmt_app->execute()) {
            throw new Exception("Execute failed (applications): " . $stmt_app->error);
        }
        $application_id = $conn->insert_id;
        $stmt_app->close();

        // 2. Insert into educational_qualifications table
        // ... (educational qualifications code remains the same)
        $stmt_edu = $conn->prepare("INSERT INTO educational_qualifications (application_id, examination_passed, university_board, year_of_passing, division, percentage_marks, subjects_studied) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt_edu) throw new Exception("Prepare failed (edu_qual): " . $conn->error);
        for ($i = 0; $i < count($edu_exam); $i++) {
            if (!empty(trim(sanitize_input($edu_exam[$i])))) {
                $s_edu_exam = sanitize_input($edu_exam[$i]);
                $s_edu_board = sanitize_input($edu_board[$i]);
                $year = !empty($edu_year[$i]) ? (int)$edu_year[$i] : NULL;
                $s_edu_division = sanitize_input($edu_division[$i]);
                $marks = !empty($edu_marks[$i]) ? (float)$edu_marks[$i] : NULL;
                $s_edu_subjects = sanitize_input($edu_subjects[$i]);
                $stmt_edu->bind_param("issisds", $application_id, $s_edu_exam, $s_edu_board, $year, $s_edu_division, $marks, $s_edu_subjects);
                if (!$stmt_edu->execute()) throw new Exception("Execute failed (edu_qual loop): " . $stmt_edu->error);
            }
        }
        $stmt_edu->close();


        // 3. Insert into work_experience table
        // ... (work experience code remains the same)
        $stmt_work = $conn->prepare("INSERT INTO work_experience (application_id, department_organization, period_from, period_to, designation, salary_emoluments, nature_of_duties) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt_work) throw new Exception("Prepare failed (work_exp): " . $conn->error);
        for ($i = 0; $i < count($work_org); $i++) {
            if (!empty(trim(sanitize_input($work_org[$i])))) {
                $s_work_org = sanitize_input($work_org[$i]);
                $from_date = !empty($work_from[$i]) ? $work_from[$i] : NULL;
                $to_date = !empty($work_to[$i]) ? $work_to[$i] : NULL;
                $s_work_designation = sanitize_input($work_designation[$i]);
                $s_work_salary = sanitize_input($work_salary[$i]);
                $s_work_duties = sanitize_input($work_duties[$i]);
                $stmt_work->bind_param("issssss", $application_id, $s_work_org, $from_date, $to_date, $s_work_designation, $s_work_salary, $s_work_duties);
                if (!$stmt_work->execute()) throw new Exception("Execute failed (work_exp loop): " . $stmt_work->error);
            }
        }
        $stmt_work->close();


        $conn->commit();
        redirect_with_message('success');

    } catch (Exception $e) {
        $conn->rollback();
        if ($applicant_photo_path && file_exists($applicant_photo_path)) @unlink($applicant_photo_path);
        if ($applicant_signature_path && file_exists($applicant_signature_path)) @unlink($applicant_signature_path);
        if ($document_pdf_path && file_exists($document_pdf_path)) @unlink($document_pdf_path);
        
        error_log("Application submission DB error: " . $e->getMessage());
        redirect_with_message('error', 'Database error occurred. Please try again. Details: ' . $e->getMessage());
    }

    $conn->close();

} else {
    redirect_with_message('error', 'Invalid request method.');
}
?>