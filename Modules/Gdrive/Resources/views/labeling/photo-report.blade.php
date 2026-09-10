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

        /* letterhead Kruger (logo + mapa da Flórida + rodapé) atrás de tudo */
        #letterhead {
            position: fixed;
            top: 0; left: 0;
            width: 210mm;
            z-index: -1000;
        }

        /* rodapé fixo — repetido em toda página, sem float */
        #foot-l { position: fixed; left: 16mm;  bottom: 13mm; font-size: 8px; color: #8a8a8a; }
        #foot-r { position: fixed; right: 16mm; bottom: 13mm; font-size: 8px; color: #8a8a8a; }
        #foot-r:after { content: counter(page); }

        .page { padding: 92mm 16mm 26mm 16mm; page-break-after: always; }
        .page.last { page-break-after: auto; }

        /* ---- capa ---- */
        h1 { font-size: 23px; letter-spacing: .5px; margin: 0 0 3px 0; text-transform: uppercase; }
        h2 { font-size: 13px; color: #9b1c1c; text-transform: uppercase; margin: 0 0 22px 0; }
        .info td { padding: 4px 0; vertical-align: top; font-size: 12px; }
        .info td.k {
            width: 130px; color: #8a8a8a; text-transform: uppercase;
            font-size: 9px; letter-spacing: .8px; padding-top: 6px;
        }
        .summary { background: #f2f2f2; padding: 13px 15px; font-size: 10px; line-height: 1.5; margin-top: 20px; }
        .summary b {
            display: block; margin-bottom: 4px; text-transform: uppercase;
            letter-spacing: .6px; font-size: 9px; color: #444;
        }
        .tagline { margin-top: 22px; font-size: 8.5px; color: #8a8a8a; text-transform: uppercase; letter-spacing: .6px; }

        /* ---- páginas de fotos ---- */
        .sechead { width: 100%; border-bottom: 2px solid #9b1c1c; margin-bottom: 8px; }
        .sechead td { padding-bottom: 4px; }
        .sechead .name { font-size: 13px; font-weight: bold; text-transform: uppercase; letter-spacing: .5px; }
        .sechead .who { text-align: right; font-size: 8px; color: #8a8a8a; text-transform: uppercase; }

        .grid { width: 100%; }
        .grid td { width: 50%; padding: 0 4px 8px 4px; }
        .frame { background: #ededed; padding: 3px; }
        .frame img { width: 82mm; height: 61.5mm; }
        .cap {
            background: #111; color: #fff; font-weight: bold; font-size: 8.5px;
            text-align: center; padding: 5px 3px; line-height: 1.2;
        }
    </style>
</head>
<body>

<img id="letterhead" src="{{ $letterhead }}" alt="">
<div id="foot-l">{{ $job['address'] }}</div>
<div id="foot-r">Page&nbsp;</div>

{{-- ---------------- CAPA ---------------- --}}
<div class="page">
    <h1>Professional Labeled Photo Report</h1>
    <h2>{{ $job['service_type'] ?: $job['company'] }}</h2>

    <table class="info">
        <tr><td class="k">Customer</td><td>{{ $job['customer_name'] }}</td></tr>
        <tr><td class="k">Job Number</td><td>{{ $job['job_number'] }}</td></tr>
        <tr><td class="k">Service Date</td><td>{{ $job['service_date'] ?: '—' }}</td></tr>
        <tr><td class="k">Property</td><td>{{ $job['address'] }}</td></tr>
        <tr><td class="k">Photo Count</td><td>{{ $job['photo_count'] }} labeled photographs</td></tr>
        @if(!empty($job['sections_line']))
            <tr><td class="k">Sections</td><td>{{ $job['sections_line'] }}</td></tr>
        @endif
    </table>

    <div class="summary">
        <b>Documentation Summary</b>
        {{ $job['summary'] }}
    </div>

    <div class="tagline">
        {{ $job['company'] }} &nbsp;|&nbsp; Job {{ $job['job_number'] }} &nbsp;|&nbsp; Professional Photo Documentation
    </div>
</div>

{{-- ---------------- PÁGINAS DE FOTOS ---------------- --}}
@foreach($pages as $pi => $page)
    <div class="page {{ $pi === count($pages) - 1 ? 'last' : '' }}">
        <table class="sechead">
            <tr>
                <td class="name">{{ $page['section'] }}</td>
                <td class="who">{{ $job['customer_name'] }} &nbsp;|&nbsp; Job {{ $job['job_number'] }}</td>
            </tr>
        </table>

        <table class="grid">
            @foreach(array_chunk($page['photos'], 2) as $pair)
                <tr>
                    @foreach($pair as $photo)
                        <td>
                            <div class="frame"><img src="{{ $photo['src'] }}" alt=""></div>
                            <div class="cap">{{ $photo['caption'] }}</div>
                        </td>
                    @endforeach
                    @if(count($pair) === 1)<td>&nbsp;</td>@endif
                </tr>
            @endforeach
        </table>
    </div>
@endforeach

</body>
</html>
