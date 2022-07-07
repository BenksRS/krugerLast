(function (root, factory) {
    let define
    if (typeof define === 'function' && define.amd) {
        define(['exports'], factory)
    } else if (typeof exports !== 'undefined') {
        factory(exports)
    } else {
        factory((root.scrollsync = {}))
    }
}(this, function (exports) {
    let Width            = 'Width'
    let Height           = 'Height'
    let Top              = 'Top'
    let Left             = 'Left'
    let scroll           = 'scroll'
    let client           = 'client'
    let EventListener    = 'EventListener'
    let addEventListener = 'add' + EventListener
    let length           = 'length'
    let Math_round       = Math.round

    let names = {}

    let reset = function () {
        let elems = document.querySelectorAll('[data-scroll-sync]');

        // clearing existing listeners
        let i, j, el, found, name
        for (name in names) {
            if (names.hasOwnProperty(name)) {
                for (i = 0; i < names[name][length]; i++) {
                    names[name][i]['remove' + EventListener](
                        scroll, names[name][i].syn, 0
                    )
                }
            }
        }

        // setting-up the new listeners
        for (i = 0; i < elems[length];) {
            found = j = 0
            el    = elems[i++]
            if (!(name = el.dataset.scrollSync)) {
                // name attribute is not set
                continue
            }

            el = el[scroll + 'er'] || el  // needed for intence

            // searching for existing entry in array of names;
            // searching for the element in that entry
            for (; j < (names[name] = names[name] || [])[length];) {
                found |= names[name][j++] === el
            }

            if (!found) {
                names[name].push(el)
            }

            el.eX = el.eY = 0;

            (function (el, name) {
                el[addEventListener](
                    scroll,
                    el.syn = function () {
                        let elems = names[name]

                        let scrollX = el[scroll + Left]
                        let scrollY = el[scroll + Top]

                        let xRate =
                                scrollX /
                                (el[scroll + Width] - el[client + Width])
                        let yRate =
                                scrollY /
                                (el[scroll + Height] - el[client + Height])

                        let updateX = scrollX !== el.eX
                        let updateY = scrollY !== el.eY

                        let otherEl, i = 0

                        el.eX = scrollX
                        el.eY = scrollY

                        for (; i < elems[length];) {
                            otherEl = elems[i++]
                            if (otherEl !== el) {
                                if (updateX &&
                                    Math_round(
                                        otherEl[scroll + Left] -
                                        (scrollX = otherEl.eX =
                                                Math_round(xRate *
                                                    (otherEl[scroll + Width] -
                                                        otherEl[client + Width]))
                                        )
                                    )
                                ) {
                                    otherEl[scroll + Left] = scrollX
                                }

                                if (updateY &&
                                    Math_round(
                                        otherEl[scroll + Top] -
                                        (scrollY = otherEl.eY =
                                                Math_round(yRate *
                                                    (otherEl[scroll + Height] -
                                                        otherEl[client + Height]))
                                        )
                                    )
                                ) {
                                    otherEl[scroll + Top] = scrollY
                                }
                            }
                        }
                    }, 0
                )
            })(el, name)
        }
    }


    if (document.readyState === "complete") {
        reset()
    } else {
        window[addEventListener]("load", reset, 0)
    }

    exports.reset = reset
}))
