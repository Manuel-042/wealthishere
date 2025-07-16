<link rel="stylesheet" href="<?= base_url('assets/css/f4f-alumni.css') ?>" />

<main class="container">
    <div class="header">
        <h1>Farmers for the Future Grant Winners 🏆</h1>
        <p>Celebrating Excellence in Agricultural Innovation</p>

        <div class="year-filter">
            <label for="yearSelect">Filter by Year:</label>
            <select id="yearSelect" class="year-select">
                <option value="2024">2024</option>
                <option value="2023">2023</option>
                <option value="2022">2022</option>
                <option value="2021">2021</option>
                <option value="2019">2019</option>
            </select>
        </div>
    </div>

    <div class="winners-container" id="winners"></div>
</main>

<script type="module">
    import { winnersData } from './assets/data/f4f-alumni.js';

    // JavaScript to handle year filtering
    document.getElementById('yearSelect').addEventListener('change', function () {
        renderWinners(this.value);
    });

    // Set default year to 2023 on page load
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('yearSelect');
        select.value = '2024';

        // Trigger the change event
        const event = new Event('change');
        select.dispatchEvent(event);
    });

    // Function to create social handles HTML
    function createSocialHandles(socialHandles) {
        if (!socialHandles || socialHandles.length === 0) return '';

        const socialLinks = socialHandles.map(social => `
                <a href="${social.url}" class="social-link ${social.platform}" target="_blank">
                    <span><img src="${social.icon}" alt="${social.platform}" width="18" height="18" style="display:block;"></span>
                    <span>${social.handle}</span>
                </a>
            `).join('');

        return `
                <div class="social-handles">
                    ${socialLinks}
                </div>
            `;
    }

    // Function to create content sections HTML
    function createContentSections(sections) {
        return sections.map((section, index) => `
        <div class="content-section">
            <h3>${section.title}</h3>
            <p>${section.content}</p>
        </div>
        ${index < sections.length - 1 ? '<div class="divider"></div>' : ''}
    `).join('');
    }


    // Function to create expandable content
    function createExpandableContent(winner) {
        const expandableSections = winner.sections // All sections except the first one
        const socialHandles = createSocialHandles(winner.socialHandles);

        return `
                <div class="expandable-content" id="expandable-${winner.id}">
                    ${createContentSections(expandableSections)}
                    ${socialHandles}
                </div>
                <button class="btn btn-primary show-less-btn" onclick="toggleExpand('${winner.id}')">Show less</button>
                <button class="btn btn-primary show-more-btn" onclick="toggleExpand('${winner.id}')">Show more</button>
            `;
    }

    // Function to generate winner card HTML
    function generateWinnerCard(winner) {
        const firstSection = winner.sections[0]; // Always show the first section
        const expandableContent = winner.expandable ? createExpandableContent(winner) : '';
        const nonExpandableContent = !winner.expandable ? `
                ${createContentSections(winner.sections)}
                ${createSocialHandles(winner.socialHandles)}
            ` : '';

        return `
                <div class="winner-card ${winner.position.split(" ")[0] == '2nd' ? 'second' : winner.position.split(" ")[0] == '3rd' ? 'third' : ''}">
                    <div class="position-badge ${winner.position.split(" ")[0] == '2nd' ? 'second' : winner.position.split(" ")[0] == '3rd' ? 'third' : ''}">${winner.position}</div>
                    
                    <div class="profile-section">
                        <img src="${winner.profileImage}" alt="Profile Picture" class="profile-image">
                        <div class="profile-info">
                            <h2>${winner.name}</h2>
                            <div class="business-name">${winner.businessName}</div>
                            ${winner.schoolInfo ? `<div class="school-info">${winner.schoolInfo}</div>` : ''}
                            ${winner.qualification ? `<div class="qualification">${winner.qualification}</div>` : ''}
                        </div>
                    </div>
                    
                    ${expandableContent}
                    ${nonExpandableContent}
                </div>
            `;
    }

    // Function to toggle expand/collapse
    function toggleExpand(winnerId) {
        const expandableContent = document.getElementById(`expandable-${winnerId}`);
        expandableContent.classList.toggle('expanded');
    }

    // Function to render all winners
    function renderWinners(year) {
        const container = document.getElementById(`winners`);
        const winners = winnersData[year];

        if (winners) {
            container.innerHTML = winners.map(winner => generateWinnerCard(winner)).join('');
        }
    }


    // Make functions globally available
    window.toggleExpand = toggleExpand;
    window.renderWinners = renderWinners;
    window.winnersData = winnersData;
</script>