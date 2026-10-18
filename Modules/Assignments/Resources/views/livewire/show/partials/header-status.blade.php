@once
    @push('css')
        <style>
            .dropdown-status-searchable {
                width: 360px;
                min-width: 320px;
                max-width: calc(100vw - 24px);
                padding: 0;
                overflow: hidden;
                border: 1px solid #e3e8f0;
                border-radius: 12px;
                background: #fff;
                box-shadow: 0 12px 32px rgba(25, 35, 55, .12);
            }

            .dropdown-status-header {
                padding: 15px 16px 12px;
                border-bottom: 1px solid #edf0f5;
            }

            .dropdown-status-title {
                display: flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 12px;
                color: #263248;
                font-size: 14px;
                font-weight: 600;
            }

            .dropdown-status-search {
                position: relative;
            }

            .dropdown-status-search-icon {
                position: absolute;
                top: 50%;
                left: 13px;
                transform: translateY(-50%);
                color: #8995a7;
                font-size: 17px;
                pointer-events: none;
            }

            .dropdown-status-search .form-control {
                height: 38px;
                padding: 7px 12px 7px 38px;
                border: 1px solid #dce3ec;
                border-radius: 20px;
                background: #fafbfd;
                color: #263248;
                font-size: 13px;
                box-shadow: none;
            }

            .dropdown-status-search .form-control:focus {
                border-color: #879af5;
                background: #fff;
                box-shadow: 0 0 0 3px rgba(85, 105, 230, .10);
            }

            .dropdown-status-search .form-control::placeholder {
                color: #939dad;
            }

            .dropdown-status-list {
                max-height: min(420px, 60vh);
                margin: 0;
                padding: 7px 0;
                overflow-y: auto;
                overscroll-behavior: contain;
                scrollbar-width: thin;
                scrollbar-color: #c5cbd5 transparent;
            }

            .dropdown-status-list .dropdown-item {
                display: block;
                width: 100%;
                padding: 10px 17px;
                border-radius: 0;
                color: #283244;
                font-size: 12px;
                line-height: 1.4;
                white-space: normal;
                text-align: left;
            }

            .dropdown-status-list .dropdown-item:not(:disabled):hover,
            .dropdown-status-list .dropdown-item:not(:disabled):focus {
                background: #f2f5ff;
                color: #445bd8;
            }

            .dropdown-status-list .dropdown-item:disabled {
                color: #98a2b3;
                opacity: 1;
                cursor: not-allowed;
            }

            .dropdown-status-list > li[hidden] {
                display: none !important;
            }

            .dropdown-status-footer {
                padding: 10px 16px;
                border-top: 1px solid #edf0f5;
                color: #8995a7;
                background: #fff;
                font-size: 12px;
                text-align: right;
            }

            @media (max-width: 575.98px) {
                .dropdown-status-searchable {
                    width: min(360px, calc(100vw - 24px));
                    min-width: 0;
                }

                .dropdown-status-list {
                    max-height: min(350px, 50vh);
                }
            }
        </style>
    @endpush
@endonce

<div class="dropdown-menu dropdown-menu-lg-end dropdown-status-searchable">

    <div class="dropdown-status-header">
        <div class="dropdown-status-title">
            <i class="bx bx-list-check" aria-hidden="true"></i>
            <span>Change Status</span>
        </div>
        <div class="dropdown-status-search">
            <i class="bx bx-search dropdown-status-search-icon" aria-hidden="true"></i>
            <input
              type="search"
              class="form-control form-control-sm js-status-search"
              placeholder="Search status..."
              aria-label="Search status"
              autocomplete="off"
              data-bs-auto-close="outside"
            >
        </div>
    </div>

    <!-- Lista rolável -->
    <ul class="list-unstyled mb-0 dropdown-status-list">

        @if($assignment->status->id == 33)
            <li>
                <button class="dropdown-item" wire:click="changeStatusScheduling(1)"
                        @if($assignment->carrier->id == 583 && $check_type == 1) disabled @endif type="button">OPEN @if($assignment->carrier->id == 583 && $check_type == 1)
                        <i class="bx bx-time-five"></i> (MISSING JOB TYPE / CARRIER)
                    @endif
                </button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="setPreStatus(11)"
                        @if($assignment->carrier->id == 583 && $check_type == 1) disabled @endif type="button">OPEN RESCHEDULE @if($assignment->carrier->id == 583 && $check_type == 1)
                        <i class="bx bx-time-five"></i> (MISSING JOB TYPE / CARRIER)
                    @endif
                </button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="setPreStatus(12)"
                        @if($assignment->carrier->id == 583 && $check_type == 1) disabled @endif type="button">PENDING @if($assignment->carrier->id == 583 && $check_type == 1)
                        <i class="bx bx-time-five"></i> (MISSING JOB TYPE / CARRIER)
                    @endif
                </button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="changeStatusScheduling(60)" type="button">SUPER PENDING</button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="setPreStatus(7)" type="button">CLOSED</button>
            </li>
        @else
            <li>
                <button class="dropdown-item" wire:click="setPreStatus(11)" type="button">OPEN RESCHEDULE</button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="setPreStatus(12)" type="button">PENDING</button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="changeStatusScheduling(60)" type="button">SUPER PENDING</button>
            </li>
            {{--                                    @if(in_array($assignment->status->id,[1, 27, 28]))
                                                    <li><button class="dropdown-item" wire:click="changeStatus(31)" type="button">NEXT WEEK</button></li>
                                                @endif--}}
            <li>
                <button class="dropdown-item" wire:click="changeStatus(31)" type="button">NEXT WEEK</button>
            </li>
            {{--<li><button class="dropdown-item" wire:click="changeStatus(32)" type="button">UNIV</button></li>--}}

            @if($assignment->status->id == 4)
                <li>
                    <button class="dropdown-item" wire:click="changeStatus(3)" type="button">IN PROGRESS</button>
                </li>
            @endif

            {{--<li><button class="dropdown-item" wire:click="changeStatusScheduling(28)" type="button">MESSAGE SENT</button></li>--}}
            <li>
                <button class="dropdown-item" wire:click="changeStatus(29)" type="button">REQUEST DOCUSIGN</button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="changeStatusScheduling(14)" type="button">DOCUSIGN SENT</button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="changeStatusScheduling(17)" type="button">READY TO INSTALL</button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="changeStatus(66)" type="button">READY TO INSTALL TARP</button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="changeStatus(62)" type="button">READY TO REVISE</button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="changeStatus(4)" @if(!isset($assignment->scheduling)) disabled @endif type="button">READY TO BILL @if(!isset($assignment->scheduling))
                        <i class="bx bx-time-five"></i> (MISSING SCHEDULED DATE)
                    @endif   </button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="changeStatusScheduling(59)" type="button">TRIP CHARGE</button>
            </li>
            @if(in_array(Auth::user()->id,[1, 2, 10, 25, 75]))
                <li>
                    <button class="dropdown-item" wire:click="changeStatusCleanUp(34, 16)" type="button">CLEAN UP CURBSIDE</button>
                </li>
                <li>
                    <button class="dropdown-item" wire:click="changeStatusCleanUp(35, 17)" type="button">CLEAN UP HAUL AWAY</button>
                </li>
                {{--<li><button class="dropdown-item" wire:click="changeStatusScheduling(47)"  type="button">TREE 3RD</button></li>--}}
            @endif

            @if($assignment->scheduling || in_array($assignment->status->id,[28, 17]))
                {{--<li><button class="dropdown-item" wire:click="changeStatusScheduling(27)"  type="button">LATE</button></li>--}}
            @endif
            <li>
                <button class="dropdown-item" wire:click="changeStatus(20)" type="button">UPLOADING PICS</button>
            </li>
            {{--<li><button class="dropdown-item" wire:click="changeStatus(61)" type="button">LABELING</button></li>--}}

            <li>
                <button class="dropdown-item" wire:click="setPreStatus(7)" type="button">CLOSED</button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="setPreStatus(26)" type="button">NO CHARGE</button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="setPreStatus(8)" type="button">NO JOB</button>
            </li>
            {{--<li><button class="dropdown-item" wire:click="changeStatus(30)"  type="button">LANDLINE</button></li>
            <li><button class="dropdown-item" wire:click="changeStatusScheduling(36)"  type="button">EXTREME</button></li>--}}
            <li>
                <button class="dropdown-item" wire:click="changeStatusScheduling(37)" type="button">NOBODY WAS HOME</button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="changeStatusScheduling(38)" type="button">CRANE NEEDED</button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="changeStatusScheduling(46)" type="button">CRANE APPROVED</button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="changeStatusScheduling(39)" type="button">NOT ENOUGH TIME</button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="changeStatusScheduling(41)" type="button">TREE EASY</button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="changeStatusScheduling(40)" type="button">TREE DONE NEED TARP</button>
            </li>
            {{--<li><button class="dropdown-item" wire:click="changeStatusScheduling(42)"  type="button">NOT CONFIRMED</button></li>--}}
            <li>
                <button class="dropdown-item" wire:click="changeStatusMissingAssignment(44)" type="button">MISSING ASSIGNMENT</button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="changeStatusScheduling(67)" type="button">GUS PROBLEM</button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="changeStatusScheduling(45)" type="button">NADAL PROBLEM</button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="changeStatusScheduling(65)" type="button">TREE GUARDIAN PROBLEM</button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="changeStatusScheduling(49)" type="button">CYNTHIA REVIEW</button>
            </li>
            {{--<li><button class="dropdown-item" wire:click="changeStatusScheduling(53)"  type="button">BAD LEAD</button></li>--}}
            <li>
                <button class="dropdown-item" wire:click="changeStatusScheduling(43)" type="button">WAITING REPLY</button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="changeStatusScheduling(54)" type="button">WAITING ESTIMATE</button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="changeStatus(64)" type="button">ROOFING ESTIMATE</button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="changeStatusScheduling(55)" type="button">ESTIMATE SENT</button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="changeStatusScheduling(58)" type="button">ESTIMATE TO BE SENT</button>
            </li>
            {{--<li><button class="dropdown-item" wire:click="changeStatusScheduling(56)"  type="button">LEAD REFUND</button></li>--}}
            <li>
                <button class="dropdown-item" wire:click="changeStatusScheduling(57)" type="button">SLIDE APPROVAL</button>
            </li>
            <li>
                <button class="dropdown-item" wire:click="changeStatus(63)" type="button">FRONTLINE</button>
            </li>
        @endif

    </ul>

    <!-- Contador de resultados, sempre visível -->
    <div class="dropdown-status-footer" role="status" aria-live="polite" aria-atomic="true">
        <span class="js-status-count">0 of 0 statuses</span>
    </div>

</div>
@once
    @push('js')
        <script>

            document.addEventListener('input', function (event) {
                if (!event.target.matches('.js-status-search')) {
                    return;
                }

                const input = event.target;
                const dropdown = input.closest('.dropdown-status-searchable');

                if (!dropdown) return;

                const search = input.value.trim().toLowerCase();
                const items = dropdown.querySelectorAll(
                    '.dropdown-status-list > li'
                );

                let visibleCount = 0;

                items.forEach(function (item) {
                    const button = item.querySelector('.dropdown-item');

                    if (!button) return;

                    const text = button.textContent.trim().toLowerCase();
                    const matches = text.includes(search);

                    item.hidden = !matches;

                    if (matches) {
                        visibleCount++;
                    }
                });

                dropdown.querySelector('.dropdown-status-list').scrollTop = 0;

                const counter = dropdown.querySelector('.js-status-count');
                if (counter) {
                    const total = items.length;
                    counter.textContent = `${visibleCount} of ${total} ${total === 1 ? 'status' : 'statuses'}`;
                }
            });

            // Limpar a pesquisa sempre que o dropdown abrir
            document.addEventListener('show.bs.dropdown', function (event) {
                const group = event.target.closest('.btn-group');

                if (!group) return;

                const dropdown = group.querySelector(
                    '.dropdown-status-searchable'
                );

                if (!dropdown) return;

                const input = dropdown.querySelector('.js-status-search');

                if (input) {
                    input.value = '';
                }

                const list = dropdown.querySelector('.dropdown-status-list');
                if (list) list.scrollTop = 0;

                dropdown.querySelectorAll(
                    '.dropdown-status-list > li'
                ).forEach(function (item) {
                    item.hidden = false;
                });

                const counter = dropdown.querySelector('.js-status-count');
                if (counter) {
                    const total = dropdown.querySelectorAll('.dropdown-status-list > li').length;
                    counter.textContent = `${total} of ${total} ${total === 1 ? 'status' : 'statuses'}`;
                }
            });

        </script>
    @endpush
@endonce