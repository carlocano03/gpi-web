<style>
.table thead {
    background: #E2E8F0 !important;
    color: red !important;
}

#church_schedule_chart {
    width: 380px !important;
    height: 380px !important;

}

@media (max-width: 768px) {
    #church_schedule_chart {
        width: 350px !important;
        height: 350px !important;

    }
}

@media (max-width: 420px) {
    #church_schedule_chart {
        width: 250px !important;
        height: 250px !important;

    }
}
</style>

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y" style="max-width:100%; ">
        <div class="row gy-3">
            <div class="col-lg-8 col-12 order-lg-1 order-2">
                <div class="row row-cols-lg-2 row-cols-1 g-3">
                    <div class="col">
                        <div class="overview-card">
                            <div class="d-flex align-items-center gap-4">
                                <div class="dashboard__img-container dashboard__img-container--border1">
                                    <img class="dashboard__img"
                                        src="<?php echo base_url('assets/images/admin/group-member.png'); ?>"
                                        alt="Scholars" />
                                </div>
                                <div class="flex flex-column">
                                    <div class="custom-card__title" id="total_member">0</div>
                                    <div class="custom-card__sub-text">
                                        Total Member
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="overview-card">
                            <div class="d-flex align-items-center gap-4 ">
                                <div class="dashboard__img-container dashboard__img-container--border2">
                                    <img class="dashboard__img"
                                        src="<?php echo base_url('assets/images/admin/approve.png'); ?>"
                                        alt="Approved" />
                                </div>
                                <div class="flex flex-column">
                                    <div class="custom-card__title" id="active_member">0</div>
                                    <div class="custom-card__sub-text">
                                        Total Active Member
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="overview-card">
                            <div class="d-flex align-items-center gap-4">
                                <div class="dashboard__img-container dashboard__img-container--border3">
                                    <img class="dashboard__img"
                                        src="<?php echo base_url('assets/images/admin/pending.png'); ?>"
                                        alt="Scholars" />
                                </div>
                                <div class="flex flex-column">
                                    <div class="custom-card__title" id="pending_application">0</div>
                                    <div class="custom-card__sub-text">
                                        Pending Application
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="overview-card">
                            <div class="d-flex align-items-center gap-4">
                                <div class="dashboard__img-container dashboard__img-container--border4 ">
                                    <img class="dashboard__img"
                                        src="<?php echo base_url('assets/images/admin/inactive.png'); ?>"
                                        alt="Scholars" />
                                </div>
                                <div class="flex flex-column">
                                    <div class="custom-card__title" id="inactive_member">0</div>
                                    <div class="custom-card__sub-text">
                                        Total Inactive Member
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <div class="overview-card">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <img class="overview-card__icon"
                                        src="<?php echo base_url('assets/images/admin/registration.png'); ?>" alt="
                                        Registration">
                                    <h1 class="overview-card__title mb-0">Member Registration Metrics</h1>
                                </div>
                                <div class="custom-date-input">
                                    <select name="filter_options" id="filter_options" class="form-select">
                                        <option value="1">Week</option>
                                        <option value="2">Monthly</option>
                                        <option value="3">Yearly</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-3">
                                <canvas id="registration-metrics"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Second Column -->
            <div class="col-lg-4 col-12 order-lg-2 order-1">
                <div class="row mb-4">
                    <div class="col">
                        <div class="overview-card">
                            <div class="d-flex align-items-center gap-2 py-2">
                                <img class="overview-card__icon"
                                    src="<?php echo base_url('assets/images/admin/recent.png'); ?>" alt="Recent">
                                <h1 class="overview-card__title mb-0">Recent News</h1>
                            </div>
                            <div>
                                <!-- <ul class="p-0" id="recent_activities">

                                </ul> -->
                                
                                <div class="mb-3">
                                    <a href="#" style="color:#434875;">
                                        <p style="font-size:16px; font-weight:600;">Sample News Title</p>
                                        <p style="font-size:12px; text-align:justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt 
                                            ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud...
                                        </p>
                                        <span style="font-size:11px; color:gray;">Posted By: Carlo Cano | Tue November 12, 2024 11:29 AM</span>
                                    </a>
                                </div>

                                <div class="mb-3">
                                    <a href="#" style="color:#434875;">
                                        <p style="font-size:16px; font-weight:600;">Sample News Title</p>
                                        <p style="font-size:12px; text-align:justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt 
                                            ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud...
                                        </p>
                                        <span style="font-size:11px; color:gray;">Posted By: Carlo Cano | Tue November 12, 2024 11:29 AM</span>
                                    </a>
                                </div>

                                <div>
                                    <a href="#" style="color:#434875;">
                                        <p style="font-size:16px; font-weight:600;">Sample News Title</p>
                                        <p style="font-size:12px; text-align:justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt 
                                            ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud...
                                        </p>
                                        <span style="font-size:11px; color:gray;">Posted By: Carlo Cano | Tue November 12, 2024 11:29 AM</span>
                                    </a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col">
                        <div class="overview-card">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <img class="overview-card__icon"
                                        src="<?php echo base_url('assets/images/admin/poll.png'); ?>" alt="
										Registration">
                                    <h1 class="overview-card__title mb-0">Poll Result</h1>
                                </div>
                            </div>

                            <div class="mt-2">
                                <div id="poll_request">
                                    <h5 style="font-size:14px;"><i class="bi bi-question-circle me-1"></i>Sample Poll Question</h5>
                                    <div class="poll_result">
                                        <div class="mb-3">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <h5 class="mb-0" style="font-size:13px;">Choices 1</h5>
                                            </div>
                                            <div class="progress" style="height:16px; cursor:pointer" title="Total Vote: 10">
                                                <div class="progress-bar bg-info progress-bar-striped progress-bar-animate" role="progressbar" style="width:20%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" title="Total Vote: 10">10</div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <h5 class="mb-0" style="font-size:13px;">Choices 2</h5>
                                            </div>
                                            <div class="progress" style="height:16px; cursor:pointer" title="Total Vote: 5">
                                                <div class="progress-bar bg-info progress-bar-striped progress-bar-animate" role="progressbar" style="width:5%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" title="Total Vote: 5">5</div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <h5 class="mb-0" style="font-size:13px;">Choices 3</h5>
                                            </div>
                                            <div class="progress" style="height:16px; cursor:pointer" title="Total Vote: 0">
                                                <div class="progress-bar bg-info progress-bar-striped progress-bar-animate" role="progressbar" style="width:0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" title="Total Vote: 0">0</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of second column -->
        </div>
    </div>
</div>

<script>
    var applicationChartInstance;

    function getDashboardCount() {
        $.ajax({
            url: "<?= base_url('admin_portal/main/getDashboardCount')?>",
            method: "GET",
            dataType: "json",
            success: function(data) {
                const countUpConfigs = [{
                        elementId: 'total_member',
                        targetValue: data.total_member,
                    },
                    {
                        elementId: 'active_member',
                        targetValue: data.active_member,
                    },
                    {
                        elementId: 'pending_application',
                        targetValue: data.pending_application,
                    },
                    {
                        elementId: 'inactive_member',
                        targetValue: data.inactive_member,
                    }
                ]; 

                countUpConfigs.forEach((config) => {
                    var countUp = new CountUp(config.elementId, 0, config
                        .targetValue,
                        0, 4, {
                            duration: 3,
                            useEasing: true,
                            separator: ',',
                        });

                    if (!countUp.error) {
                        countUp.start();
                    } else {
                        console.error("CountUp Error:", countUp.error);
                    }
                });
            }
        });
    }

    function getApplicationChart() {
        var range = $('#filter_options').val();
        var applicationData;
        const registration = document.getElementById('registration-metrics');

        if (applicationChartInstance) {
            applicationChartInstance.destroy();
        }

        $.ajax({
            url: "<?= base_url('admin_portal/member_application/applicationChart')?>",
            method: "GET",
            data: {
                range: range
            },
            success: function(data) {
                var labels = Object.keys(data[0]).filter(key => key !== 'application_status' && key !== 'total_count');

                var formattedLabels = labels.map(date => {
                    var options = {
                        month: 'short',
                        day: '2-digit',
                        year: 'numeric'
                    };
                    var dateObj = new Date(date);
                    return dateObj.toLocaleDateString('en-US', options);
                });

                var datasets = [];
                var aggregatedData = {};

                // Process response to aggregate data
                data.forEach(function(user) {
                    if (!aggregatedData[user.application_status]) {
                        aggregatedData[user.application_status] = new Array(labels.length).fill(0);
                    }
                });

                // Aggregate data
                data.forEach(function(user) {
                    labels.forEach(function(date, index) {
                        aggregatedData[user.application_status][index] += parseInt(user[date]);
                    });
                });

                // Convert aggregated data into datasets array format
                Object.keys(aggregatedData).forEach(function(userType) {
                    datasets.push({
                        label: userType,
                        data: aggregatedData[userType],
                        fill: false,
                        borderColor: userType === 'Total Application' ? '#32C7ED' : userType ===
                            'Approved' ? '#7BDF4A' :
                            '#ff3838', // Assign different colors based on user_type
                        tension: 0.1
                    });
                });

                // Construct applicationData
                var applicationData = {
                    labels: formattedLabels,
                    datasets: datasets
                };

                // Create the chart
                applicationChartInstance = new Chart(registration, {
                    type: 'line',
                    data: applicationData,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    min: 0
                                }
                            }
                        }
                    }
                });
            },
            error: function(error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    $(document).ready(function() {
        getDashboardCount();
        getApplicationChart();

        $(document).on('change', '#filter_options', function() {
            getApplicationChart();
        });

    });
</script>