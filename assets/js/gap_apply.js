// --- Dynamic Form Logic for GAP Application ---
window.teamMemberCount = 0;
const maxTeamMembers = 3;
const teamMembersContainer = document.getElementById("teamMembersContainer");
const addTeamMemberBtn = document.getElementById("addTeamMemberBtn");
const employedInBusinessSelect = document.getElementById("employedInBusiness");
const otherBusinessesSection = document.getElementById(
  "otherBusinessesSection"
);
const revenueSection = document.getElementById("revenueSection");
const stageOfBusinessSelect = document.getElementById("stageOfBusiness");
const inPartnershipSelect = document.getElementById("inPartnership");
const stakeInBusinessSection = document.getElementById(
  "stakeInBusinessSection"
);
const employeeNumberSection = document.getElementById("employeeNumberSection");
const today = new Date(); // Get today's date

window.addTeamMemberSection = addTeamMemberSection;
window.updateAddButtonVisibility = updateAddButtonVisibility;

document.addEventListener("DOMContentLoaded", function () {
  // Initialize Flatpickr for Date of Birth (Date Picker)
  const dobInput = document.querySelector("#dateOfBirth");
  if (dobInput) {
    // Calculate the maximum allowed date (13 years ago from today)
    const maxAllowedDate = new Date();
    maxAllowedDate.setFullYear(maxAllowedDate.getFullYear() - 13);

    flatpickr(dobInput, {
      altInput: true,
      disableMobile: true,
      altFormat: "F j, Y",
      dateFormat: "Y-m-d",
      maxDate: maxAllowedDate, // Set the maximum selectable date
    });
  }

  // Initialize Flatpickr for Year of Graduation (Month/Year Picker)
  const yearOfGraduationInput = document.querySelector("#yearOfGraduation");
  if (yearOfGraduationInput) {
    flatpickr(yearOfGraduationInput, {
      altInput: true,
      disableMobile: true,
      maxDate: "today",
      dateFormat: "Y", // Stored value (YYYY)
      altFormat: "Y", // Displayed value (YYYY)
      plugins: [
        new monthSelectPlugin({
          shorthand: true, // doesn't matter much here since only year is shown
          dateFormat: "Y",
          altFormat: "Y",
          theme: "material", // Optional: nice appearance
        }),
      ],
    });
  }

  // Initialize Flatpickr for When did you start your business? (MM/YY)
  const dateStartedInput = document.querySelector("#dateStarted");
  if (dateStartedInput) {
    flatpickr(dateStartedInput, {
      altInput: true,
      disableMobile: true,
      maxDate: today, // Set the maximum selectable date

      plugins: [
        new monthSelectPlugin({
          shorthand: false,
          dateFormat: "Y-m",
          altFormat: "F Y",
        }),
      ],
    });
  }

  // Initial check for "Is this your first business?" field visibility
  document
    .getElementById("firstBusiness")
    .addEventListener("change", function () {
      if (this.value === "No") {
        otherBusinessesSection.style.display = "block";
        otherBusinessesSection
          .querySelector("textarea")
          .setAttribute("", "false");
      } else {
        otherBusinessesSection.style.display = "none";
        otherBusinessesSection.querySelector("textarea").removeAttribute("");
      }
    });

  // Initial check for "If Post-Revenue, What is your revenue till date?" field visibility
  stageOfBusinessSelect.addEventListener("change", function () {
    if (this.value === "Post Revenue: We have started making Revenue") {
      revenueSection.style.display = "block";
      revenueSection.querySelector("input").setAttribute("", "false");
    } else {
      revenueSection.style.display = "none";
      revenueSection.querySelector("input").removeAttribute("");
    }
  });

  // Initial check for "If yes, what is your stake in the business?" field visibility
  inPartnershipSelect.addEventListener("change", function () {
    if (this.value === "Yes") {
      stakeInBusinessSection.style.display = "block";
      stakeInBusinessSection.querySelector("input").setAttribute("", "true");
    } else {
      stakeInBusinessSection.style.display = "none";
      stakeInBusinessSection.querySelector("input").removeAttribute("");
    }
  });

  // Event listener for "Are there other people employed in the business?"
  employedInBusinessSelect.addEventListener("change", function () {
    if (this.value === "Yes") {
      addTeamMemberBtn.style.display = "block";
      employeeNumberSection.style.display = "block";
      employeeNumberSection.querySelector("input").setAttribute("", "true");
      // If no team members are currently added, add one automatically
      if (teamMemberCount === 0) {
        addTeamMemberSection();
      }
    } else {
      addTeamMemberBtn.style.display = "none";
      employeeNumberSection.style.display = "none";
      employeeNumberSection.querySelector("input").removeAttribute("");

      // Remove all existing team member sections if "No" is selected
      teamMembersContainer.innerHTML = "";
      teamMemberCount = 0;
    }
  });

  // Event listener for "Add Another Team Member" button
  addTeamMemberBtn.addEventListener("click", addTeamMemberSection);
}); // End DOMContentLoaded

// Function to add a new team member section
function addTeamMemberSection() {
  if (teamMemberCount < maxTeamMembers) {
    teamMemberCount++;
    const newMemberDiv = document.createElement("div");
    newMemberDiv.classList.add("dynamic-team-member-section", "mt-3");
    newMemberDiv.innerHTML = `
            <h5>Team Member ${teamMemberCount}</h5>
            <button type="button" class="remove-btn">Remove</button>
            <div class="row g-3">
              <div class="col-md-6">
                <label for="teamName${teamMemberCount}" class="form-label">Name <sup class="text-danger">*</sup></label>
                <input type="text" class="form-control" id="teamName${teamMemberCount}" name="teamName${teamMemberCount}"  />
              </div>
              <div class="col-md-6">
                <label for="teamEmail${teamMemberCount}" class="form-label">Email Address <sup class="text-danger">*</sup></label>
                <input type="email" class="form-control" id="teamEmail${teamMemberCount}" name="teamEmail${teamMemberCount}"  />
              </div>
              <div class="col-md-6">
                <label for="teamGender${teamMemberCount}" class="form-label">Gender <sup class="text-danger">*</sup></label>
                <select class="form-select" id="teamGender${teamMemberCount}" name="teamGender${teamMemberCount}" >
                  <option value="" disabled selected>Select Gender</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="teamPhone${teamMemberCount}" class="form-label">Telephone Number <sup class="text-danger">*</sup></label>
                <input type="tel" class="form-control" id="teamPhone${teamMemberCount}" name="teamPhone${teamMemberCount}"  pattern="0[7-9][0-1][0-9]{8}"
  maxlength="11"
  inputmode="numeric"
  oninput="this.value = this.value.replace(/[^0-9]/g, '');"  />
              </div>
              <div class="col-md-6">
                <label for="teamLocation${teamMemberCount}" class="form-label">Current Location (State) <sup class="text-danger">*</sup></label>
                <select class="form-select" id="teamLocation${teamMemberCount}" name="teamLocation${teamMemberCount}" >
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
                <label for="teamStatus${teamMemberCount}" class="form-label">Status <sup class="text-danger">*</sup></label>
                <select class="form-select" id="teamStatus${teamMemberCount}" name="teamStatus${teamMemberCount}" >
                  <option value="" disabled selected>Select Status</option>
                  <option value="Student">Student</option>
                  <option value="Graduate (Yet to Serve)">Graduate (Yet to Serve)</option>
                  <option value="NYSC (Currently Serving)">NYSC (Currently Serving)</option>
                  <option value="Completed NYSC">Completed NYSC</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="teamHighestQualification${teamMemberCount}" class="form-label">Highest Educational Qualification <sup class="text-danger">*</sup></label>
                <select class="form-select" id="teamHighestQualification${teamMemberCount}" name="teamHighestQualification${teamMemberCount}" >
                  <option value="" disabled selected>Select Qualification</option>
                  <option value="OND">OND</option>
                  <option value="HND">HND</option>
                  <option value="BSc">BSc</option>
                  <option value="Masters">Masters</option>
                  <option value="PhD">PhD</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="teamHigherInstitution${teamMemberCount}" class="form-label">Higher Institution Attended <sup class="text-danger">*</sup></label>
                <select class="form-select" id="teamHigherInstitution${teamMemberCount}" name="teamHigherInstitution${teamMemberCount}" >
                  <option value="" disabled selected>Select Institution</option>
                  <option value="Ahmadu Bello University">Ahmadu Bello University</option>
                  <option value="Federal University of Agriculture, Abeokuta (FUNAAB)">Federal University of Agriculture, Abeokuta (FUNAAB)</option>
                  <option value="Michael Okpara University of Agriculture, Umudike">Michael Okpara University of Agriculture, Umudike</option>

                  <option value="Obafemi Awolowo University">Obafemi Awolowo University</option>

                  <option value="University of Ibadan">University of Ibadan</option>
                  <option value="University of Ilorin">University of Ilorin</option>

                  <option value="University of Lagos">University of Lagos</option>
                  <option value="University of Nigeria, Nsukka">University of Nigeria, Nsukka</option>
                  <option value="Other">Other (Please specify in Course Read)</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="teamCourseRead${teamMemberCount}" class="form-label">Course Read <sup class="text-danger">*</sup></label>
                <input type="text" class="form-control" id="teamCourseRead${teamMemberCount}" name="teamCourseRead${teamMemberCount}" />
              </div>
              <div class="col-12">
                <label for="teamRoleInBusiness${teamMemberCount}" class="form-label">Role in the Business <sup class="text-danger">*</sup></label>
                <input type="text" class="form-control" id="teamRoleInBusiness${teamMemberCount}" name="teamRoleInBusiness${teamMemberCount}" />
              </div>
              <div class="col-12">
                <label for="teamMemberQualification${teamMemberCount}" class="form-label">How/why is this team member qualified for the role he plays in the business? <sup class="text-danger">*</sup></label>
                <textarea class="form-control" id="teamMemberQualification${teamMemberCount}" name="teamMemberQualification${teamMemberCount}" rows="3" ></textarea>
              </div>
            </div>
           
            </div>
          `;
    teamMembersContainer.appendChild(newMemberDiv);

    // Add event listener to the newly created remove button
    newMemberDiv
      .querySelector(".remove-btn")
      .addEventListener("click", function () {
        newMemberDiv.remove();
        teamMemberCount--;
        updateAddButtonVisibility();
      });

    updateAddButtonVisibility();
  }
}

// Function to control the visibility of the "Add Another Team Member" button
function updateAddButtonVisibility() {
  if (
    employedInBusinessSelect.value === "Yes" &&
    teamMemberCount < maxTeamMembers
  ) {
    addTeamMemberBtn.style.display = "block";
  } else {
    addTeamMemberBtn.style.display = "none";
  }
}

// Custom Alert Modal Functions
function showCustomAlert(message, isSuccess = true) {
  const alertModal = document.getElementById("customAlertModal");
  const alertMessage = document.getElementById("customAlertMessage");
  const alertHeader = document.getElementById("customAlertHeader");

  alertMessage.textContent = message;

  if (isSuccess) {
    alertHeader.textContent = "Success!";
    alertHeader.style.backgroundColor = "#28a745"; // Green for success
  } else {
    alertHeader.textContent = "Error!";
    alertHeader.style.backgroundColor = "#dc3545"; // Red for error
  }

  const modal = new bootstrap.Modal(alertModal);
  modal.show();
}

// Form submission handling
document
  .getElementById("gapApplicationForm")
  .addEventListener("submit", async function (event) {
    event.preventDefault(); // Prevent actual form submission

    const button = document.getElementById("submit_form"); // or event.currentTarget

    button.disabled = true;
    const originalContent = button.innerHTML;
    button.innerHTML =
      '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Submitting...';

    const originalFormData = new FormData(event.target);
    const data = {};

    // Helper to format month-year to YYYY-MM-DD (first day of month)
    const formatMonthYearToYYYYMMDD = (monthYear) => {
      if (!monthYear) return "";
      // MonthYear format from flatpickr monthSelect is YYYY-MM
      const [year, month] = monthYear.split("-");
      if (year && month) {
        return `${year}-${month}-01`;
      }
      return "";
    };

    // Helper to format year only
    const formatYear = (year) => {
      if (!year) return "";
      // If year comes as YYYY-MM from monthSelectPlugin, extract only YYYY
      return year.split("-")[0];
    };

    data.application = {
      submission_status: "completed",
      application_id: `${application_id}`,
    };

    const dob = originalFormData.get("dateOfBirth");
    const yearOfGraduation = formatYear(
      originalFormData.get("yearOfGraduation")
    );

    // Team Lead Information
    data.team_lead = {
      firstname: originalFormData.get("firstName"),
      lastname: originalFormData.get("lastName"),
      email: originalFormData.get("emailAddress"),
      phone: originalFormData.get("mobileNumber"),
      gender: originalFormData.get("gender"),
      date_of_birth: dob && dob.trim() !== "" ? dob : null,
      education_qualification: originalFormData.get("highestQualification"),
      higher_institution: originalFormData.get("higherInstitution"),
      course_of_study: originalFormData.get("courseRead"),
      faculty: originalFormData.get("faculty"),
      department: originalFormData.get("department"),
      graduation_year:
        yearOfGraduation && yearOfGraduation.trim() !== ""
          ? yearOfGraduation
          : null, // Extract only year
      business_role: originalFormData.get("yourRole"), // Mapped from 'yourRole'
      is_first_business: originalFormData.get("firstBusiness"),
      other_business_description:
        originalFormData.get("firstBusiness") === "No"
          ? originalFormData.get("otherBusinesses")
          : "",
      facebook_url: originalFormData.get("facebookLink"),
      twitter_handle: originalFormData.get("twitterHandle"),
      instagram_handle: originalFormData.get("instagramHandle"),
      linkedIn_url: originalFormData.get("linkedinProfile"),
      referred_by: originalFormData.get("howDidYouHear"), // This field might need clarification if "referred_by" expects different values
      attended_incubation: originalFormData.get("attendedIncubation"),
      has_team_members: originalFormData.get("employedInBusiness"),
      full_time_employee_count:
        originalFormData.get("employedInBusiness") === "Yes"
          ? parseInt(originalFormData.get("howManyFullTime")) || 0
          : 0,
      part_time_employee_count:
        originalFormData.get("employedInBusiness") === "Yes"
          ? parseInt(originalFormData.get("howManyPartTime")) || 0
          : 0,
    };

    // Business Information
    data.business = {
      business_name: originalFormData.get("businessName"),
      business_location: originalFormData.get("businessLocation"),
      business_website: originalFormData.get("businessWebsite"),
      agriculture_field: originalFormData.get("agricField"),
      is_business_registered: originalFormData.get("businessRegistered"),
      business_start_date: formatMonthYearToYYYYMMDD(
        originalFormData.get("dateStarted")
      ), // Convert MM/YY to YYYY-MM-DD
      business_stage: originalFormData.get("stageOfBusiness"),
      revenue_till_date: originalFormData.get("revenueToDate")
        ? parseInt(originalFormData.get("revenueToDate"))
        : 0,
      business_achievements: originalFormData.get("achievements"),
      has_received_funding: originalFormData.get("capitalFunding"),
      has_partners: originalFormData.get("inPartnership"),
      stake_in_business:
        originalFormData.get("inPartnership") === "Yes"
          ? parseInt(originalFormData.get("stakeInBusiness")) || 0
          : 0,
      has_liabilities: originalFormData.get("hasLoanOrDebt"),
      problem_to_solve: originalFormData.get("problemSolving"),
      business_solution: originalFormData.get("describeSolution"),
      business_offerings: originalFormData.get("productServiceOffering"),
      target_market: originalFormData.get("targetMarket"),
      monetization_strategy: originalFormData.get("howMakeMoney"),
      market_validation: originalFormData.get("proofOfPayment"),
      business_competitors: originalFormData.get("competitors"),
      business_uniqueness: originalFormData.get("productUnique"),
      competitive_advantage: originalFormData.get("planToOutdoCompetition"),
      business_motivation: originalFormData.get("motivation"),
      business_vision: originalFormData.get("longTermVision"),
      founder_strength: originalFormData.get("bestPerson"),
      business_goals: originalFormData.get("goalNext6Months"),
      business_challenges: originalFormData.get("biggestChallenges"),
      business_support: originalFormData.get("supportNeeded"),
      self_involvement_lifespan: originalFormData.get("longInvolved"),
    };

    // Team Members Information
    data.team_members = [];
    const employedInBusinessSelect =
      document.getElementById("employedInBusiness"); // Get the select element
    const teamMembersContainer = document.getElementById(
      "teamMembersContainer"
    ); // Get the container for dynamic team members

    if (employedInBusinessSelect.value === "Yes") {
      // Loop through the actual number of dynamic team member sections
      const dynamicTeamMemberSections = teamMembersContainer.querySelectorAll(
        ".dynamic-team-member-section"
      );
      dynamicTeamMemberSections.forEach((section, index) => {
        const i = index + 1; // Get the current index for form field names
        data.team_members.push({
          fullname: originalFormData.get(`teamName${i}`),
          email: originalFormData.get(`teamEmail${i}`),
          gender: originalFormData.get(`teamGender${i}`),
          phone: originalFormData.get(`teamPhone${i}`),
          location: originalFormData.get(`teamLocation${i}`),
          status: originalFormData.get(`teamStatus${i}`),
          education_qualification: originalFormData.get(
            `teamHighestQualification${i}`
          ),
          higher_institution: originalFormData.get(`teamHigherInstitution${i}`),
          course_of_study: originalFormData.get(`teamCourseRead${i}`),
          business_role: originalFormData.get(`teamRoleInBusiness${i}`),
          qualification: originalFormData.get(`teamMemberQualification${i}`),
        });
      });
    }

    console.log(
      "Form Data to be Sent (Payload):",
      JSON.stringify(data, null, 2)
    );

    // Create a new FormData object for the multipart/form-data submission
    const submitFormData = new FormData();

    // Append the file
    const schoolCertificateInput = document.getElementById("schoolCertificate");
    if (schoolCertificateInput.files.length > 0) {
      submitFormData.append("image", schoolCertificateInput.files[0]);
    }

    // Append the JSON payload
    submitFormData.append("payload", JSON.stringify(data));
    console.log("Form Data with File and Payload:", submitFormData);

    try {
      const response = await fetch(
        `${baseUrl}/api/gap-applications/new/completed`, // Updated endpoint
        {
          method: "POST",
          headers: {
            "API-key": "d84f2a9e7c4b5e1a3f2d7e4b6c8a9012", // Keep the API key
            // Do NOT set 'Content-Type': 'application/json' when sending FormData,
            // the browser will set the correct 'Content-Type' header with the boundary.
          },
          body: submitFormData, // Use the new FormData object with file and payload
        }
      );

      if (response.ok) {
        button.disabled = false;
        button.innerHTML = originalContent;
        Swal.fire({
          title: "Application saved succesfully",
          icon: "success",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = `${baseUrl}/index`;
          }
        });
      } else {
        const errorData = await response.json();
        console.error("Submission Error:", errorData);
        button.disabled = false;
        button.innerHTML = originalContent;

        if (errorData.error === "This application has ended") {
          Swal.fire({
            title: "Application Closed",
            text: "This application is no longer accepting submissions.",
            icon: "error",
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = `${baseUrl}/index`;
            }
          });
          return; // Prevent the generic error modal below from also showing
        }

        Swal.fire({
          title: "An Error occured",
          text: `${errorData.error || response.statusText}`,
          icon: "error",
        });
      }
    } catch (error) {
      console.error("Network or Submission Error:", error);
      button.disabled = false;
      button.innerHTML = originalContent;
      Swal.fire({
        title: "An Error occured",
        text: "An error occurred during submission. Please try again.",
        icon: "error",
      });
    }
  });

// Draft Submission
document
  .getElementById("draft_submit")
  .addEventListener("click", async function (event) {
    event.preventDefault(); // Prevent actual form submission
    const button = event.target; // or event.currentTarget

    button.disabled = true;
    const originalContent = button.innerHTML;
    button.innerHTML =
      '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Submitting...';

    const formElement = document.getElementById("gapApplicationForm"); // Get the form element
    const originalFormData = new FormData(formElement);
    const data = {};

    // Helper to format month-year to YYYY-MM-DD (first day of month)
    const formatMonthYearToYYYYMMDD = (monthYear) => {
      if (!monthYear) return "";
      // MonthYear format from flatpickr monthSelect is YYYY-MM
      const [year, month] = monthYear.split("-");
      if (year && month) {
        return `${year}-${month}-01`;
      }
      return "";
    };

    // Helper to format year only
    const formatYear = (year) => {
      if (!year) return "";
      // If year comes as YYYY-MM from monthSelectPlugin, extract only YYYY
      return year;
    };

    data.application = {
      submission_status: "draft",
      application_id: `${application_id}`,
    };

    const dob = originalFormData.get("dateOfBirth");
    const yearOfGraduation = formatYear(
      originalFormData.get("yearOfGraduation")
    );

    // Team Lead Information
    data.team_lead = {
      firstname: originalFormData.get("firstName"),
      lastname: originalFormData.get("lastName"),
      email: originalFormData.get("emailAddress"),
      phone: originalFormData.get("mobileNumber"),
      gender: originalFormData.get("gender"),
      date_of_birth: dob && dob.trim() !== "" ? dob : null,
      education_qualification: originalFormData.get("highestQualification"),
      higher_institution: originalFormData.get("higherInstitution"),
      course_of_study: originalFormData.get("courseRead"),
      faculty: originalFormData.get("faculty"),
      department: originalFormData.get("department"),
      graduation_year:
        yearOfGraduation && yearOfGraduation.trim() !== ""
          ? yearOfGraduation
          : null,
      business_role: originalFormData.get("yourRole"), // Mapped from 'yourRole'
      is_first_business: originalFormData.get("firstBusiness"),
      other_business_description:
        originalFormData.get("firstBusiness") === "No"
          ? originalFormData.get("otherBusinesses")
          : "",
      facebook_url: originalFormData.get("facebookLink"),
      twitter_handle: originalFormData.get("twitterHandle"),
      instagram_handle: originalFormData.get("instagramHandle"),
      linkedIn_url: originalFormData.get("linkedinProfile"),
      referred_by: originalFormData.get("howDidYouHear"), // This field might need clarification if "referred_by" expects different values
      attended_incubation: originalFormData.get("attendedIncubation"),
      has_team_members: originalFormData.get("employedInBusiness"),
      full_time_employee_count:
        originalFormData.get("employedInBusiness") === "Yes"
          ? parseInt(originalFormData.get("howManyFullTime")) || 0
          : 0,
      part_time_employee_count:
        originalFormData.get("employedInBusiness") === "Yes"
          ? parseInt(originalFormData.get("howManyPartTime")) || 0
          : 0,
    };

    // Business Information
    data.business = {
      business_name: originalFormData.get("businessName"),
      business_location: originalFormData.get("businessLocation"),
      business_website: originalFormData.get("businessWebsite"),
      agriculture_field: originalFormData.get("agricField"),
      is_business_registered: originalFormData.get("businessRegistered"),
      business_start_date: formatMonthYearToYYYYMMDD(
        originalFormData.get("dateStarted")
      ), // Convert MM/YY to YYYY-MM-DD
      business_stage: originalFormData.get("stageOfBusiness"),
      revenue_till_date: originalFormData.get("revenueToDate")
        ? parseInt(originalFormData.get("revenueToDate"))
        : 0,
      business_achievements: originalFormData.get("achievements"),
      has_received_funding: originalFormData.get("capitalFunding"),
      has_partners: originalFormData.get("inPartnership"),
      stake_in_business:
        originalFormData.get("inPartnership") === "Yes"
          ? parseInt(originalFormData.get("stakeInBusiness")) || 0
          : 0,
      has_liabilities: originalFormData.get("hasLoanOrDebt"),
      problem_to_solve: originalFormData.get("problemSolving"),
      business_solution: originalFormData.get("describeSolution"),
      business_offerings: originalFormData.get("productServiceOffering"),
      target_market: originalFormData.get("targetMarket"),
      monetization_strategy: originalFormData.get("howMakeMoney"),
      market_validation: originalFormData.get("proofOfPayment"),
      business_competitors: originalFormData.get("competitors"),
      business_uniqueness: originalFormData.get("productUnique"),
      competitive_advantage: originalFormData.get("planToOutdoCompetition"),
      business_motivation: originalFormData.get("motivation"),
      business_vision: originalFormData.get("longTermVision"),
      founder_strength: originalFormData.get("bestPerson"),
      business_goals: originalFormData.get("goalNext6Months"),
      business_challenges: originalFormData.get("biggestChallenges"),
      business_support: originalFormData.get("supportNeeded"),
      self_involvement_lifespan: originalFormData.get("longInvolved"),
    };

    // Team Members Information
    data.team_members = [];
    const employedInBusinessSelect =
      document.getElementById("employedInBusiness"); // Get the select element
    const teamMembersContainer = document.getElementById(
      "teamMembersContainer"
    ); // Get the container for dynamic team members

    if (employedInBusinessSelect.value === "Yes") {
      // Loop through the actual number of dynamic team member sections
      const dynamicTeamMemberSections = teamMembersContainer.querySelectorAll(
        ".dynamic-team-member-section"
      );
      dynamicTeamMemberSections.forEach((section, index) => {
        const i = index + 1; // Get the current index for form field names
        data.team_members.push({
          fullname: originalFormData.get(`teamName${i}`),
          email: originalFormData.get(`teamEmail${i}`),
          gender: originalFormData.get(`teamGender${i}`),
          phone: originalFormData.get(`teamPhone${i}`),
          location: originalFormData.get(`teamLocation${i}`),
          status: originalFormData.get(`teamStatus${i}`),
          education_qualification: originalFormData.get(
            `teamHighestQualification${i}`
          ),
          higher_institution: originalFormData.get(`teamHigherInstitution${i}`),
          course_of_study: originalFormData.get(`teamCourseRead${i}`),
          business_role: originalFormData.get(`teamRoleInBusiness${i}`),
          qualification: originalFormData.get(`teamMemberQualification${i}`),
        });
      });
    }

    console.log(
      "Form Data to be Sent (Payload):",
      JSON.stringify(data, null, 2)
    );

    // Create a new FormData object for the multipart/form-data submission
    const submitFormData = new FormData();

    // Append the file
    const schoolCertificateInput = document.getElementById("schoolCertificate");
    if (schoolCertificateInput.files.length > 0) {
      submitFormData.append("image", schoolCertificateInput.files[0]);
    }

    // Append the JSON payload
    submitFormData.append("payload", JSON.stringify(data));
    console.log("Form Data with File and Payload:", submitFormData);

    try {
      const response = await fetch(
        `${baseUrl}/api/gap-applications/new/draft`, // Updated endpoint
        {
          method: "POST",
          headers: {
            "API-key": "d84f2a9e7c4b5e1a3f2d7e4b6c8a9012", // Keep the API key
            // Do NOT set 'Content-Type': 'application/json' when sending FormData,
            // the browser will set the correct 'Content-Type' header with the boundary.
          },
          body: submitFormData, // Use the new FormData object with file and payload
        }
      );

      if (response.ok) {
        button.disabled = false;
        button.innerHTML = originalContent;
        Swal.fire({
          title: "Draft saved succesfully",
          icon: "success",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = `${baseUrl}/index`;
          }
        });
      } else {
        const errorData = await response.json();
        console.error("Submission Error:", errorData);
        button.disabled = false;
        button.innerHTML = originalContent;

        if (errorData.error === "This application has ended") {
          Swal.fire({
            title: "Application Closed",
            text: "This application is no longer accepting submissions.",
            icon: "error",
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = `${baseUrl}/index`;
            }
          });
          return; // Prevent the generic error modal below from also showing
        }

        Swal.fire({
          title: "An Error occured",
          text: `${errorData.error || response.statusText}`,
          icon: "error",
        });
      }
    } catch (error) {
      console.error("Network or Submission Error:", error);
      button.disabled = false;
      button.innerHTML = originalContent;

      Swal.fire({
        title: "An Error occured",
        text: "An error occurred during submission. Please try again.",
        icon: "error",
      });
    }
  });
