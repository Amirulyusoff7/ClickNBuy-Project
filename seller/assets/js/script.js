
function openNav() {
    document.getElementById("mySidebar").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";  
    document.getElementById("main-content").style.marginLeft = "400px";
    document.getElementById("main").style.display="none";
  }
  
  function closeNav() {
    document.getElementById("mySidebar").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";  
    document.getElementById("main").style.display="block";  
  }

  //Chart Seller Dashboard
//   $.ajax({
//     url: "get_sales_data.php",
//     method: "GET",
//     success: function(data) {
//         var sales = [];
//         var dates = [];
//         for(var i in data) {
//             dates.push(data[i].date);
//             sales.push(data[i].sales);
//         }

//         var ctx = $("#sales-graph");

//         var chartData = {
//             labels: dates,
//             datasets : [
//                 {
//                     label: 'Sales',
//                     backgroundColor: 'rgba(200, 200, 200, 0.75)',
//                     borderColor: 'rgba(200, 200, 200, 0.75)',
//                     hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
//                     hoverBorderColor: 'rgba(200, 200, 200, 1)',
//                     data: sales
//                 }
//             ]
//         };

//         var salesGraph = new Chart(ctx, {
//             type: 'line',
//             data: chartData
//         });
//     },
//     error: function(data) {
//         console.log(data);
//     }
// });
