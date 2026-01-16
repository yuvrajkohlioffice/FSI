<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional: Font Awesome for icons in success message (if you uncomment it) -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            margin-top: 30px;
            margin-bottom: 30px;
        }
        h1, h2 {
            color: #343a40;
            margin-bottom: 20px;
        }
        h1 { text-align: center; }
        .form-label { font-weight: bold; }
        .table-responsive { margin-bottom: 1rem; }

        .photo-upload-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }
        .photo-upload-section .form-label,
        .photo-upload-section .form-text {
            text-align: center;
            width: 100%;
            display: block;
        }

        .image-preview-box {
            border: 2px dashed #ced4da;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 0.9em;
            color: #6c757d;
            margin-bottom: 10px;
            overflow: hidden;
            width: 90%; /* Adjusted for better fit */
        }
        .image-preview-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        #photo_preview_container { height: 200px; }
        #signature_preview_container { height: 70px; }
        .custom-file-input { max-width: 160px !important; } /* Might need adjustment based on actual appearance */

        .note-section {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            font-size: 0.9em;
        }
        .asterisk { color: red; }

        /* Success Message Overlay Styles */
        .success-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1060;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out, visibility 0s linear 0.3s;
        }
        .success-overlay.show {
            opacity: 1;
            visibility: visible;
            transition: opacity 0.3s ease-in-out, visibility 0s linear 0s;
        }
        .success-message-box {
            background-color: #fff;
            color: #155724;
            padding: 30px 40px;
            border-radius: 10px;
            border: 2px solid #28a745;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.25);
            transform: scale(0.8) translateY(20px);
            opacity: 0;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s ease-in-out;
            min-width: 300px;
        }
        .success-overlay.show .success-message-box {
            transform: scale(1) translateY(0);
            opacity: 1;
        }
        .success-message-box .icon {
            font-size: 50px;
            color: #28a745;
            margin-bottom: 15px;
            animation: bounceIn 0.8s ease;
        }
        @keyframes bounceIn {
            0%, 20%, 40%, 60%, 80%, 100% {transform: translateY(0);}
            50% {transform: translateY(-10px);}
        }
        .success-message-box h4 {
            color: #155724;
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 1.5rem;
        }
        .success-message-box p {
            margin-bottom: 20px;
            font-size: 1rem;
        }
        .success-message-box .btn-close-success {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
            padding: 10px 20px;
        }
        .success-message-box .btn-close-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .modal {
            z-index: 1070; /* Ensure modal is above success overlay if both could appear */
        }
        .modal-backdrop {
            z-index: 1065; /* Ensure modal backdrop is also correctly layered */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>APPLICATION FORM</h1>
        <hr class="mb-4">

        <?php if (isset($_GET['status']) && $_GET['status'] == 'error'): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php echo "Error submitting application: " . htmlspecialchars($_GET['message'] ?? 'Unknown error'); ?>
            </div>
        <?php endif; ?>

        <form action="submit_application.php" method="POST" enctype="multipart/form-data">

            <div class="row align-items-start">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="post_applied_for" class="form-label">1. Name of the post applied for: <span class="asterisk">*</span></label>
                        <select class="form-select" id="post_applied_for" name="post_applied_for" required>
                            <option value="">--Select Post--</option>
                            <option value="Technical Associate">Technical Associate</option>
                            <!--<option value="Junior Research Fellow">Junior Research Fellow</option>
                            <option value="Senior Project Manager">Senior Project Manager</option>
                            <option value="Data Analyst">Data Analyst</option>
                            <option value="Other">Other</option>-->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="applicant_name" class="form-label">2. Name of the Applicant (in Capital Letter): <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" id="applicant_name" name="applicant_name" style="text-transform: uppercase;" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 mb-3 mb-md-0"> <!-- Adjusted for better responsiveness on small screens -->
                            <div class="photo-upload-section">
                                <label for="applicant_photo" class="form-label">Photograph <span class="asterisk">*</span></label>
                                <div id="photo_preview_container" class="image-preview-box">
                                    <span>Passport Sized Photo Preview</span>
                                </div>
                                <input type="file" class="form-control form-control-sm custom-file-input" id="applicant_photo" name="applicant_photo" accept="image/jpeg, image/png, image/gif" required onchange="previewImage(event, 'photo_preview_container', 'Photo Preview')">
                                <small class="form-text text-muted">Max 2MB. JPG, PNG, GIF only.</small>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="photo-upload-section">
                                <label for="applicant_sig" class="form-label">Signature <span class="asterisk">*</span></label>
                                <div id="signature_preview_container" class="image-preview-box">
                                    <span>Signature Preview</span>
                                </div>
                                <input type="file" class="form-control form-control-sm custom-file-input" id="applicant_sig" name="applicant_sig" accept="image/jpeg, image/png, image/gif" required onchange="previewImage(event, 'signature_preview_container', 'Signature Preview')">
                                <small class="form-text text-muted">Max 300KB. JPG, PNG, GIF only.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="date_of_birth" class="form-label">3. Date of Birth (DD/MM/YYYY): <span class="asterisk">*</span></label>
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="age_as_on" class="form-label">4. Age as on (29<sup>th</sup> March 2025):</label>
                    <input type="number" class="form-control" id="age_as_on" name="age_as_on" readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="gender" class="form-label">5. Gender:</label>
                    <select class="form-select" id="gender" name="gender">
                        <option value="">--Select--</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="father_husband_name" class="form-label">6. Name of Father/ Husband: <span class="asterisk">*</span></label>
                    <input type="text" class="form-control" id="father_husband_name" name="father_husband_name" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="mobile_number" class="form-label">7. Mobile Number: <span class="asterisk">*</span></label>
                    <input type="text" class="form-control" id="mobile_number" name="mobile_number" pattern="[0-9]{10}" title="Mobile number must be exactly 10 digits." maxlength="10" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email_id" class="form-label">8. e-mail ID: <span class="asterisk">*</span></label>
                    <input type="email" class="form-control" id="email_id" name="email_id" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="address_correspondence" class="form-label">9. Address for correspondence: <span class="asterisk">*</span></label>
                <textarea class="form-control" id="address_correspondence" name="address_correspondence" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="permanent_address" class="form-label">10. Permanent Address: <span class="asterisk">*</span></label>
                <textarea class="form-control" id="permanent_address" name="permanent_address" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">11. Whether SC/ST/OBC/General: <span class="asterisk">*</span></label>
                <select class="form-select" id="category" name="category" required>
                    <option value="">--Select--</option>
                    <option value="SC">SC</option>
                    <option value="ST">ST</option>
                    <option value="OBC">OBC</option>
                    <option value="General">General</option>
                </select>
            </div>

            <h2 class="mt-5">12. Educational Qualification</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="educationTable">
                    <thead class="table-light">
                        <tr>
                            <th>Sr. No.</th>
                            <th>Examination Passed (indicate name of degree)</th>
                            <th>University/ Board</th>
                            <th>Year of Passing</th>
                            <th>Division</th>
                            <th>% of marks</th>
                            <th>Subjects Studied</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="edu-sr-no">1.</td>
                            <td><input type="text" class="form-control form-control-sm" name="edu_exam[]" placeholder="Matriculation"></td>
                            <td><input type="text" class="form-control form-control-sm" name="edu_board[]"></td>
                            <td><input type="number" class="form-control form-control-sm" name="edu_year[]" min="1950" max="<?php echo date('Y') + 5; ?>"></td>
                            <td><input type="text" class="form-control form-control-sm" name="edu_division[]"></td>
                            <td><input type="number" class="form-control form-control-sm" step="0.01" name="edu_marks[]" min="0" max="100"></td>
                            <td><input type="text" class="form-control form-control-sm" name="edu_subjects[]"></td>
                            <td><button type="button" class="btn btn-danger btn-sm p-1 remove-row-btn edu-remove-btn" title="Remove this row" aria-label="Remove education entry">×</button></td>
                        </tr>
                        <tr>
                            <td class="edu-sr-no">2.</td>
                            <td><input type="text" class="form-control form-control-sm" name="edu_exam[]" placeholder="Sr. Secondary"></td>
                            <td><input type="text" class="form-control form-control-sm" name="edu_board[]"></td>
                            <td><input type="number" class="form-control form-control-sm" name="edu_year[]" min="1950" max="<?php echo date('Y') + 5; ?>"></td>
                            <td><input type="text" class="form-control form-control-sm" name="edu_division[]"></td>
                            <td><input type="number" class="form-control form-control-sm" step="0.01" name="edu_marks[]" min="0" max="100"></td>
                            <td><input type="text" class="form-control form-control-sm" name="edu_subjects[]"></td>
                            <td><button type="button" class="btn btn-danger btn-sm p-1 remove-row-btn edu-remove-btn" title="Remove this row" aria-label="Remove education entry">×</button></td>
                        </tr>
                         <tr>
                            <td class="edu-sr-no">3.</td>
                            <td><input type="text" class="form-control form-control-sm" name="edu_exam[]" placeholder="Graduation"></td>
                            <td><input type="text" class="form-control form-control-sm" name="edu_board[]"></td>
                            <td><input type="number" class="form-control form-control-sm" name="edu_year[]" min="1950" max="<?php echo date('Y') + 5; ?>"></td>
                            <td><input type="text" class="form-control form-control-sm" name="edu_division[]"></td>
                            <td><input type="number" class="form-control form-control-sm" step="0.01" name="edu_marks[]" min="0" max="100"></td>
                            <td><input type="text" class="form-control form-control-sm" name="edu_subjects[]"></td>
                            <td><button type="button" class="btn btn-danger btn-sm p-1 remove-row-btn edu-remove-btn" title="Remove this row" aria-label="Remove education entry">×</button></td>
                        </tr>
                        <tr>
                            <td class="edu-sr-no">4.</td>
                            <td><input type="text" class="form-control form-control-sm" name="edu_exam[]" placeholder="Post Graduation"></td>
                            <td><input type="text" class="form-control form-control-sm" name="edu_board[]"></td>
                            <td><input type="number" class="form-control form-control-sm" name="edu_year[]" min="1950" max="<?php echo date('Y') + 5; ?>"></td>
                            <td><input type="text" class="form-control form-control-sm" name="edu_division[]"></td>
                            <td><input type="number" class="form-control form-control-sm" step="0.01" name="edu_marks[]" min="0" max="100"></td>
                            <td><input type="text" class="form-control form-control-sm" name="edu_subjects[]"></td>
                            <td><button type="button" class="btn btn-danger btn-sm p-1 remove-row-btn edu-remove-btn" title="Remove this row" aria-label="Remove education entry">×</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button type="button" id="addEducationRow" class="btn btn-success btn-sm mb-3">Add More Education</button>

            <h2 class="mt-4">13. Work Experience <small class="text-muted fs-6">(Applicant may attach separate sheet - include in single PDF)</small></h2>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="experienceTable">
                    <thead class="table-light">
                        <tr>
                            <th>Sl. No.</th>
                            <th>Department/ Organization</th>
                            <th>Period From</th>
                            <th>Period To</th>
                            <th>Designation</th>
                            <th>Salary / emoluments</th>
                            <th>Nature of duties</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="exp-sl-no">1.</td>
                            <td><input type="text" class="form-control form-control-sm" name="work_org[]"></td>
                            <td><input type="date" class="form-control form-control-sm" name="work_from[]"></td>
                            <td><input type="date" class="form-control form-control-sm" name="work_to[]"></td>
                            <td><input type="text" class="form-control form-control-sm" name="work_designation[]"></td>
                            <td><input type="text" class="form-control form-control-sm" name="work_salary[]"></td>
                            <td><textarea class="form-control form-control-sm" name="work_duties[]" rows="1"></textarea></td>
                            <td><button type="button" class="btn btn-danger btn-sm p-1 remove-row-btn exp-remove-btn" title="Remove this row" aria-label="Remove experience entry">×</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button type="button" id="addExperienceRow" class="btn btn-success btn-sm mb-3">Add More Experience</button>

            <div class="mb-3 mt-4">
                <label for="resume_summary" class="form-label">14. Resume in not more than 250 words highlighting your strengths and suitability for the post applied for: <span class="asterisk">*</span> <small class="text-muted">(Applicant may attach separate sheet - include in single PDF)</small></label>
                <textarea class="form-control" id="resume_summary" name="resume_summary" rows="5" maxlength="1500" required></textarea>
            </div>

            <div class="mb-3 mt-4">
                <label for="documents_pdf" class="form-label">Upload All Documents as a Single PDF <span class="asterisk">*</span> <small class="text-muted">(Self-attested copies of all certificates should be uploaded)</small>:</label>
                <input type="file" class="form-control" id="documents_pdf" name="documents_pdf" accept=".pdf" required>
                <small class="form-text text-muted">Max file size: 10MB. List of enclosures to include: Matriculation, Sr. Secondary, Graduation, Post Graduation (if any), Experience, Caste, Other Relevant Certificates.</small>
            </div>

            <h2 class="mt-5">15. Declaration</h2>
            <p>I affirm that the information given in this application is true and correct to the best of my knowledge and belief. I also fully understand that if at any stage it is discovered that an attempt has been made by me to willfully conceal or misrepresent the facts, my employment may be terminated along with any other legal action deemed fit under the law.</p>
            <div class="form-check mb-4">
                <input type="checkbox" class="form-check-input" id="declaration_ack" name="declaration_ack" value="agreed" required> <!-- Added value attribute -->
                <label class="form-check-label" for="declaration_ack"> I agree to the declaration. <span class="asterisk">*</span></label>
            </div>

           <!-- <div class="note-section mb-4">
                <p><strong>Note:</strong></p>
                <ol>
                    <li>Duly filled application form along with the copy of the certificates is to be sent through email (email ID: jdnfdmc@fsi.nic.in), Speed Post/ Registered Post at the address: Joint Director (FGD), Forest Survey of India, Kaulagarh Road, PO IPE, Dehradun- 248195</li>
                    <li>Please note that the email should mention in the subject "Application for the post of -"</li>
                    <li>The closing date for the receipt of application through email/Post in FSI is 29<sup>th</sup> March 2025</li>
                </ol>
                <p><i>This online form is for data collection. Please also follow the submission instructions above for physical/email submission.</i></p>
            </div>-->

            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg">Submit Application</button>
            </div>
        </form>
    </div>

    <!-- Success Message Overlay (hidden by default) -->
    <div class="success-overlay" id="successOverlay">
        <div class="success-message-box">
            <div class="icon">✔️</div> <!-- Consider using an actual SVG or Font Awesome icon if preferred -->
            <h4>Success!</h4>
            <p>Application submitted successfully!</p>
            <button type="button" class="btn btn-close-success" onclick="closeSuccessMessage()">OK</button>
        </div>
    </div>

    <!-- Duplicate Application Modal (Bootstrap) -->
    <div class="modal fade" id="duplicateApplicationModal" tabindex="-1" aria-labelledby="duplicateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="duplicateModalLabel">Application Alert</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="duplicateModalMessage">An application with these details already exists.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (Popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // All your JavaScript code from the original HTML
        document.addEventListener('DOMContentLoaded', function() {
            const dobInput = document.getElementById('date_of_birth');
            if (dobInput) {
                dobInput.addEventListener('change', calculateAge);
                const targetDateForAge = new Date('2025-03-29');
                dobInput.setAttribute('max', targetDateForAge.toISOString().split('T')[0]);
                if(dobInput.value) calculateAge.call(dobInput); 
            }
            
            updateSerialNumbers('#educationTable tbody', 'edu-sr-no', 'edu-remove-btn');
            updateSerialNumbers('#experienceTable tbody', 'exp-sl-no', 'exp-remove-btn');

            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            const message = urlParams.get('message');

            if (status === 'success') {
                showSuccessMessage();
                clearUrlParams(['status', 'message']); 
            } else if (status === 'duplicate') {
                const duplicateModalElement = document.getElementById('duplicateApplicationModal');
                if (duplicateModalElement) {
                    const duplicateModal = new bootstrap.Modal(duplicateModalElement);
                    const modalMessageElement = document.getElementById('duplicateModalMessage');
                    if (modalMessageElement && message) {
                        modalMessageElement.textContent = decodeURIComponent(message);
                    }
                    duplicateModal.show();
                }
                clearUrlParams(['status', 'message']); 
            } else if (status === 'error' && message) {
                clearUrlParams(['status', 'message']);
            }

            const pdfInput = document.getElementById('documents_pdf');
            if (pdfInput) {
                pdfInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const maxPdfSize = 10 * 1024 * 1024; 
                        if (file.type !== "application/pdf") {
                            alert("Invalid file type. Only PDF files are allowed for documents.");
                            event.target.value = ''; 
                            return;
                        }
                        if (file.size > maxPdfSize) {
                            alert("Document PDF file is too large. Maximum size is 10MB.");
                            event.target.value = ''; 
                        }
                    }
                });
            }
        });

        function clearUrlParams(paramNames) {
            if (window.history.replaceState) {
                const url = new URL(window.location.href);
                paramNames.forEach(param => url.searchParams.delete(param));
                window.history.replaceState({path: url.href}, '', url.href);
            }
        }

        function calculateAge() {
            const dobString = this.value;
            const ageAsOnInput = document.getElementById('age_as_on');
            if (!dobString) {
                 ageAsOnInput.value = '';
                 return;
            }
            
            const dob = new Date(dobString);
            const targetDate = new Date('2025-03-29'); 

            if (isNaN(dob.getTime())) { 
                ageAsOnInput.value = '';
                return;
            }

            let age = targetDate.getFullYear() - dob.getFullYear();
            const m = targetDate.getMonth() - dob.getMonth();
            if (m < 0 || (m === 0 && targetDate.getDate() < dob.getDate())) {
                age--;
            }
            ageAsOnInput.value = age >= 0 ? age : '';
        }

        function previewImage(event, previewContainerId, defaultText) {
            const fileInput = event.target;
            const previewContainer = document.getElementById(previewContainerId);
            if (!previewContainer) {
                console.error("Preview container not found:", previewContainerId);
                return;
            }
            const defaultSpan = `<span>${defaultText}</span>`;
            
            let currentMaxSize, maxSizeText;
            if (fileInput.id === 'applicant_photo') {
                currentMaxSize = 2 * 1024 * 1024; // 2MB
                maxSizeText = "2MB";
            } else if (fileInput.id === 'applicant_sig') {
                currentMaxSize = 300 * 1024; // 300KB
                maxSizeText = "300KB";
            } else {
                previewContainer.innerHTML = defaultSpan;
                return;
            }
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

            if (fileInput.files && fileInput.files[0]) {
                const file = fileInput.files[0];

                if (file.size > currentMaxSize) {
                    alert(`File is too large. Maximum size for ${fileInput.id === 'applicant_photo' ? 'photograph' : 'signature'} is ${maxSizeText}.`);
                    fileInput.value = ''; 
                    previewContainer.innerHTML = defaultSpan;
                    return;
                }
                if (!allowedTypes.includes(file.type.toLowerCase())) {
                    alert('Invalid file type. Only JPG, PNG, GIF allowed.');
                    fileInput.value = ''; 
                    previewContainer.innerHTML = defaultSpan;
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewContainer.innerHTML = `<img src="${e.target.result}" alt="${defaultText.replace(' Preview', '')}"/>`;
                };
                reader.readAsDataURL(file);
            } else {
                previewContainer.innerHTML = defaultSpan;
            }
        }

        function updateSerialNumbers(tableBodySelector, srNoClass, removeBtnClass) {
            const tableBody = document.querySelector(tableBodySelector);
            if (!tableBody) return;
            const rows = tableBody.querySelectorAll('tr');
            let firstRemoveButton = null;
            rows.forEach((row, index) => {
                const srCell = row.querySelector(`.${srNoClass}`);
                if (srCell) srCell.textContent = (index + 1) + '.';
                
                const removeBtn = row.querySelector(`.${removeBtnClass}`);
                if(removeBtn && index === 0) firstRemoveButton = removeBtn; 
                if(removeBtn) removeBtn.style.display = ''; 
            });

            if (rows.length <= 1 && firstRemoveButton) {
                 firstRemoveButton.style.display = 'none';
            }
        }

        document.getElementById('addEducationRow').addEventListener('click', function() {
            const tableBody = document.getElementById('educationTable').getElementsByTagName('tbody')[0];
            const templateRow = tableBody.rows[0]; 
            if (!templateRow) { 
                console.error("Education table template row not found!");
                return;
            }
            const newRow = templateRow.cloneNode(true);
            newRow.querySelectorAll('input, textarea').forEach(input => {
                if (input.type === 'number' || input.type === 'text' || input.type === 'date' || input.tagName.toLowerCase() === 'textarea') input.value = '';
                if (input.placeholder && input.name === 'edu_exam[]') input.placeholder = 'Degree/Certificate';
            });
            const removeBtnInNewRow = newRow.querySelector('.edu-remove-btn');
            if(removeBtnInNewRow) removeBtnInNewRow.style.display = '';

            tableBody.appendChild(newRow);
            updateSerialNumbers('#educationTable tbody', 'edu-sr-no', 'edu-remove-btn');
        });

        document.getElementById('addExperienceRow').addEventListener('click', function() {
            const tableBody = document.getElementById('experienceTable').getElementsByTagName('tbody')[0];
            const templateRow = tableBody.rows[0];
             if (!templateRow) { 
                console.error("Experience table template row not found!");
                return;
            }
            const newRow = templateRow.cloneNode(true);
            newRow.querySelectorAll('input, textarea').forEach(input => {
                 if (input.type === 'number' || input.type === 'text' || input.type === 'date' || input.tagName.toLowerCase() === 'textarea') input.value = '';
            });
            const removeBtnInNewRow = newRow.querySelector('.exp-remove-btn');
            if(removeBtnInNewRow) removeBtnInNewRow.style.display = '';

            tableBody.appendChild(newRow);
            updateSerialNumbers('#experienceTable tbody', 'exp-sl-no', 'exp-remove-btn');
        });

        document.addEventListener('click', function(event) {
            const target = event.target.closest('.remove-row-btn'); 
            if (target) {
                const row = target.closest('tr');
                const tableBody = row.parentNode;
                if (tableBody.rows.length > 1) { 
                    row.remove();
                } else {
                    row.querySelectorAll('input, textarea').forEach(input => {
                        if (input.type === 'number' || input.type === 'text' || input.type === 'date' || input.tagName.toLowerCase() === 'textarea') input.value = '';
                    });
                }

                if (target.classList.contains('edu-remove-btn')) {
                    updateSerialNumbers('#educationTable tbody', 'edu-sr-no', 'edu-remove-btn');
                } else if (target.classList.contains('exp-remove-btn')) {
                    updateSerialNumbers('#experienceTable tbody', 'exp-sl-no', 'exp-remove-btn');
                }
            }
        });

        function showSuccessMessage() {
            const overlay = document.getElementById('successOverlay');
            if (overlay) {
                overlay.classList.add('show');
            }
        }

        function closeSuccessMessage() {
            const overlay = document.getElementById('successOverlay');
            if (overlay) {
                overlay.classList.remove('show');
            }
        }
    </script>
</body>
</html>
