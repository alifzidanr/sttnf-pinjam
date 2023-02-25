$(document).ready(function () {

  window._token = $('meta[name="csrf-token"]').attr('content')
  window._stripe_key = $('meta[name="stripe-key"]').attr('content')

  moment.updateLocale('en', {
    week: {dow: 1} // Monday is the first day of the week
  })

  $(function () {
    // Initialize DateTimePicker 1
    $("#start_time").datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
        defaultDate: null,
        locale: 'en',
        sideBySide: true,
        useCurrent: false,
        
        minDate: moment(moment()).add(3, 'days'),
        maxDate: moment(moment()).add(12, 'days'),
        daysOfWeekDisabled: [0],
        icons: {
          up: 'fas fa-chevron-up',
          down: 'fas fa-chevron-down',
          previous: 'fas fa-chevron-left',
          next: 'fas fa-chevron-right'
        },
        stepping: 10,
    });

    // Initialize DateTimePicker 2
    $("#end_time").datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
        locale: 'en',
        sideBySide: true,
        useCurrent: false,
        minDate: moment(moment()).add(3, 'days'),
        maxDate: moment(moment()).add(12, 'days'),
        daysOfWeekDisabled: [0],
        icons: {
          up: 'fas fa-chevron-up',
          down: 'fas fa-chevron-down',
          previous: 'fas fa-chevron-left',
          next: 'fas fa-chevron-right'
        },
        stepping: 10
    });
  
});



  $('.select-all').click(function () {
    let $select2 = $(this).parent().siblings('.select2')
    $select2.find('option').prop('selected', 'selected')
    $select2.trigger('change')
  })
  $('.deselect-all').click(function () {
    let $select2 = $(this).parent().siblings('.select2')
    $select2.find('option').prop('selected', '')
    $select2.trigger('change')
  })

  $('.select2').select2()

  $('.treeview').each(function () {
    var shouldExpand = false
    $(this).find('li').each(function () {
      if ($(this).hasClass('active')) {
        shouldExpand = true
      }
    })
    if (shouldExpand) {
      $(this).addClass('active')
    }
  })
})



