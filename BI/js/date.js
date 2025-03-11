document.addEventListener("DOMContentLoaded", function() {
var dropdown = document.querySelector('.select-btn');
var totalSales = document.getElementById('totalSales');
var totalPurchases = document.getElementById('totalPurchases');

dropdown.addEventListener('click', function(event) {
var selectedOption = event.target.textContent.trim();

switch(selectedOption) {
case 'This week':
  totalSales.textContent = "100"; // Example value for this week sales
  totalPurchases.textContent = "50"; // Example value for this week purchases
break;
case 'This month':
  totalSales.textContent = "500"; // Example value for this month sales
  totalPurchases.textContent = "300"; // Example value for this month purchases
break;
case 'This year':
  totalSales.textContent = "2000"; // Example value for this year sales
  totalPurchases.textContent = "1500"; // Example value for this year purchases
break;
case 'Overall':
  totalSales.textContent = "10000"; // Example overall sales value
  totalPurchases.textContent = "8000"; // Example overall purchases value
break;
default:
break;
}
});
});