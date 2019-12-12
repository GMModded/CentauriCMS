Centauri.Utility.NotificationUtility = function(severity, title, description) {
    return toastr[severity](title, description);
};

Centauri.Notify = function(data) {
    return Centauri.Utility.NotificationUtility(data);
};
