

                <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:800px;'>
                    <div class="dhx_cal_navline">
                        <div class="dhx_cal_prev_button">&nbsp;</div>
                        <div class="dhx_cal_next_button">&nbsp;</div>

                        <a @if(isset($model->date)) href="/manager/order/timetable"@endif>
                            <div class="dhx_cal_today_button"></div>
                        </a>
                        <div class="dhx_cal_date"></div>
                        <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
                        <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
                        <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
                        <div class="dhx_cal_tab dhx_cal_tab_standalone active" name="timeline_tab" style="right:280px;"></div>
                    </div>
                    <div class="dhx_cal_header"></div>
                    <div class="dhx_cal_data"></div>
                </div>




    <script>
        var picker;
        jQuery(document).ready(function ($) {
            initPartial(getDate());

        });
        $(function () {
            $('[data-toggle="popover"]').popover()
        })
        var currentdate = new Date();
        var time = currentdate.getTime();

        function getDate() {
                <?php if(isset($model->date)){?>
            var today = new Date({{$model->date}});
            var dd = today.getDate();
            var mm = today.getMonth(); //January is 0!
            var yyyy = today.getFullYear();
            return new Date(yyyy, mm, dd);
                <?php } else {?>
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth(); //January is 0!
            var yyyy = today.getFullYear();
            return new Date(yyyy, mm, dd);
            <?php } ?>
        }

        function initPartial(date) {

            scheduler.locale.labels.timeline_tab = "Timeline";
            scheduler.locale.labels.section_custom = "Section";
            scheduler.config.details_on_create = true;
            scheduler.config.details_on_dblclick = true;
            scheduler.config.xml_date = "%Y-%m-%d %H:%i";
            scheduler.attachEvent("onDblClick", function (id, e) {
                var event = scheduler.getEvent(id);
                getDataForUpdate(event.jobid);
            })
            scheduler.config.drag_resize= false;


            scheduler.attachEvent("onDragEnd", function (id, mode, e) {
                var dragged_event = scheduler.getEvent(id);
                getDataAfterDrag(dragged_event);

            });
            scheduler.attachEvent("onBeforeEventChanged", function(ev, e, is_new, original){
                if(ev.start_date!=original.start_date){
                    ev.start_date=original.start_date;
                    ev.end_date=original.end_date;
                }
                return true;

            });


            //===============
            //Configuration
            //===============
            var sections = <?php echo $model->drivers?>;

            scheduler.createTimelineView({
                name: "timeline",
                x_unit: "minute",
                x_date: "%H:%i",
                x_step: 30,
                x_size: 48,
                x_start: 0,
                x_length: 48,
                y_unit: sections,
                y_property: "section_id",
                render: "tree",
                folder_dy:40,
                dx:280
            });

            //===============
            //Data loading
            //===============
            scheduler.config.lightbox.sections = [
                {name: "order_id", height: 30, map_to: "text", type: "textarea", focus: true},
                {name: "description", height: 130, map_to: "text", type: "textarea", focus: true},
                {name: "custom", height: 23, type: "select", options: sections, map_to: "section_id"},
                {name: "time", height: 72, type: "time", map_to: "auto"}
            ];

            scheduler.init('scheduler_here', date, "timeline");
            scheduler.parse(<?php echo $model->jobs ?>, "json");
        }



        $(function () {
            $('[data-toggle="popover"]').popover()
        })




    </script>


