<div id="labeling-admin" data-tab="{{ $tab }}">
    <style>
        #labeling-admin .lz-paste{border:2px dashed #b8c2cc;border-radius:10px;padding:26px 16px;text-align:center;
            cursor:pointer;color:#74788d;background:#f8f9fb;transition:.15s}
        #labeling-admin .lz-paste:hover,#labeling-admin .lz-paste.drag{border-color:#556ee6;background:#eef1fe;color:#556ee6}
        #labeling-admin .lz-paste img{max-height:220px;border-radius:8px}
        #labeling-admin .chat{max-height:60vh;overflow-y:auto;padding:8px 4px}
        #labeling-admin .bubble{display:flex;gap:12px;background:#fff;border:1px solid #eef0f2;border-radius:12px;
            padding:12px;margin-bottom:12px}
        #labeling-admin .bubble.off{opacity:.5}
        #labeling-admin .bubble img{width:130px;height:100px;object-fit:cover;border-radius:8px;flex:0 0 auto}
        #labeling-admin .bubble .lbl{font-weight:600;font-size:15px}
        #labeling-admin .composer{background:#fff;border:1px solid #eef0f2;border-radius:12px;padding:16px;position:sticky;top:16px}
    </style>

    <p class="text-muted">
        These settings feed the AI that labels job photos. Changes take effect on the next job — no deploy needed.
    </p>

    <ul class="nav nav-tabs nav-tabs-custom mb-3">
        @foreach (['examples' => 'Teach with photos', 'rules' => 'Rules', 'vocabulary' => 'Vocabulary', 'banned' => 'Banned words'] as $key => $label)
            <li class="nav-item">
                <a href="javascript:void(0)" wire:click="setTab('{{ $key }}')"
                   class="nav-link @if($tab === $key) active @endif">{{ $label }}</a>
            </li>
        @endforeach
    </ul>

    {{-- =============================================== EXAMPLES (chat) =============================================== --}}
    @if ($tab === 'examples')
        <div class="row">
            <div class="col-lg-7 order-lg-2">
                <div class="chat" id="lz-chat">
                    @forelse ($examples as $ex)
                        <div class="bubble @if(!$ex->active) off @endif">
                            <img src="{{ route('gdrive.labeling_example_image', $ex->id) }}" alt="">
                            <div class="flex-grow-1">
                                <div class="lbl">✅ {{ $ex->description }}</div>
                                <div class="small text-muted">
                                    {{ $ex->category }}@if($ex->job_number) · job {{ $ex->job_number }}@endif
                                    · {{ optional($ex->created_at)->diffForHumans() }}
                                </div>
                                @if ($ex->note)<div class="small mt-1">{{ $ex->note }}</div>@endif
                                <div class="mt-2 d-flex gap-1">
                                    <button class="btn btn-sm btn-outline-secondary" wire:click="toggleExample({{ $ex->id }})">
                                        {{ $ex->active ? 'Disable' : 'Enable' }}
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" wire:click="deleteExample({{ $ex->id }})"
                                            onclick="return confirm('Delete this example?')">Delete</button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No examples yet. Paste a photo below and tell the AI what it should be called.</p>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-5 order-lg-1">
                <div class="composer">
                    <h6 class="mb-2">Teach the AI</h6>

                    <div class="lz-paste mb-2" id="lz-paste">
                        @if ($exImage)
                            <img src="{{ $exImage->temporaryUrl() }}" alt="preview">
                            <div class="small mt-2">click / paste / drop to replace</div>
                        @else
                            <div><i class="mdi mdi-image-plus font-size-24"></i></div>
                            Paste an image (Ctrl/Cmd+V),<br>drop it here, or click to choose
                        @endif
                        <input type="file" class="d-none" id="lz-file" wire:model="exImage" accept="image/jpeg,image/png">
                    </div>
                    <div wire:loading wire:target="exImage" class="text-muted small mb-2">uploading…</div>
                    @error('exImage') <div class="text-danger small mb-2">{{ $message }}</div> @enderror

                    <label class="form-label mb-1">It should be labeled…</label>
                    <input type="text" class="form-control mb-2" wire:model.defer="exDescription"
                           placeholder="e.g. Tree Debris on Driveway">
                    @error('exDescription') <div class="text-danger small mb-2">{{ $message }}</div> @enderror

                    <div class="row g-2">
                        <div class="col-7">
                            <input type="text" class="form-control mb-2" list="cats" wire:model.defer="exCategory"
                                   placeholder="Category">
                            <datalist id="cats">@foreach ($categories as $c)<option>{{ $c }}</option>@endforeach</datalist>
                        </div>
                        <div class="col-5">
                            <input type="text" class="form-control mb-2" wire:model.defer="exJob" placeholder="Job # (opt)">
                        </div>
                    </div>
                    <textarea class="form-control mb-2" rows="2" wire:model.defer="exNote"
                              placeholder="Note — why it was wrong (optional)"></textarea>

                    <button class="btn btn-primary w-100" wire:click="addExample"
                            wire:loading.attr="disabled" wire:target="addExample,exImage">Add example</button>
                    <div class="text-muted small mt-2">Newest 8 are sent to the AI on every job (cached after the first photo).</div>
                </div>
            </div>
        </div>
    @endif

    {{-- ================================================= RULES ================================================= --}}
    @if ($tab === 'rules')
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Add a rule</h5>
                <div class="row g-2">
                    <div class="col-md-3">
                        <label class="form-label">Section</label>
                        <input type="text" class="form-control" list="rule-sections" wire:model.defer="ruleSection">
                        <datalist id="rule-sections">
                            <option>General</option><option>Equipment</option><option>Work vs. cleanup</option>
                            <option>Screen enclosure</option><option>Tarp</option><option>Never</option>
                        </datalist>
                    </div>
                    <div class="col-md-7">
                        <label class="form-label">Rule (one clear sentence)</label>
                        <textarea class="form-control" rows="2" wire:model.defer="ruleBody"
                                  placeholder='e.g. "Crane" only when a tall boom with a cable from above is visible.'></textarea>
                        @error('ruleBody') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100" wire:click="addRule" wire:loading.attr="disabled">Add</button>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($rules as $section => $items)
            <div class="card">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted">{{ $section }}</h6>
                    <table class="table table-sm align-middle mb-0">
                        <tbody>
                        @foreach ($items as $rule)
                            <tr class="{{ $rule->active ? '' : 'text-muted' }}">
                                <td style="width:60px">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input"
                                               {{ $rule->active ? 'checked' : '' }}
                                               wire:click="toggleRule({{ $rule->id }})">
                                    </div>
                                </td>
                                <td>{{ $rule->body }}</td>
                                <td style="width:50px" class="text-end">
                                    <button class="btn btn-sm btn-outline-danger"
                                            wire:click="deleteRule({{ $rule->id }})"
                                            onclick="return confirm('Delete this rule?')">&times;</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif

    {{-- ============================================== VOCABULARY ============================================== --}}
    @if ($tab === 'vocabulary')
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Add a preferred description</h5>
                <div class="row g-2">
                    <div class="col-md-4">
                        <label class="form-label">Category</label>
                        <input type="text" class="form-control" list="vocab-cats" wire:model.defer="vocabCategory">
                        <datalist id="vocab-cats">
                            @foreach ($categories as $c) <option>{{ $c }}</option> @endforeach
                        </datalist>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Description (exactly as it should appear on the photo)</label>
                        <input type="text" class="form-control" wire:model.defer="vocabTerm" placeholder="e.g. Tree Resting on House">
                        @error('vocabTerm') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100" wire:click="addVocab" wire:loading.attr="disabled">Add</button>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($vocab as $category => $terms)
            <div class="card">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted">{{ $category }}</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($terms as $t)
                            <span class="badge bg-light text-dark border p-2 @if(!$t->active) opacity-50 @endif">
                                {{ $t->term }}
                                <a href="javascript:void(0)" class="text-muted ms-1" wire:click="toggleVocab({{ $t->id }})"
                                   title="{{ $t->active ? 'disable' : 'enable' }}">
                                    <i class="mdi mdi-{{ $t->active ? 'eye' : 'eye-off' }}"></i>
                                </a>
                                <a href="javascript:void(0)" class="text-danger ms-1" wire:click="deleteVocab({{ $t->id }})"
                                   onclick="return confirm('Delete?')">&times;</a>
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    {{-- ================================================ BANNED ================================================ --}}
    @if ($tab === 'banned')
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Words the AI must never use</h5>
                <div class="row g-2">
                    <div class="col-md-6">
                        <input type="text" class="form-control" wire:model.defer="bannedTerm" placeholder="e.g. trimmed">
                        @error('bannedTerm') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100" wire:click="addBanned" wire:loading.attr="disabled">Add</button>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-2 mt-3">
                    @foreach ($banned as $b)
                        <span class="badge bg-danger-subtle text-danger border border-danger p-2">
                            {{ $b->term }}
                            <a href="javascript:void(0)" class="text-danger ms-1" wire:click="deleteBanned({{ $b->id }})">&times;</a>
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <script>
        (function () {
            if (window.__lzPasteBound) return;
            window.__lzPasteBound = true;

            function comp() {
                var el = document.getElementById('labeling-admin');
                return el ? window.Livewire.find(el.getAttribute('wire:id')) : null;
            }
            function onExamplesTab() {
                var el = document.getElementById('labeling-admin');
                return el && el.dataset.tab === 'examples';
            }
            function send(file) {
                var c = comp();
                if (file && file.type && file.type.indexOf('image/') === 0 && c) {
                    c.upload('exImage', file, function () {}, function () {}, function () {});
                }
            }

            document.addEventListener('paste', function (e) {
                if (!onExamplesTab()) return;
                var items = (e.clipboardData || {}).items || [];
                for (var i = 0; i < items.length; i++) {
                    if (items[i].type && items[i].type.indexOf('image/') === 0) {
                        send(items[i].getAsFile());
                        break;
                    }
                }
            });

            document.addEventListener('click', function (e) {
                var zone = e.target && e.target.closest ? e.target.closest('#lz-paste') : null;
                if (zone) { var f = document.getElementById('lz-file'); if (f) f.click(); }
            });

            ['dragover', 'dragleave', 'drop'].forEach(function (evt) {
                document.addEventListener(evt, function (e) {
                    var zone = e.target && e.target.closest ? e.target.closest('#lz-paste') : null;
                    if (!zone) return;
                    e.preventDefault();
                    if (evt === 'dragover') zone.classList.add('drag');
                    if (evt === 'dragleave') zone.classList.remove('drag');
                    if (evt === 'drop') {
                        zone.classList.remove('drag');
                        var dt = e.dataTransfer;
                        if (dt && dt.files && dt.files[0]) send(dt.files[0]);
                    }
                });
            });
        })();
    </script>
</div>
