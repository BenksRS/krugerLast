<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $job['customer_name'] }} ({{ $job['job_number'] }}) - Professional Labeled Photo Report</title>
    <style>
        @page { margin: 0; }

        body {
            margin: 0;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #1f1f1f;
            font-size: 11px;
        }

        /* faixa preta fixa no topo de toda página + filete vermelho */
        #brandbar {
            position: fixed;
            top: 0; left: 0;
            width: 210mm;
            height: 12mm;
            background: #111;
            color: #fff;
            text-align: center;
        }
        #brandbar span {
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 1.5px;
            line-height: 12mm;
        }
        #brandrule {
            position: fixed;
            top: 12mm; left: 0;
            width: 210mm;
            height: 1.6mm;
            background: #c8102e;
        }

        /* rodapé fixo — sem float */
        #foot-l { position: fixed; left: 14mm;  bottom: 8mm; font-size: 8px; color: #8a8a8a; }
        #foot-r { position: fixed; right: 14mm; bottom: 8mm; font-size: 8px; color: #8a8a8a; }
        #foot-r:after { content: counter(page); }
        #footline { position: fixed; left: 14mm; right: 14mm; bottom: 12mm; border-top: 1px solid #e2e2e2; }

        .page { padding: 20mm 14mm 18mm 14mm; page-break-after: always; }
        .page.last { page-break-after: auto; }

        /* ---- capa ---- */
        .cover { text-align: center; padding-top: 78mm; }
        .cover .title { font-size: 27px; font-weight: bold; letter-spacing: 1px; line-height: 1.25; text-transform: uppercase; }
        .cover .rule { width: 55mm; height: 2px; background: #c8102e; margin: 12px auto 26px auto; }
        .cover .cust { font-size: 16px; font-weight: bold; margin-bottom: 10px; }
        .cover .meta { font-size: 12px; color: #555; line-height: 1.7; }
        .cover .svc { font-size: 11px; color: #c8102e; text-transform: uppercase; letter-spacing: .5px; margin-top: 6px; }
        .cover .count { font-size: 9.5px; color: #8a8a8a; margin-top: 26px; }
        .cover .summary {
            text-align: left; background: #f4f4f4; padding: 12px 15px; font-size: 9.5px;
            line-height: 1.55; color: #444; margin: 30mm auto 0 auto; width: 150mm;
        }

        /* ---- páginas de fotos ---- */
        .sechead { width: 100%; border-bottom: 2px solid #c8102e; margin-bottom: 9px; }
        .sechead td { padding-bottom: 4px; }
        .sechead .name { font-size: 13px; font-weight: bold; text-transform: uppercase; letter-spacing: .5px; }
        .sechead .who { text-align: right; font-size: 8px; color: #8a8a8a; text-transform: uppercase; }

        .item { margin-bottom: 6mm; text-align: center; }
        .frame { margin: 0 auto; }
        .frame td { background: #ededed; padding: 4px; }
        .frame img { display: block; }
    </style>
</head>
<body>

<div id="brandbar"><span>{{ $job['company'] }}</span></div>
<div id="brandrule"></div>
<div id="footline"></div>
<div id="foot-l">{{ $job['customer_name'] }} &nbsp;|&nbsp; Job #{{ $job['job_number'] }}</div>
<div id="foot-r">Page&nbsp;</div>

{{-- ---------------- CAPA ---------------- --}}
<div class="page cover">
    <div class="title">Professional<br>Labeled Photo Report</div>
    <div class="rule"></div>

    <div class="cust">{{ $job['customer_name'] }}</div>
    <div class="meta">
        Job #{{ $job['job_number'] }}<br>
        @if(!empty($job['street'])){{ $job['street'] }}<br>@endif
        {{ $job['city_line'] }}
        @if(!empty($job['service_date']))<br>{{ $job['service_date'] }}@endif
    </div>
    @if(!empty($job['service_type']))
        <div class="svc">{{ $job['service_type'] }}</div>
    @endif

    <div class="count">{{ $job['photo_count'] }} labeled photographs</div>

    <div class="summary">{{ $job['summary'] }}</div>
</div>

{{-- ---------------- PÁGINAS DE FOTOS ---------------- --}}
@foreach($pages as $pi => $page)
    <div class="page {{ $pi === count($pages) - 1 ? 'last' : '' }}">
        <table class="sechead">
            <tr>
                <td class="name">{{ $page['section'] }}</td>
                <td class="who">{{ $job['customer_name'] }} &nbsp;|&nbsp; Job #{{ $job['job_number'] }}</td>
            </tr>
        </table>

        @foreach($page['photos'] as $photo)
            <div class="item">
                <table class="frame"><tr><td>
                    <img src="{{ $photo['src'] }}" width="{{ $photo['w'] }}" height="{{ $photo['h'] }}" alt="">
                </td></tr></table>
            </div>
        @endforeach
    </div>
@endforeach

</body>
</html>
