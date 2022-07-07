export const doSort = (el, selector) => {

    let container = el
    let elements  = container.children
    let sortMe    = []

    for (const item of elements) {
        let sortPart = item.getAttribute(selector)
        sortMe.push([1 * sortPart, item])
    }
    sortMe.sort((x, y) => x[0] - y[0])

    for (const item of sortMe) {
        container.appendChild(item[1])
    }
}