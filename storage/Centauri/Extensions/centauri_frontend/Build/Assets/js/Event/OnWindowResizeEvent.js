Centauri.Event.OnWindowResizeEvent = () => {
    let _breakpoint = "xs";

    if(Centauri.Component.MatchMediaComponent("above-sm")) {
        _breakpoint = "sm";
    }
    if(Centauri.Component.MatchMediaComponent("above-md")) {
        _breakpoint = "md";
    }
    if(Centauri.Component.MatchMediaComponent("above-lg")) {
        _breakpoint = "lg";
    }
    if(Centauri.Component.MatchMediaComponent("above-xl")) {
        _breakpoint = "xl";
    }

    if(
        Centauri.Breakpoint != "" &&
        Centauri.Breakpoint != _breakpoint
    ) {
        Centauri.Breakpoint = _breakpoint;
    } else if(Centauri.Breakpoint == "") {
        Centauri.Breakpoint = _breakpoint;
    }

    Centauri.Event.OnBreakpointChangeEvent(_breakpoint);
};
