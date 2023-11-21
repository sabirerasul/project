const d = document;
var calendarEl = d.getElementById('calendar');

var events = [
    {
        id: 1,
        title: 'Call with Jane',
        start: '2020-11-18',
        end: '2020-11-19',
        className: 'bg-red'
    },

    {
        id: 2,
        title: 'Dinner meeting',
        start: '2020-11-21',
        end: '2020-11-22',
        className: 'bg-orange'
    },

    // ...

    {
        id: 10,
        title: 'Cyber Week',
        start: '2020-12-02',
        end: '2020-12-03',
        className: 'bg-red'
    }
];

var addNewEventModalEl = d.getElementById('modal-new-event');
var addNewEventModal = new bootstrap.Modal(addNewEventModalEl);
var newEventTitleInput = d.getElementById('eventTitle');
var newEventStartDatepicker = new Datepicker(d.getElementById('dateStart'), { buttonClass: 'btn' });
var newEventEndDatepicker = new Datepicker(d.getElementById('dateEnd'), { buttonClass: 'btn' });

var editEventModalEl = d.getElementById('modal-edit-event');
var editEventModal = new bootstrap.Modal(editEventModalEl);
var editEventTitleInput = d.getElementById('eventTitleEdit');
var editEventStartDatepicker = new Datepicker(d.getElementById('dateStartEdit'), { buttonClass: 'btn' });
var editEventEndDatepicker = new Datepicker(d.getElementById('dateEndEdit'), { buttonClass: 'btn' });

// current id selection
var currentId = null;

var calendar = new FullCalendar.Calendar(calendarEl, {
    selectable: true,
    initialView: 'dayGridMonth',
    themeSystem: 'bootstrap',
    initialDate: '2020-12-01',
    editable: true,
    events: events,
    dateClick: function (d) {
        addNewEventModal.show();
        newEventTitleInput.value = '';
        newEventStartDatepicker.setDate(d.date);
        newEventEndDatepicker.setDate(d.date.setDate(d.date.getDate() + 1));

        addNewEventModalEl.addEventListener('shown.bs.modal', function () {
            newEventTitleInput.focus();
        });
    },
    eventClick: function (info, element) {
        // set current id
        currentId = info.event.id;
        editEventTitleInput.value = info.event.title;
        editEventStartDatepicker.setDate(info.event.start);
        editEventEndDatepicker.setDate(info.event.end ? info.event.end : info.event.start);

        editEventModal.show();
        editEventModalEl.addEventListener('shown.bs.modal', function () {
            editEventTitleInput.focus();
        });
    }
});
calendar.render();

d.getElementById('addNewEventForm').addEventListener('submit', function (event) {
    event.preventDefault();
    calendar.addEvent({
        id: Math.random() * 10000, // this should be a unique id from your back-end or API
        title: newEventTitleInput.value,
        start: moment(newEventStartDatepicker.getDate()).format('YYYY-MM-DD'),
        end: moment(newEventEndDatepicker.getDate()).format('YYYY-MM-DD'),
        className: 'bg-blue',
        dragabble: true
    });
    addNewEventModal.hide();
});

d.getElementById('editEventForm').addEventListener('submit', function (event) {
    event.preventDefault();
    var editEvent = calendar.getEventById(currentId);
    var startDate = moment(editEventStartDatepicker.getDate()).format('YYYY-MM-DD');
    var endDate = moment(editEventEndDatepicker.getDate()).format('YYYY-MM-DD')

    editEvent.setProp('title', editEventTitleInput.value);
    editEvent.setStart(startDate);
    editEvent.setEnd(endDate);
    editEventModal.hide();
});

d.getElementById('deleteEvent').addEventListener('click', function () {
    swalWithBootstrapButtons.fire({
        icon: 'error',
        title: 'Confirm deletion',
        text: 'Are you sure you want to delete this event?',
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: 'No, cancel!',
    }).then(function (result) {
        if (result.value) {
            swalWithBootstrapButtons.fire(
                'Deleted!',
                'The event has been deleted.',
                'success'
            );
            calendar.getEventById(currentId).remove();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            editEventModal.hide();
        }
    })
});




d.getElementById('addNewEventForm').addEventListener('submit', function (event) {
    event.preventDefault();
    calendar.addEvent({
        id: Math.random() * 10000, // this should be a unique id from your back-end or API
        title: newEventTitleInput.value,
        start: moment(newEventStartDatepicker.getDate()).format('YYYY-MM-DD'),
        end: moment(newEventEndDatepicker.getDate()).format('YYYY-MM-DD'),
        className: 'bg-blue',
        dragabble: true
    });
    addNewEventModal.hide();
});


d.getElementById('editEventForm').addEventListener('submit', function (event) {
    event.preventDefault();
    var editEvent = calendar.getEventById(currentId);
    var startDate = moment(editEventStartDatepicker.getDate()).format('YYYY-MM-DD');
    var endDate = moment(editEventEndDatepicker.getDate()).format('YYYY-MM-DD')

    editEvent.setProp('title', editEventTitleInput.value);
    editEvent.setStart(startDate);
    editEvent.setEnd(endDate);
    editEventModal.hide();
});


d.getElementById('deleteEvent').addEventListener('click', function () {
    swalWithBootstrapButtons.fire({
        icon: 'error',
        title: 'Confirm deletion',
        text: 'Are you sure you want to delete this event?',
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: 'No, cancel!',
        }).then(function(result) {
            if (result.value) {
            swalWithBootstrapButtons.fire(
                'Deleted!',
                'The event has been deleted.',
                'success'
            );
            calendar.getEventById(currentId).remove();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
            editEventModal.hide();
            }
        })
});