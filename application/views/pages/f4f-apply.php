<!-- Month Select Plugin CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css" />
<link rel="stylesheet" href="<?= base_url('assets/css/f4f_apply.css') ?>" />

<?php
if ($application_status === 'closed' || !$application_start) {
    ?>
    <div style="
        max-width: 600px;
        margin: 40px auto;
        padding: 20px 30px;
        background-color: #fef3c7;
        border: 2px solid #f59e0b;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    ">
        <div style="
            font-size: 24px;
            margin-bottom: 8px;
        ">⚠️</div>
        <p style="
            font-size: 18px;
            font-weight: 600;
            color: #92400e;
            margin: 0;
            line-height: 1.4;
        ">There's no ongoing application</p>
    </div>
    <?php
    return;
}
if ($user_review_status === 'reviewed') {
    ?>
    <div style="
        max-width: 600px;
        margin: 40px auto;
        padding: 20px 30px;
        background-color: #fef3c7;
        border: 2px solid #f59e0b;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    ">
        <div style="
            font-size: 24px;
            margin-bottom: 8px;
        ">⚠️</div>
        <p style="
            font-size: 18px;
            font-weight: 600;
            color: #92400e;
            margin: 0;
            line-height: 1.4;
        ">Your application has been submitted and reviewed.</p>
    </div>
    <?php
    return;
}
if ($user_submission_status === 'completed') {
    ?>
    <div style="
        max-width: 600px;
        margin: 40px auto;
        padding: 20px 30px;
        background-color: #fef3c7;
        border: 2px solid #f59e0b;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    ">
        <div style="
            font-size: 24px;
            margin-bottom: 8px;
        ">⚠️</div>
        <p style="
            font-size: 18px;
            font-weight: 600;
            color: #92400e;
            margin: 0;
            line-height: 1.4;
        ">Your application has been submitted and it is currently pending review.</p>
    </div>
    <?php
    return;
}
?>

<header class="page-hero">
    <div class="container text-center">
        <h1>FARMERS FOR THE FUTURE YOUTH GRANT</h1>
        <p class="lead">Application Form</p>
    </div>
</header>

<main class="container py-5">
    <form id="f4fApplicationForm" class="row justify-content-center">
        <div class="col-lg-9">
            <!-- Team Lead Information -->
            <div class="form-section-card">
                <h3>Team Lead Information</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="firstName" class="form-label">First Name <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" id="firstName" name="firstName"
                            value="<?= !empty($form_data['firstname']) ? $form_data['firstname'] : ''; ?>" />
                    </div>
                    <div class="col-md-6">
                        <label for="lastName" class="form-label">Last Name <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" id="lastName" name="lastName"
                            value="<?= !empty($form_data['lastname']) ? $form_data['lastname'] : ''; ?>" />
                    </div>
                    <div class="col-md-6">
                        <label for="emailAddress" class="form-label">Your Email Address <sup
                                class="text-danger">*</sup></label>
                        <input type="email" class="form-control" id="emailAddress" name="emailAddress"
                            value="<?= $user_email ?>" disabled />
                    </div>
                    <div class="col-md-6">
                        <label for="mobileNumber" class="form-label">Your Mobile Number <sup
                                class="text-danger">*</sup></label>
                        <input type="tel" class="form-control" id="mobileNumber" name="mobileNumber"
                            pattern="0[7-9][0-1][0-9]{8}" maxlength="11" inputmode="numeric"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                            value="<?= !empty($form_data['phone']) ? $form_data['phone'] : ''; ?>" />
                    </div>
                    <div class="col-md-6">
                        <label for="gender" class="form-label">Gender <sup class="text-danger">*</sup></label>
                        <select class="form-select" id="gender" name="gender">
                            <option value="" disabled selected>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="dateOfBirth" class="form-label">Date of Birth <sup
                                class="text-danger">*</sup></label>
                        <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth"
                            value="<?= !empty($form_data['date_of_birth']) ? $form_data['date_of_birth'] : ''; ?>" />
                    </div>
                    <div class="col-md-4">
                        <label for="nyscBatch" class="form-label">NYSC Batch<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" id="nyscBatch" name="nyscBatch"
                            value="<?= !empty($form_data['nysc_batch']) ? $form_data['nysc_batch'] : ''; ?>" />
                    </div>
                    <div class="col-md-4">
                        <label for="nyscCallUpNo" class="form-label">NYSC Call up No.<sup
                                class="text-danger">*</sup></label>
                        <input type="text" class="form-control" id="nyscCallUpNo" name="nyscCallUpNo"
                            value="<?= !empty($form_data['nysc_callup_number']) ? $form_data['nysc_callup_number'] : ''; ?>" />
                    </div>
                    <div class="col-md-4">
                        <label for="nyscCdsDay" class="form-label">NYSC CDS Day<sup class="text-danger">*</sup></label>
                        <select class="form-select" id="nyscCdsDay" name="nyscCdsDay">
                            <option value="" disabled selected>Select Day</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="statePostedTo" class="form-label">State Posted to <sup
                                class="text-danger">*</sup></label>
                        <select class="form-select" id="statePostedTo" name="statePostedTo">
                            <option value="" disabled selected>Select State</option>
                            <!-- States of Nigeria -->
                            <option value="Abia">Abia</option>
                            <option value="Adamawa">Adamawa</option>
                            <option value="Akwa Ibom">Akwa Ibom</option>
                            <option value="Anambra">Anambra</option>
                            <option value="Bauchi">Bauchi</option>
                            <option value="Bayelsa">Bayelsa</option>
                            <option value="Benue">Benue</option>
                            <option value="Borno">Borno</option>
                            <option value="Cross River">Cross River</option>
                            <option value="Delta">Delta</option>
                            <option value="Ebonyi">Ebonyi</option>
                            <option value="Edo">Edo</option>
                            <option value="Ekiti">Ekiti</option>
                            <option value="Enugu">Enugu</option>
                            <option value="FCT Abuja">FCT Abuja</option>
                            <option value="Gombe">Gombe</option>
                            <option value="Imo">Imo</option>
                            <option value="Jigawa">Jigawa</option>
                            <option value="Kaduna">Kaduna</option>
                            <option value="Kano">Kano</option>
                            <option value="Katsina">Katsina</option>
                            <option value="Kebbi">Kebbi</option>
                            <option value="Kogi">Kogi</option>
                            <option value="Kwara">Kwara</option>
                            <option value="Lagos">Lagos</option>
                            <option value="Nasarawa">Nasarawa</option>
                            <option value="Niger">Niger</option>
                            <option value="Ogun">Ogun</option>
                            <option value="Ondo">Ondo</option>
                            <option value="Osun">Osun</option>
                            <option value="Oyo">Oyo</option>
                            <option value="Plateau">Plateau</option>
                            <option value="Rivers">Rivers</option>
                            <option value="Sokoto">Sokoto</option>
                            <option value="Taraba">Taraba</option>
                            <option value="Yobe">Yobe</option>
                            <option value="Zamfara">Zamfara</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="stateCode" class="form-label">State Code<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" id="stateCode" name="stateCode"
                            value="<?= !empty($form_data['nysc_state_code']) ? $form_data['nysc_state_code'] : ''; ?>" />
                    </div>
                    <div class="col-md-6">
                        <label for="highestQualification" class="form-label">Highest Educational Qualification
                            <sup class="text-danger">*</sup></label>
                        <select class="form-select" id="highestQualification" name="highestQualification">
                            <option value="" disabled selected>Select Qualification</option>
                            <option value="OND">OND</option>
                            <option value="HND">HND</option>
                            <option value="BSc">BSc</option>
                            <option value="Masters">Masters</option>
                            <option value="PhD">PhD</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="higherInstitution" class="form-label">Higher Institution Attended<sup
                                class="text-danger">*</sup></label>
                        <select class="form-select" id="higherInstitution" name="higherInstitution">
                            <option value="" disabled selected>Select Institution</option>
                            <option value="Ahmadu Bello University">
                                Ahmadu Bello University
                            </option>
                            <option value="Federal University of Agriculture, Abeokuta (FUNAAB)">
                                Federal University of Agriculture, Abeokuta (FUNAAB)
                            </option>
                            <option value="Michael Okpara University of Agriculture, Umudike">
                                Michael Okpara University of Agriculture, Umudike
                            </option>

                            <option value="Obafemi Awolowo University">
                                Obafemi Awolowo University
                            </option>

                            <option value="University of Ibadan">
                                University of Ibadan
                            </option>
                            <option value="University of Ilorin">
                                University of Ilorin
                            </option>

                            <option value="University of Lagos">
                                University of Lagos
                            </option>
                            <option value="University of Nigeria, Nsukka">
                                University of Nigeria, Nsukka
                            </option>
                            <option value="Other">
                                Other (Please specify in Course Read)
                            </option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="courseRead" class="form-label">Course Read<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" id="courseRead" name="courseRead"
                            value="<?= !empty($form_data['course_of_study']) ? $form_data['course_of_study'] : ''; ?>" />
                    </div>
                    <div class="col-md-6">
                        <label for="yourRole" class="form-label">Your Role in the Business<sup
                                class="text-danger">*</sup></label>
                        <input type="text" class="form-control" id="yourRole" name="yourRole"
                            value="<?= !empty($form_data['business_role']) ? $form_data['business_role'] : ''; ?>" />
                    </div>
                    <div class="col-md-6">
                        <label for="firstBusiness" class="form-label">Is this your first business?
                            <sup class="text-danger">*</sup></label>
                        <select class="form-select" id="firstBusiness" name="firstBusiness">
                            <option value="" disabled selected>Select an option</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="col-12" id="otherBusinessesSection" style="display: none">
                        <label for="otherBusinesses" class="form-label">If No, describe any other businesses you have
                            been involved
                            in (Not more than 400 Characters)<sup class="text-danger">*</sup></label>
                        <textarea class="form-control" id="otherBusinesses" name="otherBusinesses" maxlength="400">
                            <?= htmlspecialchars($form_data['other_business_description'] ?? ''); ?>
                        </textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="facebookLink" class="form-label">Facebook Link</label>
                        <input type="url" class="form-control" id="facebookLink" name="facebookLink"
                            placeholder="e.g., https://facebook.com/yourprofile"
                            value="<?= !empty($form_data['facebook_url']) ? $form_data['facebook_url'] : '' ?>" />
                    </div>
                    <div class="col-md-6">
                        <label for="twitterHandle" class="form-label">Twitter Handle</label>
                        <input type="text" class="form-control" id="twitterHandle" name="twitterHandle"
                            placeholder="e.g., @yourhandle"
                            value="<?= !empty($form_data['twitter_handle']) ? $form_data['twitter_handle'] : '' ?>" ; />
                    </div>
                    <div class="col-md-6">
                        <label for="instagramHandle" class="form-label">Instagram Handle</label>
                        <input type="text" class="form-control" id="instagramHandle" name="instagramHandle"
                            placeholder="e.g., @yourhandle"
                            value="<?= !empty($form_data['instagram_handle']) ? $form_data['instagram_handle'] : ''; ?>" />
                    </div>
                    <div class="col-md-6">
                        <label for="linkedinProfile" class="form-label">Your Linkedin Profile URL</label>
                        <input type="url" class="form-control" id="linkedinProfile" name="linkedinProfile"
                            placeholder="e.g., https://linkedin.com/in/yourprofile"
                            value="<?= !empty($form_data['linkedin_url']) ? $form_data['linkedin_url'] : ''; ?>" />
                    </div>
                    <div class="col-12">
                        <label for="howDidYouHear" class="form-label">How did you first hear about the Farmers for the
                            Future
                            Program? <sup class="text-danger">*</sup></label>
                        <select class="form-select" id="howDidYouHear" name="howDidYouHear">
                            <option value="" disabled selected>Select an option</option>
                            <option value="SMS">SMS</option>
                            <option value="Email">Email</option>
                            <option value="Facebook">Facebook</option>
                            <option value="Twitter">Twitter</option>
                            <option value="LinkedIn">LinkedIn</option>
                            <option value="Instagram">Instagram</option>
                            <option value="Friend/Family">Friend/Family</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="attendedIncubation" class="form-label">Have you attended any incubation or
                            accelerator programme
                            before? <sup class="text-danger">*</sup></label>
                        <select class="form-select" id="attendedIncubation" name="attendedIncubation">
                            <option value="" disabled selected>Select an option</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Business Basics -->
            <div class="form-section-card">
                <h3>Business Basics</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="businessName" class="form-label">Business Name <sup
                                class="text-danger">*</sup></label>
                        <input type="text" class="form-control" id="businessName" name="businessName"
                            value="<?= !empty($form_data['business_name']) ? $form_data['business_name'] : ''; ?>" />
                    </div>
                    <div class="col-md-6">
                        <label for="businessLocation" class="form-label">Business Location <sup
                                class="text-danger">*</sup></label>
                        <select class="form-select" id="businessLocation" name="businessLocation">
                            <option value="" disabled selected>Select State</option>
                            <!-- States of Nigeria -->
                            <option value="Abia">Abia</option>
                            <option value="Adamawa">Adamawa</option>
                            <option value="Akwa Ibom">Akwa Ibom</option>
                            <option value="Anambra">Anambra</option>
                            <option value="Bauchi">Bauchi</option>
                            <option value="Bayelsa">Bayelsa</option>
                            <option value="Benue">Benue</option>
                            <option value="Borno">Borno</option>
                            <option value="Cross River">Cross River</option>
                            <option value="Delta">Delta</option>
                            <option value="Ebonyi">Ebonyi</option>
                            <option value="Edo">Edo</option>
                            <option value="Ekiti">Ekiti</option>
                            <option value="Enugu">Enugu</option>
                            <option value="FCT Abuja">FCT Abuja</option>
                            <option value="Gombe">Gombe</option>
                            <option value="Imo">Imo</option>
                            <option value="Jigawa">Jigawa</option>
                            <option value="Kaduna">Kaduna</option>
                            <option value="Kano">Kano</option>
                            <option value="Katsina">Katsina</option>
                            <option value="Kebbi">Kebbi</option>
                            <option value="Kogi">Kogi</option>
                            <option value="Kwara">Kwara</option>
                            <option value="Lagos">Lagos</option>
                            <option value="Nasarawa">Nasarawa</option>
                            <option value="Niger">Niger</option>
                            <option value="Ogun">Ogun</option>
                            <option value="Ondo">Ondo</option>
                            <option value="Osun">Osun</option>
                            <option value="Oyo">Oyo</option>
                            <option value="Plateau">Plateau</option>
                            <option value="Rivers">Rivers</option>
                            <option value="Sokoto">Sokoto</option>
                            <option value="Taraba">Taraba</option>
                            <option value="Yobe">Yobe</option>
                            <option value="Zamfara">Zamfara</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="businessWebsite" class="form-label">Business Website (if available)</label>
                        <input type="url" class="form-control" id="businessWebsite" name="businessWebsite"
                            placeholder="e.g., https://yourbusiness.com"
                            value="<?= !empty($form_data['business_website']) ? $form_data['business_website'] : ''; ?>" />
                    </div>
                    <div class="col-12">
                        <label class="form-label">Agric Field <sup class="text-danger">*</sup></label>
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="agricField" value="Crop Farming"
                                        id="cropFarming" />
                                    <label class="form-check-label" for="cropFarming">Crop Farming</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="agricField"
                                        value="Livestock/Animal Husbandry" id="livestock" />
                                    <label class="form-check-label" for="livestock">Livestock/Animal Husbandry</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="agricField"
                                        value="Agricultural Product Logistics & Distribution" id="logistics" />
                                    <label class="form-check-label" for="logistics">Agricultural Product Logistics &
                                        Distribution</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="agricField"
                                        value="Trade (Wholesale/Retail)" id="trade" />
                                    <label class="form-check-label" for="trade">Trade (Wholesale/Retail)</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="agricField" value="Aquaculture"
                                        id="aquaculture" />
                                    <label class="form-check-label" for="aquaculture">Aquaculture</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="agricField" value="Horticulture"
                                        id="horticulture" />
                                    <label class="form-check-label" for="horticulture">Horticulture</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="agricField"
                                        value="Agricultural Mechanization" id="mechanization" />
                                    <label class="form-check-label" for="mechanization">Agricultural
                                        Mechanization</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="agricField"
                                        value="Agricultural Produce Processing" id="processing" />
                                    <label class="form-check-label" for="processing">Agricultural Produce
                                        Processing</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="agricField" value="AgTech"
                                        id="agtech" />
                                    <label class="form-check-label" for="agtech">AgTech</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="agricField"
                                        value="Agric Financing" id="agricFinancing" />
                                    <label class="form-check-label" for="agricFinancing">Agric Financing</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="agricField"
                                        value="Agric Education & Stakeholder Support" id="agricEducation" />
                                    <label class="form-check-label" for="agricEducation">Agric Education & Stakeholder
                                        Support</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="agricField" value="Other"
                                        id="agricOther" />
                                    <label class="form-check-label" for="agricOther">others</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="businessRegistered" class="form-label">Is your Business Registered?
                            <sup class="text-danger">*</sup></label>
                        <select class="form-select" id="businessRegistered" name="businessRegistered">
                            <option value="" disabled selected>Select an option</option>
                            <option value="Yes (Business Name)">
                                Yes (Business Name)
                            </option>
                            <option value="Yes (Limited Liability Company)">
                                Yes (Limited Liability Company)
                            </option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="dateStarted" class="form-label">When did you start your business? (MM/YY)
                            <sup class="text-danger">*</sup></label>
                        <input type="month" class="form-control" id="dateStarted" name="dateStarted" placeholder="MM/YY"
                            value="<?= !empty($form_data['business_start_date']) ? $form_data['business_start_date'] : ''; ?>" />
                    </div>
                    <div class="col-12">
                        <label for="stageOfBusiness" class="form-label">Stage of Business <sup
                                class="text-danger">*</sup></label>
                        <select class="form-select" id="stageOfBusiness" name="stageOfBusiness">
                            <option value="" disabled selected>Select Stage</option>
                            <option value="Idea Stage (Not Tested)">
                                Idea Stage (Not Tested)
                            </option>
                            <option value="Prototype Stage (I am currently testing the business idea)">
                                Prototype Stage (I am currently testing the business idea)
                            </option>
                            <option value="Setup: We are currently Setting up">
                                Setup: We are currently Setting up
                            </option>
                            <option value="Pre-Revenue: We have started, but not made revenue">
                                Pre-Revenue: We have started, but not made revenue
                            </option>
                            <option value="Post Revenue: We have started making Revenue">
                                Post Revenue: We have started making Revenue
                            </option>
                        </select>
                    </div>
                    <div class="col-12" id="revenueSection" style="display: none">
                        <label for="revenueToDate" class="form-label">If Post-Revenue, What is your revenue till date?
                            (Numbers
                            only, no commas)</label>
                        <input type="number" class="form-control" id="revenueToDate" name="revenueToDate" maxlength="9"
                            value="<?= !empty($form_data['revenue_till_date']) ? $form_data['revenue_till_date'] : ''; ?>" />
                    </div>
                    <div class="col-12">
                        <label for="achievements" class="form-label">Your Achievements in the business, so far. (Not
                            more than 400
                            Characters)<sup class="text-danger">*</sup></label>
                        <textarea class="form-control" id="achievements" name="achievements" maxlength="400">
                            <?= htmlspecialchars($form_data['business_achievements'] ?? ''); ?>
                        </textarea>
                    </div>
                    <div class="col-12">
                        <label for="capitalFunding" class="form-label">Have you received any form of capital funding for
                            the
                            business before? <sup class="text-danger">*</sup></label>
                        <select class="form-select" id="capitalFunding" name="capitalFunding">
                            <option value="" disabled selected>Select an option</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="inPartnership" class="form-label">Are you in partnership with anyone in the business
                            (or do you
                            have a co-founder)? <sup class="text-danger">*</sup></label>
                        <select class="form-select" id="inPartnership" name="inPartnership">
                            <option value="" disabled selected>Select an option</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="col-12" id="stakeInBusinessSection" style="display: none">
                        <label for="stakeInBusiness" class="form-label">If yes, what is your stake in the business?
                            (Enter value in percentage %)</label>
                        <input type="number" class="form-control" id="stakeInBusiness" name="stakeInBusiness" min="0"
                            max="100" step="1" oninput="this.value = this.value.slice(0, 3)"
                            value="<?= !empty($form_data['stake_in_business']) ? $form_data['stake_in_business'] : ''; ?>" />
                    </div>
                    <div class="col-12">
                        <label for="hasLoanOrDebt" class="form-label">Is the business in any loan or debt before now?
                            <sup class="text-danger">*</sup></label>
                        <select class="form-select" id="hasLoanOrDebt" name="hasLoanOrDebt">
                            <option value="" disabled selected>Select an option</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Business Thesis -->
            <div class="form-section-card">
                <h3>Business Thesis</h3>
                <div class="row g-3">
                    <div class="col-12">
                        <label for="problemSolving" class="form-label">What Problem is your business Solving? <sup
                                class="text-danger">*</sup></label>
                        <textarea class="form-control" id="problemSolving" name="problemSolving" rows="3"
                            maxlength="400">
                            <?= htmlspecialchars($form_data['problem_to_solve'] ?? '') ?></textarea>
                    </div>

                    <div class="col-12">
                        <label for="describeSolution" class="form-label">Describe your solution <sup
                                class="text-danger">*</sup></label>
                        <textarea class="form-control" id="describeSolution" name="describeSolution" rows="3"
                            maxlength="400"><?= htmlspecialchars($form_data['business_solution'] ?? '') ?></textarea>
                    </div>

                    <div class="col-12">
                        <label for="productServiceOffering" class="form-label">What is/are your product/service
                            offering(s)? <sup class="text-danger">*</sup></label>
                        <textarea class="form-control" id="productServiceOffering" name="productServiceOffering"
                            rows="3"
                            maxlength="400"><?= htmlspecialchars($form_data['business_offerings'] ?? '') ?></textarea>
                    </div>

                    <div class="col-12">
                        <label for="targetMarket" class="form-label">Who is your target Market? <sup
                                class="text-danger">*</sup></label>
                        <textarea class="form-control" id="targetMarket" name="targetMarket" rows="3"
                            maxlength="400"><?= htmlspecialchars($form_data['target_market'] ?? '') ?></textarea>
                    </div>

                    <div class="col-12">
                        <label for="howMakeMoney" class="form-label">How will you make Money? <sup
                                class="text-danger">*</sup></label>
                        <textarea class="form-control" id="howMakeMoney" name="howMakeMoney" rows="3"
                            maxlength="400"><?= htmlspecialchars($form_data['monetization_strategy'] ?? '') ?></textarea>
                    </div>

                    <div class="col-12">
                        <label for="proofOfPayment" class="form-label">What proof do you have that people will pay? <sup
                                class="text-danger">*</sup></label>
                        <textarea class="form-control" id="proofOfPayment" name="proofOfPayment" rows="3"
                            maxlength="400"><?= htmlspecialchars($form_data['market_validation'] ?? '') ?></textarea>
                    </div>

                    <div class="col-12">
                        <label for="competitors" class="form-label">Who are your competitors? <sup
                                class="text-danger">*</sup></label>
                        <textarea class="form-control" id="competitors" name="competitors" rows="3"
                            maxlength="400"><?= htmlspecialchars($form_data['business_competitors'] ?? '') ?></textarea>
                    </div>

                    <div class="col-12">
                        <label for="productUnique" class="form-label">How is your product/service unique? <sup
                                class="text-danger">*</sup></label>
                        <textarea class="form-control" id="productUnique" name="productUnique" rows="3"
                            maxlength="400"><?= htmlspecialchars($form_data['business_uniqueness'] ?? '') ?></textarea>
                    </div>

                    <div class="col-12">
                        <label for="planToOutdoCompetition" class="form-label">What is your plan to out-do the
                            competition? <sup class="text-danger">*</sup></label>
                        <textarea class="form-control" id="planToOutdoCompetition" name="planToOutdoCompetition"
                            rows="3"
                            maxlength="400"><?= htmlspecialchars($form_data['competitive_advantage'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Your Vision, Motivation & Support Requirement -->
            <div class="form-section-card">
                <h3>Your Vision, Motivation & Support Requirement</h3>
                <div class="row g-3">
                    <div class="col-12">
                        <label for="motivation" class="form-label">What motivated you to start this business? <sup
                                class="text-danger">*</sup></label>
                        <textarea class="form-control" id="motivation" name="motivation" rows="3"
                            maxlength="400"><?= htmlspecialchars($form_data['business_motivation'] ?? '') ?></textarea>
                    </div>

                    <div class="col-12">
                        <label for="longTermVision" class="form-label">What is your long-term vision? <sup
                                class="text-danger">*</sup></label>
                        <textarea class="form-control" id="longTermVision" name="longTermVision" rows="3"
                            maxlength="400"><?= htmlspecialchars($form_data['business_vision'] ?? '') ?></textarea>
                    </div>

                    <div class="col-12">
                        <label for="bestPerson" class="form-label">Why are you the best person for this business? <sup
                                class="text-danger">*</sup></label>
                        <textarea class="form-control" id="bestPerson" name="bestPerson" rows="3"
                            maxlength="400"><?= htmlspecialchars($form_data['founder_strength'] ?? '') ?></textarea>
                    </div>

                    <div class="col-12">
                        <label for="goalNext6Months" class="form-label">Your business goal for the next 6 months? <sup
                                class="text-danger">*</sup></label>
                        <textarea class="form-control" id="goalNext6Months" name="goalNext6Months" rows="3"
                            maxlength="400"><?= htmlspecialchars($form_data['business_goals'] ?? '') ?></textarea>
                    </div>

                    <div class="col-12">
                        <label for="biggestChallenges" class="form-label">What are your biggest challenges? <sup
                                class="text-danger">*</sup></label>
                        <textarea class="form-control" id="biggestChallenges" name="biggestChallenges" rows="3"
                            maxlength="400"><?= htmlspecialchars($form_data['business_challenges'] ?? '') ?></textarea>
                    </div>

                    <div class="col-12">
                        <label for="supportNeeded" class="form-label">What kind of support do you need? <sup
                                class="text-danger">*</sup></label>
                        <textarea class="form-control" id="supportNeeded" name="supportNeeded" rows="3"
                            maxlength="400"><?= htmlspecialchars($form_data['business_support'] ?? '') ?></textarea>
                    </div>

                    <div class="col-12">
                        <label for="longInvolved" class="form-label">How long do you see yourself in this business? <sup
                                class="text-danger">*</sup></label>
                        <textarea class="form-control" id="longInvolved" name="longInvolved" rows="3"
                            maxlength="400"><?= htmlspecialchars($form_data['self_involvement_lifespan'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Other Team Member Information -->
            <div class="form-section-card">
                <h3>Other Team Member Information</h3>
                <div class="mb-3">
                    <label for="employedInBusiness" class="form-label">Are there other people employed in the business?
                        <sup class="text-danger">*</sup></label>
                    <select class="form-select" id="employedInBusiness" name="employedInBusiness">
                        <option value="" disabled selected>Select an option</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div id="employeeNumberSection" style="display: none">
                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <label for="howManyFullTime" class="form-label">How many full time employees?
                                <sup class="text-danger">*</sup></label>
                            <input type="number" class="form-control" id="howManyFullTime" name="howManyFullTime"
                                min="0"
                                value="<?= !empty($form_data['full_time_employee_count']) ? $form_data['full_time_employee_count'] : ''; ?>" />
                        </div>
                        <div class="col-md-6">
                            <label for="howManyPartTime" class="form-label">How many part time employees?
                                <sup class="text-danger">*</sup></label>
                            <input type="number" class="form-control" id="howManyPartTime" name="howManyPartTime"
                                min="0"
                                value="<?= !empty($form_data['part_time_employee_count']) ? $form_data['part_time_employee_count'] : ''; ?>" />
                        </div>
                    </div>
                </div>
                <div id="teamMembersContainer">
                    <!-- Dynamic team member fields will be added here -->
                </div>

                <button type="button" class="btn btn-secondary mt-3" id="addTeamMemberBtn" style="display: none">
                    Add Another Team Member
                </button>
            </div>

            <div class="d-flex justify-content-around gx-3">
                <span
                    class="btn btn-outline-secondary btn-lg col-md-5 col-4 d-flex justify-content-center align-items-center"
                    id="draft_submit">
                    Save as Draft
                </span>
                <button type="submit"
                    class="btn btn-primary btn-lg col-md-5 col-5 d-flex justify-content-center align-items-center"
                    id="submit_form">
                    Submit Application
                </button>

                <!-- <button type="reset" class="btn btn-outline-secondary btn-sm">
                    Reset Form
                    </button> -->
            </div>
        </div>
    </form>
</main>

<!-- Custom JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>

<script>
    // Declare the home URL in JS from PHP
    const homeUrl = "<?php echo site_url('/'); ?>";
    const baseUrl = "<?php echo base_url(); ?>";
    const application_id = "<?php echo $current_app_id ?>";
</script>

<script src="<?= base_url('assets/js/f4f_apply.js') ?>"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

<script>
    $(function () {
        let gender = <?= json_encode($form_data['gender'] ?? ''); ?>;
        if (gender) $("#gender").val(gender).trigger("change");

        let nyscCdsDay = <?= json_encode($form_data['nysc_cds_day'] ?? ''); ?>;
        if (nyscCdsDay) $("#nyscCdsDay").val(nyscCdsDay).trigger("change");

        let statePostedTo = <?= json_encode($form_data['posted_to'] ?? ''); ?>;
        if (statePostedTo) $("#statePostedTo").val(statePostedTo).trigger("change");

        let highestQualification = <?= json_encode($form_data['education_qualification'] ?? ''); ?>;
        if (highestQualification) $("#highestQualification").val(highestQualification).trigger("change");

        let higherInstitution = <?= json_encode($form_data['higher_institution'] ?? ''); ?>;
        if (higherInstitution) $("#higherInstitution").val(higherInstitution).trigger("change");

        let firstBusiness = <?= json_encode($form_data['is_first_business'] ?? ''); ?>;
        if (firstBusiness) $("#firstBusiness").val(firstBusiness).trigger("change");

        let howDidYouHear = <?= json_encode($form_data['referred_by'] ?? ''); ?>;
        if (howDidYouHear) $("#howDidYouHear").val(howDidYouHear).trigger("change");

        let attendedIncubation = <?= json_encode($form_data['attended_incubation'] ?? ''); ?>;
        if (attendedIncubation) $("#attendedIncubation").val(attendedIncubation).trigger("change");

        let businessLocation = <?= json_encode($form_data['business_location'] ?? ''); ?>;
        if (businessLocation) $("#businessLocation").val(businessLocation).trigger("change"); // FIXED ID

        let businessRegistered = <?= json_encode($form_data['is_business_registered'] ?? ''); ?>;
        if (businessRegistered) $("#businessRegistered").val(businessRegistered).trigger("change");

        let stageOfBusiness = <?= json_encode($form_data['business_stage'] ?? ''); ?>;
        if (stageOfBusiness) $("#stageOfBusiness").val(stageOfBusiness).trigger("change");

        let capitalFunding = <?= json_encode($form_data['has_revieved_funding'] ?? ''); ?>;
        if (capitalFunding) $("#capitalFunding").val(capitalFunding).trigger("change");

        let inPartnership = <?= json_encode($form_data['has_partners'] ?? ''); ?>;
        if (inPartnership) $("#inPartnership").val(inPartnership).trigger("change");

        let hasLoanOrDebt = <?= json_encode($form_data['has_liabilities'] ?? ''); ?>;
        if (hasLoanOrDebt) $("#hasLoanOrDebt").val(hasLoanOrDebt).trigger("change");

        let employedInBusiness = <?= json_encode($form_data['has_team_members'] ?? ''); ?>;
        if (employedInBusiness) $("#employedInBusiness").val(employedInBusiness).trigger("change");

        let agricField = <?= json_encode($form_data['agriculture_field'] ?? '') ?>;

        if (agricField) {
            $(`input[name="agricField"][value="${agricField}"]`).prop('checked', true);
        }

        let teamMembers = <?= json_encode($form_data['team_members'] ?? []) ?>;

       
        if (teamMembers && teamMembers.length > 0) {
            employedInBusinessSelect.value = "Yes";

            teamMembers.forEach((member, index) => {
                addTeamMemberSection(); // Call the function that creates a section
                const currentIndex = window.teamMemberCount;

                // Populate fields
                document.getElementById(`teamName${currentIndex}`).value = member.fullname ?? '';
                document.getElementById(`teamEmail${currentIndex}`).value = member.email ?? '';
                document.getElementById(`teamGender${currentIndex}`).value = member.gender ?? '';
                document.getElementById(`teamPhone${currentIndex}`).value = member.phone ?? '';
                document.getElementById(`teamLocation${currentIndex}`).value = member.location ?? '';
                document.getElementById(`teamStatus${currentIndex}`).value = member.status ?? '';
                document.getElementById(`teamNyscStateCodeSection${teamMemberCount}`).value = member.nysc_state_code ?? '';
                document.getElementById(`teamHighestQualification${currentIndex}`).value = member.education_qualification ?? '';
                document.getElementById(`teamHigherInstitution${currentIndex}`).value = member.higher_institution ?? '';
                document.getElementById(`teamCourseRead${currentIndex}`).value = member.course_of_study ?? '';
                document.getElementById(`teamRoleInBusiness${currentIndex}`).value = member.business_role ?? '';
                document.getElementById(`teamMemberQualification${currentIndex}`).value = member.qualification ?? '';
            });

            updateAddButtonVisibility();
        }
    });
</script>