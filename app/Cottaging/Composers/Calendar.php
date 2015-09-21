<?php

namespace Cottaging\Composers;

use Carbon\Carbon;

/**
 * Composer class to display a calendar
 *
 * @todo finish off 
 * 
 * Ported to Laravel 4
 */
class Calendar {

    protected $local_time;
    protected $template = '';
    protected $start_day = 0;
    protected $month_type = 'long';
    protected $day_type = 'abr';
    protected $show_next_prev = FALSE;
    protected $next_prev_url = '';
    protected $arrival_days = array();

    /**
     * Constructor
     *
     * Sets the default time reference
     */
    public function __construct()
    {
        $this->local_time = time();
    }
    
    public function compose($view)
    {
      $now = Carbon::now()->firstOfMonth();
      $months = array();
      // show a calendar for the next 12 months
      for($i = 0; $i < 12; $i++)
      {
        $cal = new \Cottaging\Presenters\Calendar(array('start_day' => 1, 'arrival_days' => $cottage->start_days));

        echo '<div class="calendar_month ">';

        if($i != 0)
          $now->firstOfMonth()->addMonth(1);
        echo $cal->render($now, $bookings);

        echo '</div>';

        $months[] = $now->format('F');
      }
    }
    
    /**
     * Render a calendar month
     * 
     * @param \Carbon\Carbon $date
     * @param \Illuminate\Database\Eloquent\Collection $bookings
     */
    public function render(Carbon $date, $bookings)
    { 
      $html = '';      
      
      // Determine the total days in the month
      $total_days = $date->daysInMonth;
      
      // Set the starting day number
      $day = $this->start_day + 1 - $date->startOfMonth()->dayOfWeek;

      while ($day > 1)
      {
          $day -= 7;
      }
      
      $html .= '<table id="'.$date->format('F').'">';
      $html .= '<thead><tr><th colspan="7">'.$date->format('F').'</th></tr>';
      
      $html .= '<tr><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th><th>Su</th></tr></thead>';
      
      $bookings = $this->parseBookings($bookings, $date);
      $first_night = true;
      
      while ($day <= $total_days)
      {
        $html .='<tr>';
        for($i=0;$i<7;$i++)
        {          
          if($day > 0 && $day <= $total_days)
          {
            $date->day($day); // set Carbon's date
            $html_classes = array();
            $bookable = true; // default
            
            // is in the past, is today, is weekend and is start day
            if($date->lt(Carbon::now()->startOfDay())) 
              $html_classes[] = 'past';
            else
            {
              if($date->isToday()) $html_classes[] = 'today';
              if($date->isWeekend()) $html_classes[] = 'weekend';
              if(in_array($date->dayOfWeek, $this->arrival_days)) $html_classes['changeover'] = 'changeover'; 
            }
            
            // is booked
            if(in_array($date, $bookings)) 
            {
              $bookable = false;
              $html_classes[] = 'booked';
              
              if($first_night) 
              {
                $html_classes[] = 'first_night';
                $bookable = true; // can be a departure day
              }
              else
              {
                // mid week arrival date: get rid
                unset($html_classes['changeover']);
              }
              $first_night = false;
            }
            else
            {
              $first_night = true;
            }
            
            $html .= '<td class="'.  implode(' ', $html_classes).'" ';
            $html .= ($bookable) ? ' data-date="'.$date->format('Y-m-d').'"' : '';
            $html .= '>'.$date->format('j').'</td>';
          }
          else
          {
            $html .= '<td class="calday_empty">&nbsp;</td>';
          }
          
          $day++;
        }
        $html .='</tr>';
      }
      
      
      $html .= '</tbody><tfoot></tfoot></table>';
      return $html;
    }
    
    
    /**
     * Get an array of booked dates for this month
     * 
     * @param \Illuminate\Database\Eloquent\Collection $bookings
     * @param \Carbon $date
     */
    public function parseBookings($bookings, Carbon $date)
    {
      $days = array();
      
      foreach($bookings as $b)
      {
        $first_night = Carbon::parse($b['first_night']);        
        $last_night = Carbon::parse($b['last_night']);
        
        // if neither of these are in the current month then swiftly move on
        if($first_night->month != $date->month || $last_night->month != $date->month) continue;
        
        $period = new \DatePeriod(
                      $first_night,
                      new \DateInterval('P1D'),
                      $last_night->addDay()
                  );
        
        foreach($period as $p)
          $days[] = $p;
      }
      
      return $days;
    }
    

    // --------------------------------------------------------------------

    /**
     * Get Month Name
     *
     * Generates a textual month name based on the numeric
     * month provided.
     * 
     * @todo i18n
     *
     * @access	public
     * @param	integer	the month
     * @return	string
     */
    public function get_month_name($month)
    {
        if($this->month_type == 'short')
        {
            $month_names = array('01' => 'jan', '02' => 'feb', '03' => 'mar', '04' => 'apr', '05' => 'may', '06' => 'jun', '07' => 'jul', '08' => 'aug', '09' => 'sep', '10' => 'oct', '11' => 'nov', '12' => 'dec');
        }
        else
        {
            $month_names = array('01' => 'january', '02' => 'february', '03' => 'march', '04' => 'april', '05' => 'mayl', '06' => 'june', '07' => 'july', '08' => 'august', '09' => 'september', '10' => 'october', '11' => 'november', '12' => 'december');
        }

        return ucfirst($month_names[$month]);
        
    }

    // --------------------------------------------------------------------

    /**
     * Get Day Names
     *
     * Returns an array of day names (Sunday, Monday, etc.) based
     * on the type.  Options: long, short, abrev
     *
     * @access	public
     * @param	string
     * @return	array
     */
    public function get_day_names($day_type = '')
    {
        if($day_type != '')
            $this->day_type = $day_type;

        if($this->day_type == 'long')
        {
            $day_names = array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');
        }
        elseif($this->day_type == 'short')
        {
            $day_names = array('sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat');
        }
        else
        {
            $day_names = array('su', 'mo', 'tu', 'we', 'th', 'fr', 'sa');
        }

        $days = array();
        foreach($day_names as $val)
        {
            $days[] =  ucfirst($val);
        }

        return $days;
    }

    // --------------------------------------------------------------------

    /**
     * Adjust Date
     *
     * This function makes sure that we have a valid month/year.
     * For example, if you submit 13 as the month, the year will
     * increment and the month will become January.
     *
     * @access	public
     * @param	integer	the month
     * @param	integer	the year
     * @return	array
     */
    public function adjust_date($month, $year)
    {
        $date = array();

        $date['month'] = $month;
        $date['year'] = $year;

        while ($date['month'] > 12)
        {
            $date['month'] -= 12;
            $date['year']++;
        }

        while ($date['month'] <= 0)
        {
            $date['month'] += 12;
            $date['year']--;
        }

        if(strlen($date['month']) == 1)
        {
            $date['month'] = '0' . $date['month'];
        }

        return $date;
    }

    // --------------------------------------------------------------------

    /**
     * Total days in a given month
     *
     * @access	public
     * @param	integer	the month
     * @param	integer	the year
     * @return	integer
     */
    public function get_total_days($month, $year)
    {
        $days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

        if($month < 1 OR $month > 12)
        {
            return 0;
        }

        // Is the year a leap year?
        if($month == 2)
        {
            if($year % 400 == 0 OR ($year % 4 == 0 AND $year % 100 != 0))
            {
                return 29;
            }
        }

        return $days_in_month[$month - 1];
    }

    // --------------------------------------------------------------------

    /**
     * Set Default Template Data
     *
     * This is used in the event that the user has not created their own template
     *
     * @access	public
     * @return array
     */
    public function default_template()
    {
        return array(
            'table_open' => '<table border="0" cellpadding="4" cellspacing="0">',
            'heading_row_start' => '<tr>',
            'heading_previous_cell' => '<th><a href="{previous_url}">&lt;&lt;</a></th>',
            'heading_title_cell' => '<th colspan="{colspan}">{heading}</th>',
            'heading_next_cell' => '<th><a href="{next_url}">&gt;&gt;</a></th>',
            'heading_row_end' => '</tr>',
            'week_row_start' => '<tr>',
            'week_day_cell' => '<td>{week_day}</td>',
            'week_row_end' => '</tr>',
            'cal_row_start' => '<tr>',
            'cal_cell_start' => '<td>',
            'cal_cell_start_today' => '<td>',
            'cal_cell_no_content' => '<a href="{content}" class="{class}">{day}</a>',
            'cal_cell_no_content_today' => '<a href="{content}" class="{class}"><strong>{day}</strong></a>',
            'cal_cell_content' => '{day}',
            'cal_cell_content_today' => '<strong>{day}</strong>',
            'cal_cell_blank' => '&nbsp;',
            'cal_cell_end' => '</td>',
            'cal_cell_end_today' => '</td>',
            'cal_row_end' => '</tr>',
            'table_close' => '</table>'
        );
    }

    // --------------------------------------------------------------------

    /**
     * Parse Template
     *
     * Harvests the data within the template {pseudo-variables}
     * used to display the calendar
     *
     * @access	public
     * @return	void
     */
    public function parse_template()
    {
        $this->temp = $this->default_template();

        if($this->template == '')
        {
            return;
        }

        $today = array('cal_cell_start_today', 'cal_cell_content_today', 'cal_cell_no_content_today', 'cal_cell_end_today');

        foreach(array('table_open', 'table_close', 'heading_row_start', 'heading_previous_cell', 'heading_title_cell', 'heading_next_cell', 'heading_row_end', 'week_row_start', 'week_day_cell', 'week_row_end', 'cal_row_start', 'cal_cell_start', 'cal_cell_content', 'cal_cell_no_content', 'cal_cell_blank', 'cal_cell_end', 'cal_row_end', 'cal_cell_start_today', 'cal_cell_content_today', 'cal_cell_no_content_today', 'cal_cell_end_today') as $val)
        {
            if(preg_match("/\{" . $val . "\}(.*?)\{\/" . $val . "\}/si", $this->template, $match))
            {
                $this->temp[$val] = $match['1'];
            }
            else
            {
                if(in_array($val, $today, TRUE))
                {
                    $this->temp[$val] = $this->temp[str_replace('_today', '', $val)];
                }
            }
        }
    }

}
