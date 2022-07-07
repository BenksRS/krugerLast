const grid = document.querySelector(`[data-layout=time]`)

const slot = {
    cols: grid.childElementCount,
    size: Math.floor(grid.offsetWidth / grid.childElementCount)
}

document.addEventListener('livewire:load', function (event) {
    loadEvents()
})

window.addEventListener('timelineUpdated', event => {
    console.log('A post was added with the id of: ')

})


const loadEvents = () => {
    console.log('A post was added with the id of: 2')
    /*    eventsPosition()*/

    $('.e-event').draggable({
        cursor:      'move',
        containment: ".e-content-resource",
        stop:        function (e, ui) {
            overlapCheck(this, ui)
        }
    }).resizable({
        containment: 'parent',
        stop (e, ui) {
            overlapCheck(this, ui)
        }
    })
    $('.e-content-events').droppable({
        drop (e, ui) {
            this.appendChild(ui.draggable[0])
        }
    })
}

const eventsPosition = () => {
    const events = document.querySelectorAll('.e-event')
    if (events.length) {
        events.forEach(function (el, key) {

            const data      = el.dataset
            const slotStart = grid.querySelector(`[data-time="${ data.timeStart }"]`)
            const slotEnd   = grid.querySelector(`[data-time="${ data.timeEnd }"]`)

            data.slotStart = slotStart.dataset.slot
            data.slotEnd   = slotEnd.dataset.slot

            console.log(slotEnd.dataset)
        })
    }

}

const overlapCheck = (el) => {

    const event = getEventData(el)


    const overlap   = [].slice.call(getSiblings(el)).filter(child => {
            const childEvent = getEventData(child)
            return (event.start.slot >= childEvent.start.slot && event.start.slot < childEvent.end.slot)
                || (event.end.slot > childEvent.start.slot && event.end.slot <= childEvent.end.slot)
                || (event.start.slot < childEvent.start.slot && event.end.slot > childEvent.end.slot)
        }
    )
    el.style.top    = null
    el.style.left   = null
    el.style.width  = null
    el.style.height = null


    if (!overlap.length) {
        /*        el.dataset.slotStart = event.start.slot
                el.dataset.slotEnd   = event.end.slot
                el.dataset.slotCol   = event.slot.col*/

        el.style.setProperty('--timeline-event-start', event.start.slot)
        el.style.setProperty('--timeline-event-end', event.end.slot)

        /*        utils.doSort(el.parentNode, `data-slot-start`)*/
        updateEvent(event)
    }
}


const getEventData = (el) => {
    const parent = el.parentNode

    const $slot = {}
    const $time = {}

    $slot.cols  = Math.ceil(el.offsetWidth / slot.size)
    $slot.start = Math.ceil(el.offsetLeft / slot.size)
    $slot.end   = Math.ceil($slot.start + $slot.cols)

    $time.start = grid.querySelector(`[data-slot="${ $slot.start }"]`)
    $time.end   = grid.querySelector(`[data-slot="${ $slot.end }"]`)

    return {
        tech_id:     parseInt(parent.dataset.employee),
        schedule_id: parseInt(el.dataset.id),
        start:       $time.start.dataset,
        end:         $time.end.dataset
    }
}

const getSiblings = (el) => {
    const parent = el.parentNode
    return [].slice.call(parent.children).filter(child => child !== el)
}

const updateEvent = (event) => {

    Livewire.emit('updateEvent', event)

}