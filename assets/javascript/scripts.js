// Get the current date
var currentDate = new Date();
      
// Get the year from the current date
var year = currentDate.getFullYear();

// Update the content of the span element with the current year
document.getElementById("footer-date").textContent = year;