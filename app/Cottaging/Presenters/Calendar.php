<?php

namespace Cottaging\Presenters;

use Carbon\Carbon;
/**
 * CodeIgniter Calendar Class
 *
 * This class enables the creation of calendars
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
    protected $start_days = array();

    /**
     * Constructor
     *
     * Sets the default time reference
     */
    public function __construct(array $config)
    {
        $this->local_time = time();

        if(count($config) > 0)
        {
            $this->initialize($config);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Initialize the user preferences
     *
     * Accepts an associative array as input, containing display preferences
     *
     * @access	public
     * @param	array	config preferences
     * @return	void
     */
    public function initialize($config = array())
    {
        foreach($config as $key => $val)
        {
            if(isset($this->$key))
            {
                $this->$key = $val;
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Generate the calendar
     *
     * @access	public
     * @param	integer	the year
     * @param	integer	the month
     * @param	array	the data to be shown in the calendar cells
     * @return	string
     */
    public function generate($year = '', $month = '', $data = array())
    {
        // Set and validate the supplied month/year
        if($year == '')
            $year = date("Y", $this->local_time);

        if($month == '')
            $month = date("m", $this->local_time);

        if(strlen($year) == 1)
            $year = '200' . $year;

        if(strlen($year) == 2)
            $year = '20' . $year;

        if(strlen($month) == 1)
            $month = '0' . $month;

        $adjusted_date = $this->adjust_date($month, $year);

        $month = $adjusted_date['month'];
        $year = $adjusted_date['year'];

        // Determine the total days in the month
        $total_days = $this->get_total_days($month, $year);

        // Set the starting day of the week
        $start_days = array('sunday' => 0, 'monday' => 1, 'tuesday' => 2, 'wednesday' => 3, 'thursday' => 4, 'friday' => 5, 'saturday' => 6);
        $start_day = (!isset($start_days[$this->start_day])) ? 0 : $start_days[$this->start_day];

        // Set the starting day number
        $local_date = mktime(12, 0, 0, $month, 1, $year);
        $date = getdate($local_date);
        $day = $start_day + 1 - $date["wday"];

        while ($day > 1)
        {
            $day -= 7;
        }

        // Set the current month/year/day
        // We use this to determine the "today" date
        $cur_year = date("Y", $this->local_time);
        $cur_month = date("m", $this->local_time);
        $cur_day = date("j", $this->local_time);

        $is_current_month = ($cur_year == $year AND $cur_month == $month) ? TRUE : FALSE;

        // Generate the template data array
        $this->parse_template();

        // Begin building the calendar output
        $out = $this->temp['table_open'];
        $out .= "\n";

        $out .= "\n";
        $out .= $this->temp['heading_row_start'];
        $out .= "\n";

        // "previous" month link
        if($this->show_next_prev == TRUE)
        {
            // Add a trailing slash to the  URL if needed
            $this->next_prev_url = preg_replace("/(.+?)\/*$/", "\\1/", $this->next_prev_url);

            $adjusted_date = $this->adjust_date($month - 1, $year);
            $out .= str_replace('{previous_url}', $this->next_prev_url . $adjusted_date['year'] . '/' . $adjusted_date['month'], $this->temp['heading_previous_cell']);
            $out .= "\n";
        }

        // Heading containing the month/year
        $colspan = ($this->show_next_prev == TRUE) ? 5 : 7;

        $this->temp['heading_title_cell'] = str_replace('{colspan}', $colspan, $this->temp['heading_title_cell']);
        $this->temp['heading_title_cell'] = str_replace('{heading}', $this->get_month_name($month) . "&nbsp;" . $year, $this->temp['heading_title_cell']);

        $out .= $this->temp['heading_title_cell'];
        $out .= "\n";

        // "next" month link
        if($this->show_next_prev == TRUE)
        {
            $adjusted_date = $this->adjust_date($month + 1, $year);
            $out .= str_replace('{next_url}', $this->next_prev_url . $adjusted_date['year'] . '/' . $adjusted_date['month'], $this->temp['heading_next_cell']);
        }

        $out .= "\n";
        $out .= $this->temp['heading_row_end'];
        $out .= "\n";

        // Write the cells containing the days of the week
        $out .= "\n";
        $out .= $this->temp['week_row_start'];
        $out .= "\n";

        $day_names = $this->get_day_names();

        for($i = 0; $i < 7; $i++)
        {
            $out .= str_replace('{week_day}', $day_names[($start_day + $i) % 7], $this->temp['week_day_cell']);
        }

        $out .= "\n";
        $out .= $this->temp['week_row_end'];
        $out .= "\n";

        // Build the main body of the calendar
        while ($day <= $total_days)
        {
            $out .= "\n";
            $out .= $this->temp['cal_row_start'];
            $out .= "\n";

            for($i = 0; $i < 7; $i++)
            {
                $out .= ($is_current_month == TRUE AND $day == $cur_day) ? $this->temp['cal_cell_start_today'] : $this->temp['cal_cell_start'];

                if($day > 0 AND $day <= $total_days)
                {
                    if(isset($data[$day]))
                    {
                        // Cells with content
                        $temp = ($is_current_month == TRUE AND $day == $cur_day) ? $this->temp['cal_cell_content_today'] : $this->temp['cal_cell_content'];
                        $out .= str_replace('{day}', $day, str_replace('{content}', $data[$day], $temp));
                    }
                    else
                    {
                        // Cells with no content
                        $temp = ($is_current_month == TRUE AND $day == $cur_day) ? $this->temp['cal_cell_no_content_today'] : $this->temp['cal_cell_no_content'];
                        $out .= str_replace('{day}', $day, $temp);
                    }
                }
                else
                {
                    // Blank cells
                    $out .= $this->temp['cal_cell_blank'];
                }

                $out .= ($is_current_month == TRUE AND $day == $cur_day) ? $this->temp['cal_cell_end_today'] : $this->temp['cal_cell_end'];
                $day++;
            }

            $out .= "\n";
            $out .= $this->temp['cal_row_end'];
            $out .= "\n";
        }

        $out .= "\n";
        $out .= $this->temp['table_close'];

        return $out;
    }
    
    /**
     * Render a calendar month for 
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
              if(in_array($date->dayOfWeek, $this->start_days)) $html_classes['changeover'] = 'changeover'; 
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
            $html .= ' data-dayofyear="'.$date->format('z').'">'.$date->format('j').'</td>';
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
    /*
      0 => 
        array (size=4)
          'nights' => int 5
          'first_night' => string '2014-02-05' (length=10)
          'last_night' => string '2014-02-09' (length=10)
          'status' => string '' (length=0)
      1 => 
        array (size=4)
          'nights' => int 7
          'first_night' => string '2014-02-15' (length=10)
          'last_night' => string '2014-02-21' (length=10)
          'status' => string '' (length=0)
      2 => 
        array (size=4)
          'nights' => int 3
          'first_night' => string '2014-03-12' (length=10)
          'last_night' => string '2014-03-14' (length=10)
          'status' => string '' (length=0)
    // */

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
