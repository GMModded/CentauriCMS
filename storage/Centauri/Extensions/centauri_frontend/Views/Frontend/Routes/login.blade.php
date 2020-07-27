@if($loggedIn)
    Welcome back
    {{ dd(get_defined_vars()["__data"]) }}
@else
    <form method="post" action="{!!
        \Centauri\CMS\BladeHelper\URIBladeHelper::linkAction(
            "\Centauri\Extension\Frontend\Controller\FrontendController",
            "login"
        )
    !!}">
        <input name="username" type="text" placeholder="Username" />
        <input name="password" type="password" placeholder="Password" />

        <input type="submit" value="Log in" />
    </form>
@endif
