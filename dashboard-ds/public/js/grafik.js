function formatRupiahJt(value) {
    if (value >= 1000000) {
        let val = value / 1000000;
        val = Math.round(val * 10) / 10;
        return val + ' jt';
    }
    if (value >= 1000) {
        let val = value / 1000;
        val = Math.round(val * 10) / 10;
        return val + ' rb';
    }
    return value;
}

function formatPercent(value) {
    return value + ' %';
}

document.addEventListener('DOMContentLoaded', function () {
    // Pie Chart Total Revenue per Regional
    const regionalCtx = document.getElementById('regionalPieChart').getContext('2d');
    new Chart(regionalCtx, {
        type: 'pie',
        data: {
            labels: window.chartData.regional.labels,
            datasets: [{
                label: 'Total Revenue',
                data: window.chartData.regional.total,
                backgroundColor: window.chartData.regional.colors,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            let label = context.label || '';
                            let value = context.formattedValue.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            return label + ': Rp ' + value;
                        }
                    }
                }
            }
        }
    });

    // Bar Chart Revenue per Tipe
    const revenueTypeCtx = document.getElementById('revenueTypeChart').getContext('2d');
    new Chart(revenueTypeCtx, {
        type: 'bar',
        data: {
            labels: window.chartData.revenue_types.labels,
            datasets: [{
                label: 'Revenue per Tipe',
                data: window.chartData.revenue_types.data,
                backgroundColor: window.chartData.revenue_types.colors,
                borderWidth: 1,
                borderRadius: 6,
                barPercentage: 0.7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return 'Rp ' + context.formattedValue.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // User Aktif Branch (jika ada)
    if (window.userAktifBranch.length > 0) {
        const userAktifBranchCtx = document.getElementById('userAktifBranchChart').getContext('2d');
        new Chart(userAktifBranchCtx, {
            type: 'bar',
            data: {
                labels: window.userAktifBranch.map(b => b.branch),
                datasets: [{
                    label: 'User Aktif',
                    data: window.userAktifBranch.map(b => b.user_aktif),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let value = context.raw || context.parsed || context.formattedValue;
                                return (context.label ? context.label + ': ' : '') + value + ' user';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return value + ' user';
                            }
                        }
                    },
                    x: {
                        ticks: {
                            autoSkip: false,
                            maxRotation: 90,
                            minRotation: 45
                        }
                    }
                }
            }
        });
    }

    // Top 5 Branch Revenue
    if (window.topBranches.length > 0) {
        const topBranchesCtx = document.getElementById('topBranchesChart').getContext('2d');
        new Chart(topBranchesCtx, {
            type: 'bar',
            data: {
                labels: window.topBranches.map(b => b.branch),
                datasets: [{
                    label: 'Revenue',
                    data: window.topBranches.map(b => b.total_revenue),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                    borderWidth: 1,
                    borderRadius: 6,
                    barPercentage: 0.6,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let value = context.raw || context.parsed || context.formattedValue;
                                return (context.label ? context.label + ': ' : '') + formatRupiahJt(value);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return formatRupiahJt(value);
                            }
                        }
                    },
                    y: { ticks: { autoSkip: false } }
                }
            }
        });
    }

    // Top 5 Cluster Revenue
    if (window.topClusters.length > 0) {
        const topClustersCtx = document.getElementById('topClustersChart').getContext('2d');
        new Chart(topClustersCtx, {
            type: 'bar',
            data: {
                labels: window.topClusters.map(c => c.cluster_name),
                datasets: [{
                    label: 'Revenue',
                    data: window.topClusters.map(c => c.total_revenue),
                    backgroundColor: ['#4BC0C0', '#FF9F40', '#9966FF', '#FFCD56', '#EB6841'],
                    borderWidth: 1,
                    borderRadius: 6,
                    barPercentage: 0.6,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let value = context.raw || context.parsed || context.formattedValue;
                                return (context.label ? context.label + ': ' : '') + formatRupiahJt(value);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return formatRupiahJt(value);
                            }
                        }
                    },
                    y: { ticks: { autoSkip: false } }
                }
            }
        });
    }

    // Top 5 Branch ACH
    if (window.topAchBranches.length > 0) {
        const achBranchCtx = document.getElementById('topAchBranchChart').getContext('2d');
        new Chart(achBranchCtx, {
            type: 'bar',
            data: {
                labels: window.topAchBranches.map(b => b.name),
                datasets: [{
                    label: 'ACH (%)',
                    data: window.topAchBranches.map(b => b.ach),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                    borderWidth: 1,
                    borderRadius: 6,
                    barPercentage: 0.7
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let value = context.raw || context.parsed || context.formattedValue;
                                return (context.label ? context.label + ': ' : '') + formatPercent(value);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function (value) {
                                return formatPercent(value);
                            }
                        }
                    },
                    y: { ticks: { autoSkip: false } }
                }
            }
        });
    }

    // Top 5 Cluster ACH
    if (window.topAchClusters.length > 0) {
        const achCtx = document.getElementById('topAchClusterChart').getContext('2d');
        new Chart(achCtx, {
            type: 'bar',
            data: {
                labels: window.topAchClusters.map(c => c.name),
                datasets: [{
                    label: 'ACH (%)',
                    data: window.topAchClusters.map(c => c.ach),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                    borderWidth: 1,
                    borderRadius: 6,
                    barPercentage: 0.7
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let value = context.raw || context.parsed || context.formattedValue;
                                return (context.label ? context.label + ': ' : '') + formatPercent(value);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function (value) {
                                return formatPercent(value);
                            }
                        }
                    },
                    y: { ticks: { autoSkip: false } }
                }
            }
        });
    }
});
