New Booking at {{ Config::get('cottaging.site-name') }}

Cottage: {{ $data->accom }} 
Arriving on {{ $data->arrive }}
Leaving on {{ $data->depart }}

View: 
{{ URL::action('Admin\BookingController@cottage', array($data->id)) }}


The {{ Config::get('cottaging.site-name') }} Team
--