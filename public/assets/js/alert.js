
document.addEventListener('DOMContentLoaded', function () {
    const alerts = document.querySelectorAll('.custom-toast');

    alerts.forEach(function (alert) {
        // Match this time (5000ms) to your CSS animation time
        setTimeout(function () {
            let bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            if (bsAlert) {
                bsAlert.close();
            }
        }, 4000);
    });
});
