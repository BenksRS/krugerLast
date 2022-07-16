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
//foreach ($pages as $page){
?>

{{--<span style="font-size: 22px; position: fixed;left:10mm; top:15mm; z-index:  -1000;">Pictures <strong>Front</strong> of the house or mail box: ()</span>--}}
<?php
$data_scheduled=date('m/d/Y', strtotime($data->start_date));

$countFront=0;
$pics_front_house=\Modules\Assignments\Entities\Gallery::where([
    'assignment_id' => $data->id,
    'type' => 'start_job'
])->get();
?>


<div id="watermark">

</div>
<main>

    <div class="card-header">
        <h4 class="mt-1 mb-1 text-black" style="font-size: 22px; position: fixed;left:10mm; top:0mm; z-index:  -1000;">
            <strong> Pictures Front of the house or mailbox: ({{count($pics_front_house)}}) Pics</strong>
        </h4>
    </div>

    <div class="card-body">
        <div style="font-size: 12px; position: fixed;left:20mm; top:283mm; z-index:  -1000;">
            <span><?="Name: $data->first_name $data->last_name - Service date: $data_scheduled"?></span>
        </div>
        <div style="font-size: 12px; position: fixed;left:20mm; top:287mm; z-index:  -1000;">
            <span><?="Address: $data->street - $data->city - $data->state - $data->zipcode"?></span>
        </div>
        @foreach($pics_front_house as $pic_front)

            <?php
            switch ($countFront){
            case 0:

                ?>
                <div style="font-size: 12px; position: fixed;left:20mm; top:25mm; z-index:  -1000;">
                    <img   style="width: 305px; height: 235px;" src="{{$pic_front->b64}}" />
                </div>

            <?php
                break;
            case 1:
            ?>
            <div style="font-size: 12px; position: fixed;left:105mm; top:25mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_front->b64}}" />
            </div>
            <?php

            break;
            case 2:
            ?>

            <div style="font-size: 12px; position: fixed;left:20mm; top:90mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_front->b64}}" />
            </div>
            <?php

            break;
            case 3:
            ?>
            <div style="font-size: 12px; position: fixed;left:105mm; top:90mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_front->b64}}" />
            </div>
            <?php

            break;
            case 4:
            ?>
            <div style="font-size: 12px; position: fixed;left:20mm; top:155mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_front->b64}}" />
            </div>
            <?php

            break;
            case 5:
            ?>
            <div style="font-size: 12px; position: fixed;left:105mm; top:155mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_front->b64}}" />
            </div>
            <?php

            break;
            case 6:
            ?>
            <div style="font-size: 12px; position: fixed;left:20mm; top:220mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_front->b64}}" />
            </div>
            <?php

            break;
            case 7:
            ?>
            <div style="font-size: 12px; position: fixed;left:105mm; top:220mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_front->b64}}" />
            </div>
            <?php

            break;
            }
            $countFront++;
            ?>
        @endforeach


    </div>

</main>

<?php
$countInside=0;
$pics_inside=\Modules\Assignments\Entities\Gallery::where([
    'assignment_id' => $data->id,
    'type' => 'pics_inside'
])->get();

if(count($pics_inside) > 0){
?>

<div class="page_break"></div>


<div id="watermark">

</div>
<main>

    <div class="card-header">
        <h4 class="mt-1 mb-1 text-black" style="font-size: 22px; position: fixed;left:10mm; top:0mm; z-index:  -1000;">
            <strong> Inside pictures of the damaged area: ({{count($pics_inside)}}) Pics</strong>
        </h4>
    </div>



    <div class="card-body">
        <div style="font-size: 12px; position: fixed;left:20mm; top:283mm; z-index:  -1000;">
            <span><?="Name: $data->first_name $data->last_name - Service date: $data_scheduled"?></span>
        </div>
        <div style="font-size: 12px; position: fixed;left:20mm; top:287mm; z-index:  -1000;">
            <span><?="Address: $data->street - $data->city - $data->state - $data->zipcode"?></span>
        </div>


    @foreach($pics_inside as $pic_inside)
            <?php
            switch ($countInside){
            case 0:

            ?>
            <div style="font-size: 12px; position: fixed;left:20mm; top:25mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_inside->b64}}" />
            </div>

            <?php
            break;
            case 1:
            ?>
            <div style="font-size: 12px; position: fixed;left:105mm; top:25mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_inside->b64}}" />
            </div>
            <?php

            break;
            case 2:
            ?>

            <div style="font-size: 12px; position: fixed;left:20mm; top:90mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_inside->b64}}" />
            </div>
            <?php

            break;
            case 3:
            ?>
            <div style="font-size: 12px; position: fixed;left:105mm; top:90mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_inside->b64}}" />
            </div>
            <?php

            break;
            case 4:
            ?>
            <div style="font-size: 12px; position: fixed;left:20mm; top:155mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_inside->b64}}" />
            </div>
            <?php

            break;
            case 5:
            ?>
            <div style="font-size: 12px; position: fixed;left:105mm; top:155mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_inside->b64}}" />
            </div>
            <?php

            break;
            case 6:
            ?>
            <div style="font-size: 12px; position: fixed;left:20mm; top:220mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_inside->b64}}" />
            </div>
            <?php

            break;
            case 7:
            ?>
            <div style="font-size: 12px; position: fixed;left:105mm; top:220mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_inside->b64}}" />
            </div>
            <?php

            break;
            }
                $countInside++;
            ?>
        @endforeach

    </div>

</main>



<?php
} //insede
$countBefore=0;
$countImageBefore=0;
$pics_before=\Modules\Assignments\Entities\Gallery::where([
    'assignment_id' => $data->id,
    'type' => 'pics_before'
])->get();
?>

<div class="page_break"></div>

<div id="watermark">

</div>
<main>

    <div class="card-header">
        <h4 class="mt-1 mb-1 text-black" style="font-size: 22px; position: fixed;left:10mm; top:0mm; z-index:  -1000;">
            <strong>Pictures of the Roof damaged area before installed: ({{count($pics_before)}}) Pics</strong>
        </h4>
    </div>



    <div class="card-body">
        <div style="font-size: 12px; position: fixed;left:20mm; top:283mm; z-index:  -1000;">
            <span><?="Name: $data->first_name $data->last_name - Service date: $data_scheduled"?></span>
        </div>
        <div style="font-size: 12px; position: fixed;left:20mm; top:287mm; z-index:  -1000;">
            <span><?="Address: $data->street - $data->city - $data->state - $data->zipcode"?></span>
        </div>
        @foreach($pics_before as $pic_before)
            <?php

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
                        <h4 class="mt-1 mb-1 text-black" style="font-size: 22px; position: fixed;left:10mm; top:0mm; z-index:  -1000;">
                            <strong>Pictures of the Roof damaged area before installed: ({{count($pics_before)}}) Pics</strong>
                        </h4>
                    </div>
                    <div style="font-size: 12px; position: fixed;left:20mm; top:283mm; z-index:  -1000;">
                        <span><?="Name: $data->first_name $data->last_name - Service date: $data_scheduled"?></span>
                    </div>
                    <div style="font-size: 12px; position: fixed;left:20mm; top:287mm; z-index:  -1000;">
                        <span><?="Address: $data->street - $data->city - $data->state - $data->zipcode"?></span>
                    </div>
                 <?php
            }
            switch ($countBefore){
            case 0:

            ?>
            <div style="font-size: 12px; position: fixed;left:20mm; top:25mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_before->b64}}" />
            </div>

            <?php
            break;
            case 1:
            ?>
            <div style="font-size: 12px; position: fixed;left:105mm; top:25mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_before->b64}}" />
            </div>
            <?php

            break;
            case 2:
            ?>

            <div style="font-size: 12px; position: fixed;left:20mm; top:90mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_before->b64}}" />
            </div>
            <?php

            break;
            case 3:
            ?>
            <div style="font-size: 12px; position: fixed;left:105mm; top:90mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_before->b64}}" />
            </div>
            <?php

            break;
            case 4:
            ?>
            <div style="font-size: 12px; position: fixed;left:20mm; top:155mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_before->b64}}" />
            </div>
            <?php

            break;
            case 5:
            ?>
            <div style="font-size: 12px; position: fixed;left:105mm; top:155mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_before->b64}}" />
            </div>
            <?php

            break;
            case 6:
            ?>
            <div style="font-size: 12px; position: fixed;left:20mm; top:220mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_before->b64}}" />
            </div>
            <?php

            break;
            case 7:
            ?>
            <div style="font-size: 12px; position: fixed;left:105mm; top:220mm; z-index:  -1000;">
                <img   style="width: 305px; height: 235px;" src="{{$pic_before->b64}}" />
            </div>
            <?php

            break;
            }
                $countBefore++;
            $countImageBefore++;
            ?>
        @endforeach
    </div>

</main>





<?php
$countImageAfter=0;
$countAfter=0;
$pics_after =\Modules\Assignments\Entities\Gallery::where([
    'assignment_id' => $data->id,
    'type' => 'pics_after'
])->get();
?>

<div class="page_break"></div>

<div id="watermark">

</div>
<main>

    <div class="card-header">
        <h4 class="mt-1 mb-1 text-black" style="font-size: 22px; position: fixed;left:10mm; top:0mm; z-index:  -1000;">
            <strong>Pictures of the Roof Tarp after installed: ({{count($pics_after)}}) Pics</strong>
        </h4>
    </div>



    <div class="card-body">
        <div style="font-size: 12px; position: fixed;left:20mm; top:283mm; z-index:  -1000;">
            <span><?="Name: $data->first_name $data->last_name - Service date: $data_scheduled"?></span>
        </div>
        <div style="font-size: 12px; position: fixed;left:20mm; top:287mm; z-index:  -1000;">
            <span><?="Address: $data->street - $data->city - $data->state - $data->zipcode"?></span>
        </div>
        @foreach($pics_after as $pic_after)
            <?php

            if($countAfter == 8){
            $countAfter=0;
            ?>
    </div>

</main>

<div class="page_break"></div>

<div id="watermark">

</div>
<main>

    <div class="card-header">
        <h4 class="mt-1 mb-1 text-black" style="font-size: 22px; position: fixed;left:10mm; top:0mm; z-index:  -1000;">
            <strong>Pictures of the Roof Tarp after installed: ({{count($pics_after)}}) Pics</strong>
        </h4>
    </div>
    <div style="font-size: 12px; position: fixed;left:20mm; top:283mm; z-index:  -1000;">
        <span><?="Name: $data->first_name $data->last_name - Service date: $data_scheduled"?></span>
    </div>
    <div style="font-size: 12px; position: fixed;left:20mm; top:287mm; z-index:  -1000;">
        <span><?="Address: $data->street - $data->city - $data->state - $data->zipcode"?></span>
    </div>
    <?php
    }
    switch ($countAfter){
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
    $countAfter++;
    $countImageAfter++;
    ?>
    @endforeach
    </div>

</main>



</body>
</html>