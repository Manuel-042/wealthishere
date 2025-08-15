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

<div class="community-banner">
    <a href="https://chat.whatsapp.com/KuHEDEC8PoxEwDaxCknPZN" target="_blank" class="community-link">
        <svg class="whatsapp-icon" viewBox="0 0 24 24" fill="currentColor">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.516" />
        </svg>
        <div>
            <div class="community-text">Join Our Youth Alumni Community</div>
            <!-- <div class="community-subtext">Get updates, tips & connect with fellow members</div> -->
        </div>
    </a>
</div>

<script type="module">
    import {
        winnersData
    } from './assets/data/f4f-alumni.js';

    // JavaScript to handle year filtering
    document.getElementById('yearSelect').addEventListener('change', function() {
        renderWinners(this.value);
    });

    // Set default year to 2023 on page load
    document.addEventListener('DOMContentLoaded', function() {
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
        const documentLink = winner.document ? `
                <div class="action-buttons">
                    <a href="${winner.document}" class="btn document-link" target="_blank">
                        Click to view business guide
                    </a>
                </div>
            ` : '';

        return `
                <div class="expandable-content" id="expandable-${winner.id}">
                    ${createContentSections(expandableSections)}
                    ${documentLink}
                    ${socialHandles}
                </div>
                <button class="btn btn-primary show-more-btn" onclick="toggleExpand('${winner.id}')">Show more</button>
                <button class="btn btn-primary show-less-btn" onclick="toggleExpand('${winner.id}')">Show less</button>
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
                        <div class="profile-images">
                            <img src="${winner.profileImage}" alt="Profile Picture" class="profile-image">
                            ${winner.logo ? `
                                <img src="${winner.logo}" alt="Business Logo" class="business-logo">
                            ` : ''}
                        </div>
                        
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