<script>
    var CalendarApp = function() {
        this.$body = $("body")
        this.$calendar = $('#calendar'),
        this.$event = ('#calendar-events div.calendar-events'),
        this.$categoryForm = $('#add-new-event form'),
        this.$extEvents = $('#calendar-events'),
        this.$modal = $('#my-event'),
        this.$saveCategoryBtn = $('.save-category'),
        this.$calendarObj = null

    };

    /* on click on event */
    CalendarApp.prototype.onEventClick =  function (calEvent, jsEvent, view) {
        var $this = this;
            var form = $("<form></form>");
            var html = '';
            html += '<div class="container-fluid">';
            html += '<div class="row" id="abcd">';
            html += '</div>';
            html += '</div>';
            form.append(html);
            $.ajax({
                type: "GET",
                url: "{{url('appointment/get-day-wise-doctor-schedule')}}/"+calEvent.doctorId+"/"+calEvent.scheduleId+"/"+calEvent.date,
                data: "data",
                dataType: "json",
                beforeSend: function(){},
                success: function (response) {
                    $('#abcd').html(response.html);
                }
            });
            $this.$modal.modal({
                backdrop: 'static'
            });
            $this.$modal.find('.delete-event').show().end().find('.save-event').hide().end().find('.modal-body').empty().prepend(form).end().find('.delete-event').unbind('click').click(function () {
                $this.$calendarObj.fullCalendar('removeEvents', function (ev) {
                    return (ev._id == calEvent._id);
                });
                $this.$modal.modal('hide');
            });
    },

    /* Initializing */
    CalendarApp.prototype.init = function() {
        // this.enableDrag();
        /*  Initialize the calendar  */
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var form = '';
        var today = new Date($.now());

        var defaultEvents =  [
            @foreach($calendarEvents as $event)
            @php $count = App\Models\doctor\DocAppointment::where('date',$event->date)->where('doctor_id',$event->doctor_id)->count(); @endphp
            {
                title: '#{{$count}} {{$event->doctor->full_name}}',
                start: '{{$event->date}}',
                date: '{{$event->date}}',
                className: 'bg-info',
                scheduleId: '{{$event->doc_schedule_id}}',
                doctorId: '{{$event->doctor_id}}',
            },
            @endforeach
            ];

        var $this = this;
        $this.$calendarObj = $this.$calendar.fullCalendar({
            slotDuration: '00:15:00', /* If we want to split day time each 15minutes */
            minTime: '08:00:00',
            maxTime: '19:00:00',  
            defaultView: 'month',  
            handleWindowResize: true,   
             
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: defaultEvents,
            editable: false,
            droppable: false, // this allows things to be dropped onto the calendar !!!
            eventLimit: true, // allow "more" link when too many events
            selectable: true,
            drop: function(date) { $this.onDrop($(this), date); },
            select: function (start, end, allDay) { $this.onSelect(start, end, allDay); },
            eventClick: function(calEvent, jsEvent, view) { $this.onEventClick(calEvent, jsEvent, view); }

        });
        
    },

   //init CalendarApp
    $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp

    $(document).ready(function($){
        $.CalendarApp.init()
    });
</script>