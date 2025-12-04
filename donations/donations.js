document.addEventListener("DOMContentLoaded", () => {
  const donationButtons = document.querySelectorAll(".donation-button");
  const customAmount = document.getElementById("custom-amount");
  const donateNow = document.getElementById("donate-now");

  let selectedAmount = null;

  // Highlight selected button
  donationButtons.forEach(button => {
    button.addEventListener("click", () => {
      donationButtons.forEach(b => b.style.background = "#5ca0d3");
      button.style.background = "#4191c0";
      selectedAmount = button.dataset.amount;
      customAmount.value = "";
    });
  });

  // Handle donation
  donateNow.addEventListener("click", () => {
    const amount = selectedAmount || customAmount.value;

    if (!amount || amount <= 0) {
      alert("Please select or enter a donation amount.");
      return;
    }

    alert(`Thank you for donating $${amount}! Your support helps our cats!`);
    selectedAmount = null;
    customAmount.value = "";
    donationButtons.forEach(b => b.style.background = "#5ca0d3");
  });
});
