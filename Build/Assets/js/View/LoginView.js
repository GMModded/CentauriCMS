Centauri.View.LoginView = function() {
    $("#login form").on("submit", this, function(e) {
        e.preventDefault();

        Centauri.fn.Ajax(
            "Backend",
            "login",

            {
                username: $("#username").val(),
                password: $("#password").val()
            },

            {
                success: function(data) {
                    data = JSON.parse(data);
                    Centauri.Notify(data.type, data.title, data.description);

                    if(data.type == "success") {
                        $(document.body).load(window.location.href, function() {
                            Centauri.Notify(data.type, data.title, data.description);
                            Centauri.Events.OnBackendEvent();

                            location.reload();
                        });
                    }
                },

                error: function(data) {
                    console.error(data);
                }
            }
        );
    });
};
