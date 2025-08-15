import { winnersData } from "../data/f4f-alumni.js";

document.addEventListener("DOMContentLoaded", function () {
  const yearSelect = document.getElementById("year-select");
  const winnersContainer = document.getElementById("winners-container");
  const allWinners = winnersData;
  
  function populateYears() {
    const years = Object.keys(allWinners).sort((a, b) => b - a); // Sort years in descending order
    years.forEach((year) => {
      const option = document.createElement("option");
      option.value = year;
      option.textContent = year;
      yearSelect.appendChild(option);
    });
    // Select the most recent year by default
    if (years.length > 0) {
      yearSelect.value = years[0];
    }
  }

  // Function to display winners for the selected year
  function displayWinners(year) {
    winnersContainer.innerHTML = ""; // Clear current winners
    const winners = allWinners[year];

    if (winners && winners.length > 0) {
      winners.forEach((winner) => {
        const winnerCard = document.createElement("div");
        winnerCard.classList.add("winner-card-container"); // Use the new class for consistent styling
        winnerCard.innerHTML = `
                            <img src="${
                              winner.profileImage
                            }" class="img-fluid" alt="Past Winner ${
          winner.name
        }" onerror="this.onerror=null;this.src='https://placehold.co/120x120/003366/FFFFFF?text=${
          winner.name
            .split(" ")
            .map((n) => n[0])
            .join(".") || "N/A"
        }';">
                            <h5>${winner.name}</h5>
                            <p class="text-muted">${winner.businessName}</p>
                        `;
        winnersContainer.appendChild(winnerCard);
      });
    } else {
      winnersContainer.innerHTML =
        "<p class='text-center w-100'>No winners found for this year.</p>";
    }
  }

  // Event listener for year selection change
  yearSelect.addEventListener("change", function () {
    displayWinners(this.value);
  });

  // Initial population and display
  populateYears();
  if (yearSelect.value) {
    // Display winners for the default selected year
    displayWinners(yearSelect.value);
  }

  // Script for copyright year in footer
  document.getElementById("copyright-year").textContent =
    new Date().getFullYear();
});
