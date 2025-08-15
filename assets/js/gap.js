import { winnersData } from "../data/gap-alumni.js";

document.addEventListener("DOMContentLoaded", function () {
  //const yearSelect = document.getElementById("year-select");
  const winnersContainer = document.getElementById("winners-container");
  const year = new Date().getFullYear();

  function displayWinners(year) {
    winnersContainer.innerHTML = ""; // Clear current winners

    let found = false;

    // Loop over each school in allWinners
    for (const school in winnersData) {
      if (winnersData[school][year] && winnersData[school][year].length > 0) {
        found = true;

        winnersData[school][year].forEach((winner) => {
          const winnerCard = document.createElement("div");
          winnerCard.classList.add("winner-card-container");
          winnerCard.innerHTML = `
          <img src="${
            winner.profileImage
          }" class="img-fluid" alt="Past Winner ${winner.name}"
            onerror="this.onerror=null;this.src='https://i.postimg.cc/4317vFKX/Portrait-Placeholder.png=${
              winner.name
                .split(" ")
                .map((n) => n[0])
                .join(".") || "N/A"
            }';">
          <h5>${winner.name}</h5>
          <p class="text-muted">${winner.businessName}</p>
          <small>${school}</small>
        `;
          winnersContainer.appendChild(winnerCard);
        });
      }
    }

    if (!found) {
      winnersContainer.innerHTML =
        "<p class='text-center w-100'>No winners found for this year.</p>";
    }
  }

  // Event listener for year selection change
  // yearSelect.addEventListener("change", function () {
  //   displayWinners(this.value);
  // });

  // Initial population and display
  //populateYears();

  // if (yearSelect.value) {
  //   // Display winners for the default selected year
  // }
  displayWinners(year);

  // Script for copyright year in footer
  document.getElementById("copyright-year").textContent =
    new Date().getFullYear();
});
