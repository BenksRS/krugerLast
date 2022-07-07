<div class="p-3 min-vh-100 d-flex">
	<div role="grid" class="c-timeline flex-grow-1">
		<div role="presentation" class="c-timeline-card">
			<livewire:scheduling::timeline.show-toolbar/>
			<livewire:scheduling::timeline.show-schedule/>
		</div>
		
		<div role="presentation" class="c-timeline-card" style="z-index: 99999999999999999999999999!important;">
			<livewire:scheduling::timeline.assignment.show/>
		</div>
	</div>
</div>
@push('js')
	<script>


        document.addEventListener('livewire:load', function () {

            const timeline = {
                init () {
                    this.handleScroll()
                    this.handleDrag()
                },
                handleScroll () {
                    const data = document.querySelector(`[data-scroll-time]`)
                    const time = data.dataset.scrollTime

                    const slot = document.querySelectorAll(`[data-time="${ time }"]`)

                    if (slot.length) {
                        slot.forEach(function (el, key) {
                            el.scrollIntoView({ inline: "start" })
                        })
                    }

                },
                handleDrag () {

                    const assignment = $("[data-dragsource=assignment]")
                    const schedule   = $("[data-dragsource=schedule]")

                    assignment.draggable({
                        cursor:      'move',
                        containment: '.e-content-resource',

                        stop (e, ui) {
                            console.log('assignment');
                            overlapCheck(this, ui)
                        }
                    })

                    schedule.draggable({

                        cursor:      'move',
                        containment: ".e-content-resource",
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
            }

            timeline.init()


            /*       loadEvents($('.e-event'))*/

            Livewire.hook('message.processed', (message, component) => {

                /*     loadEvents($('.e-event'))*/
            })

            function loadEvents (e) {

                e.draggable({
                    cursor:      'move',
                    containment: ".e-content-resource",
                    stop (e, ui) {
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

            function overlapCheck (el, ui) {

                const event = getEventData(el, ui)


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

            function getEventData (el, ui) {


                const parent = el.parentNode

                const $slot = {}
                const $time = {}

                const grid = document.querySelector(`[data-layout="time"]`)


                const slot = {
                    cols: grid.childElementCount,
                    size: Math.floor(grid.offsetWidth / grid.childElementCount)
                }


                $slot.cols  = Math.ceil(el.offsetWidth / slot.size)
                $slot.start = Math.ceil(el.offsetLeft / slot.size)
                $slot.end   = Math.ceil($slot.start + $slot.cols)

                $time.start = grid.querySelector(`[data-slot="${ $slot.start }"]`)
                $time.end   = grid.querySelector(`[data-slot="${ $slot.end }"]`)

                console.log('schedule -  tech:'+parent.dataset.tech+
                    ' assignment_id: '+el.dataset.assignment_id);
                console.log($time.start.dataset);
                console.log($time.end.dataset);

                return {


                    tech_id:     parseInt(parent.dataset.tech),
                    assignment_id: parseInt(el.dataset.assignment_id),
                    start:       $time.start.dataset,
                    end:         $time.end.dataset
                }
            }

            function getSiblings (el) {
                const parent = el.parentNode
                return [].slice.call(parent.children).filter(child => child !== el)
            }

            function updateEvent (event) {

                Livewire.emit('updateEvent', event);

            }


        })
	</script>
@endpush