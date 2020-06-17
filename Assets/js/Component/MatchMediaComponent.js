/**
 * Component for responsive JavaScript calls.
 * 
 * Usage: Centauri.Component.MatchMediaComponent("screen", "min-width: 576px and (max-width: 991px)")
 * or:    Centauri.Component.MatchMediaComponent("screen", "above_lg");
 */
Centauri.Component.MatchMediaComponent = (breakpointsString, media="screen") => {
    let nBreakpointsString = breakpointsString;
    let privKeys = Centauri.Component.MatchMediaComponent.privKeys;

    Object.keys(privKeys).forEach((key) => {
        let value = privKeys[key];
        nBreakpointsString = nBreakpointsString.replace(key, value);
    });

    return window.matchMedia(media + " and " + nBreakpointsString).matches;
};

Centauri.Component.MatchMediaComponent.privKeys = {
    "above-xl": "(min-width: 1200px)",
    "below-xl": "(max-width: 1199px)",

    "above-lg": "(min-width: 992px)",
    "below-lg": "(max-width: 991px)",

    "above-md": "(min-width: 768px)",
    "below-md": "(max-width: 767px)",

    "above-sm": "(min-width: 576px)",
    "below-sm": "(max-width: 575px)",

    "above-xs": "(min-width: 575px)"
};
