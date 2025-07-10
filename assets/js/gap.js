document.addEventListener("DOMContentLoaded", function () {
  const yearSelect = document.getElementById("year-select");
  const winnersContainer = document.getElementById("winners-container");

  const allWinners = {
    2019: [
      {
        name: "Chiamaka Ndukwu",
        title: "Founder & CEO, AgroHive",
        image: "./assets/images/past_winners/F4F/2019/Chiamaka_Ndukwu.jpg",
      },
      {
        name: "Lucy Chioma Aniagolu",
        title: "Founder, Agrodemy",
        image: "./assets/images/past_winners/F4F/2019/Lucy_Chioma_Aniagolu.jpg",
      },
      {
        name: "Taiwo Kent",
        title: "Founder, Quotidian Foods Company",
        image: "./assets/images/past_winners/F4F/2019/Taiwo_Kent.jpg",
      },
    ],
    2021: [
      {
        name: "Ikechukwu Maky",
        title: "Founder, NUCEO Agro Services",
        image: "./assets/images/past_winners/F4F/2021/Ikechukwu_Maky.jpg",
      },
    ],
    2022: [
      {
        name: "Paul Ugorji",
        title: "CEO, Netwiver Fish Farm",
        image: "./assets/images/past_winners/F4F/2022/Paul_Ugorji.jpg",
      },
      {
        name: "Victoria Emmanuel",
        title: "CEO, Sokvikia Enterprise",
        image: "./assets/images/past_winners/F4F/2022/Victoria_Emmanuel.jpg",
      },
    ],
    2023: [
      {
        name: "Adebisi Opeyemi",
        title: "CEO, Pemnia Wellness",
        image: "./assets/images/past_winners/F4F/2023/Adebisi_Opeyemi.jpg",
      },
      {
        name: "Bernice Oyedele",
        title: "Founder, Oyedele Bernice Farm",
        image: "./assets/images/past_winners/F4F/2023/Bernice_Oyedele.jpg",
      },
      {
        name: "Felicitas Edeh",
        title: "CEO, Nourishwell Foods",
        image: "./assets/images/past_winners/F4F/2023/Felicitas_Edeh.jpg",
      },
      {
        name: "Williams Ekwebelam",
        title: "CEO, Bluefish Farm",
        image: "./assets/images/past_winners/F4F/2023/Williams_Ekwebelam.jpg",
      },
    ],
      2024: [
      {
        name: "Kanadi Usman",
        title: "CEO, Ukdembos Enterprise",
        image: "./assets/images/past_winners/F4F/2024/Kanadi_Usman.png",
      },
      {
        name: "Tolu Ajibola",
        title: "CEO, Tolu Ajibola Farms",
        image: "./assets/images/past_winners/F4F/2024/Tolu_Ajibola.png",
      },
       {
        name: "Aishat Albashir",
        title: "CEO, A&A Green Farms",
        image: "./assets/images/past_winners/F4F/2024/Aishat_Albashir.png",
      },
      
       {
        name: "Chinaza Naomi Mbah",
        title: "Founder, Nana's Delight Foodstuff",
        image: "./assets/images/past_winners/F4F/2024/Chinaza_Naomi_Mbah.png",
      },
       {
        name: "Emediong Effiong",
        title: "CEO, Agro Tech Hub",
        image: "./assets/images/past_winners/F4F/2024/Emediong_Effiong.png",
      },
       {
        name: "Abubakar Yakubu",
        title: "CEO, Binyakub Aquaculture Center",
        image: "./assets/images/past_winners/F4F/2024/Abubakar_Yakubu.png",
      },
    ],
  };

  // Function to populate the year dropdown
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
                              winner.image
                            }" class="img-fluid" alt="Past Winner ${
          winner.name
        }" onerror="this.onerror=null;this.src='https://placehold.co/120x120/003366/FFFFFF?text=${
          winner.name
            .split(" ")
            .map((n) => n[0])
            .join(".") || "N/A"
        }';">
                            <h5>${winner.name}</h5>
                            <p class="text-muted">${winner.title}</p>
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
