document.addEventListener("DOMContentLoaded", loadWhatsappStoreAnalytics);

let chartType = "line";
let start = "";
let end = "";
function loadWhatsappStoreAnalytics() {
    let timeRange = $("#whatsappStoreTimeRange");
    let isPickerApply = true;
    const today = moment();
    start = moment().subtract("30", "days");
    end = today.clone().endOf("days");

    timeRange.on("apply.daterangepicker", function (ev, picker) {
        isPickerApply = true;
        start = picker.startDate;
        end = picker.endDate;
        loadWhatsappStoreDashboardData(
            start.format("YYYY-MM-D  HH:mm:ss"),
            end.format("YYYY-MM-D  HH:mm:ss")
        );
    });

    window.cb = function (start, end) {
        timeRange
            .find("span")
            .html(
                start.format("MMM D, YYYY") + " - " + end.format("MMM D, YYYY")
            );
    };

    timeRange.daterangepicker(
        {
            startDate: start,
            endDate: end,
            opens: "left",
            showDropdowns: true,
            autoUpdateInput: false,
            locale: {
                customRangeLabel: Lang.get("js.custom"),
                applyLabel: Lang.get("js.apply"),
                cancelLabel: Lang.get("js.cancel"),
                fromLabel: Lang.get("js.from"),
                toLabel: Lang.get("js.to"),
                monthNames: [
                    Lang.get("js.jan"),
                    Lang.get("js.feb"),
                    Lang.get("js.mar"),
                    Lang.get("js.apr"),
                    Lang.get("js.may"),
                    Lang.get("js.jun"),
                    Lang.get("js.jul"),
                    Lang.get("js.aug"),
                    Lang.get("js.sep"),
                    Lang.get("js.oct"),
                    Lang.get("js.nov"),
                    Lang.get("js.dec"),
                ],

                daysOfWeek: [
                    Lang.get("js.sun"),
                    Lang.get("js.mon"),
                    Lang.get("js.tue"),
                    Lang.get("js.wed"),
                    Lang.get("js.thu"),
                    Lang.get("js.fri"),
                    Lang.get("js.sat"),
                ],
            },
            ranges: {
                [Lang.get("js.this_week")]: [
                    moment().startOf("week"),
                    moment().endOf("week"),
                ],
                [Lang.get("js.last_week")]: [
                    moment().startOf("week").subtract(7, "days"),
                    moment().startOf("week").subtract(1, "days"),
                ],
            },
        },
        cb
    );

    cb(start, end);

    loadWhatsappStoreDashboardData(
        start.format("YYYY-MM-D H:mm:ss"),
        end.format("YYYY-MM-D H:mm:ss")
    );

    let applyBtn = $(".range_inputs > button.applyBtn");
    $(document).on("click", ".ranges li", function () {
        if ($(this).data("range-key") === "Custom Range") {
            applyBtn.css("display", "initial");
        } else {
            applyBtn.css("display", "none");
        }
    });
    applyBtn.css("display", "none");
}

listenClick("#whatsappStoreChangeChart", function () {
    if (chartType === "bar") {
        chartType = "line";
        $(".chart").removeClass("fa-chart-line");
        $(".chart").addClass("fa-chart-bar");
        loadWhatsappStoreDashboardData(
            start.format("YYYY-MM-D H:mm:ss"),
            end.format("YYYY-MM-D H:mm:ss")
        );
    } else {
        chartType = "bar";
        $(".chart").addClass("fa-chart-line");
        $(".chart").removeClass("fa-chart-bar");
        loadWhatsappStoreDashboardData(
            start.format("YYYY-MM-D H:mm:ss"),
            end.format("YYYY-MM-D H:mm:ss")
        );
    }
});

function loadWhatsappStoreDashboardData(startDate, endDate) {
    if (!$("#analyticWhatsappStoreId").length) {
        return;
    }
    let analyticWhatsappStoreId = $("#analyticWhatsappStoreId").val();
    $.ajax({
        type: "GET",
        url: route("whatsapp.store.chart", analyticWhatsappStoreId),
        dataType: "json",
        data: {
            start_date: startDate,
            end_date: endDate,
            whatsappStoreID: analyticWhatsappStoreId,
        },
        success: function (result) {
            weeklyWhatsappStoreBarChart(result);
        },
        cache: false,
    });
}

function weeklyWhatsappStoreBarChart(result) {
    if (!$("#weeklyUserBarChartContainer").length) {
        return;
    }
    let visitors = $("#analyticVisitors").val();
    $("#weeklyUserBarChartContainer").html("");
    $("canvas#weeklyUserBarChart").remove();
    $("#weeklyUserBarChartContainer").append(
        '<canvas id="weeklyUserBarChart" height="275" width="905" style="display: block; width: 905px; height: 500px;"></canvas>'
    );

    let data = result.data;
    let ctx = document.getElementById("weeklyUserBarChart").getContext("2d");

    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, "rgba(30, 58, 138, 0.4)");
    gradient.addColorStop(1, "rgba(30, 58, 138, 0.05)");

    const weeklyData = {
        labels: data.weeklyLabels,
        datasets: [
            {
                label: visitors,
                data: data.totalVisitorCount,
                borderColor: "#1C274C",
                backgroundColor: gradient,
                fill: chartType === 'line' ? true : false,
                tension: chartType === 'line' ? 0.4 : 0,
                borderWidth: chartType === 'line' ? 2 : 1,

                pointRadius: 0,
                pointHoverRadius: 0,
            },
        ],
    };

    let config = new Chart(ctx, {
        type: chartType,
        data: weeklyData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    enabled: true,
                    backgroundColor: "#1e3a8a",
                    titleColor: "#fff",
                    bodyColor: "#fff",
                    displayColors: false,
                    callbacks: {
                        label: function (context) {
                            let label = context.dataset.label || "";
                            if (label) {
                                label += ": ";
                            }
                            if (context.parsed.y !== null) {
                                label += context.parsed.y.toLocaleString();
                            }
                            return label;
                        },
                    },
                },
            },
            scales: {
                y: {
                    title: {
                        display: false,
                    },
                    min: 0,
                    ticks: {
                        color: "#555",
                        precision: 0,
                    },
                    grid: {
                        color: "#94a3b8",
                    }
                },
                x: {
                    title: {
                        display: false,
                    },
                    grid: { display: false },
                    ticks: { color: "#555" }
                },
            },
        },
    });
}
