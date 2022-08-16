<html>
<head>
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

    </style>
    <title>{{$page->name.' - '.$data->last_name.' '.$data->first_name}}</title>
</head>
<body>
<?php
//foreach ($pages as $page){
?>
<div id="watermark">
    <img src="{{$page->b64}}" height="100%" width="100%" />
</div>


<main>
    <?php

//dd($assignmentview->full_name);
    foreach ($fields as $f){
    if($f->field == 'augusto' ||$f->field == 'sign' || $f->field == 'sign1' || $f->field == 'sign2' || $f->field == 'sign3' || $f->field == 'sign4' || $f->field == 'sign5' || $f->field == 'sign6'){

        if($f->field == 'augusto'){
        ?>
        <div style="font-size: 12px; position: fixed;left:<?=$f->height?>mm; top:<?=$f->length?>mm; z-index:  -1000;">
            <img   height="50" src="data:image/jpeg;base64,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" />
        </div>
        <?php
        }else{
            ?>
        <div style="font-size: 12px; position: fixed;left:<?=$f->height?>mm; top:<?=$f->length?>mm; z-index:  -1000;">
            <img   height="50" src="{{$sign->b64}}" />
        </div>
        <?php
        }

    }else{

        $field=$f->field;
        switch ($f->field){
            case 'x':
                $field_test='X';
                break;
            case 'KRUGER':
                $field_test='Kruger';
                break;
            default:
                $field_test= $assignmentview->{$field};
                break;

        }






    if($field_test == '0000-00-00' || $field_test == '00-00-0000' || $field_test == '1970-01-01' || $field_test == '01-01-1970'){
        $field_test='';
    }

    ?>
    <span style="font-size: 12px; position: fixed;left:<?=$f->height?>mm; top:<?=$f->length?>mm; z-index:  -1000;">{{$field_test}}</span>
    <?php
    unset($field_test);
    }

    }
    ?>
</main>
<?php
//}
//?>
</body>
</html>

