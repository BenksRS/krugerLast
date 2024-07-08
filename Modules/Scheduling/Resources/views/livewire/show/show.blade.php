
    <style>
        .scheduled_job{
            cursor: move!important;
        }
        .open_job{
            cursor: move!important;
        }
        .schedsHeaderContent::-webkit-scrollbar {
            height: 0px;
        }
        .schedTechboxContent::-webkit-scrollbar {
            width: 0px;
        }
        .schedTechsHeader{
            border-bottom:1px solid #F2F2F5FF;
            width: 10%; position: relative;float: left;
        }
        .schedTechs{
            /*border:5px solid darkblue;*/
            border-bottom:1px solid #F2F2F5FF;
            width: 10%; position: relative;float: left;


        }
        .schedTechboxContent{
            width: 100%;
            max-height: 1200px;
            overflow-x: scroll;
        }
        .schedsgridHeader{
            width: 90%; position: relative;float: left;
        }

        .schedsgrid{
            /*border:5px solid darkred;*/
            width: 90%;
            max-height: 760px;
            position: relative;float: left;
            /*overflow-y: scroll;*/

        }
        .schedsHeaderContent{
            /*border:5px solid darkred;*/

            overflow-y: scroll;
        }
        .schedsgridContent{
            width: 100%;
            max-height: 1200px;
            overflow-x: scroll;

        }
        .jobsOpen{
            max-height: 1200px;
            overflow-x: scroll;
        }
        .job_route{
            border: 2px solid RED;
        }
        .blackfont{
            color: #0b0b0b;
        }
        .whitefont{
            color: #2a2a2a;
        }

        .schedboxHeader{
            /*border:1px solid red;*/
            /*border-top:1px solid #F2F2F5FF;*/
            border-right:1px solid #F2F2F5FF;
            height: 105px; width: 150px;position: relative;float: left; }
        .schedbox{
            /*border:1px solid red;*/
            border-right:1px solid #F2F2F5FF;
            height: 105px; width: 75px;position: relative;float: left; }
        .schedTechbox{
            /*border:1px solid blue;*/
            border-left:1px solid #F2F2F5FF;
            border-bottom:1px solid #F2F2F5FF;
            border-right:1px solid #F2F2F5FF;
            height: 106px; width: 100%;position: relative;float: left;}
        .schedWrap{
            /*border:1px solid green;*/
            width: 80%; height: 500px;position: relative;float: left;}
        .loadbox{
            background: rgba(141, 141, 141, 0.32);
        }
        .lineWrap{
            border-bottom:1px solid #F2F2F5FF;
            /*border-left:1px solid #d4d4d5;*/
            min-height: 105px;
            width: 3620px;position: relative;float: left;
        }
        .open_job{
            position: relative;
            margin-left: 5px;
            margin-top: 2px;
            height: 98px;
            /*color: #fbfbfb;*/
            font-weight: 600;
        }
        .scheduled_job{
            position: relative;
            margin-left: 5px;
            margin-top: 2px;
            width: 142px;
            height: 98px;
        }
        .headerControls{
            border-bottom:1px solid #F2F2F5FF;
            height: 80px;
        }
        .boxleftsched{
            width: 85%;
            position: relative;
            float: left;
            border-right:5px solid #F2F2F5FF;
        }
        .boxrigthsched{
            width: 15%;
            position: relative;
            float: left;

        }

        .draggable-source--is-dragging{
            border: 2px solid rgba(1, 1, 93, 0.3) !important;
            overflow: hidden;
            /*font-size: 0!important;*/
        }


    </style>
    <div>
        <div class="row m-2" >
            <div class="col-lg-12">
                <div class="row">
                    @livewire('scheduling::show.schedulle', key('schedulle_grid'))

                </div>
            </div>
        </div>

        @push('js')
            <script>


                $('.moveall').scroll(function(){
                    $('.moveall').scrollTop($(this).scrollTop());
                })
                $('.moveyall').scroll(function(){
                    $('.moveyall').scrollLeft($(this).scrollLeft());
                })

                //
                // // $('.accordion-button').onscrollTop(0);
                // $('.accordion-button').on("click",function(){
                //     var header_id = $(this).parent().attr('id');
                //     console.log(header_id);
                //     document.getElementById(header_id).scrollIntoView();
                //
                // });
                // $('.accordion-collapse').on('shown.bs.collapse', function (e) {
                //     // var $panel = $(this).closest('.panel');
                //     var scroll = $(this).data("move");
                //     console.log($(this));
                //     $('.jobsOpen').scrollTop(scroll);
                // })
                // $('.jobsOpen').scrollTop(0);


                $('.moveyall').scrollLeft(1200);

                function componentsLoadPage(){
                    console.log('START components');

                    // var height = $('.moveup').height();
                    // var position = $('.moveup').offset().top;
                    // document.getElementsByClassName('moveup').scrollIntoView();
                     var scroll = $('.moveup').data('move');
                    console.log(scroll);
                    $('.jobsOpen').scrollTop(scroll);
                    console.log('END components')

                }

                document.addEventListener("DOMContentLoaded", () => {
                    Livewire.hook('message.processed', (message, component) => {componentsLoadPage()})
                });

            </script>
        @endpush

    </div>

