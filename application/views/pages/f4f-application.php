<link rel="stylesheet" href="<?= base_url('assets/css/f4f-application.css') ?>" />

<?php
if (empty($application)) {
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
        ">You have not submitted an application</p>
    </div>
    <?php
    return;
}
?>

<main class="page-container container">
    <?php
        if ($application['review_status'] === 'pending' && $is_ongoing) {
            ?>
            <div class="alert alert-info" role="alert">
                Please review your application details below.
                To make any changes, return to the application form by clicking on the edit application button, update the
                necessary fields, and resubmit your application.
            </div>
            <?php
        }
    ?>
    <!-- Page Header -->
    <div class="page-flex">
        <div class="page-header">
            <h1><?= ucfirst($application['firstname']) ?> <?= ucfirst($application['lastname']) ?>'s Application
                <?php
                if ($application['submission_status'] === 'draft') {
                    ?>
                    <span class="status-badge status-draft">Draft</span>
                    <?php
                } else {
                    ?>
                    <span class="status-badge status-approved">Completed</span>
                    <?php
                }
                ?>
                <?php
                if ($application['review_status'] === 'pending') {
                    ?>
                    <span class="status-badge status-pending">Pending Review</span>
                    <?php
                } else {
                    ?>
                    <span class="status-badge status-approved">Reviewed</span>
                    <?php
                }
                ?>
            </h1>
            <div class="subtitle">
                Application ID: #<?= $application['app_id'] ?> • Submitted on
                <?= date('d M Y', strtotime($application['created_at'])) ?> • F4F Agriculture Program
            </div>
        </div>

        <?php
        if ($application['review_status'] === 'pending' && $is_ongoing) {
            ?>
            <div class="page-actions">
                <a href="<?= site_url('f4f-apply') ?>" class="btn btn-primary">Edit Application</a>
            </div>
            <?php
        }
        ?>


    </div>


    <!-- Main Content Grid -->
    <div class="sections-grid">
        <!-- Personal Information -->
        <div class="section-card personal-section">
            <div class="section-header">Personal Information</div>
            <div class="section-body">
                <div class="info-row">
                    <div class="info-label">Full Name</div>
                    <div class="info-value"><?= ucfirst($application['firstname']) ?>
                        <?= ucfirst($application['lastname']) ?>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email</div>
                    <div class="info-value"><a
                            href="mailto:<?= $application['email'] ?>"><?= $application['email'] ?></a></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Phone</div>
                    <div class="info-value"><?= $application['phone'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Gender</div>
                    <div class="info-value"><?= $application['gender'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Date of Birth</div>
                    <div class="info-value"><?= date('d M Y', strtotime($application['date_of_birth'])) ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Education</div>
                    <div class="info-value"><?= $application['education_qualification'] ?>
                        <?= $application['course_of_study'] ?>, <?= $application['higher_institution'] ?>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Business Role</div>
                    <div class="info-value"><?= $application['business_role'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Referred By</div>
                    <div class="info-value"><?= $application['referred_by'] ?></div>
                </div>
            </div>
        </div>

        <!-- NYSC Information -->
        <div class="section-card nysc-section">
            <div class="section-header">NYSC Information</div>
            <div class="section-body">
                <div class="info-row">
                    <div class="info-label">Batch</div>
                    <div class="info-value"><?= $application['nysc_batch'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Call-up Number</div>
                    <div class="info-value"><?= $application['nysc_callup_number'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">CDS Day</div>
                    <div class="info-value"><?= $application['nysc_cds_day'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Posted To</div>
                    <div class="info-value"><?= $application['posted_to'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">State Code</div>
                    <div class="info-value"><?= $application['nysc_state_code'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Attended Incubation?</div>
                    <div class="info-value"><?= $application['attended_incubation'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">First Business?</div>
                    <div class="info-value"><?= $application['is_first_business'] ?></div>
                </div>
                <?php
                if ($application['is_first_business'] === 'No') {
                    ?>
                    <div class="info-row">
                        <div class="info-label">Previous Business</div>
                        <div class="info-value"><?= $application['other_business_description'] ?></div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Business Information - Full Width -->
    <div class="section-card business-section full-width">
        <div class="section-header">Business Information</div>
        <div class="section-body">
            <div class="sections-grid">
                <div>
                    <div class="info-row">
                        <div class="info-label">Business Name</div>
                        <div class="info-value"><?= $application['business_name'] ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Location</div>
                        <div class="info-value"><?= $application['business_location'] ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Website</div>
                        <div class="info-value"><a href="<?= $application['business_website'] ?>"
                                target="_blank"><?= $application['business_website'] ?></a></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Agriculture Field</div>
                        <div class="info-value"><?= $application['agriculture_field'] ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Registered</div>
                        <div class="info-value"><?= $application['is_business_registered'] ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Start Date</div>
                        <div class="info-value"><?= date('M Y', strtotime($application['business_start_date'])) ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Stage</div>
                        <div class="info-value"><?= $application['business_stage'] ?></div>
                    </div>
                </div>
                <div>
                    <div class="info-row">
                        <div class="info-label">Revenue</div>
                        <div class="info-value"><?= $application['revenue_till_date'] ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Have Team Members?</div>
                        <div class="info-value"><?= $application['has_team_members'] ?> </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Employees</div>
                        <div class="info-value"><?= $application['full_time_employee_count'] ?> Full-time,
                            <?= $application['part_time_employee_count'] ?> Part-time
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Have Funding?</div>
                        <div class="info-value"><?= $application['has_received_funding'] ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Have Partners?</div>
                        <div class="info-value"><?= $application['has_partners'] ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Stake in Business (%)</div>
                        <div class="info-value"><?= $application['stake_in_business'] ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Have Liabilities? (Debt or Loan) </div>
                        <div class="info-value"><?= $application['has_liabilities'] ?></div>
                    </div>
                </div>
            </div>

            <!-- Long text fields -->
            <div class="long-text">
                <div class="info-row">
                    <div class="info-label">Market Validation</div>
                    <div class="info-value"><?= $application['market_validation'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Target Market</div>
                    <div class="info-value"><?= $application['target_market'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Competitors</div>
                    <div class="info-value"><?= $application['business_competitors'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Problem to Solve</div>
                    <div class="info-value"><?= $application['problem_to_solve'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Business Solution</div>
                    <div class="info-value"><?= $application['business_solution'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Business Motivation</div>
                    <div class="info-value"><?= $application['business_motivation'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Business Vision</div>
                    <div class="info-value"><?= $application['business_vision'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Monetization Strategy</div>
                    <div class="info-value"><?= $application['monetization_strategy'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Business Goals (6 months)</div>
                    <div class="info-value"><?= $application['business_goals'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Business Offerings</div>
                    <div class="info-value"><?= $application['business_offerings'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Founder's Strength</div>
                    <div class="info-value"><?= $application['founder_strength'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Business Challenges</div>
                    <div class="info-value"><?= $application['business_challenges'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Competitive Advantage</div>
                    <div class="info-value"><?= $application['competitive_advantage'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Business Support</div>
                    <div class="info-value"><?= $application['business_support'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Self Involvement Lifespan</div>
                    <div class="info-value"><?= $application['self_involvement_lifespan'] ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Social Media - Full Width -->
    <div class="section-card social-section full-width">
        <div class="section-header">Social Media & Online Presence</div>
        <div class="section-body">
            <div class="sections-grid">
                <div class="info-row">
                    <div class="info-label">Facebook</div>
                    <div class="info-value"><a href="<?= $application['facebook_url'] ?>"
                            target="_blank"><?= $application['facebook_url'] ?></a></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Twitter</div>
                    <?php if (!empty($application['twitter_handle'])): ?>
                        <div class="info-value">
                            <a href="https://twitter.com/<?= htmlspecialchars($application['twitter_handle']) ?>"
                                target="_blank">
                                @<?= htmlspecialchars($application['twitter_handle']) ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="info-row">
                    <div class="info-label">Instagram</div>
                    <?php if (!empty($application['instagram_handle'])): ?>
                        <div class="info-value">
                            <a href="https://instagram.com/<?= htmlspecialchars($application['instagram_handle']) ?>"
                                target="_blank">
                                @<?= htmlspecialchars($application['instagram_handle']) ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="info-row">
                    <div class="info-label">LinkedIn</div>
                    <div class="info-value"><a href="<?= $application['linkedin_url'] ?>"
                            target="_blank"><?= $application['linkedin_url'] ?></a></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Members -->
    <div class="team-section">
        <div class="section-header">Team Members (<span
                class="team_count"><?= $application["team_members_count"] ?></span>)</div>
        <div class="team-grid"></div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

<script>
    const teamMembers = <?php echo json_encode($application['team_members']) ?>;


    $(document).ready(function () {
        
        if (teamMembers.length > 0) {
            $(".team_count").text(teamMembers.length);

            teamMembers.forEach((member) => {
                console.log("memebr", { member })
                // Generate initials for avatar
                const names = member.fullname.split(' ');
                const fname = names[0] ? names[0][0].toUpperCase() : '';
                const lname = names[1] ? names[1][0].toUpperCase() : '';
                const initials = fname + lname;

                const memberHTML = `
                        <div class="team-member">
                            <div class="member-header">
                                <div class="member-avatar">
                                    ${initials}
                                </div>
                                <div class="member-info">
                                    <h4>${member.fullname}</h4>
                                    <div class="member-role">${member.business_role}</div>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Email</div>
                                <div class="info-value"><a href="mailto:${member.email}">${member.email}</a></div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Gender</div>
                                <div class="info-value">${member.gender}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Phone</div>
                                <div class="info-value">${member.phone}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Status</div>
                                <div class="info-value">${member.status}</div>
                            </div>
                            ${member.nysc_state_code
                                ? `<div class="info-row">
                                        <div class="info-label">NYSC State Code</div>
                                        <div class="info-value">${member.nysc_state_code}</div>
                                    </div>`
                                : ""
                            }
                            <div class="info-row">
                                <div class="info-label">Location</div>
                                <div class="info-value">${member.location}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Education</div>
                                <div class="info-value">${member.education_qualification} ${member.course_of_study}, ${member.higher_institution}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Role in Business</div>
                                <div class="info-value">${member.business_role}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Qualifications</div>
                                <div class="info-value">${member.qualification}</div>
                            </div>
                        </div>
                    `;

                $(".team-grid").append(memberHTML);
            });
        } else {
            const noMemberHTML = `
                    <div>
                        <p class="text-muted">No details provided for members</p>
                    </div>
                `

            $(".team-grid").append(noMemberHTML);
        }
    })
</script>