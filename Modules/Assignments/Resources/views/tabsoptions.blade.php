
        <ul class="nav nav-pills nav-justified" role="tablist" >
            <li class="nav-item waves-effect waves-light mx-2 card">

                    <a class="nav-link " data-bs-toggle="tab" href="#infodetails" role="tab">

                        <span class="fw-bold">Info Details</span>
                    </a>
            </li>
            <li class="nav-item waves-effect waves-light mx-2 card">
                    <a class="nav-link active" data-bs-toggle="tab" href="#jobreport" role="tab">
                        <span class="fw-bold">Job Report</span>
                    </a>
            </li>
            <li class="nav-item waves-effect waves-light mx-2 card">
                <a class="nav-link " data-bs-toggle="tab" href="#gallery" role="tab">
                    <span class="fw-bold">Gallery</span>
                </a>
            </li>
            <li class="nav-item waves-effect waves-light mx-2 card">
                <a class="nav-link" data-bs-toggle="tab" href="#forms" role="tab">
                    <span class="fw-bold">Forms</span>
                </a>
            </li>
            <li class="nav-item waves-effect waves-light mx-2 card">
                <a class="nav-link" data-bs-toggle="tab" href="#finance" role="tab">
                    <span class="fw-bold">Finance</span>
                </a>
            </li>

            <li class="nav-item waves-effect waves-light mx-2 card">
                <a class="nav-link" data-bs-toggle="tab" href="#comissions" role="tab">
                    <span class="fw-bold">Comissions</span>
                </a>
            </li>
            <li class="nav-item waves-effect waves-light mx-2 card">
                <a class="nav-link" data-bs-toggle="tab" href="#costs" role="tab">
                    <span class="fw-bold">Costs</span>
                </a>
            </li>
            <li class="nav-item waves-effect waves-light mx-2 card">
                <a class="nav-link" data-bs-toggle="tab" href="#messages" role="tab">
                    <span class="fw-bold">Messages</span>
                </a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content p-3 text-muted">
            <div class="tab-pane " id="infodetails" role="tabpanel">
                @include('assignments::tabs.info')
            </div>
            <div class="tab-pane active" id="jobreport" role="tabpanel">
                @include('assignments::tabs.jobreport.index')
            </div>
            <div class="tab-pane" id="finance" role="tabpanel">
                <p class="mb-0">
                    Finance
                </p>
            </div>
            <div class="tab-pane " id="gallery" role="tabpanel">
                @include('assignments::tabs.gallery.index')
            </div>
            <div class="tab-pane" id="forms" role="tabpanel">
                <p class="mb-0">
                    Forms
                </p>
            </div>
            <div class="tab-pane" id="comissions" role="tabpanel">
                <p class="mb-0">
                    Comissions
                </p>
            </div>
            <div class="tab-pane" id="costs" role="tabpanel">
                <p class="mb-0">
                    Costs
                </p>
            </div>
            <div class="tab-pane" id="messages" role="tabpanel">
                <p class="mb-0">
                    Messages
                </p>
            </div>
        </div>




