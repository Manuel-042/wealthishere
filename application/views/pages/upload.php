<style>
    .container {
        margin-top: 4rem;
    }

    form {
        display: flex;
        align-items: center;
        border: 1px solid #cccccc;
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
        border-top-right-radius: 20px !important;
        border-bottom-right-radius: 20px !important;
        padding-left: 10px;

        &>input {
            width: 80%;
        }

        &>button {
            border: 0 !important;
            border-radius: 0 !important;
            border-top-right-radius: 20px !important;
            border-bottom-right-radius: 20px !important;
            width: 20%;
        }
    }
</style>

<div class="container">
    <form id="mailForm">
        <input type="file" id="applications" name="file" placeholder="Upload File(s)"
            accept=".csv, .xls, .xlsx, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel"
            multiple />
        <button type="submit" id="uploadBtn" class="btn btn-primary">Upload</button>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

<script>
    const SEND_MAIL_URL = "<?= base_url('api/previous_applications') ?>";
    console.log("selectedValue", SEND_MAIL_URL);

    let selectedFiles = [];
    let readerPromises = [];
    let compiledApplications = [];
    let button;
    let originalContent;

    $("#applications").on("change", function (event) {
        selectedFiles = Array.from(event.target.files).slice(0, 4);
        console.log("Selected Files:", selectedFiles);
    });

    $('#mailForm').on('submit', function (e) {
        e.preventDefault();
        button = $("#uploadBtn");

        readerPromises = [];
        compiledApplications = [];

        button.prop("disabled", true);
        originalContent = button.html();
        button.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Uploading...');


        if (selectedFiles.length === 0) {
            alert("You must upload at least one file");
            return;
        } else if (selectedFiles.length > 8) {
            alert("Maximum File amount is 8 files");
            return;
        }

        $.each(selectedFiles, function (index, file) {
            readerPromises.push(readExcelFile(file));
        });

        $.when.apply($, readerPromises).done(async function (...allData) {
            console.log("All Excel Data:", allData);

            allData.forEach((filedata) => {
                //const targetIndexes = [165, 206, 241, 1795, 1940, 2407, 2490, 3629, 6579, 6602, 6664];
                //const selectedRows = filedata.filter((row, index) => targetIndexes.includes(index))
                const selectedRows = filedata.slice(1);

                selectedRows.forEach((row, index) => {
                    compiledApplications.push({
                        "application": {
                            "created_at": row[3] ?? row[48]
                        },
                        "team_lead": {
                            "firstname": row[4] ?? "",
                            "lastname": row[5] ?? "",
                            "email": isValidEmail(row[1]) ? row[1].trim() : `placeholder_${Math.random().toString(36).substring(2)}@invalid.com`,
                            'phone': row[7] ?? "",
                            'gender': row[8] ?? "",
                            'date_of_birth': row[9] ?? "",
                            'nysc_batch': row[10] ?? "",
                            'nysc_state_code': row[14] ?? "",
                            'nysc_cds_day': row[12] ?? "",
                            'nysc_callup_number': row[11] ?? "",
                            'posted_to': row[13] ?? "",
                            'education_qualification': row[15] ?? "",
                            'higher_institution': row[16] ?? "",
                            'course_of_study': row[17] ?? "",
                            'business_role': row[18] ?? "",
                            'is_first_business': "",
                            'other_business_description': "",
                            'facebook_url': row[19] ?? "",
                            'twitter_handle': row[20] ?? "",
                            'instagram_handle': row[21] ?? "",
                            'linkedIn_url': row[22] ?? "",
                            'referred_by': row[23] ?? "",
                            'attended_incubation': "",
                            'has_team_members': row[45] ?? "",
                            'full_time_employee_count': "",
                            'part_time_employee_count': "",
                            'team_members_count': row[46] ? row[46] : 0
                        },
                        "business": {
                            'business_name': row[24] ?? "",
                            'business_location': row[25] ?? "",
                            'business_website': row[26] ?? "",
                            'agriculture_field': row[27] ?? "",
                            'is_business_registered': row[28] ?? "",
                            'business_start_date': row[29] ?? "",
                            'business_stage': row[30] ?? "",
                            'revenue_till_date': row[31] ?? 0,
                            'business_achievements': row[32] ?? "",
                            'has_received_funding': "",
                            'has_partners': "",
                            'stake_in_business': "",
                            'has_liabilities': "",
                            'problem_to_solve': row[33] ?? "",
                            'business_solution': row[34] ?? "",
                            'business_offerings': "",
                            'target_market': row[35] ?? "",
                            'monetization_strategy': row[36] ?? "",
                            'market_validation': "",
                            'business_competitors': row[37] ?? "",
                            'business_uniqueness': row[38] ?? "",
                            'competitive_advantage': row[39] ?? "",
                            'business_motivation': "",
                            'business_vision': row[40] ?? "",
                            'founder_strength': "",
                            'business_goals': row[41] ?? "",
                            'business_challenges': row[42] ?? "",
                            'business_support': row[43] ?? "",
                            'self_involvement_lifespan': row[44] ?? ""
                        },
                        "team_members": []
                    })
                })
            })

            console.log({ "Complied App": compiledApplications });

            await insertItems(compiledApplications);
        })

    });

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return email && emailRegex.test(email);
    }

    async function insertItems(data) {

        try {
            const response = await fetch(SEND_MAIL_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();
            alert(result.message);
            console.log(result);

        } catch (error) {
            alert('Failed to send applications.');
            console.error(error);
        } finally {
            button.prop("disabled", false);
            button.html(originalContent);
        }
    }

    function readExcelFile(file) {
        return new Promise((resolve, reject) => {
            let reader = new FileReader();
            reader.onload = function (event) {
                let data = new Uint8Array(event.target.result);
                let workbook = XLSX.read(data, {
                    type: "array"
                });

                let sheet = workbook.SheetNames[0];
                let worksheet = workbook.Sheets[sheet];
                if (!sheet) {
                    reject(
                        "Sheet not found. Please ensure you used the same name of Sheet names as the template."
                    );
                    return;
                }

                let jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });

                // jsonData = jsonData.map(row => row.map(cell => {
                //     return cell instanceof Date
                //         ? cell.toLocaleString("en-US")
                //         : cell;
                // }));

                if (jsonData.length === 0) {
                    reject("No data found in the sheet.");
                    return;
                }
                resolve(jsonData);
            };
            reader.onerror = function (error) {
                reject(error);
            };
            reader.readAsArrayBuffer(file);
        });
    }

</script>