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
    <title>{{$page->filename.' - '.$data->last_name.' '.$data->first_name}}</title>
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

    $fields = DB::table('field_authorizations')->where('page', $page->id)->get();
    foreach ($fields as $f){
    if($f->field == 'sign'){

        ?>
        <div style="font-size: 12px; position: fixed;left:<?=$f->height?>mm; top:<?=$f->length?>mm; z-index:  -1000;">
            <img   height="50" src="{{$sign->b64}}" />
        </div>
        <?php
    }else{
        if($f->field == 'x'){
            $field_test='X';
        }else{
            $field=$f->field;
            if($f->field ==  'KRUGER'){
                $field_test='Kruger';
            }else{

//                if($field == 'date_sign'){
//                    $field_test= $assignmentview->{$field};
//                }else{
//                    $field_test= $assignmentview->{$field};
//                }
                $field_test= $assignmentview->{$field};
            }

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
