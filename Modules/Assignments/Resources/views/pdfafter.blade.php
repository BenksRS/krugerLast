<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        /**
        * Set the margins of the PDF to 0
        * so the background image will cover the entire page.
        **/
        @page {
            margin: 0cm 0cm;
        }

        /**
        * Define the real margins of the content of your PDF
        * Here you will fix the margins of the header and footer
        * Of your background image.
        **/
        body {
            margin-top:    3.5cm;
            margin-bottom: 1cm;
            margin-left:   1cm;
            margin-right:  1cm;

            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        /**
        * Define the width, height, margins and position of the watermark.
        **/
        #watermark {
            position: fixed;
            bottom:   0px;
            left:     0px;
            /** The width and height may change
                according to the dimensions of your letterhead
            **/
            width:    21.8cm;
            height:   28cm;

            /** Your watermark should be behind every content**/
            z-index:  -1000;
        }
        .page_break { page-break-before: always; }
    </style>
    <title>{{'After & Before - '.$data->last_name.' '.$data->first_name}}</title>
</head>
<body>


<?php

$countBefore=0;
$countBeforegeral=0;
$countImageBefore=0;
$pics_before =\Modules\Assignments\Entities\Gallery::where([
    'assignment_id' => $data->id,
    'type' => 'pics_after'
])->get();
?>


<div id="watermark">

</div>
<main>

    <div class="card-header">

    </div>



    <div class="card-body">

        @foreach($pics_before as $pic_after)
            <?php
if($countBeforegeral < 48){
            if($countBefore == 8){
                $countBefore=0;
                ?>
    </div>

</main>

<div class="page_break"></div>

                <div id="watermark">

                </div>
                <main>

                    <div class="card-header">

                    </div>

                 <?php
            }
            switch ($countBefore){
            case 0:

            ?>
            <div style="font-size: 12px; position: fixed;left:20mm; top:25mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_after->b64}}" />
            </div>

            <?php
            break;
            case 1:
            ?>
            <div style="font-size: 12px; position: fixed;left:105mm; top:25mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_after->b64}}" />
            </div>
            <?php

            break;
            case 2:
            ?>

            <div style="font-size: 12px; position: fixed;left:20mm; top:90mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_after->b64}}" />
            </div>
            <?php

            break;
            case 3:
            ?>
            <div style="font-size: 12px; position: fixed;left:105mm; top:90mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_after->b64}}" />
            </div>
            <?php

            break;
            case 4:
            ?>
            <div style="font-size: 12px; position: fixed;left:20mm; top:155mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_after->b64}}" />
            </div>
            <?php

            break;
            case 5:
            ?>
            <div style="font-size: 12px; position: fixed;left:105mm; top:155mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_after->b64}}" />
            </div>
            <?php

            break;
            case 6:
            ?>
            <div style="font-size: 12px; position: fixed;left:20mm; top:220mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_after->b64}}" />
            </div>
            <?php

            break;
            case 7:
            ?>
            <div style="font-size: 12px; position: fixed;left:105mm; top:220mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_after->b64}}" />
            </div>
            <?php

            break;
            }
                $countBefore++;
                $countBeforegeral++;
            $countImageBefore++;
            }
            ?>
        @endforeach
    </div>

</main>



</body>
</html>