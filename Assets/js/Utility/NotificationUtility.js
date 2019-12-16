Centauri.Utility.NotificationUtility = function(severity, title, description, options={}) {
    return toastr[severity](title, description, options);
};

Centauri.Notify = function(severity, title, description, options={}) {
    return Centauri.Utility.NotificationUtility(severity, title, description, options);
};
