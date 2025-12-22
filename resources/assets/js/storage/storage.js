document.addEventListener("DOMContentLoaded", function () {
    loadDashboardData();
});
let primaryColor;
function getCSSVariable(variable) {
    return getComputedStyle(document.documentElement)
        .getPropertyValue(variable)
        .trim();
}

function loadDashboardData() {
    primaryColor = getCSSVariable("--bs-primary");
    blurColor = getCSSVariable("--bs-bg-blur");

    var chartDataElement = document.getElementById("storagePieChart");
    if (!chartDataElement) return;
    var storageChartData = JSON.parse(
        chartDataElement.getAttribute("data-chart-data")
    );
    var storageChartLabels = JSON.parse(
        chartDataElement.getAttribute("data-chart-labels")
    );
    storageChart(storageChartData, storageChartLabels, primaryColor, blurColor);
}

function storageChart(data, labels, primaryColor, blurColor) {
    
    window.statisticsColors = [`${primaryColor}`, `${blurColor}`];

    // Check if the element exists before accessing it
    let pieChartElement = document.getElementById("storagePieChart");
    if (!pieChartElement) return; // Exit if the element doesn't exist
    let ctx = pieChartElement.getContext("2d");
    new Chart(ctx, {
        type: "pie",
        options: {
            responsive: true,
            maintainAspectRatio: false,
            responsiveAnimationDuration: 500,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            let label = labels[context.dataIndex] || "";
                            let value = Math.round(context.parsed) + "%";
                            return label + " " + value;
                        },
                    },
                },
            },
        },
        data: {
            datasets: [
                {
                    data: data,
                    backgroundColor: window.statisticsColors, // corrected variable name
                },
            ],
        },
    });
}
