// --- Dynamic Form Logic for F4F Application ---
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
const today = new Date();

window.addTeamMemberSection = addTeamMemberSection;
window.updateAddButtonVisibility = updateAddButtonVisibility;

document.addEventListener("DOMContentLoaded", function () {
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

	const startInput = document.querySelector("#dateStarted");

	if (startInput) {
		flatpickr(startInput, {
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
});
// Show/hide "If No, describe other businesses" field
document
	.getElementById("firstBusiness")
	.addEventListener("change", function () {
		if (this.value === "No") {
			otherBusinessesSection.style.display = "block";
			otherBusinessesSection
				.querySelector("textarea")
				.setAttribute("", "true");
		} else {
			otherBusinessesSection.style.display = "none";
			otherBusinessesSection
				.querySelector("textarea")
				.removeAttribute("");
		}
	});

// Show/hide "If Post-Revenue, What is your revenue till date?" field
stageOfBusinessSelect.addEventListener("change", function () {
	if (this.value === "Post Revenue: We have started making Revenue") {
		revenueSection.style.display = "block";
		revenueSection.querySelector("input").setAttribute("", "true");
	} else {
		revenueSection.style.display = "none";
		revenueSection.querySelector("input").removeAttribute("");
	}
});

// Show/hide "If yes, what is your stake in the business?" field
inPartnershipSelect.addEventListener("change", function () {
	if (this.value === "Yes") {
		stakeInBusinessSection.style.display = "block";
		stakeInBusinessSection
			.querySelector("input")
			.setAttribute("", "true");
	} else {
		stakeInBusinessSection.style.display = "none";
		stakeInBusinessSection.querySelector("input").removeAttribute("");
	}
});

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
                <label for="teamPhone${teamMemberCount}" class="form-label">Telephone Number <sup class="text-danger">*</sup> </label>
                <input type="tel" class="form-control" id="teamPhone${teamMemberCount}" name="teamPhone${teamMemberCount}"  pattern="0[7-9][0-1][0-9]{8}"
  maxlength="11"
  inputmode="numeric"
  oninput="this.value = this.value.replace(/[^0-9]/g, '');"  />
              </div>
              <div class="col-md-6">
                <label for="teamLocation${teamMemberCount}" class="form-label">Current Location (State) <sup class="text-danger">*</sup></label>
                <select class="form-select" id="teamLocation${teamMemberCount}" name="teamLocation${teamMemberCount}" >
                  <option value="" disabled selected>Select State</option>
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
              <div class="col-md-6" id="teamNyscStateCodeSection${teamMemberCount}" style="display:none;">
                <label for="teamNyscStateCode${teamMemberCount}" class="form-label">If NYSC Member, State Code <sup class="text-danger">*</sup></label>
                <input type="text" class="form-control" id="teamNyscStateCode${teamMemberCount}" name="teamNyscStateCode${teamMemberCount}"  />
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
                <input type="text" class="form-control" id="teamCourseRead${teamMemberCount}" name="teamCourseRead${teamMemberCount}"  />
              </div>
              <div class="col-12">
                <label for="teamRoleInBusiness${teamMemberCount}" class="form-label">Role in the Business <sup class="text-danger">*</sup></label>
                <input type="text" class="form-control" id="teamRoleInBusiness${teamMemberCount}" name="teamRoleInBusiness${teamMemberCount}"  />
              </div>
              <div class="col-12">
                <label for="teamMemberQualification${teamMemberCount}" class="form-label">How/why is this team member qualified for the role he plays in the business? <sup class="text-danger">*</sup></label>
                <textarea class="form-control" id="teamMemberQualification${teamMemberCount}" name="teamMemberQualification${teamMemberCount}" rows="3" ></textarea>
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

		// Add event listener for NYSC Status
		document
			.getElementById(`teamStatus${teamMemberCount}`)
			.addEventListener("change", function () {
				const nyscStateCodeSection = document.getElementById(
					`teamNyscStateCodeSection${this.id.match(/\d+/)[0]}`
				);
				if (this.value === "NYSC (Currently Serving)") {
					nyscStateCodeSection.style.display = "block";
				} else {
					nyscStateCodeSection.style.display = "none";
				}
			});

		updateAddButtonVisibility();
	}
}

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

employedInBusinessSelect.addEventListener("change", function () {
	if (this.value === "Yes") {
		addTeamMemberBtn.style.display = "block";
		employeeNumberSection.style.display = "block"; // Hide general employee count if team members are added
		employeeNumberSection
			.querySelector("#howManyFullTime")
			.setAttribute("", "false");
		employeeNumberSection
			.querySelector("#howManyPartTime")
			.setAttribute("", "false");
		// If no team members are currently added, add one automatically
		if (teamMemberCount === 0) {
			addTeamMemberSection();
		}
	} else {
		addTeamMemberBtn.style.display = "none";
		employeeNumberSection.style.display = "none"; // Show general employee count if no team members

		employeeNumberSection
			.querySelector("#howManyFullTime")
			.removeAttribute("");
		employeeNumberSection
			.querySelector("#howManyPartTime")
			.removeAttribute("");
		// Remove all existing team member sections
		teamMembersContainer.innerHTML = "";
		teamMemberCount = 0;
	}
});

addTeamMemberBtn.addEventListener("click", addTeamMemberSection);

// Form submission handling
document
	.getElementById("f4fApplicationForm")
	.addEventListener("submit", async function (event) {
		event.preventDefault(); // Prevent actual form submission

		const button = document.getElementById("submit_form"); // or event.currentTarget

		button.disabled = true;
		const originalContent = button.innerHTML;
		button.innerHTML =
			'<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Submitting...';

		const formData = new FormData(event.target);
		const data = {};

		data.application = {
			submission_status: "completed",
			application_id: application_id,
		};

		// Team Lead Information
		data.team_lead = {
			firstname: formData.get("firstName"),
			lastname: formData.get("lastName"),
			email: formData.get("emailAddress"),
			phone: formData.get("mobileNumber"),
			gender: formData.get("gender"),
			date_of_birth: formData.get("dateOfBirth"),
			nysc_batch: formData.get("nyscBatch"),
			nysc_callup_number: formData.get("nyscCallUpNo"),
			nysc_cds_day: formData.get("nyscCdsDay"),
			posted_to: formData.get("statePostedTo"),
			nysc_state_code: formData.get("stateCode"),
			education_qualification: formData.get("highestQualification"),
			higher_institution: formData.get("higherInstitution"),
			course_of_study: formData.get("courseRead"),
			business_role: formData.get("yourRole"),
			is_first_business: formData.get("firstBusiness"),
			other_business_description:
				formData.get("firstBusiness") === "No"
					? formData.get("otherBusinesses")
					: "",
			facebook_url: formData.get("facebookLink"),
			twitter_handle: formData.get("twitterHandle"),
			instagram_handle: formData.get("instagramHandle"),
			linkedIn_url: formData.get("linkedinProfile"),
			referred_by: formData.get("howDidYouHear"),
			attended_incubation: formData.get("attendedIncubation"),
			has_team_members: formData.get("employedInBusiness"),
			full_time_employee_count:
				formData.get("employedInBusiness") === "Yes"
					? parseInt(formData.get("howManyFullTime"))
					: 0,
			part_time_employee_count:
				formData.get("employedInBusiness") === "Yes"
					? parseInt(formData.get("howManyPartTime"))
					: 0,
		};

		// Business Information
		data.business = {
			business_name: formData.get("businessName"),
			business_location: formData.get("businessLocation"),
			business_website: formData.get("businessWebsite"),
			agriculture_field: formData.get("agricField"),
			is_business_registered: formData.get("businessRegistered"),
			business_start_date: formData.get("dateStarted"),
			business_stage: formData.get("stageOfBusiness"),
			revenue_till_date: formData.get("revenueToDate"),
			business_achievements: formData.get("achievements"),
			has_received_funding: formData.get("capitalFunding"),
			has_partners: formData.get("inPartnership"),
			stake_in_business:
				formData.get("inPartnership") === "Yes"
					? parseInt(formData.get("stakeInBusiness"))
					: 0,
			has_liabilities: formData.get("hasLoanOrDebt"),
			problem_to_solve: formData.get("problemSolving"),
			business_solution: formData.get("describeSolution"),
			business_offerings: formData.get("productServiceOffering"),
			target_market: formData.get("targetMarket"),
			monetization_strategy: formData.get("howMakeMoney"),
			market_validation: formData.get("proofOfPayment"),
			business_competitors: formData.get("competitors"),
			business_uniqueness: formData.get("productUnique"),
			competitive_advantage: formData.get("planToOutdoCompetition"),
			business_motivation: formData.get("motivation"),
			business_vision: formData.get("longTermVision"),
			founder_strength: formData.get("bestPerson"),
			business_goals: formData.get("goalNext6Months"),
			business_challenges: formData.get("biggestChallenges"),
			business_support: formData.get("supportNeeded"),
			self_involvement_lifespan: formData.get("longInvolved"),
		};

		// Team Members Information
		data.team_members = [];
		if (employedInBusinessSelect.value === "Yes") {
			for (let i = 1; i <= teamMemberCount; i++) {
				data.team_members.push({
					fullname: formData.get(`teamName${i}`),
					email: formData.get(`teamEmail${i}`),
					gender: formData.get(`teamGender${i}`),
					phone: formData.get(`teamPhone${i}`),
					location: formData.get(`teamLocation${i}`),
					status: formData.get(`teamStatus${i}`),
					nysc_state_code: formData.get(`teamNyscStateCode${i}`), // Add NYSC state code for team members

					education_qualification: formData.get(`teamHighestQualification${i}`),
					higher_institution: formData.get(`teamHigherInstitution${i}`),
					course_of_study: formData.get(`teamCourseRead${i}`),
					business_role: formData.get(`teamRoleInBusiness${i}`),
					qualification: formData.get(`teamMemberQualification${i}`),
				});
			}
		}

		console.log("Form Data to be Sent:", JSON.stringify(data, null, 2));

		try {
			const response = await fetch(
				`${baseUrl}/api/f4f-applications/new/completed`,
				{
					method: "POST",
					headers: {
						"Content-Type": "application/json",
						"API-key": "d84f2a9e7c4b5e1a3f2d7e4b6c8a9012",
					},
					body: JSON.stringify(data),
				}
			);
			console.log({ response });
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

// Draft submission handling
document
	.getElementById("draft_submit")
	.addEventListener("click", async function (event) {
		event.preventDefault(); // Prevent actual form submission
		const button = event.target; // or event.currentTarget

		button.disabled = true;
		const originalContent = button.innerHTML;
		button.innerHTML =
			'<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Submitting...';

		const formElement = document.getElementById("f4fApplicationForm"); // Get the form element

		const formData = new FormData(formElement);

		const data = {};

		data.application = {
			submission_status: "draft",
			application_id: application_id,
		};

		// Team Lead Information
		data.team_lead = {
			firstname: formData.get("firstName"),
			lastname: formData.get("lastName"),
			email: formData.get("emailAddress"),
			phone: formData.get("mobileNumber"),
			gender: formData.get("gender"),
			date_of_birth: formData.get("dateOfBirth"),
			nysc_batch: formData.get("nyscBatch"),
			nysc_callup_number: formData.get("nyscCallUpNo"),
			nysc_cds_day: formData.get("nyscCdsDay"),
			posted_to: formData.get("statePostedTo"),
			nysc_state_code: formData.get("stateCode"),
			education_qualification: formData.get("highestQualification"),
			higher_institution: formData.get("higherInstitution"),
			course_of_study: formData.get("courseRead"),
			business_role: formData.get("yourRole"),
			is_first_business: formData.get("firstBusiness"),
			other_business_description:
				formData.get("firstBusiness") === "No"
					? formData.get("otherBusinesses")
					: "",
			facebook_url: formData.get("facebookLink"),
			twitter_handle: formData.get("twitterHandle"),
			instagram_handle: formData.get("instagramHandle"),
			linkedIn_url: formData.get("linkedinProfile"),
			referred_by: formData.get("howDidYouHear"),
			attended_incubation: formData.get("attendedIncubation"),
			has_team_members: formData.get("employedInBusiness"),
			full_time_employee_count:
				formData.get("employedInBusiness") === "Yes"
					? parseInt(formData.get("howManyFullTime"))
					: 0,
			part_time_employee_count:
				formData.get("employedInBusiness") === "Yes"
					? parseInt(formData.get("howManyPartTime"))
					: 0,
		};

		// Business Information
		data.business = {
			business_name: formData.get("businessName"),
			business_location: formData.get("businessLocation"),
			business_website: formData.get("businessWebsite"),
			agriculture_field: formData.get("agricField"),
			is_business_registered: formData.get("businessRegistered"),
			business_start_date: formData.get("dateStarted"),
			business_stage: formData.get("stageOfBusiness"),
			revenue_till_date: formData.get("revenueToDate"),
			business_achievements: formData.get("achievements"),
			has_received_funding: formData.get("capitalFunding"),
			has_partners: formData.get("inPartnership"),
			stake_in_business:
				formData.get("inPartnership") === "Yes"
					? parseInt(formData.get("stakeInBusiness"))
					: 0,
			has_liabilities: formData.get("hasLoanOrDebt"),
			problem_to_solve: formData.get("problemSolving"),
			business_solution: formData.get("describeSolution"),
			business_offerings: formData.get("productServiceOffering"),
			target_market: formData.get("targetMarket"),
			monetization_strategy: formData.get("howMakeMoney"),
			market_validation: formData.get("proofOfPayment"),
			business_competitors: formData.get("competitors"),
			business_uniqueness: formData.get("productUnique"),
			competitive_advantage: formData.get("planToOutdoCompetition"),
			business_motivation: formData.get("motivation"),
			business_vision: formData.get("longTermVision"),
			founder_strength: formData.get("bestPerson"),
			business_goals: formData.get("goalNext6Months"),
			business_challenges: formData.get("biggestChallenges"),
			business_support: formData.get("supportNeeded"),
			self_involvement_lifespan: formData.get("longInvolved"),
		};

		// Team Members Information
		data.team_members = [];
		if (employedInBusinessSelect.value === "Yes") {
			for (let i = 1; i <= teamMemberCount; i++) {
				data.team_members.push({
					fullname: formData.get(`teamName${i}`),
					email: formData.get(`teamEmail${i}`),
					gender: formData.get(`teamGender${i}`),
					phone: formData.get(`teamPhone${i}`),
					location: formData.get(`teamLocation${i}`),
					status: formData.get(`teamStatus${i}`),
					nysc_state_code: formData.get(`teamNyscStateCode${i}`), // Add NYSC state code for team members

					education_qualification: formData.get(`teamHighestQualification${i}`),
					higher_institution: formData.get(`teamHigherInstitution${i}`),
					course_of_study: formData.get(`teamCourseRead${i}`),
					business_role: formData.get(`teamRoleInBusiness${i}`),
					qualification: formData.get(`teamMemberQualification${i}`),
				});
			}
		}

		console.log("Form Data to be Sent:", JSON.stringify(data, null, 2));

		try {
			const response = await fetch(
				`${baseUrl}/api/f4f-applications/new/draft`,
				{
					method: "POST",
					headers: {
						"Content-Type": "application/json",
						"API-key": "d84f2a9e7c4b5e1a3f2d7e4b6c8a9012",
					},
					body: JSON.stringify(data),
				}
			);
			console.log({ response });
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
