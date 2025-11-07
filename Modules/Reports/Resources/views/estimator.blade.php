<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tree Removal Estimator — v6 (Show Crew Hours per Line)</title>
    <style>
        :root{ --gap:12px; --card:#fff; --ink:#111; --muted:#666; --line:#e5e5e5; --accent:#1e88e5; --bg:#f7f7f9; }
        *{box-sizing:border-box}
        body{margin:0; font:14px/1.4 system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial; color:var(--ink); background:var(--bg)}
        header{position:sticky; top:0; z-index:10; background:#fff; border-bottom:1px solid var(--line); padding:16px}
        header h1{margin:0 0 6px; font-size:20px}
        header .actions{display:flex; gap:8px; flex-wrap:wrap}
        main{padding:16px; display:grid; gap:16px; grid-template-columns: 440px 1fr;}
        @media (max-width:1100px){ main{grid-template-columns:1fr;} }
        .card{background:var(--card); border:1px solid var(--line); border-radius:10px; padding:16px}
        .card h2{margin:0 0 12px; font-size:16px}
        .row{display:grid; grid-template-columns:1fr 1fr; gap:10px}
        .row-3{display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px}
        label{display:block; font-weight:600; font-size:12px; color:var(--muted); margin-bottom:4px}
        input, select{width:100%; padding:8px 10px; border-radius:8px; border:1px solid var(--line); background:#fff; color:var(--ink)}
        input[type="number"]{text-align:right}
        table{width:100%; border-collapse:collapse; font-size:13px}
        th, td{border-bottom:1px solid var(--line); padding:6px; vertical-align:middle}
        th{background:#fbfbfb; text-align:left; position:sticky; top:0}
        tfoot td{font-weight:700}
        .btn{background:var(--accent); color:#fff; border:none; border-radius:8px; padding:10px 12px; font-weight:700; cursor:pointer}
        .btn.secondary{background:#eee; color:#222}
        .btn.danger{background:#e53935}
        .btn.ghost{background:transparent; border:1px solid var(--line)}
        .pill{font-size:12px; border:1px solid var(--line); padding:4px 8px; border-radius:999px; background:#fff; color:#333}
        .muted{color:var(--muted)}
        .money{font-variant-numeric:tabular-nums}
        .mono{font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;}
        .right{text-align:right}
        .nowrap{white-space:nowrap}
        .estimate{background:#fff; border:1px dashed var(--line); border-radius:10px; padding:16px}
        @media print{ header,.no-print{display:none !important}; body{background:#fff} .estimate{border:none; padding:0} }
    </style>
</head>
<body>
<header>
    <h1>Tree Removal Estimator (v6)</h1>
    <div class="actions">
        <button class="btn" id="btnAddTree">+ Add Tree</button>
        <button class="btn secondary" id="btnImport">Import JSON</button>
        <button class="btn ghost" id="btnExport">Export JSON</button>
        <button class="btn ghost" id="btnSave">Save to Browser</button>
        <button class="btn ghost" id="btnLoad">Load from Browser</button>
        <button class="btn" id="btnPrint">Print Estimate</button>
    </div>
</header>

<main>
    <section class="card" id="panelConfig">
        <h2>Config</h2>
        <div class="row">
            <div><label>Currency</label><input id="cfgCurrency" value="$"></div>
            <div><label>Permit/Admin fee</label><input type="number" step="0.01" id="cfgPermit" value="75"></div>
        </div>
        <div class="row">
            <div><label>Crew hourly rate (per person)</label><input type="number" step="0.01" id="cfgCrewRate" value="65"></div>
            <div><label>Crew size</label><input type="number" id="cfgCrewSize" value="3"></div>
        </div>
        <div class="row">
            <div><label>Crane hourly rate</label><input type="number" step="0.01" id="cfgCraneRate" value="425"></div>
            <div><label>Mini skid steer hourly rate</label><input type="number" step="0.01" id="cfgMiniRate" value="95"></div>
        </div>
        <div class="row">
            <div><label>Chipper hourly rate</label><input type="number" step="0.01" id="cfgChipperRate" value="85"></div>
            <div><label>Travel rate per mile</label><input type="number" step="0.01" id="cfgTravelRate" value="2"></div>
        </div>

        <div class="row">
            <div><label>Dump fee per ton</label><input type="number" step="0.01" id="cfgDumpFeeTon" value="95"></div>
            <div><label>Stump grind per inch</label><input type="number" step="0.01" id="cfgStumpPerIn" value="8"></div>
        </div>

        <div class="row">
            <div><label>Overhead %</label><input type="number" step="0.01" id="cfgOverheadPct" value="12"></div>
            <div><label>Profit %</label><input type="number" step="0.01" id="cfgProfitPct" value="18"></div>
        </div>
        <div class="row">
            <div><label>Emergency/Weekend %</label><input type="number" step="0.01" id="cfgEmergencyPct" value="0"></div>
            <div></div>
        </div>

        <h2 style="margin-top:14px">Species Factors</h2>
        <p class="muted" style="margin-top:-6px">Set default <strong>yd³ per inch DBH</strong> and <strong>tons per yd³</strong>.</p>
        <div class="row">
            <div><label>Palm — yd³/in</label><input type="number" step="0.0001" id="fPalmVol" value="0.22"></div>
            <div><label>Palm — tons/yd³</label><input type="number" step="0.0001" id="fPalmTon" value="0.12"></div>
        </div>
        <div class="row">
            <div><label>Live Oak — yd³/in</label><input type="number" step="0.0001" id="fLiveOakVol" value="0.38"></div>
            <div><label>Live Oak — tons/yd³</label><input type="number" step="0.0001" id="fLiveOakTon" value="0.30"></div>
        </div>
        <div class="row">
            <div><label>Water Oak — yd³/in</label><input type="number" step="0.0001" id="fWaterOakVol" value="0.33"></div>
            <div><label>Water Oak — tons/yd³</label><input type="number" step="0.0001" id="fWaterOakTon" value="0.26"></div>
        </div>
        <div class="row">
            <div><label>Pine — yd³/in</label><input type="number" step="0.0001" id="fPineVol" value="0.28"></div>
            <div><label>Pine — tons/yd³</label><input type="number" step="0.0001" id="fPineTon" value="0.17"></div>
        </div>
        <div class="row">
            <div><label>Maple — yd³/in</label><input type="number" step="0.0001" id="fMapleVol" value="0.32"></div>
            <div><label>Maple — tons/yd³</label><input type="number" step="0.0001" id="fMapleTon" value="0.20"></div>
        </div>
        <div class="row">
            <div><label>Cypress — yd³/in</label><input type="number" step="0.0001" id="fCypressVol" value="0.30"></div>
            <div><label>Cypress — tons/yd³</label><input type="number" step="0.0001" id="fCypressTon" value="0.23"></div>
        </div>
        <div class="row">
            <div><label>Eucalyptus — yd³/in</label><input type="number" step="0.0001" id="fEucaVol" value="0.36"></div>
            <div><label>Eucalyptus — tons/yd³</label><input type="number" step="0.0001" id="fEucaTon" value="0.32"></div>
        </div>
        <div class="row">
            <div><label>Other — yd³/in</label><input type="number" step="0.0001" id="fOtherVol" value="0.35"></div>
            <div><label>Other — tons/yd³</label><input type="number" step="0.0001" id="fOtherTon" value="0.20"></div>
        </div>

        <h2 style="margin-top:14px">Base crew-hours by DBH</h2>
        <div class="row-3">
            <div><label>Small (≤12")</label><input type="number" step="0.01" id="bhSmall" value="1.5"></div>
            <div><label>Medium (13–24")</label><input type="number" step="0.01" id="bhMed" value="3.0"></div>
            <div><label>Large (25–36")</label><input type="number" step="0.01" id="bhLarge" value="5.0"></div>
        </div>
        <div class="row-3">
            <div><label>XL (37–48")</label><input type="number" step="0.01" id="bhXL" value="7.5"></div>
            <div><label>XXL (49"+)</label><input type="number" step="0.01" id="bhXXL" value="10.0"></div>
            <div></div>
        </div>

        <h2 style="margin-top:14px">Multipliers</h2>
        <div class="row-3">
            <div><label>Complexity Easy</label><input type="number" step="0.01" id="mCompEasy" value="1.0"></div>
            <div><label>Medium</label><input type="number" step="0.01" id="mCompMed" value="1.3"></div>
            <div><label>Climb+Rig</label><input type="number" step="0.01" id="mCompRig" value="1.8"></div>
        </div>
        <div class="row-3">
            <div><label>Access Good</label><input type="number" step="0.01" id="mAccGood" value="1.0"></div>
            <div><label>Tight</label><input type="number" step="0.01" id="mAccTight" value="1.2"></div>
            <div><label>Backyard</label><input type="number" step="0.01" id="mAccBack" value="1.4"></div>
        </div>
        <div class="row-3">
            <div><label>Hazard None</label><input type="number" step="0.01" id="mHazNone" value="1.0"></div>
            <div><label>Power lines/roof</label><input type="number" step="0.01" id="mHazUtil" value="1.3"></div>
            <div><label>Condition Dead</label><input type="number" step="0.01" id="mCondDead" value="1.2"></div>
        </div>

        <h2 style="margin-top:14px">Height Factor (crew-hours)</h2>
        <div class="row-3">
            <div><label>≤ 30 ft</label><input type="number" step="0.01" id="h30" value="0.90"></div>
            <div><label>31–60 ft</label><input type="number" step="0.01" id="h60" value="1.00"></div>
            <div><label>61–80 ft</label><input type="number" step="0.01" id="h80" value="1.15"></div>
        </div>
        <div class="row-3">
            <div><label>81–100 ft</label><input type="number" step="0.01" id="h100" value="1.30"></div>
            <div><label>&gt; 100 ft</label><input type="number" step="0.01" id="h101" value="1.50"></div>
            <div></div>
        </div>
    </section>

    <section class="card">
        <h2>Trees (Species + Circumference → DBH)</h2>
        <div class="pill no-print">Now showing crew-hours per line: <b>unit × qty = total</b>.</div>
        <div style="overflow:auto; max-height:60vh; margin-top:8px">
            <table id="treeTable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Species</th>
                    <th class="nowrap">Circumf. (in)</th>
                    <th class="nowrap">DBH (in)</th>
                    <th>Height (ft)</th>
                    <th>Qty</th>
                    <th>Complexity</th>
                    <th>Access</th>
                    <th>Hazard</th>
                    <th>Cond.</th>
                    <th>Chipper?</th>
                    <th>Mini?</th>
                    <th>Crane?</th>
                    <th class="nowrap">Crane hrs</th>
                    <th class="nowrap">Miles</th>
                    <th class="nowrap">Haul debris?</th>
                    <th class="nowrap">Stump?</th>
                    <th class="nowrap">Stump in</th>
                    <th class="nowrap">Crew hrs (unit × qty = total)</th>
                    <th class="right nowrap">Line total</th>
                    <th></th>
                </tr>
                </thead>
                <tbody id="treeBody"></tbody>
                <tfoot>
                <tr>
                    <td colspan="19" class="right">Line items total</td>
                    <td class="right money" id="lineItemsTotal">$0.00</td>
                    <td></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </section>

    <section class="card">
        <h2>Estimate</h2>
        <div class="row">
            <div><label>Client name</label><input id="clientName"></div>
            <div><label>Prepared by</label><input id="preparedBy"></div>
        </div>
        <div class="row">
            <div><label>Address</label><input id="clientAddress"></div>
            <div><label>City/State/ZIP</label><input id="clientCity"></div>
        </div>

        <div class="estimate">
            <div class="row">
                <div><div class="muted">Line items total</div><div class="money" id="sumLines">$0.00</div></div>
                <div class="right"><div class="muted">Permit/Admin</div><div class="money" id="permitFee">$0.00</div></div>
            </div>
            <hr>
            <div class="row">
                <div><div class="muted">Overhead %</div><div class="money" id="ohPct">12%</div></div>
                <div class="right"><div class="muted">Overhead amount</div><div class="money" id="ohAmt">$0.00</div></div>
            </div>
            <div class="row">
                <div><div class="muted">Subtotal</div><div class="money" id="subtotal">$0.00</div></div>
                <div class="right"><div class="muted">Profit %</div><div class="money" id="pfPct">18%</div></div>
            </div>
            <div class="row">
                <div><div class="muted">Profit amount</div><div class="money" id="pfAmt">$0.00</div></div>
                <div class="right"><div class="muted">Emergency/Weekend %</div><div class="money" id="emPct">0%</div></div>
            </div>
            <div class="row">
                <div><div class="muted">Emergency surcharge</div><div class="money" id="emAmt">$0.00</div></div>
                <div class="right"><div class="muted"><strong>TOTAL ESTIMATE</strong></div><div class="money" id="grandTotal" style="font-weight:800; font-size:18px">$0.00</div></div>
            </div>
        </div>

        <div class="row" style="margin-top:8px">
            <div class="muted">Per-tree breakdown</div>
        </div>
        <div id="breakdown"></div>
    </section>
</main>

<script>
    const $ = (s)=>document.querySelector(s);
    const $$ = (s)=>Array.from(document.querySelectorAll(s));

    // Species defaults
    const speciesDefs = {
        "Palm": {volPerIn:0.22, tonPerYd3:0.12},
        "Live Oak": {volPerIn:0.38, tonPerYd3:0.30},
        "Water Oak": {volPerIn:0.33, tonPerYd3:0.26},
        "Pine": {volPerIn:0.28, tonPerYd3:0.17},
        "Maple": {volPerIn:0.32, tonPerYd3:0.20},
        "Cypress": {volPerIn:0.30, tonPerYd3:0.23},
        "Eucalyptus": {volPerIn:0.36, tonPerYd3:0.32},
        "Other": {volPerIn:0.35, tonPerYd3:0.20}
    };

    const cfg = {
        currency:"$",
        permit:75,
        crewRate:65,
        crewSize:3,
        craneRate:425,
        miniRate:95,
        chipperRate:85,
        travelRate:2,
        dumpFeeTon:95,
        stumpPerIn:8,
        overheadPct:12,
        profitPct:18,
        emergencyPct:0,
        // multipliers
        mComp:{Easy:1.0, Medium:1.3, "Climb+Rig":1.8},
        mAcc:{Good:1.0, Tight:1.2, Backyard:1.4},
        mHaz:{"None":1.0, "Power lines/roof":1.3},
        mCond:{Alive:1.0, Dead:1.2},
        // base hours by DBH
        bh:{small:1.5, med:3.0, large:5.0, xl:7.5, xxl:10.0},
        // species factors
        species: JSON.parse(JSON.stringify(speciesDefs)),
        // height factors
        hFactor:{ h30:0.90, h60:1.00, h80:1.15, h100:1.30, h101:1.50 }
    };

    function bindCfg(){
        $("#cfgCurrency").addEventListener("input", e=>{cfg.currency=e.target.value||"$"; refresh()})
        $("#cfgPermit").addEventListener("input", e=>{cfg.permit=+e.target.value||0; refresh()})
        $("#cfgCrewRate").addEventListener("input", e=>{cfg.crewRate=+e.target.value||0; refresh()})
        $("#cfgCrewSize").addEventListener("input", e=>{cfg.crewSize=+e.target.value||0; refresh()})
        $("#cfgCraneRate").addEventListener("input", e=>{cfg.craneRate=+e.target.value||0; refresh()})
        $("#cfgMiniRate").addEventListener("input", e=>{cfg.miniRate=+e.target.value||0; refresh()})
        $("#cfgChipperRate").addEventListener("input", e=>{cfg.chipperRate=+e.target.value||0; refresh()})
        $("#cfgTravelRate").addEventListener("input", e=>{cfg.travelRate=+e.target.value||0; refresh()})
        $("#cfgDumpFeeTon").addEventListener("input", e=>{cfg.dumpFeeTon=+e.target.value||0; refresh()})
        $("#cfgStumpPerIn").addEventListener("input", e=>{cfg.stumpPerIn=+e.target.value||0; refresh()})
        $("#cfgOverheadPct").addEventListener("input", e=>{cfg.overheadPct=+e.target.value||0; refresh()})
        $("#cfgProfitPct").addEventListener("input", e=>{cfg.profitPct=+e.target.value||0; refresh()})
        $("#cfgEmergencyPct").addEventListener("input", e=>{cfg.emergencyPct=+e.target.value||0; refresh()})

        // species factor inputs
        const map = [
            ["Palm","fPalmVol","fPalmTon"],
            ["Live Oak","fLiveOakVol","fLiveOakTon"],
            ["Water Oak","fWaterOakVol","fWaterOakTon"],
            ["Pine","fPineVol","fPineTon"],
            ["Maple","fMapleVol","fMapleTon"],
            ["Cypress","fCypressVol","fCypressTon"],
            ["Eucalyptus","fEucaVol","fEucaTon"],
            ["Other","fOtherVol","fOtherTon"]
        ];
        map.forEach(([name, vid, tid])=>{
            $("#"+vid).addEventListener("input", e=>{cfg.species[name].volPerIn=+e.target.value||0; refresh()})
            $("#"+tid).addEventListener("input", e=>{cfg.species[name].tonPerYd3=+e.target.value||0; refresh()})
        });
        // multipliers and base hours
        $("#mCompEasy").addEventListener("input", e=>{cfg.mComp["Easy"]=+e.target.value||1; refresh()})
        $("#mCompMed").addEventListener("input", e=>{cfg.mComp["Medium"]=+e.target.value||1; refresh()})
        $("#mCompRig").addEventListener("input", e=>{cfg.mComp["Climb+Rig"]=+e.target.value||1; refresh()})
        $("#mAccGood").addEventListener("input", e=>{cfg.mAcc["Good"]=+e.target.value||1; refresh()})
        $("#mAccTight").addEventListener("input", e=>{cfg.mAcc["Tight"]=+e.target.value||1; refresh()})
        $("#mAccBack").addEventListener("input", e=>{cfg.mAcc["Backyard"]=+e.target.value||1; refresh()})
        $("#mHazNone").addEventListener("input", e=>{cfg.mHaz["None"]=+e.target.value||1; refresh()})
        $("#mHazUtil").addEventListener("input", e=>{cfg.mHaz["Power lines/roof"]=+e.target.value||1; refresh()})
        $("#mCondDead").addEventListener("input", e=>{cfg.mCond["Dead"]=+e.target.value||1; refresh()})
        $("#bhSmall").addEventListener("input", e=>{cfg.bh.small=+e.target.value||0; refresh()})
        $("#bhMed").addEventListener("input", e=>{cfg.bh.med=+e.target.value||0; refresh()})
        $("#bhLarge").addEventListener("input", e=>{cfg.bh.large=+e.target.value||0; refresh()})
        $("#bhXL").addEventListener("input", e=>{cfg.bh.xl=+e.target.value||0; refresh()})
        $("#bhXXL").addEventListener("input", e=>{cfg.bh.xxl=+e.target.value||0; refresh()})
        // height factors
        $("#h30").addEventListener("input", e=>{cfg.hFactor.h30=+e.target.value||1; refresh()})
        $("#h60").addEventListener("input", e=>{cfg.hFactor.h60=+e.target.value||1; refresh()})
        $("#h80").addEventListener("input", e=>{cfg.hFactor.h80=+e.target.value||1; refresh()})
        $("#h100").addEventListener("input", e=>{cfg.hFactor.h100=+e.target.value||1; refresh()})
        $("#h101").addEventListener("input", e=>{cfg.hFactor.h101=+e.target.value||1; refresh()})
    }

    const trees = [];

    function speciesOptions(selected){
        return Object.keys(cfg.species).map(s=>`<option ${s===selected?'selected':''}>${s}</option>`).join("");
    }
    function choice(opts, value){
        return opts.map(o=>`<option ${o===value?'selected':''}>${o}</option>`).join("");
    }

    function addTreeRow(data={}){
        const row = {
            species: data.species || "Live Oak",
            circ: data.circ || "",
            dbh: "",
            height: data.height || "",
            qty: data.qty || 1,
            complexity: data.complexity || "Easy",
            access: data.access || "Good",
            hazard: data.hazard || "None",
            condition: data.condition || "Alive",
            chipper: data.chipper || "Yes",
            mini: data.mini || "Yes",
            crane: data.crane || "No",
            craneHours: data.craneHours || "",
            miles: data.miles || "",
            haul: data.haul || "Yes",
            stump: data.stump || "No",
            stumpIn: data.stumpIn || ""
        };
        trees.push(row);
        renderTreeTable();
    }

    function removeTree(i){ trees.splice(i,1); renderTreeTable(); }

    function renderTreeTable(){
        const body = $("#treeBody");
        body.innerHTML = "";
        trees.forEach((t,i)=>{
            const tr = document.createElement("tr");
            tr.innerHTML = `
      <td class="mono">${i+1}</td>
      <td><select data-i="${i}" data-k="species">${speciesOptions(t.species)}</select></td>
      <td><input type="number" step="0.1" value="${t.circ}" data-i="${i}" data-k="circ" placeholder="in"></td>
      <td class="mono" id="dbh-${i}">-</td>
      <td><input type="number" step="1" value="${t.height}" data-i="${i}" data-k="height" placeholder="ft"></td>
      <td><input type="number" step="1" value="${t.qty}" data-i="${i}" data-k="qty" placeholder="1"></td>
      <td><select data-i="${i}" data-k="complexity">${choice(["Easy","Medium","Climb+Rig"], t.complexity)}</select></td>
      <td><select data-i="${i}" data-k="access">${choice(["Good","Tight","Backyard"], t.access)}</select></td>
      <td><select data-i="${i}" data-k="hazard">${choice(["None","Power lines/roof"], t.hazard)}</select></td>
      <td><select data-i="${i}" data-k="condition">${choice(["Alive","Dead"], t.condition)}</select></td>
      <td><select data-i="${i}" data-k="chipper">${choice(["Yes","No"], t.chipper)}</select></td>
      <td><select data-i="${i}" data-k="mini">${choice(["Yes","No"], t.mini)}</select></td>
      <td><select data-i="${i}" data-k="crane">${choice(["No","Yes"], t.crane)}</select></td>
      <td><input type="number" step="0.1" value="${t.craneHours}" data-i="${i}" data-k="craneHours"></td>
      <td><input type="number" step="0.1" value="${t.miles}" data-i="${i}" data-k="miles"></td>
      <td><select data-i="${i}" data-k="haul">${choice(["Yes","No"], t.haul)}</select></td>
      <td><select data-i="${i}" data-k="stump">${choice(["No","Yes"], t.stump)}</select></td>
      <td><input type="number" step="0.1" value="${t.stumpIn}" data-i="${i}" data-k="stumpIn"></td>
      <td class="mono nowrap" id="hrs-${i}">-</td>
      <td class="right money mono" id="line-${i}">$0.00</td>
      <td><button class="btn danger" onclick="removeTree(${i})">✕</button></td>
    `;
            body.appendChild(tr);
        });
        $$('tbody input, tbody select').forEach(el=>{
            el.addEventListener('input', e=>{
                const i = +e.target.getAttribute('data-i');
                const k = e.target.getAttribute('data-k');
                trees[i][k] = e.target.value;
                refresh();
            });
        });
        refresh();
    }

    function num(x){ const n=parseFloat(x); return isFinite(n)?n:0 }
    function money(n){ return cfg.currency + (Math.round(n*100)/100).toLocaleString(undefined,{minimumFractionDigits:2, maximumFractionDigits:2}) }

    function baseHours(dbh){
        if (dbh<=0) return 0;
        if (dbh<=12) return cfg.bh.small;
        if (dbh<=24) return cfg.bh.med;
        if (dbh<=36) return cfg.bh.large;
        if (dbh<=48) return cfg.bh.xl;
        return cfg.bh.xxl;
    }
    function heightFactor(h){
        if (h<=0) return 1;
        if (h<=30) return cfg.hFactor.h30;
        if (h<=60) return cfg.hFactor.h60;
        if (h<=80) return cfg.hFactor.h80;
        if (h<=100) return cfg.hFactor.h100;
        return cfg.hFactor.h101;
    }

    function calcTree(t){
        const circ = num(t.circ);
        const dbh = circ>0 ? (circ/Math.PI) : 0;
        const h = num(t.height);
        const qty = Math.max(1, Math.floor(num(t.qty)||1));

        const factors = cfg.species[t.species] || cfg.species["Other"];
        const volUnit = dbh * (factors.volPerIn||0); // yd3 per tree
        const tonsUnit = volUnit * (factors.tonPerYd3||0); // tons per tree
        const volTotal = volUnit * qty;
        const tonsTotal = tonsUnit * qty;

        // Crew hours per tree
        const bh = baseHours(dbh);
        const mComp = cfg.mComp[t.complexity] || 1;
        const mAcc = cfg.mAcc[t.access] || 1;
        const mHaz = cfg.mHaz[t.hazard] || 1;
        const mCond = (t.condition==="Dead") ? (cfg.mCond.Dead||1) : 1;
        const hF = heightFactor(h);
        const crewHoursUnit = bh * mComp * mAcc * mHaz * mCond * hF;
        const crewHoursTotal = crewHoursUnit * qty;

        const crewLaborUnit = crewHoursUnit * cfg.crewSize * cfg.crewRate;
        const equipRate = (t.mini==="Yes"?cfg.miniRate:0) + (t.chipper==="Yes"?cfg.chipperRate:0);
        const equipUnit = crewHoursUnit * equipRate;

        const dumpTotal = (t.haul==="Yes") ? (tonsTotal * cfg.dumpFeeTon) : 0; // all trees
        const travelOnce = num(t.miles) * cfg.travelRate;

        const craneUnit = (t.crane==="Yes") ? num(t.craneHours) * cfg.craneRate : 0;
        const stumpUnit = (t.stump==="Yes") ? num(t.stumpIn) * cfg.stumpPerIn : 0;

        const line = travelOnce + qty * (crewLaborUnit + equipUnit + craneUnit + stumpUnit) + dumpTotal;

        return {
            circ, dbh, h, qty,
            volUnit, tonsUnit, volTotal, tonsTotal,
            crewHoursUnit, crewHoursTotal,
            equipRate, equipUnit,
            dumpTotal, travelOnce, craneUnit, stumpUnit,
            line, hF
        };
    }

    function refresh(){
        let sum=0;
        trees.forEach((t,i)=>{
            const c = calcTree(t);
            const dbhCell = $("#dbh-"+i);
            if (dbhCell) dbhCell.textContent = c.dbh ? c.dbh.toFixed(1) : "-";
            const hrsCell = $("#hrs-"+i);
            if (hrsCell) hrsCell.textContent = c.crewHoursUnit ? `${c.crewHoursUnit.toFixed(2)} × ${c.qty} = ${c.crewHoursTotal.toFixed(2)} h` : "-";
            const lineCell = $("#line-"+i);
            if (lineCell) lineCell.textContent = money(c.line);
            sum += c.line;
        });
        $("#lineItemsTotal").textContent = money(sum);
        $("#sumLines").textContent = money(sum);

        const permit = cfg.permit;
        const overhead = (sum + permit) * (cfg.overheadPct/100);
        const subtotal = sum + permit + overhead;
        const profitAmt = subtotal * (cfg.profitPct/100);
        const emergencyAmt = subtotal * (cfg.emergencyPct/100);
        const total = subtotal + profitAmt + emergencyAmt;

        $("#permitFee").textContent = money(permit);
        $("#ohPct").textContent = (cfg.overheadPct||0) + "%";
        $("#ohAmt").textContent = money(overhead);
        $("#subtotal").textContent = money(subtotal);
        $("#pfPct").textContent = (cfg.profitPct||0) + "%";
        $("#pfAmt").textContent = money(profitAmt);
        $("#emPct").textContent = (cfg.emergencyPct||0) + "%";
        $("#emAmt").textContent = money(emergencyAmt);
        $("#grandTotal").textContent = money(total);

        const bk = $("#breakdown");
        bk.innerHTML = "";
        trees.forEach((t,i)=>{
            const c = calcTree(t);
            const div = document.createElement("div");
            div.style.borderBottom = "1px solid var(--line)";
            div.style.padding = "6px 0";
            div.innerHTML = `
      <div><strong>Tree ${i+1}</strong> — ${t.species} • Qty ${c.qty} • (Circ: ${t.circ||"-"}", DBH: ${c.dbh?c.dbh.toFixed(1):"-"}", H: ${c.h||"-"} ft)</div>
      <div class="muted mono">
        CREW: ${c.crewHoursUnit.toFixed(2)} h × ${c.qty} = ${c.crewHoursTotal.toFixed(2)} h • h-factor: ${c.hF.toFixed(2)} • equipRate/hr: ${money(c.equipRate)}
        • dump total: ${money(c.dumpTotal)} • travel: ${money(c.travelOnce)}
      </div>
      <div class="money">${money(c.line)}</div>
    `;
            bk.appendChild(div);
        });
    }

    // Save / Load / Export / Import / Print
    function snapshot(){
        return {
            cfg,
            trees,
            client:{
                name: $("#clientName").value,
                address: $("#clientAddress").value,
                city: $("#clientCity").value,
                by: $("#preparedBy").value
            }
        };
    }
    function restore(snap){
        if(!snap) return;
        Object.assign(cfg, snap.cfg||{});

        // Species inputs
        $("#fPalmVol").value = cfg.species["Palm"].volPerIn; $("#fPalmTon").value = cfg.species["Palm"].tonPerYd3;
        $("#fLiveOakVol").value = cfg.species["Live Oak"].volPerIn; $("#fLiveOakTon").value = cfg.species["Live Oak"].tonPerYd3;
        $("#fWaterOakVol").value = cfg.species["Water Oak"].volPerIn; $("#fWaterOakTon").value = cfg.species["Water Oak"].tonPerYd3;
        $("#fPineVol").value = cfg.species["Pine"].volPerIn; $("#fPineTon").value = cfg.species["Pine"].tonPerYd3;
        $("#fMapleVol").value = cfg.species["Maple"].volPerIn; $("#fMapleTon").value = cfg.species["Maple"].tonPerYd3;
        $("#fCypressVol").value = cfg.species["Cypress"].volPerIn; $("#fCypressTon").value = cfg.species["Cypress"].tonPerYd3;
        $("#fEucaVol").value = cfg.species["Eucalyptus"].volPerIn; $("#fEucaTon").value = cfg.species["Eucalyptus"].tonPerYd3;
        $("#fOtherVol").value = cfg.species["Other"].volPerIn; $("#fOtherTon").value = cfg.species["Other"].tonPerYd3;

        // Basic config
        $("#cfgCurrency").value = cfg.currency; $("#cfgPermit").value = cfg.permit;
        $("#cfgCrewRate").value = cfg.crewRate; $("#cfgCrewSize").value = cfg.crewSize;
        $("#cfgCraneRate").value = cfg.craneRate; $("#cfgMiniRate").value = cfg.miniRate;
        $("#cfgChipperRate").value = cfg.chipperRate; $("#cfgTravelRate").value = cfg.travelRate;
        $("#cfgDumpFeeTon").value = cfg.dumpFeeTon; $("#cfgStumpPerIn").value = cfg.stumpPerIn;
        $("#cfgOverheadPct").value = cfg.overheadPct; $("#cfgProfitPct").value = cfg.profitPct; $("#cfgEmergencyPct").value = cfg.emergencyPct;

        // Multipliers & base hours
        $("#mCompEasy").value = cfg.mComp["Easy"]; $("#mCompMed").value = cfg.mComp["Medium"]; $("#mCompRig").value = cfg.mComp["Climb+Rig"];
        $("#mAccGood").value = cfg.mAcc["Good"]; $("#mAccTight").value = cfg.mAcc["Tight"]; $("#mAccBack").value = cfg.mAcc["Backyard"];
        $("#mHazNone").value = cfg.mHaz["None"]; $("#mHazUtil").value = cfg.mHaz["Power lines/roof"]; $("#mCondDead").value = cfg.mCond["Dead"];
        $("#bhSmall").value = cfg.bh.small; $("#bhMed").value = cfg.bh.med; $("#bhLarge").value = cfg.bh.large; $("#bhXL").value = cfg.bh.xl; $("#bhXXL").value = cfg.bh.xxl;

        // Height factors
        $("#h30").value = cfg.hFactor.h30; $("#h60").value = cfg.hFactor.h60; $("#h80").value = cfg.hFactor.h80; $("#h100").value = cfg.hFactor.h100; $("#h101").value = cfg.hFactor.h101;

        // Client
        $("#clientName").value = (snap.client && snap.client.name) || "";
        $("#clientAddress").value = (snap.client && snap.client.address) || "";
        $("#clientCity").value = (snap.client && snap.client.city) || "";
        $("#preparedBy").value = (snap.client && snap.client.by) || "";

        // Trees
        trees.splice(0, trees.length, ...(snap.trees||[]));
        renderTreeTable();
    }

    function download(filename, text){
        const blob = new Blob([text], {type:'application/json'});
        const a = document.createElement('a');
        a.href = URL.createObjectURL(blob);
        a.download = filename;
        a.click();
        URL.revokeObjectURL(a.href);
    }
    function uploadJSON(cb){
        const inp = document.createElement('input');
        inp.type='file'; inp.accept='application/json';
        inp.onchange=()=>{
            const f=inp.files[0]; if(!f) return;
            const reader=new FileReader();
            reader.onload=()=>cb(reader.result);
            reader.readAsText(f);
        };
        inp.click();
    }
    function printEstimate(){ window.print() }

    // Buttons
    $("#btnAddTree").addEventListener("click", ()=> addTreeRow({}));
    $("#btnExport").addEventListener("click", ()=> download("tree_estimate_v6.json", JSON.stringify(snapshot(), null, 2)));
    $("#btnImport").addEventListener("click", ()=> uploadJSON(txt=> restore(JSON.parse(txt))));
    $("#btnSave").addEventListener("click", ()=>{ localStorage.setItem("treeEstimatorV6", JSON.stringify(snapshot())); alert("Saved to this browser."); });
    $("#btnLoad").addEventListener("click", ()=>{ const j=localStorage.getItem("treeEstimatorV6"); if(j) restore(JSON.parse(j)); else alert("Nothing saved yet."); });
    $("#btnPrint").addEventListener("click", printEstimate);

    // Init
    bindCfg();
    addTreeRow({species:"Live Oak", circ:56.5, height:60, qty:2, complexity:"Medium", access:"Tight", chipper:"Yes", mini:"Yes", haul:"Yes"});
    addTreeRow({species:"Palm", circ:37.7, height:30, qty:3, complexity:"Easy", access:"Good", condition:"Dead", stump:"Yes", stumpIn:12, chipper:"No", mini:"Yes", haul:"No"});
</script>
</body>
</html>
