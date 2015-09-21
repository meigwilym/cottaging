// @todo ontouchstart 
$(function(){
  
  
  $('#booking-form').hide();
  
  // slide the calendar with the date names
  var nav_index = 0;
  $('.calendar_nav a.move_month').on('click', function(e){
    e.preventDefault();
    
    var mult = $(this).data('month');
    if(mult >= 9) mult = 8;
    var move = 25*mult*-1; // @todo not necessarily 25% of the width, if < 4 cals shown.
    
    var time = 250*(mult - nav_index);
    if(time < 0) time = time * -1;
    
    $('.calendar_inner').animate( { marginLeft: move + '%'}, time, 'easeInOutQuad');
    nav_index = $(this).index();
  });
  
  $('.calendar_nav a.move_month_left').on('click', { dir: 'left'}, shiftCals);
  $('.calendar_nav a.move_month_right').on('click', { dir: 'right'}, shiftCals);
  
  // shift the calendars once to the left or right
  function shiftCals(e)
  {
    e.preventDefault();
    
    var wrapper = $('.calendar_inner');
    var margin = wrapper.css('marginLeft');
    margin = parseInt(margin.substr(0, margin.length-2), 10);
    var maxwidth = wrapper.parent().css('width')
    maxwidth = maxwidth.substr(0, maxwidth.length - 2);
    var width = parseInt(maxwidth/4, 10); // @todo this may be < 4 on some devices
    var move = (e.data.dir == 'right') ? margin - width : margin + width;
    
    // can't move up too far on either side
    if(move <= 0 && move >= (width*8*-1))
      wrapper.animate({marginLeft: move+'px'}, 200, 'easeInOutQuad');
  }
  
  setChangeoverDayTitle('Choose this arrival day');
  
  // pick a date
  WC.pick_arrival = false;
  var first_night, last_night;
  $('td.changeover').on('click', function(){
    
    // if it's booked, and the arrival date hasn't been picked
    if($(this).hasClass('booked') && !pick_arrival) return;
    
    // no disabled arrival days
    if($(this).hasClass('disabled')) return;
      
    
    // for arrival days
    // if the pick_arrival flag is false
    if(!WC.pick_arrival)
    {
      WC.pick_arrival = true;
      
      $(this).addClass('selected-arrive');
      
      // reset the form
      $('.changeover').each(function(){
        $(this).removeClass('disabled');
      });
      
      // highlight the reset button
      $('.reset-dates').addClass('btn-info');      
      
      var d_parts = $(this).data('date').split('-');
      first_night = new Date(d_parts[0], d_parts[1]-1, d_parts[2]);      
      
      // disable all departure days
      // enable only available departure date
      var found_booking = false
      $('td.changeover').each(function(i)
      { 
        var this_date = $(this).data('date').split('-');
        
        if(found_booking 
          || new Date(this_date[0], this_date[1]-1, this_date[2]) <= first_night)
        {
          $(this).addClass('disabled');
          return true; // break out
        }
        
        if($(this).hasClass('first_night')){
          found_booking = true;
        }
      });
      setChangeoverDayTitle('Choose this as a departure day');
      $(this).attr('title', 'Your arrival day');
      
      $('input#arriving').val(dayDateMonth(first_night));
      $('input[name=first_night]').val(dateMySQL(first_night));
    }
    else // chose a departure date
    {
      $('td.selected-depart').each(function(){
        $(this).removeClass('selected-depart');
      });
      $(this).addClass('selected-depart');
      
      // remove the mouseout event which clears the holiday selection classes
      $('td.changeover').unbind('mouseenter mouseleave');
      
      var d_parts = $(this).data('date').split('-');
      last_night = new Date(d_parts[0], d_parts[1]-1, d_parts[2]);
            
      $('input#departing').val(dayDateMonth(last_night));
      $('input[name=depart]').val(dateMySQL(last_night));
      
      // calculate the cost
      costSpinner('show');
      $.post(baseurl+'api/cottage/cost',
        {
          cottage_id : $('input[name=cottage_id]').val(),
          first_night: $('input[name=first_night]').val(),
          depart : $('input[name=depart]').val(),
        }, 
        function(data, textStatus, jqXHR){
          $('input#cost').val(data.cost);
        }
      ).done(function() {
        
      })
      .fail(function() {
        // show an error
        console.log('ajax fail');
      })
      .always(function() {
        costSpinner('hide');
        makeDatesVisible();
      });
      
      $('#booking-form').show('slow');
      
      // calculate number of nights
      $('input#nights').val(dateDiffDays(first_night, last_night));
    }
  });
  
  $('td.changeover').hover(tdmouseover, tdmouseout);
  
  // reset the dates on the form
  $('.reset-dates').on('click', function()
  {
    WC.pick_arrival = false;
    
    $('input#arriving').val('');
    $('input#departing').val('');
    $('input#nights').val('');
    $('input#cost').val('');
    
    $('td.changeover').each(function(i){
      $(this).removeClass('selected');
      $(this).removeClass('selected-arrive');
      $(this).removeClass('selected-depart');
      $(this).removeClass('disabled');
    });
    $('td.booking-tentative').each(function(i){
      $(this).removeClass('booking-tentative');
    });
    
    $(this).removeClass('btn-info');
    
    // re-bind the hover
    $('td.changeover').hover(tdmouseover, tdmouseout);
    
  })
  
}); // 

function dayDateMonth(thedate)
{
  // var weeknames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  var monthnames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']

  return monthnames[thedate.getMonth()]+' '+thedate.getDate();
}

function dateDiffDays(one, two)
{
  var millisecondsPerDay = 1000 * 60 * 60 * 24;
  var millisBetween = two.getTime() - one.getTime();
  
  return Math.floor(millisBetween / millisecondsPerDay);
}

function dateMySQL(date)
{
  var day = date.getDate();
  if(day<10) day = '0'+day;
  var month = date.getMonth() + 1;
  if(month<10) month = '0' + month;
  
  return date.getFullYear()+'-'+month+'-'+day;
}

function costSpinner(toggle)
{  
  var div = $('#costspinner');
  
  if(toggle == 'show')
  {
    div.html('<i class="fa fa-refresh fa-spin"></i>');
  }
  else if(toggle == 'hide')
  {
    div.html('£');
  }
}

/**
 * Set the title of all changeover days. 
 * 
 * If the day is disabled, the title is blank
 * @param {string} title
 * @returns {void}
 */
function setChangeoverDayTitle(title)
{
  $('.changeover').each(function(){
    if($(this).hasClass('disabled'))
      $(this).attr('title', '');
    else
      $(this).attr('title', title);
  });
}

/**
 * @todo If the cost box is not onscreen, scroll to show.
 * @returns {undefined}
 */
function makeDatesVisible()
{
  return;
}

function tdmouseover(){
    if(WC.pick_arrival)
    {
      var from = $('.selected-arrive').data('dayofyear');
      from++;
      var to = $(this).data('dayofyear');
      for(i=from;i<to;i++)
        $('td[data-dayofyear="'+i+'"]').addClass('booking-tentative')
    }
  }
  
function tdmouseout(){ // mouse out
    if(WC.pick_arrival)
    {
      var from = $('.selected-arrive').data('dayofyear');
      from++;
      var to = $(this).data('dayofyear');
      for(i=from;i<to;i++)
        $('td[data-dayofyear="'+i+'"]').removeClass('booking-tentative')
    }
  }